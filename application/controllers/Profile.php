<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public $user_level;
	public $user_group;
	public $user_area;
	public $nama;
	public $shift;
	public $id_t;
	function __construct(){
        parent::__construct();
        $this->id_t=$this->input->get('api');
        $query=$this->s_model->s_access($this->id_t); 
		$query=$query->row();                     
        if(!empty($query)){        		
			$this->nama=$query->nama;
			$this->user_area=$query->user_area;
			$this->user_level=$query->user_level;
			$this->user_group=$query->user_group;
		}else{
			redirect('action/losttime');
		}
    } 
   
	public function index()
	{	
		$table=$this->input->post('table');
		$data_field=$this->db->field_data($table);
		$data=array(
			'table'=>$table,
			'nav'=>'Profile',
			'url'=>'Profile',
			'menuid'=>'',
			'nama'=>$this->nama,
			'id_t'=>$this->id_t,
			'user_level'=>$this->user_level,
			'data_field'=>$data_field,
		);
		$this->load->view('element/wrapper',$data);
		$this->load->view('admin/table/profile',$data);
	}
	
	 function value_level(){
	    	$menuid = $this->input->post('menuid');
	    	$user_level = $this->input->post('user_level');
	    	$value = $this->input->post('value');
	    	$this->db->query("UPDATE tbl_menu_user SET value_level='".$value."' WHERE menuid='".$menuid."' and user_level='".$user_level."'");  	
			$data['status']=true;
			echo json_encode($data);
	    } 
	function field_level(){
	    	$menuid = $this->input->post('menuid');
	    	$user_level = $this->input->post('user_level');
	    	$value = $this->input->post('value');
	    	$this->db->query("UPDATE tbl_menu_user SET field_level='".$value."' WHERE menuid='".$menuid."' and user_level='".$user_level."'");  	
			$data['status']=true;
			echo json_encode($data);
	    }  
}
