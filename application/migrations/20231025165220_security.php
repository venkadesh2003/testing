<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
class Migration_Security extends CI_Migration { 
    public function up()
    {
            $fields = array(
                    'security_answer' => array(
                             'type' => 'varchar',
                             'constraint' => 100
                    ),
            );
            $this->dbforge->add_column('employee', $fields);
    }
}