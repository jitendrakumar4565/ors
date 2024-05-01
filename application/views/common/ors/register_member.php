<style>
    .ms-options-wrap > .ms-options > ul label {
        position: relative;
        display: inline-block;
        width: 100%;
        padding: 2px 4px 2px 20px;
        margin: 1px 0;
        border: 1px dotted transparent;
    }
    .ms-options-wrap > .ms-options > ul input[type="checkbox"] {
        margin: 0 5px 0 0;
        position: absolute;
        left: 4px;
        top: 7px;

    }

    .ms-options-wrap > button:focus, .ms-options-wrap > button {
        padding: 5px 20px 5px 10px;
    }
</style>
<section class="content pt-4 pb-2" style="">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 col-12 col-sm-12 col-xs-12 col-lg-10">
                <div class="card card-primary card-outline">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg font-weight-bold" style="text-decoration: underline">Registration</p>
                        <form id="userRegistrationForm" name="userRegistrationForm" method="post">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="email_id">Enter email address <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="email" class="form-control" id="email_id" name="email_id" maxlength="65" minlength="5" required="" placeholder="Enter email address">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fa fa-envelope"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="mobile_no">Enter mobile number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control digitsonly" id="mobile_no" name="mobile_no" minlength="10" maxlength="10" placeholder="Enter mobile number">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fa fa-phone"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="full_name" class="">Enter full name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control alphabetsspaceonly text-capitalize" id="full_name" name="full_name" minlength="2" maxlength="65" required="" placeholder="Enter full name">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fa fa-user"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="desig">Select designation <span class="text-danger">*</span></label>
                                        <select class="form-control select2" name="desig" id="desig" data-placeholder="Select designation"  style="width: 100%;">
                                            <option>Select designation</option>
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cnf_pwd">Enter confirm password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="cnf_pwd" name="cnf_pwd" required="" placeholder="Enter confirm password">
                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fa fa-eye cnf_pwd" style="cursor: pointer" onclick="showHidePwd('cnf_pwd')"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dept_id">Select department <span class="text-danger">*</span></label>
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
                                        <label for="org_id">Select organisation/office <span class="text-danger">*</span></label>
                                        <select title="Select organisation/office"  class="form-control" id="org_id"  name="org_id[]" multiple=""  required="" data-placeholder="Select organisation/office" style="width: 100%;">

                                        </select>
                                    </div>
                                </div>                                            
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="captcha">Enter captcha</label>
                                        <div class="input-group" id="" >
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
                            </div>

                            <div class="row text-center">
                                <div class="col-12 pt-4">
                                    <button type="submit" title="Register" class="btn btn-outline-primary col-md-4 col-6"><i class="fa fa-check"></i> Register</button>
                                    <a href="javascript:formReset()" title="Reset" class="btn btn-outline-danger"><i class="fa fa-refresh"></i> Reset</a>
                                </div>                  
                            </div>
                        </form>
                        <p class="mb-1">
                            <a href="<?php echo base_url('page?name=login') ?>">Already account, Login</a>
                        </p>
                        <p class="mb-0">

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
                                <div class="float-left text-success font-weight-bold">
                                    Registered Successfully
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
            <div class="modal fade" id="modal_msg">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content card card-primary card-outline">
                        <div class="card-header">
                            <div class="float-left text-info">
                                Information
                            </div>
                            <div class="float-right">
                                <a href="javascript:closeModal('modal_msg')" class="close btn btn-sm text-danger font-weight-bold" title="Close">
                                    <span class="fa fa-times-circle"></span><span aria-hidden="true"> Close</span>
                                </a>
                            </div> 
                        </div>
                        <div class="modal-body">
                            <div id="msg_html"></div>
                        </div>                
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
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
                                                            $(document).ready(function () {
                                                                $('#org_id').multiselect({
                                                                    columns: 1,
                                                                    placeholder: 'Select Organisation',
                                                                    search: true,
                                                                    showCheckbox: true,
                                                                    maxHeight: 100,
                                                                    searchOptions: {
                                                                        'default': 'Search Organisation'
                                                                                /* searchText: true, // search within the text               
                                                                                 searchValue: false,
                                                                                 */
                                                                    },
                                                                    fieldAttr: {
                                                                        id: 'org_id_search',
                                                                        name: 'org_id_search'
                                                                    },
                                                                    selectAll: true
                                                                });
                                                                $('.refreshCaptcha').on('click', function () {
                                                                    $.get('<?php echo base_url() . 'captcha/refresh'; ?>', function (data) {
                                                                        $('#captImg').html(data);
                                                                        $('#captcha').val('');
                                                                    });
                                                                });
                                                                $('.refreshCaptcha').click();
                                                            });

                                                            $(document).ready(function () {
                                                                //$('#modal_msg').modal({backdrop: 'static', keyboard: false});
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
                                                                            required: true,
                                                                            alphaspace: true
                                                                        },
                                                                        desig: {
                                                                            required: true
                                                                        },
                                                                        pwd: {
                                                                            required: true
                                                                        },
                                                                        cnf_pwd: {
                                                                            required: true,
                                                                            equalTo: "#pwd"
                                                                        },
                                                                        "dept_id": {
                                                                            required: true
                                                                        },
                                                                        "org_id[]": {
                                                                            required: true
                                                                        },
                                                                        "captcha": {
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
                                                                        desig: {
                                                                            required: "Select designation"
                                                                        },
                                                                        pwd: {
                                                                            required: "Enter password"
                                                                        },
                                                                        cnf_pwd: {
                                                                            required: "Enter confirm password",
                                                                            equalTo: "Password and confirm password should be same"
                                                                        },
                                                                        "dept_id": {
                                                                            required: "Select department name"
                                                                        },
                                                                        "org_id[]": {
                                                                            required: "Select organisation"
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
                                                                        registerUser();
                                                                    }
                                                                });
                                                            });


                                                            function registerUser() {
                                                                jQuery.ajax({
                                                                    type: "POST",
                                                                    url: "<?php echo base_url('user/registerUser'); ?>",
                                                                    dataType: 'json',
                                                                    data: $("#userRegistrationForm").serialize(),
                                                                    success: function (data) {
                                                                        if (data.status) {
                                                                            $('#modal_verify_otp').modal({backdrop: 'static', keyboard: false});
                                                                            formReset();
                                                                            $('#emailotp').html(data.emailotp);
                                                                            $('#mobotp').html(data.mobotp);
                                                                        } else if (!(data.status)) {
                                                                            $('#msg_html').html(data.msg);
                                                                            $('#modal_msg').modal({backdrop: 'static', keyboard: false});
                                                                            if (data.logout) {
                                                                                window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                            }
                                                                        }
                                                                    }});
                                                            }

                                                            function formReset() {
                                                                $('#userRegistrationForm')[0].reset();
                                                                $('.invalid-feedback').removeClass('invalid-feedback');
                                                                $('.is-invalid').removeClass('is-invalid');
                                                                $('.is-valid').removeClass('is-valid');
                                                                $('.error').remove();
                                                                $('#dept_id').val('');
                                                                $('#org_id').html('');
                                                                $('#org_id').multiselect('reload');
                                                                $('.select2').select2();
                                                                $('.refreshCaptcha').click();
                                                            }

                                                            function loadOrgName(deptid) {
                                                                $('#org_id').html('');
                                                                if (deptid != "") {
                                                                    // Ajax post
                                                                    jQuery.ajax({
                                                                        type: "POST",
                                                                        url: "<?php echo base_url('organisation/loadOrganisation'); ?>",
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
                                                                                $('#org_id').multiselect('reload');
                                                                            } else {
                                                                                toastr.error(data.msg, "", {closeButton: true, timeOut: 5000});
                                                                                if (data.logout) {
                                                                                    window.location.href = "<?php echo base_url('page?name=home'); ?>";
                                                                                }
                                                                            }
                                                                        }
                                                                    });
                                                                } else {
                                                                    $('#org_id').html('');
                                                                    $('#org_id').addClass('invalid-feedback');
                                                                    $('#org_id').addClass('is-invalid');
                                                                    $('#org_id').removeClass('is-valid');
                                                                }
                                                            }

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