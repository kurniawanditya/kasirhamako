<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_stockout extends CI_Model
{
  public function get($id = null){
    $this->db->from('t_stockout as A');
    $this->db->join('t_merk as B','A.id_merk=B.id_merk');
    $this->db->join('t_customer as C','A.id_customer=C.id_customer');
    $this->db->join('t_jobref as D','A.id_jobref=D.id_jobref');
    if($id !=null) {
      $this->db->where('id_stockout',$id);
    }
    $query = $this->db->get();
    return $query;

  }

  public function add($post) {
    $params = [
      'name_stockout' => $post['name_stockout'],
    ];
    $this->db->insert('t_stockout',$params);
  }

  public function update($post) {
    $params = [
      'name_stockout' => $post['name_stockout'],
      'updated' => date('Y-m-d H:i:s')
    ];
    $this->db->where('id_stockout',$post['id_stockout']);
    $this->db->update('t_stockout',$params);
  }

  public function delete($id) {
  		$this->db->where('id_stockout',$id);
  		$this->db->delete('t_stockout');
  }

}


?>
