<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Perhatikan, ini tetap extends CI_Controller saja
class Language extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function switch_lang($language = "") {
        // Validasi input
        $language = ($language != "") ? $language : "indonesian";
        
        // Simpan ke Session
        $this->session->set_userdata('site_lang', $language);
        
        // Redirect kembali ke halaman sebelumnya
        redirect($_SERVER['HTTP_REFERER']);
    }
}