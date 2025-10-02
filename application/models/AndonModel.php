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

class AndonModel extends CI_Model
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

    public function getData($post, $table)
    {
       if ($table == 'view_delivery') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('customer'),
                    Field::inst('po_no'),
                    Field::inst('order_date'),
                    Field::inst('item_po'),
                    Field::inst('pcs_po'),
                    Field::inst('plan_delv'),
                    Field::inst('packing_date'),
                    Field::inst('pcs_pull'),
                    Field::inst('pcs_pack'),
                    Field::inst('actual_delv'),
                    Field::inst('item_delv'),
                    Field::inst('pcs_delv'),
                    Field::inst('status')
                )

                ->on('preGet', function ($editor, $id) {
                    $editor->where(function ($q){
                    });
                })
                ->process($post)
                ->json();
         } elseif ($table == 'view_stockog') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('part_no'),
                    Field::inst('job_no'),
                    Field::inst('routing'),
                    Field::inst('subcont_code'),
                    Field::inst('customer_code'),
                    Field::inst('qty_box'),
                    Field::inst('min_pcs'),
                    Field::inst('max_pcs'),
                    Field::inst('min_box'),
                    Field::inst('max_box'),
                    Field::inst('sc'),
                    Field::inst('inc'),
                    Field::inst('ifp'),
                    Field::inst('stock'),
                    Field::inst('status_stock'),
                    Field::inst('plan_setting'),
                    Field::inst('stock_og'),
                    Field::inst('status_setting'),
                    Field::inst('qty_setting'),
                    Field::inst('order_customer'),
                    Field::inst('status_order'),
                    Field::inst('delv_date'),
                    Field::inst('remark')

                )

                ->on('preGet', function ($editor, $id) {
                    $editor->where(function ($q){
                     
                    });
                })
                ->process($post)
                ->json();
        } elseif ($table == 'view_tl') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('part_no'),
                    Field::inst('part_name'),
                    Field::inst('supplier_code'),
                    Field::inst('category'),
                    Field::inst('store'),
                    Field::inst('rack'),
                    Field::inst('satuan'),
                    Field::inst('qty_packing'),
                    Field::inst('min_stock'),
                    Field::inst('max_stock'),
                    Field::inst('odr'),
                    Field::inst('stock'),
                    Field::inst('status_stock')
                )

                ->on('preGet', function ($editor, $id) {
                    $editor->where(function ($q){
                     
                    });
                })
                ->process($post)
                ->json();
        }elseif ($table == 'tbl_stock_part') {
            Editor::inst($this->editorDb, $table)
                ->fields(
                    Field::inst('id'),
                    Field::inst('part_no_fsi'),
                    Field::inst('part_name'),
                    Field::inst('supplier_code'),
                    Field::inst('model'),
                    Field::inst('status_part'),
                    Field::inst('initial_date'),
                    Field::inst('initial_by'),
                    Field::inst('initial_stock'),
                    Field::inst('stock'),
                    Field::inst('on_delivery'),
                    Field::inst('po_qty'),
                    Field::inst('stock_akhir'),
                    Field::inst('status'),
                    Field::inst('last_update_in'),
                    Field::inst('pic_update_in'),
                    Field::inst('last_update_out'),
                    Field::inst('pic_update_out'),
                    Field::inst('update_by'),
                    Field::inst('update_time')
                )

                ->on('preGet', function ($editor, $id) {
                    $editor->where(function ($q){
                     
                    });
                })
                ->process($post)
                ->json();
        }
    }
}