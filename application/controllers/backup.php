<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Backup extends CI_Controller{
   function __construct(){
        parent::__construct();      
    
    } 
  // backup files in directory
  function files(){
    ini_set('memory_limit','1024M');
    set_time_limit(12000);
     $opt = array(
       'src' => 'rsi', // dir name to backup
       'dst' => 'backup/file' // dir name backup output destination
     );
     
     // Codeigniter v3x
     $this->load->library('recurseZip_lib', $opt);
     $this->recursezip_lib->compress();
     $download = $this->recursezip_lib->compress();
     //
     /* Codeigniter v2x
     $zip    = $this->load->library('recurseZip_lib', $opt);     
     $download = $zip->compress();
    */
     
     redirect(base_url($download));
  }
   
  // backup database.sql
  public function db()
  {
    ini_set('memory_limit','1024M');
    set_time_limit(12000);
     $this->load->dbutil();
   
     $prefs = array(
       'format' => 'zip',
       'filename' => 'my_db_backup.sql'
     );
   
     $backup =$this->dbutil->backup($prefs);
   
     $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip'; // file name
     $save  = 'backup/db/' . $db_name; // dir name backup output destination
   
     $this->load->helper('file');
     write_file($save, $backup);
   
     $this->load->helper('download');
     force_download($db_name, $backup);
  }
   function execute(){
    $cp=$this->s_model->s_access($this->input->get('api')); 
    $cp=$cp->row();                     
    
    $now=gmdate('Y-m-d H:i:s',time()+60*60*7);
    $id=$this->input->post('id');
    $tabel=$this->input->post('tabel_name');

    
    $cek=$this->db->get_where('tbl_conf_backup',array('id'=>$id,'status'=>'Open'),1)->row();
    if($cek){

      $date_field=$cek->date_field;
      $start=$cek->start_value;
      $end=$cek->end_value;
      $other_field=$cek->other_field;
      $other_value=$cek->other_value;
      $max_row_backup=$cek->max_row_backup;

      $this->load->dbforge();
      $db2 = $this->load->database('backup', TRUE);
      $ct=$db2->table_exists($tabel);
      if(!empty($ct)){
        $cb=$db2->query("SELECT count(id) as jml FROM ".$tabel."")->row();
        if($cb->jml>$max_row_backup){
          $this->dbforge->rename_table('dbbackup.'.$tabel, 'dbbackup.'.$tabel.'-'.$now);
          $dest="dbbackup.".$tabel;
          $this->db->query("CREATE TABLE ".$dest." LIKE ".$tabel."");
        }       
      }else{
        $dest="dbbackup.".$tabel;
        $this->db->query("CREATE TABLE ".$dest." LIKE ".$tabel."");
      }

      $cf=$this->db->field_exists($date_field,$tabel);
      if($other_field!=''){
        $co=$this->db->field_exists($other_field,$tabel);
      }
      if($other_field!='' AND empty($co)){
         $data['status']='Tabel field ('.$other_field.') no exists';  
      }elseif(empty($cf)){
         $data['status']='Tabel field ('.$date_field.') no exists';       
      }else{
        $cd=$this->db->get_where($tabel,array($date_field.' >='=>$start,$date_field.' <='=>$end));
        if($other_field!=''){
          $cd=$this->db->query("SELECT id FROM ".$tabel." WHERE ".$date_field.">='".$start."' and ".$date_field."<='".$end."' AND ".$other_field." ".$other_value."");
        }
        if(empty($cd->result())){
          $data['status']='Data no exists';
        }else{

          
          $ctb = $db2->field_exists($date_field,$tabel);
          if($ctb){
              //copy
              $df=$this->db->field_data($tabel);
              foreach ($df as $key) { 
                if($key->name!='id'){
                   $fl[]=$key->name; 
                }
              }
              $fl=join(',',$fl);
              
              if($other_field!=''){
                 $this->db->query("INSERT INTO dbbackup.".$tabel."(".$fl.") SELECT ".$fl." FROM ".$tabel." WHERE ".$date_field.">='".$start."' and ".$date_field."<='".$end."' AND ".$other_field." ".$other_value."");
                 //delete
                 $this->db->query("DELETE FROM ".$tabel." WHERE ".$date_field.">='".$start."' and ".$date_field."<='".$end."' AND ".$other_field." ".$other_value."");
               //$this->db->delete($tabel,array($other_field=>$other_value,$date_field.'>='=>$start,$date_field.'<='=>$end));
              }else{
                $this->db->query("INSERT INTO dbbackup.".$tabel."(".$fl.") SELECT ".$fl." FROM ".$tabel." WHERE ".$date_field.">='".$start."' and ".$date_field."<='".$end."'");
                //delete
                $this->db->delete($tabel,array($date_field.' >='=>$start,$date_field.' <='=>$end));
              }
              
              //reset id
              $this->db->query("ALTER TABLE ".$tabel." DROP id");
              $this->db->query("ALTER TABLE ".$tabel."  ADD id INT NOT NULL AUTO_INCREMENT  FIRST,  ADD   PRIMARY KEY  (id)");
              //update backup
              $trow=$cek->actual_row_backup+$cd->num_rows();
              $d1=array(
                'actual_row_backup'=>$trow,
                'execute_date'=>gmdate('Y-m-d H:i:s',time()+60*60*7),
                'execute_by'=>$cp->nama,
                'status'=>'Close'
              );
              $this->db->update('tbl_conf_backup',$d1,array('id'=>$id));
              $data['status']=true;
            }else{
              $data['status']='Field ('.$date_field.' '.$tabel.') in db backup no exists';
            }
          
         
        }
    }
      
    }else{
      $data['status']='Data Sudah execute';
    }
    
    echo json_encode($data);
   }
}