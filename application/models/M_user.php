<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class M_user extends CI_Model
{

  public function login($post){
    $this->db->select('*');
    $this->db->from('t_user');
    $this->db->where('username',$post['username']);
    $this->db->where('password',sha1($post['password']));
    $query = $this->db->get();
    return $query;
  }

  public function get($id = null){
    $this->db->from('t_user');
    if($id !=null) {
      $this->db->where('id_user',$id);
    }
    $query = $this->db->get();
    return $query;

  }

  public function add($post) {
    $params = array(
      'username' => $post['username'],
      'password'=> sha1($post['password']),
      'name'=> $post['fullname'],
      'address'=> $post['address'],
      'level'=> $post['level']
    );
    $this->db->insert('t_user',$params);
  }

  public function update($post) {
    $params['username'] = $post['username'];
    if(!empty($post['password'])){
        $params['password'] = sha1($post['password']);
    }
    $params['name']= $post['fullname'];
    $params['address']= $post['address'];
    $params['level']= $post['level'];
    $this->db->where('id_user',$post['id_user']);
    $this->db->update('t_user',$params);
  }

  public function delete($id) {
  		$this->db->where('id_user',$id);
  		$this->db->delete('t_user');
  }

}


?>
