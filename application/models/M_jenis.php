<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_jenis extends CI_Model
{

  public function get($id = null){
    $this->db->from('t_jenis');
    if($id !=null) {
      $this->db->where('id_jenis',$id);
    }
    $query = $this->db->get();
    return $query;

  }

  public function add($post) {
    $params = [
      'name_jenis' => $post['name_jenis']
    ];
    $this->db->insert('t_jenis',$params);
  }

  public function update($post) {
    $params = [
      'name_jenis' => $post['name_jenis'],
      'jenis_updated' => date('Y-m-d H:i:s')
    ];
    $this->db->where('id_jenis',$post['id_jenis']);
    $this->db->update('t_jenis',$params);
  }

  public function delete($id) {
  		$this->db->where('id_jenis',$id);
  		$this->db->delete('t_jenis');
  }

}


?>
