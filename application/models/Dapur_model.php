<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dapur_model extends CI_Model{
    public function getMejaPesanan(){
        $query = "SELECT `kodeMeja`, `noMeja`, `noidm` FROM `meja` WHERE `noid` = 1 AND `noidm` < 2 ORDER BY `waktu` ASC";

        return $this->db->query($query)->result_array();
    }

    public function getPesananMakanan($tmp){
      $array = array();
      $query = "SELECT `kodeMeja`, `noMeja`, `noidm` FROM `meja` WHERE `noid` = 1 AND `noidm` < 2 ORDER BY `waktu` ASC";
      $meja = $this->db->query($query)->result_array();

      $j = count($meja);

      for($i=0; $i<$j; $i++){
        $id = intval($meja[$i]["noidm"]);

        $tmp= $meja[$i]["kodeMeja"];

        $query2 = "SELECT makanan.namaMakanan, detailpesanan.QTY FROM makanan, detailpesanan WHERE makanan.kodeMakanan = detailpesanan.kodeMakanan AND detailpesanan.kodeMeja = '$tmp'";
        $array[$i] = $this->db->query($query2)->result_array();

      }

      return $array;
    }
    public function prosesMakanan($dapur){
      $query = "SELECT noidm FROM meja WHERE noMeja = $dapur";
      $a = $this->db->query($query)->result_array();
      $tmp = intval($a[0]["noidm"]);
      if($tmp<2){
        $tmp2 = $tmp+1;
        $query2 = "UPDATE meja SET noidm = '$tmp2' WHERE noMeja = $dapur";
        return $this->db->query($query2);
      }
    }

    public function data($number,$offset){
      return $query = $this->db->get('makanan',$number,$offset)->result();

    }

  public function jumlah_data(){
		return $this->db->get('makanan')->num_rows();
	}

  public function updateKetersediaan($kd,$n){
    $na = intval($n);

    if($n==0){

      return $query2 = $this->db->query("UPDATE makanan SET noid = 1 WHERE kodeMakanan = '$kd'");
    }elseif($n==1){

      return $query = $this->db->query("UPDATE makanan SET noid = 0 WHERE kodeMakanan = '$kd'");
    }
  }

  }
