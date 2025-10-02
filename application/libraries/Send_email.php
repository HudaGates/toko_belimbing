<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Send_email
{

	public $ci;
	public $data;

	public function __construct()
	{
		$this->ci = &get_instance();
		$this->ci->load->library('email');
	}

	public function custom_email($user_data, $email_data, $template)
	{
		$conf = $this->ci->db->get_where('tbl_email_ordering', array('is_active' => 1))->row();
		$config = array(
			'charset' => 'utf-8',
			'useragent'=>'Codeigniter',
			'protocol' => 'smtp',
			'mailtype' => 'html',
			'smtp_host' => $conf->smtp_host,
			'smtp_port' => $conf->smtp_port,
			'smtp_timeout' => '500',
			'smtp_user' => $conf->email,
			'smtp_pass' => $conf->password_email,
			'newline' => "\r\n",
			'crlf' => "\r\n",
			'wordwrap' => TRUE
		);

		$this->ci->email->initialize($config);
		$this->ci->email->from($conf->email, $user_data['sender_name']);

		$this->ci->email->to($user_data['dest_email']);
		$this->ci->email->subject($user_data['subject']);

		$c['content'] = $this->ci->load->view("emails/{$template}", $email_data, true);
		$msg = $this->ci->load->view('emails/Layout', $c, true);
		$this->ci->email->message($msg);
		$ml=explode(',',$user_data['dest_email']);
		$cek=true;
		$jml=count($ml);
		for($i=1;$i<=$jml;$i++){
			if(!$this->ci->email->valid_email($ml[$i-1])){
				$cek=false;
			}
		}
		if ($cek==true)
		{
		    if(!$this->ci->email->send()){
	   	   		return 'true';
	   	   	   //return $this->ci->email->print_debugger();
	   	    }else{
	   	   		return 'true';
	   	    } 
		}
		else
		{
		        //return 'email is not valid'.$user_data['dest_email'];
				return 'true';
		}
		
	}
}