<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main_model extends CI_Model {

    function insertRecord($record){
        
        if(count($record) > 0){
            
            // Check user
            $this->db->select('*');
            $this->db->where('id', $record[0]);
            $q = $this->db->get('employee');
            $response = $q->result_array();
            
            // Insert record
            if(count($response) == 0){
                $newuser = array(
                    "id" => trim($record[0]),
                    "name" => trim($record[1]),
                    "email" => trim($record[2]),
                    "gender" => trim($record[3]),
                    "image" => trim($record[4]),
                    "birth_date" => trim($record[5]),
                    "hire_date" => trim($record[6]),
                    "shift_id" => trim($record[7]),
                    "security_answer" => trim($record[8])
                );

                $this->db->insert('employee', $newuser);
            }
            
        }
        
    }

}