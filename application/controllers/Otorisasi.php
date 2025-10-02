<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Otorisasi extends CI_Controller
{
	public $user_level;
	public $user_group;
	public $user_area;
	public $nama;
	public $shift;
	public $id_t;
	public $qt;
	function __construct()
	{
		parent::__construct();
		$this->id_t = $this->input->get('api');
		$query = $this->s_model->s_access($this->id_t);
		$query = $query->row();
		if ($query->user_level == 'Administrator') {
			$this->nama = $query->nama;
			$this->user_area = $query->user_area;
			$this->user_level = $query->user_level;
			$this->user_group = $query->user_group;
			$this->shift = $query->shift;
			$this->qt = $this->db->get('tbl_title', 1)->row();
		} else {
			redirect('action/losttime');
		}
	}

	public function index()
	{
		$username = $this->input->post('user');
		$cek = $this->db->get_where('tbl_user', array('username' => $username), 1)->row();
		if ($cek->user_group == 'User') {
			$data_menu = $this->db->query("select a.id,a.parent,a.child,a.tabel,a.nav,a.orders,b.id AS idb,b.* from tbl_menu a INNER JOIN tbl_menu_user b on(a.menuid=b.menuid and  b.username='" . $username . "') WHERE a.parent='user' order by a.orders,a.parent asc")->result();
		} else {
			$data_menu = $this->db->query("select a.id,a.parent,a.child,a.tabel,a.nav,a.orders,b.id AS idb,b.* from tbl_menu a INNER JOIN tbl_menu_user b on(a.menuid=b.menuid and  b.username='" . $username . "') order by a.orders,a.parent asc")->result();
		}
		$data = array(
			'username' => $username,
			'data_level' => $this->db->query("select * from tbl_user where username='" . $username . "'")->result(),
			'data_menu' => $data_menu,
		);
		$this->load->view('admin/form/detail_otorisasi', $data);
	}

	function formdetail()
	{
		$id = $this->input->post('id');
		$dm = $this->db->get_where('tbl_menu_user', array('id' => $id), 1)->row();
		$qm = $this->db->get_where('tbl_menu', array('menuid' => $dm->menuid), 1)->row();
		$data = array(
			'id' => $id,
			'dm' => $dm,
			'qm' => $qm,
		);
		$this->load->view('admin/form/form_detail_outh', $data);
	}

	function subformdetail()
	{
		$data = array('success' => false, 'messages' => array());
		$this->form_validation->set_rules('view_level', 'view_level', 'trim');
		$this->form_validation->set_rules('add_level', 'add_level', 'trim');
		$this->form_validation->set_rules('edit_level', 'edit_level', 'trim');
		$this->form_validation->set_rules('delete_level', 'delete_level', 'trim');
		$this->form_validation->set_rules('import_level', 'import_level', 'trim');
		$this->form_validation->set_rules('print_level', 'print_level', 'trim');
		$this->form_validation->set_rules('export_level', 'export_level', 'trim');
		$this->form_validation->set_rules('del_all', 'del_all', 'trim');
		$this->form_validation->set_rules('other_level', 'other_level', 'trim');
		$this->form_validation->set_rules('field_level', 'field_level', 'trim');
		$this->form_validation->set_rules('value_level', 'value_level', 'trim');
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		if ($this->form_validation->run()) {
			$id = $this->input->post('id');
			$view_level = $this->input->post('view_level');
			$add_level = $this->input->post('add_level');
			$edit_level = $this->input->post('edit_level');
			$add_level = $this->input->post('add_level');
			$delete_level = $this->input->post('delete_level');
			$import_level = $this->input->post('import_level');
			$print_level = $this->input->post('print_level');
			$export_level = $this->input->post('export_level');
			$del_all = $this->input->post('del_all');
			$other_level = $this->input->post('other_level');
			$field_level = $this->input->post('field_level');
			$value_level = $this->input->post('value_level',FALSE);
			$data1 = array(
				'view_level' => $view_level,
				'add_level' => $add_level,
				'edit_level' => $edit_level,
				'delete_level' => $delete_level,
				'import_level' => $import_level,
				'print_level' => $print_level,
				'export_level' => $export_level,
				'del_all' => $del_all,
				'other_level' => $other_level,
				'field_level' => $field_level,
				'value_level' => $value_level,

			);
			$this->db->update('tbL_menu_user', $data1, array('id' => $id));
			$data['success'] = true;
		} else {
			foreach ($_POST as $key => $value) {
				$data['messages'][$key] = form_error($key);
			}
		}

		echo json_encode($data);
	}
	//function count month


	//==================== OTORISASI=====================
	function viewcheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');

		$this->db->query("UPDATE tbl_menu_user SET view_level='yes' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fas fa-check text-green"></i>';
	}
	function viewuncheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$this->db->query("UPDATE tbl_menu_user SET view_level='no' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fa fa-times text-red"></i>';
	}
	function addcheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');

		$this->db->query("UPDATE tbl_menu_user SET add_level='yes' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fas fa-check text-green "></i>';
	}
	function adduncheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$this->db->query("UPDATE tbl_menu_user SET add_level='no' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fa fa-times text-red "></i>';
	}
	function editcheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');

		$this->db->query("UPDATE tbl_menu_user SET edit_level='yes' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fas fa-check text-green "></i>';
	}
	function edituncheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$this->db->query("UPDATE tbl_menu_user SET edit_level='no' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fa fa-times text-red "></i>';
	}
	function deletecheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');

		$this->db->query("UPDATE tbl_menu_user SET delete_level='yes' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fas fa-check text-green "></i>';
	}
	function deleteuncheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$this->db->query("UPDATE tbl_menu_user SET delete_level='no' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fa fa-times text-red "></i>';
	}
	function importcheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');

		$this->db->query("UPDATE tbl_menu_user SET import_level='yes' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fas fa-check text-green "></i>';
	}
	function importuncheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$this->db->query("UPDATE tbl_menu_user SET import_level='no' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fa fa-times text-red "></i>';
	}
	function printcheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');

		$this->db->query("UPDATE tbl_menu_user SET print_level='yes' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fas fa-check text-green "></i>';
	}
	function printuncheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$this->db->query("UPDATE tbl_menu_user SET print_level='no' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fa fa-times text-red "></i>';
	}
	function exportcheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');

		$this->db->query("UPDATE tbl_menu_user SET export_level='yes' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fas fa-check text-green "></i>';
	}
	function exportuncheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$this->db->query("UPDATE tbl_menu_user SET export_level='no' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fa fa-times text-red "></i>';
	}
	function delallcheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');

		$this->db->query("UPDATE tbl_menu_user SET del_all='yes' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fas fa-check text-green "></i>';
	}
	function delalluncheck()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$this->db->query("UPDATE tbl_menu_user SET del_all='no' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		echo '<i class="fa fa-times text-red "></i>';
	}
	function value_level()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$value = $this->input->post('value');
		$this->db->query("UPDATE tbl_menu_user SET value_level='" . $this->db->escape_like_str($value) . "' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		$data['status'] = true;
		echo json_encode($data);
	}
	function field_level()
	{
		$menuid = $this->input->post('menuid');
		$username = $this->input->post('username');
		$value = $this->input->post('value');
		$this->db->query("UPDATE tbl_menu_user SET field_level='" . $value . "' WHERE menuid='" . $menuid . "' and username='" . $username . "'");
		$data['status'] = true;
		echo json_encode($data);
	}
}
