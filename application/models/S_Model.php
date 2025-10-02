<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!');
class S_Model extends CI_Model{
	 public $ip;
	 public function __construct(){
		parent::__construct();
		$this->load->library('user_agent');
		$this->ip=$this->input->ip_address(); 
	}
    
	 function s_access($id_t){
	    $this->db->select('a.*,a.id as iduser,c.*,d.*');
	    $this->db->from('tbl_user a');
	    $this->db->join('u_a c','a.idcard=c.idcard');
	    $this->db->join('files d','a.image=d.id','left');
	    $this->db->where('c.id_t',$id_t);
	    $this->db->limit(1);
	    $query=$this->db->get();
		return $query;
	 }
	public function s_auth($u, $p)
{
    $password_md5 = md5($p);
    $this->db->where('username', $u);
    $this->db->where('password', $password_md5);
    $query = $this->db->get('tbl_user');

    if ($query->num_rows() > 0) {
        $user_data = $query->row(); // Ambil data user

        // --- Semua proses sesi dilakukan di sini ---
        $id_t = sha1($user_data->id . gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7));
        $id_s = sha1($user_data->username . $user_data->password);

        $this->db->update("tbl_user", ['log_in' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7)], ['id' => $user_data->id]);
        $this->db->delete("u_a", ['id_s' => $id_s]);
        $this->db->delete("u_a", ['idcard' => $user_data->idcard]);

        $data_session = array(
            'ip_no'  => $this->ip, // Menggunakan properti $ip dari construct model
            'idcard' => $user_data->idcard,
            'id_s'   => $id_s,
            'id_t'   => $id_t,
        );
        $this->db->insert('u_a', $data_session);
        // --- Selesai proses sesi ---

        // Tambahkan token ke objek user sebelum dikembalikan
        $user_data->id_t = $id_t;

        return $user_data; // Kembalikan seluruh data user jika berhasil
    }

    return false; // Kembalikan false jika login gagal
}
	function s_end($id_t){
	    
		$data= $this->db->get_where('u_a',array('id_t'=>$id_t))->row(); 
		$data1=array(
			'log_out'=>gmdate('Y-m-d H:i:s',time()+60*60*7),
		);
		$this->db->update("tbl_user",$data1,array('SHA1(CONCAT(username,password))' =>$data->id_s));
		$this->db->delete("u_a",array('idcard'=>$data->idcard));
		$this->db->delete("u_a",array('id_s'=>$data->id_s));
		$query= $this->db->get_where('tbl_ip',array('ip_no'=>$this->ip));
		return $query;
	}
	function id_auth($p){
		$this->db->select('*');
	    $this->db->from('tbl_user');
	    $this->db->where(array('idcard'=>$p));
	    $this->db->limit(1);
	    $query=$this->db->get();
	    if($query->num_rows()>0){
	    	$data=$query->row();
	    	$id_t=$this->sha1->generate($data->id.gmdate('Y-m-d H:i:s',time()+60*60*7));
			$id_s=$this->sha1->generate($data->username.$data->password); 
	    	$data1=array(
				'log_in'=>gmdate('Y-m-d H:i:s',time()+60*60*7),
			);
			$this->db->update("tbl_user",$data1,array('idcard'=>$p));
			$this->db->delete("u_a",array('id_s'=>$id_s));
			$this->db->delete("u_a",array('idcard'=>$p));
			$data2=array(
				'ip_no'=>$this->ip,
				'idcard'=>$data->idcard,
				'id_s'=>$id_s,
				'id_t'=>$id_t,
			);
			$this->db->insert('u_a', $data2);
	    }					
		return $query;
	}
	function s_id($id_s){ 
		$this->db->select('*');
	    $this->db->from('u_a');
	    $this->db->where('id_s',$id_s);
	    $this->db->limit(1);
	    $query=$this->db->get();
		return $query;
	}
	function c_id($p){
		$this->db->select('*');
	    $this->db->from('tbl_user');
	    $this->db->where(array('idcard'=>$p));
	    $this->db->limit(1);
	    $query=$this->db->get();				
		return $query;
	}
	
	function s_ip($p){
		$this->db->select('*');
	    $this->db->from('tbl_ip');
	    $this->db->where(array('ip_no'=>$p));
	    $this->db->limit(1);
	    $query=$this->db->get();				
		return $query;
	}
}