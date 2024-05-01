<style>
    .table.dataTable {     
        /*font-size: 1em;*/
    }
    .table.dataTable  {
        /* font-family: Verdana, Geneva, Tahoma, sans-serif;*/
        /* font-size: 1em;*/
    }
    .table th {
        padding: 10px;
    }
    .table td  {
        padding: 0.30rem;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Requisition Trash</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Requisition Trash</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12"> 
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-tools float-left">
                                <a href="<?php echo base_url('requiDraft/addNew') ?>" title="Add New Requisition" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus-circle"></i> Add New</a>
                            </div>
                            <div class="card-tools float-right">
                                <button title="Export Details" type="button" class="btn btn-sm btn-outline-success"><i class="fa fa-file-excel"></i> Export</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="data_details_table" class="table dataTable table-bordered table-striped nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Organisation</th>
                                        <th>Department</th>
                                        <th>Post</th>
                                        <th>Mode</th>
                                        <th>Entry Datetime</th>
                                        <th></th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>                                   
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="modal fade" id="modal_delete">
                    <div class="modal-dialog">
                        <div class="modal-body">
                            <form role="form" autocomplete="off" id="dataDeleteForm" name="dataDeleteForm" method="post">
                                <div class="modal-content card card-primary card-outline">
                                    <div class="card-header">                       
                                        <div class="float-left">
                                            Confirmation?
                                        </div>
                                        <div class="float-right">
                                            <a href="javascript:void(0)" data-dismiss="modal" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                        </div>                                        
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <p>Do you really want to delete..?</p>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="row card-footer justify-content-end">
                                        <div class="card-tools">
                                            <button title="Delete Record" type="button" onclick="confirmDeleteData()" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash ml-2"></i> Delete Record</button>
                                            <a href="javascript:void(0)" title="Close" data-dismiss="modal" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                        </div>                  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>                
            </div>

            <div class="row">
                <div class="modal fade" id="modal_preview_details">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-body">
                            <div class="modal-content card card-primary card-outline">
                                <div class="card-header">                       
                                    <div class="float-left">
                                        Preview Details
                                    </div>
                                    <div class="float-right">
                                        <a href="javascript:void(0)" data-dismiss="modal" class="close btn btn-sm" title="Close">
                                            <span aria-hidden="true">X Close</span>
                                        </a>
                                    </div>                                        
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body" id="previewDetailsHTML">
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>                
            </div>

            <div class="row">
                <div class="modal fade" id="modal_form_restore">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-body">
                            <form role="form" autocomplete="off" id="restoreDataForm" name="restoreDataForm" method="post">
                                <div class="modal-content card card-primary card-outline">
                                    <div class="card-header">                       
                                        <div class="float-left">
                                            Confirmation?
                                        </div>
                                        <div class="float-right">
                                            <a href="javascript:closeModal('modal_form_restore')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                        </div>                                        
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <p style="font-size: 14px;font-weight: bold">Are you sure wants to restore this form..?</p>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="row card-footer justify-content-end">
                                        <div class="card-tools">
                                            <button title="Confirm Restore" type="submit" onclick="confirmRestore()" class="btn btn-sm btn-outline-danger"><i class="fa fa-check-circle ml-2"></i> Restore</button>
                                            <a href="javascript:closeModal('modal_form_restore')" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                        </div>                  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>                
            </div>

        </div>
    </section>
</div>

<script src="<?php echo base_url('assets/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/additional-methods.min.js"></script>
<script>
                                                var myTable = "";
                                                var autoRefresh = true;
                                                $(document).ready(function () {
                                                    reload_datatables();
                                                });
                                                function reload_datatables() {
                                                    myTable = $('#data_details_table').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        searching: true,
                                                        "scrollX": true,
                                                        "lengthMenu": [[10, 20, 30, 40, 50, -1], [10, 20, 30, 40, 50, "All"]],
                                                        "autoWidth": true,
                                                        //dom: 'lBfrtip',
                                                        ajax: {url: "<?php echo site_url('requiTrash/ajax_list') ?>",
                                                            type: "POST",
                                                            data: function (data) {
                                                                // data.resolved_status = $('#resolved_status').val()
                                                            }
                                                        },
                                                        "footerCallback": function (row, data, start, end, display) {
                                                            var api = this.api();
                                                            var logout = api.ajax.json().logout;
                                                            var msg = api.ajax.json().msg;
                                                            if (logout) {
                                                                toastr.error(msg, "", {closeButton: true, timeOut: 5000});
                                                                window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                            }
                                                        },
                                                        columnDefs: [
                                                            {targets: [0, 4, 6], searchable: false, orderable: false},
                                                            {targets: [0, 1, 2, 4, 5, 6], width: "5px"},
                                                            {targets: [0], className: "text-center"},
                                                        ]
                                                    });
                                                }

                                                function deleteRecord(auto_id) {
                                                    $("#dataDeleteForm #auto_id").remove();
                                                    $('#dataDeleteForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + auto_id + "'/>");
                                                    $('#modal_delete').modal('show');
                                                }

                                                function confirmDeleteData() {
                                                    $('#loading').show();
                                                    // Ajax post
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('requiTrash/deleteTempTrash'); ?>",
                                                        dataType: 'json',
                                                        data: $("#dataDeleteForm").serialize(),
                                                        success: function (data) {
                                                            if (data.status) {
                                                                toastr.success(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                $('#modal_delete').modal('hide');
                                                                myTable.draw();
                                                            } else {
                                                                toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                            }
                                                            $('#loading').hide();
                                                        }
                                                    });
                                                }

                                                function previewRecord(id) {
                                                    $('#loading').show();
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('requiTrash/viewData'); ?>",
                                                        dataType: 'json',
                                                        data: {
                                                            auto_id: id
                                                        },
                                                        success: function (data) {
                                                            if (data.status) {
                                                                $('#previewDetailsHTML').html(data.previewDetailsHTML);
                                                                $('#modal_preview_details').modal({backdrop: 'static', keyboard: false});
                                                            } else {
                                                                toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                if (data.logout) {
                                                                   window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                }
                                                            }
                                                            $('#loading').hide();
                                                        }
                                                    });
                                                }

                                                function restoreRecord(autoid) {
                                                    $("#restoreDataForm #auto_id").remove();
                                                    $('#restoreDataForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + autoid + "'/>");
                                                    $('#modal_form_restore').modal({backdrop: 'static', keyboard: false});
                                                }

                                                function confirmRestore() {
                                                    $('#loading').show();
                                                    // Ajax post
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('requiTrash/restoreFormData'); ?>",
                                                        dataType: 'json',
                                                        data: $("#restoreDataForm").serialize(),
                                                        success: function (data) {
                                                            if (data.status) {
                                                                Toast.fire({icon: 'success', title: data.msg});
                                                                myTable.draw();
                                                                $('#modal_form_restore').modal('hide');
                                                                $('#modal_preview_details').modal('hide');
                                                            } else {
                                                                toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                            }
                                                            $('#loading').hide();
                                                        }
                                                    });
                                                }
</script>
