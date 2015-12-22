<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends MY_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('users','',TRUE);
 }

protected function authenticate()
{
	//Auth is open access	
}
 
function login()
{
	//This method will have the credentials validation
	$this->load->library('form_validation');
	
	$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
	$this->form_validation->run();
	redirect($_POST['redirect'], "location");
}

function logout()
{
	fetch_session();
	//clear sessions
	session_clear();
	addSuccess(getTxt('LogOutSuccess'));
	redirect('/home', 'refresh');
}

 function check_database($password)
 {
   //Field validation succeeded.  Validate against database
   $username = $this->input->post('username');

   //query the database
   $result = $this->users->login($username, $password);

   if($result)
   {
     foreach($result as $row)
     {
		 //Set the SESSION
		 fetch_session();
		 $_SESSION['username'] =$username;
		 $_SESSION['user_auth'] =$row->authority;
		 addSuccess(getTxt('LogInSuccess'));
     }
     return TRUE;
   }
   else
   {
     addError(getTxt('Incorrect'));
     return false;
   }
 }
}
?>