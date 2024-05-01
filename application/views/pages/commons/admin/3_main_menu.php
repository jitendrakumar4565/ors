<?php
$inboxAlert = "d-none";
$usrAlert = "d-none";
if (($nosData['nosDirectReq'] + $nosData['nosLDCEReq']) > 0) {
    $inboxAlert = "";
}

if (($nosData['nosUsr']) > 0) {
    $usrAlert = "";
}
?>

<aside class="main-sidebar elevation-4 sidebar-light-warning">
    <a href="<?php echo base_url(); ?>" class="brand-link">
        <img src="<?php echo base_url('assets/ors/favicon.png') ?>" alt="TMS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Requisition System</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent nav-compact" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?php echo base_url() ?>" class="nav-link <?php
                    if ($submenu == 'home') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fa fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>

                <li class="nav-item <?php
                if ($mainmenu == 'requisitions') {
                    echo 'menu-open';
                }
                ?>">
                    <a href="#" class="nav-link <?php
                    if ($mainmenu == 'requisitions') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fas fa-inbox"></i>
                        <p>
                            Requisitions
                            <i class="right fas fa-angle-left"></i>
                            <span class="badge bg-warning inboxAlert inboxAlertLValue right <?php echo $inboxAlert; ?>"><?php echo ($nosData['nosDirectReq'] + $nosData['nosLDCEReq']); ?></span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo base_url('requiInbox') ?>" class="nav-link <?php
                            if ($submenu == 'requiInbox') {
                                echo 'active';
                            }
                            ?>">
                                <i class="nav-icon fas fa-inbox"></i>
                                <p>
                                    Inbox 
                                    <span class="badge bg-success inboxAlert inboxAlertDValue right <?php echo $inboxAlert; ?>"><?php echo $nosData['nosDirectReq'] ?></span>
                                    <span class="badge bg-danger inboxAlert inboxAlertLValue right <?php echo $inboxAlert; ?>"><?php echo $nosData['nosLDCEReq'] ?></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('requiAccepted') ?>" class="nav-link <?php
                            if ($submenu == 'requiAccepted') {
                                echo 'active';
                            }
                            ?>">
                                <i class="nav-icon fa fa-check text-success"></i>
                                <p class="">
                                    Accepted
                                    <span class="badge bg-primary float-right"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('requiReturned') ?>" class="nav-link <?php
                            if ($submenu == 'requiReturned') {
                                echo 'active';
                            }
                            ?>">
                                <i class="nav-icon far fa-times-circle text-danger"></i>
                                <p>
                                    Returned
                                    <span class="badge bg-primary float-right"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('requiAdvertised') ?>" class="nav-link <?php
                            if ($submenu == 'requiAdvertised') {
                                echo 'active';
                            }
                            ?>">
                                <i class="nav-icon far fa-newspaper-o text-primary"></i>
                                <p>
                                    Advertised
                                    <span class="badge bg-primary float-right"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo base_url('requiRecommended') ?>" class="nav-link <?php
                            if ($submenu == 'requiRecommended') {
                                echo 'active';
                            }
                            ?>">
                                <i class="nav-icon far fa-thumbs-up text-success"></i>
                                <p>
                                    Recommended
                                    <span class="badge bg-primary float-right"></span>
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url('requiReport') ?>" class="nav-link <?php
                    if ($submenu == 'requiReport') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fa fa-file-text-o text-danger"></i>
                        <p>Report</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="javascript:void(0)" class="nav-link">
                        <i class="nav-icon fas fa-envelope-open"></i>
                        <p>Requisition Forms</p>
                        <div class="right custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" <?php
                            if ($this->session->userdata('newReqForm')) {
                                echo "checked='true'";
                            }
                            ?> id="requisition_form_btn">
                            <label class="custom-control-label" for="requisition_form_btn"></label>
                        </div>
                    </a>
                </li>

                <li class="nav-header">Master Setup</li>
                <li class="nav-item">
                    <a href="<?php echo base_url('postName') ?>" class="nav-link <?php
                    if ($submenu == 'postName') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fa fa-sticky-note-o"></i>
                        <p>
                            Post
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('department') ?>" class="nav-link <?php
                    if ($submenu == 'dept') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fas fa-city"></i>
                        <p>
                            Department
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url('organisation') ?>" class="nav-link <?php
                    if ($submenu == 'org') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fa fa-building-o"></i>
                        <p>
                            Organisation/Office
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url('designation') ?>" class="nav-link <?php
                    if ($submenu == 'designation') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fa fa-level-up"></i>
                        <p>
                            Designation
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url('user') ?>" class="nav-link <?php
                    if ($submenu == 'user') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            Users
                            <span class="badge bg-primary usrAlert usrAlertValue right <?php echo $usrAlert; ?>"> <?php echo $nosData['nosUsr'] ?></span>
                        </p>
                    </a>
                </li>


                <li class="nav-header">Setting</li>
                <li class="nav-item">
                    <a href="<?php echo base_url('home/changePwd') ?>" class="nav-link <?php
                    if ($submenu == 'changePwd') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fa fa-lock"></i>
                        <p>
                            Change Password
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="javascript:lockScreen()" class="nav-link ">
                        <i class="nav-icon fa fa-laptop text-danger"></i>
                        <p>
                            Screen Lock
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url('user/logOut') ?>" class="nav-link">
                        <i class="nav-icon fa fa-power-off text-danger"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<script>
    $(document).ready(function () {
        $("#requisition_form_btn").click(function () {
            if (this.checked) {
                enableDisableNewForm(1);
            }
            if (!this.checked) {
                enableDisableNewForm(0);
            }
        });

        function enableDisableNewForm(flag) {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url('requi/enableDisableNewForm'); ?>",
                dataType: 'json',
                data: {
                    flag: flag
                },
                success: function (data) {
                    if (data.status) {
                        Toast.fire({icon: 'success', title: data.msg});
                    } else if (!(data.status)) {
                        if (data.logout) {
                            window.location.href = "<?php echo base_url('page?name=home'); ?>";
                        }
                        Toast.fire({icon: 'error', title: data.msg});
                    }
                    $('#loading').hide();
                }
            });
        }

    });
</script>