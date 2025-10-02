<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	public $id_t;
	function __construct(){
        parent::__construct();
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
	public function test_db()
	{
		$this->load->database();
		$query = $this->db->query("SELECT DATABASE() as db");
		$row = $query->row();

		if ($row) {
			echo "✅ Koneksi database berhasil: " . $row->db;
		} else {
			echo "❌ Gagal terkoneksi ke database!";
		}
	}
}
