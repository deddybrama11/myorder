<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datamakanan_model extends CI_Model{

  public function getKaryawan(){
    $query = "SELECT `user`.`id`,`user`.`name`,`user`.`email`,`user`.`image`,`user_role`.`role`  FROM `user` JOIN `user_role`
    ON `user`.`role_id` = `user_role`.`id`";

    return $this->db->query($query)->result_array();
  }

  public function getMax($kode){
    var_dump($kode);
    $kodee = $kode.'%';
    $query = "SELECT max(kodeMakanan) as maxKode FROM makanan WHERE kodeMakanan LIKE '$kodee'";
    $t = $this->db->query($query)->result_array();
    var_dump($t);
    $kodeBarang = $t[0]['maxKode'];
    $noUrut = (int) substr($kodeBarang,1,3);
    $noUrut++;
    $kodeBarang = $kode.sprintf("%03s",$noUrut);
    var_dump($kodeBarang);
    return $kodeBarang;

  }

  public function getJabatan(){
    $query = "SELECT * FROM user_role";
    return $this->db->query($query)->result_array();
  }
  public function updateMakanan($kd,$nama,$hg,$gb){
    $query = "UPDATE makanan SET namaMakanan='$nama',hargaMakanan='$hg',gambar='$gb' WHERE kodeMakanan='$kd'";
    $a = $this->db->query($query);
  }
}
 ?>
