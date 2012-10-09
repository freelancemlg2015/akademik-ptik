<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
        <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
        <title><?php if (isset($page_title)) echo $page_title; ?></title>
        <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
        <!--[if lt IE 9]>
          <script src="<?php echo base_url() ?>assets/js/html5.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap-responsive.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/docs.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/timepicker.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/shadowbox.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/combobox/bootstrap.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/combobox/bootstrap-combobox.css" type="text/css">
        <link href="<?php echo base_url() ?>assets/css/jUI/jquery-ui-1.8.17.custom.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/js/google-code-prettify/prettify.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/lib/google-chart-tooltip.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/main.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>assets/css/application.css" rel="stylesheet">

        <script type="text/javascript">
            var site_url = "<?php echo site_url(); ?>" ;
            var user_nip = "<?php //echo $auth->logged_in(); ?>" ;
            function confirm_it(message)
            {
                var answer = confirm(message)
                if (answer){
                    return true;
                }
    
                return false;  
            } 
        </script>
    </head>
    <body>
        <!--<div class="container-fluid" id="main-container">-->