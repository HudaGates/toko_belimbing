<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master extends CI_Controller
{
    public $user_level;
    public $user_group;
    public $username;
    public $nama;
    public $shift;
    public $id_t;
    public $qt;
    
    function __construct()
    {
        parent::__construct();
        $this->id_t = $this->input->get('api');
        $query = $this->s_model->s_access($this->id_t);
        
        if ($query && $query->num_rows() > 0) {
            $query = $query->row();
            if ($query->user_group == 'Admin') {
                $this->nama = $query->nama;
                $this->username = $query->username;
                $this->user_level = $query->user_level;
                $this->user_group = $query->user_group;
                $this->shift = $query->shift;
                $this->qt = $this->db->get('tbl_title', 1)->row();
            } else {
                $this->_redirect_ajax('action/losttime');
            }
        } else {
            $this->_redirect_ajax('action/losttime');
        }
    }

    // Helper untuk cegah HTML ter-render jika hit dari AJAX
    private function _redirect_ajax($url) {
        if ($this->input->is_ajax_request()) {
            return $this->output->set_content_type('application/json')->set_output(json_encode(['error' => 'Session expired', 'redirect' => base_url($url)]));
        } else {
            redirect($url);
        }
    }

    public function index()
    {
        $url = $this->input->post('url');
        $table = $this->input->post('table');
        $nav = $this->input->post('nav');
        $menuid = $this->input->post('menuid');
        $get_o = $this->db->get_where('tbl_menu_user', array('menuid' => $menuid, 'username' => $this->username), 1)->row();
        $data_field = $this->db->field_data($table);
        
        $data = array(
            'table' => $table, 'nav' => $nav, 'url' => $url, 'menuid' => $menuid,
            'get_o' => $get_o, 'data_field' => $data_field,
        );
        $this->load->view('element/wrapper', $data);
        $this->load->view('admin/table/' . $table, $data);
    }

    public function ms() { $this->_load_table_view('admin/table/master'); }
    public function bk() {
        $db2 = $this->load->database('backup', TRUE);
        $this->_load_table_view('admin/table/backup', $db2);
    }
    public function qc() { $this->_load_table_view('admin/table/masterqc'); }
    public function pl() { $this->_load_table_view('admin/table/planning', null, true); }
    public function ts() { $this->_load_table_view('admin/table/transaction'); }

    private function _load_table_view($view_path, $db_instance = null, $include_qt = false) {
        $db = $db_instance ?? $this->db;
        $table = $this->input->post('table');
        $menuid = $this->input->post('menuid');
        
        $data = array(
            'table' => $table,
            'nav' => $this->input->post('nav'),
            'url' => $this->input->post('url'),
            'menuid' => $menuid,
            'get_o' => $this->db->get_where('tbl_menu_user', array('menuid' => $menuid, 'username' => $this->username), 1)->row(),
            'data_field' => $db->field_data($table),
        );
        if ($include_qt) $data['qt'] = $this->qt;

        $this->load->view('element/wrapper', $data);
        $this->load->view($view_path, $data);
    }

    function del_all()
    {
        $table = $this->input->post('table');
        $bk = $this->input->post('bk');
        if ($bk == 'bk') {
            $db2 = $this->load->database('backup', TRUE);
            $db2->truncate($table);
        } else {
            if ($table != 'tbl_user') {
                $this->db->truncate($table);
            }
        }
    }

    function removesc()
    {
        $table = $this->input->post('table');
        $id = $this->input->post('id');
        $this->db->delete($table, array('id' => $id));
    }

    // ======================== FORM RENDERERS =======================
    function formuploadstock() { $this->load->view('admin/form/formuploadstock', ['table' => $this->input->post('table')]); }
    function formdockingpart() { $this->load->view('admin/form/formdockingpart', ['table' => $this->input->post('table')]); }
    function formdockingmat() { $this->load->view('admin/form/formdockingmat', ['table' => $this->input->post('table')]); }
    function formjudgeba() { $this->load->view('admin/form/formjudgeba', ['id' => $this->input->post('id')]); }

    // ======================== API ENDPOINTS (Force JSON) =======================
    function dockingpart()
    {
        $data = array('success' => false, 'messages' => array());
        $this->form_validation->set_rules('event', 'event', 'trim|required|callback_event_p');
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        
        if ($this->form_validation->run()){
            $event = trim($this->input->post('event'));
            $qs=$this->db->query("SELECT id,qty_box,part_no,sum(if(store='STORE 2',total_sto,0)) as str2,sum(if(store='STORE 3',total_sto,0)) as str3,sum(if(store='WIPS 3',total_sto,0)) as wips3,sum(if(store='OUTGOING',total_sto,0)) as og,sum(if(store='SUBCONT',total_sto,0)) as subc,sum(if(store='INCOMING',total_sto,0)) as inc,sum(if(store='HOLD',total_sto,0)) as hold,sum(if(store='OTHER',total_sto,0)) as other,sum(if(store='FINISH GOODS',total_sto,0)) as fg FROM tbl_h_stopart WHERE event='".$event."' and status='OK' group by part_no")->result();
            foreach ($qs as $key) {
                // (Logika perhitungan disingkat agar code readable, tetap menggunakan logic asli Anda)
                $qd = $this->db->get_where('tbl_master_docking', array('part_no' => $key->part_no))->result();
                $qt=$this->db->query("SELECT sum(stock) as sos_stock FROM tbl_stock_part WHERE part_no='".$key->part_no."' limit 1")->row();
                $total_sto=$key->str2+$key->str3+$key->wips3+$key->og+$key->subc+$key->inc+$key->hold+$key->other+$key->fg;
                $sos_stock= !empty($qt) ? $qt->sos_stock : 0;
                $diff=$total_sto-$sos_stock;
                
                if(empty($qd)){
                    $qx=$this->db->query("SELECT * FROM docking_stopart WHERE part_no='".$key->part_no."' and event='".$event."' order by id desc limit 1")->row();
                    if(empty($qx)){
                         $data1=array('event'=>$event, 'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7), 'delivery_part_code'=>'', 'child_part_code'=>'', 'part_no'=>$key->part_no, 'str2'=>$key->str2, 'str3'=>$key->str3, 'wips3'=>$key->wips3, 'og'=>$key->og, 'subc'=>$key->subc, 'inc'=>$key->inc, 'hold'=>$key->hold, 'other'=>$key->other, 'fg'=>$key->fg, 'total_sto'=>$total_sto, 'sos_stock'=>$sos_stock, 'diff'=>$diff);
                         $this->db->insert('docking_stopart',$data1);
                    }else{
                        $diff=($total_sto+$qx->total_sto)-$sos_stock;
                        $data1=array('event'=>$event, 'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7), 'delivery_part_code'=>'', 'child_part_code'=>'', 'part_no'=>$key->part_no, 'str2'=>$key->str2+$qx->str2, 'str3'=>$key->str3+$qx->str3, 'wips3'=>$key->wips3+$qx->wips3, 'og'=>$key->og+$qx->og, 'subc'=>$key->subc+$qx->subc, 'inc'=>$key->inc+$qx->inc, 'hold'=>$key->hold+$qx->hold, 'other'=>$key->other+$qx->other, 'fg'=>$key->fg+$qx->fg, 'total_sto'=>$total_sto+$qx->total_sto, 'sos_stock'=>$sos_stock, 'diff'=>$diff);
                         $this->db->update('docking_stopart',$data1,array('id'=>$qx->id));
                    }
                } else {
                    foreach ($qd as $val) {
                        $qx=$this->db->query("SELECT * FROM docking_stopart WHERE part_no='".$val->part_no."' and child_part_code='".$val->child_part_code."' and event='".$event."' order by id desc limit 1")->row();
                        if(empty($qx)){
                            $data1=array('event'=>$event, 'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7), 'delivery_part_code'=>$val->delivery_part_code, 'child_part_code'=>$val->child_part_code, 'part_no'=>$key->part_no, 'str2'=>$key->str2*$val->indexs_blank, 'str3'=>$key->str3*$val->indexs_blank, 'wips3'=>$key->wips3*$val->indexs_blank, 'og'=>$key->og*$val->indexs_blank, 'subc'=>$key->subc*$val->indexs_blank, 'inc'=>$key->inc*$val->indexs_blank, 'hold'=>$key->hold*$val->indexs_blank, 'other'=>$key->other*$val->indexs_blank, 'fg'=>$key->fg*$val->indexs_blank, 'total_sto'=>$total_sto*$val->indexs_blank, 'sos_stock'=>$sos_stock*$val->indexs_blank, 'diff'=>$diff*$val->indexs_blank);
                             $this->db->insert('docking_stopart',$data1);
                        }else{
                            $diff=($total_sto+$qx->total_sto)-$sos_stock;
                            $data1=array('event'=>$event, 'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7), 'delivery_part_code'=>$val->delivery_part_code, 'child_part_code'=>$val->child_part_code, 'part_no'=>$key->part_no, 'str2'=>($key->str2*$val->indexs_blank)+$qx->str2, 'str3'=>($key->str3*$val->indexs_blank)+$qx->str3, 'wips3'=>($key->wips3*$val->indexs_blank)+$qx->wips3, 'og'=>($key->og*$val->indexs_blank)+$qx->og, 'subc'=>($key->subc*$val->indexs_blank)+$qx->subc, 'inc'=>($key->inc*$val->indexs_blank)+$qx->inc, 'hold'=>($key->hold*$val->indexs_blank)+$qx->hold, 'other'=>($key->other*$val->indexs_blank)+$qx->other, 'fg'=>($key->fg*$val->indexs_blank)+$qx->fg, 'total_sto'=>($total_sto*$val->indexs_blank)+$qx->total_sto, 'sos_stock'=>$sos_stock*$val->indexs_blank, 'diff'=>$diff*$val->indexs_blank);
                            $this->db->update('docking_stopart',$data1,array('id'=>$qx->id));
                        }
                    }
                }
                $this->db->update('tbl_h_stopart', array('status'=>'DOCKING'), array('event'=>$event));
            }
            $data['success'] = true;
        } else {
            foreach ($_POST as $key => $value) { $data['messages'][$key] = form_error($key); }
        }
        
        // Memaksa output JSON murni
        return $this->output->set_content_type('application/json')->set_output(json_encode($data));
    }

    function searchsjsc()
    {
        $sj_no = $this->input->get('query');
        $val = $this->input->get('val');
        
        $this->db->select('sj_no')->from('tbl_delvtosubcont');
        if ($val != '') $this->db->where('subcont_code', $val);
        $this->db->like('sj_no', $sj_no)->group_by('sj_no')->order_by('id', 'desc')->limit(10);
        $result = $this->db->get()->result_array();

        $output = [];
        foreach ($result as $data) {
            $output[] = ['value' => $data['sj_no'], 'label' => $data['sj_no']];
        }

        if (empty($output)) $output[] = ['value' => 'No Data', 'label' => 'No Data'];
        
        return $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    function statusupload()
    {
        $table= $this->input->post('table');
        $query = $this->db->get_where('tbl_upload',array('tbl_name' => $table))->row();
        
        $total = $query->total ?? 0;
        $progress = $query->progress ?? 0;
        $success = $query->success ?? 0;
        $failed = $progress - $success;     
        $persen = ($total > 0) ? round($progress/$total, 2) * 100 : 0;
        
        return $this->output->set_content_type('application/json')->set_output(json_encode([
            'persen' => $persen, 'total' => $total, 'success' => $success, 'failed' => $failed
        ]));
    }

    // Callbacks Form Validation
    function event_p()
    {
        $event = trim($this->input->post('event'));
        $check = $this->db->get_where('tbl_h_stopart', array('event' => $event), 1)->row();
        $check2 = $this->db->get_where('tbl_h_stopart', array('event' => $event,'status'=>'DOCKING'), 1)->row();
        
        if (empty($check)) {
            $this->form_validation->set_message('event_p', 'Data Event tidak ditemukan!');
            return FALSE;
        } else if (!empty($check2)) {
            $this->form_validation->set_message('event_p', 'Data Event sudah di docking!');
            return FALSE;
        }
        return TRUE;
    }
}