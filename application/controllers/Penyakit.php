<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penyakit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Penyakit_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->render['content']   = $this->load->view('penyakit/penyakit_list', array(), TRUE);
        $this->load->view('template', $this->render);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Penyakit_model->json();
    }

    public function read($id) 
    {
        $row = $this->Penyakit_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_penyakit' => $row->id_penyakit,
		'penyakit' => $row->penyakit,
	    );
            $this->render['content']   = $this->load->view('penyakit/penyakit_read', $data, TRUE);
            $this->load->view('template', $this->render);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penyakit'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('penyakit/create_action'),
	    'id_penyakit' => set_value('id_penyakit'),
	    'penyakit' => set_value('penyakit'),
    );
        $this->render['content']   = $this->load->view('penyakit/penyakit_form', $data, TRUE);
        $this->load->view('template', $this->render);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'penyakit' => $this->input->post('penyakit',TRUE),
	    );

            $this->Penyakit_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('penyakit'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Penyakit_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('penyakit/update_action'),
		'id_penyakit' => set_value('id_penyakit', $row->id_penyakit),
		'penyakit' => set_value('penyakit', $row->penyakit),
	    );
            $this->render['content']   = $this->load->view('penyakit/penyakit_form', $data, TRUE);
            $this->load->view('template', $this->render);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penyakit'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_penyakit', TRUE));
        } else {
            $data = array(
		'penyakit' => $this->input->post('penyakit',TRUE),
	    );

            $this->Penyakit_model->update($this->input->post('id_penyakit', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('penyakit'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Penyakit_model->get_by_id($id);

        if ($row) {
            $this->Penyakit_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('penyakit'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('penyakit'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('penyakit', 'penyakit', 'trim|required');

	$this->form_validation->set_rules('id_penyakit', 'id_penyakit', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "penyakit.xls";
        $judul = "penyakit";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Penyakit");

	foreach ($this->Penyakit_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->penyakit);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Penyakit.php */
/* Location: ./application/controllers/Penyakit.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-23 18:51:33 */
/* http://harviacode.com */