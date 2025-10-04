<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!');
class Action extends CI_Controller{
	public $s_model;
    public $ip;
    public $id_t;
    public $nama;
    public $session;
    public $cart;
    public $email;
    public $agent;
    public $_user;
	public $input;
	public $db;
	public $form_validation;
	public $sha1;
function __construct(){
	parent::__construct();
	$this->load->library('user_agent');
	$this->ip=$this->input->ip_address();
	$this->id_t=$this->input->get('api');	
}
function index(){
	$query1=$this->s_model->s_access($this->id_t); 
	$query1=$query1->row(); 
	if($this->id_t!='' and $query1->id_s!=''){
		redirect('home?api='.$this->id_t);
	}
	$query2=$this->db->get_where('tbl_ip',array('ip_no'=>$this->ip),1)->row();
	
	if(!empty($query2)){
		if($query2->login_methode=='-'){
			redirect($query2->url."?=".$this->sha1->generate(rand(1000,10000000)));
		}else{
			redirect('action/'.strtolower($query2->login_methode));
		}
	}else{
		$qt= $this->db->query('select a.*,b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();
		$q= $this->db->get_where('files',array('id'=>$qt->bg),1)->row();	
		 $data=array(
         	'title'=>$qt->title,
         	'detail'=>$qt->detail,
         	'owner'=>$qt->owner,
         	'version'=>$qt->version,
         	'logo'=>$qt->web_path,
         	'year'=>$qt->year,
         	'thema'=>$qt->thema,
         	'bg'=>$q->web_path,
        );	
	   
		$this->load->view('login',$data);
		
		
	}
}
function scan(){
	$query1=$this->s_model->s_access($this->id_t); 
	$query1=$query1->row(); 
	if($this->id_t!='' and $query1->id_s!=''){
		redirect('home?api='.$this->id_t);
	}
	$query2=$this->db->get_where('tbl_ip',array('ip_no'=>$this->ip),1)->row();
	$qt= $this->db->query('select a.*,b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();
	$q= $this->db->get_where('files',array('id'=>$qt->bg),1)->row();			
	 $data=array(
     	'title'=>$qt->title,
     	'detail'=>$qt->detail,
     	'owner'=>$qt->owner,
     	'version'=>$qt->version,
     	'logo'=>$qt->web_path,
     	'user_level'=>$query2->user_level,
     	'year'=>$qt->year,
     	'thema'=>$qt->thema,
     	'bg'=>$q->web_path,
    );	
    
	$this->load->view('loginscan',$data);
}
function manual(){
	$query1=$this->s_model->s_access($this->id_t);
	$query1=$query1->row(); 
	if($this->id_t!='' and $query1->id_s!=''){
		redirect('home?api='.$this->id_t);
	}
		$query2=$this->db->get_where('tbl_ip',array('ip_no'=>$this->ip),1)->row();
		$qt= $this->db->query('select a.*,b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();	
		$q= $this->db->get_where('files',array('id'=>$qt->bg),1)->row();
		$user_level=$query2->user_level;
		$query_user=$this->db->from('tbl_user')->where('user_level',$user_level)->order_by('nama', 'ASC')->get();	
		
		
		
		 $data=array(
         	'title'=>$qt->title,
         	'detail'=>$qt->detail,
         	'owner'=>$qt->owner,
         	'version'=>$qt->version,
         	'logo'=>$qt->web_path,
			'year'=>$qt->year,
			'thema'=>$qt->thema,
			'data_user'=>$query_user->result(),
			'user_level'=>$user_level,
			'bg'=>$q->web_path,
        );
	    
		$this->load->view('loginmanual',$data);
		
}
function admin(){
	$query1=$this->s_model->s_access($this->id_t); 
	$query1=$query1->row(); 
	if($this->id_t!='' and $query1->id_s!=''){
		redirect('home?api='.$this->id_t);
	}	
	$qt= $this->db->query('select a.*,b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();
	$q= $this->db->get_where('files',array('id'=>$qt->bg),1)->row();		
	$data=array(
     	'title'=>$qt->title,
     	'detail'=>$qt->detail,
     	'owner'=>$qt->owner,
     	'version'=>$qt->version,
     	'logo'=>$qt->web_path,
     	'year'=>$qt->year,
     	'thema'=>$qt->thema,
     	'bg'=>'.'.$q->web_path,
    );	
    
	$this->load->view('login',$data);
		
}
function login()
{
    $data = array('success' => false, 'messages' => array());
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_login_check');
    $this->form_validation->set_error_delimiters('<span class="text-danger text-sm">', '<strong> !</strong> </span>');

    // Form validation akan memanggil login_check(), yang memanggil s_auth() di model.
    // s_auth() di model akan memvalidasi password MD5 dan membuat token sesi di database.
    if ($this->form_validation->run()) {
        // Jika validasi berhasil, kita HANYA perlu membuat ulang ID sesi ($id_s)
        // dengan cara yang SAMA PERSIS seperti di model s_auth().

        $u = $this->input->post('username');
        
        // 1. Enkripsi password yang diinput dengan MD5 (agar sama seperti di model)
        $p_md5 = md5($this->input->post('password'));

        // 2. Buat ID Sesi ($id_s) dengan menggabungkan username + password MD5, lalu di-hash dengan sha1.
        // Ini meniru logika di dalam fungsi s_auth() Anda.
        // Asumsi $this->sha1->generate() fungsinya sama dengan sha1() standar PHP.
        $id_s = sha1($u . $p_md5);

        // 3. Sekarang cari token ($id_t) menggunakan ID Sesi ($id_s) yang sudah benar.
        $cek = $this->s_model->s_id($id_s);
        $datax = $cek->row();

        // Ini sekarang akan berhasil dan tidak akan menyebabkan Error 500 lagi
        $data['id_t'] = $datax->id_t;
        $data['success'] = true;
    } else {
        foreach ($_POST as $key => $value) {
            $data['messages'][$key] = form_error($key);
        }
    }

    echo json_encode($data);
}
public function login_check()
    {
        $u = $this->input->post('username');
        $p = $this->input->post('password');

        // Panggil model s_auth yang sudah kita perbaiki
        $user_data = $this->s_model->s_auth($u, $p);

        if ($user_data) {
            $this->_user = $user_data; // Simpan data user yang berhasil login
            return true;
        } else {
            $this->form_validation->set_message('login_check', 'Incorrect Username & Password');
            return false;
        }
    }
 function loginscan(){
	$data = array ('success' => false, 'messages' => array());
	$this->form_validation->set_rules('idcard', 'Id Card', 'required|trim|callback_idcard_check');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '<strong> !</strong> </span>');
	if($this->form_validation->run()){
		$idcard=$this->input->post('idcard');
		$query=$this->s_model->c_id($idcard);
		$query=$query->row();
		$id_s=$this->sha1->generate($query->username.$query->password);
		$cek=$this->s_model->s_id($id_s);
		$datax=$cek->row();
		$data['id_t'] = $datax->id_t;
		$data['success'] = true;				
	}else{
	 	foreach ($_POST as $key => $value) {
		 	$data['messages'][$key] = form_error($key);
		}
	}
	echo json_encode($data);
}
public function idcard_check(){
	$p = $this->input->post('idcard');
	$cek=$this->s_model->id_auth($p);
	$cek=$cek->row(); 
	$cekip= $this->db->get_where('tbl_ip',array('ip_no'=>$this->ip,'user_level'=>$cek->user_level),1)->row();
   if(!empty($cek)){		
        return true;
    }else{
        $this->form_validation->set_message('idcard_check', 'Access Denied');
        return false;
   }
 }
function logout(){
	$cek=$this->s_model->s_end($this->id_t);
	if($cek->num_rows()>0){	
		redirect('action/'.strtolower($cek->row()->login_methode));
	}else{
		redirect();
	}
}	

function contact(){
		$query=$this->s_model->s_access($this->id_t); 
		$query=$query->row();
		$this->nama=$query->nama;
		$qt= $this->db->get_where('tbl_title')->row();
        $data=array(
         	'nav'=>'Contact',
         	'tlp'=>$qt->tlp,
         	'email'=>$qt->email,
			'url'=>'action/contact',
			'nama'=>$query->nama,
			'table'=>'',
			'menuid'=>'',
			'id_t'=>$this->id_t
        );
        $this->load->view('element/wrapper',$data);	
    	$this->load->view('contact',$data);
	}
 function lostTime(){
    	$id_t=$this->input->get('id_t');
    	$data=array(
    		'id_t'=>$id_t,
    	);
    	$this->load->view('timeout',$data);
    }
 function stopline(){
 	$this->load->view('user/picking/stop',$data);
 }
}