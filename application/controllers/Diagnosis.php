<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Diagnosis extends Pakar_Controller {


 	protected $page_header = 'Data Diagnosis Baru';
    protected $jenis_kelamin = array(1 => 'Laki-laki',  2 => 'Perempuan');

    public function __construct()
    {
        parent::__construct();

        $this->load->model(array('penyakit_model' => 'penyakit', 'basis_kasus_model' => 'basis_kasus', 'kasus_detail_model' => 'kasus_detail', 'diagnosis_model' => 'diagnosis', 'diagnosis_detail_model' => 'diagnosis_detail', 'gejala_model' => 'gejala'));
    }

    public function index()
    {       
        $data['page'] = '';
        $data['data_kasus']  = $this->generate_table();
        $data['page_header'] = $this->page_header;
        $data['breadcrumb']  = $this->page_header;
       	$this->frontend->view('diagnosis_v', $data);
    }

    private function generate_table()
    {
        set_table(TRUE);
        $this->table->set_heading(array('data' => 'Action', 'width' => '55px'),
            array('data' => 'Kode Kasus'),
            array('data' => 'Usia'),
            array('data' => 'Nama Penyakit'),
            array('data' => 'Gejala'),
            array('data' => 'Created At', 'width' => '100px', 'class' => 'text-center')
        );

        $query = $this->diagnosis->with_penyakit('fields:kode_penyakit')->with_diagnosis_detail('fields:kode_gejala')->get_all();
        if ($query > 0) {
            foreach ($query as $row) {
                $action = array('data' => button_action('update', array('onClick' => 'add_kasus(\'' . $row->kode_kasus . '\');')) . nbs(2) .
                    button_action('delete', array('onClick' => 'delete_kasus(\'' . $row->kode_kasus . '\');')),
                    'width'                => '125px',
                    'align'                => 'center',
                );

                $gejala = '';
                if(!empty($row->diagnosis_detail)){
                    $i = 1; 
                    foreach ($row->diagnosis_detail as $value) {
                        if($i == 5 ) {
                            $gejala .= '<br>';
                            $i = 1;
                        } 
                        $gejala .= $value->kode_gejala.', ';
                        $i++;
                    }     
                }             
                $kode_penyakit = !empty($row->penyakit->kode_penyakit) ? $row->penyakit->kode_penyakit : '';
                $this->table->add_row($action,
                    $row->kode_kasus,
                    $row->usia,
                    $kode_penyakit,
                    $gejala,
                    array('data' => $this->my_function->tgl_indo($row->created_at, 'd/m/Y'),  'class' => 'text-center')
                );
            }
        }
        return $this->table->generate();
    }

    public function reload_table()
    {
        echo $this->generate_table();
    }
  
    public function add_kasus()
    {
        $kode_kasus = $this->input->post('kode_kasus');
        $query  = $this->diagnosis->with_diagnosis_detail('fields:kode_gejala')->where('kode_kasus', $kode_kasus)->get();
        $gejala = $this->gejala->get_all();
        $data_penyakit = $this->penyakit->as_dropdown('nama_penyakit')->get_all();

        $dropdown_gejala = "<script type='text/javascript'>
            var config = {
              '.chosen-select'           : {},
              '.chosen-select-deselect'  : {allow_single_deselect:true},
              '.chosen-select-no-single' : {disable_search_threshold:10},
              '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'}
            }
            for (var selector in config) {
              $(selector).chosen(config[selector]);
            }
            </script>";

        $i = 1;
        $data_gejala = array();
        foreach($gejala as $row){
            $kode_gejala = ($i > 45) ? (($i > 54) ? 'R' . ($i - 45) : 'R0' . ($i - 45)) : $row->kode_gejala;

            $data_gejala[$row->kode_gejala] = $kode_gejala.' - '.$row->nama_gejala;
            $i++;
        }

        $gejala_lama = array();
        if(!empty($query->diagnosis_detail)) foreach ($query->diagnosis_detail as $value) $gejala_lama[] = $value->kode_gejala;

        $dropdown_gejala .= drop_down('Gejala', 'gejala[]', $data_gejala, $gejala_lama, array('class' => 'chosen-select', 'multiple' => 'multiple', 'width' => 8));

        if ($query->jk == 1) {
            $lk = true;
            $pr = false;
        }
        else{
            $lk = false;
            $pr = true;
        }

        $form  = '<div class="row">
        <div class="col-lg-10">';
        $form .= form_open_multipart('', array('role' => 'form', 'id' => 'form-kasus')) .
        input_text('Kode Kasus', array('name' => 'kode_kasus', 'id' => 'kode_kasus', 'value' => !empty($query->kode_kasus) ? $query->kode_kasus : '', 'width' => 3)) .
        input_text('Usia (Bulan)', array('name' => 'usia', 'id' => 'usia', 'value' => !empty($query->usia) ? $query->usia : '', 'width' => 3)) .
        radio_button('Jenis Kelamin', array('Laki-laki' => array('name' => 'jk', 'value' => 1, 'checked' => $lk), 'Perempuan' => array('name' => 'jk', 'value' => 2, 'checked' => $pr))).
        $dropdown_gejala.
        drop_down('Penyakit', 'kode_penyakit', $data_penyakit, $query->kode_penyakit, array('width'=>8)).
        button(array('name' => 'submit', 'id' => 'submit', 'onClick' => 'save_kasus()', 'value' => 'Simpan')) . nbs(4) .
        button(array('name' => 'reset', 'id' => 'reset', 'type' => 'reset', 'value' => 'Reset')) .
        form_close();
        $form .= '</div>
        </div>';

        echo $form;
    }

    public function save_kasus()
    {
        $error      = array('result' => 0);        
        $kode_kasus = $this->input->post('kode_kasus');
        $kode_penyakit = $this->input->post('kode_penyakit');
        $usia = $this->input->post('usia');
        $jk = $this->input->post('jk');
        $gejala = $this->input->post('gejala');

        $query = $this->basis_kasus->where('kode_kasus', $kode_kasus)->get();
        if ($query > 0) {
            $kode_kasus = $this->basis_kasus->get_max_id();
            $id         = substr($kode_kasus, 1) + 1;
            $kode_kasus = 'K' . $id;
        }

        $row    = array('kode_kasus' => $kode_kasus, 'kode_penyakit' => $kode_penyakit, 'usia'=>$usia, 'jk'=>$jk);
        $result = $this->basis_kasus->insert($row);

        $insert_many = array();
        foreach ($gejala as $value) $insert_many[] = array('kode_kasus' => $kode_kasus, 'kode_gejala' => $value);

        $result2 = $this->kasus_detail->insert($insert_many);

        echo json_encode(array('result' => 1));
        exit;
        
        echo json_encode(array('result' => 0));
    }

    public function delete_kasus()
    {
        $kode_kasus = $this->input->post('kode_kasus');

        $result  = $this->diagnosis->delete(array('kode_kasus' => $kode_kasus));
        $result2 = $this->diagnosis_detail->delete(array('kode_kasus'=>$kode_kasus));
        echo json_encode(array("result" => 1));
    }
}
