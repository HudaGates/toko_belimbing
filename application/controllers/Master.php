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
		$query = $query->row();
		if ($query->user_group == 'Admin') {
			$this->nama = $query->nama;
			$this->username = $query->username;
			$this->user_level = $query->user_level;
			$this->user_group = $query->user_group;
			$this->shift = $query->shift;
			$this->qt = $this->db->get('tbl_title', 1)->row();
		} else {
			redirect('action/losttime');
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
			'table' => $table,
			'nav' => $nav,
			'url' => $url,
			'menuid' => $menuid,
			'get_o' => $get_o,
			'data_field' => $data_field,
		);
		$this->load->view('element/wrapper', $data);
		$this->load->view('admin/table/' . $table, $data);
	}
	public function ms()
	{
		$url = $this->input->post('url');
		$table = $this->input->post('table');
		$nav = $this->input->post('nav');
		$menuid = $this->input->post('menuid');
		$get_o = $this->db->get_where('tbl_menu_user', array('menuid' => $menuid, 'username' => $this->username), 1)->row();
		$data_field = $this->db->field_data($table);
		$data = array(
			'table' => $table,
			'nav' => $nav,
			'url' => $url,
			'menuid' => $menuid,
			'get_o' => $get_o,
			'data_field' => $data_field,
		);
		$this->load->view('element/wrapper', $data);
		$this->load->view('admin/table/master', $data);
	}
	public function bk()
	{
		$db2 = $this->load->database('backup', TRUE);
		$url = $this->input->post('url');
		$table = $this->input->post('table');
		$nav = $this->input->post('nav');
		$menuid = $this->input->post('menuid');
		$get_o = $this->db->get_where('tbl_menu_user', array('menuid' => $menuid, 'username' => $this->username), 1)->row();
		$data_field = $db2->field_data($table);
		$data = array(
			'table' => $table,
			'nav' => $nav,
			'url' => $url,
			'menuid' => $menuid,
			'get_o' => $get_o,
			'data_field' => $data_field,
		);
		$this->load->view('element/wrapper', $data);
		$this->load->view('admin/table/backup', $data);
	}
	public function qc()
	{
		$url = $this->input->post('url');
		$table = $this->input->post('table');
		$nav = $this->input->post('nav');
		$menuid = $this->input->post('menuid');
		$get_o = $this->db->get_where('tbl_menu_user', array('menuid' => $menuid, 'username' => $this->username), 1)->row();
		$data_field = $this->db->field_data($table);
		$data = array(
			'table' => $table,
			'nav' => $nav,
			'url' => $url,
			'menuid' => $menuid,
			'get_o' => $get_o,
			'data_field' => $data_field,
		);
		$this->load->view('element/wrapper', $data);
		$this->load->view('admin/table/masterqc', $data);
	}
	public function pl()
	{
		$url = $this->input->post('url');
		$table = $this->input->post('table');
		$nav = $this->input->post('nav');
		$menuid = $this->input->post('menuid');
		$get_o = $this->db->get_where('tbl_menu_user', array('menuid' => $menuid, 'username' => $this->username), 1)->row();
		$data_field = $this->db->field_data($table);
		$data = array(
			'table' => $table,
			'nav' => $nav,
			'url' => $url,
			'menuid' => $menuid,
			'get_o' => $get_o,
			'data_field' => $data_field,
			'qt' => $this->qt
		);
		$this->load->view('element/wrapper', $data);
		$this->load->view('admin/table/planning', $data);
	}
	public function ts()
	{
		$url = $this->input->post('url');
		$table = $this->input->post('table');
		$nav = $this->input->post('nav');
		$menuid = $this->input->post('menuid');
		$get_o = $this->db->get_where('tbl_menu_user', array('menuid' => $menuid, 'username' => $this->username), 1)->row();
		$data_field = $this->db->field_data($table);
		$data = array(
			'table' => $table,
			'nav' => $nav,
			'url' => $url,
			'menuid' => $menuid,
			'get_o' => $get_o,
			'data_field' => $data_field,
		);
		$this->load->view('element/wrapper', $data);
		$this->load->view('admin/table/transaction', $data);
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
	//    ======================== form =======================
	function formuploadstock()
	{
		$table = $this->input->post('table');
		$data = array(
			'table' => $table,
		);
		$this->load->view('admin/form/formuploadstock', $data);
	}

	function formdockingpart()
	{
		$table = $this->input->post('table');
		$data = array(
			'table' => $table,
		);
		$this->load->view('admin/form/formdockingpart', $data);
	}

	function formdockingmat()
	{
		$table = $this->input->post('table');
		$data = array(
			'table' => $table,
		);
		$this->load->view('admin/form/formdockingmat', $data);
	}

	function dockingpart()
	{
		$data = array('success' => false, 'messages' => array());
		$this->form_validation->set_rules('event', 'event', 'trim|required|callback_event_p');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run()){
			$event = trim($this->input->post('event'));
			$qs=$this->db->query("SELECT id,qty_box,part_no,sum(if(store='STORE 2',total_sto,0)) as str2,sum(if(store='STORE 3',total_sto,0)) as str3,sum(if(store='WIPS 3',total_sto,0)) as wips3,sum(if(store='OUTGOING',total_sto,0)) as og,sum(if(store='SUBCONT',total_sto,0)) as subc,sum(if(store='INCOMING',total_sto,0)) as inc,sum(if(store='HOLD',total_sto,0)) as hold,sum(if(store='OTHER',total_sto,0)) as other,sum(if(store='FINISH GOODS',total_sto,0)) as fg FROM tbl_h_stopart WHERE event='".$event."' and status='OK' group by part_no")->result();
			foreach ($qs as $key) {
				$qd = $this->db->get_where('tbl_master_docking', array('part_no' => $key->part_no))->result();
				$qt=$this->db->query("SELECT sum(stock) as sos_stock FROM tbl_stock_part WHERE part_no='".$key->part_no."' limit 1")->row();
				$total_sto=$key->str2+$key->str3+$key->wips3+$key->og+$key->subc+$key->inc+$key->hold+$key->other+$key->fg;
				$sos_stock=$qt->sos_stock;
				$diff=$total_sto-$sos_stock;
				if (empty($qt)) {
					$sos_stock=0;
				}
				
				if(empty($qd)){
					$qx=$this->db->query("SELECT * FROM docking_stopart WHERE part_no='".$key->part_no."' and event='".$event."' order by id desc limit 1")->row();
					if(empty($qx)){
						 $data1=array(
							'event'=>$event,
							'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
							'delivery_part_code'=>'',
							'child_part_code'=>'',
							'part_no'=>$key->part_no,
							'str2'=>$key->str2,
							'str3'=>$key->str3,
							'wips3'=>$key->wips3,
							'og'=>$key->og,
							'subc'=>$key->subc,
							'inc'=>$key->inc,
							'hold'=>$key->hold,
							'other'=>$key->other,
							'fg'=>$key->fg,
							'total_sto'=>$total_sto,
							'sos_stock'=>$sos_stock,
							'diff'=>$diff,
						);
						 $this->db->insert('docking_stopart',$data1);
					}else{
						$diff=($total_sto+$qx->total_sto)-$sos_stock;
						 $data1=array(
							'event'=>$event,
							'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
							'delivery_part_code'=>'',
							'child_part_code'=>'',
							'part_no'=>$key->part_no,
							'str2'=>$key->str2+$qx->str2,
							'str3'=>$key->str3+$qx->str3,
							'wips3'=>$key->wips3+$qx->wips3,
							'og'=>$key->og+$qx->og,
							'subc'=>$key->subc+$qx->subc,
							'inc'=>$key->inc+$qx->inc,
							'hold'=>$key->hold+$qx->hold,
							'other'=>$key->other+$qx->other,
							'fg'=>$key->fg+$qx->fg,
							'total_sto'=>$total_sto+$qx->total_sto,
							'sos_stock'=>$sos_stock,
							'diff'=>$diff,
						);
						 $this->db->update('docking_stopart',$data1,array('id'=>$qx->id));
					}
				}else{
					foreach ($qd as $val) {
						$qx=$this->db->query("SELECT * FROM docking_stopart WHERE part_no='".$val->part_no."' and child_part_code='".$val->child_part_code."' and event='".$event."' order by id desc limit 1")->row();
						if(empty($qx)){
							$data1=array(
								'event'=>$event,
								'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
								'delivery_part_code'=>$val->delivery_part_code,
								'child_part_code'=>$val->child_part_code,
								'part_no'=>$key->part_no,
								'str2'=>$key->str2*$val->indexs_blank,
								'str3'=>$key->str3*$val->indexs_blank,
								'wips3'=>$key->wips3*$val->indexs_blank,
								'og'=>$key->og*$val->indexs_blank,
								'subc'=>$key->subc*$val->indexs_blank,
								'inc'=>$key->inc*$val->indexs_blank,
								'hold'=>$key->hold*$val->indexs_blank,
								'other'=>$key->other*$val->indexs_blank,
								'fg'=>$key->fg*$val->indexs_blank,
								'total_sto'=>$total_sto*$val->indexs_blank,
								'sos_stock'=>$sos_stock*$val->indexs_blank,
								'diff'=>$diff*$val->indexs_blank,
							);
							 $this->db->insert('docking_stopart',$data1);
						}else{
							$diff=($total_sto+$qx->total_sto)-$sos_stock;
							$data1=array(
								'event'=>$event,
								'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
								'delivery_part_code'=>$val->delivery_part_code,
								'child_part_code'=>$val->child_part_code,
								'part_no'=>$key->part_no,
								'str2'=>($key->str2*$val->indexs_blank)+$qx->str2,
								'str3'=>($key->str3*$val->indexs_blank)+$qx->str3,
								'wips3'=>($key->wips3*$val->indexs_blank)+$qx->wips3,
								'og'=>($key->og*$val->indexs_blank)+$qx->og,
								'subc'=>($key->subc*$val->indexs_blank)+$qx->subc,
								'inc'=>($key->inc*$val->indexs_blank)+$qx->inc,
								'hold'=>($key->hold*$val->indexs_blank)+$qx->hold,
								'other'=>($key->other*$val->indexs_blank)+$qx->other,
								'fg'=>($key->fg*$val->indexs_blank)+$qx->fg,
								'total_sto'=>($total_sto*$val->indexs_blank)+$qx->total_sto,
								'sos_stock'=>$sos_stock*$val->indexs_blank,
								'diff'=>$diff*$val->indexs_blank,
							);
							$this->db->update('docking_stopart',$data1,array('id'=>$qx->id));
						}
					}
				}
			
				$data3=array(
					'status'=>'DOCKING'
				);
				$this->db->update('tbl_h_stopart',$data3,array('event'=>$event));

			}
			$data['success'] = true;
		} else {
			foreach ($_POST as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($data);
	}

	function event_p()
	{
		$event = trim($this->input->post('event'));
		$check = $this->db->get_where('tbl_h_stopart', array('event' => $event), 1)->row();
		$check1 = $this->db->get_where('tbl_h_stopart', array('event' => $event,'status'=>'OK'), 1)->row();
		$check2 = $this->db->get_where('tbl_h_stopart', array('event' => $event,'status'=>'DOCKING'), 1)->row();
		if (empty($check)) {
			$this->form_validation->set_message('event_p', 'Data Event tidak ditemukan!');
			return FALSE;
		} else if (empty($check1) AND !empty($check2)) {
			$this->form_validation->set_message('event_p', 'Data Event sudah di docking!');
			return FALSE;
		} else {
			return true;
		}
	}

	function dockingmat()
	{
		$data = array('success' => false, 'messages' => array());
		$this->form_validation->set_rules('event', 'event', 'trim|required|callback_event_m');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run()) {
			$event = trim($this->input->post('event'));
			$qs=$this->db->query("SELECT id,weight_coil,material_spec,thickwidth,sum(if(store='RM',total_sto,0)) as rm,sum(if(store='MACHINE',total_sto,0)) as machine,sum(if(store='OTHER',total_sto,0)) as other,sum(total_sto) as total_sto FROM tbl_h_stomat WHERE event='".$event."' and status='OK' group by material_spec,thickwidth")->result();
			foreach ($qs as $key) {
				$qt=$this->db->query("SELECT sum(stock_weight) as sos_stock FROM tbl_stock_mat WHERE material_spec='".$key->material_spec."' limit 1")->row();
				$qm=$this->db->query("SELECT sum(stock_weight) as sos_stock FROM tbl_stock_materialmc WHERE material_spec='".$key->material_spec."' limit 1")->row();
				$qb=$this->db->query("SELECT total_sto FROM docking_stomat WHERE material_spec='".$key->material_spec."' and event!='".$event."' order by id desc limit 1")->row();
				if(empty($qt)){
					$qtstok=0;
				}else{
					$qtstok=$qt->sos_stock;
				}
				if(empty($qm)){
					$qmstok=0;
				}else{
					$qmstok=$qm->sos_stock;
				}
				if(empty($qb)){
					$sto_before=0;
				}else{
					$sto_before=$qb->total_sto;
				}
				
				$sos_stock=$qmstok+$qtstok;
			    
			    $qx=$this->db->query("SELECT * FROM docking_stomat WHERE material_spec='".$key->material_spec."' and thickwidth='".$key->thickwidth."' and event='".$event."' order by id desc limit 1")->row();
			    if(empty($qx)){
			    	$data1=array(
						'event'=>$event,
						'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
						'material_spec'=>$key->material_spec,
						'thickwidth'=>$key->thickwidth,
						'rm'=>$key->rm,
						'machine'=>$key->machine,
						'other'=>$key->other,
						'total_sto'=>$key->total_sto,
						'sto_before'=>$sto_before,
						'sos_stock'=>$sos_stock,
					);
				 	$this->db->insert('docking_stomat',$data1);
				 }else{
				 	$data1=array(
						'event'=>$event,
						'docking_date'=>gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
						'material_spec'=>$key->material_spec,
						'thickwidth'=>$key->thickwidth,
						'rm'=>$key->rm+$qx->rm,
						'machine'=>$key->machine+$qx->machine,
						'other'=>$key->other+$qx->other,
						'total_sto'=>$key->total_sto+$qx->total_sto,
						'sto_before'=>$sto_before,
						'sos_stock'=>$sos_stock,
					);
					$this->db->update('docking_stomat',$data1,array('id'=>$qx->id));
				 }

			}
			$data3=array(
					'status'=>'DOCKING'
				);
			$this->db->update('tbl_h_stomat',$data3,array('event'=>$event));
			$data['success'] = true;
		} else {
			foreach ($_POST as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($data);
	}

	function event_m()
	{
		$event = trim($this->input->post('event'));
		$check = $this->db->get_where('tbl_h_stomat', array('event' => $event), 1)->row();
		$check1 = $this->db->get_where('tbl_h_stomat', array('event' => $event,'status'=>'OK'), 1)->row();
		$check2 = $this->db->get_where('tbl_h_stomat', array('event' => $event,'status'=>'DOCKING'), 1)->row();
		if (empty($check)) {
			$this->form_validation->set_message('event_m', 'Data Event tidak ditemukan!');
			return FALSE;
		} else if (empty($check1) AND !empty($check2)) {
			$this->form_validation->set_message('event_m', 'Data Event sudah di docking!');
			return FALSE;
		} else {
			return true;
		}
	}


	function searchsjsc()
	{
		$sj_no = $this->input->get('query');
		$val = $this->input->get('val');
		if ($val == '') {
			$query = $this->db->query("SELECT sj_no FROM tbl_delvtosubcont WHERE sj_no LIKE '%" . $sj_no . "%' group by sj_no ORDER BY id desc limit 10");
		} else {
			$query = $this->db->query("SELECT sj_no FROM tbl_delvtosubcont WHERE subcont_code='" . $val . "' and sj_no LIKE '%" . $sj_no . "%' group by sj_no ORDER BY id desc limit 10");
		}

		$result = $query->result_array();

		// Format bentuk data untuk autocomplete.
		foreach ($result as $data) {
			$output[] = [
				'value' => $data['sj_no'],
				'label'  => $data['sj_no']
			];
		}

		if (!empty($output) and $sj_no != '') {
			// Encode ke format JSON.
			echo json_encode($output);
		} else {
			$output[] = [
				'value' => 'No Data',
				'label'  => 'No Data'
			];
			echo json_encode($output);
		}
	}
	function viewrecsjsc()
	{
		$sj_no = $this->input->post('sj_no');
		$val = $this->input->post('val');
		// Query ke database.
		if ($val == '') {
			$data_table = $this->db->get_where('tbl_delvtosubcont', array('sj_no' => $sj_no))->result();
			$cek = $this->db->query("SELECT receipt_date FROM tbl_delvtosubcont WHERE sj_no='" . $sj_no . "' limit 1")->row();
		} else {
			$data_table = $this->db->get_where('tbl_delvtosubcont', array('sj_no' => $sj_no, 'subcont_code' => $val))->result();
			$cek = $this->db->query("SELECT receipt_date FROM tbl_delvtosubcont WHERE  subcont_code='" . $val . "' and sj_no='" . $sj_no . "' limit 1")->row();
		}

		$data = array(
			'data_table' => $data_table,
			'sj_no' => $sj_no,
			'val' => $val,
			'receipt_date' => $cek->receipt_date
		);
		$this->load->view('admin/form/viewrecsjsc', $data);
	}
	function submitrecsjsc()
	{
		$table = $this->input->post('table');
		$data = array('success' => false, 'messages' => array());
		$this->form_validation->set_rules('rec_qty[]', 'rec_qty', 'trim|required|is_natural');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run()) {
			$success = true;
			$id = $this->input->post('id');
			foreach ($id as $key => $val) {
				$cek = $this->db->get_where($table, array('id' => $_POST['id'][$key]), 1)->row();
				if ($cek->delv_qty != $_POST['rec_qty'][$key]) {
					$status = 'Problem';
					$qty_problem = abs($cek->delv_qty - $_POST['rec_qty'][$key]);
					$ba = array(
						'sj_no' => $cek->sj_no,
						'category' => 'YPI-SC',
						'subcont_code' => $cek->subcont_code,
						'part_no' => $cek->part_no,
						'part_name' => $cek->part_name,
						'delv_qty' => $cek->delv_qty,
						'qty_problem' => $qty_problem,
						'create_by' => $this->nama,
						'create_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
						'status' => 'Open'
					);
					$cekba = $this->db->get_where('tbL_h_beritaacara', array('sj_no' => $cek->sj_no, 'part_no' => $cek->part_no), 1)->row();
					if (empty($cekba)) {
						$this->db->insert('tbL_h_beritaacara', $ba);
					} else {
						$this->db->update('tbL_h_beritaacara', $ba, array('id' => $cekba->id));
					}
					$success = 'problem';
				} else {
					$status = 'COMPLETE';
					$qty_problem = 0;
				}
				$data1 = array(
					'rec_qty' => $_POST['rec_qty'][$key],
					'qty_problem' => $qty_problem,
					'receipt_pic' => $this->nama,
					'receipt_date' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
					'status' => $status
				);

				$this->db->update($table, $data1, array('id' => $cek->id));
			}
			$data['success'] = $success;
		} else {

			$data['messages']['rec_qty'] = form_error('rec_qty[]');
		}
		echo json_encode($data);
	}


	function formjudgeba()
	{
		$id = $this->input->post('id');
		$data = array(
			'id' => $id,
		);
		$this->load->view('admin/form/formjudgeba', $data);
	}
	
	function submitjudgeba()
	{
		$table = 'tbL_h_beritaacara';
		$data = array('success' => false, 'messages' => array());
		$this->form_validation->set_rules('judge', 'judge', 'trim|required');
		$this->form_validation->set_rules('remark', 'remark', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run()) {
			$id = $this->input->post('id');
			$judge = $this->input->post('judge');
			$remark = $this->input->post('remark');
			$cek=$this->db->get_where('tbL_h_beritaacara',array('id'=>$id),1)->row();
			$part_no = $cek->part_no;
			$sj_no = $cek->sj_no;
			$qt_problem= $cek->qty_problem;
			$cekd=$this->db->get_where('tbl_delvtoyoska',array('sj_no'=>$sj_no,'part_no'=>$part_no),1)->row();
			if($judge=='STOCK YPI'){
				//add stock to incoming minus stock subcont
				$ceks=$this->db->get_where('tbl_stock_part',array('store'=>'INC','part_no'=>$part_no),1)->row();
				if(empty($ceks)){
					$data2 = array(
				    	'store'=>'INC',
				    	'part_no'=>$part_no,
				    	'stock'=>$qty_problem,
						'last_update_in'=>gmdate('Y-m-d H:i:s',time()+60*60*7),
						'pic_update_in'=> $this->nama,
					 );
					$this->db->insert('tbl_stock_part',$data2);
				}else{
					$st=0;
					$st=$ceks->stock+$qty_problem;
					// if($st<=0){
					// 	$st=0;
					// }
					$data2 = array(
				    	'stock'=>$st,
						'last_update_in'=>gmdate('Y-m-d H:i:s',time()+60*60*7),
						'pic_update_in'=> $this->nama,
					 );
					$this->db->update('tbl_stock_part',$data2,array('id'=>$ceks->id));

				}
				$ceks=$this->db->get_where('tbl_stock_part',array('store'=>'SC','part_no'=>$part_no),1)->row();
				if(empty($ceks)){
					$data2 = array(
				    	'store'=>'SC',
				    	'part_no'=>$part_no,
				    	'stock'=>0,
						'last_update_out'=>gmdate('Y-m-d H:i:s',time()+60*60*7),
						'pic_update_out'=> $this->nama,
					 );
					$this->db->insert('tbl_stock_part',$data2);
				}else{
					$st=0;
					$st=$ceks->stock-$qty_problem;
					// if($st<=0){
					// 	$st=0;
					// }
					$data2 = array(
				    	'stock'=>$st,
						'last_update_out'=>gmdate('Y-m-d H:i:s',time()+60*60*7),
						'pic_update_out'=> $this->nama,
					 );
					$this->db->update('tbl_stock_part',$data2,array('id'=>$ceks->id));

				}
			}elseif($judge=='STOCK SUBCONT'){
				//Add stock subcont
			}else{
				//putihkan
			}
			$data3 = array(
				'status' => 'Complete',
				'qty_problem' =>0,
				'total_rec' =>$cekd->total_delv,
			);
			$this->db->update('tbl_delvtoyoska', $data3, array('id' => $cekd->id));
			$data1 = array(
				'status' => 'Close',
				'remark' => $judge.' '.$remark,
				'judge_by'=>$this->nama,
				'judge_time'=> gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
			);
			$this->db->update($table, $data1, array('id' => $id));
			$data['success'] = true;
		} else {

			foreach ($_POST as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
		}
		echo json_encode($data);
	}
	//create sj from subcont
	function formcreatesjsc()
	{
		$table = $this->input->post('table');
		$val = $this->input->post('val');
		$ex = explode('|', $val);
		$sc = $ex[0];
		$cek = $this->db->query("SELECT sj_no FROM tbl_delvtoyoska WHERE subcont_code='" . $sc . "' and sj_date is null order by id desc limit 1")->row();
		if (empty($cek)) {
			$sj = $this->db->query("SELECT count(distinct(sj_no)) as no_urut FROM tbl_delvtoyoska WHERE subcont_code='" . $sc . "' and sj_date like '%" . gmdate('Y-m', time() + 60 * 60 * 7) . "%'")->row();
			$no_urut = $sj->no_urut + 1;
			$sj_no=$no_urut."/".gmdate('m/Y',time()+60*60*7)."/".$sc."-YPI";
			$print = 'no';
		} else {
			$sj_no = $cek->sj_no;
			$print = 'yes';
		}

		$data_table = $this->db->get_where('tbl_delvtoyoska', array('sj_no' => $sj_no))->result();
		$data = array(
			'table' => $table,
			'sc' => $sc,
			'sj_no' => $sj_no,
			'print' => $print,
			'data_table' => $data_table
		);
		$this->load->view('admin/form/formcreatesjsc', $data);
	}
	function viewcreatesjsc()
	{
		$save = $this->input->post('save');
		$table = $this->input->post('table');
		$sj_no = $this->input->post('sj_no');
		$sc = $this->input->post('sc');
		$delv_date = $this->input->post('delv_date');
		$baris = abs($this->input->post('baris'));
		$data_table = $this->db->get_where('tbl_delvtoyoska', array('sj_no' => $sj_no))->result();
		if($save=='ok'){
			$baris=0;
		}
		$data = array(
			'table' => $table,
			'sj_no' => $sj_no,
			'baris' => $baris,
			'sc' => $sc,
			'delv_date' => $delv_date,
			'data_table' => $data_table
		);
		$this->load->view('admin/form/viewcreatesjsc', $data);
	}
	function searchpartsc()
	{
		$part_no = $this->input->get('query');
		$sc = $this->input->get('sc');
		if ($sc == '') {
			$query = $this->db->query("SELECT id_kbn,part_no,job_no FROM tbl_master_kanban WHERE part_no like '%" . $part_no . "%'  and subcont_code!=''  ORDER BY id desc limit 10");
		} else {
			$query = $this->db->query("SELECT id_kbn,part_no,job_no FROM tbl_master_kanban WHERE subcont_code='" . $sc . "' and part_no LIKE '%" . $part_no . "%'  ORDER BY id desc limit 10");
		}

		$result = $query->result_array();

		// Format bentuk data untuk autocomplete.
		foreach ($result as $data) {
			$output[] = [
				'value' => $data['part_no'],
				'label'  => $data['part_no']
			];
		}

		if (!empty($output) and $part_no != '') {
			// Encode ke format JSON.
			echo json_encode($output);
		} else {
			$output[] = [
				'value' => 'No Data',
				'label'  => 'No Data'
			];
			echo json_encode($output);
		}
	}
	function pilihpart()
	{
		$part_no = $this->input->post('part_no');
		$sc = $this->input->post('sc');
		$data = array('part_name' => 'No Data', 'qty_box' => '');
		if ($sc == '') {
			$cm = $this->db->query("SELECT * FROM tbl_master_kanban WHERE part_no='" . $part_no . "' and subcont_code!='' limit 1")->row();
		} else {
			$cm = $this->db->query("SELECT * FROM tbl_master_kanban WHERE subcont_code='" . $sc . "' and part_no='" . $part_no . "'  limit 1")->row();
		}
		if (!empty($cm)) {
			$data = array('part_name' => $cm->part_name, 'qty_box' => $cm->qty_box);
		}
		echo json_encode($data);
	}
	function submitcreatesjsc()
	{
		$table = $this->input->post('table');
		$data = array('success' => false, 'messages' => array());
		$this->form_validation->set_rules('part_no[]', 'part_no', 'trim|required|callback_cek_partno');
		$this->form_validation->set_rules('delv_qtybox[]', 'delv_qtybox', 'trim|required|is_natural');
		$this->form_validation->set_rules('delv_qtypcs[]', 'delv_qtypcs', 'trim|required|is_natural');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run()) {
			$sj_no = $this->input->post('sj_no');
			$sc = $this->input->post('sc');
			$id = $this->input->post('id');
			foreach ($id as $key => $val) {
				$cek = $this->db->get_where($table, array('sj_no' => $sj_no, 'part_no' => $_POST['part_no'][$key]), 1)->row();
				$cm = $this->db->query("SELECT * FROM tbl_master_kanban WHERE subcont_code='" . $sc . "' and part_no='" .$_POST['part_no'][$key]. "' limit 1")->row();
				if(!empty($cm)){
					$data1 = array(
						'subcont_code' => $sc,
						'id_kbn' => $cm->id_kbn,
						'part_no' => $cm->part_no,
						'part_name' => $cm->part_name,
						'qty_box' => $cm->qty_box,
						'create_by' => $this->nama,
						'create_date' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
						'sj_no' => $sj_no,
						'delv_qtybox' => $_POST['delv_qtybox'][$key],
						'delv_qtypcs' => $_POST['delv_qtypcs'][$key],
						'total_delv' => ($_POST['delv_qtybox'][$key]*$cm->qty_box)+$_POST['delv_qtypcs'][$key],
						'total_rec' => 0,
						'delv_date' => $this->input->post('delv_date'),
						'status' => 'CREATE'
					);

					if (empty($cek)) {
						$this->db->insert($table, $data1);
					} else {
						$this->db->update($table, $data1, array('id' => $cek->id));
					}
					$data1 = array(
						'delv_date' => $this->input->post('delv_date'),
					);
					$this->db->update($table, $data1, array('sj_no' => $sj_no));
				}
				
			}
			$success = true;
			$data['success'] = $success;
		} else {
		 	$data['messages']['part_no'] = form_error('part_no[]');
		 	$data['messages']['delv_qtybox'] = form_error('delv_qtybox[]');
		 	$data['messages']['delv_qtypcs'] = form_error('delv_qtypcs[]');
		}
		echo json_encode($data);
	}
	function cek_partno()
	{
		$sc = $this->input->post('sc');
		$id = $this->input->post('id');
		$status=TRUE;
		foreach ($id as $key => $val) {
			$cm = $this->db->query("SELECT * FROM tbl_master_kanban WHERE subcont_code='" . $sc . "' and part_no='" .$_POST['part_no'][$key]. "'  limit 1")->row();
			if(empty($cm)){
				
				$status=FALSE;
			}
		}
		if($status==FALSE){
			$this->form_validation->set_message('cek_partno', 'Data part_no tidak ditemukan!');
        	return FALSE;
		}else{
			return TRUE;
		}
	}
	function formfinishset(){
		$order_no=$this->input->post('order_no');
		$data=array(
		 'order_no'=>$order_no,
		 'data_order'=>$this->db->query("select part_no,part_name,qty_kbn,order_kbn as total_order,setting_kbn ,order_pcs,setting_pcs FROM view_setting where order_no='".$order_no."'")->result(),
		);	
		$this->load->view('admin/form/detail_setting',$data);
	}
	function finish_setting(){	
			$order_no=$this->input->post('order_no');
			$data1 = array( 
				"finish_time"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				"finish_by"=> $this->nama,
			);
			$this->db->update('tbl_order_customer',$data1,array('order_no'=>$order_no));
	}

	function form_upd_stge_lbl(){
		$table= $this->input->post('table');
		$this->db->query("DELETE FROM tbl_upload WHERE  tbl_name='".$table."'");
		$data=array(
		'table'=>$table,
		'id_t'=>$this->id_t,
		'total_before'=>$this->db->get($table)->num_rows(),
		);		
	$this->load->view('admin/form/form_upd_stge_lbl',$data);
	}

	function upload_upd_stge_lbl(){
		///Inisialisasi config
    	ini_set('memory_limit','1024M');
		set_time_limit(12000);
		$no=0;
    	$this->load->library('PHPExcel');
		$table = $this->input->post('table');
        $fileName = $table.time() . $_FILES['fileimport']['name'];                     
        $config['upload_path'] = './fileExcel/';                             
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->upload->initialize($config);
        $namafile=explode('.',$_FILES['fileimport']['name']); ///Explode nama file
        $namafile1=explode('_',$namafile[0]); ///pecah _ dan ambil array pertama
        $namafile2=$namafile1[0];
		// var_dump($namafile2);
		// die();
        if (!$this->upload->do_upload('fileimport') OR $namafile2!='storage-label'){ /// Jika tidak upload atau nama file bukan reguler
        	$this->db->query("DELETE FROM tbl_upload WHERE  tbl_name='".$table."'"); // delete tbl upload
        	$status = "error";
            $msg = strip_tags($this->upload->display_errors());
            if($msg==''){
            	$msg='Error file name, Plase change name file to storage-label_<anyword> !';
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg)); /// kembalikan JSON eror dan message
        }else{ /// Jika lolos
        $media = $this->upload->data();
        $inputFileName = $media['full_path']; /// Cari Path File Full

        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName); // Cari File type
            $objReader = PHPExcel_IOFactory::createReader($inputFileType); // Class baru untuk baca excell
            $objReader->setReadDataOnly(true);   /// Set ke hanya baca
            $objPHPExcel = $objReader->load($inputFileName);  /// Class load file excel
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);   /// Dapatkan lembar pertama [0]
        $highestRow = $sheet->getHighestRow(); /// dapatkan baris maksimal
        $highestColumn = $sheet->getHighestColumn(); /// dapatkan kolom maksimal 
		$baris = $objPHPExcel->setACTIVESheetIndex(0)->getHighestRow()-1;   // Set aktive sheet pertama
		$this->db->query("DELETE FROM tbl_upload WHERE  tbl_name='".$table."'"); 

        $datainsert=array(
					'tbl_name'=>$table,
					'total'=>$baris,
					'progress'=>0,
					'success'=>0,
				);
			$this->db->insert('tbl_upload',$datainsert);	/// Isi progres upload ke tabel upload	
       		
			$this->db->truncate('tbl_storage_label_temp'); /// Reset tabel 
			$i=1;
			
			for ($row = 2; $row <= $highestRow; $row++) { // Read a row of data into an array
	            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				
	            if($rowData[0][1]!=''){
	             	$cekpart=$this->db->query("SELECT * from tbl_master_partlist WHERE part_no_customer='".trim($rowData[0][1])."' limit 1")->row();
					if(trim($rowData[0][1])==''){
						$status_upload='empty part_no_customer';
					}elseif(trim($rowData[0][2])==''){
						$status_upload='empty storage label';
					}elseif(empty($cekpart)){
						$status_upload='part_no_customer not registered';
					}else{
						$status_upload='OK';
						$no=$no+1;
					}
					
					$data1 = array(
						"status_upload"=>$status_upload,
						"part_no_customer"=>trim($rowData[0][1]),
						"storage_label"=>trim($rowData[0][2]),
						"update_by"=>$this->nama,
						"update_time"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
					);
		           
		           // insert tbl_storage_label_temp
		            $this->db->insert('tbl_storage_label_temp', $data1); 			       			    				
					$this->db->query("UPDATE tbl_upload SET progress='".$i."',success='".$no."' WHERE  tbl_name='".$table."'"); 
	    			$i=$i+1;
					
	    		}
	        }		
			// die();
	        		 unlink($media['full_path']);
	    			// menghapus semua file .xls yang diupload
	        		$cekfinish=$this->db->query("SELECT id from tbl_storage_label_temp WHERE status_upload!='OK' limit 1")->result();
				//    die();
			       if(empty($cekfinish)){
						// $this->db->truncate('tbl_calculation_part'); /// Reset tabel 
				       	$this->db->query("UPDATE tbl_master_partlist JOIN tbl_storage_label_temp ON tbl_master_partlist.part_no_customer = tbl_storage_label_temp.part_no_customer SET tbl_master_partlist.storage_label = tbl_storage_label_temp.storage_label, tbl_master_partlist.update_by = tbl_storage_label_temp.update_by, tbl_master_partlist.update_time = tbl_storage_label_temp.update_time");					   
						echo json_encode(array('status'=>'success','msg'=>'ok'));
			       }else{
			       		$status = "gagal";
			            $msg = "Data Upload Tidak Sesuai";
			            echo json_encode(array('status'=>$status,'msg'=>$msg));
			       }
			
		}
		
    }
function uploadstock(){
		///Inisialisasi config
    	ini_set('memory_limit','1024M');
		set_time_limit(12000);
		$no=0;
    	$this->load->library('PHPExcel');
		$table = $this->input->post('table');
        $fileName = $table.time() . $_FILES['fileimport']['name'];                     
        $config['upload_path'] = './fileExcel/';                             
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv';
        $config['max_size'] = 10000;

        $this->upload->initialize($config);
        $namafile=explode('.',$_FILES['fileimport']['name']); ///Explode nama file
        $namafile1=explode('_',$namafile[0]); ///pecah _ dan ambil array pertama
        $namafile2=$namafile1[0];
		// var_dump($namafile2);
		// die();
        if (!$this->upload->do_upload('fileimport') OR $namafile2!='UpdateStock'){ /// Jika tidak upload atau nama file bukan reguler
        	$this->db->query("DELETE FROM tbl_upload WHERE  tbl_name='".$table."'"); // delete tbl upload
        	$status = "error";
            $msg = strip_tags($this->upload->display_errors());
            if($msg==''){
            	$msg="Plase change name file excel 'UpdateStock_' !!";
            }
            echo json_encode(array('status'=>$status,'msg'=>$msg)); /// kembalikan JSON eror dan message
        }else{ /// Jika lolos
        $media = $this->upload->data();
        $inputFileName = $media['full_path']; /// Cari Path File Full

        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName); // Cari File type
            $objReader = PHPExcel_IOFactory::createReader($inputFileType); // Class baru untuk baca excell
            $objReader->setReadDataOnly(true);   /// Set ke hanya baca
            $objPHPExcel = $objReader->load($inputFileName);  /// Class load file excel
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }

        $sheet = $objPHPExcel->getSheet(0);   /// Dapatkan lembar pertama [0]
        $highestRow = $sheet->getHighestRow(); /// dapatkan baris maksimal
        $highestColumn = $sheet->getHighestColumn(); /// dapatkan kolom maksimal 
		$baris = $objPHPExcel->setACTIVESheetIndex(0)->getHighestRow()-1;   // Set aktive sheet pertama
		$this->db->query("DELETE FROM tbl_upload WHERE  tbl_name='tbl_temp_stock'"); 

        $datainsert=array(
					'tbl_name'=>'tbl_temp_stock',
					'total'=>$baris,
					'progress'=>0,
					'success'=>0,
				);
			$this->db->insert('tbl_upload',$datainsert);	/// Isi progres upload ke tabel upload	
       		
			$this->db->truncate('tbl_temp_stock'); /// Reset tabel 
			$i=1;
			
			for ($row = 2; $row <= $highestRow; $row++) { // Read a row of data into an array
	            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);				
	             	$cekpart=$this->db->query("SELECT * from tbl_master_partlist WHERE part_no_fsi='".trim($rowData[0][1])."' limit 1")->row();
					if(trim($rowData[0][1])==''){
						$status_upload='empty part_no_fsi';
					}elseif(empty($cekpart)){
						$status_upload='part_no_fsi not registered in master';
					}elseif(is_numeric($rowData[0][2])==false){
						$status_upload='stock false';
					}else{
						$status_upload='OK';
						$no=$no+1;
					}
					
					$data1 = array(
						"status_upload"=>$status_upload,
						"part_no_fsi"=>trim($rowData[0][1]),
						"stock"=>trim($rowData[0][2]),
					);
		           
		           // insert tbl_storage_label_temp
		            $this->db->insert('tbl_temp_stock', $data1); 			       			    				
					$this->db->query("UPDATE tbl_upload SET progress='".$i."',success='".$no."' WHERE  tbl_name='tbl_temp_stock'"); 
	    			$i=$i+1;
					
	        }		
			// die();
	        		 unlink($media['full_path']);
	    			// menghapus semua file .xls yang diupload
	        		$cekfinish=$this->db->query("SELECT id from tbl_temp_stock WHERE status_upload!='OK' limit 1")->result();
				//    die();
			       if(empty($cekfinish)){
				       	$this->db->query("UPDATE tbl_stock_part A,tbl_temp_stock B set A.initial_stock=0,A.stock=B.stock,A.update_time=now(),A.update_by='".$this->nama."' WHERE A.part_no_fsi=B.part_no_fsi");					   
						echo json_encode(array('status'=>'success','msg'=>'ok'));
			       }else{
			       		$status = "gagal";
			            $msg = "Data Upload Tidak Sesuai";
			            echo json_encode(array('status'=>$status,'msg'=>$msg));
			       }
			
		}
		
    }
	function statusupload(){
		$table= $this->input->post('table');
		$query = $this->db->get_where('tbl_upload',array('tbl_name' => $table))->result();
		foreach ($query as $key) {
				$total=$key->total;
				$progress=$key->progress;
				$success=$key->success;
			}
		$failed=$progress-$success;		
		$persen=round($progress/$total,2) * 100;
		echo json_encode(array('persen'=>$persen,'total'=>$total,'success'=>$success,'failed'=>$failed));
	}
	function gagalupload(){
		$table = $this->input->post('table');
		$data_table=$this->db->get_where($table,array('status_upload !='=>'OK'))->result();
		$data=array(
			'data_table'=>$data_table,
			);		
	$this->load->view('admin/form/gagal_'.$table,$data);
	}
	
    function formorderpart(){
		$part_no_fsi = $this->input->post('part_no_fsi');
		$qs = $this->db->get_where('tbl_stock_part', array('part_no_fsi' => $part_no_fsi),1)->row();
		$data = array(
			'qs' => $qs,
		);
		$this->load->view('admin/form/formorderpart', $data);
	}
	function orderpart(){
		$table = 'tbL_h_beritaacara';
		$data = array('success' => false, 'messages' => array());
		$this->form_validation->set_rules('part_no_fsi', 'part_no_fsi', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run()) {
			$part_no_fsi = $this->input->post('part_no_fsi');
			$part_name = $this->input->post('part_name');
			$model = $this->input->post('model');
			$supplier_code = $this->input->post('supplier_code');
			$order_pcs = $this->input->post('order_part');
			$delv_date = $this->input->post('delv_date');
			$periode=gmdate('Ym',time()+60*60*7);
			$od='FSI'.gmdate('ym',time()+60*60*7);
			$qn=$this->db->query("SELECT * FROM tbl_order_supplier WHERE SUBSTRING(order_no,1,7)='".$od."' ORDER BY id desc limit 1")->row();
			if(!empty($qn)){
	        	$seq=substr($qn->order_no,-4);
	        	$seq=intval($seq)+1;
	        }else{
	        	$seq=1;
	        }
     		 if($seq<10){
			    $seqid='000'.$seq;
			  }elseif ($seq>=10 and $seq<100) {
			    $seqid='00'.$seq;
			  }elseif ($seq>=100 and $seq<1000) {
			    $seqid='0'.$seq;
			  }else{
			    $seqid=$seq;
			  }
			  $qm=$this->db->query("SELECT *,GROUP_CONCAT(DISTINCT(no_box)) as nb FROM tbl_master_partlist WHERE part_no_fsi='".$part_no_fsi."' limit 1")->row();
			  if($qm->qty_box==0 OR $qm->qty_box==''){
			  	$order_box=1;
			  }else{
			  	$order_box=ceil($order_pcs/$qm->qty_box);
			  }
                $data1 = array(
                	"periode"=>$periode,
					"calc_date"=>gmdate('Y-m-d',time()+60*60*7),
					"delv_date"=>$delv_date,
					"order_no"=>$od.$seqid,
					"part_no_fsi"=> $part_no_fsi,
					"part_name"=> $part_name,
					"model"=> $model,
					"supplier_code"=> $supplier_code,
					"qty_box"=> $qm->qty_box,
					"storage"=> $qm->storage,
					"no_box"=>$qm->nb,
					"order_box"=> $order_box,
					"order_pcs"=> $order_pcs,
					"rec_pcs"=> 0,
					"remain_pcs"=> $order_pcs,
					"status"=> 'Open',
					"update_by"=>$this->nama,
					"update_time"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				);
				$q=$this->db->insert('tbl_order_supplier', $data1); 
				if($q){
					$data['success'] = true;					
				}else{
					$data['success'] = 'Order Failed !!';
				}
			
		} else {

			foreach ($_POST as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
		}
		echo json_encode($data);
	}
}
