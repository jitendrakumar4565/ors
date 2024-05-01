<section class="content pt-4 pb-2">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg font-weight-bold" style="text-decoration: underline">Change Password</p>
                        <div id="msg_html"> 
                            <?php $htmlmsg = $this->session->userdata('htmlmsg'); ?>
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <span><?php echo $htmlmsg; ?></span>
                            </div>
                        </div>                        
                        <form id="resetPasswordForm" name="resetPasswordForm" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Enter new password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="new_pwd" name="new_pwd" required="" placeholder="Enter new password">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-eye new_pwd" style="cursor: pointer" onclick="showHidePwd('new_pwd')"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Enter confirm password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control cnf_pwd" id="cnf_pwd" name="cnf_pwd" required="" placeholder="Enter confirm password">
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Enter OTP <span class="text-danger">*</span><span id="mobemailotp"></span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control font-weight-bold" value="<?php echo $this->session->userdata('mobemailotp'); ?>" id="email_mobile_otp" name="email_mobile_otp" maxlength="4" minlength="4" required="" placeholder="Enter OTP">
                                            <div class="input-group-append">
                                                <div class="btn btn-outline-danger" onclick="resendOtp('reset')">
                                                    <span class=""></span> Resend
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Enter captcha</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control alphabetsonly text-uppercase" id="captcha" name="captcha" maxlength="6" minlength="6" required="" placeholder="Enter Captcha">
                                            <div class="input-group-append">
                                                <span id="captImg"></span>
                                            </div>
                                            <div class="input-group-append">
                                                <div class="refreshCaptcha input-group-text" style="cursor: pointer" title="New Captcha"><i class="fa fa-refresh"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end pb-4">
                                <div class="col-12 pt-4">
                                    <button type="submit" class="btn btn-outline-primary btn-block"><i class="fa fa-check-circle mr-2"></i> Change Password</button>
                                </div>
                            </div>
                        </form>

                        <p class="mb-1">
                            <a href="<?php echo base_url('page?name=login') ?>">Already account, Login</a>
                        </p>
                        <p class="mb-0">
                            <a href="<?php echo base_url('page?name=register') ?>" class="text-center">Register a new membership</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="modal fade" id="modal_final_message">
                <div class="modal-dialog">
                    <div class="modal-content card card-primary card-outline">
                        <div class="card-header">
                            <div class="float-left text-success font-weight-bold">
                                Information
                            </div>
                            <div class="float-right">
                                <a href="<?php echo base_url() ?>" class="close btn btn-sm font-weight-bold" title="Close">
                                    <span aria-hidden="true">X Close</span>
                                </a>
                            </div> 
                        </div>
                        <div class="modal-body">
                            <div class="row">                                       
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span class="text-success font-weight-bold">Your password has been updated successfully!</span>
                                    </div>
                                </div>
                            </div>
                        </div>                
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
    </div>
</section>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/additional-methods.min.js"></script>
<script>
                                                    $(document).ready(function () {
                                                        $('.refreshCaptcha').on('click', function () {
                                                            $.get('<?php echo base_url() . 'captcha/refresh'; ?>', function (data) {
                                                                $('#captImg').html(data);
                                                                $('#captcha').val('');
                                                            });
                                                        });
                                                        $('.refreshCaptcha').click();
                                                    });
                                                    $(document).ready(function () {
                                                        $('form[id="resetPasswordForm"]').validate({
                                                            rules: {
                                                                new_pwd: {
                                                                    required: true
                                                                },
                                                                cnf_pwd: {
                                                                    required: true
                                                                },
                                                                email_mobile_otp: {
                                                                    required: true
                                                                },
                                                                "captcha": {
                                                                    required: true
                                                                }
                                                            },
                                                            messages: {
                                                                new_pwd: {
                                                                    required: "Enter new password"
                                                                },
                                                                cnf_pwd: {
                                                                    required: "Enter confirm password"
                                                                },
                                                                email_mobile_otp: {
                                                                    required: "Enter OTP"
                                                                },
                                                                "captcha": {
                                                                    required: "Enter captcha"
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
                                                                resetPassword();
                                                            }
                                                        });
                                                    });

                                                    function resetPassword() {
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url('user/resetPassword'); ?>",
                                                            dataType: 'json',
                                                            data: $("#resetPasswordForm").serialize(),
                                                            success: function (data) {
                                                                if (data.status) {
                                                                    $('#modal_final_message').modal({backdrop: 'static', keyboard: false});
                                                                } else if (!(data.status)) {
                                                                    $('#msg_html').html("");
                                                                    var html = '<div class="alert alert-danger alert-dismissible">';
                                                                    html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                                                                    html += '<span> ' + data.msg + '</span>';
                                                                    html += '</div>';
                                                                    $('#msg_html').html(html);
                                                                    if (data.logout) {
                                                                        window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                    }
                                                                }
                                                            }});
                                                    }

                                                    function resendOtp(id) {
                                                        // Ajax post
                                                        jQuery.ajax({
                                                            type: "POST",
                                                            url: "<?php echo base_url('user/resendOtp'); ?>",
                                                            dataType: 'json',
                                                            data: {
                                                                type: id
                                                            },
                                                            success: function (data) {
                                                                if (data.status) {
                                                                    Toast.fire({icon: 'success', title: data.msg});
                                                                    $('#mobemailotp').html(data.mobemailotp);
                                                                    $('#email_mobile_otp').val('');
                                                                } else {
                                                                    if (data.logout) {
                                                                        window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                    }
                                                                    toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                }
                                                            }
                                                        });
                                                    }
</script>