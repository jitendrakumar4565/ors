<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Change Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form id="updatePasswordForm" name="updatePasswordForm">
                        <div class="card card-primary card-outline">
                            <div class="card-header">                       
                                <div class="card-tools float-left">
                                    Change Password
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body login-card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Enter old password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="old_pwd" name="old_pwd" required="" placeholder="Enter password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-eye old_pwd" style="cursor: pointer" onclick="showHidePwd('old_pwd')"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Enter new password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="new_pwd" name="new_pwd" required="" placeholder="Enter confirm password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-eye new_pwd" style="cursor: pointer" onclick="showHidePwd('new_pwd')"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Enter confirm password <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="cnf_pwd" name="cnf_pwd" required="" placeholder="Enter confirm password">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-eye cnf_pwd" style="cursor: pointer" onclick="showHidePwd('cnf_pwd')"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row justify-content-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <button title="Chnage Password" type="submit" class="col-md-12 btn btn-outline-primary"><i class="fa fa-check"></i> Update Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/additional-methods.min.js"></script>
<script>
                                                            $(document).ready(function () {
                                                                $('form[id="updatePasswordForm"]').validate({
                                                                    rules: {
                                                                        old_pwd: {
                                                                            required: true,
                                                                        },
                                                                        new_pwd: {
                                                                            required: true,
                                                                        },
                                                                        ncnf_pwd: {
                                                                            required: true,
                                                                        }
                                                                    },
                                                                    messages: {
                                                                        old_pwd: {
                                                                            required: "Old password is required"
                                                                        },
                                                                        new_pwd: {
                                                                            required: "New password is required",
                                                                        },
                                                                        cnf_pwd: {
                                                                            required: "Confirm password is required",
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
                                                                        updateAdminPassword();
                                                                        //$('#loading').show();
                                                                    }
                                                                });
                                                            });

                                                            function updateAdminPassword() {
                                                                $('#loading').show();
                                                                // Ajax post
                                                                jQuery.ajax({
                                                                    type: "POST",
                                                                    url: "<?php echo base_url('home/updatePassword'); ?>",
                                                                    dataType: 'json',
                                                                    data: $("#updatePasswordForm").serialize(),
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            toastr.success(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                            $('#old_pwd').val('');
                                                                            $('#new_pwd').val('');
                                                                            $('#cnf_pwd').val('');
                                                                            window.location.href = "<?php echo base_url('page?name=home') ?>";
                                                                        } else {
                                                                            toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                        }
                                                                        $('#loading').hide();
                                                                    }
                                                                });
                                                            }

</script>