<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function index(){
    $data['title'] = 'My Profile';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/index', $data);
    $this->load->view('templates/footer');

  }

  public function dapur(){
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

  public function kasir(){
    $dtMeja =  $this->input->get('meja');
    if($dtMeja){
      //bagian nama pelanggan
      $this->load->model('Kasir_model', 'namaTotal');
      $data['namaTotal'] = $this->namaTotal->getKodeMeja($dtMeja);
      $this->load->model('Kasir_model', 'namaPelanggan');
      $data['namaPelanggan'] = $this->namaPelanggan->getNamaPelanggan($data['namaTotal']['0']['kodeMeja']);

        //bagian total harga
        $this->load->model('Kasir_model', 'total');
        $data['total'] = $this->total->getTotalHarga($data['namaTotal']['0']['kodeMeja']);


        //tabel
        $this->load->model('Kasir_model', `dataPesanan`);
        $data['dataPesanan'] = $this->namaTotal->getDataPesanan($data['namaTotal']['0']['kodeMeja']);


    }else{
      $data['namaPelanggan'] = "-";
      $data['dataPesanan'] = "-";
      $data['total'] = "-";
    }

    $bayar = $this->input->post('bayar');
    if($bayar){
      $bayar =  $this->input->post('bayar');
      $kdMeja = $this->input->post('kodeMeja');
      $idk = $this->input->post('idAdmin');
      // var_dump($id);

      // echo $this->input->post('noMeja');
      $subTotal =  $this->input->post('total');
      $total = $bayar - $subTotal;
      $data['kembalian'] = number_format($total);
      if($total>=0){
        //pesanan
        $this->load->model('Kasir_model', 'dp');
        $data['dPesanan'] = $this->dp->dPesanan($kdMeja);

        //kodeTransaksi
        $this->load->model('Kasir_model','mx');
        $data['kodem'] = $this->mx->max();

        $kodeBarang = $data['kodem'][0]['maxKode'];
        $noUrut = (int) substr($kodeBarang,2,5);
        $noUrut++;
        // var_dump($noUrut);

        $char = "TR";
        $kodeBarang = $char.sprintf("%03s",$noUrut);
        // var_dump($kodeBarang);

        $this->load->model('Kasir_model', 'insertT');
        $data['insertT'] = $this->insertT->insertTrans($kdMeja,$kodeBarang,$idk);
      }

    }else{
      $data['kembalian'] = "-";
    }

    $data['title'] = 'KASIR';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->model('Kasir_model', 'meja');
    $data['detailMeja'] = $this->meja->getDetailMeja();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/kasir', $data);
    $this->load->view('templates/footer');
  }


}
