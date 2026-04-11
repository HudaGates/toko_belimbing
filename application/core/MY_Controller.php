<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        // 1. Pastikan Session aktif
        $this->load->library('session');
        
        // 2. Mengaktifkan fungsi lang() untuk HTML/View
        $this->load->helper('language');
        
        // 3. Cek session bahasa yang dipilih user
        $siteLang = $this->session->userdata('site_lang');
        
        if ($siteLang) {
            // Jika ada, muat kamus bahasa tersebut
            $this->lang->load('toko', $siteLang);
        } else {
            // Jika belum pernah diset, jadikan 'indonesian' sebagai default
            $this->lang->load('toko', 'indonesian'); 
        }
    }
}