<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!');

class Ajax extends CI_Controller {
    
    public $database;
    
    function __construct(){
        parent::__construct();
        
        $api = $this->input->get('api');
        $query = $this->s_model->s_access($api); 
        $query = $query ? $query->row() : null;
        
        // FIX: Tangani jika sesi API habis/tidak valid saat AJAX Request
        if(empty($api) OR empty($query)) {
            if ($this->input->is_ajax_request()) {
                // Jika request dari DataTables, berikan respons JSON Error (bukan redirect HTML)
                header('Content-Type: application/json');
                echo json_encode(['error' => 'Session Expired or Invalid API. Please reload the page.']);
                exit; 
            } else {
                redirect('http://google.com');
            }
        }
    }

    /**
     * Helper Method untuk mengeksekusi EditorLib dengan aman
     * Memastikan tidak ada PHP Error/Warning yang bocor dan merusak JSON DataTables
     */
    private function _process_editor($method, $table, $api, $menuid = null) {
        // Matikan error reporting sementara di fungsi ini agar Notice/Warning PHP tidak tercetak
        error_reporting(0);
        
        $this->load->library('EditorLib');
        
        // Memaksa output header sebagai JSON Murni
        header('Content-Type: application/json; charset=utf-8');
        
        // Eksekusi library
        if ($menuid !== null) {
            $this->editorlib->$method($_POST, $table, $api, $menuid);
        } else {
            $this->editorlib->$method($_POST, $api);
        }
    }

    public function sData() {   
        $api = $this->input->get('api');
        $table = $this->input->get('table');
        $menuid = $this->input->get('menuid');
        $this->_process_editor('sProcess', $table, $api, $menuid);
    }
    
    public function mData() {   
        $api = $this->input->get('api');
        $table = $this->input->get('table');
        $menuid = $this->input->get('menuid');
        $this->_process_editor('mProcess', $table, $api, $menuid);
    }
    
    public function bData() {   
        $api = $this->input->get('api');
        $table = $this->input->get('table');
        $menuid = $this->input->get('menuid');
        $this->_process_editor('bProcess', $table, $api, $menuid);
    }
    
    public function mqcData() {   
        $api = $this->input->get('api');
        $table = $this->input->get('table');
        $menuid = $this->input->get('menuid');
        $this->_process_editor('mqcProcess', $table, $api, $menuid);
    }
    
    public function plData() {   
        $api = $this->input->get('api');
        $table = $this->input->get('table');
        $menuid = $this->input->get('menuid');
        $this->_process_editor('planProcess', $table, $api, $menuid);
    }
    
    public function tData() {   
        $api = $this->input->get('api');
        $table = $this->input->get('table');
        $menuid = $this->input->get('menuid');
        $this->_process_editor('tProcess', $table, $api, $menuid);
    }
    
    public function pData() {   
        $api = $this->input->get('api');
        $table = $this->input->get('table');
        $this->_process_editor('pProcess', $table, $api);
    }
}