<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!');
class Ajax extends CI_Controller {
	function __construct(){
		parent::__construct();
		$api=$this->input->get('api');
		$query=$this->s_model->s_access($api); 
		$query=$query->row();
		if(empty($api) OR empty($query)) redirect('http://google.com');
		
	}
	public function sData()
	{	
	 	//Load our library EditorLib 
	 	$api=$this->input->get('api');
	    $table=$this->input->get('table');
	    $menuid=$this->input->get('menuid');
		$this->load->library('EditorLib');
		
		//`Call the process method to process the posted data
		$this->editorlib->sProcess($_POST,$table,$api,$menuid);
		
	    
	}
	public function mData()
	{	
			//Load our library EditorLib 
			$api=$this->input->get('api');
		    $table=$this->input->get('table');
		    $menuid=$this->input->get('menuid');
			$this->load->library('EditorLib');
			
			//`Call the process method to process the posted data
			$this->editorlib->mProcess($_POST,$table,$api,$menuid);
	    
	}
	public function bData()
	{	
			//Load our library EditorLib 
			$api=$this->input->get('api');
		    $table=$this->input->get('table');
		    $menuid=$this->input->get('menuid');
			$this->load->library('EditorLib');
			
			//`Call the process method to process the posted data
			$this->editorlib->bProcess($_POST,$table,$api,$menuid);
	    
	}
	public function mqcData()
	{	
			//Load our library EditorLib 
			$api=$this->input->get('api');
		    $table=$this->input->get('table');
		    $menuid=$this->input->get('menuid');
			$this->load->library('EditorLib');
			
			//`Call the process method to process the posted data
			$this->editorlib->mqcProcess($_POST,$table,$api,$menuid);
		
	}
	public function plData()
	{	
			//Load our library EditorLib 
			$api=$this->input->get('api');
		    $table=$this->input->get('table');
		    $menuid=$this->input->get('menuid');
			$this->load->library('EditorLib');
			
			//`Call the process method to process the posted data
			$this->editorlib->planProcess($_POST,$table,$api,$menuid);
		
	    
	}
	public function tData()
	{	
			//Load our library EditorLib 
			$api=$this->input->get('api');
		    $table=$this->input->get('table');
		    $menuid=$this->input->get('menuid');
			$this->load->library('EditorLib');
			
			//`Call the process method to process the posted data
			$this->editorlib->tProcess($_POST,$table,$api,$menuid);
	    
	}
	public function pData()
	{	
			//Load our library EditorLib 
			$api=$this->input->get('api');
			$this->load->library('EditorLib');
			
			//`Call the process method to process the posted data
			$this->editorlib->pProcess($_POST,$api);
		
	    
	}
}