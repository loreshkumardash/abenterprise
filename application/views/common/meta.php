<?php
            $accessar = json_decode($this->session->userdata('access_menus'));
            error_reporting(0);
            ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AB ENTERPRISE | Dashboard</title>
    <script src="https://cdn.ckeditor.com/4.24.0-lts/standard/ckeditor.js"></script>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- <link rel="apple-touch-icon" sizes="57x57" href="<?php echo base_url()?>icons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo base_url()?>icons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo base_url()?>icons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url()?>icons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo base_url()?>icons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo base_url()?>icons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo base_url()?>icons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo base_url()?>icons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url()?>icons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo base_url()?>icons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url()?>icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url()?>icons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url()?>icons/favicon-16x16.png"> -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/favicon.png');?>">
    <!--<link rel="manifest" href="<?php echo base_url()?>icons/manifest.json">-->
    <meta name="msapplication-TileColor" content="#ffffff">
    <!-- <meta name="msapplication-TileImage" content="<?php echo base_url()?>icons/ms-icon-144x144.png"> -->
    <meta name="theme-color" content="#ffffff">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?php echo base_url()?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url()?>bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url()?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?=base_url();?>bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>dist/css/AdminLTE.min.css">

    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url()?>dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/clockpicker.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo base_url()?>bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url()?>bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet"
        href="<?php echo base_url()?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?php echo base_url()?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?php echo base_url()?>bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?php echo base_url()?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>bower_components/SumoSelect/sumoselect.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/custom.css">
    <style type="text/css">
    .tbl_time tr:nth-child(odd) {
        background-color: #f8f9fa;
    }

    .tbl_time tr:nth-child(even) {
        background-color: #e9ecef;
    }

    .view_time tr:nth-child(even) {
        font-size: 10px;
        background-color: #f7f7d2;
    }

    .view_time tr:nth-child(odd) {
        font-size: 10px;
        background-color: #f8f9fa;
    }

    .view_time th {


        font-size: 10px;

        background-color: #b0cf8c;
    }

    .lowpaddinginput {
        height: 20px;
        padding: 2px 3px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 3px;
    }

    .td_width {
        width: 100px;
    }

    #container {
        height: auto;
        width: auto;

    }

    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }

    .highcharts-credits {
        display: none;
    }

    #load {
        width: 100%;
        height: 100%;
        position: fixed;
        z-index: 9999;
        background: url("https://www.creditmutuel.fr/cmne/fr/banques/webservices/nswr/images/loading.gif") no-repeat center center rgba(0, 0, 0, 0.25)
    }

    .pgl-loader {
        color: #002e6e;
        margin-top: 25%;
        width: 3px;
        aspect-ratio: 1;
        border-radius: 50%;
        box-shadow: 19px 0 0 7px, 38px 0 0 3px, 57px 0 0 0;
        transform: translateX(-38px);
        animation: loader 0.5s infinite alternate linear;
        -webkit-box-shadow: 19px 0 0 7px, 38px 0 0 3px, 57px 0 0 0;
        -webkit-transform: translateX(-38px);
        -webkit-animation: loader 0.5s infinite alternate linear;
    }

    @keyframes loader {
        50% {
            box-shadow: 19px 0 0 3px, 38px 0 0 7px, 57px 0 0 3px;
        }

        100% {
            box-shadow: 19px 0 0 0, 38px 0 0 3px, 57px 0 0 7px;
        }
    }

    @-webkit-keyframes loader {
        50% {
            box-shadow: 19px 0 0 3px, 38px 0 0 7px, 57px 0 0 3px;
        }

        100% {
            box-shadow: 19px 0 0 0, 38px 0 0 3px, 57px 0 0 7px;
        }
    }

    .ck-rounded-corners .ck.ck-editor_main>.ck-editoreditable,
    .ck.ck-editor_main>.ck-editor__editable.ck-rounded-corners {
        height: 200px;
    }
    </style>
</head>

<body class="sidebar-mini wysihtml5-supported fixed skin-yellow-light">