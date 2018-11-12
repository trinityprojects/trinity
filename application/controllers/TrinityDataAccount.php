<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityDataAccount extends MY_Controller {

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

    public function getAllUsersList() {
			
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$page = isset($clean['page']) ? intval($clean['page']) : 1;
		$rows = isset($clean['rows']) ? intval($clean['rows']) : 10;
		$lastNameUser = isset($clean['lastNameUser']) ? $clean['lastNameUser'] : '';
		$firstNameUser = isset($clean['firstNameUser']) ? $clean['firstNameUser'] : '';

		
		$offset = ($page-1)*$rows;
		$result = array();
		$whereSpcl = "triune_user.lastNameUser like '$lastNameUser%'";
		$whereSpcl = $whereSpcl . " and triune_user.firstNameUser like '$firstNameUser%'";
	 


		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_user'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_user'), 
			$fieldName = null, $where = null, 
			$join = null, 
			$joinType =null, 
			$sortBy = array('lastNameUser', 'firstNameUser'), $sortOrder = array('asc', 'asc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;

			echo json_encode($result);
    }


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