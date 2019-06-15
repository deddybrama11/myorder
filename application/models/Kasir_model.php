<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kasir_model extends CI_Model{
    public function getDetailMeja(){
      // $query = "SELECT `user_sub_menu`.*,`user_menu`.`menu`
      //           FROM `user_sub_menu` JOIN `user_menu`
      //           ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
      //         ";
            $query = "SELECT `meja`.`noMeja`,`statusm`.`status`
                      FROM `statusm` JOIN `meja`
                      ON `statusm`.`noid` = `meja`.`noid` AND `meja`.`hapus` = '0' ORDER BY `meja`.`noMeja` ASC
                    ";
                    return $this->db->query($query)->result_array();
    }

    public function getKodeMeja($mj){
      $query = "SELECT `kodeMeja` FROM `meja` WHERE `noMeja` = $mj";
      return $this->db->query($query)->result_array();
    }

    public function getNamaPelanggan($np){
      $query = "SELECT `namaPemesan` FROM `detailpesanan` WHERE `kodeMeja` = '$np'";
      return $this->db->query($query)->result_array();
    }

    public function getDataPesanan($kd){
      $query = "SELECT `makanan`.`namaMakanan`,`detailPesanan`.`harga`,`detailpesanan`.`QTY`,`detailpesanan`.`subtotal`
                FROM `makanan` JOIN `detailpesanan`
                ON `makanan`.`kodeMakanan` = `detailpesanan`.`kodeMakanan` AND `detailPesanan`.`kodeMeja` = '$kd'";
      return $this->db->query($query)->result_array();
    }

    public function getTotalHarga($kd){
      $query = "SELECT SUM(`detailPesanan`.`subtotal`) as total
                FROM `detailPesanan` WHERE `detailPesanan`.`kodeMeja`= '$kd'";
      return $this->db->query($query)->result_array();
    }

    public function dPesanan($km){
      $query2 = "SELECT * FROM `detailpesanan` WHERE `kodeMeja` = '$km'";
      return $this->db->query($query2)->result_array();

    }

    public function max(){
      $query = "SELECT max(`idtransaksi`) as maxKode FROM `pesanan`";
      return $this->db->query($query)->result_array();
    }

    public function insertTrans($km,$kodeBarang,$idk){
      //query 1
      $query1 = "SELECT * FROM detailpesanan WHERE kodeMeja = '$km'";
      $tmp = $this->db->query($query1)->result_array();

      foreach ($tmp as $tm) {
        $nopesanan = $tm["noPesanan"];
        $kodemeja = $tm["kodeMeja"];
        $kodemakanan = $tm["kodeMakanan"];
        $qty = $tm["QTY"];
        $sub = $tm["subtotal"];
        $tgl = date('Y-m-d');

        //query 2
        $query = "INSERT INTO pesanan VALUES ('$kodeBarang','$nopesanan','$kodemeja','$kodemakanan','$qty','$sub','$idk','$tgl')";
        $this->db->query($query);

        //query 3
        $query3 = "SELECT penjualan FROM makanan WHERE kodeMakanan = '$kodemakanan'";
        $jum = $this->db->query($query3)->result_array();

        $jumlah = intval($jum[0]["penjualan"]);
        $jumlah = $jumlah + $qty;

        //query 4
        $query4 = "UPDATE makanan SET penjualan = '$jumlah' WHERE kodeMakanan = '$kodemakanan'";
        $this->db->query($query4);
      }

      $query5= "SELECT namaPemesan FROM detailpesanan WHERE kodeMeja = '$kodemeja'";
      $nm = $this->db->query($query5)->result_array();
      $n = $nm[0]['namaPemesan'];

      $query6 = "DELETE FROM detailpesanan WHERE kodeMeja = '$kodemeja'";
      $query7 = "UPDATE meja SET noid = '0', noidm = '0' WHERE kodeMeja = '$kodemeja'";
      $query8 = "DELETE FROM namapemesan WHERE namaPemesan = '$n'";

      $this->db->query($query6);
      $this->db->query($query7);
      $this->db->query($query8);
      $berhasil = 'berhasil';
      return $berhasil;





    }
}
 ?>
