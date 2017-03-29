<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo isset($page_header) ? $page_header : ''; ?>
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> <?php echo isset($breadcrumb) ? $breadcrumb : ''; ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-md-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : ''; ?> </h3>
                </div><!-- /.box-header -->
<?php
if (!isset($page)) $page = '';

switch ($page) {
    default:
?>
 <div class="row">
    <div class="col-md-3">
        <div class="box-body">
            <form role="form" method="POST" action="<?php echo site_url('hierarchical_learning/training'); ?>"> 
            <div class="box-body"> 
                <div class="form-group">
                    <label>Number Of Cluster</label>
                    <input type="text" placeholder="" class="form-control" name="numCluster" id="numCluster" value = "<?php echo isset($numCluster) ? $numCluster : '';?>" />
                </div>
                <div class="form-group">
                    <label>Methode</label>
                    <div class="radio"><label class="radio-inline"><input type="radio" name="methode" id="methode" value = "single" checked="checked" />Single Linkage</label></div>
                    <div class="radio"><label class="radio-inline"><input type="radio" name="methode" id="methode" value = "complete" />Complete Linkage</label></div>
                </div>                
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-primary">Training With Hierarchical</button>
            </div>
            </form>
        </div>
    </div>
</div>


<?php
        break;
        
    case 'training':
        echo '<div class="box-body">
        <div class="row">
        <div class="col-md-12">
        <div class="table-responsive" id="table-responsive">';
        echo isset($table) ? $table : '';
        echo '</div>
        </div>
        </div>';
        echo '<ul>';
        for ($i = 0; $i < count($cluster); $i++) {
            echo '<li> Cluster' . ($i + 1) . ' : ' . $cluster[$i] . '</li>';
        }

        echo '</ul>';
        echo '</div>';
        break;
}
?>
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->

