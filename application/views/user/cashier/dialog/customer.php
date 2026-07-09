<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold">Customer</h4>
    </div>
    <div class="col-3 text-right">
        <button type="button" class="btn btn-danger btn-sm" onclick=" $('#modallg').modal('hide');">X</button>
    </div>
</div>
<div class="row mb-3">
    <div class="col-12 text-left">
        <button type="button" class="btn btn-primary btn-sm" onclick="formaddcustomer()">Add</button>
    </div>
</div>
<div class="row">
    <div class="col-4 border" style="height: 50vh; overflow-y:scroll;">
        <div class="list-group text-left pt-2">
            <?php
            $i = 1;
            foreach ($qmc as $key) { ?>
            <a onclick="detailcustomer('<?=$key->id ?>')" id="list-history-sale-<?=$key->id ?>"
                class="list-group-item list-group-item-action list-history-sale">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?=$key->id ?> - <?=$key->customer_name ?></h5>
                    </div>
                <p class="mb-1">
                    </p>
                <small><?=$key->city ?></small>

                <div class="text-right mt-2 pt-2 border-top">
                    <button type="button" class="btn btn-xs btn-warning text-white px-2 py-1" style="font-size: 11px; font-weight: 600; border-radius: 4px;" onclick="event.stopPropagation(); btn_edit('<?=$key->id ?>')">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button type="button" class="btn btn-xs btn-danger px-2 py-1" style="font-size: 11px; font-weight: 600; border-radius: 4px;" onclick="event.stopPropagation(); btn_delete('<?=$key->id ?>', '<?=$key->customer_name ?>')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </a>
            <?php }?>
        </div>
    </div>
    <div id="container-modal-right" class="col-8">
        </div>
</div>
<div class="row">
    <div class="col">
        <button type="button" class="btn btn-outline-danger btn-sm"
            onclick=" $('#modallg').modal('hide');">BATAL</button>
        </div>
</div>
<input type="hidden"
       id="csrf_sysx_name"
       value="<?= $this->security->get_csrf_hash(); ?>">

<script>

function detailcustomer(param) {
    $.ajax({
        type: "POST",
        url: "<?=base_url('cashier/detailcustomer?api='.$this->id_t); ?>",
        data: "saleid=" + param + "&<?= $this->security->get_csrf_token_name(); ?>=<?= $this->security->get_csrf_hash(); ?>",
        cache: false,
        success: function(res) {
            $('#container-modal-right').html(res);
            $(".list-history-sale").removeClass('active');
            $("#list-history-sale-" + param).addClass('active');
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal membuka detail customer'
            });
        }
    });
}

function formaddcustomer() {
    $.ajax({
        type: "GET",
        url: "<?=base_url('cashier/formaddcustomer?api='.$this->id_t); ?>",
        cache: false,
        success: function(res) {
            $('#container-modal-right').html(res);
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal membuka form customer'
            });
        }
    });
}

function cancel() {
    $("#modallg").modal('hide');
}

function printReceiptForm() {
    var cartid = $('#cartid').val();

    window.open(
        "<?=base_url('cashier/print_receipt');?>?cartid=" +
        cartid +
        "&api=<?=$this->id_t;?>",
        "_blank"
    );
}

/* ===========================
   EDIT CUSTOMER
=========================== */

function btn_edit(id)
{
    $.ajax({

        url: "<?= base_url('cashier/getcustomerbyid?api='.$this->id_t); ?>",

        type: "POST",

        data: {
            id: id,
            "<?= $this->security->get_csrf_token_name(); ?>":
            "<?= $this->security->get_csrf_hash(); ?>"
        },

        dataType: "json",

        success: function(data)
        {

            var html = `
                <h4 class="mb-3">Form Edit Customer</h4>

                <form id="formEditCustomer">

                    <input type="hidden"
                           name="id"
                           value="${data.id}">

                    <div class="form-group">
                        <label>Customer</label>
                        <input type="text"
                               class="form-control"
                               name="customer_name"
                               value="${data.customer_name}">
                    </div>

                    <div class="form-group">
                        <label>Customer Code</label>
                        <input type="text"
                               class="form-control"
                               name="customer_code"
                               value="${data.customer_code}">
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control" name="gender">

                            <option value="L" ${(data.gender == 'L' ? 'selected' : '')}>
                                Laki-laki
                            </option>

                            <option value="P" ${(data.gender == 'P' ? 'selected' : '')}>
                                Perempuan
                            </option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text"
                               class="form-control"
                               name="phone"
                               value="${data.phone}">
                    </div>

                    <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control"
                                  name="address">${data.address}</textarea>
                    </div>

                    <div class="form-group">
                        <label>City</label>
                        <input type="text"
                               class="form-control"
                               name="city"
                               value="${data.city}">
                    </div>

                    <br>

                    <button type="submit"
                            class="btn btn-warning">
                        Simpan Perubahan
                    </button>

                </form>
            `;

            $("#container-modal-right").html(html);
        },

        error: function(xhr)
        {
            console.log(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal mengambil data customer'
            });
        }

    });
}

/* ===========================
   UPDATE CUSTOMER
=========================== */

$(document).on('submit', '#formEditCustomer', function(e){

    e.preventDefault();

    $.ajax({

        url: "<?= base_url('cashier/editcustomersubmit?api='.$this->id_t); ?>",

        type: "POST",

        data: $(this).serialize() +
              "&<?= $this->security->get_csrf_token_name(); ?>=<?= $this->security->get_csrf_hash(); ?>",

        dataType: "json",

        success: function(res){

            if(res.success){

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data customer berhasil diperbarui',
                    confirmButtonColor: '#3085d6'
                }).then(() => {
                    location.reload();
                });

            }else{

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Data customer gagal diperbarui'
                });

            }

        },

        error: function(xhr){

            console.log(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Request update gagal'
            });

        }

    });

});

/* ===========================
   DELETE CUSTOMER
=========================== */

function btn_delete(id, name)
{
    Swal.fire({
        title: 'Hapus Customer?',
        html: 'Customer <b>' + name + '</b> akan dihapus permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if(result.isConfirmed){

            $.ajax({

                url: "<?= base_url('cashier/deletecustomer?api='.$this->id_t); ?>",

                type: "POST",

                data: {
                    id: id,
                    "<?= $this->security->get_csrf_token_name(); ?>":
                    "<?= $this->security->get_csrf_hash(); ?>"
                },

                dataType: "json",

                success: function(res){

                    if(res.success){

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Customer berhasil dihapus'
                        }).then(() => {
                            location.reload();
                        });

                    }else{

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Customer gagal dihapus'
                        });

                    }

                },

                error: function(xhr){

                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Request hapus gagal'
                    });

                }

            });

        }

    });
}

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>