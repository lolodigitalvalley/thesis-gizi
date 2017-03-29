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
<div id="notification"></div>
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
                <div class="table-responsive" id="table-responsive">
                <div id="table-kasus">
                    <?php echo !empty($data_kasus) ? $data_kasus : ''; ?>
                </div>                
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
    var baseUrl = base_url() + 'diagnosis/';

    function reload_table()
    {
        $.ajax({
            url: baseUrl + "reload_table/",
            cache: false,
            type: "POST",
            success: function(data){
                $("#table-kasus").html(data);
            }
        });
    }

    function add_kasus(kode_kasus)
    {
         $.ajax({
            url: baseUrl + "add_kasus/",
            data: {'kode_kasus':kode_kasus},
            cache: false,
            type: "POST",
            success: function(data){
                $("#show").html(data);
            }
        });

        $('#modal-form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Simpan Diagnosis Sebagai Kasus Baru'); // Set Title to Bootstrap modal title
    }

    function delete_kasus(kode_kasus)
    {
        if(confirm('Are you sure delete this data?'))
        {
            $.ajax({
                url : baseUrl + "delete_kasus/",
                data: {'kode_kasus':kode_kasus},
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

    function save_kasus()
    {
        // ajax adding data to database
        var agree = confirm("Yakin ingin menyimpan Kasus ini Sebagai Kasus Baru ? ");
        if (agree){
            $.ajax({
                url : baseUrl + "save_kasus/",
                type: "POST",
                data: new FormData($('#form-kasus')[0]),
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
    }
</script>