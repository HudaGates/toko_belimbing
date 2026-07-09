<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller{
  // public $shift;
  // public $prod_date;
  // public $user_level;
  // public $pos_level;
  // public $pos_name;
  // public $user_area;
  // public $idcard;
  // public $nama;
  // public $id_t;
  //   function __construct(){
  //       parent::__construct();
  //       $this->id_t=$this->input->get('api');
  //       $query=$this->s_model->s_access($this->id_t); 
  //       $query=$query->row();
  //       if($query->user_level=='Cashier'){            
  //         $this->nama=$query->nama;
  //         $this->user_level=$query->user_level;
  //         $this->user_area=$query->user_area;
  //         $this->idcard=$query->idcard;
  //       }else{
  //         redirect('action/scan?api='.$this->id_t);
  //       }
  //   }
function index(){
  $this->id_t=$this->input->get('api');

  $month = 1;
  $year = 2024;
  $qt = $this->db->get('tbl_title', 1)->row();
  $qr = $this->db->query("SELECT * FROM `tbl_history_sale` WHERE MONTH(update_time) = ".$month."  and YEAR(update_time) = ".$year."")->result();
  
//  print_r($qr);
  $data=array(
        'qt'=>$qt,

    ); 
  $this->load->view('user/cashier/home',$data);
}

function formprintreportmonthly(){
  $this->id_t=$this->input->get('api');


  $qt = $this->db->get('tbl_title', 1)->row();
  $qsubstr = $this->db->query("SELECT SUBSTRING(update_time, 1, 7) AS substr FROM `tbl_history_sale` GROUP BY SUBSTRING(update_time, 1, 7)")->result();
  
//  print_r($qr);
  $data=array(
        'qt'=>$qt,
        'qsubstr'=>$qsubstr,
    ); 
  $this->load->view('admin/form/form_print_report_monthly',$data);
}

function formprintreportdaily(){
  $this->id_t=$this->input->get('api');


  $qt = $this->db->get('tbl_title', 1)->row();
  $qsubstr = $this->db->query("SELECT SUBSTRING(update_time, 1, 7) AS substr FROM `tbl_history_sale` GROUP BY SUBSTRING(update_time, 1, 7)")->result();
  
//  print_r($qr);
  $data=array(
        'qt'=>$qt,
        'qsubstr'=>$qsubstr,
    ); 
  $this->load->view('admin/form/form_print_report_daily',$data);
}


function reportmonth(){
  
  $month =$this->input->get('month');
  $year = $this->input->get('year');
  
  $qt = $this->db->get('tbl_title', 1)->row();
  $qr = $this->db->query("SELECT * FROM `tbl_history_sale` WHERE MONTH(update_time) = ".$month."  and YEAR(update_time) = ".$year."")->result();
  
  $qminstock = $this->db->query("SELECT * FROM `tbl_master_product` WHERE stock<5")->result();
  $cminstock = $this->db->query("SELECT COUNT(id) AS count_product FROM `tbl_master_product` WHERE stock<5")->row();
  $qsr = $this->db->query("SELECT SUM(total_amount) AS total_amount_month FROM `tbl_history_sale` WHERE MONTH(update_time) = ".$month."  and YEAR(update_time) = ".$year."")->row();
//  print_r($qr);
// SELECT DATE(update_time) as DATE, SUM(total_amount) total_count FROM tbl_history_sale GROUP BY  DATE(update_time)
   $data=array(
        'qt'=>$qt,
        'month'=>$month,
        'year'=>$year,
        'qr'=>$qr,
        'qminstock'=>$qminstock,
        'cminstock'=>$cminstock,
        'qsr'=>$qsr,

    ); 
  $this->load->view('report/report_month',$data);
}
function bulanan(){
    $this->id_t = $this->input->get('api');
    $qt = $this->db->get('tbl_title', 1)->row();

    // Query untuk mengambil rekapitulasi transaksi & omzet per bulan otomatis
    $q_omzet = $this->db->query("
        SELECT 
            DATE_FORMAT(update_time, '%M %Y') AS bulan_tahun, 
            DATE_FORMAT(update_time, '%m') AS bulan_angka,
            DATE_FORMAT(update_time, '%Y') AS tahun_angka,
            COUNT(id) AS total_transaksi, 
            SUM(total_amount) AS omzet 
        FROM tbl_history_sale 
        GROUP BY DATE_FORMAT(update_time, '%Y-%m')
        ORDER BY update_time DESC
    ")->result();

    $data = array(
        'qt' => $qt,
        'api' => $this->id_t,
        'laporan' => $q_omzet
    ); 

    // Kita arahkan ke folder report/v_bulanan
    $this->load->view('report/v_bulanan', $data);
}
function get_omzet_ajax() {
    // Tambahkan kondisi WHERE untuk menyaring data tanggal yang tidak valid
    $q_omzet = $this->db->query("
        SELECT 
            DATE_FORMAT(update_time, '%M %Y') AS bulan_tahun, 
            COUNT(id) AS total_transaksi, 
            SUM(total_amount) AS omzet 
        FROM tbl_history_sale 
        WHERE update_time IS NOT NULL 
          AND update_time != '0000-00-00 00:00:00'
          AND update_time != ''
        GROUP BY DATE_FORMAT(update_time, '%Y-%m')
        ORDER BY update_time DESC
    ")->result_array();

    echo json_encode($q_omzet); 
}
function export_excel_omzet() {
    // 1. Ambil data dari database (Query yang sama persis dengan tampilan AJAX)
    $laporan = $this->db->query("
        SELECT 
            DATE_FORMAT(update_time, '%M %Y') AS bulan_tahun, 
            COUNT(id) AS total_transaksi, 
            SUM(total_amount) AS omzet 
        FROM tbl_history_sale 
        WHERE update_time IS NOT NULL 
          AND update_time != '0000-00-00 00:00:00'
          AND update_time != ''
        GROUP BY DATE_FORMAT(update_time, '%Y-%m')
        ORDER BY update_time DESC
    ")->result_array();

    // 2. Atur Header HTTP agar browser mengenali file ini sebagai Excel (.xls)
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Omzet_Toko_Belimbing.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    // 3. Buat struktur tabel HTML di dalam berkas Excel
    echo "<h3>LAPORAN REKAPITULASI OMZET BULANAN</h3>";
    echo "<h4>Toko Belimbing</h4>";
    echo "<br>";
    
    echo "<table border='1' cellpadding='5'>";
    echo "<thead>
            <tr style='background-color: #333; color: #fff;'>
                <th>No</th>
                <th>Periode Bulan</th>
                <th>Total Transaksi</th>
                <th>Total Omzet</th>
            </tr>
          </thead>";
    echo "<tbody>";

    $no = 1;
    $grand_total = 0;
    
    if(!empty($laporan)) {
        foreach($laporan as $row) {
            $grand_total += $row['omzet'];
            echo "<tr>";
            echo "<td align='center'>".$no++."</td>";
            echo "<td>".$row['bulan_tahun']."</td>";
            echo "<td align='center'>".$row['total_transaksi']." Transaksi</td>";
            echo "<td align='right'>".$row['omzet']."</td>"; // Angka murni agar bisa dirumus di Excel
            echo "</tr>";
        }
        // Baris Grand Total Keseluruhan
        echo "<tr style='font-weight: bold; background-color: #eee;'>";
        echo "<td colspan='3' align='right'>TOTAL OMZET KESELURUHAN:</td>";
        echo "<td align='right'>".$grand_total."</td>";
        echo "</tr>";
    } else {
        echo "<tr><td colspan='4' align='center'>Belum ada data penjualan.</td></tr>";
    }

    echo "</tbody>";
    echo "</table>";
}
}
