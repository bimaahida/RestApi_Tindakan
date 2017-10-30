<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tindakan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->API = "http://localhost/pasien/index.php/api/";
        $this->load->model('Tindakan_model');
        $this->load->library('form_validation');        
        $this->load->library('datatables');
        $this->load->library('curl'); 
    }

    public function index()
    {
        $this->render['content']   = $this->load->view('tindakan/tindakan_list', array(), TRUE);
        $this->load->view('template', $this->render);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Tindakan_model->json();
    }

    public function read($id) 
    {
        $row = $this->Tindakan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_tindakan' => $row->id_tindakan,
		'status' => $row->status,
		'keluhan' => $row->keluhan,
		'id_dokter' => $row->id_dokter,
		'nama_dokter' => $row->nama_dokter,
		'id_pasien' => $row->id_pasien,
		'nama_pasien' => $row->nama_pasien,
		'tgl_tindakan' => $row->tgl_tindakan,
		'id_jenis_tindakan' => $row->id_jenis_tindakan,
		'jenis_tindakan' => $row->jenis_tindakan,
		'penyakit' => $row->penyakit,
		'resep' => $row->resep,
	    );
            $this->render['content']   = $this->load->view('tindakan/tindakan_read', $data, TRUE);
            $this->load->view('template', $this->render);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tindakan'));
        }
    }

    public function create() 
    {

        
        $this->load->model('Penyakit_model');
        $data_list = $this->Penyakit_model->get_all();
        $data_pasien = json_decode($this->curl->simple_get($this->API.'pasien'));
        $data = array(
            'button' => 'Create',
            'action' => site_url('tindakan/create_action'),
	    'id_tindakan' => set_value('id_tindakan'),
	    'status' => set_value('status'),
	    'keluhan' => set_value('keluhan'),
	    'id_dokter' => set_value('id_dokter'),
	    'nama_dokter' => set_value('nama_dokter'),
	    'id_pasien' => set_value('id_pasien'),
	    'nama_pasien' => set_value('nama_pasien'),
	    'tgl_tindakan' => set_value('tgl_tindakan'),
	    'id_jenis_tindakan' => set_value('id_jenis_tindakan'),
	    'jenis_tindakan' => set_value('jenis_tindakan'),
	    'id_penyakit' => set_value('id_penyakit'),
        'resep' => set_value('resep'),
        'data_list' => $data_list,
        'data_pasien' => $data_pasien,
    );
        
        // var_dump($data_pasien);
        $this->render['content']   = $this->load->view('tindakan/tindakan_form', $data, TRUE);
        $this->load->view('template', $this->render);
    }
    
    public function create_action() 
    {
        // $data_pasien = json_decode($this->curl->simple_get($this->API.'pasien'));
        // var_dump($data_pasien);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $status = $this->input->post('status',TRUE);
            $tgl_tindakan = $this->input->post('tgl_tindakan',TRUE);
            $id_pasien = $this->input->post('pasien',TRUE);
            $data_pasien = $data_pasien = json_decode($this->curl->simple_get($this->API.'pasien?id='.$id_pasien));
            $nama = "";
            foreach ($data_pasien as $key) {
                $nama = $key->nama;
            }
            $data = array(
            'status' => $status,
            'keluhan' => $this->input->post('keluhan',TRUE),
            'id_dokter' => $this->input->post('id_dokter',TRUE),
            'nama_dokter' => $this->input->post('nama_dokter',TRUE),
            'id_pasien' => $id_pasien,
            'nama_pasien' => $nama,
            'tgl_tindakan' => $tgl_tindakan,
            'id_jenis_tindakan' => $this->input->post('id_jenis_tindakan',TRUE),
            'jenis_tindakan' => $this->input->post('jenis_tindakan',TRUE),
            'id_penyakit' => $this->input->post('id_penyakit',TRUE),
            'resep' => $this->input->post('resep',TRUE),
            );
            $last_id =$this->Tindakan_model->insert($data);
            
            if ($status == "0") {
                $this->load->model('Rawat_jalan_model');

                $data = array(
                    'id_tindakan' => $last_id,
                    'tgl_periksa' => $tgl_tindakan,
                    );
                $this->Rawat_jalan_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('tindakan'));
            }else if ($status == "1"){
                $data = array(
                    'button' => 'Create',
                    'action' => site_url('rawat_inap/create_action'),
                    'id_rawat_inap' => set_value('id_rawat_inap'),
                    'id_tindakan' => $last_id,
                    'id_ruangan' => set_value('id_ruangan'),
                    'ruangan' => set_value('ruangan'),
                    'tgl_masuk' => set_value('tgl_masuk',$tgl_tindakan),
                    'tgl_keluar' => set_value('tgl_keluar'),
                );
                //echo $last_id;
                $this->render['content']   = $this->load->view('rawat_inap/rawat_inap_form', $data, TRUE);
                $this->load->view('template', $this->render);
                
            }
           
        }
    }
    
    public function update($id) 
    {
        $this->load->model('Penyakit_model');
        $data_list = $this->Penyakit_model->get_all();
        $row = $this->Tindakan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('tindakan/update_action'),
                'id_tindakan' => set_value('id_tindakan', $row->id_tindakan),
                'status' => set_value('status', $row->status),
                'keluhan' => set_value('keluhan', $row->keluhan),
                'id_dokter' => set_value('id_dokter', $row->id_dokter),
                'nama_dokter' => set_value('nama_dokter', $row->nama_dokter),
                'id_pasien' => set_value('id_pasien', $row->id_pasien),
                'nama_pasien' => set_value('nama_pasien', $row->nama_pasien),
                'tgl_tindakan' => set_value('tgl_tindakan', $row->tgl_tindakan),
                'id_jenis_tindakan' => set_value('id_jenis_tindakan', $row->id_jenis_tindakan),
                'jenis_tindakan' => set_value('jenis_tindakan', $row->jenis_tindakan),
                'id_penyakit' => set_value('id_penyakit', $row->id_penyakit),
                'resep' => set_value('resep', $row->resep),
                'data_list' =>$data_list,
	         );
            $this->render['content']   = $this->load->view('tindakan/tindakan_form', $data, TRUE);
            $this->load->view('template', $this->render);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tindakan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_tindakan', TRUE));
        } else {
            $data = array(
		'status' => $this->input->post('status',TRUE),
		'keluhan' => $this->input->post('keluhan',TRUE),
		'id_dokter' => $this->input->post('id_dokter',TRUE),
		'nama_dokter' => $this->input->post('nama_dokter',TRUE),
		'id_pasien' => $this->input->post('id_pasien',TRUE),
		'nama_pasien' => $this->input->post('nama_pasien',TRUE),
		'tgl_tindakan' => $this->input->post('tgl_tindakan',TRUE),
		'id_jenis_tindakan' => $this->input->post('id_jenis_tindakan',TRUE),
		'jenis_tindakan' => $this->input->post('jenis_tindakan',TRUE),
		'id_penyakit' => $this->input->post('id_penyakit',TRUE),
		'resep' => $this->input->post('resep',TRUE),
	    );

            $this->Tindakan_model->update($this->input->post('id_tindakan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tindakan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Tindakan_model->get_by_id($id);

        if ($row) {
            $this->Tindakan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tindakan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tindakan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('status', 'status', 'trim|required');
	$this->form_validation->set_rules('keluhan', 'keluhan', 'trim|required');
	$this->form_validation->set_rules('id_dokter', 'id dokter', 'trim|required');
	$this->form_validation->set_rules('nama_dokter', 'nama dokter', 'trim|required');
	$this->form_validation->set_rules('tgl_tindakan', 'tgl tindakan', 'trim|required');
	$this->form_validation->set_rules('id_jenis_tindakan', 'id jenis tindakan', 'trim|required');
	$this->form_validation->set_rules('jenis_tindakan', 'jenis tindakan', 'trim|required');
	$this->form_validation->set_rules('id_penyakit', 'id penyakit', 'trim|required');
	$this->form_validation->set_rules('resep', 'resep', 'trim|required');

	$this->form_validation->set_rules('id_tindakan', 'id_tindakan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "tindakan.xls";
        $judul = "tindakan";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Status");
	xlsWriteLabel($tablehead, $kolomhead++, "Keluhan");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Dokter");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Dokter");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Pasien");
	xlsWriteLabel($tablehead, $kolomhead++, "Nama Pasien");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Tindakan");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Jenis Tindakan");
	xlsWriteLabel($tablehead, $kolomhead++, "Jenis Tindakan");
	xlsWriteLabel($tablehead, $kolomhead++, "Id Penyakit");
	xlsWriteLabel($tablehead, $kolomhead++, "Resep");

	foreach ($this->Tindakan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->status);
	    xlsWriteLabel($tablebody, $kolombody++, $data->keluhan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_dokter);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_dokter);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_pasien);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nama_pasien);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_tindakan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_jenis_tindakan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->jenis_tindakan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_penyakit);
	    xlsWriteLabel($tablebody, $kolombody++, $data->resep);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Tindakan.php */
/* Location: ./application/controllers/Tindakan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-23 18:29:47 */
/* http://harviacode.com */