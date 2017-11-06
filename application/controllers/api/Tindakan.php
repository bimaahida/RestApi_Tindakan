<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';

class Tindakan extends REST_Controller
{
    public function __construct(){
        parent::__construct();

        $this->load->model('Tindakan_model');
    }

    function index_get() {
        $id = $this->get('id');
        if ($id == '') {
            $data =  $this->Tindakan_model->get_all();
        } else {
            $data =  $this->Tindakan_model->get_by_id($id);
        }
        //var_dump($data);
        $this->response($data, 200);
    }
}