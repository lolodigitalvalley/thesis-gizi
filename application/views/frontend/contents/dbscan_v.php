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
<?php 
if ($this->session->flashdata('error')) {
    echo notifications('error', $this->session->flashdata('error'));
}
?>
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : ''; ?> </h3>
                </div><!-- /.box-header -->
<?php
if (isset($page)) :
    switch ($page) {
        default:
?>
 <div class="row">
    <div class="col-md-3">
            <form role="form" method="POST" id="form-data" action="<?php echo site_url('dbscan_learning/training/'); ?>">             
            <div class="box-body"> 
                <div class="form-group">
                    <label>Epsilon</label>
                    <input type="text" placeholder="" class="form-control" name="epsilon" id="epsilon" value = "<?php echo isset($epsilon) ? $epsilon : '';?>" />
                </div>
                <div class="form-group">
                    <label>Minimum Points</label>
                    <input type="text" placeholder="" class="form-control" name="minPoints" id="minPoints" value = "<?php echo isset($minPoints) ? $minPoints : '';?>" />
                </div>                
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-primary">Training With DBSCAN</button>
            </div>
            </form>
    </div>
</div>

<?php
            break; 

        case 'training':
?>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive" id="table-responsive">
            <?php echo isset($table) ? $table : ''; ?>
            </div>
        </div>
    </div>
    <ul>
    <?php
    for ($i = 0; $i < count($clusters); $i++) {
        echo '<li> Cluster ' . ($i + 1). ' : ';
        foreach ($clusters[$i] as $key => $value) {
             echo $value.' ';
        }
        echo '</li>';        
    }

    echo '<li> Noises ('.count($noises).') : ';
    foreach ($noises as $key => $value) {
         echo $value.' ';
    }
    echo '</li>';
    echo isset($elapsed_time) ? '<b>Waktu Yang dibutuhkan '.$elapsed_time.'</b>' : '';
    ?>
    </ul>
    <div class="box-footer">
          <form role="form" method="POST" id="form-data" action="<?php echo site_url('dbscan_learning/save_training/'); ?>">
            <input type="hidden" name="clusters" value='<?php echo !empty($clusters) ? serialize($clusters) : ''; ?>' id="clusters"/>
            <input type="hidden" name="noises" value='<?php echo serialize($noises); ?>' id="noises"/>
            <input type="hidden" name="centroids" value='<?php echo !empty($centroids) ? serialize($centroids) : ''; ?>' id="centroids"/>
            <input type="hidden" name="gejala" value='<?php echo !empty($gejala) ? serialize($gejala) : ''; ?>' id="gejala"/>
            <input type="hidden" name="corePoints" value='<?php echo serialize($corePoints); ?>' id="corePoints"/>
            <input type="hidden" name="noiseCentroids" value='<?php echo serialize($noiseCentroids); ?>' id="noiseCentroids"/>
            <input type="hidden" name="epsilon" value='<?php echo serialize($epsilon); ?>' id="epsilon"/>
            <input type="hidden" name="minPoints" value='<?php echo serialize($minPoints); ?>' id="minPoints"/>
            <input type="hidden" name="silhoutteIndex" value='<?php echo serialize($silhoutteIndex); ?>' id="silhoutteIndex"/>
            <!--
            <input type="submit" value="submit" name="submit">
            !-->
            <input type="button" name="save_training" id="save-training" class="btn btn-primary" value="Save Training" />&nbsp; &nbsp; 
            <input type="button" name="back" class="btn btn-primary" value="New Training" onClick="location.href='<?php echo site_url('dbscan_learning'); ?>'" /> 
         </form> 
        </div>            
    </div>
<?php
        break;
    }
endif;
?>
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->
<script src="<?php echo base_url().'assets/'; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript">
    var baseUrl = base_url() + 'dbscan_learning/';
    
    $(document).ready(function() {
        $('#save-training').click(function(){
            // ajax adding data to database
            $.ajax({
                url: baseUrl + "save_training/",
                type: "POST",
                data: $('#form-data').serialize(),
                success: function(data) {
                    alert('Data berhasil disimpan');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        });
    });
</script>