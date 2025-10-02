<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once('assets/lte/mpdf60/qrcode/qrcode.class.php');
class Test extends CI_Controller {
	function __construct(){
        parent::__construct();
        $this->load->library('user_agent');
		$this->load->helper('dompdf_helper');

		
        
    } 
   
	function index(){
		$df=$this->db->field_data('tbl_calcprod');
	      foreach ($df as $key) { 
	        if($key->name!='id'){
	           $fl[]=$key->name; 
	        }
	      }
	      $fl=join(',',$fl);
	      print_r($fl);
		if ($this->agent->is_browser())
		{
		        $agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
		        $agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
		        $agent = $this->agent->mobile();
		}
		else
		{
		        $agent = 'Unidentified User Agent';
		}
		$dc=$agent.$this->agent->platform().$this->input->ip_address();
		echo $dc;
		echo '<iframe src="//docs.google.com/gview?url=https://www.yourwebsite.com/powerpoint.ppt&embedded=true" style="width:600px; height:500px;" frameborder="0"></iframe>';
	}
	public function exports_data(){
		//$data=$this->db->get('tbl_master_line')->row_array();
       	$this->load->dbutil();

		$query = $this->db->query("SELECT * FROM tbl_master_line");
		$delimiter = ",";
		$newline = "\r\n";

		header ("Content-disposition: attachment; filename=csvoutput_" . time() . ".csv") ;
		echo mb_convert_encoding($this->dbutil->csv_from_result($query, $delimiter, $newline), "ISO-8859-1", "UTF-8");
    }

	function generate(){
		$qu=$this->db->get_where('tbl_user',array('username !='=>'administrator'))->result();
		
	        foreach ($qu as $val) {
	        	$dx='';
	        	$group=$val->user_group;
	        	if($group=='User'){
	        		$m=$this->db->get_where('tbl_menu',array('parent'=>'user'))->result();
	        	}else{
	        		$m=$this->db->get_where('tbl_menu',array('parent !='=>'user'))->result();
	        	}
	             
	            foreach ($m as $key) {
	             $dx[]=array(
	                'menuid'=>$key->menuid,
	                'username'=>$val->username,
	                'view_level'=>'no',
	                'add_level'=>'no',
	                'edit_level'=>'no',
	                'delete_level'=>'no',
	                'import_level'=>'no',
	                'print_level'=>'no',
	                'export_level'=>'no',
	                'del_all'=>'no',
	                );
	                
	            }
	            $this->db->insert_batch('tbl_menu_user',$dx);
	        }
	}
	function deletefile(){
		$path = './fileExcel/tbl_order_customer1640274074ADD_20200428.xlsx';

		if(@unlink($path))
		{
		    echo "Deleted file ";
		}
		else
		{
		    echo "File can't be deleted";
		}   
	}
	function str(){
	
	$qrcode='DN4111000000129ANX-25930001';
	echo preg_match("/DN4111000000129A/i",$qrcode);
	$delv_date='2022-04-11';
	$seq=substr('FSI23010101',-4);
    $seq=intval($seq)+1;
    echo '<br> test '.$seq.'<br>';
	echo date('Y-m-d',strtotime($delv_date));
	$qc='FSI'.gmdate('ym',time()+60*60*7);
	echo '<br>'.substr($qc,0,1);
	echo $qc;
	echo preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $qc);
	if(preg_match('/^[a-zA-Z]+[a-zA-Z0-9._]+$/', $qc)==1){
		echo 'alphanumeric';
	}else{
		echo 'bukan alphanumeric';
	}
	}

	function sj(){
		
        $html = $this->load->view('print/print_suratjalan', '', TRUE);
		$pdf = pdf_create($html, 'tes', 'A4', 'portrait', $stream=TRUE);

	}

	function label(){
		
        $html = $this->load->view('print/test_partlabel', '', TRUE);
		$pdf = pdf_create($html, 'tes', 'A4', 'portrait', TRUE);
		// echo($pdf);

	}

	function dn(){
        $html = $this->load->view('print/print_partlabel', '', TRUE);
		$pdf = pdf_create($html, 'tes', 'A4', 'portrait', $stream=TRUE);

	}
}