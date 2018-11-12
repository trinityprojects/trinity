<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityDataMyAccount extends MY_Controller {

	/**
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Account Controller. Included 
	 * DATE CREATED: November 11, 2018
     * DATE UPDATED: November 11, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('encryption');		
		
    }//function __construct()



	public function resetPassword() {
		
		$post = $this->input->post(NULL, TRUE);

		$cleanPost = $this->security->xss_clean($post);
		$hashed = $this->encryption->encrypt($cleanPost['userNumber']);      
        $ID = $_POST['ID'];    
		
		$defaultPassword = $hashed;

		$recordUpdate = array(
			'password' => $defaultPassword,
			'lastLogin' => date('Y-m-d h:i:s A'),
		);
	
		$this->_updateRecords($tableName = 'triune_user', 
		$fieldName = array('ID'), 
		$where = array($ID), $recordUpdate);

		
		
		$result["successMessage"] = 'Password Updated to Default - User Number';
		echo json_encode($result);
		
	}
	
}