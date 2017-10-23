<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Rawat_inap extends REST_Controller
{
    public function __construct(){
        parent::__construct();

        $this->load->model('Rawat_inap_model');
    }

    function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $data =  $this->Rawat_inap_model->Api_get_rawat_inap();
        } else {
            $data =  $this->Rawat_inap_model->Api_get_rawat_inap_byid($id);
        }
        var_dump($data);
        //$this->response($data, 200);
    }
}