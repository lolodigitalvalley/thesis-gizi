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
<div id="notifications"></div>
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
    <div class="col-md-12">
         <div class="box-body">
            <div class="form-group">
                <button type="button" onClick="add_penyakit();" class="btn btn-primary" id="add-penyakit" >Tambah</button><br/><br/> 
                <div class="table-responsive" id="table-responsive">
                <?php echo !empty($data_penyakit) ? $data_penyakit : ''; ?>
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

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal Judul</h4>
      </div>
      <div class="modal-body">
        <div id="show">
             Modal Body
        </div>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>

<script src="<?php echo base_url().'assets/'; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script type="text/javascript">
    var baseUrl = base_url() + 'penyakit/';

    function reload_table()
    {
        $.ajax({
            url: baseUrl + "reload_table/",
            cache: false,
            type: "POST",
            success: function(data){
                $("#table-responsive").html(data);
            }
        });
    }

    function add_penyakit()
    {
        $.ajax({
            url: baseUrl + "add_penyakit/",
            cache: false,
            type: "POST",
            success: function(data){
                $("#show").html(data);
            }
        });

        $('#modal-form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Penyakit'); // Set Title to Bootstrap modal title
    }

    function update_penyakit(kode_penyakit)
    {
         $.ajax({
            url: baseUrl + "update_penyakit/",
            data: {'kode_penyakit':kode_penyakit},
            cache: false,
            type: "POST",
            success: function(data){
                $("#show").html(data);
            }
        });

        $('#modal-form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Update Penyakit'); // Set Title to Bootstrap modal title
    }

    function delete_penyakit(kode_penyakit)
    {
        if(confirm('Are you sure delete this data?'))
        {
            $.ajax({
                url : baseUrl + "delete_penyakit/",
                data: {'kode_penyakit':kode_penyakit},
                type: "POST",
                dataType: "JSON",
                success: function(data)
                {
                    reload_table();
                    alert('Success delete data');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error deleting data');
                }
            });
        }
    }

    function save_penyakit()
    {
        // ajax adding data to database
        $.ajax({
            url : baseUrl + "save_penyakit/",
            type: "POST",
            data: new FormData($('#form-penyakit')[0]),
            dataType: "JSON",
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            success: function(data)
            {
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

                $('#modal-form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
            }
        });
    }
</script>