<section class="content pt-4 pb-2" style="">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12 col-sm-8 col-xs-12 col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg font-weight-bold" style="text-decoration: underline">Login</p>
                        <div id="msg_html">  
                        </div>
                        <form id="loginForm" name="loginForm" method="post">
                            <div class="form-group">
                                <label for="email_mobile">Enter email address or mobile number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="email_mobile" name="email_mobile" minlength="10" maxlength="65" required="" placeholder="Enter email address or mobile number">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pwd">Enter password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="pwd" name="pwd" required="" placeholder="Enter password">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa fa-eye pwd" style="cursor: pointer" onclick="showHidePwd('pwd')"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group">
                                    <label for="captcha">Enter captcha</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control alphabetsonly text-uppercase" id="captcha" name="captcha" maxlength="6" minlength="6" required="" placeholder="Enter captcha">
                                        <div class="input-group-append">
                                            <span id="captImg"></span>
                                        </div>
                                        <div class="input-group-append">
                                            <div class="refreshCaptcha input-group-text" style="cursor: pointer" title="New Captcha"><i class="fa fa-refresh"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-lock mr-2"></i> Sign In</button>
                                </div>
                            </div>
                        </form>

                        <p class="mb-2 pt-4">
                            <a href="<?php echo base_url('page?name=forgotPassword') ?>">I forgot my password</a>
                        </p>
                        <p class="mb-1">
                            <a href="<?php echo base_url('page?name=register') ?>" class="text-center">Register a new membership</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="modal fade" id="modal_verify_otp">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-body">
                        <div class="modal-content card card-primary card-outline">
                            <div class="card-header">                       
                                <div class="float-left text-danger font-weight-bold">
                                    Pending Verification
                                </div>
                                <div class="float-right">
                                    <a href="javascript:closeModal('modal_verify_otp')" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                </div>                                        
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <?php
                                $emailOtp = $this->session->userdata('emailotp');
                                $mobOtp = $this->session->userdata('mobotp');
                                ?>
                                <div class="row">                                       
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <span class="text-danger font-weight-bold">Verify your email address and mobile number within 24-hours from date of registration, otherwise your registration will be auto delete</span>
                                        </div>
                                    </div>
                                </div>
                                <form method="post" id="verifyEmailOTPForm" name="verifyEmailOTPForm"> 
                                    <div class="row" id="verifyEmailOTPFormDiv">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="email_otp">Verify email <span class="text-danger">*</span><span id="emailotp"></span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control font-weight-bold" value="<?php echo $emailOtp; ?>" id="email_otp" name="email_otp" maxlength="4" minlength="4" required="" placeholder="Email OTP">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-outline-primary">
                                                            <span class="fas fa-check mr-2"></span> Verify
                                                        </button>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <div class="btn btn-outline-danger" onclick="resendOtp('email')">
                                                            <span class=""></span> Resend OTP
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form method="post" id="verifyMobileOTPForm" name="verifyMobileOTPForm">
                                    <div class="row" id="verifyMobileOTPFormDiv">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="mobile_otp">Verify mobile <span class="text-danger">*</span><span id="mobotp"></span></label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control font-weight-bold" value="<?php echo $mobOtp; ?>" id="mobile_otp" name="mobile_otp" maxlength="4" minlength="4" required="" placeholder="Mobile OTP">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-outline-primary">
                                                            <span class="fas fa-check mr-2"></span> Verify
                                                        </button>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <div class="btn btn-outline-danger" onclick="resendOtp('mobile')">
                                                            <span class=""></span> Resend OTP
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                            <div class="row card-footer text-center">
                                <div class="card-tools">
                                    <a href="javascript:changeEmailMobile()" title="Change email or mobile"class=""><i class="fa fa-edit"></i> Change email or mobile</a>
                                </div>                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>                
        </div>

        <div class="row">
            <div class="modal fade" id="modal_change_email_mobile">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-body">                        
                        <div class="modal-content card card-primary card-outline">
                            <div class="card-header">                       
                                <div class="float-left font-weight-bold">
                                    Change email address or mobile number
                                </div>
                                <div class="float-right">
                                    <a href="javascript:closeChangeEmailMobModal()" class="text-danger" title="Close"><i class="fa fa-times-circle"></i></a>
                                </div>                                        
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form role="form" autocomplete="off" id="changeEmailForm" name="changeEmailForm" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="new_email_id">Enter new email address <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="email" title="Enter new email address" class="form-control" id="new_email_id" name="new_email_id" maxlength="65" minlength="4" required="" placeholder="Email new email address">
                                                    <div title="Change email address" class="input-group-append">
                                                        <button type="submit" class="btn btn-outline-primary">
                                                            <span class=""></span> Change
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <form role="form" autocomplete="off" id="changeMobileForm" name="changeMobileForm" method="post">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="new_mob_no">Enter new mobile number <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" title="Eneter new mobile number" class="form-control" id="new_mob_no" name="new_mob_no" maxlength="10" minlength="10" required="" placeholder="Enter new mobile number">
                                                    <div class="input-group-append">
                                                        <button type="submit" title="Change mobile number"class="btn btn-outline-primary">
                                                            <span class=""></span> Change
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                            <div class="row card-footer text-right">
                                <div class="card-tools">
                                    <a href="javascript:closeChangeEmailMobModal()" title="Close" class="btn btn-sm btn-outline-danger"><i class="fa fa-times-circle"></i> Close</a>
                                </div>                  
                            </div>
                        </div>
                    </div>
                </div>
            </div>                
        </div>

        <div class="row">
            <div class="modal fade" id="modal_final_message">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content card card-primary card-outline">
                        <div class="card-header">
                            <div class="float-left text-success font-weight-bold">
                                Information
                            </div>
                            <div class="float-right">
                                <a href="<?php echo base_url() ?>" class="close btn btn-sm text-danger font-weight-bold" title="Close">
                                    <span aria-hidden="true">X Close</span>
                                </a>
                            </div> 
                        </div>
                        <div class="modal-body">
                            <div class="row">                                       
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span class="text-danger font-weight-bold">Your email address and mobile number is verified successfully and your registration is under process. You will get a notification once your registration is approved! </span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span class="text-danger font-weight-bold">Thanks, Teams APSSB</span>
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
                                                            $('.refreshCaptcha').on('click', function () {
                                                                $.get('<?php echo base_url() . 'captcha/refresh'; ?>', function (data) {
                                                                    $('#captImg').html(data);
                                                                    $('#captcha').val('');
                                                                });
                                                            });
                                                            $(document).ready(function () {
                                                                //$('#modal_verify_otp').modal('show');
                                                                $('.refreshCaptcha').click();
                                                                // $('#modal_verify_otp').modal({backdrop: 'static', keyboard: false});

                                                            });

                                                            $(document).ready(function () {
                                                                $('form[id="loginForm"]').validate({
                                                                    rules: {
                                                                        email_mobile: {
                                                                            required: true
                                                                        },
                                                                        pwd: {
                                                                            required: true
                                                                        },
                                                                        "captcha": {
                                                                            required: true
                                                                        }
                                                                    },
                                                                    messages: {
                                                                        email_mobile: {
                                                                            required: "Enter email address or mobile number"
                                                                        },
                                                                        pwd: {
                                                                            required: "Enter password"
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
                                                                        login();
                                                                    }
                                                                });
                                                            });

                                                            function login() {
                                                                jQuery.ajax({
                                                                    type: "POST",
                                                                    url: "<?php echo base_url('auth/signIn'); ?>",
                                                                    dataType: 'json',
                                                                    data: $("#loginForm").serialize(),
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            window.location.href = "<?php echo base_url('home'); ?>";
                                                                        } else if (!(data.status)) {
                                                                            var isEmailVerified = data.isEmailVerified;
                                                                            var isMobVerified = data.isMobVerified;
                                                                            if (isEmailVerified == "Y") {
                                                                                $('#verifyEmailOTPFormDiv').addClass('d-none');
                                                                            }
                                                                            if (isMobVerified == "Y") {
                                                                                $('#verifyMobileOTPFormDiv').addClass('d-none');
                                                                            }
                                                                            if (isEmailVerified == "N" || isMobVerified == "N") {
                                                                                $('#modal_verify_otp').modal({backdrop: 'static', keyboard: false});
                                                                            }

                                                                            $('#msg_html').html("");
                                                                            var html = '<div class="alert alert-danger alert-dismissible">';
                                                                            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                                                                            html += '<span> ' + data.msg + '</span>';
                                                                            html += '</div>';
                                                                            $('#msg_html').html(html);
                                                                        }
                                                                    }});
                                                            }

                                                            $('#loginForm .form-control').keypress(function (e) {
                                                                if (e.which == 13) {
                                                                    $('form#loginForm').submit();
                                                                }
                                                            });

                                                            $('.clearError').keyup(function () {
                                                                $('#msg_html').html("");
                                                            });

                                                            function closeModal(id) {
                                                                $('#' + id).modal('hide');
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
                                                                            if (data.emailotp != "") {
                                                                                $('#emailotp').html(data.emailotp);
                                                                                $('#email_otp').val('')
                                                                            }
                                                                            if (data.mobotp != "") {
                                                                                $('#mobotp').html(data.mobotp);
                                                                                $('#mobile_otp').val('')
                                                                            }
                                                                        } else {
                                                                            if (data.logout) {
                                                                                window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                            }
                                                                            toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                        }
                                                                    }
                                                                });
                                                            }

                                                            $(document).ready(function () {
                                                                $('form[id="verifyEmailOTPForm"]').validate({
                                                                    rules: {
                                                                        email_otp: {
                                                                            required: true,
                                                                            digits: true
                                                                        }
                                                                    },
                                                                    messages: {
                                                                        email_otp: {
                                                                            required: "Enter OTP"
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
                                                                        var otp = $('#email_otp').val();
                                                                        verifyOtp('email', otp);
                                                                    }
                                                                });
                                                            });

                                                            $(document).ready(function () {
                                                                $('form[id="verifyMobileOTPForm"]').validate({
                                                                    rules: {
                                                                        mobile_otp: {
                                                                            required: true,
                                                                            digits: true
                                                                        }
                                                                    },
                                                                    messages: {
                                                                        mobile_otp: {
                                                                            required: "Enter OTP"
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
                                                                        var otp = $('#mobile_otp').val();
                                                                        verifyOtp('mobile', otp);
                                                                    }
                                                                });
                                                            });

                                                            function verifyOtp(id, otp) {
                                                                // Ajax post
                                                                jQuery.ajax({
                                                                    type: "POST",
                                                                    url: "<?php echo base_url('user/verifyOtp'); ?>",
                                                                    dataType: 'json',
                                                                    data: {
                                                                        type: id,
                                                                        otp: otp
                                                                    },
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            Toast.fire({icon: 'success', title: data.msg});
                                                                            if (id == 'email') {
                                                                                $('#verifyEmailOTPFormDiv').addClass('d-none');
                                                                            }
                                                                            if (id == 'mobile') {
                                                                                $('#verifyMobileOTPFormDiv').addClass('d-none');
                                                                            }
                                                                            if (data.close_modal) {
                                                                                $('#modal_verify_otp').modal('hide');
                                                                                $('#modal_final_message').modal('show');
                                                                            }
                                                                        } else {
                                                                            if (data.logout) {
                                                                                window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                            }
                                                                            Toast.fire({icon: 'error', title: data.msg});
                                                                        }
                                                                    }
                                                                });
                                                            }

                                                            $(document).ready(function () {
                                                                $('form[id="changeEmailForm"]').validate({
                                                                    rules: {
                                                                        new_email_id: {
                                                                            required: true
                                                                        }
                                                                    },
                                                                    messages: {
                                                                        new_email_id: {
                                                                            required: "Enter new email address"
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
                                                                        updateEmail();
                                                                    }
                                                                });
                                                            });

                                                            $(document).ready(function () {
                                                                $('form[id="changeMobileForm"]').validate({
                                                                    rules: {
                                                                        new_mob_no: {
                                                                            required: true,
                                                                            digits: true
                                                                        }
                                                                    },
                                                                    messages: {
                                                                        new_mob_no: {
                                                                            required: "Enter new mobile number"
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
                                                                        updateMobile();
                                                                    }
                                                                });
                                                            });


                                                            function updateEmail() {
                                                                // Ajax post
                                                                jQuery.ajax({
                                                                    type: "POST",
                                                                    url: "<?php echo base_url('user/updateEmail'); ?>",
                                                                    dataType: 'json',
                                                                    data: $("#changeEmailForm").serialize(),
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            Toast.fire({icon: 'success', title: data.msg});
                                                                            $('#emailotp').html(data.emailotp);
                                                                            $('#email_otp').val('');
                                                                            $('#verifyEmailOTPFormDiv').removeClass('d-none');
                                                                        } else {
                                                                            Toast.fire({icon: 'error', title: data.msg});
                                                                            if (data.logout) {
                                                                                window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                            }
                                                                        }
                                                                    }
                                                                });
                                                            }

                                                            function updateMobile() {
                                                                // Ajax post
                                                                jQuery.ajax({
                                                                    type: "POST",
                                                                    url: "<?php echo base_url('user/updateMobile'); ?>",
                                                                    dataType: 'json',
                                                                    data: $("#changeMobileForm").serialize(),
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            Toast.fire({icon: 'success', title: data.msg});
                                                                            $('#mobotp').html(data.mobotp);
                                                                            $('#mobile_otp').val('');
                                                                            $('#verifyMobileOTPFormDiv').removeClass('d-none');
                                                                        } else {
                                                                            Toast.fire({icon: 'error', title: data.msg});
                                                                            if (data.logout) {
                                                                                window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                            }
                                                                        }
                                                                    }
                                                                });
                                                            }

                                                            function changeEmailMobile() {
                                                                $('#modal_verify_otp').modal('hide');
                                                                $('#modal_change_email_mobile').modal('show');
                                                            }

                                                            function closeChangeEmailMobModal() {
                                                                $('#modal_change_email_mobile').modal('hide');
                                                                $('#modal_verify_otp').modal('show');
                                                            }
</script>