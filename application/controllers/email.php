<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Email extends CI_Controller {
    function __construct() {
        parent::__construct();
//            jika belum login redirect ke login
   
    }
    function send(){
    				
    	// 			$config = Array(
					//     'protocol' => 'smtp',
					//     'smtp_host' => 'ssl://mail.rahmansolusiindonesia.com',
					//     'smtp_port' => 465,
					//     'smtp_timeout' =>500,
					//     'smtp_user' => 'developer@rahmansolusiindonesia.com',
					//     'smtp_pass' => 'Rsideveloper2022',
					//     'mailtype'  => 'html', 
					//     'charset'   => 'iso-8859-1',
					//     'useragent' => 'Codeigniter',

					// );
					// $this->email->initialize($config);
					// $this->email->set_newline("\r\n");
					// $this->email->set_mailtype("html");
					
					$username= "developer@rahmansolusiindonesia.com";
					$password= "Rsideveloper2022";
					$toemail='prasetiaekon@gmail.com';
					$alias="Admin Log";	
				   $host="mail.rahmansolusiindonesia.com";
				   $port="26";				
				   //kirim notifications email
				   $config = array();
				   $config['charset'] = 'iso-8859-1';
				   $config['useragent'] ='Codeigniter'; //bebas sesuai keinginan kamu
				   $config['protocol']= "smtp";
				   $config['mailtype']= "html";
				   $config['smtp_host']=$host;
				   $config['smtp_port']=$port;
				   $config['starttls']= true;
				   $config['smtp_timeout']= "500";
				   $config['smtp_user']= $username;//isi dengan email kamu
				   $config['smtp_pass']= $password; // isi dengan password kamu
				   $config['crlf']="\r\n"; 
				   $config['newline']="\r\n"; 
				  
				   $config['wordwrap'] = TRUE;
				   //memanggil library email dan set konfigurasi untuk pengiriman email
				   
				   $this->email->initialize($config);
				   $this->email->set_newline("\r\n");
				   //konfigurasi pengiriman
				   $msg="<h3 style='color:#0E2D0B'>Thank You For Using WOORI SAUDARA Priority Internet Banking</h3> <br/>
						We would like to inform you, the transaction you've performed for the following period : <br/>
						<br/>
						<table border='0' cellspacing='2' cellpadding='1'>
						 <tr>
							<td>Transaction ID</td>
							<td>: ".$alias."</td>
						  </tr>
		
						  <tr>
							<td>Created By</td>
							<td>:  ".$username."</td>
						  </tr>
						</table>
						<br/>
						We hope this information is useful for you.<br/>
						<br/>
						<a href='http://sos.step.co.id/sos' target='_blank'>download</a>
						<br>
						If you have any question or comment regarding your transaction, 
						please contact us at cs@ibwoorisaudara.com <br/>
						<br/>
						Thank you.<br/>
						<br/>
						<h4 style='color:#0E2D0B'>Best regards,</b><br/>
						<br/>
						<br/>
						Admin Priority Service</h4>";

					   $this->email->from($username,$alias);
					   $this->email->to($toemail);
					   $this->email->subject('Notification Transaction');
					   $this->email->message($msg);
					   $this->email->attach('D:\xampp\htdocs\yos\assets\pdf\tes1.pdf');
					   $this->email->attach('D:\xampp\htdocs\yos\assets\pdf\tes2.pdf');
				   		  	if($this->email->send()) {
					            echo 'Email sent.';
					        }else{
					            show_error($this->email->print_debugger());
					        }
	
	}
	function ext(){
		
		$config['protocol'] = "smtp";
		$config['useragent'] = 'Codeigniter'; //bebas sesuai keinginan kamu
		$config['mailtype'] = "html";
		$config['smtp_host'] = 'mail.rahmansolusiindonesia.com';
		$config['smtp_port'] = 26;
		$config['smtp_timeout'] = 500;
		$config['smtp_user'] = 'developer@rahmansolusiindonesia.com'; //isi dengan email kamu
		$config['smtp_pass'] = 'Rsideveloper2022'; // isi dengan password kamu
		$config['charset'] = 'utf-8';
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";
		$config['wordwrap'] = true;
		//memanggil library email dan set konfigurasi untuk pengiriman email

		$this->email->initialize($config);
        $this->email->from('developer@rahmansolusiindonesia.com', 'Test email');
        $this->email->to('imamfaozi10@gmail.com');
        $this->email->subject('Contoh Kirim Email Dengan Codeigniter');
        $this->email->message('Contoh pesan yang dikirim dengan codeigniter');

          if($this->email->send()) {
               echo 'Email berhasil dikirim';
          }
          else {
               echo 'Email tidak berhasil dikirim';
               echo '<br />';
               
          }
          echo $this->email->print_debugger();

	}
	public function index()
    {
      // Konfigurasi email
        $config = Array(
					    'protocol' => 'smtp',
					    'smtp_host' => 'ssl://mail.rahmansolusiindonesia.com',
					    'smtp_port' => 465,
					    'smtp_timeout' =>500,
					    'smtp_user' => 'developer@rahmansolusiindonesia.com',
					    'smtp_pass' => 'Rsideveloper2022',
					    'mailtype'  => 'html', 
					    'charset'   => 'iso-8859-1',
					    'useragent' => 'Codeigniter',

					);
 
        // Load library email dan konfigurasinya
        $this->load->library('email', $config);
 
        // Email dan nama pengirim
        $this->email->from('developer@rahmansolusiindonesia.com', 'RSI');
 
        // Email penerima
        $this->email->to('grey.hanif@gmail.com'); // Ganti dengan email tujuan
 
 
        // Subject email
        $this->email->subject('Kirim Email dengan SMTP Gmail CodeIgniter | Nandakrisbianto.my.id');
 
        // Isi email
        $this->email->message("Ini adalah contoh email yang dikirim menggunakan SMTP Gmail pada CodeIgniter.<br><br> Klik <strong><a href='https://www.nandakrisbianto.my.id/2021/07/cara-kirim-pesan-email-menggunakan.html' target='_blank' rel='noopener'>disini</a></strong> untuk melihat tutorialnya.");
		$this->email->attach('D:\xampp\htdocs\yos\assets\img\welding.jpg');
        // Tampilkan pesan sukses atau error
        if ($this->email->send()) {
            echo 'Sukses! email berhasil dikirim.';
        } else {
            echo 'Error! email tidak dapat dikirim.';
        }
         echo $this->email->print_debugger();
    }
}