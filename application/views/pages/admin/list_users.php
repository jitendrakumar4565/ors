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
    .multiselect-container {
        width: 100% !important;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url() ?>">Home</a></li>
                        <li class="breadcrumb-item active">Users List</li>
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
                                <a href="javascript:addUser()" title="Add New User" class="btn btn-sm btn-outline-primary"><i class="fa fa-plus-circle"></i> Add New User</a>
                                <button title="Export Details" type="button" onclick="filterData()" class="btn btn-sm btn-outline-success"><i class="fa fa-file-excel"></i> Export</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="data_details_table" class="table dataTable text-sm table-bordered table-striped nowrap" width="100%">
                                <thead>
                                    <tr>
                                        <th>Sno</th>
                                        <th>Full Name</th>
                                        <th>Designation</th>
                                        <th>Mobile No</th>
                                        <th>Level</th>
                                        <th></th>
                                        <th>Status</th>
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
                    <div class="modal-dialog modal-xl">
                        <div class="modal-body">
                            <form role="form" autocomplete="off" id="userRegistrationForm" name="userRegistrationForm" method="post">
                                <div class="modal-content card card-primary card-outline">
                                    <div class="card-header">                       
                                        <div class="card-tools float-left modal-title">
                                            Add/Edit User Details
                                        </div>
                                    </div>
                                    <!-- /.card-header -->
                                    <div class="card-body login-card-body">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Enter email address <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="email" class="form-control form-control-sm" id="email_id" name="email_id" maxlength="65" minlength="5" required="" placeholder="Enter email address">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-envelope"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Enter mobile number <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm digitsonly" id="mobile_no" name="mobile_no" minlength="10" maxlength="10" placeholder="Enter mobile number">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-phone"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="">Enter full name <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control form-control-sm text-capitalize alphabetsspaceonly" id="full_name" name="full_name" minlength="2" maxlength="65" required="" placeholder="Enter full name">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-user"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Level <span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm"  id="usr_lvl" name="usr_lvl" style="width: 100%;">
                                                        <option value="UR">User</option>
                                                        <option value="AD">Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Select designation <span class="text-danger">*</span></label>
                                                    <select class="form-control select2" name="desig" id="desig" data-placeholder="Select designation" style="width: 100%;">
                                                        <option value="">-Select-</option>
                                                        <?php
                                                        if ($desigList != NULL) {
                                                            foreach ($desigList as $dRow) {
                                                                ?>
                                                                <option value="<?php echo $dRow->auto_id; ?>"><?php echo $dRow->desig_name; ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>                                                      
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Enter password <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control form-control-sm" id="pwd" name="pwd" required="" placeholder="Enter password">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-eye pwd" style="cursor: pointer" onclick="showHidePwd('pwd')"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Enter confirm password <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control form-control-sm" id="cnf_pwd" name="cnf_pwd" required="" placeholder="Enter confirm password">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-eye cnf_pwd" style="cursor: pointer" onclick="showHidePwd('cnf_pwd')"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Select department <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <select class="form-control select2" onchange="loadOrgName(this.value)" id="dept_id" name="dept_id" data-placeholder="Select department" style="width: 100%;">
                                                            <option value="">-Select-</option>
                                                            <?php
                                                            if ($deptList != NULL) {
                                                                foreach ($deptList as $dRow) {
                                                                    ?>
                                                                    <option value="<?php echo $dRow->auto_id; ?>"><?php echo $dRow->dept_name; ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Select organisation/office <span class="text-danger">*</span></label>
                                                    <select title="Select organisation/office"  class="form-control form-control-sm" id="org_id"  name="org_id[]" multiple=""  required="" data-placeholder="Select organisation/office" style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Email Verified <span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm"  id="email_ver" name="email_ver" style="width: 100%;">
                                                        <option value="N">NO</option>
                                                        <option value="Y">YES</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Mobile Verified <span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm"  id="mob_ver" name="mob_ver" style="width: 100%;">
                                                        <option value="N">NO</option>
                                                        <option value="Y">YES</option>                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Login Access <span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm"  id="login_access" name="login_access" style="width: 100%;">
                                                        <option value="N">NO</option>
                                                        <option value="Y">YES</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Approved <span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm"  id="approved_flag" name="approved_flag" style="width: 100%;">
                                                        <option value="P">Pending</option>
                                                        <option value="A">Approved</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="row card-footer justify-content-end">
                                        <div class="card-tools">
                                            <button title="Save Changes" type="submit" class="btn btn-outline-primary"><i class="fa fa-check"></i> Save Changes</button>
                                            <a href="javascript:void(0)" data-dismiss="modal" title="Close" class="btn btn-outline-danger"><i class="fa fa-times"></i> Close</a>
                                        </div>                  
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>                
            </div>

            <div class="row">
                <div class="modal fade" id="modal_view_details">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content card card-primary card-outline">
                            <div class="card-header">
                                <div class="float-left text-success font-weight-bold">
                                    Details
                                </div>
                                <div class="float-right">
                                    <a href="javascript:void(0)" data-dismiss="modal" class="close btn btn-sm text-sm font-weight-bold" title="Close">
                                        <span aria-hidden="true">X Close</span>
                                    </a>
                                </div> 
                            </div>
                            <div class="modal-body">
                                <div class="" id="htmlData">                                       


                                </div>
                            </div>                
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>

            <div class="row">
                <div class="modal fade" id="modal_edit_details">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content card card-primary card-outline">
                            <div class="card-header">
                                <div class="float-left text-success font-weight-bold">
                                    Details
                                </div>
                                <div class="float-right">
                                    <a href="javascript:void(0)" data-dismiss="modal" class="close btn btn-sm text-sm font-weight-bold" title="Close">
                                        <span aria-hidden="true">X Close</span>
                                    </a>
                                </div> 
                            </div>
                            <div class="modal-body">
                                <div class="" id="editData">                                       


                                </div>
                            </div>                
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
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
                                                    $('#org_id').multiselect({
                                                        includeSelectAllOption: true,
                                                        enableFiltering: true,
                                                        buttonWidth: '100%',
                                                        maxHeight: 200,
                                                        templates: {
                                                            button: '<button style="background-color:white;" type="button" class="form-control form-control-sm multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> <b class="caret"></b></button>',
                                                            ul: '<ul class="multiselect-container dropdown-menu pb-4"></ul>',
                                                            filter: '<div class="row"><div class="col-md-12"><div class="form-group"><li class="multiselect-item multiselect-filter"><div class="input-group"><input style="width:90%" class="multiselect-search" type="text"/></div></li>',
                                                            filterClearBtn: '<span class="input-group-append input-group-btn"><button class="btn btn-default multiselect-clear-filter" type="button"><i class="fa fa-times-circle"></i></button></span>',
                                                            li: '<li style="margin-left:-20px;"><a tabindex="0"><label></label></a></li>',
                                                            divider: '<li class="multiselect-item divider"></li>',
                                                            liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>',
                                                            resetButton: '<li class="multiselect-reset text-center"><div class="input-group"><a class="btn btn-default btn-block"></a></div></li></div></div></div>'
                                                        }
                                                    });
                                                    // $('#org_id option[value="N"]').prop('disabled', true);

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
                                                        ajax: {url: "<?php echo site_url('user/ajax_list') ?>",
                                                            type: "POST",
                                                            data: function (data) {
                                                                // data.resolved_status = $('#resolved_status').val()
                                                            }
                                                        },
                                                        "footerCallback": function (row, data, start, end, display) {
                                                            var api = this.api();
                                                            var logout = api.ajax.json().logout;
                                                            var msg = api.ajax.json().msg;
                                                            var nosPending = api.ajax.json().nosPending;
                                                            $('#nosUserPending').html(nosPending);
                                                            if (logout) {
                                                                toastr.error(msg, "", {closeButton: true, timeOut: 5000});
                                                                window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                            }
                                                        },
                                                        columnDefs: [
                                                            {targets: [0, 4, 5, 7], searchable: false, orderable: false},
                                                            {targets: [0, 2, 3, 4, 5, 6, 7], width: "5px"},
                                                            {targets: [0, 3, 4, 5, 6], className: "text-center"}
                                                        ]
                                                    });
                                                }

                                                function loadOrgName(deptid) {
                                                    $('#org_id').html('');
                                                    if (deptid != "") {
                                                        $('#loading').show();
                                                        // Ajax post
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url('organisation/loadOrgName'); ?>",
                                                            dataType: 'json',
                                                            data: {
                                                                dept_id: deptid
                                                            },
                                                            success: function (data) {
                                                                if (data.status) {
                                                                    // Add options
                                                                    $.each(data.result, function (index, data_dept) {
                                                                        $('#org_id').append('<option value="' + data_dept['auto_id'] + '">' + data_dept['org_name'] + '</option>');
                                                                    });
                                                                    $('#org_id').multiselect('rebuild');
                                                                } else {
                                                                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                    if (data.logout) {
                                                                        window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                    }
                                                                }
                                                                $('#loading').hide();
                                                            }
                                                        });
                                                    } else {
                                                        toastr.error("ID is required", "", {closeButton: true, timeOut: 5000});
                                                        $('#org_id').html('');
                                                        $('#org_id').addClass('invalid-feedback');
                                                        $('#org_id').addClass('is-invalid');
                                                        $('#org_id').removeClass('is-valid');
                                                    }
                                                }

                                                $(document).ready(function () {
                                                    $('form[id="userRegistrationForm"]').validate({
                                                        rules: {
                                                            email_id: {
                                                                required: true
                                                            },
                                                            mobile_no: {
                                                                required: true,
                                                                pattern: /^[6-9]{1}[0-9]{9}$/
                                                            },
                                                            full_name: {
                                                                required: true
                                                            },
                                                            usr_lvl: {
                                                                required: true
                                                            },
                                                            desig: {
                                                                required: true
                                                            },
                                                            pwd: {
                                                                required: true
                                                            },
                                                            cnf_pwd: {
                                                                required: true
                                                            },
                                                            "dept_id": {
                                                                required: true
                                                            },
                                                            "org_id[]": {
                                                                required: true
                                                            },
                                                            "email_ver": {
                                                                required: true
                                                            },
                                                            "mob_ver": {
                                                                required: true
                                                            },
                                                            "login_access": {
                                                                required: true
                                                            },
                                                            "approved_flag": {
                                                                required: true
                                                            }
                                                        },
                                                        messages: {
                                                            email_id: {
                                                                required: "Enter email address"
                                                            },
                                                            mobile_no: {
                                                                required: "Enter mobile number",
                                                                pattern: "Invalid mobile number"
                                                            },
                                                            full_name: {
                                                                required: "Enter full name"
                                                            },
                                                            usr_lvl: {
                                                                required: "Select"
                                                            },
                                                            desig: {
                                                                required: "Select designation"
                                                            },
                                                            pwd: {
                                                                required: "Enter password"
                                                            },
                                                            cnf_pwd: {
                                                                required: "Enter confirm password"
                                                            },
                                                            "dept_id": {
                                                                required: "Select department"
                                                            },
                                                            "org_id[]": {
                                                                required: "Select organisation/office"
                                                            },
                                                            "email_ver": {
                                                                required: "Select"
                                                            },
                                                            "mob_ver": {
                                                                required: "Select"
                                                            },
                                                            "login_access": {
                                                                required: "Select"
                                                            },
                                                            "approved_flag": {
                                                                required: "Select"
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
                                                            registerUser();
                                                        }
                                                    });
                                                });


                                                function registerUser() {
                                                    $('#loading').show();
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('user/registerUserByAdmin'); ?>",
                                                        dataType: 'json',
                                                        data: $("#userRegistrationForm").serialize(),
                                                        success: function (data) {
                                                            if (data.status) {
                                                                Toast.fire({icon: 'success', title: data.msg});
                                                                myTable.draw();
                                                                $('#modal_dataForm').modal('hide');
                                                                clearForm();
                                                            } else if (!(data.status)) {
                                                                if (data.logout) {
                                                                    window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                }
                                                                toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                            }
                                                            $('#loading').hide();
                                                        }
                                                    });
                                                }

                                                function addUser() {
                                                    //clearForm();
                                                    $('#modal_dataForm .modal-title').html('Add New User');
                                                    $('#modal_dataForm').modal({backdrop: 'static', keyboard: false});
                                                }

                                                function clearForm() {
                                                    $('#userRegistrationForm')[0].reset();
                                                    $('.invalid-feedback').removeClass('invalid-feedback');
                                                    $('.is-invalid').removeClass('is-invalid');
                                                    $('.is-valid').removeClass('is-valid');
                                                    $('.error').remove();
                                                    $('#dept_id').val('');
                                                    $('#org_id').html('');
                                                    $('#org_id').multiselect('reload');
                                                    $('.select2').select2();
                                                }

                                                function viewDetails(usrid) {
                                                    $('#loading').show();
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('user/viewDetails'); ?>",
                                                        dataType: 'json',
                                                        data: {
                                                            auto_id: usrid
                                                        },
                                                        success: function (data) {
                                                            if (data.status) {
                                                                $('#htmlData').html(data.htmlData)
                                                                $('#modal_view_details').modal({backdrop: 'static', keyboard: false});
                                                                myTable.draw();
                                                            } else if (!(data.status)) {
                                                                if (data.logout) {
                                                                    window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                }
                                                                toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                            }
                                                            $('#loading').hide();
                                                        }
                                                    });
                                                }

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
                                                        url: "<?php echo base_url('user/deleteUser'); ?>",
                                                        dataType: 'json',
                                                        data: $("#dataDeleteForm").serialize(),
                                                        success: function (data) {
                                                            if (data.status) {
                                                                Toast.fire({icon: 'success', title: data.msg});
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

                                                function editDetails(usrid) {
                                                    $('#loading').show();
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: "<?php echo base_url('user/editDetails'); ?>",
                                                        dataType: 'json',
                                                        data: {
                                                            auto_id: usrid
                                                        },
                                                        success: function (data) {
                                                            $('#loading').hide();
                                                            if (data.status) {
                                                                $('#editData').html(data.htmlData)
                                                                $('#modal_edit_details').modal({backdrop: 'static', keyboard: false});
                                                            } else if (!(data.status)) {
                                                                if (data.logout) {
                                                                    window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                }
                                                                toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                            }
                                                        }
                                                    });
                                                }

</script>
