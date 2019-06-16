<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajer extends CI_Controller {

  public function index(){
    $data['title'] = 'Data Karyawan';
    $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

    $this->load->model('Manajer_model', 'mm');
    $data['karyawan'] = $this->mm->getKaryawan();
    $data['jabatan'] = $this->mm->getJabatan();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('user/manajer', $data);
    $this->load->view('templates/footer');

    // $registea = $this->input->post('register');
    $ubah = $this->input->post('ubah');
    $baten = $this->input->post('regis');
    $hapus = $this->input->get('hapusid');

    if($hapus){
      $this->db->delete('user', array('id' => $hapus));
      redirect('manajer');
      //DELETE FROM tbl_user WHERE id = $id
    }


    if($baten){
      var_dump($baten);
      echo "bisaaa";
      $this->form_validation->set_rules('name','Name','required|trim');
      $this->form_validation->set_rules('email','Email','required|trim|valid_email|is_unique[user.email]',[
        'is_unique' => 'This email has already registered!'
      ]);
      $this->form_validation->set_rules('password1','Password','required|trim|min_length[3]|matches[password2]',[
        'matches' => 'Password dont match!',
        'min_length' => 'Password too short!'
      ]);
      $this->form_validation->set_rules('password2','Password','required|trim|matches[password1]');
      if($this->form_validation->run()==false){
        redirect('manajer');
      }else{
        $config['upload_path']          = './assets/img/profile';
    		$config['allowed_types']        = 'gif|jpg|png';
    		$config['max_size']             = 1000;
        $config['encrypt_name'] = TRUE;

    		$this->load->library('upload', $config);

    		if ( ! $this->upload->do_upload('gambar')){
    			$error = array('error' => $this->upload->display_errors());
          echo $error;
    		}else{
          $upload_data = $this->upload->data();
          $file_name = $upload_data['file_name'];
          $data = [
              'name' => htmlspecialchars($this->input->post('name',true)),
              'email' => htmlspecialchars($this->input->post('email',true)),
              'image' => $file_name,
              'password' => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
              'role_id' => $this->input->post('jabatan',true),
              'is_active' => 1,
              'date_created' => time()
            ];

            $this->db->insert('user',$data);
            $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
              Congratulation your account has been created. Please Login
              </div>');
            redirect('manajer');
    		}
      }
    }elseif ($ubah) {
      $name = $this->input->post('nama');
      $jabatan = $this->input->post('menu_id');
      $email = $this->input->post('email');
      $id = $this->input->post('id');
        $config['upload_path']          = './assets/img/profile';
    		$config['allowed_types']        = 'gif|jpg|png';
    		$config['max_size']             = 1000;
        $config['encrypt_name'] = TRUE;
    		$this->load->library('upload', $config);
    		if ( ! $this->upload->do_upload('jjk')){
    			$error = array('error' => $this->upload->display_errors());
          var_dump($error);
          $gambar = $this->input->post('gambar2');
    		}else{

          $upload_data = $this->upload->data();
          $file_name = $upload_data['file_name'];
          $gambar = $file_name;
      }
      $this->mm->updateKaryawan($id,$name,$email,$gambar,$jabatan);
      redirect('manajer');
    }
  }
    public function datamakanan(){
      $data['title'] = 'Data Makanan';
      $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

      $this->load->model('Datamakanan_model', 'dm');


      $data['makanan'] = $this->db->get('makanan')->result_array();


      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('user/datamakanan', $data);
      $this->load->view('templates/footer');


      // $registea = $this->input->post('register');
      $ubah = $this->input->post('ubah');
      $btn = $this->input->post('tbh');
      $hapus = $this->input->get('hapusid');
      $lio = $this->input->post('btnTambah');


      if($hapus){
        $this->db->delete('makanan', array('kodeMakanan' => $hapus));
        redirect('manajer/datamakanan');
        //DELETE FROM tbl_user WHERE id = $id
      }

      if($lio=="--"){
        $this->form_validation->set_rules('namaMakanan','Name','required|trim');
        $this->form_validation->set_rules('harga','Harga','required|trim');

        if($this->form_validation->run()==false){
          echo "assaassaassa";
        }else{
          echo "berhasil disini";
           $kode = $this->input->post('makanan');
           $data['max'] = $this->dm->getMax($kode);
           var_dump($data['max']);


          $config['upload_path']          = './assets/img/makanan';
          $config['allowed_types']        = 'gif|jpg|png';
          $config['max_size']             = 1000;
          $config['encrypt_name'] = TRUE;

          $this->load->library('upload', $config);

          if ( ! $this->upload->do_upload('foto')){
            $error = array('error' => $this->upload->display_errors());
            echo $error;
          }else{
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
            $data = [
                'kodeMakanan' => $data['max'],
                'namaMakanan' => htmlspecialchars($this->input->post('namaMakanan',true)),
                'hargaMakanan' => htmlspecialchars($this->input->post('harga',true)),
                'gambar' => $file_name,
                'noid' => 1,
                'hapus' => 0,
                'penjualan' => 0
              ];

              $this->db->insert('makanan',$data);
              $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">
                Congratulation your account has been created. Please Login
                </div>');
              redirect('manajer/datamakanan');

          }
        }

      }elseif ($ubah) {
        $nama = $this->input->post('nama');
        $hrg = $this->input->post('harga');
        $kd = $this->input->post('kode');


          $config['upload_path']          = './assets/img/makanan';
          $config['allowed_types']        = 'gif|jpg|png';
          $config['max_size']             = 1000;
          $config['encrypt_name'] = TRUE;

          $this->load->library('upload', $config);

          if ( ! $this->upload->do_upload('emakanan')){

            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
            $gambar = $this->input->post('gmbr2');
          }else{

            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];
            $gambar = $file_name;


        }

        $this->dm->updateMakanan($kd,$nama,$hrg,$gambar);
        redirect('manajer/datamakanan');

      }
    }

}
