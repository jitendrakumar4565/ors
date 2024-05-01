<section class="content pt-4 pb-2">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-12 col-sm-8 col-xs-12 col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg font-weight-bold" style="text-decoration: underline">Forgot Password</p>
                        <div id="msg_html">  

                        </div>
                        <form id="forgotPasswordForm" name="forgotPasswordForm" method="post">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email_mobile">Enter email address or mobile number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="email_mobile" name="email_mobile" required="" placeholder="Enter email address or mobile number">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-envelope"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="captcha">Enter captcha</label>
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
                                <div class="col-6 pt-4">
                                    <button type="submit" class="btn btn-outline-primary btn-block"><i class="fa fa-check-circle mr-2"></i> Submit</button>
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
        $('form[id="forgotPasswordForm"]').validate({
            rules: {
                email_mobile: {
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
                forgotPassword();
            }
        });
    });

    function forgotPassword() {
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('user/forgotPassword'); ?>",
            dataType: 'json',
            data: $("#forgotPasswordForm").serialize(),
            success: function (data) {
                if (data.status) {
                    //Toast.fire({icon: 'success', title: data.msg});
                    window.location.href = "<?php echo base_url('page?name=resetPassword'); ?>";
                } else if (!(data.status)) {
                    $('#msg_html').html("");
                    var html = '<div class="alert alert-danger alert-dismissible">';
                    html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
                    html += '<span> ' + data.msg + '</span>';
                    html += '</div>';
                    $('#msg_html').html(html);
                }
            }});
    }
</script>