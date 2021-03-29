<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_supplier extends CI_Model
{
  public function get($id = null){
    $this->db->from('t_supplier');
    if($id !=null) {
      $this->db->where('id_supplier',$id);
    }
    $query = $this->db->get();
    return $query;

  }

  public function add($post) {
    $params = [
      'name_supplier' => $post['name_supplier'],
      'address'=> $post['address'],
      'phone'=> $post['phone'],
    ];
    $this->db->insert('t_supplier',$params);
  }

  public function update($post) {
    $params = [
      'name_supplier' => $post['name_supplier'],
      'address'=> $post['address'],
      'phone'=> $post['phone'],
      'updated' => date('Y-m-d H:i:s')
    ];
    $this->db->where('id_supplier',$post['id_supplier']);
    $this->db->update('t_supplier',$params);
  }

  public function delete($id) {
  		$this->db->where('id_supplier',$id);
  		$this->db->delete('t_supplier');
  }

}


?>
