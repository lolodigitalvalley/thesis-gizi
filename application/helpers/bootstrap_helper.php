<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Bootstrap helper digunakan untuk memudahkan penggunaan bootstrap pada codeigneter,
 * HTML dan CSS mengacu pada template SB-Admin (bootstrap 3),
 * mungkin tidak akan berjalan dengan baik pada template bootstrap lainnya.
 *
 * @link
 * @copyright Copyright (c) 2014, Herdiesel Santoso <http://nulisapajah.com>
 */

if (!function_exists('set_table')) {
    function set_table($enDataTables = false, $class = 'table table-striped table-bordered table-hover')
    {
        $ci = &get_instance();

        $ci->load->library('table');

        $id = ($enDataTables == true) ? 'id="dataTables"' : '';

        $tmpl = array(
            'table_open'         => '<table class="' . $class . '" ' . $id . '>',

            'heading_row_start'  => '<tr>',
            'heading_row_end'    => '</tr>',
            'heading_cell_start' => '<th>',
            'heading_cell_end'   => '</th>',

            'row_start'          => '<tr>',
            'row_end'            => '</tr>',
            'cell_start'         => '<td>',
            'cell_end'           => '</td>',

            'row_alt_start'      => '<tr>',
            'row_alt_end'        => '</tr>',
            'cell_alt_start'     => '<td>',
            'cell_alt_end'       => '</td>',

            'table_close'        => '</table>',
        );

        $ci->table->set_template($tmpl);
    }
}

if (!function_exists('input_text')) {
    function input_text($label, $data)
    {
        if (!isset($data['width'])) {
            $inputWidth = 'col-md-5';
        } else {
            $inputWidth = 'col-md-' . $data['width'];
            unset($data['width']);
        }

        if (isset($data['help'])) {
            $help = '<p class="help-block">' . $data['help'] . '</p>';
            unset($data['help']);
        } else {
            $help = '';
        }

        if (!isset($data['class'])) {
            $data['class'] = "form-control";
        }

        $input = '<div class="form-group">
            <label class="control-label">' . $label . '</label>
            <div class="row">
                <div class="' . $inputWidth . '">' . form_input($data) . '</div>
            </div>' . $help . '
            </div>';
        return $input;
    }
}

if (!function_exists('input_text_h')) {
    // Form Class must form-horizontal
    function input_text_h($label, $data)
    {
        if (is_array($label)) {
            $lblWidth = 'col-lg-' . $label['width'];
            $label    = $label['label'];
        } else {
            $lblWidth = 'col-lg-4';
        }

        if (!isset($data['width'])) {
            $inputWidth = 'col-lg-5';
        } else {
            $inputWidth = 'col-lg-' . $data['width'];
            unset($data['width']);
        }

        if (isset($data['help'])) {
            $help = '<p class="help-block">' . $data['help'] . '</p>';
            unset($data['help']);
        } else {
            $help = '';
        }

        if (!isset($data['class'])) {
            $data['class'] = "form-control";
        }

        $input = '<div class="form-group">
            <label class="control-label ' . $lblWidth . '">' . $label . '</label>
                <div class="' . $inputWidth . '">' . form_input($data) . '</div>' . $help . '
            </div>';
        return $input;
    }
}

if (!function_exists('static_text')) {
    function static_text($label, $data)
    {
        $input = '<div class="form-group">
            <label>' . $label . '</label>
            <p class="form-control-static">' . $data . '</p>
            </div>';
        return $input;
    }
}

if (!function_exists('static_text_h')) {
    function static_text_h($label, $data)
    {
        $input = '<div class="form-group">
            <label class="col-sm-2 control-label">' . $label . '</label>
            <div class="col-sm-10 form-control-static">' . $data . '</div>
            </div>';
        return $input;
    }
}

if (!function_exists('input_group')) {
    function input_group($label, $addon, $data, $backaddon = false)
    {
        if (!isset($data['width'])) {
            $inputWidth = 'col-lg-5';
        } else {
            $inputWidth = 'col-lg-' . $data['width'];
            unset($data['width']);
        }

        if (isset($data['help'])) {
            $help = '<p class="help-block">' . $data['help'] . '</p>';
            unset($data['help']);
        } else {
            $help = '';
        }

        if (!isset($data['class'])) {
            $data['class'] = "form-control";
        }

        if ($backaddon == true) {
            $input = '<div class="form-group">
            <label>' . $label . '</label>
            <div class="input-group ' . $inputWidth . '">
            ' . form_input($data) . '<span class="input-group-addon">' . $addon . '</span>' .
                '</div>' . $help . '</div>';
        } else {
            $input = '<div class="form-group">
            <label>' . $label . '</label>
            <div class="input-group ' . $inputWidth . '">
            <span class="input-group-addon">' . $addon . '</span>' . form_input($data) .
                '</div>' . $help . '</div>';
        }

        return $input;
    }
}

/* input_datetime needs Bootstrap datetimepicker */
if (!function_exists('input_datetime')) {
    function input_datetime($label, $data, $enTime = true, $enDate = true)
    {
        if (is_array($label)) {
            $lblWidth = 'col-lg-' . $label['width'];
            $label    = $label['label'];
        } else {
            $lblWidth = 'col-lg-4';
        }

        if (!isset($data['width'])) {
            $inputWidth = 'col-lg-5';
        } else {
            $inputWidth = 'col-lg-' . $data['width'];
            unset($data['width']);
        }

        if (isset($data['help'])) {
            $help = '<p class="help-block">' . $data['help'] . '</p>';
            unset($data['help']);
        } else {
            $help = '';
        }

        if (!isset($data['class'])) {
            $data['class'] = "form-control";
        }

        $input = '<div class="form-group">
            <label>' . $label . '</label>';

        if ($enDate && $enTime) {
            $input .= '<div class="input-group date datetimepicker ' . $inputWidth . '">
                ' . form_input($data) . '
                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span>
                </span>
                </div>' . $help;
        } elseif ($enDate && !$enTime) {
            $input .= '<div class="input-group date datepicker ' . $inputWidth . '">
                ' . form_input($data) . '
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>' . $help;
        } elseif (!$enDate && $enTime) {
            $input .= '<div class="input-group date timepicker ' . $inputWidth . '">
                ' . form_input($data) . '
                <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
                </span>
                </div>' . $help;
        }
        $input .= '</div>';
        return $input;
    }
}

if (!function_exists('text_area')) {
    function text_area($label, $data)
    {
        if (!isset($data['width'])) {
            $inputWidth = 'col-md-8';
        } else {
            $inputWidth = 'col-md-' . $data['width'];
            unset($data['width']);
        }

        if (isset($data['help'])) {
            $help = '<p class="help-block">' . $data['help'] . '</p>';
            unset($data['help']);
        } else {
            $help = '';
        }

        if (!isset($data['class'])) {
            $data['class'] = "form-control";
        }

        $text_area = '<div class="form-group">
            <label class="control-label">' . $label . '</label>
            <div class="row">
                <div class="' . $inputWidth . '">' . form_textarea($data) . '</div>
            </div>' . $help . '
            </div>';
        return $text_area;
    }
}

if (!function_exists('text_area_h')) {
    function text_area_h($label, $data)
    {
        if (is_array($label)) {
            $lblWidth = 'col-sm-' . $label['width'];
            $label    = $label['label'];
        } else {
            $lblWidth = 'col-sm-4';
        }

        if (!isset($data['width'])) {
            $inputWidth = 'col-sm-8';
        } else {
            $inputWidth = 'col-sm-' . $data['width'];
            unset($data['width']);
        }

        if (isset($data['help'])) {
            $help = '<p class="help-block">' . $data['help'] . '</p>';
            unset($data['help']);
        } else {
            $help = '';
        }

        if (!isset($data['class'])) {
            $data['class'] = "form-control";
        }

        $text_area = '<div class="form-group">
            <label class="control-label ' . $lblWidth . '">' . $label . '</label>
            <div class="' . $inputWidth . '">' . form_textarea($data) . '</div>' . $help . '
            </div>';
        return $text_area;
    }
}

if (!function_exists('input_password')) {
    function input_password($label, $data)
    {
        if (!isset($data['width'])) {
            $inputWidth = 'col-sm-4';
        } else {
            $inputWidth = 'col-sm-' . $data['width'];
            unset($data['width']);
        }

        if (isset($data['help'])) {
            $help = '<p class="help-block">' . $data['help'] . '</p>';
            unset($data['help']);
        } else {
            $help = '';
        }

        if (!isset($data['class'])) {
            $data['class'] = "form-control";
        }

        $input = '<div class="form-group">
            <label class="control-label">' . $label . '</label>
            <div class="row">
                <div class="' . $inputWidth . '">' . form_password($data) . '</div>
            </div>' . $help . '
            </div>';

        return $input;
    }
}

if (!function_exists('input_password_h')) {
    function input_password_h($label, $data)
    {
        if (is_array($label)) {
            $width = 'col-sm-' . $label['width'];
            $label = $label['label'];
        } else {
            $width = 'col-sm-4';
        }

        if (!isset($data['width'])) {
            $inputWidth = 'col-sm-5';
        } else {
            $inputWidth = 'col-sm-' . $data['width'];
            unset($data['width']);
        }

        if (isset($data['help'])) {
            $help = '<p class="help-block">' . $data['help'] . '</p>';
            unset($data['help']);
        } else {
            $help = '';
        }

        if (!isset($data['class'])) {
            $data['class'] = "form-control";
        }

        $input = '<div class="form-group">
            <label class="control-label ' . $width . '">' . $label . '</label>
                <div class="' . $inputWidth . '">' . form_password($data) . '</div>' . $help . '
            </div>';

        return $input;
    }
}

if (!function_exists('input_file')) {
    function input_file($label, $data)
    {
        $input = '<div class="form-group">
            <label>' . $label . '</label>
            <div>' . form_upload($data) . '</div>
            </div>';
        return $input;
    }
}

if (!function_exists('input_file_h')) {
    function input_file_h($label, $data)
    {
        if (is_array($label)) {
            $width = 'col-sm-' . $label['width'];
            $label = $label['label'];
        } else {
            $width = 'col-sm-4';
        }

        if (!isset($data['width'])) {
            $inputWidth = 'col-sm-4';
        } else {
            $inputWidth = 'col-sm-' . $data['width'];
            unset($data['width']);
        }

        $input = '<div class="form-group">
            <label class="control-label ' . $width . '">' . $label . '</label>
            <div class="' . $inputWidth . '">' . form_upload($data) . '</div>
            </div>';
        return $input;
    }
}

/* input_fileupload Needs Bootstrap fileupload */
if (!function_exists('input_fileupload')) {
    function input_fileupload($label = 'Image', $data)
    {
        if (!isset($data['width'])) {
            $inputWidth = 'col-md-3';
        } else {
            $inputWidth = 'col-md-' . $data['width'];
            unset($data['width']);
        }

        if (empty($data['image'])) {
            $data['image'] = '';
        }

        if (empty($data['max_width'])) {
            $data['max_width'] = '720';
        }

        if (empty($data['max_height'])) {
            $data['max_height'] = '960';
        }

        $input = '<div class="form-group">
            <label class="control-label">' . $label . '</label>
            <div class="row">
                <div class="col-lg-3">
                    <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail">' . $data['image'] . '</div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: ' . $data['max_width'] . 'px; max-height: ' . $data['max_height'] . 'px; line-height: 20px;"></div>
                        <p>Size Max : ' . $data['max_width'] . ' x ' . $data['max_height'] . ' pixel</p>
                        <div>
                            <span class="btn btn-file btn-primary">
                                <span class="fileupload-new">Select image</span>
                                <span class="fileupload-exists">Change</span>
                                <input type="file" name="userfile" id="userfile"/>
                            </span>
                            <a class="btn btn-danger fileupload-exists" data-dismiss="fileupload" href="#">
                                Remove
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        return $input;
    }
}

if (!function_exists('drop_down')) {
    function drop_down($label, $name, $data, $selected = 0, $opt = array())
    {
        //Set class 'class'=>'chosen-select' And OR 'multiple'=>'TRUE' in controllers
        $class = '';

        if (!isset($opt['class'])) {
            $opt['class'] = "form-control";
        }

        if (!isset($opt['width'])) {
            $inputWidth = 'col-md-5';
        } else {
            $inputWidth = 'col-md-' . $opt['width'];
            unset($opt['width']);
        }

        if (!isset($opt['class'])) {
            $opt['class'] = "form-control";
        }

        foreach ($opt as $key => $value) {
            $class .= $key . '="' . $value . '" ';
        }

        $drop_down = '<div class="form-group">
            <label class="control-label">' . $label . '</label>
            <div class="row">
                <div class="' . $inputWidth . '">' . form_dropdown($name, $data, $selected, $class) . '</div>
            </div>
            </div>';
        return $drop_down;
    }
}

if (!function_exists('drop_down_h')) {
    function drop_down_h($label, $name, $data, $selected = 0, $opt = array())
    {
        //Set class 'class'=>'chosen-select' And OR 'multiple'=>'TRUE' in controllers
        $class = '';
        if (is_array($label)) {
            $lblWidth = 'col-sm-' . $label['width'];
            $label    = $label['label'];
        } else {
            $lblWidth = 'col-sm-4';
        }

        if (!isset($opt['class'])) {
            $opt['class'] = "form-control";
        }

        if (!isset($opt['width'])) {
            $inputWidth = 'col-sm-5';
        } else {
            $inputWidth = 'col-sm-' . $opt['width'];
            unset($opt['width']);
        }

        foreach ($opt as $key => $value) {
            $class .= $key . '="' . $value . '" ';
        }

        $drop_down = '<div class="form-group">
            <label class="control-label ' . $lblWidth . '">' . $label . '</label>
                <div class="' . $inputWidth . '">' . form_dropdown($name, $data, $selected, $class) . '</div>
            </div>';
        return $drop_down;
    }
}

if (!function_exists('check_box')) {
    function check_box($label, $data, $inline = true)
    {
        $input = '<div class="form-group">
                    <label>' . $label . '</label>';
        $input .= '&nbsp; &nbsp; ';

        if ($inline == true) {
            foreach ($data as $key => $value) {
                $input .= '<label class="checkbox-inline">' . form_checkbox($value) . $key . '</label> &nbsp; ';
            }

        } else {
            foreach ($data as $key => $value) {
                $input .= ' <div class="checkbox"><label class="checkbox-inline">' . form_checkbox($value) . $key . '</label></div>';
            }
        }

        $input .= '</div>';
        return $input;
    }
}

if (!function_exists('check_box_h')) {
    function check_box_h($label, $data)
    {
        if (is_array($label)) {
            $lblWidth = 'col-sm-' . $label['width'];
            $label    = $label['label'];
        } else {
            $lblWidth = 'col-sm-4';
        }

        $input = '<div class="form-group">
                   <label class="control-label ' . $lblWidth . '">' . $label . '</label>';
        $input .= '&nbsp; &nbsp; ';

        foreach ($data as $key => $value) {
            $input .= '<label class="checkbox-inline">' . form_checkbox($value) . $key . '</label> &nbsp; ';
        }

        $input .= '</div>';
        return $input;
    }
}

if (!function_exists('radio_button')) {
    function radio_button($label, $data, $inline = true)
    {
        $input = '<div class="form-group">
                    <label>' . $label . '</label>';
        $input .= '&nbsp; &nbsp; ';

        if ($inline == true) {
            foreach ($data as $key => $value) {
                if (!empty($value['checked']) && ($value['checked'] === 0)) {
                    unset($value['checked']);
                }
                $input .= '<label class="radio-inline">' . form_radio($value) . $key . '</label> &nbsp; ';
            }

        } else {
            foreach ($data as $key => $value) {
                $input .= ' <div class="radio"><label class="checkbox-inline">' . form_radio($value) . $key . '</label></div>';
            }
        }

        $input .= '</div>';
        return $input;
    }
}

if (!function_exists('radio_button_h')) {
    function radio_button_h($label, $data)
    {
        if (is_array($label)) {
            $lblWidth = 'col-sm-' . $label['width'];
            $label    = $label['label'];
        } else {
            $lblWidth = 'col-sm-4';
        }

        $input = '<div class="form-group">
                   <label class="control-label ' . $lblWidth . '">' . $label . '</label>';
        $input .= '&nbsp; &nbsp; ';

        foreach ($data as $key => $value) {
            $input .= '<label class="radio-inline">' . form_radio($value) . $key . '</label> &nbsp; ';
        }

        $input .= '</div>';
        return $input;
    }
}

if (!function_exists('button')) {
    function button($submit)
    {
        if (empty($submit['class'])) {
            $submit['class'] = 'btn btn-primary';
        }

        $button = form_button($submit, $submit['value']);
        return $button;
    }
}

if (!function_exists('button_submit')) {
    function button_submit($submit, $reset, $size = 8)
    {
        $width = 'col-md-' . $size;

        if (empty($submit['class'])) {
            $submit['class'] = 'btn btn-primary';
        }

        if (empty($reset['class'])) {
            $reset['class'] = 'btn btn-default';
        }

        $input = '<div class="row">
            <div class="' . $width . '">';
        $input .= form_submit($submit) . nbs(4) . form_reset($reset);
        $input .= '</div></div>';
        return $input;
    }
}

if (!function_exists('button_submit_h')) {
    function button_submit_h($submit, $reset, $size = 4)
    {
        $width = 'col-sm-' . $size;

        if (empty($submit['class'])) {
            $submit['class'] = 'btn btn-primary';
        }

        if (empty($reset['class'])) {
            $reset['class'] = 'btn btn-primary';
        }

        $input = '<div class="form-group">
            <div class="row">
            <label class="control-label ' . $width . '"></label>
            <div  class="' . $width . '">';
        $input .= form_submit($submit) . nbs(4) . form_reset($reset);
        $input .= '</div>
            </div>
            </div>';
        return $input;
    }
}

if (!function_exists('button_action')) {
    function button_action($type, $data)
    {
        $atribut = '';
        foreach ($data as $key => $value) {
            $atribut .= $key . '="' . $value . '" ';
        }

        switch ($type) {
            case 'add':
                $link = '<button id="add" class="btn btn-primary btn-sm" title="Add Data" alt="Add Data" ' . $atribut . '><i class="glyphicon glyphicon-plus"></i> Add</button>';
                break;
            case 'view':
                $link = '<button id="view" class="btn btn-info btn-circle" title="View Data" alt="View Data" ' . $atribut . '><i class="glyphicon glyphicon-eye-open"></i></button>';
                break;
            case 'edit':
            case 'update':
                $link = '<button id="update" class="btn btn-warning btn-circle" title="Edit Data" alt="Edit Data" ' . $atribut . '><i class="glyphicon glyphicon-pencil"></i></button>';
                break;
            case 'delete':
                $link = '<button id="delete"  class="btn btn-danger btn-circle" title="Delete Data" alt="Delete Data" ' . $atribut . '><i class="glyphicon glyphicon-remove"></i></button>';
                break;
            case 'replay':
                $link = '<button id="replay" class="btn btn-warning btn-circle" title="Replay Message" alt="Replay Message" ' . $atribut . '><i class="glyphicon glyphicon-envelope"></i></button>';
                break;
            case 'print':
                break;
        }
        return $link;
    }
}

if (!function_exists('button_squre')) {
    function button_square($type, $url, $label = null)
    {
        $link = '';
        switch ($type) {
            case 'add':
                $label = (!empty($label)) ? $label : 'Add';
                $link  = '<button id="' . $label . '" class="btn btn-primary btn-sm" onClick="location.href=\'' . $url . '\'" title="Add Data" alt="Add Data"><i class="glyphicon glyphicon-plus"></i> ' . $label . '</button>';
                break;
            case 'import':
                $label = (!empty($label)) ? $label : 'Import';
                $link  = '<button id="' . $label . '" class="btn btn-primary btn-sm" onClick="location.href=\'' . $url . '\'" title="Import Data" alt="Import Data"><i class="glyphicon glyphicon-plus"></i> ' . $label . '</button>';
                break;
            case 'export':
                $label = (!empty($label)) ? $label : 'Export';
                $link  = '<button id="' . $label . '" class="btn btn-primary btn-sm" onClick="location.href=\'' . $url . '\'" title="Export Data" alt="Export Data"><i class="glyphicon glyphicon-plus"></i> ' . $label . '</button>';
                break;
            case 'view':
                $label = (!empty($label)) ? $label : 'View';
                $link  = '<button id="' . $label . '" class="btn btn-info btn-sm" onClick="location.href=\'' . $url . '\'" title="View Data" alt="View Data"><i class="glyphicon glyphicon-eye-open"></i></button>';
                break;
            case 'edit':
            case 'update':
                $label = (!empty($label)) ? $label : 'Update';
                $link  = '<button id="' . $label . '" class="btn btn-warning btn-sm" onClick="location.href=\'' . $url . '\'" title="Edit Data" alt="Edit Data"><i class="glyphicon glyphicon-pencil"></i></button>';
                break;
            case 'delete':
                $label = (!empty($label)) ? $label : 'Delete';
                $link  = '<button id="' . $label . '"  class="btn btn-danger btn-sm" onClick="return ConfirmDelete(\'' . $url . '\');" title="Delete Data" alt="Delete Data"><i class="glyphicon glyphicon-remove"></i></button>';
                break;
            case 'drop':
                $label = (!empty($label)) ? $label : 'Drop';
                $link  = '<button id="' . $label . '"  class="btn btn-danger btn-sm" onClick="return ConfirmDelete(\'' . $url . '\');" title="Delete Data" alt="Delete Data"><i class="glyphicon glyphicon-remove"></i> ' . $label . '</button>';
                break;
            case 'replay':
                $label = (!empty($label)) ? $label : 'Replay';
                $link  = '<button id="' . $label . '" class="btn btn-warning btn-sm" onClick="location.href=\'' . $url . '\'" title="Replay Message" alt="Replay Message"><i class="glyphicon glyphicon-envelope"></i></button>';
                break;
            case 'print':
                if (is_array($url)) {
                    $li = '';
                    foreach ($url as $key => $value) {
                        $li .= '<li><a href="#" onClick="' . $value . '">' . $key . '</a></li>';
                    }

                    $link = '<div class="btn-group" role="group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <i class="glyphicon glyphicon-print"></i>
                          Print
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">' . $li . '</ul></div>';

                } else {
                    $link = '<button id="print" class="btn btn-default btn-sm" onClick="' . $url . '" title="Print Data" alt="Print Data"><i class="glyphicon glyphicon-print"></i> Print</button>';
                }

                break;
        }
        return $link;
    }
}

if (!function_exists('button_circle')) {
    function button_circle($type, $url)
    {
        $link = '';
        switch ($type) {
            case 'add':
                $link = '<button id="add" class="btn btn-primary btn-sm btn-circle" onClick="location.href=\'' . $url . '\'" title="Add Data" alt="Add Data"><i class="glyphicon glyphicon-plus"></i></button>';
                break;
            case 'import':
                $link = '<button id="import" class="btn btn-primary btn-sm btn-circle" onClick="location.href=\'' . $url . '\'" title="Import Data" alt="Import Data"><i class="glyphicon glyphicon-plus"></i></button>';
                break;
            case 'export':
                $link = '<button id="export" class="btn btn-primary btn-sm btn-circle" onClick="location.href=\'' . $url . '\'" title="Export Data" alt="Export Data"><i class="glyphicon glyphicon-plus"></i></button>';
                break;
            case 'view':
                $link = '<button id="view" class="btn btn-info btn-sm btn-circle" onClick="location.href=\'' . $url . '\'" title="View Data" alt="View Data"><i class="glyphicon glyphicon-eye-open"></i></button>';
                break;
            case 'edit':
            case 'update':
                $link = '<button id="update" class="btn btn-warning btn-sm btn-circle" onClick="location.href=\'' . $url . '\'" title="Edit Data" alt="Edit Data"><i class="glyphicon glyphicon-pencil"></i></button>';
                break;
            case 'delete':
                $link = '<button id="delete"  class="btn btn-danger btn-sm btn-circle" onClick="return ConfirmDelete(\'' . $url . '\');" title="Delete Data" alt="Delete Data"><i class="glyphicon glyphicon-remove"></i></button>';
                break;
            case 'replay':
                $link  = '<button id="replay" class="btn btn-warning btn-sm btn-circle" onClick="location.href=\'' . $url . '\'" title="Replay Message" alt="Replay Message"><i class="glyphicon glyphicon-envelope"></i></button>';
                break;
        }
        return $link;
    }
}

if (!function_exists('notifications')) {
    function notifications($type, $message)
    {
        $notification = '';
        switch ($type) {
            case 'success':
                $notification = '<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                ' . $message . '
            </div>';
                break;
            case 'info':
                $notification = '<div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                ' . $message . '
            </div>';
                break;
            case 'warning':
                $notification = '<div class="alert alert-warning alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                ' . $message . '
            </div>';
                break;

            case 'danger':
            case 'error':
                $notification = '<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                ' . $message . '
            </div>';
                break;
        }
        return $notification;
    }
}

/* End of file bootstrap_helper.php */
/* Location: ./application/helpers/bootstrap_helper.php */
