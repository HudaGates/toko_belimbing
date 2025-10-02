<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postingpc extends CI_Controller{
  public $shift;
  public $prod_date;
  public $user_level;
  public $pos_level;
  public $pos_name;
  public $user_area;
  public $idcard;
  public $nama;
  public $id_t;
  function __construct(){
    parent::__construct();
    $this->id_t=$this->input->get('api');
    $query=$this->s_model->s_access($this->id_t); 
    $query=$query->row();
    if($query->user_level=='Posting'){            
      $this->nama=$query->nama;
      $this->user_level=$query->user_level;
      $this->user_area=$query->user_area;
      $this->idcard=$query->idcard;
    }else{
      redirect('action/scan?api='.$this->id_t);
    }
}
function index(){
  // echo 'test';
  $qt = $this->db->get('tbl_title', 1)->row();
  $datapos=$this->db->query("SELECT * from tbl_master_posting group by pos_level order by id asc")->result();
  $data=array(
        'datapos'=>$datapos,
        'qt'=>$qt
    ); 
  $this->load->view('user/posting/home',$data);
}
function postingpc(){
  // echo 'test';
  $qt = $this->db->get('tbl_title', 1)->row();
  $datapos=$this->db->query("SELECT * from tbl_master_posting group by pos_level order by id asc")->result();
  $data=array(
        'datapos'=>$datapos,
        'qt'=>$qt
    ); 
  $this->load->view('user/postingpc/scan',$data);
}

function start(){
    $pos_level=$this->input->get('pos');
    $qt = $this->db->get('tbl_title', 1)->row();
    $qp= $this->db->get_where('tbl_pesan_andon',array('process'=>'Posting'))->row();
    $temp=$this->db->get_where('tbl_temp_posting',array('scan_by'=>$this->nama),1)->row();  
    if(!empty($temp)){
        $scanstatus='PLEASE SCAN NEXT LABEL SUPPLIER';
      }else{
        $scanstatus='PLEASE SCAN LABEL SUPPLIER';
      }
      
      $mis=$this->db->query("SELECT id from tbl_mis_posting WHERE pos_level='".$pos_level."' and category='Mis Posting' and problem_date is null order by id desc limit 1")->row();
      if(!empty($temp)){
        $part=$this->db->get_where('tbl_master_posting',array('part_no'=>$temp->part_no),1)->row();
        $part_no=$part->part_no;
        $part_name=$part->part_name;
        $qty_kbn=$part->qty_kbn;
        $rack_actual=$part->rack_actual;
        $rack_id=$part->rack_id;
        $variant=$part->variant;
        $model=$part->model;
        $supplier=$part->supplier_name;
        
      }else{
        $part_no='';
        $part_name='';
        $qty_kbn='';
        $rack_id='';
        $rack_actual='';
        $variant='';
        $model='';
        $supplier='';
        
      }
    $data=array(
        'part_no'=>$part_no,
        'part_name'=>$part_name,
        'qty_kbn'=>$qty_kbn,
        'supplier'=>$supplier,
        'variant'=>$variant,
        'model'=>$model,
        'rack_actual'=>$rack_actual,
        'rack_id'=>$rack_id,
        'pos_level'=>$pos_level,
        'scanstatus'=>$scanstatus,
        'mis_posting'=>$mis->id,
        'qt'=>$qt,
        'qp'=>$qp,

    );  
      $this->load->view('user/postingpc/scan',$data);
  }
function scan(){
    $data = array ('status' => false);
    $qrcode =str_replace('$','',trim($this->input->post('qrcode')));
    $pos_level=trim($this->input->post('pos_level'));
    $cek=$this->db->query("SELECT * FROM tbl_master_posting WHERE '".$qrcode."' REGEXP qr_supplier  and status='Active' limit 1")->row();
    $querylog=$this->db->get_where('tbl_user',array('idcard'=>$qrcode))->result();

    if($qrcode!='' and !empty($cek)){
       $part_no=$cek->part_no;
       $supplier_name=$cek->supplier_name;
       $rack_id=$cek->rack_id;
       $sensor_no=$cek->sensor_no;
       $range_sensor=$cek->range_sensor;
       $double=$this->db->query("SELECT * FROM tbl_temp_posting where pos_level='".$pos_level."' and posting_date is null limit 1")->row();
       $mis=$this->db->query("SELECT id from tbl_mis_posting WHERE pos_level='".$pos_level."' and category='Mis Posting' and problem_date is null order by id desc limit 1")->row();
        if(!empty($double)){
          $data['status'] ='SCAN DOUBLE, BELUM SELESAI POSTING';
        }elseif(!empty($mis)){
          $data['status'] ='MIS POSTING';
        }elseif($cek->pos_level!=$pos_level){
          $data['status'] ='BEDA AREA POSTING';
        }else{
          $this->db->query("INSERT INTO tbl_history_posting(supplier_name,part_no,qr_supplier,pos_level,rack_actual, rack_id,sensor_no,range_sensor,scan_by,scan_date,posting_date) SELECT supplier_name,part_no,qr_supplier,pos_level,rack_actual,rack_id,sensor_no,range_sensor,scan_by,scan_date,posting_date FROM tbl_temp_posting WHERE pos_level='".$pos_level."' and scan_by='".$this->nama."'");
          $this->db->delete('tbl_temp_posting',array('pos_level'=>$pos_level,'scan_by'=>$this->nama));
           $data1 = array(
            "supplier_name"=>$supplier_name,
            "part_no"=>$part_no,
            "qr_supplier"=>$qrcode,
            "pos_level"=>$pos_level,
            "rack_actual"=>$rack_actual,
            "rack_id"=>$rack_id,
            "sensor_no"=>$sensor_no,
            "range_sensor"=>$range_sensor,
            "scan_by"=>$this->nama,
            "scan_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
          );
          $this->db->insert('tbl_temp_posting',$data1);
          
          $data['status'] ='SUCCESS';
                
        }      
            
    }elseif(!empty($querylog)){
      $data['status'] = 'LOGOUT';
    }else{    
      $data['status'] ='ERROR, KODE TIDAK DITEMUKAN';       
    }
    echo json_encode($data);
 }
 function mis(){
  $pos_level=$this->input->get('pos');
    $data_mis=$this->db->query("SELECT * from tbl_mis_posting WHERE pos_level='".$pos_level."' and category='Mis Posting' and problem_date is null order by id desc limit 1")->row();
    $data=array(
        'data_mis'=>$data_mis,
        'pos_level'=>$pos_level,
    );      
    $this->load->view('user/posting/mis',$data); 
  }
 function submitmis(){
  $this->form_validation->set_rules('problem', 'Problem', 'trim|required');
  $this->form_validation->set_rules('password', 'Password Leader', 'trim|required|callback_cek_pwd');
  $this->form_validation->set_error_delimiters('<p class="text-danger" style="margin-top:2px;">', '</p>');
  if($this->form_validation->run()) {
    $id=$this->input->post('id'); 
    $problem=$this->input->post('problem');

    $p=$this->input->post('password');
    $p = $this->encrypt->sha1($p);
    $p = strrev($p); $p=substr($p,5);
    $cekuser=$this->db->get_where('tbl_user',array('password'=>$p,'user_level'=>'Leader','user_area'=>$this->user_area),1)->row();
    $this->db->query("UPDATE tbl_mis_posting set problem='".$problem."', problem_date=now(),leader_confirm='".$cekuser->nama."' WHERE id='".$id."'");     
    $data['success'] = true;

  }else{
    foreach ($_POST as $key => $value) {
      $data['messages'][$key] = form_error($key);
    }     

  }
  echo json_encode($data);
 }
 public function cek_pwd(){
    $p=$this->input->post('password');
    $p = $this->encrypt->sha1($p);
    $p = strrev($p); $p=substr($p,5);
    $cekuser=$this->db->get_where('tbl_user',array('password'=>$p,'user_level'=>'Leader','user_area'=>$this->user_area),1)->row();
            if(!empty($cekuser)){
                    return true;
            }else{
                    $this->form_validation->set_message('cek_pwd', 'Password Leader Salah');
                    return FALSE;
            }
    }
function cekmis(){
  $pos_level=$this->input->get('pos');
  $mis=$this->db->query("SELECT id from tbl_mis_posting WHERE pos_level='".$pos_level."' and category='Mis Posting' and problem_date is null order by id desc limit 1")->row();
  if(!empty($mis)){
    $data['status']=true;
  }else{
    $data['status']=false;
  }
  echo json_encode($data);
}
function logout(){
    redirect('action/logout?api='.$this->id_t);
  }
}