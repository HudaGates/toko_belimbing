<?php if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem..!');

class Action extends CI_Controller {
    
    // Properti class
    public $ip;
    public $id_t;
    
    function __construct() {
        parent::__construct();
        
        // Memastikan library dan model terload dengan benar
        $this->load->library(['user_agent', 'form_validation', 'session']);
        $this->load->model('s_model'); // Pastikan nama model sesuai
        
        // Inisialisasi data dasar
        $this->ip = $this->input->ip_address();
        $this->id_t = $this->input->get('api');
    }

    /**
     * Private helper untuk cek session aktif
     * Mencegah pengulangan code di index, scan, manual, dll.
     */
    private function _check_already_logged_in() {
        if ($this->id_t != '') {
            $query = $this->s_model->s_access($this->id_t);
            if ($query && $query->num_rows() > 0) {
                $row = $query->row();
                if (!empty($row->id_s)) {
                    redirect('home?api=' . $this->id_t);
                }
            }
        }
    }

    function index() {
        $this->_check_already_logged_in();

        $query2 = $this->db->get_where('tbl_ip', array('ip_no' => $this->ip), 1)->row();
        
        if (!empty($query2)) {
            if ($query2->login_methode == '-') {
                // Gunakan helper sha1 atau library jika tersedia
                $random_hash = sha1(rand(1000, 10000000));
                redirect($query2->url . "?=" . $random_hash);
            } else {
                redirect('action/' . strtolower($query2->login_methode));
            }
        } else {
            // Menggunakan Query Builder untuk kejelasan
            $this->db->select('a.*, b.web_path');
            $this->db->from('tbl_title a');
            $this->db->join('files b', 'a.image = b.id', 'left');
            $qt = $this->db->get()->row();

            $q = $this->db->get_where('files', array('id' => $qt->bg), 1)->row();
            
            $data = array(
                'title'   => $qt->title,
                'detail'  => $qt->detail,
                'owner'   => $qt->owner,
                'version' => $qt->version,
                'logo'    => $qt->web_path,
                'year'    => $qt->year,
                'thema'   => $qt->thema,
                'bg'      => $q->web_path,
            );
            
            $this->load->view('login', $data);
        }
    }

    function scan() {
        $this->_check_already_logged_in();

        $query2 = $this->db->get_where('tbl_ip', array('ip_no' => $this->ip), 1)->row();
        $qt = $this->db->query('select a.*, b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();
        $q = $this->db->get_where('files', array('id' => $qt->bg), 1)->row();
        
        $data = array(
            'title'      => $qt->title,
            'detail'     => $qt->detail,
            'owner'      => $qt->owner,
            'version'    => $qt->version,
            'logo'       => $qt->web_path,
            'user_level' => ($query2) ? $query2->user_level : 'Guest',
            'year'       => $qt->year,
            'thema'      => $qt->thema,
            'bg'         => $q->web_path,
        );
        
        $this->load->view('loginscan', $data);
    }

    function manual() {
        $this->_check_already_logged_in();

        $query2 = $this->db->get_where('tbl_ip', array('ip_no' => $this->ip), 1)->row();
        $user_level = ($query2) ? $query2->user_level : '';
        
        $qt = $this->db->query('select a.*, b.web_path from tbl_title a left join files b on(a.image=b.id) limit 1')->row();
        $q = $this->db->get_where('files', array('id' => $qt->bg), 1)->row();
        
        $query_user = $this->db->from('tbl_user')
                               ->where('user_level', $user_level)
                               ->order_by('nama', 'ASC')
                               ->get();

        $data = array(
            'title'      => $qt->title,
            'detail'     => $qt->detail,
            'owner'      => $qt->owner,
            'version'    => $qt->version,
            'logo'       => $qt->web_path,
            'year'       => $qt->year,
            'thema'      => $qt->thema,
            'data_user'  => $query_user->result(),
            'user_level' => $user_level,
            'bg'         => $q->web_path,
        );
        
        $this->load->view('loginmanual', $data);
    }

    function login() {
        $data = array('success' => false, 'messages' => array(), 'id_t' => '');
        
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_login_check');
        $this->form_validation->set_error_delimiters('<span class="text-danger text-sm">', '</span>');

        if ($this->form_validation->run()) {
            $u = $this->input->post('username');
            $p_md5 = md5($this->input->post('password'));

            // Konsistensi pembuatan ID Sesi
            $id_s = sha1($u . $p_md5);

            $cek = $this->s_model->s_id($id_s);
            if ($cek && $cek->num_rows() > 0) {
                $datax = $cek->row();
                $data['id_t'] = $datax->id_t;
                $data['success'] = true;
            } else {
                $data['messages']['auth'] = "Session failed to generate.";
            }
        } else {
            foreach ($_POST as $key => $value) {
                $data['messages'][$key] = form_error($key);
            }
        }

        // Set header agar output murni JSON
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function login_check() {
        $u = $this->input->post('username');
        $p = $this->input->post('password');

        $user_data = $this->s_model->s_auth($u, $p);

        if ($user_data) {
            $this->_user = $user_data;
            return true;
        } else {
            $this->form_validation->set_message('login_check', 'Incorrect Username & Password');
            return false;
        }
    }

    function loginscan() {
        $data = array('success' => false, 'messages' => array());
        
        $this->form_validation->set_rules('idcard', 'Id Card', 'required|trim|callback_idcard_check');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        
        if ($this->form_validation->run()) {
            $idcard = $this->input->post('idcard');
            $query = $this->s_model->c_id($idcard);
            
            if ($query && $query->num_rows() > 0) {
                $row = $query->row();
                // Pastikan logika hashing sama dengan fungsi login()
                $id_s = sha1($row->username . $row->password);
                
                $cek = $this->s_model->s_id($id_s);
                if ($cek && $cek->num_rows() > 0) {
                    $datax = $cek->row();
                    $data['id_t'] = $datax->id_t;
                    $data['success'] = true;
                }
            }
        } else {
            foreach ($_POST as $key => $value) {
                $data['messages'][$key] = form_error($key);
            }
        }
        
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function idcard_check() {
        $p = $this->input->post('idcard');
        $cek = $this->s_model->id_auth($p);
        
        if ($cek && $cek->num_rows() > 0) {
            return true;
        } else {
            $this->form_validation->set_message('idcard_check', 'Access Denied');
            return false;
        }
    }

    function logout() {
        $cek = $this->s_model->s_end($this->id_t);
        if ($cek && $cek->num_rows() > 0) {
            redirect('action/' . strtolower($cek->row()->login_methode));
        } else {
            redirect('action');
        }
    }

    function contact() {
        $query = $this->s_model->s_access($this->id_t);
        if (!$query || $query->num_rows() == 0) redirect('action');
        
        $row = $query->row();
        $qt = $this->db->get('tbl_title')->row();
        
        $data = array(
            'nav'     => 'Contact',
            'tlp'     => $qt->tlp,
            'email'   => $qt->email,
            'url'     => 'action/contact',
            'nama'    => $row->nama,
            'table'   => '',
            'menuid'  => '',
            'id_t'    => $this->id_t
        );
        $this->load->view('element/wrapper', $data);
        $this->load->view('contact', $data);
    }
}