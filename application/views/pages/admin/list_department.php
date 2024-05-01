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
                    <h1>Departments List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Departments Details List</li>
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
                            <div class="card-tools float-right">
                                <a href="javascript:addDetails()" title="Add New Department" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus-circle"></i> Add New Department</a>
                                <button title="Export Details" type="button" class="btn btn-sm btn-outline-success"><i class="fa fa-file-excel"></i> Export</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="candidate_details_table" class="table dataTable table-bordered table-striped nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Department Name</th>
                                        <th>Address</th>
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
                                            Add Department Details
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12" id="msg_html">

                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Department Full Name</label> <label class="text-danger">*</label>
                                                    <input type="text" required="" class="clearError form-control form-control-sm text-uppercase" id="dept_name" name="dept_name" maxlength="65" minlength="2" placeholder="Department Full Name">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="inputEmail3" class="">Address</label>
                                                    <textarea class="form-control" maxlength="225" rows="3" name="dept_address" id="dept_address" placeholder="Enter address"></textarea>
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
                                                        ajax: {url: "<?php echo site_url('department/ajax_list') ?>",
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
                                                            {targets: [0, 3], searchable: false, orderable: false},
                                                            {targets: [0, 3], width: "5px"},
                                                            {targets: [0, 3], className: "text-center"}
                                                        ]
                                                    });
                                                }

                                                function clearForm() {
                                                    $('#dept_name').val('');
                                                    $('#dept_address').val('');
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
                                                    $('#modal_dataForm .modal-title').html('Add Department Details');
                                                    $('#modal_dataForm').modal({backdrop: 'static', keyboard: false});
                                                }

                                                function closeModal1() {
                                                    $('#add_update').val('add');
                                                    clearForm();
                                                    $('#modal_dataForm .modal-title').html('Add Department Details');
                                                    $('#modal_dataForm').modal('hide');
                                                }

                                                // A $( document ).ready() block.
                                                $(document).ready(function () {
                                                    $('form[id="dataForm"]').validate({
                                                        rules: {
                                                            dept_name: {
                                                                required: true
                                                            }
                                                        },
                                                        messages: {
                                                            dept_name: {
                                                                required: "Department name is required",
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
                                                        url: "<?php echo base_url('department/saveChanges'); ?>",
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
                                                        url: "<?php echo base_url('Department/deleteData'); ?>",
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

                                                function editDetails(autoid) {
                                                    if (autoid != "") {
                                                        // Ajax post
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url('Department/getData'); ?>",
                                                            dataType: 'json',
                                                            data: {
                                                                id: autoid
                                                            },
                                                            success: function (resp_data) {
                                                                clearForm();
                                                                if (resp_data.status) {
                                                                    var data = resp_data.result;
                                                                    $('#modal_dataForm .modal-title').html('Edit Department');
                                                                    $('#dept_name').val(data['dept_name']);
                                                                    $('#dept_address').val(data['dept_address']);
                                                                    $('#add_update').val('update');
                                                                    $('#dataForm').append("<input type='hidden' name='auto_id' id='auto_id' value='" + data['auto_id'] + "'/>");
                                                                    $('#modal_dataForm').modal({backdrop: 'static', keyboard: false});
                                                                } else {
                                                                    toastr.error(resp_data.msg, "", {closeButton: true, timeOut: 5000});
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
</script>
