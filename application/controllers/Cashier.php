<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashier extends MY_Controller{
  public $shift;
  public $prod_date;
  public $user_level;
  public $pos_level;
  public $pos_name;
  public $user_area;
  public $idcard;
  public $nama;
  public $id_t;
  public $s_model;
  
    function __construct(){
        parent::__construct();
        
        // ==========================================
        // SUNTIKAN BAHASA UNTUK CONTROLLER CASHIER
        // ==========================================
        $bahasa = $this->session->userdata('site_lang') ? $this->session->userdata('site_lang') : 'indonesian';
        $this->lang->load('toko', $bahasa);
        // ==========================================

        $this->load->model('s_model');
        $this->id_t=$this->input->get('api');
        $query=$this->s_model->s_access($this->id_t)->row(); 
        
        if($query && $query->user_level=='Cashier'){            
          $this->nama=$query->nama;
          $this->user_level=$query->user_level;
          $this->user_area=$query->user_area;
          $this->idcard=$query->idcard;
        }else{
          redirect('action/scan?api='.$this->id_t);
        }
    }

function index(){
  $cartid = $this->input->get('cartid');
  $qhc=$this->db->query("SELECT * from tbl_history_sale where id= '". $cartid . "'")->result();
  if(count($qhc)>0){
    if(method_exists($this, 'openviewcart')){
      return $this->openviewcart();
    } else{
      show_error("Function openviewcart() belum dibuat di controller Cashier", 500);
    }
  }

  $qtc=$this->db->query("SELECT customer_name from tbl_master_customer order by customer_name asc")->result();
  $qt = $this->db->get('tbl_title', 1)->row();
  $qmp=$this->db->query("SELECT * from tbl_master_product group by product_name order by id asc")->result();
  
  // ===========================================================================
  // FIX: PERBAIKAN LOGIKA PEMBUATAN KERANJANG BARU
  // ===========================================================================
  $qhc=$this->db->query("SELECT * from tbl_history_sale where cashier= '". $this->nama . "' AND status = 'init'")->row();
  
  if(empty($qhc)){ 
    // JIKA KOSONG (Kasir baru ganti nama / belum ada keranjang), BUAT BARU!
    $data=array(
      'status'=>'init',
      'cart_source'=>'store',
      'cashier'=>$this->nama,
    ); 
    $this->db->insert('tbl_history_sale', $data);
    
    // Ambil ulang data keranjang yang baru saja dibuat
    $qhc=$this->db->query("SELECT * from tbl_history_sale where cashier= '". $this->nama . "' and status = 'init'")->row();
  }
  // ===========================================================================

  $data=array(
        'qt'=>$qt,
        'qmp'=>$qmp,
        'nama'=>$this->nama,
        'qhc'=>$qhc,
        'qtc'=>$qtc,
    ); 
  $this->load->view('user/cashier/home',$data);
}

function openviewcart(){
  $cartid = $this->input->get('cartid');
  $qtc=$this->db->query("SELECT customer_name from tbl_master_customer order by customer_name asc")->result();

  $qt = $this->db->get('tbl_title', 1)->row();
  $datapos=$this->db->query("SELECT * from tbl_master_posting group by pos_level order by id asc")->result();
  $qmp=$this->db->query("SELECT * from tbl_master_product group by product_name order by id asc")->result();
  $qhc=$this->db->query("SELECT * from tbl_history_sale where id= ". $cartid . "")->row();
 
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
  $qmp=$this->db->query("SELECT * from tbl_master_product where product_code like '%".trim($product) . "%' group by product_name order by id asc limit 12")->result();
  if(empty($qmp)){
    $qmp=$this->db->query("SELECT * from tbl_master_product where product_name like '%".trim($product) . "%' group by product_name order by id asc limit 12")->result();
  }
  $data=array(
        'qmp'=>$qmp
    ); 
  $this->load->view('user/cashier/catalog',$data);
}

function tagsearch(){
  $tag=$this->input->post('tag');
  $qmp=$this->db->query("SELECT * from tbl_master_product where category_id like '%".trim($tag) . "%' group by product_name order by id asc")->result();
 
  $data=array(
        'qmp'=>$qmp
    ); 
  $this->load->view('user/cashier/catalog',$data);
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
    $cartid = $this->input->post('cartid');
    $product_code = trim($this->input->post('sku'));
    $quantity_add = $this->input->post('quantity') ? intval($this->input->post('quantity')) : 1;

    $qmp = $this->db->query("SELECT product_code, product_name, price, discount, SUM(stock) as stock FROM tbl_master_product WHERE product_code = '".$this->db->escape_str($product_code)."' GROUP BY product_code")->row();
    
    $cd = $this->db->get_where('tbl_history_sale_detail', array('sale_id' => $cartid, 'product_code' => $product_code))->row();
    
    $qtc = $this->db->query("SELECT SUM(quantity) AS qty from tbl_history_sale_detail where product_code= '".$this->db->escape_str($product_code)."' AND sale_id=". intval($cartid))->row();
    $current_qty = empty($qtc->qty) ? 0 : intval($qtc->qty);

    $qts = $this->db->get_where('tbl_history_sale', array('id' => $cartid))->row();

    if(empty($qts) || $qts->status == 'done'){
        echo json_encode(array('success' => false, 'message' => 'TRANSAKSI TELAH SELESAI'));
    } else if(empty($qmp)){
        echo json_encode(array('success' => false, 'message' => 'SKU NOT FOUND'));
    } else if($qmp->stock <= 0){
        echo json_encode(array('success' => false, 'message' => 'STOCK HABIS')); 
    } else if(($current_qty + $quantity_add) > $qmp->stock){
        echo json_encode(array('success' => false, 'message' => 'STOCK TIDAK CUKUP (Sisa: '.($qmp->stock - $current_qty).')'));
    } else {
        
        $persen_diskon = empty($qmp->discount) ? 0 : floatval($qmp->discount);
        $potongan_rupiah = (floatval($qmp->price) * $persen_diskon) / 100;
        $harga_akhir = floatval($qmp->price) - $potongan_rupiah;

        if(!empty($cd)){
            $qty = intval($cd->quantity) + $quantity_add;
            $stbc = $quantity_add * $harga_akhir; 
            $st = intval($cd->sub_total) + $stbc;
            
            $data = array(
                'quantity' => $qty,
                'sub_total' => $st,
                'update_by' => $this->nama,
                'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
            );
            $this->db->update('tbl_history_sale_detail',  $data, array('id'=> $cd->id));
        } else {
            $data = array(
                'sale_id' => $cartid,
                'product_code' => $qmp->product_code,
                'product_name' => $qmp->product_name,
                'unit_price' => $harga_akhir, 
                'quantity' => $quantity_add,
                'sub_total' => ($harga_akhir * $quantity_add), 
                'update_by' => $this->nama,
                'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
            );
            $this->db->insert('tbl_history_sale_detail', $data);
        }
        echo json_encode(array('success' => true));
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
  
  // PERBAIKAN NAMA CUSTOMER
  if(empty($qtc)){
    if(trim($customer_name) == '') {
        $customer_name = "Umum";
    }
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
  
$qd = $this->db->update('tbl_history_sale',  $data, array('id'=> $cartid, ));
  if($qd){
    $data = array(
      'success' => true
    );

    $qmp=$this->db->query("SELECT * from tbl_history_sale_detail where sale_id= '". $cartid . "' ")->result();

    foreach($qmp as $key){
      $this->db->query("UPDATE tbl_master_product SET stock=stock-".$key->quantity." where product_code= '". $key->product_code . "' ");
    }
  } else {
    $data = array(
      'success' => false
    );
  }

  echo json_encode($data);
}

function historysale(){
  $qhs=$this->db->query("SELECT * from tbl_history_sale where status='done'  ORDER BY id DESC ")->result();
  $qhsd=$this->db->query("SELECT * from tbl_history_sale where status='draft' AND cart_source!='cust' ORDER BY id DESC ")->result();
  $data = array(
    'qhs' => $qhs,
    'qhsd' => $qhsd,
  );
  $this->load->view('user/cashier/dialog/historysale',$data);
}

function historysaledetail(){
  $saleid=$this->input->post('saleid');
  $qhs=$this->db->query("SELECT * from tbl_history_sale WHERE id= '". $saleid . "'")->row();
  $qhsd=$this->db->query("SELECT * FROM tbl_history_sale_detail WHERE sale_id= '". $saleid . "' ")->result();
  $data = array(
    'qhs' => $qhs,
    'qhsd' => $qhsd,
  );
  $this->load->view('user/cashier/dialog/historysaledetail',$data);
}

function historysaleist(){
  $qhs=$this->db->query("SELECT * from tbl_history_sale where status!='draft' AND cart_source='cust' AND status!='done' ORDER BY id DESC ")->result();
  $data = array(
    'qhs' => $qhs,
  );
  $this->load->view('user/cashier/dialog/historysaleist',$data);
}

function formcustomer(){
  $qmc=$this->db->query("SELECT * from tbl_master_customer")->result();
  $data = array(
    'qmc' => $qmc,
  );
  $this->load->view('user/cashier/dialog/customer',$data);
}

function detailcustomer(){
  $saleid=$this->input->post('saleid');
  $qhsd=$this->db->query("SELECT * FROM tbl_master_customer WHERE id= ". $saleid . " ")->result();
  $data = array(
    'qhsd' => $qhsd,
  );
  $this->load->view('user/cashier/dialog/detailcustomer',$data);
}

function formaddcustomer(){
  $data = array(
    'id_t'=>$this->id_t,
  );
  $this->load->view('user/cashier/form/formaddcustomer',$data);
}

function addcustomersubmit(){
  $customer_name=$this->input->post('customer_name');
  $gender=$this->input->post('gender');
  $phone=$this->input->post('phone');
  $address=$this->input->post('address');
  $city=$this->input->post('city');

  $data = array(
    'customer_name' => $customer_name,
    'gender' => $gender,
    'phone' => $phone,
    'address' => $address,
    'city' => $city,
    'update_by' => $this->nama,
    'update_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
  );
  
$this->db->insert('tbl_master_customer',  $data);
$data = array(
  'success' => true
);

  echo json_encode($data);
}

function truncate(){
  $this->db->query("TRUNCATE tbl_history_sale");
  $this->db->query("TRUNCATE tbl_history_sale_detail");
  $data = array(
    'success' => true
  );
    echo json_encode($data);
}

function logout(){
    redirect('action/logout?api='.$this->id_t);
  }
}