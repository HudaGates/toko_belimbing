<?php if (!defined("BASEPATH")) exit("No direct script access allowed");
if (!function_exists('pr_no')) {
 function pr_no($username)
    {
        $CI =& get_instance();
        $m = gmdate('m', time() + 60 * 60 * 7);
        $y = gmdate('Y', time() + 60 * 60 * 7);
        $time = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
        $q = $CI->db->query("SELECT * FROM tbl_temp_pr WHERE YEAR(create_time)='" . $y . "'  order by create_time asc limit 1")->row();
        // cek tbl_temp_pr dengan create_time bulan berjalan
        if (empty($q)) {
            //truncate using codeigniter function
            $CI->db->truncate('tbl_temp_pr');
            // 2.insert tbl_temp_pr dengan temp_no=1,username,create_time pakai fungsi insert ci
            $CI->db->insert('tbl_temp_pr', array('temp_no' => 1, 'username' => $username, 'create_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7)));
        } else {
            $cek = $CI->db->get_where('tbl_temp_pr', array('username' => $username), 1)->row();
            if (empty($cek)) {
                $CI->db->query("INSERT INTO tbl_temp_pr(temp_no,username,create_time) SELECT temp_no +1 AS temp_no, '" . $username . "', '" . $time . "' FROM tbl_temp_pr ORDER BY id DESC LIMIT 1");
            }
        }
        //tampilkan tbl_temp_pr berdasar user login
        $qn = $CI->db->get_where("tbl_temp_pr", array('username' => $username), 1)->row();
        // if (empty($qr)) {
        //     $tn = 1;
        // } else {
        //     $t = substr($qr->temp_no, -4);
        //     $tn = $t + 1;
        // }
        $tn = $qn->temp_no;
        if ($tn < 10) {
            $temp_no = '00' . $tn;
        } else if ($tn < 100) {
            $temp_no = '0' . $tn;
        } else if ($tn < 1000) {
            $temp_no = '0' . $tn;
        } else {
            $temp_no = $tn;
        }

        $pr_no = $temp_no . '/' . 'PR-YPI' . '/' . $m . '/' . $y;
        return $pr_no;
    }
}
if (!function_exists('po_no')) {
function po_no($username)
    {
        $CI =& get_instance();
        $m = gmdate('m', time() + 60 * 60 * 7);
        $y = gmdate('Y', time() + 60 * 60 * 7);
        $ym = gmdate('Y-m', time() + 60 * 60 * 7);
        $time = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
        $q = $CI->db->query("SELECT * FROM tbl_temp_po WHERE YEAR(create_time)='" . $ym . "'  order by create_time asc limit 1")->row();
        // cek tbl_temp_po dengan create_time bulan berjalan
        if (empty($q)) {
            //truncate using codeigniter function
            $CI->db->truncate('tbl_temp_po');
            // 2.insert tbl_temp_po dengan temp_no=1,username,create_time pakai fungsi insert ci
            $CI->db->insert('tbl_temp_po', array('temp_no' => 1, 'username' => $username, 'create_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7)));
        } else {
            $cek = $CI->db->get_where('tbl_temp_po', array('username' => $username), 1)->row();
            if (empty($cek)) {
                $CI->db->query("INSERT INTO tbl_temp_po(temp_no,username,create_time) SELECT temp_no +1 AS temp_no, '" . $username . "', '" . $time . "' FROM tbl_temp_po ORDER BY id DESC LIMIT 1");
            }
        }
        //tampilkan tbl_temp_po berdasar user login
        $qn = $CI->db->get_where("tbl_temp_po", array('username' => $username), 1)->row();

        $tn = $qn->temp_no;
        if ($tn < 10) {
            $temp_no = '00' . $tn;
        } else if ($tn < 100) {
            $temp_no = '0' . $tn;
        } else if ($tn < 1000) {
            $temp_no = '0' . $tn;
        } else {
            $temp_no = $tn;
        }

        $po_no = $temp_no . '/' . 'PO-YPI' . '/' . $m . '/' . $y;
        return $po_no;
    }
}
if (!function_exists('skm_no')) {
function skm_no($username)
    {
        $CI =& get_instance();
        $m = gmdate('m', time() + 60 * 60 * 7);
        $y = gmdate('Y', time() + 60 * 60 * 7);
        $ym = gmdate('Y-m', time() + 60 * 60 * 7);
        $time = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);
        $q = $CI->db->query("SELECT * FROM tbl_temp_skm WHERE YEAR(create_time)='" . $ym . "'  order by create_time asc limit 1")->row();
        // cek tbl_temp_po dengan create_time bulan berjalan
        if (empty($q)) {
            //truncate using codeigniter function
            $CI->db->truncate('tbl_temp_skm');
            // 2.insert tbl_temp_po dengan temp_no=1,username,create_time pakai fungsi insert ci
            $CI->db->insert('tbl_temp_skm', array('temp_no' => 1, 'username' => $username, 'create_time' => gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7)));
        } else {
            $cek = $CI->db->get_where('tbl_temp_skm', array('username' => $username), 1)->row();
            if (empty($cek)) {
                $CI->db->query("INSERT INTO tbl_temp_skm(temp_no,username,create_time) SELECT temp_no +1 AS temp_no, '" . $username . "', '" . $time . "' FROM tbl_temp_skm ORDER BY id DESC LIMIT 1");
            }
        }
        //tampilkan tbl_temp_po berdasar user login
        $qn = $CI->db->get_where("tbl_temp_skm", array('username' => $username), 1)->row();

        $tn = $qn->temp_no;
        if ($tn < 10) {
            $temp_no = '00' . $tn;
        } else if ($tn < 100) {
            $temp_no = '0' . $tn;
        } else if ($tn < 1000) {
            $temp_no = '0' . $tn;
        } else {
            $temp_no = $tn;
        }

        $skm_no = $temp_no . '/' . 'SKM-YPI' . '/' . $m . '/' . $y;
        return $skm_no;
    }
}

 