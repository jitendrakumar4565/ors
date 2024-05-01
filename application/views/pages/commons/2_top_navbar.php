<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo base_url() ?>" class="nav-link"><i class="fa fa-home mr-1"></i>Home</a>
        </li>
    </ul>
    <?php
    $topNavAlert = "d-none";
    $inboxAlert = "d-none";
    $usrAlert = "d-none";
    $nosNotify = ($nosData['nosDirectReq'] + $nosData['nosLDCEReq'] + $nosData['nosUsr']);
    if ($nosNotify > 0) {
        $topNavAlert = "";
    }
    if (($nosData['nosDirectReq'] + $nosData['nosLDCEReq']) > 0) {
        $inboxAlert = "";
    }

    if (($nosData['nosUsr']) > 0) {
        $usrAlert = "";
    }
    ?>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown topNavAlert <?php echo $topNavAlert; ?>">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-success navbar-badge topNavAlertValue1"><?php echo $nosNotify; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header topNavAlertValue2"><?php echo $nosNotify; ?> Notifications</span>
                <div class="dropdown-divider inboxAlert <?php echo $inboxAlert; ?>"></div>
                <a href="#" class="dropdown-item inboxAlert <?php echo $inboxAlert; ?>">
                    <i class="fas fa-envelope mr-2"> </i> <span class="inboxAlertValue"> <?php echo ($nosData['nosDirectReq'] + $nosData['nosLDCEReq']); ?> </span> new inbox 
                    <span class="badge bg-success float-right mr-2 inboxAlertDValue"><?php echo $nosData['nosDirectReq'] ?></span>
                    <span class="badge bg-danger float-right mr-2 inboxAlertLValue"><?php echo $nosData['nosLDCEReq'] ?></span>
                </a>

                <div class="dropdown-divider usrAlert <?php echo $usrAlert; ?>"></div>
                <a href="#" class="dropdown-item usrAlert <?php echo $usrAlert; ?>">
                    <i class="fas fa-users mr-2 usrAlertValue"></i> <?php echo $nosData['nosUsr']; ?> user requests
                </a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <span><i class="fas fa-user-circle mr-1"></i><?php echo $this->session->userdata('fullname') ?> <i class="fa fa-angle-down"></i></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('home/changePwd') ?>" class="dropdown-item">
                    <i class="fa fa-lock mr-2"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?php echo base_url('user/logOut') ?>" class="dropdown-item">
                    <i class="fas fa-power-off mr-2 text-danger"></i> Logout
                </a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>