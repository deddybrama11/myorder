<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajer_model extends CI_Model{

  public function getKaryawan(){
    $query = "SELECT `user`.`id`,`user`.`name`,`user`.`email`,`user`.`image`,`user_role`.`role`  FROM `user` JOIN `user_role`
    ON `user`.`role_id` = `user_role`.`id`";

    return $this->db->query($query)->result_array();

  }

  public function getJabatan(){
    $query = "SELECT * FROM user_role";
    return $this->db->query($query)->result_array();
  }
  public function updateKaryawan($id,$name,$email,$image,$role_id){
    $query = "UPDATE user SET name='$name',email='$email',image='$image',role_id='$role_id' WHERE id='$id'";
    $a = $this->db->query($query);
  }
}
 ?>
