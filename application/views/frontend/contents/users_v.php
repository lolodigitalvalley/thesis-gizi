<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo isset($page_header) ? $page_header : '';?>
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
                    <h3 class="box-title"><?php echo isset($panel_heading) ? $panel_heading : '';?> </h3>
                </div><!-- /.box-header -->
<?php
switch ($page) {
    case 'view':
?>
 <div class="row">
    <div class="col-md-8">
        <form class="form-horizontal">
            <div class="box-body"> 
                <div class="form-group">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="form-control-static">
                        <?php echo isset($username) ? $username : '';?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <p class="form-control-static"><?php echo isset($name) ? $name : '';?></p>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Email</label>
                    <p class="form-control-static"><?php echo isset($email) ? $email : '';?></p>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Level</label>
                    <div class="col-sm-2 form-control-static"><?php echo isset($level) ? $level : '';?></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Status</label>
                    <p class="form-control-static"><?php echo isset($status) ? $status : '';?></p>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Created At</label>
                    <p class="form-control-static"><?php echo isset($created_at) ? $created_at : '';?></p>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Updated At</label>
                    <p class="form-control-static"><?php echo isset($updated_at) ? $updated_at : '';?></p>
                </div>
            </div>

            <div class="box-footer">
                <button type="button" name="edit" class="btn btn-primary" onClick="location.href='<?php echo site_url('adminweb/users/update/'.$id); ?>'">Edit Data</button> &nbsp; &nbsp; 
                <button type="button" name="back" class="btn btn-primary" onclick="history.back();">Back Button</button>
            </div>
        </form>
    </div>
</div>

<?php
    break;
    
    case 'add':
	case 'update':
?>
 <div class="row">
    <div class="col-md-4">
        <form role="form" method="POST" action="<?php echo $action; ?>"> 
            <div class="box-body"> 
                <div class="form-group">
                    <label>Username</label>
                    <div class="input-group">
                        <span class="input-group-addon">@</span>
                        <input type="text" placeholder="username" class="form-control" name="username" id="username"  value = "<?php echo isset($username) ? $username : '';?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" class="form-control" placeholder="Email" name="email" id="email" value = "<?php echo isset($email) ? $email : '';?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" placeholder="" class="form-control" name="name" id="name" value = "<?php echo isset($name) ? $name : '';?>" />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password" id="password" />
                </div>
                <div class="form-group">
                    <label>Retype Password</label>
                    <input type="Password" class="form-control" name="repassword" id="repassword" />
                </div>
                <div class="form-group">
                    <label>Level</label>
                    <?php
                        echo form_dropdown('level', $array_level, isset($level) ? set_value('level', $level) : '1', 'class="form-control" id="status"'); 
                    ?> 
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <?php
                        echo form_dropdown('status', $array_status, isset($status) ? set_value('status', $status) : '1', 'class="form-control" id="status"'); 
                    ?>                
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" name="submit" class="btn btn-primary">Submit Button</button>
                <button type="reset" name="reset" class="btn btn-default">Reset Button</button>
            </div>
        </form>
    </div>
</div>
<?php
		break;

    case 'import':
        echo '<div class="box-body">'.
            form_open_multipart(site_url('users/import'), array ('role'=>'form', 'methode'=>'POST')).
            input_file('File Excel', array ('name'=>'userfile', 'id'=>'', 'size'=>'5')).
            button_submit(array ('name'=>'submit', 'value'=>'Upload'), array('name'=>'reset', 'value'=>'Reset')).
            form_close().
            '</div>';
    break;

	default:
		echo '<div class="box-body"><div class="table-responsive" id="table-responsive">';							 							
		echo isset($table) ? $table : '';
		echo '</div></div>';
		break;
}
?>
            </div><!-- /.box -->
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->
