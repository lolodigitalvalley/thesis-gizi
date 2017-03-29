<!-- Sidebar user panel -->
<div class="user-panel">
    <div class="pull-left image">
        <img src="<?php echo base_url().'assets/'; ?>dist/img/diesel.jpg" class="img-circle" alt="User Image">
    </div>
    <div class="pull-left info">
        <p>Herdiesel Santoso</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
    </div>
</div>

<!-- search form
<form action="#" method="get" class="sidebar-form">
    <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
        </span>
    </div>
</form>
 /.search form -->

<!-- sidebar menu: : style can be found in sidebar.less -->
<ul class="sidebar-menu">
    <li class="header">MENU UTAMA</li>
    <li>
        <a href="<?php echo site_url('dashboard');?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('penyakit');?>">
            <i class="fa fa-users"></i> <span>Data Penyakit</span>
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('gejala');?>">
            <i class="fa fa-users"></i> <span>Data Gejala</span>
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('basis_kasus');?>">
            <i class="fa fa-users"></i> <span>Basis Kasus</span>
        </a>
    </li>
    <li>
        <a href="<?php echo site_url('diagnosis');?>">
            <i class="fa fa-users"></i> <span>Diagnosis Baru</span>
        </a>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-files-o"></i>
             <span>Self Organizing Map </span>
            <span class="label label-primary pull-right">4</span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo site_url('klaster_som');?>"><i class="fa fa-circle-o"></i> Data Training</a></li>          
            <li><a href="<?php echo site_url('som_learning');?>"><i class="fa fa-circle-o"></i> SOM Learning</a></li>
            <li><a href="<?php echo site_url('pusat_klaster_som');?>"><i class="fa fa-circle-o"></i> Pusat Klaster</a></li>
        </ul>
    </li>
    <li class="treeview">
        <a href="#">
            <i class="fa fa-files-o"></i>
             <span>DBSCAN </span>
            <span class="label label-primary pull-right">3</span>
        </a>
        <ul class="treeview-menu">
            <li><a href="<?php echo site_url('klaster_dbscan');?>"><i class="fa fa-circle-o"></i> Data Training</a></li>           
            <li><a href="<?php echo site_url('dbscan_learning');?>"><i class="fa fa-circle-o"></i> DBSCAN Learning</a></li>
            <li><a href="<?php echo site_url('pusat_klaster_dbscan');?>"><i class="fa fa-circle-o"></i> Pusat Klaster</a></li>
        </ul>
    </li>
    <li>
        <a href="<?php echo site_url('similarity');?>">
            <i class="fa fa-users"></i> <span>Similarity</span>
        </a>
    </li>
     <!--
    <li class="treeview">
        <a href="#">
            <i class="fa fa-files-o"></i>
             <span>Layout Options</span>
            <span class="label label-primary pull-right">4</span>
        </a>
        <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
        </ul>
    </li>
      !-->
    <li class="header"></li>
    <li>
        <a href="<?php echo site_url('auth/logout');?>">
            <i class="fa fa-power-off"></i> <span>Logout</span>
        </a>
    </li>
  
</ul>