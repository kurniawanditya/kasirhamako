<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		check_not_login();
		check_admin();
		$this->load->model('M_user');
		$this->load->library('form_validation');
	}


	public function index()
	{
    $data['user'] = $this->M_user->get();
		$this->template->load('template','user/user_data',$data);
	}

  public function add()
	{
		$this->form_validation->set_rules('fullname', 'Fullname', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|is_unique[t_user.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'required|matches[password]',
			array('matches' =>"%s tidak sesuai dengan password", ));
		$this->form_validation->set_rules('level', 'Level', 'required');

		$this->form_validation->set_message('required', '%s Masih Kosong, Silahkan isi');
		$this->form_validation->set_message('is_unique', '%s ini sudah terdaftar');
		$this->form_validation->set_message('min_length', '%s Minimal 5 karaketer');

		$this->form_validation->set_error_delimiters('<span class="help-block">','</span>');


		if($this->form_validation->run() == FALSE){
			$this->template->load('template','user/user_form_add');
		} else {
			$post = $this->input->post(null, TRUE);
			$this->M_user->add($post);
			if($this->db->affected_rows()>0){
				echo "<script>alert('Data Berhasil Disimpan')</script>";
			}
			echo "<script>window.location='".site_url('User')."'</script>";
		}
	}

	public function update($id)
	{
		$this->form_validation->set_rules('fullname', 'Fullname', 'required');
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|callback_username_check');
		if($this->input->post('password')){
			$this->form_validation->set_rules('password', 'Password', 'min_length[5]');
			$this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'matches[password]',
				array('matches' =>"%s tidak sesuai dengan password", ));
		}
		if($this->input->post('passconf')){
			$this->form_validation->set_rules('passconf', 'Konfirmasi Password', 'matches[password]',
				array('matches' =>"%s tidak sesuai dengan password", ));
		}
		$this->form_validation->set_rules('level', 'Level', 'required');

		$this->form_validation->set_message('required', '%s Masih Kosong, Silahkan isi');
		$this->form_validation->set_message('is_unique', '%s ini sudah terdaftar');
		$this->form_validation->set_message('min_length', '%s Minimal 5 karaketer');

		$this->form_validation->set_error_delimiters('<span class="help-block">','</span>');


		if($this->form_validation->run() == FALSE){
			$query = $this->M_user->get($id);
			if($query->num_rows() > 0){
				$data['user'] = $query->row();
				$this->template->load('template','user/user_form_update',$data);
			}else{
				echo "<script>alert('Data Tidak Ditemukan');";
				echo "window.location='".site_url('User')."'</script>";
			}
		} else {
			$post = $this->input->post(null, TRUE);
			$this->M_user->update($post);
			if($this->db->affected_rows()>0){
				echo "<script>alert('Data Berhasil Disimpan')</script>";
			}
			echo "<script>window.location='".site_url('User')."'</script>";
		}
	}

	function username_check($value=''){
			$post = $this->input->post(null, TRUE);
			$query = $this->db->query("SELECT * FROM t_user WHERE username = '$post[username]' AND id_user != '$post[id_user]'");
			if($query ->num_rows() > 0){
				$this->form_validation->set_message('username_check', '%s ini sudah diapakai');
				return FALSE;
			}else {
				return TRUE;
			}
	}

	public function delete()
	{
		$id= $this->input->post('id_user');
		$this->M_user->delete($id);
		if($this->db->affected_rows()>0){
			echo "<script>alert('Data Berhasil Dihapus')</script>";
		}
		echo "<script>window.location='".site_url('User')."'</script>";

  }
}
