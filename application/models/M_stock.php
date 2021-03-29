<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_stock extends CI_Model
{
  public function add_stock_in($post)
  {
      $params=[
          'id_item'     => $post['id_item'],
          'type'        => 'in',
          'detail'      => $post['detail'],
          'id_supplier' => $post['supplier'],
          'qty'         => $post['qty'],
          'date'        => $post['date'],
          'id_user'     => $this->session->userdata('id_user'),
      ];
      $this->db->insert('t_stock',$params);

  }
}


?>
