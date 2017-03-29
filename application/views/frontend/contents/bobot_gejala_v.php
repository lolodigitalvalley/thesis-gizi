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
 <div class="row">
    <div class="col-md-10">
         <div class="box-body">
            <div class="form-group">
                <div class="table-responsive" id="table-responsive">
                <table class="table table-responsive"> 
                <form action="<?php echo site_url('bobot_gejala/save_bobot');?>" method="POST" name="form-bobot">

                    <tr>
                    <th width="12%">Kode Gejala</th>
                    <?php
                        foreach ($penyakit as $row) echo '<th>'.$row->kode_penyakit.'</th>';
                    ?>
                    </tr>
                    <tr>
                    <?php
                        $i = 0;
                        echo '<th>'.$kode_gejala.'</th>';
                        foreach ($penyakit as $row)  echo '<th><div class="row"><div class="col-md-6">'.form_input(array('name'=>'bobot['.$row->kode_penyakit.']', 'class'=>'form-control', 'value' => !empty($bobot_gejala) ? $bobot_gejala[$i++]->bobot : '')).'</div></div></th>';
                        ?>
                    </tr>
                    <tr>
                    <td colspan="<?php echo ($i+2); ?>">
                        <input type="hidden" name="kode_gejala" value="<?php echo $kode_gejala; ?>">
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
                        <button name="back" class="btn btn-primary" onClick="history.back();"> Kembali </button>
                    </td>
                    </tr>
                </form>
                </table>                              
                </div> 
            </div>
        </div>
    </div>
</div>

            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->


