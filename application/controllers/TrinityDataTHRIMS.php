<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityDataTHRIMS extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: THRIMS Data Controller. Included 
	 * DATE CREATED: August 16, 2018
     * DATE UPDATED: August 16, 2018
	 */

	var	$LOGFOLDER = 'thrims';

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function getAllEmployeeListTHRIMS() {
			
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$page = isset($clean['page']) ? intval($clean['page']) : 1;
		$rows = isset($clean['rows']) ? intval($clean['rows']) : 10;
		$lastName = isset($clean['lastName']) ? $clean['lastName'] : '';
		$firstName = isset($clean['firstName']) ? $clean['firstName'] : '';
		$currentDepartment = isset($clean['currentDepartment']) ? $clean['currentDepartment'] : '';
		$active = isset($clean['active']) ? $clean['active'] : '';

		
		$offset = ($page-1)*$rows;
		$result = array();
		$whereSpcl = "triune_employee_data.lastName like '$lastName%'";
		$whereSpcl = $whereSpcl . " and triune_employee_data.firstName like '$firstName%'";
		$whereSpcl = $whereSpcl . " and triune_employee_data.currentDepartment like '$currentDepartment%'";
		$whereSpcl = $whereSpcl . " and triune_employee_data.active like '$active%'";
	 


		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_employee_data'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_employee_data'), 
			$fieldName = null, $where = null, 
			$join = null, 
			$joinType =null, 
			$sortBy = array('lastName', 'firstName'), $sortOrder = array('asc', 'asc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;

			echo json_encode($result);
    }


	public function updateRecordTHRIMS() {
		$employeeNumber = $_POST["employeeNumber"];
		$value = $_POST["value"];
		$fieldNm = $_POST["fieldName"];

		$userName = $this->_getUserName(1);
		
			$systemForAuditName = "THRIMS";
			$moduleName = "EMPLOYEEPROFILEUPDATE";

			$this->db->trans_start();

				$recordUpdate = array(
					$fieldNm => $value,
				);
			
				$this->_updateRecords($tableName = 'triune_employee_data', 
				$fieldName = array('employeeNumber'), 
				$where = array($employeeNumber), $recordUpdate);


				$actionName1 = "Update Employee Data";
				$for1 = $employeeNumber . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $fieldNm . " - " . $value;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_employee_data-update-" . $this->_getCurrentDate();
			$text1 = "UPDATE triune_employee_data ";
			$text1 = $text1 .  "SET " . $fieldNm . " = '" .  $value . "', ";
			$text1 = $text1 .  "WHERE employeeNumber = ".$employeeNumber;
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

			if($this->db->trans_status() === FALSE) {
				$this->_transactionFailed();
				return FALSE;  
			} 

				 /*   $message = '';                     
					$message .= '<strong>Request from user</strong>' . $userName . '<br>';

					
					$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
					if(!$emailSent) {
						//$this->session->set_flashdata('emailSent', '1');
						//echo "HELLO";
					} else {
						//$this->session->set_flashdata('emailSent', '1');
						//redirect(base_url().'user-acct/sign-up');

					}*/
			
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);
	}
	

	public function insertEmployeeCareerAssignmentsTHRIMS() {
		$employeeNumber = $_POST["employeeNumber"];
		$jobTitleID = $_POST["jobTitleID"];
		$departmentID = $_POST["departmentID"];
		$positionClassID = $_POST["positionClassID"];
		$employeeStatusID = $_POST["employeeStatusID"];
		$startDate = $_POST["startDate"];
		$expiryDate = $_POST["expiryDate"];
			
		$userName = $this->_getUserName(1);

		$transactionExist1 = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_employment_career_assignments'), 
		$fieldName = array('startDate', 'employeeNumber', 'jobTitleID', 'departmentID', 'positionClassID', 'employeeStatusID'), 
		$where = array($startDate, $employeeNumber, $jobTitleID, $departmentID, $positionClassID, $employeeStatusID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		$transactionExist2 = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_employment_career_history'), 
		$fieldName = array('startDate', 'employeeNumber', 'jobTitleID', 'departmentID', 'positionClassID', 'employeeStatusID'), 
		$where = array($startDate, $employeeNumber, $jobTitleID, $departmentID, $positionClassID, $employeeStatusID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		
		if( empty($transactionExist1) && empty($transactionExist2)) {
	
			$systemForAuditName1 = "THRIMS";
			$moduleName1 = "CAREERASSIGNMENTCREATE";
			$moduleName2 = "CAREERHISTORYCREATE";
			
			$insertData1 = null;
			$insertData1 = array(
				'employeeNumber' => $employeeNumber,
				'startDate' => $startDate,
				'expiryDate' => $expiryDate,
				'departmentID' => $departmentID,
				'positionClassID' => $positionClassID,
				'jobTitleID' => $jobTitleID,
				'employeeStatusID' => $employeeStatusID,
				'userName' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
				'workstationID' => $this->_getIPAddress(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_employment_career_assignments', $insertData1);        			 
			$insertedRecord2 =$this->_insertRecords($tableName = 'triune_employment_career_history', $insertData1);        			 


				$actionName1 = "Insert Career Assignment";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName1, $moduleName1, $for1, $oldValue1, $newValue1, $userType);		

				$actionName2 = "Insert Career History";
				$this->_insertAuditTrail($actionName2, $systemForAuditName1, $moduleName2, $for1, $oldValue1, $newValue1, $userType);		
				
				
				
			$this->db->trans_complete();
		
			$fileName1 = "triune_employment_career_assignments-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_employment_career_assignments ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$employeeNumber . "', ";
			$text1 = $text1 .  "'".$startDate . "', ";
			$text1 = $text1 .  "'".$expiryDate . "', ";
			$text1 = $text1 .  "'".$departmentID . "', ";
			$text1 = $text1 .  "'".$positionClassID . "', ";
			$text1 = $text1 .  "'".$jobTitleID . "', ";
			$text1 = $text1 .  "'".$employeeStatusID . "', ";
			$text1 = $text1 .  "'".$userName. "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
			$text1 = $text1 .  "'".$this->_getIPAddress(). "'";
			$text1 = $text1 . ");";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

			
			$fileName2 = "triune_employment_career_history-" . $this->_getCurrentDate();
			$text2 = "INSERT INTO triune_employment_career_history ";
			$text2 = $text2 .  "VALUES (" .  $insertedRecord2 . ", ";
			$text2 = $text2 .  "'".$employeeNumber . "', ";
			$text2 = $text2 .  "'".$startDate . "', ";
			$text2 = $text2 .  "'".$expiryDate . "', ";
			$text2 = $text2 .  "'".$departmentID . "', ";
			$text2 = $text2 .  "'".$positionClassID . "', ";
			$text2 = $text2 .  "'".$jobTitleID . "', ";
			$text2 = $text2 .  "'".$employeeStatusID . "', ";
			$text2 = $text2 .  "'".$userName. "', ";
			$text2 = $text2 .  "'".$this->_getTimeStamp(). "'";
			$text2 = $text2 .  "'".$this->_getIPAddress(). "'";
			$text2 = $text2 . ");";
			$this->_insertTextLog($fileName2, $text2, $this->LOGFOLDER);
			
			
			if($this->db->trans_status() === FALSE) {
				$this->_transactionFailed();
				return FALSE;  
			} 

                 /*   $message = '';                     
                    $message .= '<strong>Request from user</strong>' . $userName . '<br>';
 
					
					$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
                    if(!$emailSent) {
                        //$this->session->set_flashdata('emailSent', '1');
                        //echo "HELLO";
                    } else {
                        //$this->session->set_flashdata('emailSent', '1');
                        //redirect(base_url().'user-acct/sign-up');

                    }*/
			
			
			$returnValue = array();
			

			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} else  {//if(empty($transactionExist))
			$returnValue = array();
			$returnValue['success'] = 0;
			echo json_encode($returnValue);
		
		}
	}

	

    public function getEmploymentCareerAssignmentsTHRIMS() {
		$employeeNumber = $_GET["employeeNumber"];
			
		$selectField = "triune_employee_job_title.jobTitleDescription, triune_employee_department.departmentDescription, triune_employment_career_assignments.ID,";
		$selectField = $selectField . "triune_employee_job_status.jobStatusDescription, triune_employee_job_status.statusCategory, triune_employee_position_class.positionClass, ";
		$selectField = $selectField . "triune_employment_career_assignments.startDate, triune_employment_career_assignments.expiryDate, triune_employment_career_assignments.employeeStatusID";

		$resultsCareer = $this->_getRecordsData($dataSelect2 = array($selectField), 
			$tables = array('triune_employment_career_assignments', 'triune_employee_job_title', 'triune_employee_department', 'triune_employee_job_status', 'triune_employee_position_class'), 
			$fieldName = array('employeeNumber'), $where = array($employeeNumber), 
			$join = array('triune_employment_career_assignments.jobTitleID = triune_employee_job_title.jobTitleID', 'triune_employment_career_assignments.departmentID = triune_employee_department.departmentID', 'triune_employment_career_assignments.employeeStatusID = triune_employee_job_status.jobStatusID', 'triune_employment_career_assignments.positionClassID = triune_employee_position_class.positionClassID'), 
			$joinType = array('left', 'left', 'left', 'left'), 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		echo json_encode($resultsCareer);

	}

	
	
	public function deleteEmployeeCareerAssignmentsTHRIMS() {
		$ID = $_POST["ID"];
			
		$userName = $this->_getUserName(1);

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_employment_career_assignments'), 
		$fieldName = array('ID'), 
		$where = array($ID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		
		$systemForAuditName = "THRIMS";
		$moduleName = "CAREERASSIGNMENTDELETE";

		$this->db->trans_start();
			//CONDITION AND ACTION FOR DELETION
			$where = array($ID);
			$fieldName = array('ID');
			$this->_deleteRecords('triune_employment_career_assignments', $fieldName, $where);


			$actionName1 = "Delete Career Assignment";
			$for1 = $ID . ";" . $userName;
			$oldValue1 = $record;
			$newValue1 =  null;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();

		$fileName1 = "triune_employment_career_assignments-delete-" . $this->_getCurrentDate();
		$text1 = "INSERT INTO triune_employment_career_assignments ";
		$text1 = $text1 .  "VALUES (" .  $ID . ", ";
		$text1 = $text1 .  "'".$record[0]->employeeNumber . "', ";
		$text1 = $text1 .  "'".$record[0]->startDate . "', ";
		$text1 = $text1 .  "'".$record[0]->expiryDate . "', ";
		$text1 = $text1 .  "'".$record[0]->departmentID . "', ";
		$text1 = $text1 .  "".$record[0]->positionClassID . ", ";
		$text1 = $text1 .  "'".$record[0]->jobTitleID . "', ";
		$text1 = $text1 .  "'".$record[0]->employeeStatusID . "', ";
		$text1 = $text1 .  "'".$record[0]->salaryHonorarium . "', ";
		$text1 = $text1 .  "'".$record[0]->userName. "', ";
		$text1 = $text1 .  "'".$record[0]->timeStamp. "', ";
		$text1 = $text1 .  "'".$record[0]->workstationID. "'";
		$text1 = $text1 . ");";
		$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		if($this->db->trans_status() === FALSE) {
			$this->_transactionFailed();
			return FALSE;  
		} 

			 /*   $message = '';                     
				$message .= '<strong>Request from user</strong>' . $userName . '<br>';

				
				$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
				if(!$emailSent) {
					//$this->session->set_flashdata('emailSent', '1');
					//echo "HELLO";
				} else {
					//$this->session->set_flashdata('emailSent', '1');
					//redirect(base_url().'user-acct/sign-up');

				}*/
		
		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);
	}
	
	public function updateEmployeeCareerAssignmentsTHRIMS() {
		$startDate = $_POST["startDate"];
		$expiryDate = $_POST["expiryDate"];
		$jobTitleID = $_POST["jobTitleID"];
		$departmentID = $_POST["departmentID"];
		$positionClassID = $_POST["positionClassID"];
		$employeeNumber = $_POST["employeeNumber"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

		
		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_employment_career_assignments'), 
		$fieldName = array('ID'), 
		$where = array($ID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
	
		$systemForAuditName = "THRIMS";
		$moduleName = "CAREEREMPLOYMENTUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'startDate' => $startDate,
				'expiryDate' => $expiryDate,
				'jobTitleID' => $jobTitleID,
				'departmentID' => $departmentID,
				'positionClassID' => $positionClassID,
			);
		
			$this->_updateRecords($tableName = 'triune_employment_career_assignments', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Career Employment";
			$for1 = $employeeNumber . ";" . $userName;
			$oldValue1 = $record;
			$newValue1 =  $recordUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_employment_career_assignments-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_employment_career_assignments ";
		$text1 = $text1 .  "SET startDate = '" .  $record[0]->startDate . "', ";
		$text1 = $text1 .  "expiryDate = '" .  $record[0]->expiryDate . "', ";
		$text1 = $text1 .  "jobTitleID = '" .  $record[0]->jobTitleID . "' ";
		$text1 = $text1 .  "departmentID = '" .  $record[0]->departmentID . "', ";
		$text1 = $text1 .  "positionClassID = '" .  $record[0]->positionClassID . "' ";
		$text1 = $text1 .  "WHERE ID = ".$ID;
		$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		if($this->db->trans_status() === FALSE) {
			$this->_transactionFailed();
			return FALSE;  
		} 

			 /*   $message = '';                     
				$message .= '<strong>Request from user</strong>' . $userName . '<br>';

				
				$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
				if(!$emailSent) {
					//$this->session->set_flashdata('emailSent', '1');
					//echo "HELLO";
				} else {
					//$this->session->set_flashdata('emailSent', '1');
					//redirect(base_url().'user-acct/sign-up');

				}*/
		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}	


    public function getChildrenTHRIMS() {
		$employeeNumber = $_GET["employeeNumber"];
		//echo $locationCode;
		$results = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_employee_children'), $fieldName = array('employeeNumber'), $where = array($employeeNumber), $join = null, $joinType = null, 
			$sortBy = array('fullName'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
	}
	

	public function insertChildrenTHRIMS() {
		$employeeNumber = $_POST["employeeNumber"];
		$fullName = $_POST["fullName"];
		$birthDay = $_POST["birthDay"];
		$civilStatus = $_POST["civilStatus"];
			
		$userName = $this->_getUserName(1);

		$transactionExist1 = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_employee_children'), 
		$fieldName = array('employeeNumber', 'fullName', 'birthDay'), 
		$where = array($employeeNumber, $fullName, $birthDay), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		
		if( empty($transactionExist1)) {
	
			$systemForAuditName1 = "THRIMS";
			$moduleName1 = "CHILDRENCREATE";
			
			$insertData1 = null;
			$insertData1 = array(
				'employeeNumber' => $employeeNumber,
				'fullName' => $fullName,
				'birthDay' => $birthDay,
				'civilStatus' => $civilStatus,
				'userName' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
				'workstationID' => $this->_getIPAddress(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_employee_children', $insertData1);        			 


				$actionName1 = "Insert Children";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName1, $moduleName1, $for1, $oldValue1, $newValue1, $userType);		
				
			$this->db->trans_complete();
		
			$fileName1 = "triune_employee_children-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_employee_children ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$employeeNumber . "', ";
			$text1 = $text1 .  "'".$fullName . "', ";
			$text1 = $text1 .  "'".$birthDay . "', ";
			$text1 = $text1 .  "'".$civilStatus . "', ";
			$text1 = $text1 .  "'".$userName. "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
			$text1 = $text1 .  "'".$this->_getIPAddress(). "'";
			$text1 = $text1 . ");";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

			if($this->db->trans_status() === FALSE) {
				$this->_transactionFailed();
				return FALSE;  
			} 

                 /*   $message = '';                     
                    $message .= '<strong>Request from user</strong>' . $userName . '<br>';
 
					
					$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
                    if(!$emailSent) {
                        //$this->session->set_flashdata('emailSent', '1');
                        //echo "HELLO";
                    } else {
                        //$this->session->set_flashdata('emailSent', '1');
                        //redirect(base_url().'user-acct/sign-up');

                    }*/
			
			
			$returnValue = array();
			

			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} else  {//if(empty($transactionExist))
			$returnValue = array();
			$returnValue['success'] = 0;
			echo json_encode($returnValue);
		
		}
	}


	public function updateChildrenTHRIMS() {
		$fullName = $_POST["fullName"];
		$birthDay = $_POST["birthDay"];
		$civilStatus = $_POST["civilStatus"];
		$employeeNumber = $_POST["employeeNumber"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

		
		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_employee_children'), 
		$fieldName = array('ID'), 
		$where = array($ID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
	
		$systemForAuditName = "THRIMS";
		$moduleName = "CHILDRENUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'fullName' => $fullName,
				'birthDay' => $birthDay,
				'civilStatus' => $civilStatus,
			);
		
			$this->_updateRecords($tableName = 'triune_employee_children', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Children";
			$for1 = $employeeNumber . ";" . $userName;
			$oldValue1 = $record;
			$newValue1 =  $recordUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_employee_children-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_employee_children ";
		$text1 = $text1 .  "SET fullName = '" .  $record[0]->fullName . "', ";
		$text1 = $text1 .  "birthDay = '" .  $record[0]->birthDay . "', ";
		$text1 = $text1 .  "civilStatus = '" .  $record[0]->civilStatus . "' ";
		$text1 = $text1 .  "WHERE ID = ".$ID;
		$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		if($this->db->trans_status() === FALSE) {
			$this->_transactionFailed();
			return FALSE;  
		} 

			 /*   $message = '';                     
				$message .= '<strong>Request from user</strong>' . $userName . '<br>';

				
				$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
				if(!$emailSent) {
					//$this->session->set_flashdata('emailSent', '1');
					//echo "HELLO";
				} else {
					//$this->session->set_flashdata('emailSent', '1');
					//redirect(base_url().'user-acct/sign-up');

				}*/
		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}	


	public function deleteChildrenTHRIMS() {
		$ID = $_POST["ID"];
			
		$userName = $this->_getUserName(1);

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_employee_children'), 
		$fieldName = array('ID'), 
		$where = array($ID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		
		$systemForAuditName = "THRIMS";
		$moduleName = "CHILDRENDELETE";

		$this->db->trans_start();
			//CONDITION AND ACTION FOR DELETION
			$where = array($ID);
			$fieldName = array('ID');
			$this->_deleteRecords('triune_employee_children', $fieldName, $where);


			$actionName1 = "Delete Children";
			$for1 = $ID . ";" . $userName;
			$oldValue1 = $record;
			$newValue1 =  null;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();

		$fileName1 = "triune_employee_children-delete-" . $this->_getCurrentDate();
		$text1 = "INSERT INTO triune_employee_children ";
		$text1 = $text1 .  "VALUES (" .  $ID . ", ";
		$text1 = $text1 .  "'".$record[0]->fullName . "', ";
		$text1 = $text1 .  "'".$record[0]->birthDay . "', ";
		$text1 = $text1 .  "'".$record[0]->civilStatus . "', ";
		$text1 = $text1 .  "'".$record[0]->userName. "', ";
		$text1 = $text1 .  "'".$record[0]->timeStamp. "', ";
		$text1 = $text1 .  "'".$record[0]->workstationID. "'";
		$text1 = $text1 . ");";
		$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		if($this->db->trans_status() === FALSE) {
			$this->_transactionFailed();
			return FALSE;  
		} 

			 /*   $message = '';                     
				$message .= '<strong>Request from user</strong>' . $userName . '<br>';

				
				$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
				if(!$emailSent) {
					//$this->session->set_flashdata('emailSent', '1');
					//echo "HELLO";
				} else {
					//$this->session->set_flashdata('emailSent', '1');
					//redirect(base_url().'user-acct/sign-up');

				}*/
		
		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);
	}




	public function insertGenderTHRIMS() {
		$gender = $_POST["gender"];
			
		$userName = $this->_getUserName(1);

		$transactionExist1 = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_employee_gender'), 
		$fieldName = array('gender'), 
		$where = array($gender), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		
		if( empty($transactionExist1)) {
	
			$systemForAuditName1 = "THRIMS";
			$moduleName1 = "GENDERCREATE";
			
			$insertData1 = null;
			$insertData1 = array(
				'gender' => $gender,
				'userName' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
				'workstationID' => $this->_getIPAddress(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_employee_gender', $insertData1);        			 


				$actionName1 = "Insert Gender";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName1, $moduleName1, $for1, $oldValue1, $newValue1, $userType);		
				
			$this->db->trans_complete();
		
			$fileName1 = "triune_employee_gender-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_employee_gender ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'". '0' . "', ";
			$text1 = $text1 .  "'".$gender . "', ";
			$text1 = $text1 .  "'".$userName. "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp(). "',";
			$text1 = $text1 .  "'".$this->_getIPAddress(). "'";
			$text1 = $text1 . ");";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

			if($this->db->trans_status() === FALSE) {
				$this->_transactionFailed();
				return FALSE;  
			} 

                 /*   $message = '';                     
                    $message .= '<strong>Request from user</strong>' . $userName . '<br>';
 
					
					$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
                    if(!$emailSent) {
                        //$this->session->set_flashdata('emailSent', '1');
                        //echo "HELLO";
                    } else {
                        //$this->session->set_flashdata('emailSent', '1');
                        //redirect(base_url().'user-acct/sign-up');

                    }*/
			
			
			$returnValue = array();
			

			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} else  {//if(empty($transactionExist))
			$returnValue = array();
			$returnValue['success'] = 0;
			echo json_encode($returnValue);
		
		}
	}


	public function updateGenderTHRIMS() {
		$ID = $_POST["ID"];
		$gender = $_POST["gender"];

		$userName = $this->_getUserName(1);


			$transactionExist1 = $this->_getRecordsData($data = array('gender'), 
			$tables = array('triune_employee_gender'), 
			$fieldName = array('ID'), 
			$where = array($ID), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$oldGender = $transactionExist1[0]->gender;
		
			$systemForAuditName = "THRIMS";
			$moduleName = "GENDERUPDATE";

			$this->db->trans_start();

				$recordUpdate = array(
					'gender' => $gender,
				);
			
				$this->_updateRecords($tableName = 'triune_employee_gender', 
				$fieldName = array('ID'), 
				$where = array($ID), $recordUpdate);


				$actionName1 = "Update Gender Data";
				$for1 = $gender . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $gender;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_employee_gender-update-" . $this->_getCurrentDate();
			$text1 = "UPDATE triune_employee_gender ";
			$text1 = $text1 .  "SET " . 'gender' . " = '" .  $oldGender . "'";
			$text1 = $text1 .  "WHERE ID = ".$ID;
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

			if($this->db->trans_status() === FALSE) {
				$this->_transactionFailed();
				return FALSE;  
			} 

				 /*   $message = '';                     
					$message .= '<strong>Request from user</strong>' . $userName . '<br>';

					
					$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
					if(!$emailSent) {
						//$this->session->set_flashdata('emailSent', '1');
						//echo "HELLO";
					} else {
						//$this->session->set_flashdata('emailSent', '1');
						//redirect(base_url().'user-acct/sign-up');

					}*/
			
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);
	}
	
	
	public function deleteGenderTHRIMS() {
		$ID = $_POST["ID"];
			
		$userName = $this->_getUserName(1);

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_employee_gender'), 
		$fieldName = array('ID'), 
		$where = array($ID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		
		$systemForAuditName = "THRIMS";
		$moduleName = "GENDERDELETE";

		$this->db->trans_start();
			//CONDITION AND ACTION FOR DELETION
			$where = array($ID);
			$fieldName = array('ID');
			$this->_deleteRecords('triune_employee_gender', $fieldName, $where);


			$actionName1 = "Delete Gender";
			$for1 = $ID . ";" . $userName;
			$oldValue1 = $record;
			$newValue1 =  null;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();

		$fileName1 = "triune_employee_gender-delete-" . $this->_getCurrentDate();
		$text1 = "INSERT INTO triune_employee_gender ";
		$text1 = $text1 .  "VALUES (" .  $ID . ", ";
		$text1 = $text1 .  "'".$record[0]->genderID . "', ";
		$text1 = $text1 .  "'".$record[0]->gender . "', ";
		$text1 = $text1 .  "'".$record[0]->userName. "', ";
		$text1 = $text1 .  "'".$record[0]->timeStamp. "', ";
		$text1 = $text1 .  "'".$record[0]->workstationID. "'";
		$text1 = $text1 . ");";
		$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		if($this->db->trans_status() === FALSE) {
			$this->_transactionFailed();
			return FALSE;  
		} 

			 /*   $message = '';                     
				$message .= '<strong>Request from user</strong>' . $userName . '<br>';

				
				$emailSent = $this->_sendMail($toEmail = 'rdlagdaan@tua.edu.ph', $subject = "Email Notification from" . $userName, $message);
				if(!$emailSent) {
					//$this->session->set_flashdata('emailSent', '1');
					//echo "HELLO";
				} else {
					//$this->session->set_flashdata('emailSent', '1');
					//redirect(base_url().'user-acct/sign-up');

				}*/
		
		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);
	}


    public function getEvaluationDetailsTHRIMS() {

			
			$selectField = "triune_section_junior_high.sectionCode, triune_subject_junior_high.subjectCode, triune_subject_junior_high.subjectDescription, triune_section_junior_high.employeeNumber, ";
			$selectField = $selectField . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName) as facultyFullName, ";
			$selectField = $selectField . "question1, question2, question3, question4, question5, question6, question7, question8, question9, question10, ";
			$selectField = $selectField . "question11, question12, question13, question14, question15, question16, question17, question18, question19, question20, ";
			$selectField = $selectField . "question21, question22, question23, question24, question25, question26, question27, question28, question29, question30, ";
			$selectField = $selectField . "question31, question32, question33, question34, question35, question36, question37, question38, question39, question40, ";
			$selectField = $selectField . "question41, question42, question43, comments";
			
			$results = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_student_roster_junior_high', 'triune_subject_junior_high', 'triune_section_junior_high', 'triune_employee_data', 'triune_faculty_evaluation_answers'), 
			$fieldName = array('triune_student_roster_junior_high.sy', 'triune_student_roster_junior_high.studentNumber'), 
			$where = array($_SESSION['sy'], $_SESSION['userNumber']), 
			$join = array('triune_student_roster_junior_high.subjectCode = triune_subject_junior_high.subjectCode', 
			'triune_student_roster_junior_high.sy = triune_section_junior_high.sy AND triune_student_roster_junior_high.sectionCode = triune_section_junior_high.sectionCode AND triune_student_roster_junior_high.subjectCode = triune_section_junior_high.subjectCode', 
			'triune_section_junior_high.employeeNumber = triune_employee_data.employeeNumber',
			'triune_student_roster_junior_high.sy = triune_faculty_evaluation_answers.sy AND triune_student_roster_junior_high.sem = triune_faculty_evaluation_answers.sem AND triune_student_roster_junior_high.sectionCode = triune_faculty_evaluation_answers.sectionCode AND triune_student_roster_junior_high.subjectCode = triune_faculty_evaluation_answers.subjectCode  AND triune_student_roster_junior_high.studentNumber = triune_faculty_evaluation_answers.studentNumber'), 
			$joinType = array('left', 'left', 'left', 'left'), 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
			if(empty($results)) {

					$selectField = "triune_section_senior_high.sectionCode, triune_subject_senior_high.subjectCode, triune_subject_senior_high.subjectDescription, triune_section_senior_high.employeeNumber, ";
					$selectField = $selectField . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName) as facultyFullName, ";
					$selectField = $selectField . "question1, question2, question3, question4, question5, question6, question7, question8, question9, question10, ";
					$selectField = $selectField . "question11, question12, question13, question14, question15, question16, question17, question18, question19, question20, ";
					$selectField = $selectField . "question21, question22, question23, question24, question25, question26, question27, question28, question29, question30, ";
					$selectField = $selectField . "question31, question32, question33, question34, question35, question36, question37, question38, question39, question40, ";
					$selectField = $selectField . "question41, question42, question43, comments";
					
					$results = $this->_getRecordsData($data = array($selectField), 
					$tables = array('triune_student_roster_senior_high', 'triune_subject_senior_high', 'triune_section_senior_high', 'triune_employee_data', 'triune_faculty_evaluation_answers'), 
					$fieldName = array('triune_student_roster_senior_high.sy', 'triune_student_roster_senior_high.sem', 'triune_student_roster_senior_high.studentNumber'), 
					$where = array($_SESSION['sy'], $_SESSION['sem'], $_SESSION['userNumber']), 
					$join = array('triune_student_roster_senior_high.subjectCode = triune_subject_senior_high.subjectCode', 
					'triune_student_roster_senior_high.sy = triune_section_senior_high.sy AND triune_student_roster_senior_high.sem = triune_section_senior_high.sem AND triune_student_roster_senior_high.sectionCode = triune_section_senior_high.sectionCode AND triune_student_roster_senior_high.subjectCode = triune_section_senior_high.subjectCode', 
					'triune_section_senior_high.employeeNumber = triune_employee_data.employeeNumber', 
					'triune_student_roster_senior_high.sy = triune_faculty_evaluation_answers.sy AND triune_student_roster_senior_high.sem = triune_faculty_evaluation_answers.sem AND triune_student_roster_senior_high.sectionCode = triune_faculty_evaluation_answers.sectionCode AND triune_student_roster_senior_high.subjectCode = triune_faculty_evaluation_answers.subjectCode  AND triune_student_roster_senior_high.studentNumber = triune_faculty_evaluation_answers.studentNumber'), 
					$joinType = array('left', 'left', 'left', 'left'), 
					$sortBy = null, $sortOrder = null, $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
					
					if(empty($results)) {
						$selectField = "triune_employee_data.employeeNumber, triune_faculty_load_college.sectionCode, triune_faculty_load_college.subjectCode, triune_subjects_college.subjectDescription, ";
						$selectField = $selectField . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName) as facultyFullName, ";
						$selectField = $selectField . "question1, question2, question3, question4, question5, question6, question7, question8, question9, question10, ";
						$selectField = $selectField . "question11, question12, question13, question14, question15, question16, question17, question18, question19, question20, ";
						$selectField = $selectField . "question21, question22, question23, question24, question25, question26, question27, question28, question29, question30, ";
						$selectField = $selectField . "question31, question32, question33, question34, question35, question36, question37, question38, question39, question40, ";
						$selectField = $selectField . "question41, question42, question43, comments";
						
						$results = $this->_getRecordsData($data = array($selectField), 
						$tables = array('triune_class_list_college', 'triune_faculty_load_college', 'triune_employee_data', 'triune_subjects_college', 'triune_faculty_evaluation_answers'), 
						$fieldName = array('triune_class_list_college.sy', 'triune_class_list_college.sem', 'triune_class_list_college.studentNumber'), 
						$where = array($_SESSION['sy'], $_SESSION['sem'], $_SESSION['userNumber']), 
						$join = array('triune_class_list_college.sy = triune_faculty_load_college.sy AND triune_class_list_college.sem = triune_faculty_load_college.sem AND triune_class_list_college.sectionCode = triune_faculty_load_college.sectionCode AND triune_class_list_college.eSubjectCode = triune_faculty_load_college.subjectCode', 
						'triune_faculty_load_college.fCode = triune_employee_data.employeeNumber', 
						'triune_faculty_load_college.subjectCode = triune_subjects_college.subjectCode', 
						'triune_class_list_college.sy = triune_faculty_evaluation_answers.sy AND triune_class_list_college.sem = triune_faculty_evaluation_answers.sem AND triune_class_list_college.eSubjectCode = triune_faculty_evaluation_answers.subjectCode AND triune_class_list_college.sectionCode = triune_faculty_evaluation_answers.sectionCode  AND triune_class_list_college.studentNumber = triune_faculty_evaluation_answers.studentNumber AND triune_faculty_load_college.fCode = triune_faculty_evaluation_answers.employeeNumber'), 
						$joinType = array('left', 'left', 'left', 'left'), 
						$sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
						
						
						
					}
				
			}
			
			
			
			echo json_encode($results);
    }


	public function populateEvaluationDetailsTHRIMS() {
		$employeeNumber = $_POST['employeeNumber'];
		$sectionCode = $_POST['sectionCode'];
		$subjectCode = $_POST['subjectCode'];
		$fieldNameData = $_POST['fieldName'];
		$value = $_POST['value'];
		$userName = $this->_getUserName(1);
		
		$exist = $this->_getRecordsData($data = array("*"), 
			$tables = array('triune_faculty_evaluation_answers'), 
			$fieldName = array('employeeNumber', 'sectionCode', 'subjectCode', 'studentNumber', 'sy', 'sem'), 
			$where = array($employeeNumber, $sectionCode, $subjectCode, $_SESSION['userNumber'], $_SESSION['sy'], $_SESSION['sem']), 
			$join = null, 
			$joinType = null, 
			$sortBy = null, 
			$sortOrder = null, 
			$limit = null, 
			$fieldNameLike = null, 
			$like = null, 
			$whereSpecial = null, 
			$groupBy = null );
			
		if(empty($exist)) {
				$insertData1 = null;
				$insertData1 = array(
					'sy' => $_SESSION['sy'],
					'sem' => $_SESSION['sem'],
					'subjectCode' => $subjectCode,
					'sectionCode' => $sectionCode,
					'employeeNumber' => $employeeNumber,
					'studentNumber' => $_SESSION['userNumber'],
					$fieldNameData => $value,
					'workstationID' => $this->_getIPAddress(),
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),
				);				 

				$insertedRecord1 =$this->_insertRecords($tableName = 'triune_faculty_evaluation_answers', $insertData1);        			 
			
		
		} else {
			
				$recordUpdate = array(
					$fieldNameData => $value,
				);
			
				$this->_updateRecords($tableName = 'triune_faculty_evaluation_answers', 
				$fieldName = array('employeeNumber', 'sectionCode', 'subjectCode', 'studentNumber', 'sy', 'sem'), 
				$where = array($employeeNumber, $sectionCode, $subjectCode, $_SESSION['userNumber'], $_SESSION['sy'], $_SESSION['sem']), $recordUpdate);
			
		}
		
	}



	public function postEvaluationTHRIMS() {
		$userName = $this->_getUserName(1);
		
		$exist = $this->_getRecordsData($data = array("*"), 
			$tables = array('triune_faculty_evaluation_post'), 
			$fieldName = array('studentNumber', 'sy', 'sem'), 
			$where = array($_SESSION['userNumber'], $_SESSION['sy'], $_SESSION['sem']), 
			$join = null, 
			$joinType = null, 
			$sortBy = null, 
			$sortOrder = null, 
			$limit = null, 
			$fieldNameLike = null, 
			$like = null, 
			$whereSpecial = null, 
			$groupBy = null );
			
		if(empty($exist)) {
				$insertData1 = null;
				$insertData1 = array(
					'sy' => $_SESSION['sy'],
					'sem' => $_SESSION['sem'],
					'studentNumber' => $_SESSION['userNumber'],
					'postedFlag' => 1,
					'workstationID' => $this->_getIPAddress(),
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),
				);				 

				$insertedRecord1 =$this->_insertRecords($tableName = 'triune_faculty_evaluation_post', $insertData1);        			 
			
		
		} else {
			
				$recordUpdate = array(
					'postedFlag' => 1,
				);
			
				$this->_updateRecords($tableName = 'triune_faculty_evaluation_post', 
				$fieldName = array('studentNumber', 'sy', 'sem'), 
				$where = array($_SESSION['userNumber'], $_SESSION['sy'], $_SESSION['sem']), $recordUpdate);
			
		}
		
	}

	
	public function checkEvaluationPostingTHRIMS() {

		$exist = $this->_getRecordsData($data = array("*"), 
			$tables = array('triune_faculty_evaluation_post'), 
			$fieldName = array('studentNumber', 'sy', 'sem'), 
			$where = array($_SESSION['userNumber'], $_SESSION['sy'], $_SESSION['sem']), 
			$join = null, 
			$joinType = null, 
			$sortBy = null, 
			$sortOrder = null, 
			$limit = null, 
			$fieldNameLike = null, 
			$like = null, 
			$whereSpecial = null, 
			$groupBy = null );
	
		$returnValue = array();
		
		if(empty($exist)) {
			$returnValue['success'] = 0;
		} else {
			$returnValue['success'] = 1;
		}
		
		echo json_encode($returnValue);
	}
	
	
	
}