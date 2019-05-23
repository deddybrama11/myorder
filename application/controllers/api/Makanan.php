<?php

use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Makanan extends REST_Controller{

  public function __construct(){
    parent::__construct();
    $this->load->model('Makanan_model','makanan');
  }
  public function index_get(){
    $kodeMakanan = $this->get('kodeMakanan');
    if($kodeMakanan == null){
      $makanan = $this->makanan->getMakanan();
    }else{
      $makanan = $this->makanan->getMakanan($kodeMakanan);
    }


    if($makanan){
      $this->response([
          'status' => true,
          'data' => $makanan
      ], REST_Controller::HTTP_OK);
    }else{
      $this->response([
          'status' => false,
          'message' => 'kode makanan not tidak ditemukan!'
      ], REST_Controller::HTTP_NOT_FOUND);
    }
  }
}

 ?>
