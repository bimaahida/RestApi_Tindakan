<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rawat_jalan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Rawat_jalan_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->render['content']   = $this->load->view('rawat_jalan/rawat_jalan_list', array(), TRUE);
        $this->load->view('template', $this->render);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Rawat_jalan_model->json();
    }

    public function read($id) 
    {
        $row = $this->Rawat_jalan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_rawat_jalan' => $row->id_rawat_jalan,
		'id_tindakan' => $row->id_tindakan,
        'nama_pasien' => $row->nama_pasien,
        'nama_dokter' => $row->nama_dokter,
        'jenis_tindakan' => $row->jenis_tindakan,
        'tgl_periksa' => $row->tgl_periksa,
        );
            $this->render['content']   = $this->load->view('rawat_jalan/rawat_jalan_read', $data, TRUE);
            $this->load->view('template', $this->render);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('rawat_jalan'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('rawat_jalan/create_action'),
	    'id_rawat_jalan' => set_value('id_rawat_jalan'),
	    'id_tindakan' => set_value('id_tindakan'),
	    'tgl_periksa' => set_value('tgl_periksa'),
    );
        $this->render['content']   = $this->load->view('rawat_jalan/rawat_jalan_form', $data, TRUE);
        $this->load->view('template', $this->render);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_tindakan' => $this->input->post('id_tindakan',TRUE),
		'tgl_periksa' => $this->input->post('tgl_periksa',TRUE),
	    );

            $this->Rawat_jalan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('rawat_jalan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Rawat_jalan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('rawat_jalan/update_action'),
		'id_rawat_jalan' => set_value('id_rawat_jalan', $row->id_rawat_jalan),
		'id_tindakan' => set_value('id_tindakan', $row->id_tindakan),
		'tgl_periksa' => set_value('tgl_periksa', $row->tgl_periksa),
	    );
            $this->render['content']   = $this->load->view('rawat_jalan/rawat_jalan_form', $data, TRUE);
            $this->load->view('template', $this->render);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('rawat_jalan'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_rawat_jalan', TRUE));
        } else {
            $data = array(
		'id_tindakan' => $this->input->post('id_tindakan',TRUE),
		'tgl_periksa' => $this->input->post('tgl_periksa',TRUE),
	    );

            $this->Rawat_jalan_model->update($this->input->post('id_rawat_jalan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('rawat_jalan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Rawat_jalan_model->get_by_id($id);

        if ($row) {
            $this->Rawat_jalan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('rawat_jalan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('rawat_jalan'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_tindakan', 'id tindakan', 'trim|required');
	$this->form_validation->set_rules('tgl_periksa', 'tgl periksa', 'trim|required');

	$this->form_validation->set_rules('id_rawat_jalan', 'id_rawat_jalan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "rawat_jalan.xls";
        $judul = "rawat_jalan";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Id Tindakan");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Periksa");

	foreach ($this->Rawat_jalan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_tindakan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_periksa);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Rawat_jalan.php */
/* Location: ./application/controllers/Rawat_jalan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-22 16:47:07 */
/* http://harviacode.com */