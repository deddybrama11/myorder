<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dapur extends CI_Controller {

  public function index(){
    $dapur = $this->input->get('kode');

    if($dapur){
      echo $dapur;

      $this->load->model('Dapur_model', 'proses');
      $data['proses'] = $this->proses->prosesMakanan($dapur);

    }
    $data['title'] = 'Dapur';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->model('Dapur_model', 'meja');
    $data['meja'] = $this->meja->getMejaPesanan();
    // var_dump($data['meja']);

    //sampe sini sek
    $this->load->model('Dapur_model', 'tm');
    $data['tmp'] = $this->tm->getPesananMakanan($data['meja'][0]['kodeMeja']);



    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/dapur', $data);
    $this->load->view('templates/footer');
  }
  public function ketersediaan(){
    $this->load->model('Dapur_model', 'mj');

    $kd = $this->input->get('kode');
    $n = $this->input->get('noid');

    if($n==0||$n==1){
        $wasa = $this->mj->updateKetersediaan($kd,$n);
    }

    $this->load->database();

    $jumlah_data = $this->mj->jumlah_data();

    $this->load->library('pagination');
    $config['base_url'] = base_url().'dapur/ketersediaan';
    $config['total_rows'] = $jumlah_data;
    $config['per_page'] = 5;
    $from = $this->uri->segment(3);
    $this->pagination->initialize($config);
    $data['tbl'] = $this->mj->data($config['per_page'],$from);


    $data['title'] = 'Ketersediaan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/ketersediaan', $data);
    $this->load->view('templates/footer');
  }
}
