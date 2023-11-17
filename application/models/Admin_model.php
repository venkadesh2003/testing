<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
  public function getAdmin($username)
  {
    $account = $this->db->get_where('users', ['username' => $username])->row_array();
    $e_id = $account['employee_id'];
    $query = "SELECT  employee.id AS `id`,
                      employee.name AS `name`,
                      employee.gender AS `gender`,   
                      employee.shift_id AS `shift`,
                      employee.image AS `image`,
                      employee.birth_date AS `birth_date`,
                      employee.hire_date AS `hire_date`,
                      employee.security_answer AS `security_answer`
                FROM  employee
               WHERE `employee`.`id` = '$e_id'";
    return $this->db->query($query)->row_array();
  }
  public function getDataForDashboard()
  {
    $d['shift'] = $this->db->get('shift')->result_array();
    $d['c_shift'] = $this->db->get('shift')->num_rows();
    $d['location'] = $this->db->get('location')->result_array();
    $d['c_location'] = $this->db->get('location')->num_rows();
    $d['employee'] = $this->db->get('employee')->result_array();
    $d['c_employee'] = $this->db->get('employee')->num_rows();
    $d['department'] = $this->db->get('department')->result_array();
    $d['c_department'] = $this->db->get('department')->num_rows();
    $d['users'] = $this->db->get('users')->result_array();
    $d['c_users'] = $this->db->get('users')->num_rows();

    return $d;
  }

  public function getDepartment()
  {
    $query = "SELECT  department.name AS d_name,
                      department.id AS d_id,
                      COUNT(employee_department.employee_id) AS d_quantity
                FROM  department
                JOIN  employee_department
                  ON  department.id = employee_department.department_id
            GROUP BY  d_name
    ";
    return $this->db->query($query)->result_array();
  }

  public function getDepartmentEmployees($d_id)
  {
    $query = "SELECT  employee_department.employee_id AS e_id,
                      employee.name AS e_name,
                      employee.image AS e_image,
                      employee.hire_date AS e_hdate
                FROM  employee_department
          INNER JOIN  employee
                  ON  employee_department.employee_id = employee.id
               WHERE  employee_department.department_id = '$d_id'
    ";
    return $this->db->query($query)->result_array();
  }

  public function getEmployeeStatsbyCurrent($e_id)
  {
    $year = date('Y', time());
    $month = date('m', time());
    $query = "SELECT  in_time AS `date`,
                      out_time AS `out_time`,
                      shift_id AS `shift`,
                      in_status AS `status`,
                      lack_of AS `lack_of`
                FROM  attendance
                WHERE  employee_id = $e_id
                  AND  YEAR(FROM_UNIXTIME(in_time)) = $year
                  AND  MONTH(FROM_UNIXTIME(in_time)) = $month
            ORDER BY  `date` ASC";

    return $this->db->query($query)->result_array();
  }
//   public function getDetails($email,$security)
//   {
//     $query = "SELECT  employee.name AS u_name,
//     employee.email AS e_email,
//       employee.security_answer AS s_answer
//     FROM  employee
//     WHERE email = '$email'
//     AND security_answer = '$security'";
//     return $this->db->query($query)->result_array();
//   }
// public function getDetails($email, $security)
// {
//   $this->db->select('employee.name AS u_name, employee.email AS e_email, employee.security_answer AS s_answer, users.username, users.password, users.role_id');
//   $this->db->from('employee');
//   $this->db->join('users', 'employee.id = users.employee_id', 'inner');
//   $this->db->where('employee.email', $email);
//   $this->db->where('employee.security_answer', $security);
//   $query = $this->db->get();
  

//     return $query->result_array();
// }
public function getDetails($email, $security) {
  $this->db->select('employee.id AS employee_id, employee.name AS u_name, employee.email AS e_email, employee.security_answer AS s_answer, users.username, users.password, users.role_id, users.employee_id AS employee_id');
  $this->db->from('employee');
  $this->db->join('users', 'employee.id = users.employee_id', 'inner');
  $this->db->where('employee.email', $email);
  $this->db->where('employee.security_answer', $security);
  $query = $this->db->get();

  return $query->result_array();
}

// public function updatePassword($email, $hashedPassword) {

//   $this->db->where('email', $email);
//   $this->db->update('users', ['password' => $hashedPassword]);
//  $var = $this->db->affected_rows();
//   return $this->db->affected_rows() > 0;
// }
// public function updatePassword($email, $hashedPassword) {
//   $this->db->trans_start(); // Start a transaction

//   // Specify the email in the 'employee' table
//   $this->db->where('employee.email', $email);

//   // Join 'users' and 'employee' based on the common column
//   $this->db->join('users', 'employee.id = users.employee_id', 'inner');

//   // Update the 'password' field in the 'users' table
//   $this->db->update('users', ['password' => $hashedPassword]);

//   $var = $this->db->affected_rows(); // Get the number of affected rows

//   $this->db->trans_complete(); // Complete the transaction

//   // Check if the transaction was successful and return the result
//   if ($this->db->trans_status() === FALSE) {
//       return false; // Transaction failed
//   } else {
//       return $this->db->affected_rows() > 0; // Return true if rows were affected
//   }
// }


public function getUserByEmailAndSecurity($email, $security) {
  $this->db->select('employee.id as employee_id');
  $this->db->from('employee');
  $this->db->join('users', 'employee.id = users.employee_id', 'inner');
  $this->db->where('employee.email', $email);
  $this->db->where('employee.security_answer', $security);

  $query = $this->db->get();

  if ($query->num_rows() == 1) {
      return $query->row();
  } else {
      return false;
  }
}

  public function updatePassword($employee_id, $hashedPassword) {
      // Update the password in the 'users' table
      $this->db->where('employee_id', $employee_id);
      $this->db->update('users', array('password' => $hashedPassword));

      return $this->db->affected_rows() > 0; 
  }
  public function getTodayAttendance() {
    $sql = "SELECT attendance.*, employee.name, employee.email, employee.gender
            FROM attendance
            INNER JOIN employee ON attendance.employee_id = employee.id
            WHERE DATE(FROM_UNIXTIME(in_time)) = CURDATE()";
            return $this->db->query($sql)->result_array();
    //    $sql = "SELECT attendance.in_time,
    //    employee.name AS name,
    //    attendance.out_time
    //    FROM attendance
    //    INNER JOIN employee
    //    ON attendance.employee_id = employee.id
    //    where (DATE(FROM_UNIXTIME(in_time)) = CURDATE())";
    // $query = $this->db->query($sql);
    // $result = $query->result();
}


}


