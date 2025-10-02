<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');
class Andon extends CI_Controller{
    public $pulling_date;
    function __construct(){
        parent::__construct();
		$hour= intval(gmdate('H',time()+60*60*7));
		$menit= intval(gmdate('i',time()+60*60*7));
		$cek=($hour*60)+$menit;
        $this->pulling_date=gmdate('Y-m-d',time()+60*60*7);
        if($cek<=420){ 
            $this->pulling_date=date('Y-m-d',strtotime('-1 days',strtotime(gmdate('Y-m-d',time()+60*60*7))));
        }   
    }
    
 function pulling(){
    $waiting_pos=$this->uri->segment(3);
 	$query['title']= $this->db->get('tbl_title')->row();
 	$query['pesan']= $this->db->get_where('tbl_pesan_andon',array('process'=>'Pulling'))->row();
    $query['temp']= $this->db->query("SELECT * FROM tbl_temp_pulling where waiting_pos='".$waiting_pos."' and pulling_type='Reguler' limit 1")->row();
    
    if($query['temp']->order_no!=''){
        $query['order']= $this->db->query("SELECT customer_code,delv_time,pulling_time,delv_cycle,order_no,sum(order_kbn) as order_kbn,sum(total_pulling) as total_pulling FROM tbl_order_customer where order_no='".$query['temp']->order_no."' limit 1")->row();
        $order_no=$query['order']->order_no;
        $delv_cycle=$query['order']->delv_cycle;
        $pulling_time=date('H:i',strtotime($query['order']->pulling_time));
        $delv_time=date('H:i',strtotime($query['order']->delv_time));
        $customer_code=$query['order']->customer_code;
        $pulling_kbn=$query['order']->total_pulling.'/'.$query['order']->order_kbn;
        $part_noekanban=$query['temp']->part_no1;
        $part_nopartlabel=$query['temp']->part_no2;
        $checking=$query['temp']->status;
        $pulling_shift=$query['temp']->pulling_shift;
    }else{
        $pulling_time='';
        $delv_time='';
        $order_no='';
        $delv_cycle='';
        $customer_code='';
        $pulling_kbn='';
        $part_noekanban='';
        $part_nopartlabel='';
        $checking='';
        $pulling_shift='';
    }
    $summary_shift['id']=$this->db->query("SELECT sum(order_kbn) as order_kbn,sum(total_pulling) as total_pulling,sum(if(finish_time is not null,remain_pulling,0)) as minus FROM tbl_order_customer where  waiting_pos='".$waiting_pos."' and pulling_date='".$this->pulling_date."' and pulling_shift='".$pulling_shift."' limit 1")->row(); 
    $summary_mis['id']=$this->db->query("SELECT count(id) as mis FROM tbl_mis_pulling where  waiting_pos='".$waiting_pos."' and pulling_date like '%".$this->pulling_date."%' and shift='".$pulling_shift."'")->row();
    $summary_chart=$this->db->query("SELECT customer_code,pulling_time,sum(order_kbn) as order_kbn,sum(total_pulling) as total_pulling FROM tbl_order_customer where  waiting_pos='".$waiting_pos."' and pulling_date='".$this->pulling_date."' and pulling_shift='".$pulling_shift."' group by customer_code,pulling_time order by pulling_time asc");
   if($summary_shift['id']->order_kbn!=''){
        $pull_order=$summary_shift['id']->total_pulling.'/'.$summary_shift['id']->order_kbn;
        $minus=$summary_shift['id']->minus;
   }else{
        $pull_order='0';
        $minus='0';
   }
   $mis_pulling=$summary_mis['id']->mis;
 	$data=array(
         	'title'=>$query['title']->title,
         	'owner'=>$query['title']->owner,
         	'version'=>$query['title']->version,
         	'logo'=>$query['title']->logo,
         	'pesan_andon'=>$query['pesan']->pesan,
            'order_no'=>$order_no,
            'customer_code'=>$customer_code,
            'delv_cycle'=>$delv_cycle,
            'delv_time'=>$delv_time,
            'pulling_time'=>$pulling_time,
            'pulling_kbn'=>$pulling_kbn,
            'part_noekanban'=>$part_noekanban,
            'part_nopartlabel'=>$part_nopartlabel,
            'checking'=>$checking,
            'pulling_date'=>$this->pulling_date,
            'waiting_pos'=>$waiting_pos,
            'pull_order'=>$pull_order,
            'minus'=>$minus,
            'mis_pulling'=>$mis_pulling,
            'pulling_shift'=>$pulling_shift,
         	'item_list'=>$this->db->query("SELECT customer_code,job_no,part_no,part_name,qty_kbn,order_kbn,total_pulling FROM tbl_order_customer WHERE order_no='".$query['temp']->order_no."' order by id asc")->result(),           
            'list_minus'=>$this->db->query("SELECT part_no,job_no,part_name,qty_kbn,sum(order_kbn) as order_kbn,sum(remain_pulling) as minus FROM tbl_order_customer where finish_time is not null and remain_pulling>0 group by part_no order by minus desc limit 5")->result(),
            'summary_chart'=>$summary_chart->result(),
            'status_scan'=>$query['temp']->order_no.$query['temp']->part_no1.$query['temp']->status.$pull_order.$minus.$mis_pulling,
			);	
 	$this->load->view('content/andon/pulling',$data);
 }
 
 function stock(){
 	$query['title']= $this->db->get('tbl_title')->row();
 	$query['pesan']= $this->db->get_where('tbl_pesan_andon',array('process'=>'Posting'))->row();
    $summary_mis['id']=$this->db->query("SELECT count(id) as mis FROM tbl_mis_posting where posting_date like '%".$this->pulling_date."%'")->row();
    $summary['id']=$this->db->query("SELECT count(if(status='EMPTY',id,null)) as empty, count(if(status='CRITICAL',id,null)) as critical,count(if(status='NORMAL',id,null)) as normal,count(if(status='OVER',id,null)) as over,count(if(pulling='DELAY_PLNG',id,null)) as delay_pulling,count(if(pulling='DELAY_DELV',id,null)) as delay_delv,count(if(pulling='MINUS',id,null)) as minus FROM view_stock_part")->row();
    $mis_posting=$summary_mis['id']->mis;
    $empty=$summary['id']->empty;
    $critical=$summary['id']->critical;
    $normal=$summary['id']->normal;
    $over=$summary['id']->over;
    $delay_pulling=$summary['id']->delay_pulling;
    $delay_delv=$summary['id']->delay_delv;
    $minus=$summary['id']->minus;
 	$data=array(
         	'title'=>$query['title']->title,
         	'detail'=>$query['title']->detail,
         	'owner'=>$query['title']->owner,
         	'version'=>$query['title']->version,
         	'logo'=>$query['title']->logo,
            'pesan_andon'=>$query['pesan']->pesan,
            'mis_posting'=>$mis_posting,
            'empty'=>$empty,
            'critical'=>$critical,
            'normal'=>$normal,
            'over'=>$over,
            'delay_pulling'=>$delay_pulling,
            'delay_delv'=>$delay_delv,
            'minus'=>$minus,
         	'status_scan'=>$mis_posting.$empty.$critical.$normal.$over.$delay_pulling.$minus,
			);	
 	$this->load->view('content/andon/stock',$data);
 }
function datastock(){
    $summary_mis['id']=$this->db->query("SELECT count(id) as mis FROM tbl_mis_posting where posting_date like '%".$this->pulling_date."%'")->row();
    $query['id']=$this->db->query("SELECT count(id) as total FROM tbl_history_posting where status='Stock'")->row();
    $summary['id']=$this->db->query("SELECT count(if(status='EMPTY',id,null)) as empty, count(if(status='CRITICAL',id,null)) as critical,count(if(status='NORMAL',id,null)) as normal,count(if(status='OVER',id,null)) as over,count(if(pulling='DELAY',id,null)) as delay_pulling,count(if(pulling='MINUS',id,null)) as minus FROM view_stock_part")->row();
    $mis_posting=$summary_mis['id']->mis;
    $empty=$summary['id']->empty;
    $critical=$summary['id']->critical;
    $normal=$summary['id']->normal;
    $over=$summary['id']->over;
    $delay_pulling=$summary['id']->delay_pulling;
    $minus=$summary['id']->minus;
    $data=array(
            'mis_posting'=>$mis_posting,
            'empty'=>$empty,
            'critical'=>$critical,
            'normal'=>$normal,
            'over'=>$over,
            'delay_pulling'=>$delay_pulling,
            'minus'=>$minus,
            'item_list'=>$this->db->query("SELECT * FROM view_stock_part order by pulling asc,delv_date asc,delv_time asc ,stock asc")->result(),  
            'status_scan'=>$mis_posting.$empty.$critical.$normal.$over.$delay_pulling.$query['id']->total,
            );  
    $this->load->view('content/andon/datastock',$data);
 }
 function resultstock(){
	$summary_mis['id']=$this->db->query("SELECT count(id) as mis FROM tbl_mis_posting where posting_date like '%".$this->pulling_date."%'")->row();
     $summary['id']=$this->db->query("SELECT count(if(status='EMPTY',id,null)) as empty, count(if(status='CRITICAL',id,null)) as critical,count(if(status='NORMAL',id,null)) as normal,count(if(status='OVER',id,null)) as over,count(if(pulling='DELAY_PLNG',id,null)) as delay_pulling,count(if(pulling='DELAY_DELV',id,null)) as delay_delv,count(if(pulling='MINUS',id,null)) as minus FROM view_stock_part")->row();
    $mis_posting=$summary_mis['id']->mis;
    $empty=$summary['id']->empty;
    $critical=$summary['id']->critical;
    $normal=$summary['id']->normal;
    $over=$summary['id']->over;
    $delay_pulling=$summary['id']->delay_pulling;
    $delay_delv=$summary['id']->delay_delv;
    $minus=$summary['id']->minus;
    $data['empty']=$empty;
    $data['critical']=$critical;
    $data['normal']=$normal;
    $data['over']=$over;
    $data['delay_pulling']=$delay_pulling;
    $data['delay_delv']=$delay_delv;
    $data['minus']=$minus;
    $data['mis_posting']=$mis_posting;
    $data['status_scan']=$mis_posting.$empty.$critical.$normal.$over.$delay_pulling.$minus;
	echo json_encode($data);
	}
 function resultpulling(){
    $waiting_pos=$this->input->post('waiting_pos');
    $pulling_shift=$this->input->post('pulling_shift');
	$query['temp']= $this->db->query("SELECT * FROM tbl_temp_pulling where waiting_pos='".$waiting_pos."' and pulling_type='Reguler' limit 1")->row();
    $summary_shift['id']=$this->db->query("SELECT sum(order_kbn) as order_kbn,sum(total_pulling) as total_pulling,sum(if(finish_time is not null,remain_pulling,0)) as minus FROM tbl_order_customer where  waiting_pos='".$waiting_pos."' and pulling_date='".$this->pulling_date."' and pulling_shift='".$pulling_shift."' limit 1")->row(); 
    $summary_mis['id']=$this->db->query("SELECT count(id) as mis FROM tbl_mis_pulling where  waiting_pos='".$waiting_pos."' and pulling_date like '%".$this->pulling_date."%' and shift='".$pulling_shift."'")->row();
   if($summary_shift['id']->order_kbn!=''){
        $pull_order=$summary_shift['id']->total_pulling.'/'.$summary_shift['id']->order_kbn;
        $minus=$summary_shift['id']->minus;
   }else{
        $pull_order='0';
        $minus='0';
   }
   $mis_pulling=$summary_mis['id']->mis;
	$data['status_scan']=$query['temp']->order_no.$query['temp']->part_no1.$query['temp']->status.$pull_order.$minus.$mis_pulling;
	echo json_encode($data);
	}
 function qccheck(){
    $query['title']= $this->db->get('tbl_title')->row();
    $query['pesan']= $this->db->get_where('tbl_pesan_andon',array('process'=>'QC Check'))->row();
    $lane= $this->db->get('tbl_master_laneqc')->result();
    $data=array(
            'title'=>$query['title']->title,
            'detail'=>$query['title']->detail,
            'owner'=>$query['title']->owner,
            'version'=>$query['title']->version,
            'logo'=>$query['title']->logo,
            'pesan_andon'=>$query['pesan']->pesan,
            'data_lane'=>$lane,
            );  
    $this->load->view('content/andon/qccheck',$data);
 }
 function resultqc(){
    $this->db->select('a.lane_no,a.eff as stdx,b.*');
    $this->db->from('tbl_master_laneqc a');
    $this->db->join('tbl_eff_line b',"a.lane_no=b.line_no and b.status is not null and b.prod_date='".$this->pulling_date."'",'left');
    $select=$this->db->get();
    foreach ($select->result() as $key) {
        $data['pic'.$key->lane_no]='('.$key->pic.') '.$key->part_no;
        $data['ef'.$key->lane_no]=$key->eff;
        $eff=$key->eff+0;
        $data['eff'.$key->lane_no]=$eff.'%';
        $data['plan'.$key->lane_no]=$key->plan+0;
        $data['target'.$key->lane_no]=$key->target+0;
        $data['actual'.$key->lane_no]=$key->ok+$key->ng;
        $data['stdeff'.$key->lane_no]=$key->stdx;
    }
    echo json_encode($data);
 }
function s_data(){
         if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $this->load->library('SSP');
            $table = 'view_stock_part';
            $primaryKey = 'id';
             
            $columns = array(
                array( 'db' => 'part_no',  'dt' => 'part_no', 'field'=>'part_no', 'as'=> 'part_no' ),
                array( 'db' => 'customer_code', 'dt' => 'customer_code', 'field'=>'customer_code', 'as'=> 'customer_code' ),
                array( 'db' => 'line', 'dt' => 'line', 'field'=>'line', 'as'=> 'line' ),
                array( 'db' => 'stock_min', 'dt' => 'stock_min', 'field'=>'stock_min', 'as'=> 'stock_min' ),
                array( 'db' => 'stock_max',  'dt' => 'stock_max', 'field'=>'stock_max', 'as'=> 'stock_max' ),
                array( 'db' => 'stock', 'dt' => 'stock', 'field'=>'stock', 'as'=> 'stock' ),
                array( 'db' => 'order_customer',  'dt' => 'order_customer', 'field'=>'order_customer', 'as'=> 'order_customer' ),
                array( 'db' => 'status',  'dt' => 'status', 'field'=>'status', 'as'=> 'status' ),
                array( 'db' => 'pulling_date','dt' => 'pulling_date', 'field'=>'pulling_date', 'as'=> 'pulling_date' ),
                array( 'db' => 'pulling_time', 'dt' => 'pulling_time', 'field'=>'pulling_time', 'as'=> 'pulling_time' ),
                array( 'db' => 'pulling',  'dt' => 'pulling', 'field'=>'pulling', 'as'=> 'pulling' ),
                array( 'db' => 'delv_date',  'dt' => 'delv_date', 'field'=>'delv_date', 'as'=> 'delv_date' ),
                array( 'db' => 'delv_time','dt' => 'delv_time', 'field'=>'delv_time', 'as'=> 'delv_time' ),
                array( 'db' => 'problem', 'dt' => 'problem', 'field'=>'problem', 'as'=> 'problem' ),
            );
                $joinQuery  = "";
                $where      = "";            
                $groupBy    = "";
                $having     = "";
            $sql_details = array(
                'user' => $this->db->username,  
                'pass' => $this->db->password,
                'db'   => $this->db->database,
                'host' => $this->db->hostname
            );
            
            echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $where, $groupBy,$having)
            );
        }
    }
}