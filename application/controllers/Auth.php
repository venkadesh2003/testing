<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('Admin_model');
    $this->load->database();
  }

  public function index()
  {
    if ($this->session->userdata('username')) {
      
      switch ($this->session->userdata('role_id')) {
        case 1:
          redirect('admin');
          break;
        case 2:
          redirect('profile');
          break;
      }
    }
    // Login Page
    $d['title'] = 'Login Page';

    // Form Validation
    $this->form_validation->set_rules('username', 'Username', 'required|trim');
    $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]');

    if ($this->form_validation->run() == false) {
      $this->load->view('templates/auth_header', $d);
      $this->load->view('auth/index');
      $this->load->view('templates/auth_footer');
    } else {
      $this->_login();
    }
  }

  private function _login()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');

    $user = $this->db->get_where('users', ['username' => $username])->row_array();

    if ($user) {
      if (password_verify($password, $user['password'])) {
        $data = [
          'username' => $user['username'],
          'role_id' => $user['role_id']
        ];
        $this->session->set_userdata($data);
        switch ($user['role_id']) {
          case 1:
            redirect('admin');
            break;
          case 2:
            redirect('profile');
            break;
        }
      } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          Wrong password!</div>');
        redirect('auth');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
      Username Not Found</div>');
      redirect('auth');
    }

    if ($user) {
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong password or Invalid username!</div>');
      redirect('auth');
    }
  }
  public function logout()
  {
    $this->session->unset_userdata('username');
    $this->session->unset_userdata('role_id');
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Logged Out!</div>');
    redirect('auth');
  }
  public function blocked()
  {
    $d['title'] = 'Access Blocked';
    $this->load->view('auth/blocked', $d);
  }
  public function reset()
  {
    $d['title'] = 'reset';    
    $this->load->view('templates/auth_header', $d);
    $this->load->view('auth/reset');
    $this->load->view('templates/auth_footer');
   
  }
  public function password() {
    $email = $this->input->post('email');
    $security = $this->input->post('security');
    $data = $this->Admin_model->getDetails($email, $security);
    // echo "<pre>";
    // print_r($data);
    // exit;

    if ($data) {
        $this->load->view('password_reset_form', ['email' => $email, 'security' => $security]);
    } else {
      $this->session->set_flashdata('password_reset_message', 'No data found in the database for the given email and security');    
      redirect('auth/reset');
    }
    }

public function reset_password() {
  $email = $this->input->post('email');
  $security = $this->input->post('security');
  $newPassword = $this->input->post('new_password');
  $confirmPassword = $this->input->post('confirm_password');

  if ($newPassword === $confirmPassword) {
      // Hash the new password
      $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

      // Check if the user with the given email and security information exists
      $user = $this->Admin_model->getUserByEmailAndSecurity($email, $security);


      if ($user) {
          // Update the password in the 'users' table using the user's employee_id
          $result = $this->Admin_model->updatePassword($user->employee_id, $hashedPassword);

          if ($result) {
            $this->session->set_flashdata('password_reset_message', 'Password reset successful. You can now log in.');
            redirect('auth');
          }
           else {
              echo "Password reset failed. Please try again.";
          }
      } else {
          echo "Invalid email or security information.";
      }
  } else {
    $this->session->set_flashdata('password_reset_message', 'Passwords do not match. Please try again.');
    redirect('auth/reset');
  }
}


}
