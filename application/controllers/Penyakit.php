<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit extends Pakar_Controller
{

    protected $page_header = 'Data Penyakit';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('penyakit_model', 'penyakit');
    }

    public function index()
    {
        $data['page']          = '';
        $data['data_penyakit'] = $this->generate_table();
        $data['page_header']   = $this->page_header;
        $data['breadcrumb']    = $this->page_header;
        $this->frontend->view('penyakit_v', $data);
    }

    private function generate_table()
    {
        set_table(false);
        $this->table->set_heading(array('data' => 'Action', 'width' => '55px'),
            array('data' => 'Kode Penyakit'),
            array('data' => 'Nama Penyakit'),
            array('data' => 'Created At', 'width' => '100px', 'class' => 'text-center')
        );

        $query = $this->penyakit->get_all();
        if ($query > 0) {
            foreach ($query as $row) {
                $action = array('data' => button_action('update', array('onClick' => 'update_penyakit(\'' . $row->kode_penyakit . '\');')) . nbs(2) .
                    button_action('delete', array('onClick' => 'delete_penyakit(\'' . $row->kode_penyakit . '\');')),
                    'width'                => '125px',
                    'align'                => 'center',
                );

                $this->table->add_row($action,
                    $row->kode_penyakit,
                    $row->nama_penyakit,
                    array('data' => $this->my_function->tgl_indo($row->created_at, 'd/m/Y'), 'class' => 'text-center')
                );
            }
        }
        return $this->table->generate();
    }

    public function reload_table()
    {
        echo $this->generate_table();
    }

    public function add_penyakit()
    {
        $form = '<div class="row">
        <div class="col-lg-10">';
        $form .= form_open_multipart('', array('role' => 'form', 'id' => 'form-penyakit')) .
        form_hidden('methode', 'add') .
        input_text('Kode Penyakit', array('name' => 'kode_penyakit', 'id' => 'kode_penyakit', 'width' => 3)) .
        input_text('Nama Penyakit', array('name' => 'nama_penyakit', 'id' => 'nama_penyakit', 'width' => 8)) .
        button(array('name' => 'submit', 'id' => 'submit', 'onClick' => 'save_penyakit()', 'value' => 'Submit')) . nbs(4) .
        button(array('name' => 'reset', 'id' => 'reset', 'type' => 'reset', 'value' => 'Reset')) .
        form_close();
        $form .= '</div>
        </div>';

        echo $form;
    }

    public function update_penyakit()
    {
        $kode_penyakit = $this->input->post('kode_penyakit');
        $query         = $this->penyakit->where('kode_penyakit', $kode_penyakit)->get();

        $form = '<div class="row">
        <div class="col-lg-10">';
        $form .= form_open_multipart('', array('role' => 'form', 'id' => 'form-penyakit')) .
        form_hidden('methode', 'update') .
        input_text('Kode Penyakit', array('name' => 'kode_penyakit', 'id' => 'kode_penyakit', 'value' => !empty($query->kode_penyakit) ? $query->kode_penyakit : '', 'width' => 3)) .
        input_text('Nama Penyakit', array('name' => 'nama_penyakit', 'id' => 'nama_penyakit', 'value' => !empty($query->nama_penyakit) ? $query->nama_penyakit : '', 'width' => 8)) .
        button(array('name' => 'submit', 'id' => 'submit', 'onClick' => 'save_penyakit()', 'value' => 'Submit')) . nbs(4) .
        button(array('name' => 'reset', 'id' => 'reset', 'type' => 'reset', 'value' => 'Reset')) .
        form_close();
        $form .= '</div>
        </div>';

        echo $form;
    }

    public function save_penyakit()
    {
        $error         = array('result' => 0);
        $kode_penyakit = $this->input->post('kode_penyakit');
        $nama_penyakit = $this->input->post('nama_penyakit');

        $methode = $this->input->post('methode');
        if ($methode == 'add') {
            $row    = array('kode_penyakit' => $kode_penyakit, 'nama_penyakit' => $nama_penyakit);
            $result = $this->penyakit->insert($row);
            echo json_encode(array('result' => 1));
            exit;
        } else if ($methode == 'update') {
            $result = $this->penyakit->update(array('nama_penyakit' => $nama_penyakit), array('kode_penyakit' => $kode_penyakit));
            echo json_encode(array('result' => 2));
            exit;
        }

        echo json_encode(array('result' => 0));
    }

    public function delete_penyakit()
    {
        $kode_penyakit = $this->input->post('kode_penyakit');

        $this->penyakit->delete(array('kode_penyakit' => $kode_penyakit));
        echo json_encode(array("result" => 1));
    }
}
