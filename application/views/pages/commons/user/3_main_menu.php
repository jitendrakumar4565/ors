<?php
$inboxAlert = "d-none";
$trashAlert = "d-none";
if (($nosData['nosDirectReq'] + $nosData['nosLDCEReq']) > 0) {
    $inboxAlert = "";
}

if (($nosData['nosDirectTrash'] + $nosData['nosLDCETrash']) > 0) {
    $trashAlert = "";
}
?>

<aside class="main-sidebar elevation-4 sidebar-light-info">
    <a href="<?php echo base_url(); ?>" class="brand-link">
        <img src="<?php echo base_url('assets/ors/favicon.png') ?>" alt="ORS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Requisition System</span>
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
                <li class="nav-header">Requisition</li>
                <li class="nav-item">
                    <a href="<?php echo base_url('requiDraft/addNew') ?>" class="nav-link <?php
                    if ($submenu == 'addNew') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon fas fa-envelope-open"></i>
                        <p>
                            Add New 
                            <span class="badge bg-primary float-right"></span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url('userInbox') ?>" class="nav-link <?php
                    if ($submenu == 'userInbox') {
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
                    <a href="<?php echo base_url('requiSent') ?>" class="nav-link <?php
                    if ($submenu == 'requiSent') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon far fa-envelope"></i>
                        <p>
                            Sent
                            <span class="badge bg-primary float-right"></span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url('requiDraft') ?>" class="nav-link <?php
                    if ($submenu == 'requiDraft') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>
                            Drafts
                            <span class="badge bg-primary float-right"></span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url('requiTrash') ?>" class="nav-link <?php
                    if ($submenu == 'requiTrash') {
                        echo 'active';
                    }
                    ?>">
                        <i class="nav-icon far fa-trash-alt"></i>
                        <p>
                            Trash
                            <span class="badge bg-success trashAlert nosDirectTrash right <?php echo $trashAlert; ?>"><?php echo $nosData['nosDirectTrash'] ?></span>
                            <span class="badge bg-danger trashAlert nosLDCETrash right <?php echo $trashAlert; ?>"><?php echo $nosData['nosLDCETrash'] ?></span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo base_url('userRecommended') ?>" class="nav-link <?php
                    if ($submenu == 'userRecommended') {
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