<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{
	public $user_level;
	public $user_group;
	public $username;
	public $nama;
	public $shift;
	public $id_t;
	function __construct()
	{
		parent::__construct();
		$this->load->model('cart_model');
		$this->id_t = $this->input->get('api');
		$query = $this->s_model->s_access($this->id_t);
		$query = $query->row();
		if (!empty($query)) {
			$this->nama = $query->nama;
			$this->username = $query->username;
			$this->user_level = $query->user_level;
			$this->user_group = $query->user_group;
			$this->shift = $query->shift;
		} else {
			redirect('action/losttime');
		}
	}
	function index()
	{

		$data['data'] = $this->cart_model->get_all_produk();
		$this->load->view('v_cart', $data);
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

		$qtc=$this->db->query("SELECT SUM(quantity) AS qty from tbl_history_sale_detail where product_code= '". $product_code . "' AND sale_id=". $cartid . " ")->row();

		$qts = $this->db->get_where('tbl_history_sale', array('id' => $cartid))->row();
		if($qts->status=='done'){
		$data = array(
			'success' => false,
			'message' => 'TRANSAKSI TELAH SELESAI',
			
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
			if(!empty($cd)){
				$qty= intval($cd->quantity) + intval($quantity);
				$stbc = intval($quantity)* floatval($unit_price);
				$st = intval($cd->sub_total) + $stbc;
				
				$data = array(
					'quantity' => $qty,
					'sub_total' => $st,
					'update_by' => $this->nama,
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
					'update_by' => $this->nama,
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
				'message' => 'STOCK TIDAK CUKUP',
				
			  );
		
		echo json_encode($data);

		}
		

		
	}

	function get_amount(){
		$cartid = $this->input->post('cartid');
		$qsst = $this->db->query("SELECT SUM(sub_total) as amount from tbl_history_sale_detail where sale_id='". $cartid."'")->row();
		echo $qsst->amount;
	}

	function show_cart()
	{ //Fungsi untuk menampilkan Cart
		$cartid = $this->input->post('cartid');
		$qts = $this->db->get_where('tbl_history_sale', array('id' => $cartid))->row();
		$qsd = $this->db->get_where('tbl_history_sale_detail', array('sale_id' => $cartid))->result();
		$data = array(
			'qsd' => $qsd,
			'qts' => $qts
			
		);
		$this->load->view('user/cashier/cart',$data);

		
	}

	function submit_cart()
	{
		$rows = count($this->cart->contents());
		if ($rows == 0) {
			return 0;
		} else {
			// $pr_no = $this->helper_temp_pr();
			$pr_no = pr_no($this->username);
			foreach ($this->cart->contents() as $items) {
				$data_i[] = array(
					'pr_no' => $pr_no,
					'supplier_code' => $items['supplier_code'],
					'part_no' => $items['id'],
					'part_detail' => $items['name'] . ' ' . $items['dimensi'],
					'price' => $items['price'],
					'qty_pr' => $items['qty'],
					'qty_packing' => $items['qty_packing'],
					'total_price' => $items['price'] * $items['qty'],
					'stock' => $items['stock'],
					'min_stock' => $items['min_stock'],
					'qty_order' => $items['qty_order'],
					'satuan' => $items['satuan'],
				);
			}
			$remark = $this->input->post('remark');
			$qap = $this->db->get_where('tbl_master_approver', array('username' => $this->username, 'doc_approver' => 'PR_TOOLROOM'), 1)->row();
			$qseq = $this->db->get_where('tbl_master_approver', array('doc_approver' => 'PR_TOOLROOM', 'role_code' => $qap->role_code, 'order_approver !=' => 1))->result();

			foreach ($qseq as $seq) {
				if ($seq->title == 'SPVSHOP') {
					$spvshop_by = $seq->username;
				} elseif ($seq->title == 'MGRSHOP') {
					$mgrshop_by = $seq->username;
				} elseif ($seq->title == 'PICTL') {
					$pictl_by = $seq->username;
				} elseif ($seq->title == 'SPVTL') {
					$spvtl_by = $seq->username;
				} elseif ($seq->title == 'PICPUD') {
					$picpud_by = $seq->username;
				} elseif ($seq->title == 'SPVPUD') {
					$spvpud_by = $seq->username;
				} elseif ($seq->title == 'MGRPUD') {
					$mgrpud_by = $seq->username;
				}
			}

			$comment = array(
				array(
					'username' => $this->username,
					'judgement' => 'Approve',
					'comment' => 'Create PR #' . $pr_no,
					'datetime' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
				)
			);

			// $comment['data'] = array(
			// 	array(
			// 		'username' => $this->username,
			// 		'judgement' => 'Approve',
			// 		'comment' => 'Create PR',
			// 		'datetime' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
			// 	)
			// );



			$data_pr = array(
				'pr_no' => $pr_no,
				'pr_date' => gmdate('Y-m-d', time() + 60 * 60 * 7),
				'role_code' => $qap->role_code,
				'doc_approver' => $qap->doc_approver,
				'remark' => $remark,
				'status' => 'SUBMIT PR',
				'picshop_by' => $qap->username,
				'picshop_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
				'spvshop_by' => $spvshop_by,
				'spvshop_time' => null,
				'mgrshop_by' => $mgrshop_by,
				'mgrshop_time' => null,
				'pictl_by' => $pictl_by,
				'pictl_time' => null,
				'spvtl_by' => $spvtl_by,
				'spvtl_time' => null,
				'picpud_by' => $picpud_by,
				'picpud_time' => null,
				'spvpud_by' => $spvpud_by,
				'spvpud_time' => null,
				'mgrpud_by' => $mgrpud_by,
				'mgrpud_time' => null,
				'comment' => json_encode($comment),
				'approval' => null,
			);

			$qn = $this->db->get_where("tbl_temp_pr", array('username' => $this->username), 1)->row();
			$data_tmp = array(
				'username' => 'done',
				'pr_no' => $pr_no,
			);
			$this->db->update('tbl_temp_pr', $data_tmp, array('id' => $qn->id));


			$this->db->insert_batch('tbl_h_detailpr', $data_i);
			$this->db->insert('tbl_h_pr', $data_pr);
			$this->cart->destroy();
		}
	}

	function form_new_part()
	{
		$qap = $this->db->get_where('tbl_master_approver', array('username' => $this->username, 'doc_approver' => 'PR_NEWTL', 'order_approver' => 1), 1)->row();
		$qs = $this->db->get_where('tbl_satuan')->result();
		$data=array(
			'qs'=>$qs
		);
		if(!empty($qap)){
			$this->load->view('admin/form/form_newtl',$data);
		}else{
			echo "<div class='text-red text-center text-bold'>Need Otorisation Master Approver(PR_NEWTL)</div>";
		}

	}

	function submit_new_part()
	{

		$pr_no = pr_no($this->username);
		$remark = $this->input->post('remark');
		$part_name = $this->input->post('part_name');
		$dimensi = $this->input->post('dimensi');
		$satuan = $this->input->post('satuan');
		$qty_order = $this->input->post('quantity');
		$data_i = array(
			'pr_no' => $pr_no,
			'supplier_code' => null,
			'part_no' => '-',
			'part_detail' => $part_name . ' ' . $dimensi,
			'price' => null,
			'qty_pr' => $qty_order,
			'qty_packing' => null,
			'total_price' => null,
			'stock' => 0,
			'min_stock' => 0,
			'qty_order' => $qty_order,
			'satuan' => $satuan,
		);

		$naming = str_replace("/", "", $pr_no);
		//atachment
		$this->load->library('upload');
		$config['upload_path'] = './assets/tl';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size'] = '100000';
		$config['overwrite'] = TRUE;

		$config['file_name'] = $naming;
		$this->upload->initialize($config);
		// $file_up = $this->upload->data('filex');
		if (!$this->upload->do_upload('filex')) {
			echo strip_tags($this->upload->display_errors());
		} else {
			$atc = array(
				'filename' => $naming,
				'remark' => 'NEWTL',
				'filesize' => $this->upload->data('file_size'),
				'web_path' => './assets/tl/' . $this->upload->data('file_name'),
				'system_path'  => $this->upload->data('full_path'),
			);
			$this->db->insert('files', $atc);
		}


		$qap = $this->db->get_where('tbl_master_approver', array('username' => $this->username, 'doc_approver' => 'PR_NEWTL'), 1)->row();
		$qseq = $this->db->get_where('tbl_master_approver', array('doc_approver' => 'PR_NEWTL', 'role_code' => $qap->role_code, 'order_approver !=' => 1))->result();

		foreach ($qseq as $seq) {
			if ($seq->title == 'SPVSHOP') {
				$spvshop_by = $seq->username;
			} elseif ($seq->title == 'MGRSHOP') {
				$mgrshop_by = $seq->username;
			} elseif ($seq->title == 'PICTL') {
				$pictl_by = $seq->username;
			} elseif ($seq->title == 'SPVTL') {
				$spvtl_by = $seq->username;
			} elseif ($seq->title == 'PICPUD') {
				$picpud_by = $seq->username;
			} elseif ($seq->title == 'SPVPUD') {
				$spvpud_by = $seq->username;
			} elseif ($seq->title == 'MGRPUD') {
				$mgrpud_by = $seq->username;
			}
		}

		$comment = array(
			array(
				'username' => $this->username,
				'judgement' => 'Approve',
				'comment' => 'Create PR #' . $pr_no,
				'datetime' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
			)
		);

		$data_pr = array(
			'pr_no' => $pr_no,
			'pr_date' => gmdate('Y-m-d', time() + 60 * 60 * 7),
			'role_code' => $qap->role_code,
			'doc_approver' => $qap->doc_approver,
			'remark' => $remark,
			'status' => 'SUBMIT PR',
			'picshop_by' => $qap->username,
			'picshop_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7),
			'spvshop_by' => $spvshop_by,
			'spvshop_time' => null,
			'mgrshop_by' => $mgrshop_by,
			'mgrshop_time' => null,
			'pictl_by' => null,
			'pictl_time' => null,
			'spvtl_by' => null,
			'spvtl_time' => null,
			'picpud_by' => $picpud_by,
			'picpud_time' => null,
			'spvpud_by' => $spvpud_by,
			'spvpud_time' => null,
			'mgrpud_by' => $mgrpud_by,
			'mgrpud_time' => null,
			'comment' => json_encode($comment),
			'approval' => null,
		);

		// print_r($data_i);
		// die();

		$qn = $this->db->get_where("tbl_temp_pr", array('username' => $this->username), 1)->row();
		$data_tmp = array(
			'username' => 'done',
			'pr_no' => $pr_no,
		);
		$this->db->update('tbl_temp_pr', $data_tmp, array('id' => $qn->id));


		$this->db->insert('tbl_h_detailpr', $data_i);
		$this->db->insert('tbl_h_pr', $data_pr);

		$src = $this->db->get_where("files", array('filename' => $naming), 1)->row();
		$data = array(
			'success' => true,
			'item' => $data_i,
			'pr' => $data_pr,
			'src' => $src,
		);
		echo json_encode($data);


		// batas

	}

	function load_cart()
	{ //load data cart
		echo $this->show_cart();
	}

	function hapus_cart()
	{ //fungsi untuk menghapus item cart
		$data = array(
			'rowid' => $this->input->post('row_id'),
			'qty' => 0,
		);
		$this->cart->update($data);
		echo $this->show_cart();
	}
}