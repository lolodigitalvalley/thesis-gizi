<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3><?php echo isset($count_kasus) ? $count_kasus : 0; ?></h3>
                    <p>Basis Kasus</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="<?php echo site_url('basis_kasus'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3><?php echo isset($count_diagnosis) ? $count_diagnosis : 0; ?></h3>
                    <p>Diagnosis Baru</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="<?php echo site_url('diagnosis'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3><?php echo isset($count_non_klaster) ? $count_non_klaster : 0; ?></h3>
                    <p>Data Belum Terklaster</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <div class="small-box-footer">
                    <a href="<?php echo site_url('klaster_som'); ?>" style="color:white;">Klaster SOM <i class="fa fa-arrow-circle-right"></i></a> &nbsp; 
                    <a href="<?php echo site_url('klaster_dbscan'); ?>" style="color:white;">Klaster DBSCAN <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo isset($count_penyakit) ? $count_penyakit : 0; ?></h3>
                <p>Penyakit</p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo site_url('penyakit'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div><!-- ./col -->
    </div><!-- /.row -->
    <!-- Main row -->
    <div class="row">
    </div><!-- /.row (main row) -->
</section><!-- /.content -->