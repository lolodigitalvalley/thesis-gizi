<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class My_function
{

    protected $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
    }

    public function date_now()
    {
        return date('Y-m-d');
    }

    public function time_now()
    {
        return date('h:m:s');
    }

    public function jam_indo($time)
    {
        if (!empty($time)) {
            return date('h:m:s', $time);
        }

        return false;
    }

    public function getMonthNameId($number)
    {
        switch ($number) {
            case 1:return "Januari";
                break;
            case 2:return "Februari";
                break;
            case 3:return "Maret";
                break;
            case 4:return "April";
                break;
            case 5:return "Mei";
                break;
            case 6:return "Juni";
                break;
            case 7:return "Juli";
                break;
            case 8:return "Agustus";
                break;
            case 9:return "September";
                break;
            case 10:return "Oktober";
                break;
            case 11:return "November";
                break;
            case 12:return "Desember";
                break;
        }
    }

    public function getMonthNameEn($number)
    {
        switch ($number) {
            case 1:return "January";
                break;
            case 2:return "February";
                break;
            case 3:return "March";
                break;
            case 4:return "April";
                break;
            case 5:return "May";
                break;
            case 6:return "June";
                break;
            case 7:return "July";
                break;
            case 8:return "August";
                break;
            case 9:return "September";
                break;
            case 10:return "October";
                break;
            case 11:return "November";
                break;
            case 12:return "December";
                break;
        }
    }

    public function tgl_eng($tgl, $format = 'd M Y')
    {
        if (!empty($tgl) && $tgl != '0000-00-00') {
            $tanggal    = substr($tgl, 8, 2);
            $bulan      = substr($tgl, 5, 2);
            $nama_bulan = $this->getMonthNameEn(substr($tgl, 5, 2));
            $tahun      = substr($tgl, 0, 4);
            switch ($format) {
                case 'd/m/Y':
                    return $tanggal . '/' . $bulan . '/' . $tahun;
                    break;
                case 'd-m-Y':
                    return $tanggal . '-' . $bulan . '-' . $tahun;
                    break;
                case 'd M Y':
                    return $tanggal . ' ' . $nama_bulan . ' ' . $tahun;
                    break;
                case 'd-M-Y':
                    return $tanggal . '-' . $nama_bulan . '-' . $tahun;
                    break;
            }
        }
        return false;
    }

    public function tgl_indo($tgl, $format = 'd M Y')
    {
        if (!empty($tgl) && $tgl != '0000-00-00') {
            $tanggal    = substr($tgl, 8, 2);
            $bulan      = substr($tgl, 5, 2);
            $nama_bulan = $this->getMonthNameId(substr($tgl, 5, 2));
            $tahun      = substr($tgl, 0, 4);
            switch ($format) {
                case 'd/m/Y':
                    return $tanggal . '/' . $bulan . '/' . $tahun;
                    break;
                case 'd-m-Y':
                    return $tanggal . '-' . $bulan . '-' . $tahun;
                    break;
                case 'd M Y':
                    return $tanggal . ' ' . $nama_bulan . ' ' . $tahun;
                    break;
                case 'd-M-Y':
                    return $tanggal . '-' . $nama_bulan . '-' . $tahun;
                    break;
            }
        }
        return false;
    }

    public function getMonthNumber($month)
    {
        $month = strtolower($month);
        switch ($month) {
            case "januari":
            case "january":
                return 1;
                break;
            case "februari":
            case "february":
                return 2;
                break;
            case 'maret':
            case 'march':
                return 3;
                break;
            case 'april':
                return 4;
                break;
            case 'mei':
            case 'may':
                return 5;
                break;
            case 'juni':
            case 'june':
                return 6;
                break;
            case 'juli':
            case 'july':
                return 7;
                break;
            case 'agustus':
            case 'august':
                return 8;
                break;
            case 'september':
                return 9;
                break;
            case 'oktober':
            case 'october':
                return 10;
                break;
            case 'november':
            case 'november':
                return 11;
                break;
            case 'desember':
            case 'december':
                return 12;
                break;
        }
    }

    public function tgl_mysql($tgl)
    {
        if (!empty($tgl) && $tgl != '0000-00-00') {
            $pecah   = explode(' ', $tgl);
            $tanggal = $pecah[0];
            $bulan   = $this->getMonthNumber($pecah[1]);
            if (strlen($bulan) < 2) {
                $bulan = '0' . $bulan;
            }
            $tahun = $pecah[2];

            return implode('-', array($tahun, $bulan, $tanggal));
        }
        return false;
    }

    public function create_password($tgl)
    {
        if (!empty($tgl) && $tgl != '0000-00-00') {
            $pecah   = explode(' ', $tgl);
            $tanggal = $pecah[0];
            $bulan   = $this->getMonthNumber($pecah[1]);
            if (strlen($bulan) < 2) {
                $bulan = '0' . $bulan;
            }
            $tahun = $pecah[2];

            return implode('', array($tanggal, $bulan, $tahun));
        }
        return false;
    }

    public function rupiah($uang)
    {
        $rupiah  = "";
        $panjang = strlen($uang);
        while ($panjang > 3) {
            $rupiah  = "." . substr($uang, -3) . $rupiah;
            $lebar   = strlen($uang) - 3;
            $uang    = substr($uang, 0, $lebar);
            $panjang = strlen($uang);
        }
        $rupiah = "Rp " . $uang . $rupiah . ",-";
        return $rupiah;
    }

    public function dollars($value)
    {
        return '$' . number_format($value, 2);
    }

    public function discount($value, $discount)
    {
        return ($value - ($value * $discount / 100));
    }

    public function rediscount($value, $discount)
    {
        return ($value * 100) / (100 - $discount);
    }

    public function unique_key()
    {
        $tgl   = date('Y-m-d');
        $pecah = explode('-', $tgl);
        return (count($pecah) == 3) ? rand(100, 999) . $pecah[0] . $pecah[1] . $pecah[2] : $tgl;
    }

    public function get_thumb_name($img_name)
    {
        $parts = explode('.', $img_name);
        return (count($parts) == 2) ? $parts[0] . '_thumb.' . $parts[1] : $img_name;
    }

    public function is_image($source_path, $source_name)
    {
        $is_image = false;

        $ext_allowed = array("jpg", "jpeg", "gif", "png");

        $parts     = pathinfo($source_name);
        $extension = $parts['extension'];

        $img_type     = exif_imagetype($source_path);
        $file_allowed = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);

        if ((in_array($extension, $ext_allowed)) &&
            (in_array($img_type, $file_allowed)) &&
            (getimagesize($source_path))) {
            $is_image = true;
        }

        return $is_image;
    }

    public function is_file($source_path, $source_name)
    {
        $is_file = false;

        if (function_exists('finfo_open')) {
            $finfo     = finfo_open(FILEINFO_MIME_TYPE);
            $tipe_file = finfo_file($finfo, $source_path);
        } else {
            $tipe_file = $_FILES['xfile']['type'];
        }

        if (function_exists('pathinfo')) {
            $parts     = pathinfo($source_name);
            $extension = $parts['extension'];
        } else {
            $extension = explode(".", $source_name);
            $extension = end($extension);
        }

        $allowed_ext = array(
            /* images extensions */
            'jpeg', 'bmp', 'png', 'gif', 'tiff', 'jpg',
            /* audio extensions */
            'mp3', 'wav', 'midi', 'aac', 'ogg', 'wma', 'm4a', 'mid', 'orb', 'aif',
            /* movie extensions */
            'mov', 'flv', 'mpeg', 'mpg', 'mp4', 'avi', 'wmv', 'qt',
            /* document extensions */
            'pdf', 'ppt', 'pps', 'xls', 'doc', 'xlsx', 'pptx', 'ppsx', 'docx',
            /* compressed extensions */
            'zip', 'rar',
        );

        $allowed_type = array(
            /* images type */
            'image/gif', 'image/jpeg', 'image/png', 'image/x-ms-bmp', 'image/tiff',
            /* audio type */
            'video/mp4', 'video/x-ms-wvx', 'video/flv', 'audio/mpeg', 'audio/x-ms-wma',
            /*document type */
            'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword',
            'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            /* compressed type */
            'application/zip', 'application/x-rar');

        if ((in_array($extension, $allowed_ext)) && (in_array($tipe_file, $allowed_type))) {
            $is_file = true;
        }

        return $is_file;
    }

    public function send_email($options)
    {
        if (is_array($options)) {
            $config = array('smtp_user' => 'di3.santo@gmail.com',
                'smtp_pass'                 => 'h3r12id135el',
                'protocol'                  => 'smtp',
                'smtp_host'                 => 'ssl://smtp.googlemail.com',
                'smtp_port'                 => '465',
                'smtp_timeout'              => '30',
                'charset'                   => 'utf-8',
                'newline'                   => "\r\n");

            if (!isset($options['from_email'])) {
                $options['from_email'] = $config['smtp_user'];
            }

            if (!isset($options['from_name'])) {
                $options['from_name'] = 'Administrator';
            }

            $this->ci->load->library('email', $config);
            $mail = $this->ci->email;

            $mail->from($options['from_email'], $options['from_name']);
            $mail->to($options['to']);
            if (isset($options['cc'])) {
                $mail->cc($options['cc']);
            }

            if (isset($options['bcc'])) {
                $mail->bcc($options['bcc']);
            }

            $mail->subject($options['subject']);
            $mail->message($options['message']);

            $mail->send();

            return $mail->print_debugger();
        }

    }
}

/* End of file MY_Function.php */
/* Location: ./application/libraries/MY_Function.php */
