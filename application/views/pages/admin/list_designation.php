<style>
    .table.dataTable {     
        /*font-size: 1em;*/
    }
    .table.dataTable  {
        /* font-family: Verdana, Geneva, Tahoma, sans-serif;*/
        /* font-size: 1em;*/
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
                    <h1>Designation List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Designation Details List</li>
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
                            <div class="card-tools float-righ">
                                <a href="javascript:addDetails()" title="Add New Designation" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus-circle"></i> Add New Designation</a>
                                <button title="Export Details" type="button" onclick="filterData()" class="btn btn-sm btn-outline-success"><i class="fa fa-file-excel"></i> Export</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="candidate_details_table" class="table dataTable table-bordered table-striped nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Designation</th>
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
                <div class="modal fade" id="modal_dataForm">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-body">
                            <form role="form" autocomplete="off" id="dataForm" name="dataForm" method="post">
                                <div class="modal-content card card-primary card-outline">
                                    <div class="card-header">                       
                                        <div class="card-tools float-left modal-title">
                                            Add Designation Details
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12" id="msg_html">

                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Designation Full Name</label> <label class="text-danger">*</label>
                                                    <input type="text" required="" class="clearError form-control form-control-sm text-uppercase" id="desig_name" name="desig_name" maxlength="65" minlength="2" placeholder="Designation Full Name">
                                                </div>
                                            </div>                            
                                            <input type="hidden" name="add_update" id="add_update"/>
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="row card-footer justify-content-end">
                                        <div class="card-tools">
                                            <button title="Save Changes" type="submit" class="btn btn-sm btn-outline-primary"><i class="fa fa-check"></i> Save Changes</button>
                                            <a href="javascript:closeModal1()" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                        </div>                  
                                    </div>
                                </div>
                            </form>
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
                                                var autoRefresh = false;
                                                $(document).ready(function () {
                                                    reload_datatables();
                                                });
                                                function reload_datatables() {
                                                    myTable = $('#candidate_details_table').DataTable({
                                                        processing: true,
                                                        serverSide: true,
                                                        searching: true,
                                                        "scrollX": true,
                                                        "lengthMenu": [[10, 20, 30, 40, 50, -1], [10, 20, 30, 40, 50, "All"]],
                                                        "autoWidth": true,
                                                        //dom: 'lBfrtip',
                                                        ajax: {url: "<?php echo site_url('Designation/ajax_list') ?>",
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
                                                            {targets: [0, 2], searchable: false, orderable: false, width: "5px", className: "text-center"}
                                                        ]
                                                    });
                                                }

                                                function clearForm() {
                                                    $('#desig_name').val('');
                                                    $('#msg_html').html("");
                                                    $('.invalid-feedback').removeClass('invalid-feedback');
                                                    $('.is-invalid').removeClass('is-invalid');
                                                    $('.is-valid').removeClass('is-valid');
                                                    $('.error').remove();
                                                    $("#auto_id").remove();
                                                }

                                                function addDetails() {
                                                    $('#add_update').val('add');
                                                    clearForm();
                                                    $('#modal_dataForm .modal-title').html('Add Designation Details');
                                                    $('#modal_dataForm').modal({backdrop: 'static', keyboard: false});
                                                }

                                                function closeModal1() {
                                                    $('#add_update').val('add');
                                                    clearForm();
                                                    $('#modal_dataForm .modal-title').html('Add Designation Details');
                                                    $('#modal_dataForm').modal('hide');
                                                }

                                                // A $( document ).ready() block.
                                                $(document).ready(function () {
                                                    $('form[id="dataForm"]').validate({
                                                        rules: {
                                                            desig_name: {
                                                                required: true
                                                            }
                                                        },
                                                        messages: {
                                                            desig_name: {
                                                                required: "Designation name is required",
                                                            }
                                                        },
                                                        errorElement: 'span',
                                                        errorPlacement: function (error, element) {
                                                            error.addClass('invalid-feedback');
                                                            element.closest('.form-group').append(error);
                                                        },
                                                        highlight: function (element, errorClass, validClass) {
                                                            $(element).addClass('is-invalid');
                                                        },
                                                        unhighlight: function (element, errorClass, validClass) {
                                                            $(element).removeClass('is-invalid');
                                                            $(element).addClass('is-valid');
                                                        },
                                                        submitHandler: function (form) {
                                                            saveChanges();
                                                            //$('#loading').show();
                                                        }
                                                    });
                                                });

                                                function saveChanges() {
                                                    $('#loading').show();
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('Designation/saveChanges'); ?>",
                                                        dataType: 'json',
                                                        data: $("#dataForm").serialize(),
                                                        success: function (data) {
                                                            if (data.status) {
                                                                clearForm();
                                                                var html = '<div class="alert alert-success alert-dismissible">';
                                                                html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                                                                html += '<span> ' + data.msg + '</span>';
                                                                html += '</div>';
                                                                $('#msg_html').html(html);
                                                                toastr.success(data.msg, "", {timeOut: 5000});
                                                                myTable.draw();
                                                                closeModal1();
                                                            } else if (!(data.status)) {
                                                                $('#msg_html').html("");
                                                                var html = '<div class="alert alert-danger alert-dismissible">';
                                                                html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                                                                html += '<span> ' + data.msg + '</span>';
                                                                html += '</div>';
                                                                $('#msg_html').html(html);
                                                                toastr.error(data.msg, "", {timeOut: 5000});
                                                                if (data.logout) {
                                                                    window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                }
                                                            }
                                                            $('#loading').hide();
                                                        }
                                                    });
                                                }

                                                $('.clearError').keyup(function () {
                                                    $('#msg_html').html("");
                                                });



                                                function deleteDetail(auto_id) {
                                                    $("#dataDeleteForm #auto_id").remove();
                                                    $('#dataDeleteForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + auto_id + "'/>");
                                                    $('#modal_delete').modal('show');
                                                }

                                                function confirmDeleteData() {
                                                    $('#loading').show();
                                                    // Ajax post
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('Designation/deleteData'); ?>",
                                                        dataType: 'json',
                                                        data: $("#dataDeleteForm").serialize(),
                                                        success: function (data) {
                                                            if (data.status) {
                                                                toastr.success(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                $('#modal_delete').modal('hide');
                                                                myTable.draw();
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

                                                function editDetails(autoid) {
                                                    if (autoid != "") {
                                                        $('#loading').show();
                                                        // Ajax post
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url('Designation/getData'); ?>",
                                                            dataType: 'json',
                                                            data: {
                                                                id: autoid
                                                            },
                                                            success: function (resp_data) {
                                                                clearForm();
                                                                if (resp_data.status) {
                                                                    var data = resp_data.result;
                                                                    $('#modal_dataForm .modal-title').html('Edit Designation');
                                                                    $('#desig_name').val(data['desig_name']);
                                                                    $('#add_update').val('update');
                                                                    $('#dataForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + data['auto_id'] + "'/>");
                                                                    $('#modal_dataForm').modal({backdrop: 'static', keyboard: false});
                                                                } else {
                                                                    if (data.logout) {
                                                                        window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                    }
                                                                    toastr.error(resp_data.msg, "", {closeButton: true, timeOut: 5000});
                                                                }
                                                                $('#loading').hide();
                                                            }
                                                        });
                                                    } else {
                                                        toastr.error("ID is required", "", {closeButton: true, timeOut: 5000});
                                                    }
                                                }
</script>
