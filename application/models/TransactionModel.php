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

class TransactionModel extends CI_Model
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
        $ex = explode('-', $table);
        $table = $ex[0];
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
        // $qt = $this->db->get_where('tbl_master_approver', array('username' => $username), 1)->row();
        
        // if(!empty($qt)){
        //     $title=$qt->title;
        // }else{
        //     $title='';
        // }
        if($table=='tbl_order_supplier'){
            Editor::inst( $this->editorDb, $table)
                ->fields(
                Field::inst('id'),
                Field::inst('periode')->validator('Validate::notEmpty'),
                Field::inst('calc_date')->validator('Validate::notEmpty'),
                Field::inst('delv_date')->setFormatter(Format::ifEmpty(null)),
                Field::inst('order_no')->validator('Validate::notEmpty'),
                Field::inst('part_no_fsi')->validator('Validate::notEmpty'),
                Field::inst('part_name')->validator('Validate::notEmpty'),
                Field::inst('model')->validator('Validate::notEmpty'),
                Field::inst('supplier_code')->validator('Validate::notEmpty'),
                Field::inst('qty_box')->setFormatter(Format::ifEmpty(0)),
                Field::inst('storage')->setFormatter(Format::ifEmpty(null)),
                Field::inst('no_box')->setFormatter(Format::ifEmpty(null)),
                Field::inst('order_box')->setFormatter(Format::ifEmpty(0)),
                Field::inst('order_pcs')->setFormatter(Format::ifEmpty(0)),
                Field::inst('rec_pcs')->setFormatter(Format::ifEmpty(0)),
                Field::inst('remain_pcs')->setFormatter(Format::ifEmpty(0)),
                Field::inst('rec_by')->setFormatter(Format::ifEmpty(null)),
                Field::inst('rec_date')->setFormatter(Format::ifEmpty(null)),
                Field::inst('status')->validator('Validate::notEmpty'),
                Field::inst('update_by')->set(true)->setValue($nama),
                Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                )
            ->on( 'preGet', function ( $editor,$id ) use($user_level,$field,$value){
                        $editor->where( function ( $q ) use($user_level,$field,$value){
                            if($field){
                                    $val_t=explode(',,',$value);
                                    $fie_t=explode(',,',$field);
                                    $ex_x=count($val_t);
                                    for ($i = 0; $i < $ex_x; $i++) {
                                        $ex = explode('|', $val_t[$i]);
                                        if($ex[0]=='null' and $ex[1]=='='){
                                             $q->where($fie_t[$i], null);
                                        }else{
                                            if ($ex[1] == 'IN') {
                                                $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                            } else {
                                                $q->where($fie_t[$i], $ex[0], $ex[1]);
                                            }
                                        }
                                        
                                    }
                                   
                                }

                        });
                        
                } )     
            ->process( $post )
            ->json();
        } elseif($table=='tbl_h_packing'){
            Editor::inst( $this->editorDb, $table)
                ->fields(
                Field::inst('id'),
                Field::inst('customer')->validator('Validate::notEmpty'),
                Field::inst('po_no')->validator('Validate::notEmpty'),
                Field::inst('part_no_customer')->validator('Validate::notEmpty'),
                Field::inst('part_no_fsi')->validator('Validate::notEmpty'),
                Field::inst('part_name')->validator('Validate::notEmpty'),
                Field::inst('qr_label_customer')->setFormatter(Format::ifEmpty(null)),
                Field::inst('qr_label_fsi')->setFormatter(Format::ifEmpty(null)),
                Field::inst('qr_kbn_customer')->setFormatter(Format::ifEmpty(null)),
                Field::inst('qr_case')->setFormatter(Format::ifEmpty(null)),
                Field::inst('qty')->setFormatter(Format::ifEmpty(0)),
                Field::inst('pos_name')->setFormatter(Format::ifEmpty(null)),
                Field::inst('scan_time')->setFormatter(Format::ifEmpty(null)),
                Field::inst('scan_by')->setFormatter(Format::ifEmpty(null)),
                Field::inst('update_by')->set(true)->setValue($nama),
                Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                )
            ->on( 'preGet', function ( $editor,$id ) use($user_level,$field,$value){
                        $editor->where( function ( $q ) use($user_level,$field,$value){
                            if($field){
                                    $val_t=explode(',,',$value);
                                    $fie_t=explode(',,',$field);
                                    $ex_x=count($val_t);
                                    for ($i = 0; $i < $ex_x; $i++) {
                                        $ex = explode('|', $val_t[$i]);
                                        if($ex[0]=='null' and $ex[1]=='='){
                                             $q->where($fie_t[$i], null);
                                        }else{
                                            if ($ex[1] == 'IN') {
                                                $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                            } else {
                                                $q->where($fie_t[$i], $ex[0], $ex[1]);
                                            }
                                        }
                                        
                                    }
                                   
                                }

                        });
                        
                } ) 
            ->on( 'preEdit', function ( $editor, $id, $values ) use ($nama,$table) {             
                $this->logdate('edit'.$table.$id,$values['po_no'].'#'.$values['part_no_fsi'].'#'.$values['pos_name'], $nama); 
            } )
            ->on( 'preRemove', function ($editor, $id, $values ) use($nama,$table) {
                $this->logdate('remove'.$table.$id,$values['po_no'].'#'.$values['part_no_fsi'].'#'.$values['pos_name'],$nama);
                } )
            ->on( 'preCreate', function ( $editor,$values) use($nama,$table) {
                $this->logdate('create'.$table.'0',$values['po_no'].'#'.$values['part_no_fsi'].'#'.$values['pos_name'],$nama);                    
                } )             
            ->process( $post )
            ->json();
        }elseif($table=='tbl_order_customer'){
            Editor::inst( $this->editorDb, $table)
                ->fields(
                Field::inst('id'),
                Field::inst('po_adm')->setFormatter(Format::ifEmpty(null)),
                Field::inst('periode')->validator('Validate::notEmpty'),
                Field::inst('customer')->validator('Validate::notEmpty'),
                Field::inst('po_no')->validator('Validate::notEmpty'),
                Field::inst('po_date')->validator('Validate::notEmpty'),
                Field::inst('po_item')->validator('Validate::notEmpty'),
                Field::inst('part_no_customer')->validator('Validate::notEmpty'),
                Field::inst('part_name')->validator('Validate::notEmpty'),
                Field::inst('model_code')->setFormatter(Format::ifEmpty(null)),
                Field::inst('po_qty')->setFormatter(Format::ifEmpty(0)),
                Field::inst('kbn_qty')->setFormatter(Format::ifEmpty(0)),
                Field::inst('pallet_size')->setFormatter(Format::ifEmpty(null)),
                Field::inst('case_no')->setFormatter(Format::ifEmpty(null)),
                Field::inst('delv_date')->validator('Validate::notEmpty'),
                Field::inst('kbn_customer')->validator('Validate::unique')->setFormatter(Format::ifEmpty(null)),
                Field::inst('packing_date')->setFormatter(Format::ifEmpty(0)),
                Field::inst('pulling')->setFormatter(Format::ifEmpty(0)),
                Field::inst('part_check')->setFormatter(Format::ifEmpty(0)),
                Field::inst('packing')->setFormatter(Format::ifEmpty(0)),
                Field::inst('packing_check')->setFormatter(Format::ifEmpty(0)),
                Field::inst('delivery')->setFormatter(Format::ifEmpty(0)),
                Field::inst('status')->validator('Validate::notEmpty'),
                Field::inst('scan_packing')->setFormatter(Format::ifEmpty(null)),
                Field::inst('scan_delv')->setFormatter(Format::ifEmpty(null)),
                Field::inst('update_by')->set(true)->setValue($nama),
                Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                )
            ->on( 'preGet', function ( $editor,$id ) use($user_level,$field,$value){
                        $editor->where( function ( $q ) use($user_level,$field,$value){
                            if($field){
                                    $val_t=explode(',,',$value);
                                    $fie_t=explode(',,',$field);
                                    $ex_x=count($val_t);
                                    for ($i = 0; $i < $ex_x; $i++) {
                                        $ex = explode('|', $val_t[$i]);
                                        if($ex[0]=='null' and $ex[1]=='='){
                                             $q->where($fie_t[$i], null);
                                        }else{
                                            if ($ex[1] == 'IN') {
                                                $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                            } else {
                                                $q->where($fie_t[$i], $ex[0], $ex[1]);
                                            }
                                        }
                                        
                                    }
                                   
                                }

                        });
                        
                } )     
            ->process( $post )
            ->json();
         }elseif($table=='tbl_stock_part'){
            Editor::inst( $this->editorDb, $table)
                ->fields(
                Field::inst('id'),
                Field::inst('part_no_fsi')
                ->validator('Validate::notEmpty')
                ->validator(function ($val, $data, $field, $host) {
                          $qusr = $this->db->query("SELECT * FROM tbl_master_partlist WHERE part_no_fsi='" . $data['part_no_fsi'] . "' LIMIT 1")->row();                             
                            if(empty($qusr)){
                                return 'part_no_fsi must have registered in master partlist';
                            }else{
                                return true;
                            }
                        }),
                Field::inst('part_name')->setFormatter(Format::ifEmpty(null)),
                Field::inst('supplier_code')->setFormatter(Format::ifEmpty(null)),
                Field::inst('model')->setFormatter(Format::ifEmpty(null)),
                Field::inst('status_part')->setFormatter(Format::ifEmpty(null)),
                Field::inst('initial_date')
                    ->validator( Validate::dateFormat(
                    'Y-m-d',ValidateOptions::inst()->allowEmpty( true )
                    )),
                Field::inst('initial_by')->setFormatter(Format::ifEmpty(null)),
                Field::inst('initial_stock')->setFormatter(Format::ifEmpty(0)),
                Field::inst('stock')->setFormatter(Format::ifEmpty(0)),
                Field::inst('on_delivery')->setFormatter(Format::ifEmpty(0)),
                Field::inst('po_qty')->setFormatter(Format::ifEmpty(0)),
                Field::inst('stock_akhir')->setFormatter(Format::ifEmpty(0)),
                Field::inst('status')->setFormatter(Format::ifEmpty(null)),
                Field::inst('last_update_in')->setFormatter(Format::ifEmpty(null)),
                Field::inst('pic_update_in')->setFormatter(Format::ifEmpty(null)),
                Field::inst('last_update_out')->setFormatter(Format::ifEmpty(null)),
                Field::inst('pic_update_out')->setFormatter(Format::ifEmpty(null)),
                Field::inst('update_by')->set(true)->setValue($nama),
                Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                )
            ->on( 'preGet', function ( $editor,$id ) use($user_level,$field,$value,$nama){
                $this->db->query("INSERT INTO tbl_stock_part(part_no_fsi,part_name,supplier_code,model,status_part,initial_date,initial_by,initial_stock,stock) SELECT a.part_no_fsi,a.part_name,a.supplier_code,a.model,a.status_part,date(now()),'".$nama."','0','0' FROM tbl_master_partlist a LEFT JOIN tbl_stock_part b ON(a.part_no_fsi=b.part_no_fsi) WHERE b.part_no_fsi is null group by a.part_no_fsi");
                $this->db->query("UPDATE tbl_stock_part A, tbl_master_partlist B set A.part_name=B.part_name,A.supplier_code=B.supplier_code,A.model = B.model, A.status_part = B.status_part WHERE A.part_no_fsi=B.part_no_fsi and A.status_part!=B.status_part");
                
                 $this->db->query("UPDATE tbl_stock_part set po_qty=0");
                $this->db->query("UPDATE tbl_stock_part A, tbl_order_customer B LEFT JOIN tbl_master_partlist C ON(B.part_no_customer=C.part_no_customer AND B.status NOT IN('Finish','Cancel')) set A.po_qty=(SELECT sum(D.po_qty) FROM tbl_order_customer D WHERE D.part_no_customer=B.part_no_customer AND D.status NOT IN('Finish','Cancel'))  WHERE A.part_no_fsi=C.part_no_fsi AND B.status NOT IN('Finish','Cancel')");
                $this->db->query("UPDATE tbl_stock_part A, tbl_stock_part B left join tbl_order_supplier C ON(B.part_no_fsi=C.part_no_fsi) set A.on_delivery=if(C.id is not null,(SELECT sum(D.remain_pcs) FROM tbl_order_supplier D WHERE D.part_no_fsi=B.part_no_fsi AND D.remain_pcs>0),0)  WHERE A.part_no_fsi=B.part_no_fsi");
                 $this->db->query("UPDATE tbl_stock_part set stock_akhir=(stock+on_delivery)-po_qty");
                 $this->db->query("UPDATE tbl_stock_part set status=if(stock_akhir<0,'Need Order',if(stock_akhir>=0 and stock<po_qty and on_delivery>0,'On Delivery','Aman'))");
                        $editor->where( function ( $q ) use($user_level,$field,$value){
                            if($field){
                                    $val_t=explode(',,',$value);
                                    $fie_t=explode(',,',$field);
                                    $ex_x=count($val_t);
                                    for ($i = 0; $i < $ex_x; $i++) {
                                        $ex = explode('|', $val_t[$i]);
                                        if($ex[0]=='null' and $ex[1]=='='){
                                             $q->where($fie_t[$i], null);
                                        }else{
                                            if ($ex[1] == 'IN') {
                                                $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                            } else {
                                                $q->where($fie_t[$i], $ex[0], $ex[1]);
                                            }
                                        }
                                        
                                    }
                                   
                                }

                        });
                        
                } )     
            ->process( $post )
            ->json();
        }elseif($table == 'tbl_h_misscan') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('part_no_true')->validator('Validate::notEmpty'),
                    Field::inst('part_no_false')->validator('Validate::notEmpty'),
                    Field::inst('scan_by')->validator('Validate::notEmpty'),
                    Field::inst('scan_time')->validator('Validate::notEmpty'),
                    Field::inst('problem')->validator('Validate::notEmpty'),
                    Field::inst('pos_name')->validator('Validate::notEmpty'),
                    Field::inst('leader_by')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('leader_time')->setFormatter(Format::ifEmpty(null)),
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
                                if($ex[0]=='null' and $ex[1]=='='){
                                     $q->where($fie_t[$i], null);
                                }else{
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
        }elseif($table == 'tbl_h_receiving') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('qrcode')->validator('Validate::notEmpty'),
                    Field::inst('qty_receipt')->validator('Validate::notEmpty'),
                    Field::inst('scan_by')->validator('Validate::notEmpty'),
                    Field::inst('scan_time')->validator('Validate::notEmpty'),
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
                                if($ex[0]=='null' and $ex[1]=='='){
                                     $q->where($fie_t[$i], null);
                                }else{
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
        }elseif($table == 'tbl_h_scrap') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('qrcode')->validator('Validate::notEmpty'),
                    Field::inst('part_no_fsi')->validator('Validate::notEmpty'),
                    Field::inst('qty_scrap')->validator('Validate::notEmpty'),
                    Field::inst('problem')->validator('Validate::notEmpty'),
                    Field::inst('scan_by')->validator('Validate::notEmpty'),
                    Field::inst('scan_time')->validator('Validate::notEmpty'),
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
                                if($ex[0]=='null' and $ex[1]=='='){
                                     $q->where($fie_t[$i], null);
                                }else{
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
        }elseif($table=='tbl_h_calc'){
            Editor::inst( $this->editorDb, $table)
                ->fields(
                Field::inst('id'),
                Field::inst('periode')->validator('Validate::notEmpty'),
                Field::inst('calc_date')->validator('Validate::notEmpty'),
                Field::inst('part_no_fsi')->validator('Validate::notEmpty'),
                Field::inst('part_name')->validator('Validate::notEmpty'),
                Field::inst('supplier_code')->validator('Validate::notEmpty'),
                Field::inst('model')->setFormatter(Format::ifEmpty(null)),
                Field::inst('status_part')->setFormatter(Format::ifEmpty(null)),
                Field::inst('qty_box')->setFormatter(Format::ifEmpty(0)),
                Field::inst('min_stock')->setFormatter(Format::ifEmpty(0)),
                Field::inst('max_stock')->setFormatter(Format::ifEmpty(0)),
                Field::inst('stock')->setFormatter(Format::ifEmpty(0)),
                Field::inst('forecast')->setFormatter(Format::ifEmpty(0)),
                Field::inst('po_qty')->setFormatter(Format::ifEmpty(0)),
                Field::inst('last_calc')->setFormatter(Format::ifEmpty(0)),
                Field::inst('calc_pcs')
                ->validator('Validate::numeric')
                ->validator( 'Validate::minMaxNum', array(
                    'min' => 1,
                    'max' => 100000000,
                    'message' => 'Please enter a number min 1'
                ) ),
                Field::inst('calc_box')->setFormatter(Format::ifEmpty(0)),
                Field::inst('status')->validator('Validate::notEmpty'),
                Field::inst('update_by')->set(true)->setValue($nama),
                Field::inst('update_time')->set(true)->setValue(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))
                )
            ->on( 'preGet', function ( $editor,$id ) use($user_level,$field,$value){
                        $editor->where( function ( $q ) use($user_level,$field,$value){
                            if($field){
                                    $val_t=explode(',,',$value);
                                    $fie_t=explode(',,',$field);
                                    $ex_x=count($val_t);
                                    for ($i = 0; $i < $ex_x; $i++) {
                                        $ex = explode('|', $val_t[$i]);
                                        if($ex[0]=='null' and $ex[1]=='='){
                                             $q->where($fie_t[$i], null);
                                        }else{
                                            if ($ex[1] == 'IN') {
                                                $q->where($fie_t[$i], $ex[0], $ex[1], false);
                                            } else {
                                                $q->where($fie_t[$i], $ex[0], $ex[1]);
                                            }
                                        }
                                        
                                    }
                                   
                                }

                        });
                        
                } )
            ->on( 'preEdit', function ( $editor, $id, $values ) {             
                $calc_box=ceil($values['calc_pcs']/$values['qty_box']);
                if($values['qty_box'] == 0) {
                    $calc_box = 1;
                 }
                $editor
                    ->field( 'calc_box' )
                    ->setValue($calc_box);
            } )     
            ->process( $post )
            ->json();
        } elseif ($table == 'tbl_h_mispacking') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('part_no_true')->validator('Validate::notEmpty'),
                    Field::inst('part_no_false')->validator('Validate::notEmpty'),
                    Field::inst('scan_by')->validator('Validate::notEmpty'),
                    Field::inst('scan_time')->validator('Validate::notEmpty'),
                    Field::inst('problem')->validator('Validate::notEmpty'),
                    Field::inst('leader_by')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('leader_time')->setFormatter(Format::ifEmpty(null)),
                    Field::inst('update_by'),
                    Field::inst('update_time')
                )
                ->on('preGet', function ($editor, $id) use ($user_level, $field, $value) {
                    $editor->where(function ($q) use ($user_level, $field, $value) {
                        if ($field) {
                            $val_t = explode(',,', $value);
                            $fie_t = explode(',,', $field);
                            $ex_x = count($val_t);
                            for ($i = 0; $i < $ex_x; $i++) {
                                $ex = explode('|', $val_t[$i]);
                                if($ex[0]=='null' and $ex[1]=='='){
                                     $q->where($fie_t[$i], null);
                                }else{
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
        } elseif ($table == 'tbl_history_sale') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('invoice_code')->validator('Validate::notEmpty'),
                    Field::inst('cashier')->validator('Validate::notEmpty'),
                    Field::inst('customer_id')->validator('Validate::notEmpty'),
                    Field::inst('customer_name')->validator('Validate::notEmpty'),
                    Field::inst('phone')->validator('Validate::notEmpty'),
                    Field::inst('cart_source')->validator('Validate::notEmpty'),
                    Field::inst('total_amount')->validator('Validate::notEmpty'),
                    Field::inst('pay_amount')->validator('Validate::notEmpty'),
                    Field::inst('payment_type')->validator('Validate::notEmpty'),
                    Field::inst('status')->validator('Validate::notEmpty'),
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
                                if($ex[0]=='null' and $ex[1]=='='){
                                     $q->where($fie_t[$i], null);
                                }else{
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
        } elseif ($table == 'tbl_history_sale_detail') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('sale_id')->validator('Validate::notEmpty'),
                    Field::inst('product_code')->validator('Validate::notEmpty'),
                    Field::inst('product_name')->validator('Validate::notEmpty'),
                    Field::inst('quantity')->validator('Validate::notEmpty'),
                    Field::inst('unit_price')->validator('Validate::notEmpty'),
                    Field::inst('sub_total')->validator('Validate::notEmpty'),
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
                                if($ex[0]=='null' and $ex[1]=='='){
                                     $q->where($fie_t[$i], null);
                                }else{
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
        
        elseif ($table == 'tbl_mis_posting') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('posting_date'),
                    Field::inst('category'),
                    Field::inst('pos_level'),
                    Field::inst('true_part_no'),
                    Field::inst('true_rack_no'),
                    Field::inst('true_sensor_no'),
                    Field::inst('false_part_no'),
                    Field::inst('false_rack_no'),
                    Field::inst('false_sensor_no'),
                    Field::inst('leader_confirm'),
                    Field::inst('problem'),
                    Field::inst('problem_date')
                )
                ->on('preGet', function ($editor, $id) use ($user_level, $field, $value) {
                    $editor->where(function ($q) use ($user_level, $field, $value) {
                        if ($field) {
                            $val_t = explode(',,', $value);
                            $fie_t = explode(',,', $field);
                            $ex_x = count($val_t);
                            for ($i = 0; $i < $ex_x; $i++) {
                                $ex = explode('|', $val_t[$i]);
                                if($ex[0]=='null' and $ex[1]=='='){
                                     $q->where($fie_t[$i], null);
                                }else{
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
        elseif ($table == 'tbl_temp_posting') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('supplier_name'),
                    Field::inst('part_no'),
                    Field::inst('qr_supplier'),
                    Field::inst('pos_level'),
                    Field::inst('rack_actual'),
                    Field::inst('rack_id'),
                    Field::inst('c_no')->validator('Validate::notEmpty'),
                    Field::inst('sensor_no'),
                    Field::inst('range_sensor'),
                    Field::inst('scan_by'),
                    Field::inst('scan_date'),
                    Field::inst('posting_date')
                )
                ->on('preGet', function ($editor, $id) use ($user_level, $field, $value) {
                    $editor->where(function ($q) use ($user_level, $field, $value) {
                        if ($field) {
                            $val_t = explode(',,', $value);
                            $fie_t = explode(',,', $field);
                            $ex_x = count($val_t);
                            for ($i = 0; $i < $ex_x; $i++) {
                                $ex = explode('|', $val_t[$i]);
                                if($ex[0]=='null' and $ex[1]=='='){
                                     $q->where($fie_t[$i], null);
                                }else{
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