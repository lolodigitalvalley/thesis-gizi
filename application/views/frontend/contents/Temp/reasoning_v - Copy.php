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
if ($this->session->flashdata('success')) {
    echo notifications('success', $this->session->flashdata('success'));
}
if ($this->session->flashdata('error')) {
    echo notifications('error', $this->session->flashdata('error'));
}
if (validation_errors()) {
    echo notifications('warning', validation_errors('<p>', '</p>'));
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
    <div class="col-md-6">

        <form method="POST" action="" id="form-data">
        <table class="table table-responsive">
        <tr>
            <td width="18%">Kode Kasus </td>
            <td width="5px"> : </td>
            <td><div class="col-md-4"><input type = "text" name="kode_kasus" class="form-control" /></div></td>
        </tr>
        <tr>
            <td>Nama </td>
            <td> : </td>
            <td><div class="col-md-10"><input type = "text" name="nama_pasien" class="form-control" /></div></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td> : </td>
            <td>
                <div class="col-md-6">
                    <label class="radio-inline"><input type = "radio" name="sex" value="L"  />L</label>
                    <label class="radio-inline"><input type = "radio" name="sex" value="P"  />P</label>
                </div>
            </td>
        </tr>
        <tr>
            <td>Usia </td>
            <td> : </td>
            <td><div class="col-sm-3"><input type = "text" name="age" class="form-control" /></div><div style="padding-top:9px;"> Bulan</div></td>
        </tr>
        <tr>
            <td>Gejala </td>
            <td> : </td>
            <td>
                <div class="col-md-6">               
                    <select class="chosen-select" name="gejala[]" multiple="multiple" class="form-control" size="16">
                    <?php
                    foreach($gejala as $row) echo '<option value="'.$row->kode_gejala.'">'.$row->kode_gejala.' - '.$row->nama_gejala.'</option>';
                    ?>
                    </select>                 
                </div>
            </td>
        </tr>
        <tr>
            <td>Indexing</td>
            <td> : </td>
            <td>
                <div class="col-md-8">
                    <label class="radio-inline"><input type = "radio" name="indexing" value="non-indexing"  checked="true"/>Non Indexing</label>
                    <label class="radio-inline"><input type = "radio" name="indexing" value="som" />SOM</label>
                    <label class="radio-inline"><input type = "radio" name="indexing" value="dbscan"  />DBSCAN</label>
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2"> 
                <input type="hidden" name="centroids_som" value=<?php echo !empty($centroids_som) ? serialize($centroids_som) : '' ?>/> 
                <input type="hidden" name="centroids_dbscan" value=<?php echo !empty($centroids_dbscan) ? serialize($centroids_dbscan) : '' ?>
            </td>            
            <td>
                <div class="col-md-6"><button type="button" class="btn btn-primary" id="reasoning" name="reasoning">Reasoning</button></div>
            </td>
        </tr>
        </table>
        </form>

    </div>

    <div class="col-md-6">
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
    var baseUrl = base_url() + 'reasoning/';
    
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
                    //alert('Data berhasil disimpan');
                    //alert(JSON.stringify(data));
                   
                    var arr  = JSON.parse(data);
                    var text = '';

                    //alert(Object.keys(arr.row).length);
                    text = text + '<table class="table table-striped table-bordered table-hover">'
                    + '<thead><th>Kode Kasus</th><th>Penyakit</th><th>Umur</th><th>G001</th><th>G002</th><th>G003</th><th>G004</th><th>G005</th><th>G006</th><th>G007</th><th>G008</th><th>G009</th><th>G010</th>'
                    + '<th>G011</th><th>G012</th><th>G013</th><th>G014</th><th>G015</th><th>G016</th><th>G017</th><th>G018</th><th>G019</th><th>G020</th><th>G021</th></thead>'
                    + '<tbody><tr>';


                    for(var x in arr.row){
                      text = text + '<td>' + arr.row[x] + '</td>';
                    }
                    /*
                    for(i=1; i <= Object.keys(arr.row).length; i++){
                        text = text + '<td>' + arr.row['v'+i] + '</td>';
                    }
                    */

                    text = text + '</tr></tbody></table>';
                    $('#result-cluster h4').remove();
                    $('#table-responsive table').remove();
                    $('#result-cluster').append('<h4>Indexing With '+arr.indexing+': Nearest Cluster In Cluster ' + arr.nearestCluster +' and Nearest Case Is Case '+ arr.nearestCase + '</h4>');
                    $('#table-responsive').append(text);
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Error adding / update data');
                }
            });
        });
    });
</script>