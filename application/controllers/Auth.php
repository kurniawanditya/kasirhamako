<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function index()
	 {
		check_already_login();
	 	$this->load->view('auth');
	 }

	 public function process()
	 {
		 $post = $this->input->post(null,TRUE);
		 if(isset($_POST['login'])){
				$this->load->model('M_auth');
			 	$query = $this->M_auth->login($post);
				if($query->num_rows() > 0){
					$row = $query->row();
					$params = array(
						'id_user' => $row->id_user,
						'level' => $row->level
					 );
					 $this->session->set_userdata($params);
					 echo "<script>
					 	window.location='".site_url('dashboard')."';
						</script>";
				}else{
					echo "<script>
					 window.location='".site_url('Auth')."';
					 </script>";
				}
		 }
	 }

	public function logout()
 	{
	 		$params = array('id_user','level');
			$this->session->unset_userdata($params);
			redirect('Auth');
 	}
}
