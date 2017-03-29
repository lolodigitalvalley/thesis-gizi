<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo isset($page_header) ? $page_header : ''; ?>
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
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
            <form role="form" method="POST" id="form-data" action="<?php echo site_url('som_learning/training/'); ?>">             
            <div class="box-body"> 
                <div class="form-group">
                    <label>Number Of Cluster</label>
                    <input type="text" placeholder="" class="form-control" name="numCluster" id="numCluster" value = "<?php echo isset($numCluster) ? $numCluster : '';?>" />
                </div>
                <div class="form-group">
                    <label>Maximum Iterasi</label>
                    <input type="text" placeholder="" class="form-control" name="maxIterasi" id="maxIterasi" value = "<?php echo isset($maxIterasi) ? $maxIterasi : '';?>" />
                </div>                
                <div class="form-group"> 
                    <div class="row">                  
                        <div class="col-sm-6">
                            <label class="control-label">Learning Rate</label>
                            <input type="text" placeholder="" class="form-control" name="learningRate" id="learningRate" value = "<?php echo isset($learningRate) ? $learningRate : '';?>" /> 
                        </div>
                        <div class="col-sm-6">
                            <label class="control-label">to</label>
                            <input type="text" placeholder="" class="form-control" name="toLearningRate" id="toLearningRate" value = "<?php echo isset($toLearningRate) ? $toLearningRate : '';?>" />        
                         </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <input type="hidden" name="weights" id="weights" />
                <button type="submit" name="submit" class="btn btn-primary">Training With SOM</button>
            </div>
            </form>
    </div>

    <div class="col-md-6">
         <div class="box-body">
            <div class="form-group"> 
                <p><input type="button" name="generate" id="generate" class="btn btn-primary" value="Generate Weight" /></p>
                <div class="table-responsive" id="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>W0</th><th>W1</th><th>W2</th><th>W3</th><th>W4</th><th>W5</th><th>W6</th><th>W7</th><th>W8</th><th>W9</th><th>W10</th>
                        <th>W11</th><th>W12</th><th>W13</th><th>W14</th><th>W15</th><th>W16</th><th>W17</th><th>W18</th><th>W19</th><th>W20</th><th>W21</th>
                    </tr>
                    </thead>
                    <tbody id="body"></tbody>
                    </table>
                </div>
            </div>
        </div>
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
        echo '<li> Cluster ' . ($i + 1) . ' : ' . $clusters[$i] . '</li>';
    }
    ?>
    </ul>
    <div class="box-footer">
          <form role="form" method="POST" id="form-data" action="">
            <input type="hidden" name="clusters" value='<?php echo serialize($clusters); ?>' id="clusters"/>
            <input type="hidden" name="newWeights" value='<?php echo serialize($newWeights); ?>' id="newWeights"/>
            <input type="button" name="save_training" id="save-training" class="btn btn-primary" value="Save Training" />&nbsp; &nbsp; 
            <input type="button" name="back" class="btn btn-primary" value="New Training" onClick="location.href='<?php echo site_url('som_learning'); ?>'" /> 
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
    var baseUrl = base_url() + 'som_learning/';
    
    $(document).ready(function() {
        $('#generate').click(function(){
            var numCluster = $('#numCluster').val();
            if(numCluster != '')
            {
                var weights =  new Array();
                var text   = ''; 

                for (var i = 0; i < numCluster; i++) {
                    weights[i] = new Array();
                    text      = text + '<tr>';
                    for (var j=0; j < 22; j++) {
                        weights[i][j] = Math.random().toFixed(2); //Math.floor((Math.random() * 10) + 1);              
                        text = text + '<td>' + weights[i][j] + '</td>';
                    }
                    text = text + '</tr>';            
                }
                $('#table-responsive #body tr').remove();
                $('#table-responsive #body').append(text);
                $('#form-data #weights').val();
                $('#form-data #weights').val(JSON.stringify(weights));  
            }
            else{
                alert('You Must Define Number Cluster.')
            }

        });

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

