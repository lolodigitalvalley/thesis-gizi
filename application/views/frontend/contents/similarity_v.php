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
if (isset($page)) :
    switch ($page) {
        default:
?>
 <div class="row">
    <div class="col-lg-8">

        <form method="POST" action="similarity/retrive_with_indexing" id="form-data">
        <table class="table table-responsive">
        <tr>
            <td width="17%">Usia </td>
            <td> : </td>
            <td><div class="col-md-3"><input type = "text" name="usia" class="form-control" /></div><div style="padding-top:9px;"> Bulan</div></td>
        </tr>
        <tr>
            <td>Gejala </td>
            <td> : </td>
            <td>
                <div class="col-md-6">               
                    <select class="chosen-select" name="gejala_baru[]" multiple="multiple" class="form-control">
                    <?php
                    $i = 1;
                    foreach($gejala as $row){
                        $kode_gejala = ($i > 45) ? (($i > 54) ? 'R' . ($i - 45) : 'R0' . ($i - 45)) : $row->kode_gejala;

                        echo '<option value="'.$row->kode_gejala.'">'.$kode_gejala.' - '.$row->nama_gejala.'</option>';
                        $i++;
                    }
                    ?>
                    </select>                 
                </div>
            </td>
        </tr>
        <tr>
            <td>Indexing</td>
            <td> : </td>
            <td>
                <div class="col-md-12">
                    <label class="radio-inline"><input type = "radio" name="indexing" value="non-indexing"  checked="true"/>Non Indexing</label>
                    <label class="radio-inline"><input type = "radio" name="indexing" value="som" />SOM</label>
                    <label class="radio-inline"><input type = "radio" name="indexing" value="dbscan" />DBSCAN</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>Similarity</td>
            <td> : </td>
            <td>
                <div class="col-md-12">
                    <label class="radio-inline"><input type = "radio" name="similarity" value="NEAREST_NEIGHBORS"  checked="true"/>Nearest Neighbors</label>
                    <label class="radio-inline"><input type = "radio" name="similarity" value="EUCLIDEAN_NEIGHBORS" />Euclidean Neighbors</label>
                    <label class="radio-inline"><input type = "radio" name="similarity" value="MINKOWSKI" />Minkowski</label>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2"> 
                <input type="hidden" name="gejala" value= <?php echo !empty($gejala) ? "'".serialize($gejala)."'" : '' ?> />
                <input type="hidden" name="penyakit" value= <?php echo !empty($penyakit) ? "'".serialize($penyakit)."'" : '' ?> /> 
                <input type="hidden" name="bobot_gejala" value= <?php echo !empty($bobot_gejala) ? "'".serialize($bobot_gejala)."'" : '' ?> /> 
                <input type="hidden" name="centroids_som" value=<?php echo !empty($centroids_som) ? serialize($centroids_som) : '' ?> /> 
                <input type="hidden" name="centroids_dbscan" value=<?php echo !empty($centroids_dbscan) ? serialize($centroids_dbscan) : '' ?> />
            </td>            
            <td>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" id="reasoning" name="reasoning">Reasoning</button>
                    <button type="button" class="btn btn-primary" id="save" name="save">Save New Case</button>
                    <!--
                    <input type="submit" value="submit" name="submit"/>
                   !-->
                   
                </div>
            </td>
        </tr>
        </table>
        </form>

    </div>

    <div class="col-md-12">
         <div class="box-body">
            <div class="form-group"> 
                <p id="result-cluster"></p>
                <div class="table-responsive" id="table-responsive">

                </div>
            </div>
        </div>
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
    var baseUrl = base_url() + 'similarity/';
    
    $(document).ready(function() {
        $('#reasoning').click(function(){

            var indexing = $('input:radio[name=indexing]:checked').val();
            if(indexing == 'non-indexing'){
                var url = baseUrl + "retrive_non_indexing/";
            }
            else{
                var url = baseUrl + "retrive_with_indexing/";
            }

            $.ajax({
                url: url,
                type: "POST",
                data: $('#form-data').serialize(),
                success: function(data) {
                   
                    var arr  = JSON.parse(data);
                    var text = '';

                    text = text + '<table class="table table-striped table-bordered table-hover">'
                    + '<thead><th>Similarity</th><th>Time</th><th>Kode Kasus</th><th>Penyakit</th><th>Jenis Kelamin</th><th>Umur</th><th>G001</th><th>G002</th><th>G003</th><th>G004</th><th>G005</th><th>G006</th><th>G007</th><th>G008</th><th>G009</th><th>G010</th>'
                    + '<th>G011</th><th>G012</th><th>G013</th><th>G014</th><th>G015</th><th>G016</th><th>G017</th><th>G018</th><th>G019</th><th>G020</th><th>G021</th>'
                    + '</thead>'
                    + '<tbody><tr><td>' + arr.point.toFixed(2) + '</td><td>' + arr.elapsed_time + '</td>';


                    for(var x in arr.row){
                      text = text + '<td>' + arr.row[x] + '</td>';
                    }


                    text = text + '</tr></tbody></table>';
                    $('#result-cluster h4').remove();
                    $('#table-responsive table').remove();
                    $('#result-cluster').append('<h4>Indexing dengan '+arr.indexing+' : Klaster Terdekat ' + arr.nearestCluster +' dan Kasus Paling Mirip '+ arr.nearestCase + '</h4>');
                    $('#table-responsive').append(text);
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        });

        $('#save').click(function(){
            var agree = confirm("Yakin ingin menyimpan Kasus ini ? ");
            if (agree){
                // ajax adding data to database
                $.ajax({
                    url : baseUrl + "save_kasus/",
                    type: "POST",
                    data: $('#form-data').serialize(),
                    success: function(data)
                    {
                        var data  = JSON.parse(data);
                        if(data.result == 1) {
                            $('#notifications').append('<div class="alert alert-success alert-dismissable">'
                        + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                        + 'Succes Insert Data.</div>');
                            alert('Success Insert data');
                        }else if(data.result == 2) {
                            $('#notifications').append('<div class="alert alert-success alert-dismissable">'
                        + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                        + 'Succes Update Data.</div>');
                            alert('Success Update data');
                        }else{
                            $('#notifications').append('<div class="alert alert-warning alert-dismissable">'
                        + '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>'
                        + data.validation_errors + '</div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error adding / update data');
                    }
                });
            }   
        });   
    });
</script>