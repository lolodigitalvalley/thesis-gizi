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
    <div class="col-md-4">
            <form role="form" method="POST" id="form-data" action="<?php echo site_url('som_learning/training/'); ?>">             
            <div class="box-body"> 
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Jumlah Klaster</label>
                        <input type="text" placeholder="" class="form-control" name="numCluster" id="numCluster" value = "<?php echo isset($numCluster) ? $numCluster : '';?>" />
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label>Maximum Iterasi</label>
                        <input type="text" placeholder="" class="form-control" name="maxIterasi" id="maxIterasi" value = "<?php echo isset($maxIterasi) ? $maxIterasi : '';?>" />
                    </div>
                </div>                
                <div class="form-group row"> 
                    <div class="col-sm-12">
                        <div class="row">                  
                            <div class="col-sm-6">
                                <label class="control-label">Laju Pembelajaran</label>
                                <input type="text" placeholder="" class="form-control" name="learningRate" id="learningRate" value = "<?php echo isset($learningRate) ? $learningRate : '';?>" /> 
                            </div>
                            <div class="col-sm-6">
                                <label class="control-label">menjadi</label>
                                <input type="text" placeholder="" class="form-control" name="toLearningRate" id="toLearningRate" value = "<?php echo isset($toLearningRate) ? $toLearningRate : '';?>" />        
                             </div>
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
    <!--
    <div class="col-md-9">
         <div class="box-body">
            <div class="form-group"> 
                <p><input type="button" name="generate" id="generate" class="btn btn-primary" value="Generate Weight" /></p>
                <div class="table-responsive" id="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>W0</th><th>W1</th><th>W2</th><th>W3</th><th>W4</th><th>W5</th><th>W6</th><th>W7</th><th>W8</th><th>W9</th><th>W10</th>
                        <th>W11</th><th>W12</th><th>W13</th><th>W14</th><th>W15</th><th>W16</th><th>W17</th><th>W18</th><th>W19</th><th>W20</th>
                        <th>W21</th><th>W22</th><th>W23</th><th>W24</th><th>W25</th><th>W26</th><th>W27</th><th>W28</th><th>W29</th><th>W30</th>
                        <th>W31</th><th>W32</th><th>W33</th><th>W34</th><th>W35</th><th>W36</th><th>W37</th><th>W38</th><th>W39</th><th>W40</th>
                        <th>W41</th><th>W42</th><th>W43</th><th>W44</th><th>W45</th><th>W46</th><th>W47</th><th>W48</th><th>W49</th><th>W50</th>
                        <th>W51</th><th>W52</th><th>W53</th><th>W54</th><th>W55</th><th>W56</th>
                    </tr>
                    </thead>
                    <tbody id="body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    !-->
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
    echo isset($elapsed_time) ? '<br/><b>Waktu Yang dibutuhkan '.$elapsed_time.'</b>' : '';
    ?>
    </ul>
    <div class="box-footer">
          <form role="form" method="POST" id="form-data" action="<?php echo site_url('som_learning/save_training/'); ?>">
            <input type="hidden" name="clusters" value='<?php echo !empty($clusters) ? serialize($clusters) : ''; ?>' id="clusters"/>
            <input type="hidden" name="centroids" value='<?php echo !empty($centroids) ? serialize($centroids) : ''; ?>' id="centroids"/>
            <input type="hidden" name="weights" value='<?php echo !empty($weights) ? serialize($weights) : ''; ?>' id="weights"/>
            <input type="hidden" name="gejala" value='<?php echo !empty($gejala) ? serialize($gejala) : ''; ?>' id="gejala"/>
            <input type="hidden" name="maxIterasi" value='<?php echo !empty($maxIterasi) ? serialize($maxIterasi) : ''; ?>' id="iterasi"/>
            <input type="hidden" name="learningRate" value='<?php echo !empty($learningRate) ? serialize($learningRate) : ''; ?>' id="learningRate"/>
            <input type="hidden" name="toLearningRate" value='<?php echo !empty($toLearningRate) ? serialize($toLearningRate) : ''; ?>' id="learningRate"/>
            <input type="hidden" name="silhoutteIndex" value='<?php echo serialize($silhoutteIndex); ?>' id="silhoutteIndex"/>
            <!--
            <input type="submit" value="submit" name="submit">
            !-->
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

                $.ajax({
                    url: baseUrl + "get_weights/",
                    type: "POST",
                    data: $('#form-data').serialize(),
                    success: function(data) {
                        //alert(JSON.stringify(data));
                        var arr  = JSON.parse(data);
                        var weights =  new Array();
                        var text = '';

                        for (var i = 0; i < numCluster; i++) {
                            weights[i] = new Array();

                            text = text + '<tr>';
                            for (var j = 0; j <= 56; j++) {
                                weights[i][j] = arr[i][j];
                                text = text + '<td>' + arr[i][j] + '</td>';                            
                            }
                            /* 
                            var j = 0;                          
                            for(var x in arr[i]){
                                weights[i][j] = arr[i][x];
                                text = text + '<td>' + arr[i][x] + '</td>';
                                j = j+1;
                            }
                            */
                            text = text + '</tr>';
                        }

                        $('#table-responsive #body tr').remove();
                        $('#table-responsive #body').append(text);
                        $('#form-data #weights').val();
                        $('#form-data #weights').val(JSON.stringify(weights)); 
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error adding / update data');
                    }
                }); 

 
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

