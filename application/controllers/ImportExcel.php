<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ImportExcel extends CI_Controller
{
	public $user_level;
	public $user_group;
	public $username;
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
		if ($query->user_group == 'Admin') {
			$this->nama = $query->nama;
			$this->username = $query->username;
			$this->user_level = $query->user_level;
			$this->user_group = $query->user_group;
			$this->shift = $query->shift;
			$this->qt = $this->db->get('tbl_title', 1)->row();
		} else {
			redirect('action/losttime');
		}
	}

	function index()
	{
		$table = $this->input->post('table');
		$data = array(
			'table' => $table,
			'id_t' => $this->id_t,
		);
		$this->load->view('admin/form/formimport', $data);
	}
	function statusupload()
	{
		$table = $this->input->post('table');
		$query = $this->db->get_where('tbl_upload', array('tbl_name' => $table))->result();
		foreach ($query as $key) {
			$total = $key->total;
			$progress = $key->progress;
			$success = $key->success;
		}
		$failed = $progress - $success;
		$persen = round($progress / $total, 2) * 100;
		echo json_encode(array('persen' => $persen, 'total' => $total, 'success' => $success, 'failed' => $failed));
	}
	function gagaluploadpl()
	{
		$data_table = $this->db->get('tbl_upload_temp')->result();
		$data = array(
			'data_table' => $data_table,
			'id_t' => $this->id_t,
		);
		$this->load->view('admin/form/gagaluploadpl', $data);
	}
	function uploadplanning()
	{
		ini_set('memory_limit', '512M');
		set_time_limit(12000);
		$no = 0;
		$this->load->library('PHPExcel');
		$table = $this->input->post('table');
		$line_no = $this->input->post('line_no');
		$fileName = $table . time() . $_FILES['fileimport']['name'];
		$config['upload_path'] = './fileExcel/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = 'xls|xlsx|csv';
		$config['max_size'] = 10000;

		$this->upload->initialize($config);
		$namafile = explode('.', $_FILES['fileimport']['name']);
		$namafile1 = explode('_', $namafile[0]);
		$namafile2 = $namafile1[0];
		if (!$this->upload->do_upload('fileimport') or $namafile2 != 'planning') {
			$this->db->delete('tbl_upload', array('tbl_name' => $table));
			$status = "error";
			$msg = strip_tags($this->upload->display_errors());
			if ($msg == '') {
				$msg = 'Error file name, Plase change name file to planning_... !';
			}
			echo json_encode(array('status' => $status, 'msg' => $msg));
		} else {
			$this->db->truncate('tbl_upload_temp');

			$media = $this->upload->data('fileimport');
			$inputFileName = './fileExcel/' . $media['file_name'];

			try {
				$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
				$objReader = PHPExcel_IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch (Exception $e) {
				die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
			}

			$sheet = $objPHPExcel->getSheet(0);
			$highestRow = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();
			$baris = $objPHPExcel->setACTIVESheetIndex(0)->getHighestRow() - 2;
			$this->db->delete('tbl_upload', array('tbl_name' => $table));
			$d_u = array(
				'tbl_name' => $table,
				'total' => $baris,
				'progress' => 0,
				'success' => 0,
			);
			$this->db->insert('tbl_upload', $d_u);

			$ceklift = $this->db->query("SELECT id,lifting_no FROM " . $table . " order by id desc limit 1")->row();
			$lift = intval($ceklift->lifting_no) + 1;
			if ($table == 'tbl_planning_special') {
				$lift = intval(str_replace('S-', '', $ceklift->lifting_no)) + 1;
			}
			if ($lift == 10000) {
				$lift = 1;
			}
			$i = 1;
			$no = 0;
			if ($table == 'tbl_planning_special') {
				$pref = 'S-';
			} else {
				$pref = '';
			}

			for ($row = 3; $row <= $highestRow; $row++) {                           // Read a row of data into an array
				$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
				$upload_date = gmdate('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($rowData[0][1]));
				$prod_shift = trim($rowData[0][2]);
				$suffix1 = trim($rowData[0][3]);
				$tg = explode('-', $upload_date);
				$tg1 = date('Ymd', strtotime($upload_date));
				$now = gmdate('Ymd', time() + 60 * 60 * 7);
				$ceksfx = $this->db->query("SELECT id FROM tbl_master_seat WHERE suffix1 like'%" . $suffix1 . "%' limit 1")->result();
				if (checkdate(intval($tg[1]), intval($tg[2]), intval($tg[0])) == false) {
					$status_upload = 'Upload_date invalid';
				} elseif (intval($tg1) < intval($now)) {
					$status_upload = 'Upload_date invalid';
				} elseif ($prod_shift != 'Day' and $prod_shift != 'Night') {
					$status_upload = 'Prod_shift invalid';
				} elseif (empty($ceksfx)) {
					$status_upload = 'Suffix invalid';
				} else {
					$status_upload = 'Valid';
				}
				$data2[] = array(
					"status_upload" => $status_upload,
					"upload_date" => $upload_date,
					"prod_shift" => $prod_shift,
					"suffix" => $suffix1,
				);
			}
			$this->db->insert_batch('tbl_upload_temp', $data2);
			delete_files($media['file_path']);
			// menghapus semua file .xls yang diupload
			$cek = $this->db->query("SELECT id from tbl_upload_temp WHERE status_upload!='Valid'")->result();
			if (empty($cek)) {
				//update po	
				$qu = $this->db->query("SELECT * from tbl_upload_temp order by id asc")->result();
				foreach ($qu as $xe) {

					$upload_date = $xe->upload_date;
					$prod_id = gmdate('Ymd', strtotime($upload_date));
					$prod_shift = $xe->prod_shift;
					$suffix1 = $xe->suffix;
					if ($line_no == 'All') {
						$queryseat = $this->db->query("SELECT a.line_no,a.item,a.label,a.code,a.side_andon,a.urutan,b.part_no,b.part_name,b.grade,b.model,b.variant FROM tbl_seat a INNER JOIN tbl_master_seat b ON(a.line_no=b.line_no AND a.code=b.code AND b.suffix1 like'%" . $suffix1 . "%') group by b.part_name ORDER BY a.urutan,b.model ASC")->result();
					} else {
						$queryseat = $this->db->query("SELECT a.line_no,a.item,a.label,a.code,a.side_andon,a.urutan,b.part_no,b.part_name,b.grade,b.model,b.variant FROM tbl_seat a INNER JOIN tbl_master_seat b ON(a.line_no=b.line_no AND a.code=b.code AND b.suffix1 like'%" . $suffix1 . "%') WHERE a.line_no='" . $line_no . "' group by b.part_name ORDER BY a.urutan,b.model ASC")->result();
					}


					if ($lift == 10000) {
						$lift = 1;
					}
					if ($lift < 10) {
						$lifting_no = $pref . '000' . $lift;
					} elseif ($lift >= 10 and $lift < 100) {
						$lifting_no = $pref . '00' . $lift;
					} elseif ($lift >= 100 and $lift < 1000) {
						$lifting_no = $pref . '0' . $lift;
					} else {
						$lifting_no = $pref . $lift;
					}
					$lo = 1;

					foreach ($queryseat as $key) {
						if ($key->part_no != NULL) {
							$part_no = $key->part_no;
							$part_name = $key->part_name;
							$grade = $key->grade;
							$model = $key->model;
							$variant = $key->variant;
						} else {
							$part_no = "EMPTY";
							$part_name = "EMPTY";
							$grade = "EMPTY";
							$model = "EMPTY";
							$variant = "EMPTY";
						}
						$qrcode = $part_no . '|' . $suffix1 . '|' . $lifting_no . '|' . $key->line_no . '|' . $key->code . '|' . $prod_id . $lo;
						$data1 = array(
							"part_no" => $part_no,
							"part_name" => $part_name,
							"line_no" => $key->line_no,
							"item" => $key->item,
							"label" => $key->label,
							"code" => $key->code,
							"side_andon" => $key->side_andon,
							"grade" => $grade,
							"model" => $model,
							"variant" => $variant,
							"suffix1" => $suffix1,
							"lifting_no" => $lifting_no,
							"qrcode" => $qrcode,
							"upload_by" => $this->nama,
							"upload_date" => $upload_date,
							"prod_shift" => $prod_shift,
						);
						$this->db->query("DELETE from " . $table . " WHERE qrcode = '" . $qrcode . "'");
						$this->db->insert($table, $data1);
						$lo = $lo + 1;
					}

					$lift = $lift + 1;
					// Sesuaikan nama dengan nama tabel untuk melakukan insert data
					$no = $no + 1;
					$this->db->query("UPDATE tbl_upload SET progress='" . $i . "',success='" . $no . "' WHERE  tbl_name='" . $table . "'");
					$i = $i + 1;
				}
				echo json_encode(array('status' => 'success', 'msg' => 'ok'));
			} else {
				$msg = "Data Upload Tidak Sesuai";
				echo json_encode(array('status' => "gagal", 'msg' => $msg));
			}
		}
	}
}
