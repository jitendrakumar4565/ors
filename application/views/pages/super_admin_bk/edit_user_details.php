<style>
    #approval {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }
    #approval td, #approval th {
        border: 1px solid #ddd;
        padding: 5px;
    }
    #approval tr:nth-child(even){background-color: #f2f2f2;}
    #approval tr:hover {background-color: #ddd;}
    #approval th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: left;
        background-color: #4c98af;
        color: white;
    }    
</style>
<div class="box-body login-card-body" id="">
    <form role="form" autocomplete="off" id="userRegistrationFormEdit" name="userRegistrationFormEdit" method="post">
        <?php
        if ($userDetails != NULL) {
            $emailVer = $userDetails->is_email_verified;
            $mobVer = $userDetails->is_mob_verified;
            $loginAccess = $userDetails->login_access;
            $approvedFlag = $userDetails->approved_flag;
            ?>
            <div class="row">
                <input type="hidden" class="form-control form-control-sm" id="auto_id" name="auto_id" value="<?php echo $autoId; ?>"/>
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Enter email address <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="email" class="form-control form-control-sm" value="<?php echo $userDetails->email_id; ?>" id="email_id1" name="email_id1" maxlength="65" minlength="5" required="" placeholder="Enter email address">
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
                            <input type="text" class="form-control form-control-sm" value="<?php echo $userDetails->mobile_no; ?>" id="mobile_no1" name="mobile_no1" minlength="10" maxlength="10" placeholder="Enter mobile number">
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
                            <input type="text" class="form-control form-control-sm text-capitalize" value="<?php echo $userDetails->full_name; ?>" id="full_name1" name="full_name1" minlength="2" maxlength="65" required="" placeholder="Enter full name">
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
                        <select class="form-control form-control-sm"  id="usr_lvl1" name="usr_lvl1" style="width: 100%;">
                            <?php $lvl = $userDetails->user_lvl; ?>
                            <option value="UR" <?php
                            if ($lvl == 'UR') {
                                echo 'selected';
                            }
                            ?>>User</option>
                            <option value="AD" <?php
                            if ($lvl == 'AD') {
                                echo 'selected';
                            }
                            ?>>Admin</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <?php $desig = $userDetails->desig; ?>
                        <label for="exampleInputEmail1">Select designation <span class="text-danger">*</span></label>
                        <select class="form-control  select2" name="desig1" id="desig1"  style="width: 100%;">
                            <option value="">-Select-</option>
                            <?php
                            if ($desigList != NULL) {
                                foreach ($desigList as $dRow) {
                                    ?>
                                    <option <?php
                                    if ($desig == $dRow->auto_id) {
                                        echo 'selected';
                                    }
                                    ?> value="<?php echo $dRow->auto_id; ?>"><?php echo $dRow->desig_name; ?></option>
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
                        <label for="exampleInputEmail1">Select department <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-control select2" onchange="loadOrgName(this.value)" id="dept_id1" name="dept_id1" data-placeholder="Select department" style="width: 100%;">
                                <option value="">-Select-</option>
                                <?php
                                if ($deptList != NULL) {
                                    $deptId = $userDetails->dept_id;
                                    foreach ($deptList as $dRow) {
                                        ?>
                                        <option <?php
                                        if ($deptId == $dRow->auto_id) {
                                            echo 'selected';
                                        }
                                        ?> value="<?php echo $dRow->auto_id; ?>"><?php echo $dRow->dept_name; ?></option>
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
                        <select title="Select organisation/office"  class="form-control form-control-sm" id="org_id1"  name="org_id1[]" multiple=""  required="" data-placeholder="Select organisation/office" style="width: 100%;">
                        </select>
                    </div>
                </div>                                            
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email Verified <span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm"  id="email_ver1" name="email_ver1" style="width: 100%;">
                            <option value="N" <?php
                            if ($emailVer == 'N') {
                                echo 'selected';
                            }
                            ?>>NO</option>
                            <option value="Y" <?php
                            if ($emailVer == 'Y') {
                                echo 'selected';
                            }
                            ?>>YES</option>   
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Mobile Verified <span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm"  id="mob_ver1" name="mob_ver1" style="width: 100%;">
                            <option value="N" <?php
                            if ($mobVer == 'N') {
                                echo 'selected';
                            }
                            ?>>NO</option>
                            <option value="Y" <?php
                            if ($mobVer == 'Y') {
                                echo 'selected';
                            }
                            ?>>YES</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Login Access <span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm"  id="login_access1" name="login_access1" style="width: 100%;">
                            <option value="N" <?php
                            if ($loginAccess == 'N') {
                                echo 'selected';
                            }
                            ?>>NO</option>
                            <option value="Y" <?php
                            if ($loginAccess == 'Y') {
                                echo 'selected';
                            }
                            ?>>YES</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Approved <span class="text-danger">*</span></label>
                        <select class="form-control form-control-sm"  id="approved_flag1" name="approved_flag1" style="width: 100%;">
                            <option value="P" <?php
                            if ($approvedFlag == 'P') {
                                echo 'selected';
                            }
                            ?>>Pending</option>
                            <option value="A" <?php
                            if ($approvedFlag == 'A') {
                                echo 'selected';
                            }
                            ?>>Approved</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-12 ml-4">
                        <button title="Save Changes" type="submit" class="btn btn-outline-primary"><i class="fa fa-check"></i> Save Changes</button>
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            <?php }
            ?>
        </div><!-- /.box-body -->
    </form> 
</div>
<script>
    $(document).ready(function () {
        $('.select2').select2();
        $('#org_id1').multiselect({
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
            selectAll: true
        });
        loadUserMappOrg('<?php echo $deptId ?>', '<?php echo $autoId; ?>');
        $('form[id="userRegistrationFormEdit"]').validate({
            rules: {
                email_id1: {
                    required: true
                },
                mobile_no1: {
                    required: true
                },
                full_name1: {
                    required: true
                },
                usr_lvl1: {
                    required: true
                },
                desig1: {
                    required: true
                },
                "dept_id1": {
                    required: true
                },
                "org_id1[]": {
                    required: true
                },
                "email_ver1": {
                    required: true
                },
                "mob_ver1": {
                    required: true
                },
                "login_access1": {
                    required: true
                },
                "approved_flag1": {
                    required: true
                }
            },
            messages: {
                email_id1: {
                    required: "Enter email address"
                },
                mobile_no1: {
                    required: "Enter mobile number"
                },
                full_name1: {
                    required: "Enter full name"
                },
                usr_lvl1: {
                    required: "Select"
                },
                desig1: {
                    required: "Select designation"
                },
                "dept_id1": {
                    required: "Select department name"
                },
                "org_id1[]": {
                    required: "Select organisation"
                },
                "email_ver1": {
                    required: "Select"
                },
                "mob_ver1": {
                    required: "Select"
                },
                "login_access1": {
                    required: "Select"
                },
                "approved_flag1": {
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
                registerUser1();
            }
        });
    });


    function registerUser1() {
        $('#loading').show();
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url('user/editUserByAdmin'); ?>",
            dataType: 'json',
            data: $("#userRegistrationFormEdit").serialize(),
            success: function (data) {
                if (data.status) {
                    Toast.fire({icon: 'success', title: data.msg});
                    $('#modal_edit_details').modal('hide');
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

    function loadOrgName(deptid) {
        $('#loading').show();
        $('#org_id1').html('');
        if (deptid != "") {
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
                            $('#org_id1').append('<option value="' + data_dept['auto_id'] + '">' + data_dept['org_name'] + '</option>');
                        });
                        $('#org_id1').multiselect('reload');
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
            $('#loading').hide();
            $('#org_id').html('');
            $('#org_id').addClass('invalid-feedback');
            $('#org_id').addClass('is-invalid');
            $('#org_id').removeClass('is-valid');
        }
    }

    function loadUserMappOrg(deptid, userid) {
        $('#loading').show();
        $('#org_id1').html('');
        if (deptid != "") {
            // Ajax post
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url('organisation/userMappOrg'); ?>",
                dataType: 'json',
                data: {
                    dept_id: deptid,
                    user_id: userid
                },
                success: function (data) {
                    if (data.status) {
                        // Add options
                        $.each(data.result, function (index, data_dept) {
                            if (data_dept['status_flag'] != null) {
                                $('#org_id1').append('<option selected="" value="' + data_dept['auto_id'] + '">' + data_dept['org_name'] + '</option>');
                            } else {
                                $('#org_id1').append('<option value="' + data_dept['auto_id'] + '">' + data_dept['org_name'] + '</option>');
                            }
                        });
                        $('#org_id1').multiselect('reload');
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
            $('#loading').hide();
            $('#org_id').html('');
            $('#org_id').addClass('invalid-feedback');
            $('#org_id').addClass('is-invalid');
            $('#org_id').removeClass('is-valid');
        }
    }
</script>
