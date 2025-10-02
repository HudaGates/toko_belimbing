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

class MasterModel extends CI_Model
{
    private $editorDb = null;

    //constructor which loads the CodeIgniter database class (not required)
    public function __construct()
    {
        // $this->load->database();
    }

    public function init($editorDb)
    {
        $this->editorDb = $editorDb;
        $this->editorDb->sql('set names utf8mb4 collate utf8mb4_unicode_ci');
    }

    public function getData($post, $table, $api, $menuid)
    {
        $query = $this->s_model->s_access($api);
        $query = $query->row();
        $nama = $query->nama;
        $username = $query->username;
        $user_area = $query->user_area;
        $user_level = $query->user_level;
        $user_group = $query->user_group;
        $get_o = $this->db->get_where('tbl_menu_user', array('menuid' => $menuid, 'username' => $username), 1)->row();
        $field = $get_o->field_level;
        $value = $get_o->value_level;

        if ($table == 'tbl_master_supplier') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('supplier_code')
                    ->validator('Validate::notEmpty')
                    ->validator('Validate::unique')
                    ->validator(Validate::maxLen(50)),
                    Field::inst('supplier_name')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('address')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('phone')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('email')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('pic')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('update_by')->set(true)->setValue($nama),
                    Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                )
                ->on('preGet', function ($editor, $id) use ($user_level, $field, $value) {
                    $editor->where(function ($q) use ($user_level, $field, $value) {
                        if ($field) {
                            $val_t = explode(',,', $value);
                            $fie_t = explode(',,', $field);
                            $ex_x = count($val_t);
                            for ($i = 0; $i < $ex_x; $i++) {
                                $ex = explode('|', $val_t[$i]);
                                if ($ex[0] == 'null' and $ex[1] == '=') {
                                    $q->where($fie_t[$i], null);
                                } else {
                                    if ($ex[1] == 'IN') {
                                        $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                    } else {
                                        $q->where($fie_t[$i], $ex[0], $ex[1]);
                                    }
                                }
                            }
                        }
                    });
                })
                ->process($post)
                ->json();
        } elseif ($table == 'tbl_master_partlist') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('file_spps')
                    ->upload(
                        Upload::inst('./assets/part/pdf/__NAME__')
                            ->db('files', 'id', array(
                                'filename'    => Upload::DB_FILE_NAME,
                                'remark'      => 'SPPS',
                                'filesize'    => Upload::DB_FILE_SIZE,
                                'web_path'    => Upload::DB_WEB_PATH,
                                'system_path' => Upload::DB_SYSTEM_PATH
                            ))
                            ->validator(Validate::fileSize(10000000, 'Files must be smaller that 10MB'))
                            ->validator(Validate::fileExtensions(array('pdf'), "Please upload an file pdf"))
                    )->setFormatter(Format::ifEmpty(null)),
                    Field::inst('file_spis')
                    ->upload(
                        Upload::inst('./assets/part/pdf/__NAME__')
                            ->db('files', 'id', array(
                                'filename'    => Upload::DB_FILE_NAME,
                                'remark'      => 'SPIS',
                                'filesize'    => Upload::DB_FILE_SIZE,
                                'web_path'    => Upload::DB_WEB_PATH,
                                'system_path' => Upload::DB_SYSTEM_PATH
                            ))
                            ->validator(Validate::fileSize(10000000, 'Files must be smaller that 10MB'))
                            ->validator(Validate::fileExtensions(array('pdf'), "Please upload an file pdf"))
                    )->setFormatter(Format::ifEmpty(null)),
                    Field::inst('img_part')
                    ->upload(
                        Upload::inst('./assets/part/img/__NAME__')
                            ->db('files', 'id', array(
                                'filename'    => Upload::DB_FILE_NAME,
                                'remark'      => 'PART',
                                'filesize'    => Upload::DB_FILE_SIZE,
                                'web_path'    => Upload::DB_WEB_PATH,
                                'system_path' => Upload::DB_SYSTEM_PATH
                            ))
                            ->validator(Validate::fileSize(1000000, 'Files must be smaller that 1MB'))
                            ->validator(Validate::fileExtensions(array('jpg'), "Please upload an image jpg"))
                    )->setFormatter(Format::ifEmpty(null)),
                    Field::inst('part_no_fsi')->validator('Validate::notEmpty')
                    ->setFormatter( function ( $val, $data, $opts ) {
                        return trim($val);
                    } ),
                    Field::inst('customer')->validator('Validate::notEmpty')
                     ->setFormatter( function ( $val, $data, $opts ) {
                        return trim($val);
                    } ),
                    Field::inst('customer_code')->validator('Validate::notEmpty'),
                    Field::inst('part_no_customer')->validator('Validate::notEmpty')->validator('Validate::unique')
                    ->setFormatter( function ( $val, $data, $opts ) {
                        return trim($val);
                    } ),
                    Field::inst('qr_label')->setFormatter(Format::ifEmpty(null))->validator('Validate::unique')
                    ->setFormatter( function ( $val, $data, $opts ) {
                        return trim($val);
                    } ),
                    Field::inst('storage_label')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('part_name')->validator('Validate::notEmpty'),
                    Field::inst('model')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('supplier_code')->validator('Validate::notEmpty')
                    ->options(
                            Options::inst()
                                ->table('tbl_master_supplier')
                                ->value('supplier_code')
                                ->label('supplier_code')
                        ),
                    Field::inst('qty_box')->setFormatter(Format::ifEmpty(0)),
                    Field::inst('storage')->validator('Validate::notEmpty'),
                    Field::inst('no_box')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('min_stock')->setFormatter(Format::ifEmpty(0)),
                    Field::inst('max_stock')->setFormatter(Format::ifEmpty(0)),
                    Field::inst('status_part')->validator('Validate::notEmpty'),
                    Field::inst('update_by')->set(true)->setValue($nama),
                    Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                )
                ->on('postCreate', function ($editor, $id, &$values, &$row) {
                    //file values
                    $qf = $this->db->get_where('files', array('id' => $values['img_part']), 1)->row();
                    if(!empty($qf)){
                        $replace = $values['part_no'] . '.jpg';
                        $df = array(
                            'filename'    => str_replace($qf->filename, $replace, $qf->filename),
                            'web_path'    => str_replace($qf->filename, $replace, $qf->web_path),
                            'system_path' => str_replace($qf->filename, $replace, $qf->system_path)
                        );
                        $this->db->update('files', $df, array('id' => $values['img_part']));
                        $oldDir = FCPATH . 'assets/part/img/';
                        $newDir = FCPATH . 'assets/part/img/';
                        rename($oldDir . $qf->filename, $newDir . $replace);
                    }
                    $qf = $this->db->get_where('files', array('id' => $values['file_spis']), 1)->row();
                    if(!empty($qf)){
                        $replace = $values['part_no_fsi'] . 'P1.pdf';
                        $df = array(
                            'filename'    => str_replace($qf->filename, $replace, $qf->filename),
                            'web_path'    => str_replace($qf->filename, $replace, $qf->web_path),
                            'system_path' => str_replace($qf->filename, $replace, $qf->system_path)
                        );
                        $this->db->update('files', $df, array('id' => $values['file_spis']));
                        $oldDir = FCPATH . 'assets/part/pdf/';
                        $newDir = FCPATH . 'assets/part/pdf/';
                        rename($oldDir . $qf->filename, $newDir . $replace);
                    }
                    $qf = $this->db->get_where('files', array('id' => $values['file_spps']), 1)->row();
                    if(!empty($qf)){
                        if(trim($values['customer'])=='ADM'){
                            $pt='P2D';
                        }else{
                            $pt='P2T';
                        }
                        $replace = $values['part_no_fsi'] .$pt.'.pdf';
                        $df = array(
                            'filename'    => str_replace($qf->filename, $replace, $qf->filename),
                            'web_path'    => str_replace($qf->filename, $replace, $qf->web_path),
                            'system_path' => str_replace($qf->filename, $replace, $qf->system_path)
                        );
                        $this->db->update('files', $df, array('id' => $values['file_spps']));
                        $oldDir = FCPATH . 'assets/part/pdf/';
                        $newDir = FCPATH . 'assets/part/pdf/';
                        rename($oldDir . $qf->filename, $newDir . $replace);
                    }

                    
                })
                ->on('preEdit', function ($editor, $id, $values)  use($nama,$table){
                    //file values
                   $qf = $this->db->get_where('files', array('id' => $values['img_part']), 1)->row();
                   if(!empty($qf)){
                       $replace = $values['part_no_fsi'] . '.jpg';
                       $df = array(
                           'filename'    => str_replace($qf->filename, $replace, $qf->filename),
                           'web_path'    => str_replace($qf->filename, $replace, $qf->web_path),
                           'system_path' => str_replace($qf->filename, $replace, $qf->system_path)
                       );
                       $this->db->update('files', $df, array('id' => $values['img_part']));
                       $oldDir = FCPATH . 'assets/part/img/';
                       $newDir = FCPATH . 'assets/part/img/';
                       rename($oldDir . $qf->filename, $newDir . $replace);
                   }
                   $qf = $this->db->get_where('files', array('id' => $values['file_spis']), 1)->row();
                   if(!empty($qf)){
                       $replace = $values['part_no_fsi'] . 'P1.pdf';
                       $df = array(
                           'filename'    => str_replace($qf->filename, $replace, $qf->filename),
                           'web_path'    => str_replace($qf->filename, $replace, $qf->web_path),
                           'system_path' => str_replace($qf->filename, $replace, $qf->system_path)
                       );
                       $this->db->update('files', $df, array('id' => $values['file_spis']));
                       $oldDir = FCPATH . 'assets/part/pdf/';
                       $newDir = FCPATH . 'assets/part/pdf/';
                       rename($oldDir . $qf->filename, $newDir . $replace);
                   }
                   $qf = $this->db->get_where('files', array('id' => $values['file_spps']), 1)->row();
                   if(!empty($qf)){
                       if(trim($values['customer'])=='ADM'){
                            $pt='P2D';
                        }else{
                            $pt='P2T';
                        }
                        $replace = $values['part_no_fsi'] .$pt.'.pdf';
                       $df = array(
                           'filename'    => str_replace($qf->filename, $replace, $qf->filename),
                           'web_path'    => str_replace($qf->filename, $replace, $qf->web_path),
                           'system_path' => str_replace($qf->filename, $replace, $qf->system_path)
                       );
                       $this->db->update('files', $df, array('id' => $values['file_spps']));
                       $oldDir = FCPATH . 'assets/part/pdf/';
                       $newDir = FCPATH . 'assets/part/pdf/';
                       rename($oldDir . $qf->filename, $newDir . $replace);
                   }
                   $this->logdate('edit'.$table.$id,$values['part_no_fsi'].'#'.$values['part_no_customer'], $nama);
               })
                ->on( 'preRemove', function ($editor, $id, $values ) use($nama,$table) {
                $this->logdate('remove'.$table.$id, $values['part_no_fsi'].'#'.$values['part_no_customer'],$nama);
                } )
                ->on('preGet', function ($editor, $id) use ($user_level, $field, $value) {
                    $editor->where(function ($q) use ($user_level, $field, $value) {
                        if ($field) {
                            $val_t = explode(',,', $value);
                            $fie_t = explode(',,', $field);
                            $ex_x = count($val_t);
                            for ($i = 0; $i < $ex_x; $i++) {
                                $ex = explode('|', $val_t[$i]);
                                if ($ex[0] == 'null' and $ex[1] == '=') {
                                    $q->where($fie_t[$i], null);
                                } else {
                                    if ($ex[1] == 'IN') {
                                        $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                    } else {
                                        $q->where($fie_t[$i], $ex[0], $ex[1]);
                                    }
                                }
                            }
                        }
                    });
                })
                ->process($post)
                ->json();
        } elseif ($table == 'tbl_master_customer') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('customer_code'),
                    Field::inst('customer_name'),
                    Field::inst('gender'),
                    Field::inst('birth_date'),
                    Field::inst('address'),
                    Field::inst('city'),
                    Field::inst('phone'),
                    Field::inst('email'),
                    Field::inst('img_customer'),

                    Field::inst('update_by')->set(true)->setValue($nama),
                    Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                )
                ->on('preGet', function ($editor, $id) use ($user_level, $field, $value) {
                    $editor->where(function ($q) use ($user_level, $field, $value) {
                        if ($field) {
                            $val_t = explode(',,', $value);
                            $fie_t = explode(',,', $field);
                            $ex_x = count($val_t);
                            for ($i = 0; $i < $ex_x; $i++) {
                                $ex = explode('|', $val_t[$i]);
                                if ($ex[0] == 'null' and $ex[1] == '=') {
                                    $q->where($fie_t[$i], null);
                                } else {
                                    if ($ex[1] == 'IN') {
                                        $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                    } else {
                                        $q->where($fie_t[$i], $ex[0], $ex[1]);
                                    }
                                }
                            }
                        }
                    });
                })
                ->process($post)
                ->json();
        } elseif ($table == 'tbl_satuan') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('satuan')->validator('Validate::notEmpty')->validator('Validate::unique' ),
                    Field::inst('update_by')->set(true)->setValue($nama),
                    Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                )
                ->on('preGet', function ($editor, $id) use ($user_level, $field, $value) {
                    $editor->where(function ($q) use ($user_level, $field, $value) {
                        if ($field) {
                            $val_t = explode(',,', $value);
                            $fie_t = explode(',,', $field);
                            $ex_x = count($val_t);
                            for ($i = 0; $i < $ex_x; $i++) {
                                $ex = explode('|', $val_t[$i]);
                                if ($ex[0] == 'null' and $ex[1] == '=') {
                                    $q->where($fie_t[$i], null);
                                } else {
                                    if ($ex[1] == 'IN') {
                                        $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                    } else {
                                        $q->where($fie_t[$i], $ex[0], $ex[1]);
                                    }
                                }
                            }
                        }
                    });
                })
                ->process($post)
                ->json();
        } elseif ($table == 'tbl_master_product') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('product_code'),
                    Field::inst('product_name'),
                    Field::inst('supplier_code'),
                    Field::inst('img_product')
                    ->upload(Upload::inst('./assets/product/img/__NAME__')
                            ->db('files', 'id', array(
                                'filename'    => Upload::DB_FILE_NAME,
                                'remark'      => 'PRODUCT',
                                'filesize'    => Upload::DB_FILE_SIZE,
                                'web_path'    => Upload::DB_WEB_PATH,
                                'system_path' => Upload::DB_SYSTEM_PATH
                            ))
                            ->validator(Validate::fileSize(1000000, 'Files must be smaller that 1MB'))
                            ->validator(Validate::fileExtensions(array('jpg','jpeg','png'), "Please upload an image jpg"))
                    )->setFormatter(Format::ifEmpty(null)),
                    Field::inst('unit'),
                    Field::inst('stock'),
                    Field::inst('price'),
                    Field::inst('discount'),
                    Field::inst('category_id'),
                    Field::inst('update_by')->set(true)->setValue($nama),
                    Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                    
                    
                    
                )
                ->on('postCreate', function ($editor, $id, &$values, &$row) {
                    //file values
                    $qf = $this->db->get_where('files', array('id' => $values['img_product']), 1)->row();
                    if(!empty($qf)){
                        $replace = $values['product_code'] . '.jpg';
                        $df = array(
                            'filename'    => str_replace($qf->filename, $replace, $qf->filename),
                            'web_path'    => str_replace($qf->filename, $replace, $qf->web_path),
                            'system_path' => str_replace($qf->filename, $replace, $qf->system_path)
                        );
                        $this->db->update('files', $df, array('id' => $values['img_product']));
                        $oldDir = FCPATH . 'assets/product/img/';
                        $newDir = FCPATH . 'assets/product/img/';
                        rename($oldDir . $qf->filename, $newDir . $replace);
                    }
                    
                })
                ->on('preGet', function ($editor, $id) use ($user_level, $field, $value) {
                    $editor->where(function ($q) use ($user_level, $field, $value) {
                        if ($field) {
                            $val_t = explode(',,', $value);
                            $fie_t = explode(',,', $field);
                            $ex_x = count($val_t);
                            for ($i = 0; $i < $ex_x; $i++) {
                                $ex = explode('|', $val_t[$i]);
                                if ($ex[0] == 'null' and $ex[1] == '=') {
                                    $q->where($fie_t[$i], null);
                                } else {
                                    if ($ex[1] == 'IN') {
                                        $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                    } else {
                                        $q->where($fie_t[$i], $ex[0], $ex[1]);
                                    }
                                }
                            }
                        }
                    });
                })
                ->process($post)
                ->json();
        } elseif ($table == 'tbl_master_rack') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('rack'),
                    Field::inst('qty_col'),
                    Field::inst('qty_row'),
                    Field::inst('rack_name')
                )
                ->on('preGet', function ($editor, $id) use ($user_level, $field, $value) {
                    $editor->where(function ($q) use ($user_level, $field, $value) {
                        if ($field) {
                            $val_t = explode(',,', $value);
                            $fie_t = explode(',,', $field);
                            $ex_x = count($val_t);
                            for ($i = 0; $i < $ex_x; $i++) {
                                $ex = explode('|', $val_t[$i]);
                                if ($ex[0] == 'null' and $ex[1] == '=') {
                                    $q->where($fie_t[$i], null);
                                } else {
                                    if ($ex[1] == 'IN') {
                                        $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                    } else {
                                        $q->where($fie_t[$i], $ex[0], $ex[1]);
                                    }
                                }
                            }
                        }
                    });
                })
                ->process($post)
                ->json();
        }

    }


    //An additional method just to see if we can still use the Codeigniter database class (not required)

    function ChangeLevel($action, $id, $values)
    {
        if ($action == 'create') {
            $user_level = $values['user_level'];
            if ($values['user_group'] == 'Admin') {
                $m = $this->db->get_where('tbl_menu', array('parent !=' => 'user'))->result();
            } else {
                $m = $this->db->get_where('tbl_menu', array('parent' => 'user'))->result();
            }
            foreach ($m as $key) {
                $data2[] = array(
                    'menuid' => $key->menuid,
                    'user_level' => $user_level,
                    'view_level' => 'no',
                    'add_level' => 'no',
                    'edit_level' => 'no',
                    'delete_level' => 'no',
                    'import_level' => 'no',
                    'print_level' => 'no',
                    'export_level' => 'no',
                    'del_all' => 'no',
                );
            }
            $this->db->insert_batch('tbl_menu_user', $data2);
        } elseif ($action == 'edit') {
            $q = $this->db->get_where('tbl_level', array('id' => $id), 1)->row();
            $a = $q->user_level;
            if (!empty($values['user_level'])) {
                $user_level = $values['user_level'];
            } else {
                $user_level = $a;
            }

            $data = array(
                'user_level' => $user_level
            );
            $this->db->update('tbl_user', $data, array('user_level' => $a));
            $this->db->update('tbl_menu_user', $data, array('user_level' => $a));
            $this->db->update('tbl_ip', $data, array('user_level' => $a));
        } else {
            $q = $this->db->get_where('tbl_level', array('id' => $id), 1)->row();
            $a = $q->user_level;
            $this->db->delete('tbl_menu_user', array('user_level' => $a));
        }
    }
    function ChangeMenu($action, $id, $values)
    {
        if ($action == 'create') {
            $menuid = $values['parent'] . $values['child'];
            if ($values['parent'] == 'user') {
                $m = $this->db->get_where('tbl_level', array('user_group' => 'User'))->result();
            } else {
                $m = $this->db->get_where('tbl_level', array('user_group' => 'Admin'))->result();
            }
            foreach ($m as $key) {
                $data2[] = array(
                    'menuid' => $menuid,
                    'user_level' => $key->user_level,
                    'view_level' => 'no',
                    'add_level' => 'no',
                    'edit_level' => 'no',
                    'delete_level' => 'no',
                    'import_level' => 'no',
                    'print_level' => 'no',
                    'export_level' => 'no',
                    'del_all' => 'no',
                );
            }
            $this->db->insert_batch('tbl_menu_user', $data2);
        } elseif ($action == 'edit') {
            $q = $this->db->get_where('tbl_menu', array('id' => $id), 1)->row();
            $a = $q->menuid;
            if (!empty($values['parent']) and !empty($values['child'])) {
                $menuid = $values['parent'] . $values['child'];
            } else {
                $menuid = $a;
            }

            $data = array(
                'menuid' => $menuid
            );
            $this->db->update('tbl_menu_user', $data, array('menuid' => $a));
        } else {
            $q = $this->db->get_where('tbl_menu', array('id' => $id), 1)->row();
            $a = $q->menuid;
            $this->db->delete('tbl_menu_user', array('menuid' => $a));
        }
    }
    function logdate ($action,$values,$nama){
        $this->load->library('user_agent');
        if ($this->agent->is_browser())
        {
                $agent = $this->agent->browser().' '.$this->agent->version();
        }
        elseif ($this->agent->is_robot())
        {
                $agent = $this->agent->robot();
        }
        elseif ($this->agent->is_mobile())
        {
                $agent = $this->agent->mobile();
        }
        else
        {
                $agent = 'Unidentified User Agent';
        }
        $dc=$agent.$this->agent->platform().$this->input->ip_address();
         $data=array(
            'action'=>$action,
            'data'=>$values,
            'device'=>$dc,
            'update_by'=>$nama,
            'update_time'=>gmdate('Y-m-d H:i:s',time()+60*60*7)
            );
        $this->db->insert('tbl_logdate',$data);

    }
}