<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityMyAccount extends MY_Controller {

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

    public function myAccountInfo() {

		$results1 = $this->_getRecordsData($records = array('*'), 
			$tables = array('triune_user'), $fieldName = array('userNumber'), $where = array($_SESSION['userNumber']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

		$data['ID'] = $results1[0]->ID;
		$data['userName'] = $results1[0]->userName;
		$data['userNumber'] = $results1[0]->userNumber;
		$data['fullName'] = $results1[0]->firstNameUser . ' ' . $results1[0]->lastNameUser;
		$data['emailAddress'] = $results1[0]->emailAddress;
		$data['companyNameUser'] = $results1[0]->companyNameUser;

		$this->load->view('MYACCOUNT/account-details', $data);
    }

	
}