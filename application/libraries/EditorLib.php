<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditorLib {
    
    private $CI = null;
    
    function __construct()
    {
        $this->CI = &get_instance();
    }   

	
	public function sProcess($post,$table,$api,$menuid)
	{	
	    // DataTables PHP library
		require dirname(__FILE__).'/DataTables/lib/DataTables.php';
		
		//Load the model which will give us our data
		$this->CI->load->model('SystemModel');
		
		//Pass the database object to the model
		$this->CI->SystemModel->init($db);
		
		//Let the model produce the data

		$this->CI->SystemModel->getData($post,$table,$api,$menuid);
	}
	public function mProcess($post,$table,$api,$menuid)
	{	
	    // DataTables PHP library
		require dirname(__FILE__).'/DataTables/lib/DataTables.php';
		
		//Load the model which will give us our data
		$this->CI->load->model('MasterModel');
		
		//Pass the database object to the model
		$this->CI->MasterModel->init($db);
		
		//Let the model produce the data

		$this->CI->MasterModel->getData($post,$table,$api,$menuid);
	}
	public function bProcess($post,$table,$api,$menuid)
	{	
	    // DataTables PHP library
		require dirname(__FILE__).'/DataTables1/lib/DataTables.php';
		
		//Load the model which will give us our data
		$this->CI->load->model('TransactionModel');
		
		//Pass the database object to the model
		$this->CI->TransactionModel->init($db);
		
		//Let the model produce the data

		$this->CI->TransactionModel->getData($post,$table,$api,$menuid);
	}
	public function mqcProcess($post,$table,$api,$menuid)
	{	
	    // DataTables PHP library
		require dirname(__FILE__).'/DataTables/lib/DataTables.php';
		
		//Load the model which will give us our data
		$this->CI->load->model('MasterqcModel');
		
		//Pass the database object to the model
		$this->CI->MasterqcModel->init($db);
		
		//Let the model produce the data

		$this->CI->MasterqcModel->getData($post,$table,$api,$menuid);
	}
	public function planProcess($post,$table,$api,$menuid)
	{	
	    // DataTables PHP library
		require dirname(__FILE__).'/DataTables/lib/DataTables.php';
		
		//Load the model which will give us our data
		$this->CI->load->model('PlanModel');
		
		//Pass the database object to the model
		$this->CI->PlanModel->init($db);
		
		//Let the model produce the data

		$this->CI->PlanModel->getData($post,$table,$api,$menuid);
	}
	public function tProcess($post,$table,$api,$menuid)
	{	
	    // DataTables PHP library
		require dirname(__FILE__).'/DataTables/lib/DataTables.php';
		
		//Load the model which will give us our data
		$this->CI->load->model('TransactionModel');
		
		//Pass the database object to the model
		$this->CI->TransactionModel->init($db);
		
		//Let the model produce the data

		$this->CI->TransactionModel->getData($post,$table,$api,$menuid);
	}
	public function pProcess($post,$api)
	{	
	    // DataTables PHP library
		require dirname(__FILE__).'/DataTables/lib/DataTables.php';
		
		//Load the model which will give us our data
		$this->CI->load->model('ProfileModel');
		
		//Pass the database object to the model
		$this->CI->ProfileModel->init($db);
		
		//Let the model produce the data

		$this->CI->ProfileModel->getData($post,$api);
	}
	public function andon($post,$table)
	{	
	    // DataTables PHP library
		require dirname(__FILE__).'/DataTables/lib/DataTables.php';
		
		//Load the model which will give us our data
		$this->CI->load->model('AndonModel');
		
		//Pass the database object to the model
		$this->CI->AndonModel->init($db);
		
		//Let the model produce the data

		$this->CI->AndonModel->getData($post,$table);
	}

}

