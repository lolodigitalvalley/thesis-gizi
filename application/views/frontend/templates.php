<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Case Base Reasoning Penyakit Gizi Buruk | Dashboard</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/';?>bootstrap/css/bootstrap.min.css">
        <!-- Custom Fonts -->
        <link href="<?php echo base_url().'assets/'; ?>plugins/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/iCheck/flat/blue.css">
        <!-- DataTables CSS -->
        <link href="<?php echo base_url().'assets/'; ?>plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- chosen CSS -->
        <link href="<?php echo base_url().'assets/'; ?>plugins/chosen/chosen.min.css" rel="stylesheet">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/'; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <script type="text/javascript"> 
            function base_url() {
                var url = location.href;  // entire url including querystring - also: window.location.href;
                var baseURL = url.substring(0, url.indexOf('/', 14));


                if (baseURL.indexOf('http://localhost') != -1) {
                    // Base Url for localhost
                    var url = location.href;  // window.location.href;
                    var pathname = location.pathname;  // window.location.pathname;
                    var index1 = url.indexOf(pathname);
                    var index2 = url.indexOf("/", index1 + 1);
                    var baseLocalUrl = url.substr(0, index2);

                    return baseLocalUrl + "/";
                }
                else {
                    // Root Url for domain name
                    return baseURL + "/";
                }

            }

            function ConfirmDelete(url) 
            {
                var agree = confirm("Are you sure you want to delete this item?");
                if (agree)
                    return location.href =  url;
                else
                    return false ;
            };


        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo site_url(); ?>" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>C</b>BR</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg">CBR Gizi Buruk</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation"> 
                <?php echo isset($navbar) ? $navbar : ''; ?>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <?php echo isset($sidebar) ? $sidebar : ''; ?>
                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <?php echo isset($content) ? $content : '' ?>
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.3.0
                </div>
                <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <?php //echo isset($ctrlsidebar) ? $ctrlsidebar : '' ?>
            </aside><!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->

        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url().'assets/';?>bootstrap/js/bootstrap.min.js"></script>

        <!-- DataTables JavaScript -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/dataTables/jquery.dataTables.js"></script>
        <script src="<?php echo base_url().'assets/'; ?>plugins/dataTables/dataTables.bootstrap.js"></script>

        <!-- daterangepicker 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
        -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/daterangepicker/daterangepicker.js"></script>
        <!-- datepicker -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Slimscroll -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- Chosen Plugin JavaScript -->
        <script src="<?php echo base_url().'assets/'; ?>plugins/chosen/chosen.jquery.min.js"></script>
        <script src="<?php echo base_url().'assets/'; ?>plugins/chosen/chosen.proto.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url().'assets/'; ?>dist/js/app.min.js"></script>

    <script>
    $(document).ready(function() {    
        $('#dataTables').dataTable();
    }); 
    </script>
    <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
      '.chosen-select-width'     : {width:"150%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
    </script>
    <script language="javascript" type="text/javascript">
        $(function() {
            $.configureBoxes();
        });
    </script>
    <script type="text/javascript">
        $('#select').DualListBox();
    </script>

    </body>
</html>
