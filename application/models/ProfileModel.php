<?php
use 
    DataTables\Editor,
    DataTables\Editor\Field,
    DataTables\Editor\Format,
    DataTables\Editor\Mjoin,
    DataTables\Editor\Options,
    DataTables\Editor\Upload,
    DataTables\Editor\Validate,
    DataTables\Editor\ValidateOptions;
    
class ProfileModel extends CI_Model 
{
    private $editorDb = null;
   
    //constructor which loads the CodeIgniter database class (not required)
    public function __construct()	{
       // $this->load->database();
    }    
    
    public function init($editorDb)
    {
        $this->editorDb = $editorDb;
        $this->editorDb->sql('set names utf8mb4 collate utf8mb4_unicode_ci');
    }
    
     public function getData($post,$api)
    {
        $query=$this->s_model->s_access($api); 
        $query=$query->row();
        $idcard=$query->idcard; 
            Editor::inst( $this->editorDb,'tbl_user')
            ->fields(
                Field::inst('id'),
                Field::inst( 'username' )
                 ->validator( 'Validate::unique' )
                 ->validator( 'Validate::notEmpty' )->validator( 'Validate::noTags' ),
                Field::inst( 'password as password' )              
                   ->getFormatter( function ( $val, $data, $opts ) { return null;})
                ,
                Field::inst( 'nama' )->validator( 'Validate::notEmpty' ),
                Field::inst( 'nik' )->validator( 'Validate::notEmpty' )->validator( Validate::numeric()),
                Field::inst( 'shift' )
                ->options( Options::inst()
                        ->table( 'tbl_shift')
                        ->value( 'shift')
                        ->label( 'shift')
                    ),           
                Field::inst( 'image' )
                 ->upload( Upload::inst( './assets/img/__NAME__' )
                    ->db( 'files', 'id', array(
                        'filename'    => Upload::DB_FILE_NAME,
                        'remark'    => 'USER',
                        'filesize'    => Upload::DB_FILE_SIZE,
                        'web_path'    => Upload::DB_WEB_PATH,
                        'system_path' => Upload::DB_SYSTEM_PATH
                    ) )
                    ->validator( Validate::fileSize( 500000, 'Files must be smaller that 500K' ) )
                    ->validator( Validate::fileExtensions( array( 'png', 'jpg', 'jpeg', 'gif' ), "Please upload an image" ) )
                     )
                    ->setFormatter( Format::ifEmpty(null) ),
                Field::inst( 'user_level'),
                Field::inst( 'user_area'),
                Field::inst( 'user_group'),
                Field::inst( 'registrasi'),               
                Field::inst( 'idcard'),
                Field::inst( 'log_in'),
                Field::inst( 'log_out')
            )

            ->on( 'preEdit', function ( $editor, $id, $values ) {
                // //file values
                // $qf = $this->db->get_where('files', array('id' => $values['sign']), 1)->row();
                // if(!empty($qf)){
                //     $replace = 'sign-' . $values['username'] . '.jpg';
                //     $df = array(
                //         'filename'    => str_replace($qf->filename, $replace, $qf->filename),
                //         'web_path'    => str_replace($qf->filename, $replace, $qf->web_path),
                //         'system_path' => str_replace($qf->filename, $replace, $qf->system_path)
                //     );
                //     $this->db->update('files', $df, array('id' => $values['sign']));
                //     $oldDir = FCPATH . 'assets/sign/';
                //     $newDir = FCPATH . 'assets/sign/';
                //     rename($oldDir . $qf->filename, $newDir . $replace);
                // }
                $q=$this->db->get_where('tbl_user',array('id'=>$id),1)->row();
                if (!empty($values['password'])) {
                    $p = $this->sha1->generate($values['password']); $p=strrev($p); $p=substr($p,5);
                    $editor->field( 'password')->setValue( $p );

                }else{
                     $editor->field( 'password')->setValue($q->password);
                }
               
            } )
            
           
           ->on( 'preGet', function ( $editor,$id ) use ($idcard){
                        $editor->where( function ( $q ) use ($idcard) {                  
                            $q->where('idcard',$idcard);
                        });
                      
                } )
            ->process( $post )
            ->json();
    }
     
   
}