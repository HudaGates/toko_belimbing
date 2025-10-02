<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller{
  // public $shift;
  // public $prod_date;
  // public $user_level;
  // public $pos_level;
  // public $pos_name;
  // public $user_area;
  // public $idcard;
  // public $nama;
  // public $id_t;
  //   function __construct(){
  //       parent::__construct();
  //       $this->id_t=$this->input->get('api');
  //       $query=$this->s_model->s_access($this->id_t); 
  //       $query=$query->row();
  //       if($query->user_level=='Cashier'){            
  //         $this->nama=$query->nama;
  //         $this->user_level=$query->user_level;
  //         $this->user_area=$query->user_area;
  //         $this->idcard=$query->idcard;
  //       }else{
  //         redirect('action/scan?api='.$this->id_t);
  //       }
  //   }
function index(){
  $this->id_t=$this->input->get('api');

  $month = 1;
  $year = 2024;
  $qt = $this->db->get('tbl_title', 1)->row();
  $qr = $this->db->query("SELECT * FROM `tbl_history_sale` WHERE MONTH(update_time) = ".$month."  and YEAR(update_time) = ".$year."")->result();
  
//  print_r($qr);
  $data=array(
        'qt'=>$qt,

    ); 
  $this->load->view('user/cashier/home',$data);
}

function formprintreportmonthly(){
  $this->id_t=$this->input->get('api');


  $qt = $this->db->get('tbl_title', 1)->row();
  $qsubstr = $this->db->query("SELECT SUBSTRING(update_time, 1, 7) AS substr FROM `tbl_history_sale` GROUP BY SUBSTRING(update_time, 1, 7)")->result();
  
//  print_r($qr);
  $data=array(
        'qt'=>$qt,
        'qsubstr'=>$qsubstr,
    ); 
  $this->load->view('admin/form/form_print_report_monthly',$data);
}

function formprintreportdaily(){
  $this->id_t=$this->input->get('api');


  $qt = $this->db->get('tbl_title', 1)->row();
  $qsubstr = $this->db->query("SELECT SUBSTRING(update_time, 1, 7) AS substr FROM `tbl_history_sale` GROUP BY SUBSTRING(update_time, 1, 7)")->result();
  
//  print_r($qr);
  $data=array(
        'qt'=>$qt,
        'qsubstr'=>$qsubstr,
    ); 
  $this->load->view('admin/form/form_print_report_daily',$data);
}


function reportmonth(){
  
  $month =$this->input->get('month');
  $year = $this->input->get('year');
  
  $qt = $this->db->get('tbl_title', 1)->row();
  $qr = $this->db->query("SELECT * FROM `tbl_history_sale` WHERE MONTH(update_time) = ".$month."  and YEAR(update_time) = ".$year."")->result();
  
  $qminstock = $this->db->query("SELECT * FROM `tbl_master_product` WHERE stock<5")->result();
  $cminstock = $this->db->query("SELECT COUNT(id) AS count_product FROM `tbl_master_product` WHERE stock<5")->row();
  $qsr = $this->db->query("SELECT SUM(total_amount) AS total_amount_month FROM `tbl_history_sale` WHERE MONTH(update_time) = ".$month."  and YEAR(update_time) = ".$year."")->row();
//  print_r($qr);
// SELECT DATE(update_time) as DATE, SUM(total_amount) total_count FROM tbl_history_sale GROUP BY  DATE(update_time)
   $data=array(
        'qt'=>$qt,
        'month'=>$month,
        'year'=>$year,
        'qr'=>$qr,
        'qminstock'=>$qminstock,
        'cminstock'=>$cminstock,
        'qsr'=>$qsr,

    ); 
  $this->load->view('report/report_month',$data);
}

}