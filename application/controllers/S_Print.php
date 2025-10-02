<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!!');
class S_Print extends CI_Controller{
	public $user_level;
	public $user_group;
	public $user_area;
	public $nama;
	public $username;
	public $shift;
	public $id_t;
	public $qt;
	function __construct(){
        parent::__construct();
        $this->id_t=$this->input->get('api');
        $query=$this->s_model->s_access($this->id_t); 
		$query=$query->row();  
		
		if($this->id_t!='andon'){
			if(!empty($query)){        		
				$this->username=$query->username;
				$this->nama=$query->nama;
				$this->user_area=$query->user_area;
				$this->user_level=$query->user_level;
				$this->user_group=$query->user_group;
				$this->shift=$query->shift;
				$this->qt= $this->db->get('tbl_title',1)->row();
			}else{
				redirect('action/losttime');
			}
		}
    } 
   
	function tbl_user(){
		$id=$this->input->get('id'); 
		$query=$this->db->query("select a.*,b.web_path from tbl_user a left join files b on(a.image=b.id) where a.id IN(".$id.") group by a.username");	
        //load content html
        $qt= $this->db->query('select a.*,b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();
        $data=array(	
						'data_table'=>$query->result(),
						'logo'=>$qt->web_path,
						'owner'=>$qt->owner,
						'title'=>$qt->title,
						'detail'=>$qt->detail,
						'jumlah'=>$query->num_rows(),

						);	
        $this->load->view('print/idcard',$data);
	}

	
	function tbl_master_product(){			
		$id=$this->input->get('id');
		$query=$this->db->query("select * from tbl_master_product where id IN(".$id.") order by id asc");
		$data=array(	
			'data_table'=>$query->result(),
			'jumlah'=>$query->num_rows(),
			);	
		$this->load->view('print/print_etalase_label',$data);
		
	}

	function tbl_stock_part(){			
		$id=trim($this->input->get('id'));
		$q=$this->db->query("select * from tbl_order_supplier where part_no_fsi='".$id."' and remain_pcs>0 limit 1")->row();
		// var_dump($q);
		if(!empty($q)){
		$qj=$this->db->query("select sum(order_box) as jumlah from tbl_order_supplier where part_no_fsi='".$id."'  and remain_pcs>0  limit 1")->row();
		$query=$this->db->query("select *,if(qty_box=0,order_pcs,qty_box) as qtybox from tbl_order_supplier where part_no_fsi='".$id."' and remain_pcs>0 order by id asc");
			$data=array(	
				'data_table'=>$query->result(),
				'jumlah'=>$qj->jumlah,
			);
			$this->load->view('print/print_order_supplier1',$data);
		}else{
			echo 'Bukan status On Delivery';
		}

		
	}

	function tbl_history_sale(){
		$cartid = $this->input->get('id');
		$qt = $this->db->get_where('tbl_title')->row();
		$qs = $this->db->get_where('tbl_history_sale', array('id' => $cartid))->row();
		$qsd = $this->db->get_where('tbl_history_sale_detail', array('sale_id' => $cartid))->result();
		$qsst = $this->db->query("SELECT SUM(sub_total) as amount from tbl_history_sale_detail where sale_id='". $cartid."'")->row();
		$data = array(
      'qt' => $qt,
      'qs' => $qs,
			'qsd' => $qsd,
			'qsst' => $qsst->amount
			
		);
		$this->load->view('print/receipt',$data);
	}

	function reportmonth(){
		// $start = $this->input->get('start');
		// $end = $this->input->get('end');
		$yearmonth = $this->input->get('yearmonth');
		$qt = $this->db->get('tbl_title', 1)->row();

		// $qr = $this->db->query("SELECT SUM(`total_amount`) AS total_per_day, DATE(`update_time`) AS date FROM tbl_history_sale WHERE (update_time BETWEEN '". $start."' AND '". $end."') GROUP BY DATE(`update_time`)")->result();
		$qr = $this->db->query("SELECT SUM(`total_amount`) AS total_per_day, DATE(`update_time`) AS date FROM tbl_history_sale WHERE SUBSTRING(update_time, 1, 7)=SUBSTRING('". $yearmonth."', 1, 7) GROUP BY DATE(`update_time`)")->result();

		$data = array(
      		'qr' => $qr,
			  'qt' => $qt,
			//   'start' => $start,
			//   'end' => $end,
			  'yearmonth' => $yearmonth,
		);
		$this->load->view('report/report_month',$data);
	}

	function reportday(){
		$day = $this->input->get('day');
		$qt = $this->db->get('tbl_title', 1)->row();

		$qt = $this->db->get('tbl_title', 1)->row();
		$qr = $this->db->query("SELECT * FROM `tbl_history_sale` WHERE SUBSTRING(update_time, 1, 10)=SUBSTRING('". $day."', 1, 10)")->result();
		
		$qminstock = $this->db->query("SELECT * FROM `tbl_master_product` WHERE stock<5")->result();
		$cminstock = $this->db->query("SELECT COUNT(id) AS count_product FROM `tbl_master_product` WHERE stock<5")->row();
		$qsr = $this->db->query("SELECT SUM(total_amount) AS total_amount_month FROM `tbl_history_sale` WHERE SUBSTRING(update_time, 1, 10)=SUBSTRING('". $day."', 1, 10)")->row();
	  //  print_r($qr);
	  // SELECT DATE(update_time) as DATE, SUM(total_amount) total_count FROM tbl_history_sale GROUP BY  DATE(update_time)
		 $data=array(
			  'qt'=>$qt,
			  'qr'=>$qr,
			  'qminstock'=>$qminstock,
			  'cminstock'=>$cminstock,
			  'qsr'=>$qsr,
			  'day'=>$day,
	  
		  ); 
		$this->load->view('report/report_day',$data);

	}



	function tbl_order_supplier(){			
		$id=$this->input->get('id');
		$q=$this->db->query("select * from tbl_order_supplier where id='".$id."' limit 1")->row();
		$qj=$this->db->query("select sum(order_box) as jumlah from tbl_order_supplier where order_no='".$q->order_no."'  limit 1")->row();
		$query=$this->db->query("select *,if(qty_box=0,order_pcs,qty_box) as qtybox from tbl_order_supplier where order_no='".$q->order_no."' order by id asc");
		$data=array(	
			'data_table'=>$query->result(),
			'jumlah'=>$qj->jumlah,
			);
		//$this->load->view('print/print_order_supplier',$data);
		$this->load->helper('dompdf_helper');
		$html =$this->load->view('print/print_order_supplier',$data,TRUE);
		$pdf=pdf_create($html, $q->supplier_code.'-'.$q->order_no, 'A4', 'portrait', TRUE);	
		
		
	}
	
	function tbl_master_rack(){
		$id=$this->input->get('id');
		$ex=explode('_',$id); 
		$id=$ex[0];
		$to=$ex[1];
		$query=$this->db->query("SELECT a.*,b.job_no,b.job_internal,b.part_no,b.part_name,b.box_type,b.qty_box FROM tbl_master_rack a left join tbl_master_kanban b ON(a.id_kbn=b.id_kbn) where  a.id IN(".$id.")  group by a.qrrack,a.id_kbn order by a.id asc");	
		$qt= $this->db->get('tbl_title',1)->row();
        $data=array(	
				'qt'=>$qt,
				'data_table'=>$query->result(),
				'jumlah'=>$query->num_rows(),
				);
		if($to=='IN'){
			$this->load->view('print/print_rack_in',$data);
		}else{
			$this->load->view('print/print_rack_out',$data);
		}	
        
	}
	function tbl_master_toolroom(){
		$id=$this->input->get('id');
		$query=$this->db->query("select * from tbl_master_toolroom where id IN(".$id.") order by id asc");	
		$qt= $this->db->get('tbl_title',1)->row();
        $data=array(	
				'qt'=>$qt,
				'data_table'=>$query->result(),
				'jumlah'=>$query->num_rows(),
				);		
        $this->load->view('print/print_racktoolroom',$data);
	}
	function tbl_jig(){	
		$id=$this->input->get('id');
		$query=$this->db->query("select * from tbl_master_matrixroute a left join tbl_master_kanban b on(a.id_kbn=b.id_kbn) where a.machine_no!='-'  and a.id IN(".$id.") group by a.diesjigrack_no order by a.id asc");	
		$qt= $this->db->get('tbl_title',1)->row();
        $data=array(	
				'qt'=>$qt,
				'data_table'=>$query->result(),
				'jumlah'=>$query->num_rows(),
				);		
        $this->load->view('print/print_labeljig',$data);
	}
	function tbl_machine(){
		$id=$this->input->get('id');
		$query=$this->db->query("select * from tbl_master_matrixroute where machine_no!='-'  and id IN(".$id.") group by machine_no order by id asc");	
		$qt= $this->db->get('tbl_title',1)->row();
        $data=array(	
				'qt'=>$qt,
				'data_table'=>$query->result(),
				'jumlah'=>$query->num_rows(),
				);			
        $this->load->view('print/print_labelmachine',$data);
	}
	function tbl_master_operator(){
		$id=$this->input->get('id');
		$query=$this->db->query("select * from tbl_master_operator where id IN(".$id.") order by id asc");	
		$qt= $this->db->get('tbl_title',1)->row();
        $data=array(	
				'qt'=>$qt,
				'data_table'=>$query->result(),
				'jumlah'=>$query->num_rows(),
				);	
        $this->load->view('print/print_labeloperator',$data);
	}
	function tbl_history_partlabel(){
		$id=$this->input->get('id'); 
		$seq=$this->input->get('seq'); 
		$cek=explode("_", $id);
		$id=$cek[0];
		$qs=$this->db->get_where('tbl_history_partlabel',array('id'=>$id),1)->row();
		$qk=$this->db->get_where('tbl_master_kanban',array('id_kbn'=>$qs->id_kbn),1)->row();
		$qr=$this->db->query("SELECT GROUP_CONCAT(qrrack) as qrrack FROM tbl_master_rack WHERE id_kbn='".$qs->id_kbn."' limit 1")->row();
		$qrt=$this->db->query("SELECT max(route_order) as total_post,GROUP_CONCAT(route_pos) as routing FROM tbl_master_matrixroute WHERE id_kbn='".$qs->id_kbn."' limit 1")->row(); 

		$qt= $this->db->get('tbl_title',1)->row();	
		if($seq==''){
			$jumlah=$qs->qty_lot;
		}else{
			$jumlah=1;
		}
		$data=array(
			'key'=>$qs,
			'qt'=>$qt,
			'qk'=>$qk,
			'qrr'=>$qr,
			'qrt'=>$qrt,
			'seq'=>$seq,
			'jumlah'=>$jumlah,
			);	
        $this->load->view('print/partlabel',$data);
	}
	 function tbl_delvtoyoska(){ 
		$id=$this->input->get('id');
		$set=$this->db->get_where('tbl_delvtoyoska',array('id'=>$id),1)->row(); 
		$delv_date=$set->delv_date;
		$sj_no=$set->sj_no;		
		if($set->status=='CREATE'){
			$data2 = array( 
				"sj_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				"delv_date"=>$delv_date,
				"status"=>"DELIVERY",
			);
		}else{
			$data2 = array( 
				"sj_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				"delv_date"=>$delv_date,
			);
		}
		$this->db->update('tbl_delvtoyoska',$data2,array('sj_no'=>$sj_no));
		$data_set=$this->db->query("SELECT id_kbn,part_no,part_name,delv_qtypcs,qty_box,ceil(total_delv/qty_box) as total_kbn,total_delv as total_pcs FROM tbl_delvtoyoska WHERE sj_no='".$sj_no."'  GROUP BY part_no  order by id asc");
		foreach($data_set->result() as $key){
			$qk=$this->db->get_where('tbl_master_kanban',array('id_kbn'=>$key->id_kbn),1)->row();
   			$qr=$this->db->query("SELECT GROUP_CONCAT(qrrack) as qrrack FROM tbl_master_rack WHERE id_kbn='".$key->id_kbn."' limit 1")->row();
			
			$qty_box=$key->qty_box;
			if($key->delv_qtypcs>0){
				$qty_box=$key->qty_box.'-'.$key->delv_qtypcs;
			}
			$qrcode=$qk->id_kbn.'|'.$qk->part_no.'|'.$qk->customer_code.'|'.$qk->job_no.'|'.$qty_box.'|'.$sj_no.'|'.$key->total_kbn;            
			$data3[] = array(
	       		"create_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				"create_by"=>$this->nama,
				"lotid"=>$sj_no,
				"qrcode"=>$qrcode,
				"id_kbn"=>$qk->id_kbn,
				"qty_lot"=>$key->total_kbn,
				"qty_box"=>$key->qty_box,
				"qrrack"=>$qr->qrrack,
				"status"=>'Production',
	        	);	       
		   
		}
		$this->db->insert_batch('tbl_history_partlabel', $data3);   
		$qt= $this->db->get('tbl_title',1)->row();
		$qd=$this->db->query("SELECT * from tbl_master_document WHERE doc_name='SURAT JALAN' limit 1")->row();
		$qs=$this->db->get_where('tbl_master_subcont',array('subcont_code'=>$set->subcont_code),1)->row();
			$data1=array(
				'data_table'=>$data_set->result(),
				'jumlah'=>$data_set->num_rows(),
				'qt'=>$qt,
				'qd'=>$qd,
				'qs'=>$qs,
				'sj_no'=>$sj_no,
				'delv_date'=>$delv_date,
				);							
  		$this->load->view('print/print_sjscypi',$data1);
					
    }
   function tbl_release_order(){			
			$id=$this->input->get('id');
			$query=$this->db->query("select * from tbl_release_order where id IN(".$id.") order by id asc");
			$this->db->query("UPDATE tbl_release_order set status='Print',print_by='".$this->nama."',print_date=now() WHERE print_date is null and id IN(".$id.")");
	        $data=array(	
				'data_table'=>$query->result(),
				'jumlah'=>$query->num_rows(),
				);	
	        $this->load->view('print/labelrowmatrial',$data);
	}
	function form_print_sj(){
		$table= $this->input->post('table');
		$data=array(
		'table'=>$table,
		'id_t'=>$this->id_t,
		);		
	  $this->load->view('print/form_print_sj',$data);
	}
	function form_reprint_sj(){
		$table= $this->input->post('table');
		$data=array(
		'table'=>$table,
		'id_t'=>$this->id_t,
		);		
	  $this->load->view('print/form_reprint_sj',$data);
	}
	function form_print_sjsc(){
		$table= $this->input->post('table');
		$data=array(
		'table'=>$table,
		'id_t'=>$this->id_t,
		);		
	  $this->load->view('print/form_print_sjsc',$data);
	}
	 function form_print_labelsc(){
		$table= $this->input->post('table');
		$data=array(
		'table'=>$table,
		'id_t'=>$this->id_t,
		);		
	  $this->load->view('print/form_print_labelsc',$data);
	}
	function view_sj(){ 
		$int_bulan=intval(gmdate('m',time()+60*60*7));	
		$sj_no=trim($this->input->post('sj_no'));
		$delv_date=$this->input->post('delv_date');
		$delv_date=date('Y-m-d',strtotime($delv_date));
		$cek=$this->db->get_where('tbl_history_setting',array('sj_no' =>$sj_no),1)->row();
		$data_order=$this->db->query("SELECT b.id,a.part_no,a.part_name,count(a.id) as jumlah,sum(a.qty_kbn) as total_pcs,b.remark from tbl_history_setting a inner join tbl_order_customer b on(a.order_no=b.order_no and a.part_no=b.part_no) WHERE a.sj_no='".$sj_no."' group by a.part_no order by b.id asc");
		$qs=$this->db->get_where('view_print_sj',array('sj_no'=>$sj_no),1)->row();
		$qd=$this->db->get_where('tbl_master_document',array('doc_name'=>'SURAT JALAN'),1)->row();
		$qc=$this->db->get_where('tbl_master_customer',array('customer_code'=>$cek->customer_code),1)->row();
		$qt= $this->db->get('tbl_title',1)->row();
			$data1=array(
				'data_table'=>$data_order->result(),
				'qt'=>$qt,
				'qd'=>$qd,
				'qc'=>$qc,
				'jumlah'=>$data_order->num_rows(),
				'sj_no'=>$sj_no,
				'note'=>$qs->note,
				'order_no'=>$cek->order_no,
				'setting_type'=>$cek->setting_type,
				'delv_date'=>$delv_date,
				);		
  		$this->load->view('print/view_sj',$data1);
					
    }

  function re_print_sj(){ 
		$sj_no=$this->input->post('sj_no');
		$delv_date=$this->input->post('delv_date');
		$delv_date=date('Y-m-d',strtotime($delv_date));
		$cek=$this->db->get_where('tbl_history_setting',array('sj_no' =>$sj_no),1)->row();
		$order_no=$cek->order_no;
		$setting_type=$cek->setting_type;
		$data2 = array( 
					"print_pic"=> $this->nama,
					"print_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
					"act_delv_date"=>$delv_date,
				);
		$this->db->update('tbl_history_setting',$data2,array('order_no'=>$order_no,'sj_no'=>$sj_no));
		$data_order=$this->db->query("SELECT b.id,a.part_no,a.part_name,count(a.id) as jumlah,sum(a.qty_kbn) as total_pcs,b.remark from tbl_history_setting a inner join tbl_order_customer b on(a.order_no=b.order_no and a.part_no=b.part_no) WHERE a.order_no='".$order_no."' and a.sj_no='".$sj_no."'  group by a.part_no order by b.id asc");

		$qs=$this->db->get_where('view_print_sj',array('sj_no'=>$sj_no),1)->row();
		$qd=$this->db->get_where('tbl_master_document',array('doc_name'=>'SURAT JALAN'),1)->row();
		$qc=$this->db->get_where('tbl_master_customer',array('customer_code'=>$cek->customer_code),1)->row();
		$qt= $this->db->get('tbl_title',1)->row();
			$data1=array(
				'data_table'=>$data_order->result(),
				'qt'=>$qt,
				'qd'=>$qd,
				'qc'=>$qc,
				'jumlah'=>$data_order->num_rows(),
				'sj_no'=>$sj_no,
				'order_no'=>$order_no,
				'setting_type'=>$setting_type,
				'note'=>$qs->note,
				'delv_date'=>$delv_date,
				);		
  		$this->load->view('print/print_sj',$data1);
					
    }
    function view_sjsc(){ 
		$sj_no=trim($this->input->post('sj_no'));
		$del_date=$this->input->post('del_date');
		$sett=$this->db->get_where('tbl_delvtosubcont',array('sj_no'=>$sj_no),1)->row();		
		$data_set=$this->db->query("SELECT part_no,part_name,ceil(delv_qty/qty_box) as total_kbn,delv_qty as total_pcs FROM tbl_delvtosubcont WHERE sj_no='".$sj_no."'  GROUP BY part_no  order by id asc");
		$qt= $this->db->get('tbl_title',1)->row();
		$qd=$this->db->query("SELECT * from tbl_master_document WHERE doc_name='SURAT JALAN' limit 1")->row();
		$qs=$this->db->get_where('tbl_master_subcont',array('subcont_code'=>$sett->subcont_code),1)->row();
			$data1=array(
				'data_table'=>$data_set->result(),
				'jumlah'=>$data_set->num_rows(),
				'qt'=>$qt,
				'qd'=>$qd,
				'qs'=>$qs,
				'sj_no'=>$sj_no,
				'del_date'=>$del_date,
				);		
  		$this->load->view('print/view_sjsc',$data1);
					
    }
    function print_sjsc(){ 
		$sj_no=trim($this->input->post('sj_no'));
		$del_date=$this->input->post('del_date');
		$sett=$this->db->get_where('tbl_delvtosubcont',array('sj_no'=>$sj_no),1)->row();		
		$data_set=$this->db->query("SELECT part_no,part_name,ceil(delv_qty/qty_box) as total_kbn,delv_qty as total_pcs FROM tbl_delvtosubcont WHERE sj_no='".$sj_no."'  GROUP BY part_no  order by id asc");
		if($sett->status=='SETTING'){
			$data2 = array( 
				"print_sj_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				"delv_date"=>$del_date,
				"status"=>"DELIVERY",
			);
		}else{
			$data2 = array( 
				"print_sj_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				"delv_date"=>$del_date,
			);
		}
		$this->db->update('tbl_delvtosubcont',$data2,array('sj_no'=>$sj_no));
		
		$qt= $this->db->get('tbl_title',1)->row();
		$qd=$this->db->query("SELECT * from tbl_master_document WHERE doc_name='SURAT JALAN' limit 1")->row();
		$qs=$this->db->get_where('tbl_master_subcont',array('subcont_code'=>$sett->subcont_code),1)->row();
			$data1=array(
				'data_table'=>$data_set->result(),
				'jumlah'=>$data_set->num_rows(),
				'qt'=>$qt,
				'qd'=>$qd,
				'qs'=>$qs,
				'sj_no'=>$sj_no,
				'del_date'=>$del_date,
				);		
  		$this->load->view('print/print_sjsc',$data1);
					
    }
    function view_sjscypi(){ 
		$sj_no=trim($this->input->post('sj_no'));
		$delv_date=$this->input->post('delv_date');

		$set=$this->db->get_where('tbl_delvtoyoska',array('sj_no'=>$sj_no),1)->row();		
		$data_set=$this->db->query("SELECT part_no,part_name,ceil(total_delv/qty_box) as total_kbn,total_delv as total_pcs FROM tbl_delvtoyoska WHERE sj_no='".$sj_no."'  GROUP BY part_no  order by id asc");
		$qt= $this->db->get('tbl_title',1)->row();
		$qd=$this->db->query("SELECT * from tbl_master_document WHERE doc_name='SURAT JALAN' limit 1")->row();
		$qs=$this->db->get_where('tbl_master_subcont',array('subcont_code'=>$set->subcont_code),1)->row();
			$data1=array(
				'data_table'=>$data_set->result(),
				'jumlah'=>$data_set->num_rows(),
				'qt'=>$qt,
				'qd'=>$qd,
				'qs'=>$qs,
				'sj_no'=>$sj_no,
				'delv_date'=>$delv_date,
				);				
  		$this->load->view('print/view_sjscypi',$data1);
					
    }
     function print_sjscypi(){ 
		$sj_no=trim($this->input->post('sj_no'));
		$delv_date=$this->input->post('delv_date');
		$set=$this->db->get_where('tbl_delvtoyoska',array('sj_no'=>$sj_no),1)->row();		
		if($set->status=='CREATE'){
			$data2 = array( 
				"sj_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				"delv_date"=>$delv_date,
				"status"=>"DELIVERY",
			);
		}else{
			$data2 = array( 
				"sj_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				"delv_date"=>$delv_date,
			);
		}
		$this->db->update('tbl_delvtoyoska',$data2,array('sj_no'=>$sj_no));

		$data_set=$this->db->query("SELECT id_kbn,part_no,part_name,delv_qtypcs,qty_box,ceil(total_delv/qty_box) as total_kbn,total_delv as total_pcs FROM tbl_delvtoyoska WHERE sj_no='".$sj_no."'  GROUP BY part_no  order by id asc");
		foreach($data_set->result() as $key){
			$qk=$this->db->get_where('tbl_master_kanban',array('id_kbn'=>$key->id_kbn),1)->row();
   			$qr=$this->db->query("SELECT GROUP_CONCAT(qrrack) as qrrack FROM tbl_master_rack WHERE id_kbn='".$key->id_kbn."' limit 1")->row();
			
			$qty_box=$key->qty_box;
			if($key->delv_qtypcs>0){
				$qty_box=$key->qty_box.'-'.$key->delv_qtypcs;
			}
			$qrcode=$qk->id_kbn.'|'.$qk->part_no.'|'.$qk->customer_code.'|'.$qk->job_no.'|'.$qty_box.'|'.$sj_no.'|'.$key->total_kbn;            
			$data3[] = array(
	       		"create_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
				"create_by"=>$this->nama,
				"lotid"=>$sj_no,
				"qrcode"=>$qrcode,
				"id_kbn"=>$qk->id_kbn,
				"qty_lot"=>$key->total_kbn,
				"qty_box"=>$key->qty_box,
				"qrrack"=>$qr->qrrack,
				"status"=>'Production',
	        	);	       
		   
		}
		$this->db->insert_batch('tbl_history_partlabel', $data3);   
		$qt= $this->db->get('tbl_title',1)->row();
		$qd=$this->db->query("SELECT * from tbl_master_document WHERE doc_name='SURAT JALAN' limit 1")->row();
		$qs=$this->db->get_where('tbl_master_subcont',array('subcont_code'=>$set->subcont_code),1)->row();
			$data1=array(
				'data_table'=>$data_set->result(),
				'jumlah'=>$data_set->num_rows(),
				'qt'=>$qt,
				'qd'=>$qd,
				'qs'=>$qs,
				'sj_no'=>$sj_no,
				'delv_date'=>$delv_date,
				);						
  		$this->load->view('print/print_sjscypi',$data1);
					
    }

   
	function get_part_nosc(){
    	$part_no = $this->input->get('query');

		// Query ke database.
		$query  = $this->db->query("SELECT part_no,subcont_code FROM tbl_h_delsubcont WHERE part_no LIKE '%".$part_no."%'  and receipt_date is not null and label_date is null and next_store!='FINISH GOODS' ORDER BY id ASC limit 10");
    	$result = $query->result_array();

		// Format bentuk data untuk autocomplete.
		foreach($result as $data) {
		    $output[] = [
		        'value' => $data['part_no'].'_'.$data['subcont_code'],
		        'label'  => $data['part_no']
		    ];
		}

		if (!empty($output) and $part_no!='') {
		    // Encode ke format JSON.
		    echo json_encode($output);
		}else{
			$output[] = [
		        'value' => 'No Data',
		        'label'  => 'No Data'
		    ];
			echo json_encode($output);
		}
    }
    function print_partlist(){ 
    	$int_bulan=intval(gmdate('m',time()+60*60*7));
    	$part_no=trim($this->input->post('part_no'));
    	$ex=explode('_', $part_no);
    	$part_no=$ex[0];
    	$cms=$this->db->query("SELECT * FROM tbl_h_delsubcont WHERE part_no='".$part_no."' and receipt_date is not null and label_date is null and next_store!='FINISH GOODS' ORDER BY id ASC limit 1")->row();
    	$cmp=$this->db->query("SELECT * FROM tbl_master_partlist WHERE part_no='".$part_no."' and store='".$cms->next_store."' ORDER BY id ASC limit 1")->row();	
    	$bln=$this->db->get_where("tbl_konversi_bulan",array("int_bulan"=>$int_bulan),1)->row();

		$lot_no=$cmp->line_code.' '.gmdate('d',time()+60*60*7).' '.$bln->string_bulan.' '.gmdate('y',time()+60*60*7).' '.'N';
		$qlot=$this->db->query("SELECT count(DISTINCT(lot_seq)) as lot_seq from tbl_history_partlabel where lot_no='".$lot_no."' limit 1")->row();
		$lot_seq=$qlot->lot_seq+1;
		;
		if(!empty($cms)){
				$x=$cms->rec_qtybox;
				for ($i = 1; $i <= $x; $i++) {                           
		           $data1[] = array(
						"lot_no"=>$lot_no,
						"lot_seq"=>$lot_seq,
						"qr_partlabel"=>$lot_no.'_'.$lot_seq.'_'.$cms->part_no.'_'.$i.'_QC',
						"label_seq"=>$i,
						"customer_code"=>$cmp->customer_code,
						"model"=>$cmp->model,
						"part_no"=>$cms->part_no,
						"part_name"=>$cms->part_name,
						"qty_kbn"=>$cms->qty_kbn,
						"qty_lot"=>$cms->qty_kbn*$x,
						"store"=>$cms->next_store,
						"rack_no"=>$cms->rack_no,
						"process"=>'QC',
						"line"=>$cms->subcont_code,
						"line_code"=>$cms->subcont_code,
						"jig_no"=>$cmp->jig_no,
						"prod_pic"=>$this->nama,
						"shift"=>$this->shift,
						"prod_date"=>gmdate('Y-m-d',time()+60*60*7),
						"print_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
						"print_pic"=>$this->nama,
						"supply_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
						"supply_pic"=>'INCOMING',
						"status"=>'Production',
		            );
			       
			   }
			   $this->db->insert_batch('tbl_history_partlabel', $data1); 
			}

		    $part_label=$this->db->query("SELECT * from tbl_history_partlabel WHERE lot_no='".$lot_no."' and lot_seq='".$lot_seq."' and print_pic='".$this->nama."' order by id asc");
			$query['doc']=$this->db->query("SELECT * from tbl_master_document WHERE doc_name='PART LABEL' limit 1")->row();
			$qt= $this->db->query('select a.*,b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();
			$this->db->query("UPDATE tbl_h_delsubcont set label_date=now() WHERE id='".$cms->id."'");
			$data=array(
				'data_table'=>$part_label->result(),
				'owner'=>$qt->owner,
				'detail'=>$qt->detail,
				'doc_name'=>$query['doc']->doc_name,
				'doc_no'=>$query['doc']->doc_no,
				'revision'=>$query['doc']->revision,
				'active_date'=>$query['doc']->active_date,
				'jumlah'=>$part_label->num_rows(),
				);		
	  		$this->load->view('print/partlabel',$data);
		
			
    }
    function print_labelqc(){ 
    	$int_bulan=intval(gmdate('m',time()+60*60*7));
    	$id=trim($this->input->post('id'));
    	$shift='N';
    	$ex=explode('_', $part_no);
    	$part_no=$ex[0];
    	$cms=$this->db->query("SELECT * FROM tbl_master_partsubcont WHERE id='".$id."' limit 1")->row();
    	$cmp=$this->db->query("SELECT * FROM tbl_master_partlist WHERE part_no='".$part_no."' and store='".$cms->next_store."' ORDER BY id ASC limit 1")->row();
    	$bln=$this->db->get_where("tbl_konversi_bulan",array("int_bulan"=>$int_bulan),1)->row();

		$lot_no=$cmp->line_code.' '.gmdate('d',time()+60*60*7).' '.$bln->string_bulan.' '.gmdate('y',time()+60*60*7).' '.$shift;
		$qlot=$this->db->query("SELECT count(DISTINCT(lot_seq)) as lot_seq from tbl_history_partlabel where lot_no='".$lot_no."' limit 1")->row();
		$lot_seq=$qlot->lot_seq+1;
		
		if(!empty($cms)){
				$x=1;
				for ($i = 1; $i <= $x; $i++) {                           
		           $data1[] = array(
						"lot_no"=>$lot_no,
						"lot_seq"=>$lot_seq,
						"qr_partlabel"=>$lot_no.'_'.$lot_seq.'_'.$cms->part_no.'_'.$i.'_QC',
						"label_seq"=>$i,
						"customer_code"=>$cmp->customer_code,
						"model"=>$cmp->model,
						"part_no"=>$cms->part_no,
						"part_name"=>$cms->part_name,
						"qty_kbn"=>$cms->qty_kbn,
						"qty_lot"=>$cms->qty_kbn*$x,
						"store"=>$cms->next_store,
						"rack_no"=>$cms->rack_no,
						"process"=>'QC',
						"line"=>$cms->subcont_code,
						"line_code"=>$cms->subcont_code,
						"jig_no"=>$cmp->jig_no,
						"prod_pic"=>$this->nama,
						"shift"=>$this->shift,
						"prod_date"=>gmdate('Y-m-d',time()+60*60*7),
						"print_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
						"print_pic"=>$this->nama,
						"supply_date"=>gmdate('Y-m-d H:i:s',time()+60*60*7),
						"supply_pic"=>'INCOMING',
						"status"=>'Production',
		            );
			       
			   }
			   $this->db->insert_batch('tbl_history_partlabel', $data1); 
			}

		    $part_label=$this->db->query("SELECT * from tbl_history_partlabel WHERE lot_no='".$lot_no."' and lot_seq='".$lot_seq."' and print_pic='".$this->nama."' order by id asc");
			$query['doc']=$this->db->query("SELECT * from tbl_master_document WHERE doc_name='PART LABEL' limit 1")->row();
			$qt= $this->db->query('select a.*,b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();
			$this->db->query("UPDATE tbl_h_delsubcont set label_date=now() WHERE id='".$cms->id."'");
			$data=array(
				'data_table'=>$part_label->result(),
				'owner'=>$qt->owner,
				'detail'=>$qt->detail,
				'doc_name'=>$query['doc']->doc_name,
				'doc_no'=>$query['doc']->doc_no,
				'revision'=>$query['doc']->revision,
				'active_date'=>$query['doc']->active_date,
				'jumlah'=>$part_label->num_rows(),
				);		
	  		$this->load->view('print/partlabel',$data);
		
			
    }
    function tbl_h_pr()
	{
		$ip_client = $this->input->ip_address();
		$id = $this->input->get('id');
		$qpr =  $this->db->get_where('tbl_h_pr',array('id'=>$id),1)->row();
		$qldpr = $this->db->get_where('tbl_h_detailpr', array('pr_no' => $qpr->pr_no))->result();
		$qap = $this->db->get_where('tbl_master_approver', array('username' => $qpr->picshop_by, 'doc_approver' => 'PR_TOOLROOM'), 1)->row();
		$qmdoc = $this->db->get_where('tbl_master_document', array('doc_name' => 'PR'), 1)->row();
		$qt= $this->db->get('tbl_title',1)->row();
		$data = array(
			'ip_client' => $ip_client,
			'qldpr' => $qldpr,
			'qpr' => $qpr,
			'qap' => $qap,
			'qmdoc' => $qmdoc,
			'jumlah' =>  count($qldpr),
		);
		$this->load->view('print/print_sj_proc', $data);
	}
  function tbl_h_po()
	{
		$ip_client = $this->input->ip_address();
		$id = $this->input->get('id');
		$qpo = $this->db->query("SELECT a.*, b.* FROM tbl_h_po a left join tbl_master_supplier b on(a.supplier_code=b.supplier_code) where a.id = '" . $id . "' limit 1")->row();
		$ex=explode('/',$qpo->po_no);
		$ex1=explode('-',$ex[1]);
		$q = $this->db->get_where('tbl_h_detailpr', array('po_no' => $qpo->po_no),1)->row();
		$qdir = $this->db->get_where('tbl_user', array('user_level' => 'Directur'),1)->row();
		$qldpr = $this->db->get_where('tbl_h_detailpr', array('po_no' => $qpo->po_no))->result();
		$qmdoc = $this->db->get_where('tbl_master_document', array('doc_name' => $ex1[0]), 1)->row();
		$qt = $this->db->get('tbl_title', 1)->row();
		$qpshop=$this->db->query("SELECT a.picshop_time, b.* FROM tbl_h_pr a left join tbl_user b on(a.picshop_by=b.username) where a.pr_no = '" . $q->pr_no . "' limit 1")->row();
		$qsshop=$this->db->query("SELECT a.spvshop_time, b.* FROM tbl_h_pr a left join tbl_user b on(a.spvshop_by=b.username) where a.pr_no = '" . $q->pr_no . "' limit 1")->row();
		$qmpud=$this->db->query("SELECT a.mgrpud_time, b.* FROM tbl_h_pr a left join tbl_user b on(a.mgrpud_by=b.username) where a.pr_no = '" . $q->pr_no . "' limit 1")->row();
		$qppud=$this->db->query("SELECT a.picpud_time, b.* FROM tbl_h_pr a left join tbl_user b on(a.picpud_by=b.username) where a.pr_no = '" . $q->pr_no . "' limit 1")->row();
		$qspud=$this->db->query("SELECT a.spvpud_time, b.* FROM tbl_h_pr a left join tbl_user b on(a.spvpud_by=b.username) where a.pr_no = '" . $q->pr_no . "' limit 1")->row();
		$qmpud=$this->db->query("SELECT a.mgrpud_time, b.* FROM tbl_h_pr a left join tbl_user b on(a.mgrpud_by=b.username) where a.pr_no = '" . $q->pr_no . "' limit 1")->row();
		// print_r($qpo);
		$data = array(
			'ip_client' => $ip_client,
			'qldpr' => $qldpr,
			'qpo' => $qpo,
			'qt' => $qt,
			'qmdoc' => $qmdoc,
			'jumlah' =>  count($qldpr),
			'qpshop'=>$qpshop,
			'qsshop'=>$qsshop,
			'qppud'=>$qppud,
			'qspud'=>$qspud,
			'qmpud'=>$qmpud,
			'qdir'=>$qdir,
		);
		if($qpo->sup_date=='' and strtolower($qpo->supplier_code)==strtolower($this->username)){
			$data2 = array(
				'sup_by'=>$this->username,
				'sup_date' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
			);
			$this->db->update('tbl_h_po', $data2, array('po_no' => $qpo->po_no));
		}
		
		if($ex1[0]=='PO'){
			$this->load->view('print/print_po_new', $data);
		}else{
			$this->load->view('print/print_skm', $data);
		}
		
	}
	function label_po()
	{
		$id = $this->input->get('id');
		$query = $this->db->query("select a.*,b.pr_no,b.delv_date,c.doc_approver,d.shape,d.shearing,e.rack from tbl_h_sj a left join tbl_h_detailpr b on(a.po_no=b.po_no) left join tbl_h_pr c on(b.pr_no=c.pr_no) left join tbl_master_rowmaterial d on(a.part_no=d.part_no) left join tbl_master_toolroom e on(a.part_no=e.part_no) where a.id IN(" . $id . ") group by a.id order by a.id asc");
		$qr=
		$qd = $this->db->get_where('tbl_master_document', array('doc_name' => 'LABEL PO'), 1)->row();
		$qt = $this->db->get('tbl_title', 1)->row();
		$data = array(
			'qt' => $qt,
			'qd' => $qd,
			'data_table' => $query->result(),
			'jumlah' => $query->num_rows(),
		);
		$this->load->view('print/partlabel_po', $data);
	}
	function label_skm()
	{
		$id = $this->input->get('id');
		$query = $this->db->query("select a.*,concat('','-') as sj_no,b.delv_date,c.doc_approver,d.shape,d.shearing from tbl_h_detailpr a left join tbl_h_po b on(a.po_no=b.po_no) left join tbl_h_pr c on(a.pr_no=c.pr_no) left join tbl_master_rowmaterial d on(a.part_no=d.part_no) where a.id IN(" . $id . ") group by a.id order by a.id asc");
		$qd = $this->db->get_where('tbl_master_document', array('doc_name' => 'LABEL PO'), 1)->row();
		$qt = $this->db->get('tbl_title', 1)->row();
		$this->db->query("UPDATE tbl_h_detailpr set status='Delivery' WHERE id IN(". $id . ") ");

		$data = array(
			'qt' => $qt,
			'qd' => $qd,
			'data_table' => $query->result(),
			'jumlah' => $query->num_rows(),
		);
		$this->load->view('print/partlabel_po', $data);
	}
	function tbl_h_sj(){ 
		$id=trim($this->input->get('id'));
		$q=$this->db->get_where('tbl_h_sj',array('id'=>$id),1)->row();
		$data_t=$this->db->get_where('tbl_h_sj',array('sj_no'=>$q->sj_no))->result();			
		$qt= $this->db->get('tbl_title',1)->row();
		$qd=$this->db->query("SELECT * from tbl_master_document WHERE doc_name='SURAT JALAN' limit 1")->row();
		$qs=$this->db->get_where('tbl_master_supplier',array('supplier_code'=>$q->supplier_code),1)->row();
			$data1=array(
				'data_t'=>$data_t,
				'jumlah'=>count($data_t),
				'qt'=>$qt,
				'qd'=>$qd,
				'q'=>$q,
				'qs'=>$qs,
				);						
  		$this->load->view('print/print_sjsupypi',$data1);
					
    }
}