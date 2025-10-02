<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');
class Andon extends CI_Controller{
    public $setting_date;
    function __construct(){
        parent::__construct();
		$hour= intval(gmdate('H',time()+60*60*7));
		$menit= intval(gmdate('i',time()+60*60*7));
		$cek=($hour*60)+$menit;
        $this->setting_date=gmdate('Y-m-d',time()+60*60*7);
        if($cek<=420){ 
            $this->setting_date=date('Y-m-d',strtotime('-1 days',strtotime(gmdate('Y-m-d',time()+60*60*7))));
        }   
    }

    function domPoDeliv(){
        $qt= $this->db->get('tbl_title',1)->row();
        $qp= $this->db->get_where('tbl_pesan_andon',array('process'=>'Packing'),1)->row();
        $q=$this->db->query("SELECT id,customer,po_no,po_date as order_date,count(DISTINCT(id)) as item_po,sum(po_qty) as pcs_po,delv_date as plan_delv,min(scan_packing) as packing_date,sum(if(pulling>0 ,pulling,0)) as pcs_pull,sum(if(packing_check>0 ,packing,0)) as pcs_pack,min(scan_delv) as stat_part,count(DISTINCT(if(delivery>0,id,null))) as item_delv,sum(if(delivery>0,delivery,0)) as pcs_delv,status as stat_delv FROM tbl_order_customer WHERE  (delv_date>= DATE(NOW()) and status !='Cancel') or (delv_date< DATE(NOW()) and status NOT IN('Finish','Cancel')) group by po_no, status order by plan_delv, po_no asc LIMIT 25
        ")->result();
       $data=array(
        'q'=>$q,
        'qt'=>$qt,
        'qp'=>$qp,
       );
       $this->load->view('andon/domPoDeliv',$data);
    }

    function monorder(){
        $qt= $this->db->get('tbl_title',1)->row();
        $qp= $this->db->get_where('tbl_pesan_andon',array('process'=>'Packing'),1)->row();
        $mis=$this->db->query("SELECT count(id) as total FROM tbl_h_misscan where pos_name='Packing_Check' and EXTRACT(YEAR_MONTH FROM now())=EXTRACT(YEAR_MONTH FROM scan_time)")->row();
        $sum=$this->db->query("SELECT count(if(status='Open',id,null)) as open, count(if(status='Process',id,null)) as process,count(if(status='Packing',id,null)) as finish,count(if(status='Minus',id,null)) as minus FROM view_delivery limit 1")->row();
       $data=array(
           'qt'=>$qt,
           'qp'=>$qp,
           'mis'=>$mis,
           'sum'=>$sum,
           'status_scan'=>$sum->open.$sum->process.$sum->finish.$sum->minus.$mis->total,
           'table'=>'view_delivery',
       );
       $this->load->view('andon/monitoring_order',$data);
    }

    function mondeliv(){
        $qt= $this->db->get('tbl_title',1)->row();
        $qp= $this->db->get_where('tbl_pesan_andon',array('process'=>'Packing'),1)->row();
        $mis=$this->db->query("SELECT count(id) as total FROM tbl_h_misscan where pos_name='Packing_Check' and EXTRACT(YEAR_MONTH FROM now())=EXTRACT(YEAR_MONTH FROM scan_time)")->row();
        $sum=$this->db->query("SELECT count(if(status='Open',id,null)) as open, count(if(status='Process',id,null)) as process,count(if(status='Packing',id,null)) as finish,count(if(status='Minus',id,null)) as minus FROM view_delivery limit 1")->row();
       $data=array(
           'qt'=>$qt,
           'qp'=>$qp,
           'mis'=>$mis,
           'sum'=>$sum,
           'status_scan'=>$sum->open.$sum->process.$sum->finish.$sum->minus.$mis->total,
           'table'=>'view_delivery',
       );
       $this->load->view('andon/monitoring_delivery',$data);
    }

    function domPlanActual(){
        
        $q=$this->db->query("SELECT customer,
        SUM(IF(packing_date<DATE(NOW() - INTERVAL 1 DAY), po_qty - packing, 0)) AS lr_qty,
        SUM(IF(packing_date=DATE(NOW() - INTERVAL 1 DAY), po_qty, 0)) AS lpo_qty,
        SUM(IF(packing_date<=DATE(NOW() - INTERVAL 1 DAY), packing, 0)) AS lact_qty,
        
        SUM(IF(packing_date=DATE(NOW()- INTERVAL 1 DAY), po_qty - packing, 0)) AS r_qty,
        SUM(IF(packing_date=DATE(NOW()), po_qty, 0)) AS po_qty,
        SUM(IF(packing_date=DATE(NOW()), packing, 0)) AS act_qty
        FROM tbl_order_customer WHERE status!='Finish' AND status!='Cancel' GROUP BY customer")->result();

       $data=array(
           'q'=>$q,
       );
       
       $this->load->view('andon/domPlanActual',$data);
    }

    function kombinasi(){
        $qt= $this->db->get('tbl_title',1)->row();
        $qp= $this->db->get_where('tbl_pesan_andon',array('process'=>'Packing'),1)->row();
        $mis=$this->db->query("SELECT count(id) as total FROM tbl_h_misscan where pos_name='Packing_Check' and EXTRACT(YEAR_MONTH FROM now())=EXTRACT(YEAR_MONTH FROM scan_time)")->row();
        $sum=$this->db->query("SELECT count(if(status='Open',id,null)) as open, count(if(status='Process',id,null)) as process,count(if(status='Packing',id,null)) as finish,count(if(status='Minus',id,null)) as minus FROM view_delivery limit 1")->row();
       $data=array(
           'qt'=>$qt,
           'qp'=>$qp,
           'mis'=>$mis,
           'sum'=>$sum,
           'status_scan'=>$sum->open.$sum->process.$sum->finish.$sum->minus.$mis->total,
           'table'=>'view_delivery',
       );
       $this->load->view('andon/kombinasi',$data);
    }
    function resultdel(){
     $mis=$this->db->query("SELECT count(id) as total FROM tbl_h_misscan where pos_name='Packing_Check' and EXTRACT(YEAR_MONTH FROM now())=EXTRACT(YEAR_MONTH FROM scan_time)")->row();
     $sum=$this->db->query("SELECT count(if(status='Open',id,null)) as open, count(if(status='Process',id,null)) as process,count(if(status='Packing',id,null)) as finish,count(if(status='Minus',id,null)) as minus FROM view_delivery limit 1")->row();
    $data['open']=$sum->open;
    $data['process']=$sum->process;
    $data['finish']=$sum->finish;
    $data['minus']=$sum->minus;
    $data['mis']=$mis->total;
    $data['status_scan']=$sum->open.$sum->process.$sum->finish.$sum->minus.$mis->total;
    echo json_encode($data);
    }
 function stock(){
 	$qt= $this->db->get('tbl_title',1)->row();
 	$qp= $this->db->get_where('tbl_pesan_andon',array('process'=>'Packing'),1)->row();
    $mis=$this->db->query("SELECT count(id) as total FROM tbl_h_misscan where pos_name='Packing_Check' and EXTRACT(YEAR_MONTH FROM now())=EXTRACT(YEAR_MONTH FROM scan_time)")->row();
    $sum=$this->db->query("SELECT count(if(status='On Delivery',id,null)) as on_delivery,count(if(status='Aman',id,null)) as aman,count(if(status='Need Order',id,null)) as need_order FROM tbl_stock_part limit 1")->row();
    $qd= $this->db->query("SELECT * FROM tbl_stock_part GROUP BY part_no_fsi")->result();    

    $data=array(
        'qt'=>$qt,
        'qp'=>$qp,
        'qd'=>$qd,
        'table'=>'tbl_stock_part',
        'on_delivery'=>$sum->on_delivery,
        'aman'=>$sum->aman,
        'need_order'=>$sum->need_order,
        'mis'=>$mis->total,
        
    );
    $this->load->view('andon/stock',$data);
 }
 function resultstock(){
    $this->db->query("UPDATE tbl_stock_part set po_qty=0");
    $this->db->query("UPDATE tbl_stock_part A, tbl_order_customer B LEFT JOIN tbl_master_partlist C ON(B.part_no_customer=C.part_no_customer AND B.status NOT IN('Finish','Cancel')) set A.po_qty=(SELECT sum(D.po_qty) FROM tbl_order_customer D WHERE D.part_no_customer=B.part_no_customer AND D.status NOT IN('Finish','Cancel'))  WHERE A.part_no_fsi=C.part_no_fsi AND B.status NOT IN('Finish','Cancel')");
    $this->db->query("UPDATE tbl_stock_part A, tbl_stock_part B left join tbl_order_supplier C ON(B.part_no_fsi=C.part_no_fsi) set A.on_delivery=if(C.id is not null,(SELECT sum(D.remain_pcs) FROM tbl_order_supplier D WHERE D.part_no_fsi=B.part_no_fsi AND D.remain_pcs>0),0)  WHERE A.part_no_fsi=B.part_no_fsi");
    $this->db->query("UPDATE tbl_stock_part set stock_akhir=(stock+on_delivery)-po_qty");
    $this->db->query("UPDATE tbl_stock_part set status=if(stock_akhir<0,'Need Order',if(stock_akhir>=0 and stock<po_qty and on_delivery>0,'On Delivery','Aman'))");
    // BATAS
    $mis=$this->db->query("SELECT count(id) as total FROM tbl_h_misscan where pos_name='Packing_Check' and EXTRACT(YEAR_MONTH FROM now())=EXTRACT(YEAR_MONTH FROM scan_time)")->row();
    $sum=$this->db->query("SELECT count(if(status='On Delivery',id,null)) as on_delivery,count(if(status='Aman',id,null)) as aman,count(if(status='Need Order',id,null)) as need_order FROM tbl_stock_part limit 1")->row();
    $data=array(
        'on_delivery'=>$sum->on_delivery,
        'aman'=>$sum->aman,
        'need_order'=>$sum->need_order,
        'mis'=>$mis->total,
        
    );
    echo json_encode($data);
    }
function tl(){
    $qt= $this->db->get('tbl_title',1)->row();
    $qp= $this->db->get_where('tbl_pesan_andon',array('process'=>'Posting'),1)->row();
    $mis=$this->db->query("SELECT count(id) as mis FROM tbl_mis_posting where  category='T/L' and post_date like '%".$this->setting_date."%'")->row();
    $sum=$this->db->query("SELECT count(if(status_stock='EMPTY',id,null)) as empty, count(if(status_stock='CRITICAL',id,null)) as critical,count(if(status_stock='NORMAL',id,null)) as normal,count(if(status_stock='OVER',id,null)) as over FROM view_tl limit 1")->row();
    $data=array(
        'qt'=>$qt,
        'qp'=>$qp,
        'table'=>'view_tl',
        'status_scan'=>$sum->empty.$sum->critical.$sum->normal.$sum->over.$mis->mis,
    );
    $this->load->view('andon/stocktl',$data);
 }
 function resulttl(){
    $mis=$this->db->query("SELECT count(id) as mis FROM tbl_mis_posting where  category='T/L' and post_date like '%".$this->setting_date."%'")->row();
   $sum=$this->db->query("SELECT count(if(status_stock='EMPTY',id,null)) as empty, count(if(status_stock='CRITICAL',id,null)) as critical,count(if(status_stock='NORMAL',id,null)) as normal,count(if(status_stock='OVER',id,null)) as over FROM view_tl limit 1")->row();
    $data['empty']=$sum->empty;
    $data['critical']=$sum->critical;
    $data['normal']=$sum->normal;
    $data['over']=$sum->over;
    $data['mis']=$mis->mis;
    $data['status_scan']=$sum->empty.$sum->critical.$sum->normal.$sum->over.$mis->mis;
    echo json_encode($data);
    }
 function outgoing(){
    $qt= $this->db->get('tbl_title',1)->row();
    $qp= $this->db->get_where('tbl_pesan_andon',array('process'=>'Posting'),1)->row();
    $sum=$this->db->query("SELECT count(if(status_stock='EMPTY',id,null)) as empty, count(if(status_stock='CRITICAL',id,null)) as critical,count(if(status_stock='NORMAL',id,null)) as normal,count(if(status_stock='OVER',id,null)) as over,count(if(status_setting='MINUS',id,null)) as minus_setting,count(if(status_order='MINUS',id,null)) as minus_order,count(if(status_order='DELAY',id,null)) as delay,sum(stock_og) as stock_og FROM view_stockog")->row();
    $data=array(
        'qt'=>$qt,
        'qp'=>$qp,
        'status_scan'=>$sum->empty.$sum->critical.$sum->normal.$sum->over.$sum->delay.$sum->minus_setting.$sum->minus_order.$sum->stock_og,
    );  
    $this->load->view('andon/outgoing',$data);

 }

 
function resultstockog(){
    $sum=$this->db->query("SELECT count(if(status_stock='EMPTY',id,null)) as empty, count(if(status_stock='CRITICAL',id,null)) as critical,count(if(status_stock='NORMAL',id,null)) as normal,count(if(status_stock='OVER',id,null)) as over,count(if(status_setting='MINUS',id,null)) as minus_setting,count(if(status_order='MINUS',id,null)) as minus_order,count(if(status_order='DELAY',id,null)) as delay,sum(stock_og) as stock_og FROM view_stockog")->row();
    $data['empty']=$sum->empty;
    $data['critical']=$sum->critical;
    $data['normal']=$sum->normal;
    $data['over']=$sum->over;
    $data['delay']=$sum->delay;
    $data['minu_order']=$sum->minus_order;
    $data['minus_setting']=$sum->minus_setting;
    $data['status_scan']=$sum->empty.$sum->critical.$sum->normal.$sum->over.$sum->delay.$sum->minus_setting.$sum->minus_order.$sum->stock_og;
    echo json_encode($data);
    }
 
 function qccheck(){
    $qt= $this->db->get('tbl_title')->row();
    $qp= $this->db->get_where('tbl_pesan_andon',array('process'=>'QC Check'))->row();
    $lane= $this->db->get('tbl_master_laneqc')->result();
    $data=array(
            'title'=>$qt->title,
            'detail'=>$qt->detail,
            'owner'=>$qt->owner,
            'version'=>$qt->version,
            'pesan_andon'=>$qp->pesan,
            'data_lane'=>$lane,
            );  
    $this->load->view('andon/qccheck',$data);
 }
 
 function resultqc(){
    $this->db->select('a.lane_no,a.eff as stdx,b.*');
    $this->db->from('tbl_master_laneqc a');
    $this->db->join('tbl_eff_line b',"a.lane_no=b.line_no and b.status is not null and b.prod_date='".$this->setting_date."'",'left');
    $select=$this->db->get();
    foreach ($select->result() as $key) {
        $data['pic'.$key->lane_no]=$key->part_no;
        $data['ef'.$key->lane_no]=$key->eff;
        $eff=$key->eff+0;
        $data['takt_time'.$key->lane_no]=$key->takt_time;
        $data['status'.$key->lane_no]=$key->status;
        $data['eff'.$key->lane_no]=$eff.'%';
        $data['plan'.$key->lane_no]=$key->plan+0;
        $data['target'.$key->lane_no]=$key->target+0;
        $data['actual'.$key->lane_no]=$key->ok+$key->ng;
        $data['stdeff'.$key->lane_no]=$key->stdx;
    }
    echo json_encode($data);
 }



    function formorderpart(){
		$part_no_fsi = $this->input->post('part_no_fsi');
		$qs = $this->db->get_where('tbl_stock_part', array('part_no_fsi' => $part_no_fsi),1)->row();
		$data = array(
			'qs' => $qs,
		);
		$this->load->view('admin/form/formorderpart_andon', $data);
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
					"update_by"=>"Andon",
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

    public function aData(){   
        //Load our library EditorLib 
        $table=$this->input->get('table');
        $this->load->library('EditorLib');
        $this->editorlib->andon($_POST,$table);
    
    }
}