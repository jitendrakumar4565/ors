<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="This is Arunachal Pradesh Staff Selection Board Online Requisition System, APSSB">
        <link rel="shortcut icon" href="<?php echo base_url('assets/ors/favicon.png') ?>" type="image/x-icon">
        <title>ORS | Government of Arunachal Pradesh</title>
        <meta property="og:title" content="Arunachal Pradesh Staff Selection Board Online Requisition System, APSSB" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://apssb.nic.in/" />
        <meta property="og:image" content="<?php echo base_url('assets/ors/favicon.png') ?> Arunachal Pradesh Staff Selection Board Online Requisition System, APSSB" />
        <meta property="og:image:type" content="image/png">
        <meta property="og:image:height" content="200">
        <meta property="og:image:width" content="200">
        <meta property="og:description" content="Arunachal Pradesh Staff Selection Board, Arunachal Pradesh, APSSB" />
        <meta name="twitter:title" content="Arunachal Pradesh Staff Selection Board Online Requisition System, APSSB" />
        <meta name="twitter:description" content="Arunachal Pradesh Staff Selection Board Online Requisition System, APSSB" />
        <meta name="twitter:image" content="Arunachal Pradesh Staff Selection Board Online Requisition System, APSSB" />

        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/fontawesome-free/css/all.min.css') ?>"> 
        <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/4.5.0/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/toastr/toastr.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/css/select2.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">        <!-- DataTables -->
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/adminlte.min.css') ?>">
        <!--<script src="<?php //echo base_url('assets/plugins/jquery/jquery.min.js')                ?>"></script>-->
        <script src="<?php echo base_url('assets/ors/site/theme1/plugins/jquery/jquery-3.6.0.min.js') ?>"></script>
        <link href="<?php echo base_url('assets/mselect/jquery.multiselect_sm.css') ?>" rel="stylesheet" />
        <script src="<?php echo base_url('assets/mselect/jquery.multiselect_sm.js') ?>"></script>
        <style>
            .mycustomfile::-webkit-input-placeholder {
                color: #050606;                
                /*font-weight: bold;*/
            }
            .mycustomfile::-moz-placeholder {
                color: #050606;                
            }
            .mycustomfile:-ms-input-placeholder {
                color: #050606;                
            } 

            .mycustomfile:-o-input-placeholder {
                color: #050606;                
            }

            .mycustomfile:hover{
                cursor: pointer;
            }
        </style>
        <style>
            /* width */
            ::-webkit-scrollbar {
                width: 5px;
            }
            /* Track */
            ::-webkit-scrollbar-track {
                box-shadow: inset 0 0 5px grey; 
                border-radius: 10px;
            }
            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: #0d6efd; 
                border-radius: 10px;
            }
            /* Handle on hover */
            ::-webkit-scrollbar-thumb:hover {
                background: #b30000; 
            }

            fieldset.scheduler-border {
                border: 2px solid #4c98af !important;
                padding: 0 1.4em 0 1.4em !important;
                margin: 0 0 1.5em 0 !important;
                -webkit-box-shadow: 0px 0px 0px 0px #000;
                box-shadow: 0px 0px 0px 0px #000;
                border-radius: 5px;
            }
            legend.scheduler-border {
                font-size: 1.0em !important;
                font-weight: bold !important;
                text-align: left !important;
                width: auto;
                padding: 0 10px;
                border-bottom: none;
            }
            span.error {
                /*display: none !important;*/
                /* margin-left: 300px;*/
            }
            .error{

            }

            .mytable thead th{
                padding : 5px 5px 5px 5px;
                text-align: left;
                background-color: #4c98af;
                color: white;
            }
            .mytable tbody td{

            }

            .mytable1 tbody th{
                padding: 10px 5px 10px 15px;
            }

            .hide{
                display: none;
            }    
        </style>
        <style>
            #loading{
                display:block;
                position:fixed;
                top:0;
                left:0;
                z-index:10000;
                width:100%;
                height:100%;
                background-color:rgba(192,192,192,0.5);
                background-image:url("<?php echo base_url('assets/images/loader/loader.gif') ?>");
                background-repeat:no-repeat;
                background-position:center
            }
        </style>
        <!--<body class="layout-navbar-fixed text-sm accent-info">-->
    <body  class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
        <div class="col-lg-12 col-md-12 col-xs-12" id="loading"></div>        
        <div class="wrapper">