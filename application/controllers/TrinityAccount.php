<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityAccount extends MY_Controller {

	/**
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Account Controller. Included 
	 * DATE CREATED: November 11, 2018
     * DATE UPDATED: November 11, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function showUsersList() {
        //echo "HELLO WORLD";
        $this->load->view('ACCOUNT/users-list');
    }

    public function showAccountUserDetails() {
		$data['ID'] = $_POST["ID"];

		$results1 = $this->_getRecordsData($records = array('*'), 
			$tables = array('triune_user'), $fieldName = array('ID'), $where = array($data['ID']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		$data['userName'] = $results1[0]->userName;
		$data['userNumber'] = $results1[0]->userNumber;
		$data['fullName'] = $results1[0]->firstNameUser . ' ' . $results1[0]->lastNameUser;
		$data['emailAddress'] = $results1[0]->emailAddress;
		$data['companyNameUser'] = $results1[0]->companyNameUser;
		
        $this->load->view('ACCOUNT/user-details', $data);
    }
	
}