<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller{
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
  $phone=$this->input->get('p');

 
  $qt = $this->db->get('tbl_title', 1)->row();

    //  $cartid=$this->db->query("SELECT UUID() as cartid")->row();
    
    $cartid=0;
    $total_cart=0;
    if($phone!=''){
      $qhc=$this->db->query("SELECT * from tbl_history_sale where phone= '". $phone . "' and status = 'init'")->row();
      
      
      if(count($qhc)==0){
        // $cartid=$this->db->query("SELECT UUID() as cartid")->row();
        $qmc=$this->db->query("SELECT * from tbl_master_customer where phone= '". $phone . "' ")->row();
        $customer_id = 0;
        $customer_name = '';
        // $phone = '';
        if(count($qmc)<1){
          $customer_id = 0;
          $customer_name = '';
          $phone = $phone;
        }else{
          $customer_id = $qmc->id;
        $customer_name = $qmc->customer_name;
        $phone = $qmc->phone;
        }
        
        $data=array(
          'customer_id'=>$customer_id,
          'customer_name'=>$customer_name,
          'status'=>'init',
          'cart_source'=>'cust',
          'phone'=> $phone,
        ); 
        $this->db->insert('tbl_history_sale', $data);
        $qhc=$this->db->query("SELECT * from tbl_history_sale where phone= '". $phone . "' and status != 'done' order by id DESC")->row();
        $cartid=$qhc->id;
        $qsdc=$this->db->query("SELECT count(id) AS count from tbl_history_sale_detail where sale_id=". $qhc->id )->row();
        $total_cart=$qsdc->count;
      }else{
        
        $qhc=$this->db->query("SELECT * from tbl_history_sale where phone= '". $phone . "' and status != 'done' order by id DESC")->row();
        $cartid=$qhc->id;
        $qsdc=$this->db->query("SELECT count(id) AS count from tbl_history_sale_detail where sale_id=". $qhc->id )->row();
        $total_cart=$qsdc->count;
      }
    }else{
      $cartid=0;
    }
    

    
    
//  print_r($qr);
  $data=array(
        'qt'=>$qt,
        'phone'=>$phone,
        // 'qhc'=>$qhc,
        'cartid'=>$cartid,
        'total_cart'=>$total_cart,
    ); 
  $this->load->view('order/home',$data);
}


function add_to_cart()
{ //fungsi Add To Cart

  $cartid = $this->input->post('cartid');
  $quantity = $this->input->post('quantity');
  $product_code = $this->input->post('product_code');
  $unit_price = $this->input->post('price');
  // $min_stock = $this->input->post('min_stock');
  // $order = $min_stock - $stock;
  // $qty_order = $order + $qty_pr;
  // if($qty_order<0){
  // 	$qty_order=0;
  // }
  // var_dump($product_code);
  $cd = $this->db->get_where('tbl_history_sale_detail', array('sale_id' =>$cartid, 'product_code' =>$product_code))->row();
  $qmp = $this->db->get_where('tbl_master_product', array('product_code' => $product_code))->row();
  $qtc=$this->db->query("SELECT SUM(quantity) AS qty from tbl_history_sale_detail where product_code= '". $product_code . "' AND sale_id=". $cartid . " ")->row();

  if($cartid=="" OR $cartid==0){
    $data = array(
      'success' => false,
      'message' => 'NOMOR HP BELUM DIINPUT',
      
    );
    echo json_encode($data);
  }else if($quantity > $qmp->stock ){
    $data = array(
      'success' => false,
      'message' => 'STOCK HABIS',
      
    );
    echo json_encode($data);
  }else if($qtc->qty >= $qmp->stock){
    $data = array(
      'success' => false,
      'message' => 'STOCK TIDAK CUKUP',
      
    );
    echo json_encode($data);
    }else if($qmp->stock <= 0){
    $data = array(
      'success' => false,
      'message' => 'STOCK HABIS',
      
    ); 
    echo json_encode($data);
    }else{
      $qhc = $this->db->get_where('tbl_history_sale', array('id' =>$cartid))->row();
    if(!empty($cd)){
      $qty= intval($cd->quantity) + intval($quantity);
      $stbc = intval($quantity)* floatval($unit_price);
      $st = intval($cd->sub_total) + $stbc;
      
      $data = array(
        'quantity' => $qty,
        'sub_total' => $st,
        'update_by' => $qhc->phone,
        'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
  
      );
      // var_dump($cd->quantity);
      $this->db->update('tbl_history_sale_detail',  $data, array('id'=> $cd->id, ));
    }else{
      $data = array(
        'sale_id' => $cartid,
        'product_code' => $this->input->post('product_code'),
        'product_name' => $this->input->post('product_name'),
        'unit_price' => $unit_price,
        'quantity' => $quantity,
        'sub_total' =>  intval($quantity)* floatval($unit_price),
        'update_by' => $qhc->phone,
        'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
      );
    
      $this->db->insert('tbl_history_sale_detail', $data);
    }
    

    // $qsd = $this->db->get_where('tbl_history_sale_detail', array('sale_id' => $cartid))->result();
    // $data = array(
    // 	'qsd' => $qsd,
    // 	// 'qsst' => $qsst
      
    // );
    // $this->load->view('user/cashier/cart',$data);

    $data = array(
      'success' => true,
      'message' => 'SUKSES MENAMBAHKAN ITEM',
      
      );
  
  echo json_encode($data);

  }
  

  
}

function openviewcart(){
  $cartid = $this->input->get('cartid');
// var_dump($cartid);
// die();
  $qtc=$this->db->query("SELECT customer_name from tbl_master_customer order by customer_name asc")->result();

  $qt = $this->db->get('tbl_title', 1)->row();
  $datapos=$this->db->query("SELECT * from tbl_master_posting group by pos_level order by id asc")->result();
  $qmp=$this->db->query("SELECT * from tbl_master_product group by product_name order by id asc")->result();
  //  $cartid=$this->db->query("SELECT UUID() as cartid")->row();
  $qhc=$this->db->query("SELECT * from tbl_history_sale where id= ". $cartid . "")->row();
 
//  print_r($qhc);
  $data=array(
        'datapos'=>$datapos,
        'qt'=>$qt,
        'qmp'=>$qmp,
        'nama'=>$this->nama,
        'qhc'=>$qhc,
        'qtc'=>$qtc,
    ); 
  $this->load->view('user/cashier/home',$data);
}

function search(){
  $product=$this->input->post('product');
  // var_dump($product);
  // die();
  $qmp=$this->db->query("SELECT * from tbl_master_product where product_code like '%".trim($product) . "%' group by product_name order by id asc limit 12")->result();
  if(empty($qmp)){
    $qmp=$this->db->query("SELECT * from tbl_master_product where product_name like '%".trim($product) . "%' group by product_name order by id asc limit 12")->result();
  }
  $data=array(
        'qmp'=>$qmp
    ); 
  $this->load->view('order/cataloghp',$data);
}
function tagsearch(){
  $tag=$this->input->post('tag');
  // var_dump($product);
  // die();
  $qmp=$this->db->query("SELECT * from tbl_master_product where category_id like '%".trim($tag) . "%' group by product_name order by id asc")->result();
 
  $data=array(
        'qmp'=>$qmp
    ); 
  $this->load->view('user/cashier/cataloghp',$data);
}

function tag(){
  $qcp=$this->db->query("SELECT category_id from tbl_master_product group by category_id order by category_id asc")->result();
  $data=array(
        'qcp'=>$qcp
    ); 
  $this->load->view('user/cashier/tag',$data);
}

function print_receipt(){
  $cartid = $this->input->get('cartid');
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

function additem(){
  $cartid=$this->input->post('cartid');
  $product_code= trim($this->input->post('sku'));
  
  $qmp = $this->db->get_where('tbl_master_product', array('product_code' => $product_code))->row();
  $cd = $this->db->get_where('tbl_history_sale_detail', array('sale_id' =>$cartid, 'product_code' =>$product_code))->row();
  $qtc=$this->db->query("SELECT SUM(quantity) AS qty from tbl_history_sale_detail where product_code= '". $product_code . "' AND sale_id=". $cartid . " ")->row();
		// var_dump($qtc->qty > $qmp->stock);
    // die();
  if(empty($qmp)){
    $data = array(
      'success' => false,
      'message' => 'SKU NOT FOUND',
      
    );
    echo json_encode($data);
  }else if($qtc->qty >= $qmp->stock){
    $data = array(
      'success' => false,
      'message' => 'STOCK TIDAK CUKUP',
      
    );
    echo json_encode($data);
  }else if($qmp->stock <= 0){
    $data = array(
      'success' => false,
      'message' => 'STOCK HABIS',
      
    ); 
    echo json_encode($data);
  }
  
  else{
    if(!empty($cd)){
			$qty= intval($cd->quantity) + 1;
			$stbc = 1* floatval($qmp->price);
			$st = intval($cd->sub_total) + $stbc;
			
			$data = array(
				'quantity' => $qty,
				'sub_total' => $st,
        'update_by' => $this->nama,
        'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
	
			);
			// var_dump($cd->quantity);
			$qd = $this->db->update('tbl_history_sale_detail',  $data, array('id'=> $cd->id, ));
		}else{
			$data = array(
				'sale_id' => $cartid,
				'product_code' => $qmp->product_code,
				'product_name' =>  $qmp->product_name,
				'unit_price' => $qmp->price,
				'quantity' => 1,
				'sub_total' =>  $qmp->price,
        'update_by' => $this->nama,
        'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
			);
		
			$qd = $this->db->insert('tbl_history_sale_detail', $data);
		}

    if($qd){
      $data = array(
        'success' => true
        
      );
    } else {
      $data = array(
        'success' => false
        
      );
    }
  
    echo json_encode($data);
  }

		
}



function formeditdetail(){
  $id=$this->input->post('id');
  
  $qd = $this->db->get_where('tbl_history_sale_detail', array('id' =>$id))->row();
  $qmp = $this->db->get_where('tbl_master_product', array('product_code' => $qd->product_code))->row();
  $data = array(
    'qd' => $qd,
    'qmp' => $qmp,
    
  );
  $this->load->view('user/cashier/form/formeditdetail',$data);
}



function edititem(){
  $id=$this->input->post('id');
  $quantity=$this->input->post('qty');
  


  $cd = $this->db->get_where('tbl_history_sale_detail', array('id' =>$id))->row();
  $qty= intval($quantity);
			$stbc = intval($quantity)* floatval($cd->unit_price);
			$st =  $stbc;
			
			$data = array(
				'quantity' => $qty,
				'sub_total' => $st,
	
			);
			// var_dump($cd->quantity);
			
  $qd = $this->db->update('tbl_history_sale_detail',  $data, array('id'=> $cd->id, ));
  if($qd){
    $data = array(
      'success' => true
      
    );
  } else {
    $data = array(
      'success' => false
      
    );
  }

  echo json_encode($data);
}

function removeitem(){
  $id=$this->input->post('id');

  
  $qd = $this->db->delete('tbl_history_sale_detail', array('id' => $id));
  if($qd){
    $data = array(
      'success' => true
      
    );
  } else {
    $data = array(
      'success' => false
      
    );
  }

  echo json_encode($data);
}


function clearcart(){
  $cartid=$this->input->post('cartid');

  
  $qd = $this->db->delete('tbl_history_sale_detail', array('sale_id' => $cartid));
  if($qd){
    $data = array(
      'success' => true
      
    );
  } else {
    $data = array(
      'success' => false
      
    );
  }

  echo json_encode($data);
}


function skipcart(){
  $cartid=$this->input->post('cartid');

  $data = array(
    'status' => 'draft',
    'update_by' => $this->nama,
    'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
  );
  // var_dump($cd->quantity);
  
$qd = $this->db->update('tbl_history_sale',  $data, array('id'=> $cartid, ));
  if($qd){
    $data = array(
      'success' => true
      
    );
// buat cart baru ketika sukses
    $data1=array(
      'status'=>'init',
      'cart_source'=>'store',
      'cashier'=>$this->nama,
    ); 
    $this->db->insert('tbl_history_sale', $data1);

  } else {
    $data = array(
      'success' => false
    );
  }

  echo json_encode($data);
}

function formpay(){
  $cartid=$this->input->post('cartid');
  $amount=$this->input->post('amount');
  $customer_name=$this->input->post('customer_name');
  
  $qd = $this->db->get_where('tbl_history_sale', array('id' =>$cartid))->row();
  $data = array(
    'qd' => $qd,
    'amount' => $amount,
    'customer_name' => $customer_name,
    'cartid' => $cartid,
    
  );
  $this->load->view('user/cashier/form/formpay',$data);
}

function paysubmit(){
  $cartid=$this->input->post('cartid');
  $customer_name=$this->input->post('customer_name');
  $amount=$this->input->post('amount');
  $pay_amount=$this->input->post('pay_amount');

  $qtc=$this->db->query("SELECT * from tbl_master_customer where customer_name= '". $customer_name . "' ")->row();
  if(empty($qtc)){
    $customer_name = "umum";
    $customer_id = 0;
  }else{
    $customer_id = $qtc->id;
  }


  $data = array(
    'customer_id' => $customer_id,
    'customer_name' => $customer_name,
    'total_amount' => $amount,
    'pay_amount' => $pay_amount,
    'payment_type' => 'cash',
    'status' => 'done',
    'update_by' => $this->nama,
    'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
  );
  // var_dump($cd->quantity);
  
$qd = $this->db->update('tbl_history_sale',  $data, array('id'=> $cartid, ));
  if($qd){
    $data = array(
      'success' => true
      
    );

    $qmp=$this->db->query("SELECT * from tbl_history_sale_detail where sale_id= '". $cartid . "' ")->result();

    foreach($qmp as $key){
      $this->db->query("UPDATE tbl_master_product SET stock=stock-".$key->quantity." where product_code= '". $key->product_code . "' ");
    }

// buat cart baru ketika sukses
    $data1=array(
      'status'=>'init',
      'cart_source'=>'store',
      'cashier'=>$this->nama,
    ); 
    $this->db->insert('tbl_history_sale', $data1);

  } else {
    $data = array(
      'success' => false
      
    );
  }

  echo json_encode($data);
}

function historysalehp(){
  $phone=$this->input->post('phone');
  $qhs=$this->db->query("SELECT * from tbl_history_sale where phone='".$phone."' AND status!='init' ORDER BY id DESC ")->result();
  // $qhsd=$this->db->query("SELECT * from tbl_history_sale where status='draft' ORDER BY id DESC ")->result();
  $data = array(
    'qhs' => $qhs,
    // 'qhsd' => $qhsd,
  );
  $this->load->view('user/cashier/dialog/historysalehp',$data);
}

function historysaledetail(){
  $saleid=$this->input->get('saleid');
  $qhs=$this->db->query("SELECT * from tbl_history_sale WHERE id= ". $saleid . "")->row();
  $qhsd=$this->db->query("SELECT * FROM tbl_history_sale_detail WHERE sale_id= '". $saleid . "' ")->result();
  // var_dump($saleid);
  $data = array(
    'qhs' => $qhs,
    'qhsd' => $qhsd,
    
  );
  $this->load->view('user/cashier/dialog/historysaledetailhp',$data);
}

function formcustomer(){
 
  $qmc=$this->db->query("SELECT * from tbl_master_customer")->result();

  $data = array(
    'qmc' => $qmc,
  );
  $this->load->view('user/cashier/dialog/customer',$data);
}

function formaddcustomer(){
  $data = array(
    'id_t'=>$this->id_t,
  );
  $this->load->view('user/cashier/form/formaddcustomer',$data);
}


function addcustomersubmit(){
  // $cartid=$this->input->post('cartid');
  $customer_name=$this->input->post('customer_name');
  $gender=$this->input->post('gender');
  $phone=$this->input->post('phone');
  $address=$this->input->post('address');
  $city=$this->input->post('city');

  // $qtc=$this->db->query("SELECT * from tbl_master_customer where customer_name= '". $customer_name . "' ")->row();
  // if(empty($qtc)){
  //   $customer_name = "umum";
  //   $customer_id = 0;
  // }else{
  //   $customer_id = $qtc->id;
  // }


  $data = array(
    // 'customer_id' => $customer_id,
    'customer_name' => $customer_name,
    'gender' => $gender,
    'phone' => $phone,
    'address' => $address,
    'city' => $city,
    'update_by' => $this->nama,
    'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
  );
  // var_dump($cd->quantity);
  
$this->db->insert('tbl_master_customer',  $data);
$data = array(
  'success' => true
  
);

  echo json_encode($data);
}

function dialogphone(){
  $phone=$this->input->get('p');
  
  // $qd = $this->db->get_where('tbl_history_sale_detail', array('id' =>$id))->row();
  // $qmp = $this->db->get_where('tbl_master_product', array('product_code' => $qd->product_code))->row();
  $data = array(
    'phone' => $phone,
    // 'qmp' => $qmp,
    
  );
  $this->load->view('user/cashier/form/dialogphone',$data);
}


function logout(){
    redirect('action/logout?api='.$this->id_t);
  }

}