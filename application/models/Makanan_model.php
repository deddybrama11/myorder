<?php
class Makanan_model extends CI_Model{
  public function getMakanan($kodeMakanan=null){
    if($kodeMakanan === null){
      return $this->db->get('makanan')->result_array();
    }else{
      return $this->db->get_where('makanan',['kodeMakanan' => $kodeMakanan])->result_array();
    }

  }
}
 ?>
