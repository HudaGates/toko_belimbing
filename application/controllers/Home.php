<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    public $id_t;
    
    function __construct(){
        parent::__construct();
        // Set Timezone sesuai standar sistem ZettBOT
        date_default_timezone_set('Asia/Jakarta');
        $this->id_t=$this->input->get('api');
    } 
   
    public function index(){
        $cu=$this->s_model->s_access($this->id_t)->row(); 
        if(empty($cu)){ 
            redirect('action/losttime');                
        }   
        
        if($cu->user_group=='Admin'){
            $menu_parent=$this->db->query("select * from tbl_menu a inner join tbl_menu_user b on(a.menuid=b.menuid) where a.child='-' and b.username='".$cu->username."' and b.view_level='yes' order by a.orders asc")->result();
            $menu_child=$this->db->query("select * from tbl_menu a inner join tbl_menu_user b on(a.menuid=b.menuid) where a.child!='-' and b.username='".$cu->username."' and b.view_level='yes' order by a.orders asc")->result();
            $qt= $this->db->query('select a.*,b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();  
            $q= $this->db->get_where('files',array('id'=>$qt->bg),1)->row();    
            $data=array(
                'menu_child'=>$menu_child,
                'menu_parent'=>$menu_parent,
                'title'=>$qt->title,
                'detail'=>$qt->detail,
                'owner'=>$qt->owner,
                'version'=>$qt->version,
                'logo'=>$qt->web_path,
                'year'=>$qt->year,
                'thema'=>$qt->thema,
                'bg'=>$q->web_path,
                'cu'=>$cu
            );
            $this->load->view('element/header',$data);
            $this->load->view('element/home');
            $this->load->view('element/footer');
        }else{
            $lv=$this->db->get_where('tbl_level',array('user_level'=>$cu->user_level),1)->row();
            if($lv->user_device=='Mobilescan'){
                $menu_parent=$this->db->query("select * from tbl_menu a inner join tbl_menu_user b on(a.menuid=b.menuid) where a.child='-' and b.username='".$cu->username."' and b.view_level='yes' order by a.orders asc")->result();
                $menu_child=$this->db->query("select * from tbl_menu a inner join tbl_menu_user b on(a.menuid=b.menuid) where a.child!='-' and b.username='".$cu->username."' and b.view_level='yes' order by a.orders asc")->result();
                $qt= $this->db->query('select a.*,b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();  
                $q= $this->db->get_where('files',array('id'=>$qt->bg),1)->row();    
                $data=array(
                    'menu_child'=>$menu_child,
                    'menu_parent'=>$menu_parent,
                    'title'=>$qt->title,
                    'detail'=>$qt->detail,
                    'owner'=>$qt->owner,
                    'version'=>$qt->version,
                    'logo'=>$qt->web_path,
                    'year'=>$qt->year,
                    'thema'=>$qt->thema,
                    'bg'=>$q->web_path,
                    'cu'=>$cu
                );
                $this->load->view('element/header',$data);
                $this->load->view('element/home');
                $this->load->view('element/footer');
            }elseif($lv->user_device=='Tablet'){
                redirect(strtolower(str_replace(' ','',$cu->user_level).'?api='.$this->id_t),'refresh');
            }else{
                redirect(strtolower($cu->user_level.'?api='.$this->id_t),'refresh');
            }
        }   
    }

    // 🔹 Fungsi tambahan untuk test koneksi DB
    public function test_db() {
        $this->load->database();
        $query = $this->db->query("SELECT DATABASE() as db");
        $row = $query->row();

        if ($row) {
            echo "✅ Koneksi database berhasil: " . $row->db;
        } else {
            echo "❌ Gagal terkoneksi ke database!";
        }
    }
    
    // ==========================================
    // MESIN PENARIK DATA DASHBOARD LAPORAN
    // ==========================================
    public function get_dashboard_data() {
        $periode = $this->input->post('periode');
        $start_date = $this->input->post('start_date'); 
        $end_date = $this->input->post('end_date');     
        $keyword = $this->input->post('keyword'); 
        
        $today = date('Y-m-d');
        $this_month = date('m');
        $this_year = date('Y');

        // 1. MENGHITUNG 4 KOTAK SUMMARY
        $q_hari = $this->db->query("SELECT SUM(total_amount) as total FROM tbl_history_sale WHERE status='done' AND DATE(update_time) = '$today'")->row();
        $q_minggu = $this->db->query("SELECT SUM(total_amount) as total FROM tbl_history_sale WHERE status='done' AND YEARWEEK(update_time, 1) = YEARWEEK(CURDATE(), 1)")->row();
        $q_bulan = $this->db->query("SELECT SUM(total_amount) as total FROM tbl_history_sale WHERE status='done' AND MONTH(update_time) = '$this_month' AND YEAR(update_time) = '$this_year'")->row();
        $q_tahun = $this->db->query("SELECT SUM(total_amount) as total FROM tbl_history_sale WHERE status='done' AND YEAR(update_time) = '$this_year'")->row();

        // 2. MENGAMBIL DATA UNTUK TABEL
        $this->db->select('*');
        $this->db->from('tbl_history_sale');
        $this->db->where('status', 'done');
        
        // Menerapkan Pencarian: Berdasarkan Nama Kasir atau Nama Customer
        if (!empty($keyword)) {
            $this->db->group_start();
            $this->db->like('customer_name', $keyword);
            $this->db->or_like('cashier', $keyword);
            $this->db->group_end();
        }
        
        // Menerapkan Filter Tanggal
        if ($periode == 'hari_ini') {
            $this->db->where('DATE(update_time)', $today);
        } elseif ($periode == 'minggu_ini') {
            $this->db->where('YEARWEEK(update_time, 1) = YEARWEEK(CURDATE(), 1)', NULL, FALSE);
        } elseif ($periode == 'bulan_ini') {
            $this->db->where('MONTH(update_time)', $this_month);
            $this->db->where('YEAR(update_time)', $this_year);
        } elseif ($periode == 'tahun_ini') {
            $this->db->where('YEAR(update_time)', $this_year);
        } elseif ($periode == 'custom') {
            if(!empty($start_date) && !empty($end_date)) {
                $this->db->where('DATE(update_time) >=', $start_date);
                $this->db->where('DATE(update_time) <=', $end_date);
            }
        }
        
        // Urutkan dari transaksi terbaru
        $this->db->order_by('update_time', 'DESC');
        $data_tabel = $this->db->get()->result();

        // 3. MERAKIT HTML TABEL (Sesuai 5 Kolom Request)
        $html_tabel = '';
        if(empty($data_tabel)) {
            $html_tabel = '<tr><td colspan="5" class="text-center text-muted py-4"><i class="fas fa-inbox fa-2x mb-2"></i><br>Tidak ada transaksi ditemukan.</td></tr>';
        } else {
            $no = 1;
            foreach($data_tabel as $row) {
                // Formatting nama customer jika kosong / 0
                $nama_customer = ($row->customer_name == '' || $row->customer_name == '0') ? 'Umum' : $row->customer_name;
                
                $html_tabel .= '<tr>';
                $html_tabel .= '<td class="text-center">'.$no++.'</td>';
                $html_tabel .= '<td>'.date('d M Y H:i', strtotime($row->update_time)).'</td>';
                $html_tabel .= '<td>'.$row->cashier.'</td>';
                // Menampilkan Nama Customer dengan styling ringan agar mudah dibaca
                $html_tabel .= '<td><span class="badge badge-light border" style="font-size:13px;">'.$nama_customer.'</span></td>';
                $html_tabel .= '<td class="text-right font-weight-bold text-success">Rp '.number_format($row->total_amount, 0, ',', '.').'</td>';
                $html_tabel .= '</tr>';
            }
        }

        // 4. KEMBALIKAN DATA KE JAVASCRIPT (JSON)
        echo json_encode(array(
            'harian'   => 'Rp ' . number_format((float)$q_hari->total, 0, ',', '.'),
            'mingguan' => 'Rp ' . number_format((float)$q_minggu->total, 0, ',', '.'),
            'bulanan'  => 'Rp ' . number_format((float)$q_bulan->total, 0, ',', '.'),
            'tahunan'  => 'Rp ' . number_format((float)$q_tahun->total, 0, ',', '.'),
            'html_tabel' => $html_tabel
        ));
    }
}