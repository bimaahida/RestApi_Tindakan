<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rawat_inap extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Rawat_inap_model');
        $this->load->library('form_validation');        
    $this->load->library('datatables');
    $this->load->library('curl'); 
    }

    public function index()
    {
        $this->render['content']   = $this->load->view('rawat_inap/rawat_inap_list', array(), TRUE);
        $this->load->view('template', $this->render);
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Rawat_inap_model->json();
    }

    public function read($id) 
    {
        $row = $this->Rawat_inap_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_rawat_inap' => $row->id_rawat_inap,
		'id_tindakan' => $row->id_tindakan,
		'id_ruangan' => $row->id_ruangan,
		'ruangan' => $row->ruangan,
		'tgl_masuk' => $row->tgl_masuk,
		'tgl_keluar' => $row->tgl_keluar,
        );
            $this->render['content']   = $this->load->view('rawat_inap/rawat_inap_read', $data, TRUE);
            $this->load->view('template', $this->render);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('rawat_inap'));
        }
    }

    public function create() 
    {
        $data_ruang = json_decode($this->curl->simple_get('http://192.168.10.2/ofbi/index.php/api/ruang_kosong'));
        // var_dump($data_ruang);
        $data = array(
            'button' => 'Create',
            'action' => site_url('rawat_inap/create_action'),
            'id_rawat_inap' => set_value('id_rawat_inap'),
            'id_tindakan' => set_value('id_tindakan'),
            'id_ruangan' => set_value('id_ruangan'),
            'ruangan' => set_value('ruangan'),
            'tgl_masuk' => set_value('tgl_masuk'),
            'tgl_keluar' => set_value('tgl_keluar'),
            'data_ruang' => $data_ruang,
        );
        $this->render['content']   = $this->load->view('rawat_inap/rawat_inap_form', $data, TRUE);
        $this->load->view('template', $this->render);
    }
    
    public function create_action() 
    {
        $id_ruangan = $this->input->post('id_ruangan',TRUE);    
        $data_ruang = json_decode($this->curl->simple_get('http://192.168.10.2/ofbi/index.php/api/ruang_kosong?id='.$id_ruangan));
        $nama_ruang = "";
        foreach ($data_ruang as $key) {
            $nama_ruang = $key->nama_ruang;
        }
        var_dump($id_ruangan);
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_tindakan' => $this->input->post('id_tindakan',TRUE),
		'id_ruangan' => $id_ruangan,
		'ruangan' => $nama_ruang,
		'tgl_masuk' => $this->input->post('tgl_masuk',TRUE),
		'tgl_keluar' => $this->input->post('tgl_keluar',TRUE),
	    );

            $this->Rawat_inap_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('rawat_inap'));
        }
    }
    
    public function update($id) 
    {
        $data_ruang = json_decode($this->curl->simple_get('http://192.168.10.2/ofbi/index.php/api/ruang_kosong'));
        $row = $this->Rawat_inap_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('rawat_inap/update_action'),
                'id_rawat_inap' => set_value('id_rawat_inap', $row->id_rawat_inap),
                'id_tindakan' => set_value('id_tindakan', $row->id_tindakan),
                'id_ruangan' => set_value('id_ruangan', $row->id_ruangan),
                'ruangan' => set_value('ruangan', $row->ruangan),
                'tgl_masuk' => set_value('tgl_masuk', $row->tgl_masuk),
                'tgl_keluar' => set_value('tgl_keluar', $row->tgl_keluar),
                'data_ruang' => $data_ruang,
            );
            $this->render['content']   = $this->load->view('rawat_inap/rawat_inap_form', $data, TRUE);
            $this->load->view('template', $this->render);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('rawat_inap'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        $id_ruangan = $this->input->post('id_ruangan',TRUE);    
        $data_ruang = json_decode($this->curl->simple_get('http://192.168.10.2/ofbi/index.php/api/ruang_kosong?id='.$id_ruangan));

        $nama_ruang = "";
        foreach ($data_ruang as $key) {
            $nama_ruang = $key->nama_ruang;
        }

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_rawat_inap', TRUE));
        } else {
            $data = array(
		'id_tindakan' => $this->input->post('id_tindakan',TRUE),
		'id_ruangan' => $this->input->post('id_ruangan',TRUE),
		'ruangan' => $nama_ruang,
		'tgl_masuk' => $this->input->post('tgl_masuk',TRUE),
		'tgl_keluar' => $this->input->post('tgl_keluar',TRUE),
	    );

            $this->Rawat_inap_model->update($this->input->post('id_rawat_inap', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('rawat_inap'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Rawat_inap_model->get_by_id($id);

        if ($row) {
            $this->Rawat_inap_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('rawat_inap'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('rawat_inap'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_tindakan', 'id tindakan', 'trim|required');
	$this->form_validation->set_rules('id_ruangan', 'id ruangan', 'trim|required');
	$this->form_validation->set_rules('tgl_masuk', 'tgl masuk', 'trim|required');
	$this->form_validation->set_rules('tgl_keluar', 'tgl keluar', 'trim|required');

	$this->form_validation->set_rules('id_rawat_inap', 'id_rawat_inap', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "rawat_inap.xls";
        $judul = "rawat_inap";
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
	xlsWriteLabel($tablehead, $kolomhead++, "Id Ruangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Ruangan");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Masuk");
	xlsWriteLabel($tablehead, $kolomhead++, "Tgl Keluar");

	foreach ($this->Rawat_inap_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_tindakan);
	    xlsWriteNumber($tablebody, $kolombody++, $data->id_ruangan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->ruangan);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_masuk);
	    xlsWriteLabel($tablebody, $kolombody++, $data->tgl_keluar);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Rawat_inap.php */
/* Location: ./application/controllers/Rawat_inap.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2017-10-23 18:29:42 */
/* http://harviacode.com */