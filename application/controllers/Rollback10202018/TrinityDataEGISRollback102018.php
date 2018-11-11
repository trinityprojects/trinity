<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityDataEGIS extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Building Controller. Included 
	 * DATE CREATED: August 04, 2018
     * DATE UPDATED: August 04, 2018
	 */
	var	$LOGFOLDER = 'egis';

    function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('form_validation'); 
		
    }//function __construct()

    public function officerSetupEGIS() {
		$selectFields = "triune_employee_data.employeeNumber,  ";
		$selectFields = $selectFields . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName) as fullName, ";
		$selectFields = $selectFields . "triune_department_head_k12.designationDescription, triune_department_head_k12.departmentCode";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_department_head_k12', 'triune_employee_data'), $fieldName = null, $where = null, 
			$join = array('triune_department_head_k12.employeeNumber = triune_employee_data.employeeNumber'), $joinType = array('inner'), 
			$sortBy = array('lastName', 'firstName'), $sortOrder = array('asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }


	public function insertOfficerRecordsEGIS() {
		$employeeNumber = $_POST["employeeNumber"];
		$departmentCode = $_POST["departmentCode"];
		$designationDescription = $_POST["designationDescription"];
			
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_department_head_k12'), 
		$fieldName = array('sy', 'employeeNumber', 'departmentCode', 'designationDescription'), 
		$where = array($_SESSION['sy'], $employeeNumber, $departmentCode, $designationDescription), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

		
		
			$systemForAuditName = "EGIS";
			$moduleName = "OFFICERSETUPCREATE";
			
			$levelCode = null;
			$courseCode = null;
			
			$insertData1 = null;
			$insertData1 = array(
				'sy' => $_SESSION['sy'],
				'levelCode' => $levelCode,
				'courseCode' => $courseCode,
				'departmentCode' => $departmentCode,
				'employeeNumber' => $employeeNumber,
				'designationDescription' => $designationDescription,
				'userName' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_department_head_k12', $insertData1);        			 


				$actionName1 = "Insert Officer Setup";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_department_head_k12-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_department_head_k12 ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
			$text1 = $text1 .  "'".$levelCode . "', ";
			$text1 = $text1 .  "'".$courseCode . "', ";
			$text1 = $text1 .  "'".$departmentCode . "', ";
			$text1 = $text1 .  "'".$employeeNumber . "', ";
			$text1 = $text1 .  "'".$designationDescription . "', ";
			$text1 = $text1 .  "'".$userName. "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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
	
    public function getOfficersEGIS() {
		$selectFields = "triune_employee_data.employeeNumber,  ";
		$selectFields = $selectFields . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName) as fullName, ";
		$selectFields = $selectFields . "triune_department_head_k12.designationDescription, triune_department_head_k12.departmentCode";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_department_head_k12', 'triune_employee_data'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = array('triune_department_head_k12.employeeNumber = triune_employee_data.employeeNumber'), $joinType = array('inner'), 
			$sortBy = array('lastName', 'firstName'), $sortOrder = array('asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	


	public function deleteOfficerRecordsEGIS() {
		$employeeNumber = $_POST["employeeNumber"];
		$departmentCode = $_POST["departmentCode"];
		$designationDescription = $_POST["designationDescription"];
		$levelCode = null;
		$courseCode = null;
			
		$userName = $this->_getUserName(1);

		$transaction = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_department_head_k12'), 
		$fieldName = array('sy', 'employeeNumber', 'departmentCode', 'designationDescription'), 
		$where = array($_SESSION['sy'], $employeeNumber, $departmentCode, $designationDescription), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );



		
		$systemForAuditName = "EGIS";
		$moduleName = "OFFICERSETUPDELETE";
		

		

		$this->db->trans_start();
			//CONDITION AND ACTION FOR DELETION
			$where = array($employeeNumber, $departmentCode, $designationDescription);
			$fieldName = array('employeeNumber', 'departmentCode', 'designationDescription');
			$this->_deleteRecords('triune_department_head_k12', $fieldName, $where);


			$actionName1 = "Delete Officer Setup";
			$for1 = $employeeNumber . ";" . $departmentCode . ";" . $designationDescription . ";" . $userName;
			$oldValue1 = $employeeNumber . ";" . $departmentCode . ";" . $designationDescription;
			$newValue1 =  null;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_department_head_k12-delete" . $this->_getCurrentDate();
		$text1 = "INSERT INTO triune_department_head_k12 ";
		$text1 = $text1 .  "VALUES (" .  $transaction[0]->ID . ", ";
		$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
		$text1 = $text1 .  "'".$levelCode . "', ";
		$text1 = $text1 .  "'".$courseCode . "', ";
		$text1 = $text1 .  "'".$departmentCode . "', ";
		$text1 = $text1 .  "'".$employeeNumber . "', ";
		$text1 = $text1 .  "'".$designationDescription . "', ";
		$text1 = $text1 .  "'".$userName. "', ";
		$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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

	

    public function getSectionElementaryEGIS() {
		$selectFields = "triune_section_elementary.ID, triune_section_elementary.sectionCode, triune_section_elementary.subjectCode, ";
		$selectFields = $selectFields . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName, ';' , triune_employee_data.employeeNumber) as fullName, ";
		$selectFields = $selectFields . "triune_subject_elementary.subjectDescription, triune_employee_data.employeeNumber";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_elementary', 'triune_employee_data', 'triune_subject_elementary'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = array('triune_section_elementary.employeeNumber = triune_employee_data.employeeNumber', 'triune_section_elementary.subjectCode = triune_subject_elementary.subjectCode'), $joinType = array('left', 'left'), 
			$sortBy = array('sectionCode', 'subjectDescription', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	



	public function updateSectionElementaryEGIS() {
		$fullName = $_POST["fullName"];
		if(!empty($fullName)) {
			$ID = $_POST["ID"];
			$userName = $this->_getUserName(1);

			$fN = explode(";", $fullName, 2);
			$employeeNumber = $fN[1];
		
			$systemForAuditName = "EGIS";
			$moduleName = "ELEMENTARYSECTIONUPDATE";

			$this->db->trans_start();

				$recordUpdate = array(
					'employeeNumber' => $employeeNumber,
				);
			
				$this->_updateRecords($tableName = 'triune_section_elementary', 
				$fieldName = array('ID'), 
				$where = array($ID), $recordUpdate);


				$actionName1 = "Update Elementary Section";
				$for1 = $employeeNumber . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $employeeNumber;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_section_elementary-update-" . $this->_getCurrentDate();
			$text1 = "UPDATE triune_section_elementary ";
			$text1 = $text1 .  "SET employeeNumber = '" .  $employeeNumber . "', ";
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
			
		}	
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);
		

	}


    public function getSectionJuniorHighEGIS() {
		$selectFields = "triune_section_junior_high.ID, triune_section_junior_high.sectionCode, triune_section_junior_high.subjectCode, ";
		$selectFields = $selectFields . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName, ';' , triune_employee_data.employeeNumber) as fullName, ";
		$selectFields = $selectFields . "triune_subject_junior_high.subjectDescription, triune_employee_data.employeeNumber";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_junior_high', 'triune_employee_data', 'triune_subject_junior_high'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = array('triune_section_junior_high.employeeNumber = triune_employee_data.employeeNumber', 'triune_section_junior_high.subjectCode = triune_subject_junior_high.subjectCode'), $joinType = array('left', 'left'), 
			$sortBy = array('sectionCode', 'subjectDescription', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	

	public function updateSectionJuniorHighEGIS() {
		$fullName = $_POST["fullName"];
		if(!empty($fullName)) {
			$ID = $_POST["ID"];
			$userName = $this->_getUserName(1);

			$fN = explode(";", $fullName);
			$employeeNumber = $fN[1];

		
			$systemForAuditName = "EGIS";
			$moduleName = "JUNIORHIGHSECTIONUPDATE";

			$this->db->trans_start();

				$recordUpdate = array(
					'employeeNumber' => $employeeNumber,
				);
			
				$this->_updateRecords($tableName = 'triune_section_junior_high', 
				$fieldName = array('ID'), 
				$where = array($ID), $recordUpdate);


				$actionName1 = "Update Junior High Section";
				$for1 = $employeeNumber . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $employeeNumber;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_section_junior_high-update-" . $this->_getCurrentDate();
			$text1 = "UPDATE triune_section_junior_high ";
			$text1 = $text1 .  "SET employeeNumber = '" .  $employeeNumber . "', ";
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
		}
		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}	
	
	
    public function getMyElementarySectionsEGIS() {
		$selectFields = "triune_section_elementary.ID, triune_section_elementary.sectionCode, triune_section_elementary.subjectCode, ";
		$selectFields = $selectFields . "triune_subject_elementary.subjectDescription, triune_subject_elementary.departmentCode";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_elementary', 'triune_subject_elementary'), 
			$fieldName = array('sy', 'employeeNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
			$join = array('triune_section_elementary.subjectCode = triune_subject_elementary.subjectCode'), $joinType = array('inner'), 
			$sortBy = array('subjectDescription'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	
	



    public function getMySectionScoreSheet1EGIS() {
		$sectionCode = $_GET["sectionCode"];
		$subjectCode = $_GET["subjectCode"];

		//$sectionCode = '1001 5-HUMILITY';
		//$subjectCode = 'HELED5E';
		$gradingPeriod = $_SESSION['gP'];
		$results1 = null;
		
		if($gradingPeriod == 1) {	
			$selectFields = "triune_grades_score_sheet_1.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($data = array($selectFields), 
				$tables = array('triune_grades_score_sheet_1', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = array('triune_grades_score_sheet_1.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 2) {
			
			$selectFields = "triune_grades_score_sheet_2.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($data = array($selectFields), 
				$tables = array('triune_grades_score_sheet_2', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = array('triune_grades_score_sheet_2.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 3) {
			
			$selectFields = "triune_grades_score_sheet_3.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($data = array($selectFields), 
				$tables = array('triune_grades_score_sheet_3', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = array('triune_grades_score_sheet_3.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 4) {
			
			$selectFields = "triune_grades_score_sheet_4.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($data = array($selectFields), 
				$tables = array('triune_grades_score_sheet_4', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = array('triune_grades_score_sheet_4.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
			
		} 
			echo json_encode($results1);
    }	



	public function updateScoreSheetFirstGradingEGIS() {
		$row = $_POST["row"];
		$i = $_POST["i"];
		$userName = $this->_getUserName(1);

		$gradingPeriod = $_SESSION['gP'];

		//$systemForAuditName = "EGIS";
		//$moduleName = "FIRSTGRADINGSCORESHEETUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'WW1' => $row['WW1'],
				'WW2' => $row['WW2'],
				'WW3' => $row['WW3'],
				'WW4' => $row['WW4'],
				'WW5' => $row['WW5'],
				'WW6' => $row['WW6'],
				'WW7' => $row['WW7'],
				'WW8' => $row['WW8'],
				'WW9' => $row['WW9'],
				'WW10' => $row['WW10'],
				'WW11' => $row['WW11'],
				'WW12' => $row['WW12'],
				'WW13' => $row['WW13'],
				'WW14' => $row['WW14'],
				'WW15' => $row['WW15'],
				'PT1' => $row['PT1'],
				'PT2' => $row['PT2'],
				'PT3' => $row['PT3'],
				'PT4' => $row['PT4'],
				'PT5' => $row['PT5'],
				'PT6' => $row['PT6'],
				'PT7' => $row['PT7'],
				'PT8' => $row['PT8'],
				'PT9' => $row['PT9'],
				'PT10' => $row['PT10'],
				'QA1' => $row['QA1'],				
				
			);


			if($gradingPeriod == 1) {		
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_1', 
				$fieldName = array('ID'), 
				$where = array($row['ID']), $recordUpdate);
			} elseif($gradingPeriod == 2) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_2', 
				$fieldName = array('ID'), 
				$where = array($row['ID']), $recordUpdate);

			} elseif($gradingPeriod == 3) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_3', 
				$fieldName = array('ID'), 
				$where = array($row['ID']), $recordUpdate);

			} elseif($gradingPeriod == 4) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_4', 
				$fieldName = array('ID'), 
				$where = array($row['ID']), $recordUpdate);

			}

			//$actionName1 = "Update Elementary Section";
			//$for1 = $employeeNumber . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $employeeNumber;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		//$fileName1 = "triune_section_junior_high-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_section_junior_high ";
		//$text1 = $text1 .  "SET employeeNumber = '" .  $employeeNumber . "', ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

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


    public function getMySectionScoreSheet2EGIS() {
		$sectionCode = $_GET["sectionCode"];
		$subjectCode = $_GET["subjectCode"];

		//$sectionCode = '1001 5-HUMILITY';
		//$subjectCode = 'HELED5E';

		$selectFields = "triune_grades_score_sheet_2.*, ";
		$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
		
		$results1 = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_grades_score_sheet_2', 'triune_students_k12'), 
			$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
			$join = array('triune_grades_score_sheet_2.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
			$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results1);
    }	



	public function updateScoreSheetSecondGradingEGIS() {
		$row = $_POST["row"];
		$i = $_POST["i"];
		$userName = $this->_getUserName(1);

	
		//$systemForAuditName = "EGIS";
		//$moduleName = "FIRSTGRADINGSCORESHEETUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'WW1' => $row['WW1'],
				'WW2' => $row['WW2'],
				'WW3' => $row['WW3'],
				'WW4' => $row['WW4'],
				'WW5' => $row['WW5'],
				'WW6' => $row['WW6'],
				'WW7' => $row['WW7'],
				'WW8' => $row['WW8'],
				'WW9' => $row['WW9'],
				'WW10' => $row['WW10'],
				'WW11' => $row['WW11'],
				'WW12' => $row['WW12'],
				'WW13' => $row['WW13'],
				'WW14' => $row['WW14'],
				'WW15' => $row['WW15'],
				'PT1' => $row['PT1'],
				'PT2' => $row['PT2'],
				'PT3' => $row['PT3'],
				'PT4' => $row['PT4'],
				'PT5' => $row['PT5'],
				'PT6' => $row['PT6'],
				'PT7' => $row['PT7'],
				'PT8' => $row['PT8'],
				'PT9' => $row['PT9'],
				'PT10' => $row['PT10'],
				'QA1' => $row['QA1'],				
				
			);


			
			$this->_updateRecords($tableName = 'triune_grades_score_sheet_2', 
			$fieldName = array('ID'), 
			$where = array($row['ID']), $recordUpdate);


			//$actionName1 = "Update Elementary Section";
			//$for1 = $employeeNumber . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $employeeNumber;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		//$fileName1 = "triune_section_junior_high-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_section_junior_high ";
		//$text1 = $text1 .  "SET employeeNumber = '" .  $employeeNumber . "', ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

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

    public function getTransmutationEGIS() {
		
		$results1 = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_transmutation_k12'), 
			$fieldName = null, $where = null, 
			$join = null, $joinType = null, 
			$sortBy = array('transmutedScore'), $sortOrder = array('desc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results1);
    }	


	public function insertTrasmutationEGIS() {
		$lowScore = $_POST["lowScore"];
		$highScore = $_POST["highScore"];
		$transmutedScore = $_POST["transmutedScore"];
			
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_transmutation_k12'), 
		$fieldName = array('transmutedScore'), 
		$where = array($transmutedScore), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$systemForAuditName = "EGIS";
			$moduleName = "TRANSMUTATIONCREATE";
			
			
			$insertData1 = null;
			$insertData1 = array(
				'lowScore' => $lowScore,
				'highScore' => $highScore,
				'transmutedScore' => $transmutedScore,
				'userName' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_transmutation_k12', $insertData1);        			 


				$actionName1 = "Insert Transmutation";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_transmutation_k12-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_transmutation_k12 ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$lowScore . "', ";
			$text1 = $text1 .  "'".$highScore . "', ";
			$text1 = $text1 .  "'".$transmutedScore . "', ";
			$text1 = $text1 .  "'".$userName. "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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


	public function updateTrasmutationEGIS() {
		$lowScore = $_POST["lowScore"];
		$highScore = $_POST["highScore"];
		$transmutedScore = $_POST["transmutedScore"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "EGIS";
		$moduleName = "TRANSMUTATIONUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'lowScore' => $lowScore,
				'highScore' => $highScore,
				'transmutedScore' => $transmutedScore,
			);
		
			$this->_updateRecords($tableName = 'triune_transmutation_k12', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Transmutation";
			$for1 = $transmutedScore . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $lowScore . ';' . $highScore . ';' . $transmutedScore;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_transmutation_k12-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_transmutation_k12 ";
		$text1 = $text1 .  "SET lowScore = '" .  $lowScore . "', ";
		$text1 = $text1 .  "highScore = '" .  $highScore . "', ";
		$text1 = $text1 .  "transmutedScore = '" .  $transmutedScore . "' ";
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
	

    public function getAssignedAdvisersEGIS() {
		$selectFields = "triune_section_adviser_k12.sectionCode, triune_course_info_k12.courseDescription, triune_section_adviser_k12.ID, ";
		$selectFields = $selectFields . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName, ';' , triune_employee_data.employeeNumber) as fullName, ";
		$selectFields = $selectFields . "triune_section_adviser_k12.yearLevel, triune_employee_data.employeeNumber";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_adviser_k12', 'triune_course_info_k12', 'triune_employee_data'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = array('triune_section_adviser_k12.courseCode = triune_course_info_k12.courseCode', 'triune_section_adviser_k12.employeeNumber = triune_employee_data.employeeNumber'), 
			$joinType = array('left', 'left'), 
			$sortBy = array('courseDescription', 'yearLevel'), $sortOrder = array('asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	

	public function updateAdviserAssignmentEGIS() {
		$fullName = $_POST["fullName"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

		$fN = explode(";", $fullName);
		$employeeNumber = $fN[1];
	
		$systemForAuditName = "EGIS";
		$moduleName = "SECTIONADVISERUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'employeeNumber' => $employeeNumber,
			);
		
			$this->_updateRecords($tableName = 'triune_section_adviser_k12', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Section Adviser";
			$for1 = $employeeNumber . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $employeeNumber;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_section_adviser_k12-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_section_adviser_k12 ";
		$text1 = $text1 .  "SET employeeNumber = '" .  $employeeNumber . "', ";
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
	

    public function getGradeComponentEGIS() {
		
		$results = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_grading_components'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = null, $joinType =null, 
			$sortBy = array('levelCode', 'departmentCode', 'gradingComponentCode'), $sortOrder = array('asc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	

	
	public function insertGradeComponentEGIS() {
		$levelCode = $_POST["levelCode"];
		$departmentCode = $_POST["departmentCode"];
		$gradingComponentCode = $_POST["gradingComponentCode"];
		$componentPercentage = $_POST["componentPercentage"];
			
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_grading_components'), 
		$fieldName = array('sy', 'levelCode', 'departmentCode', 'gradingComponentCode'), 
		$where = array($_SESSION['sy'], $levelCode, $departmentCode, $gradingComponentCode), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$systemForAuditName = "EGIS";
			$moduleName = "GRADECOMPONENTCREATE";
			
			
			$insertData1 = null;
			$insertData1 = array(
				'sy' => $_SESSION['sy'],
				'levelCode' => $levelCode,
				'departmentCode' => $departmentCode,
				'gradingComponentCode' => $gradingComponentCode,
				'componentPercentage' => $componentPercentage,
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grading_components', $insertData1);        			 


				$actionName1 = "Insert Grading Component";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_grading_components-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_grading_components ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
			$text1 = $text1 .  "'".$levelCode . "', ";
			$text1 = $text1 .  "'".$departmentCode . "', ";
			$text1 = $text1 .  "'".$gradingComponentCode . "', ";
			$text1 = $text1 .  "'".$componentPercentage . "', ";
			$text1 = $text1 .  "'".$userName. "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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
	
	public function deleteGradeComponentEGIS() {
		$ID = $_POST["ID"];
			
		$userName = $this->_getUserName(1);

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_grading_components'), 
		$fieldName = array('ID'), 
		$where = array($ID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		
		$systemForAuditName = "EGIS";
		$moduleName = "GRADECOMPONENTDELETE";
		

		

		$this->db->trans_start();
			//CONDITION AND ACTION FOR DELETION
			$where = array($ID);
			$fieldName = array('ID');
			$this->_deleteRecords('triune_grading_components', $fieldName, $where);


			$actionName1 = "Delete Grade Component";
			$for1 = $ID . ";" . $userName;
			$oldValue1 = $record;
			$newValue1 =  null;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_grading_components-delete" . $this->_getCurrentDate();
		$text1 = "INSERT INTO triune_grading_components ";
		$text1 = $text1 .  "VALUES (" .  $ID . ", ";
		$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
		$text1 = $text1 .  "'".$record[0]->levelCode . "', ";
		$text1 = $text1 .  "'".$record[0]->departmentCode . "', ";
		$text1 = $text1 .  "'".$record[0]->gradingComponentCode . "', ";
		$text1 = $text1 .  "".$record[0]->componentPercentage . ", ";
		$text1 = $text1 .  "'".$userName. "', ";
		$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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


	public function updateGradingComponentEGIS() {
		$levelCode = $_POST["levelCode"];
		$departmentCode = $_POST["departmentCode"];
		$gradingComponentCode = $_POST["gradingComponentCode"];
		$componentPercentage = $_POST["componentPercentage"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "EGIS";
		$moduleName = "GRADINGCOMPONENTUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'levelCode' => $levelCode,
				'departmentCode' => $departmentCode,
				'gradingComponentCode' => $gradingComponentCode,
				'componentPercentage' => $componentPercentage,
			);
		
			$this->_updateRecords($tableName = 'triune_grading_components', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Grading Component";
			$for1 = $recordUpdate . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $levelCode . ';' . $departmentCode . ';' . $gradingComponentCode . ';' . $componentPercentage;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_grading_components-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_grading_components ";
		$text1 = $text1 .  "SET levelCode = '" .  $levelCode . "', ";
		$text1 = $text1 .  "departmentCode = '" .  $departmentCode . "', ";
		$text1 = $text1 .  "gradingComponentCode = '" .  $gradingComponentCode . "' ";
		$text1 = $text1 .  "componentPercentage = '" .  $componentPercentage . "' ";
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
	

    public function getSubjectElementaryEGIS() {
		
		$results = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_subject_elementary'), 
			$fieldName = null, $where = null, 
			$join = null, $joinType = null, 
			$sortBy = array('subjectDescription'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	


	public function updateSubjectDepartmentEGIS() {
		$row = $_POST["row"];
		$i = $_POST["i"];
		$userName = $this->_getUserName(1);

	
		//$systemForAuditName = "EGIS";
		//$moduleName = "FIRSTGRADINGSCORESHEETUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'departmentCode' => $row['departmentCode'],
			);

			$this->_updateRecords($tableName = 'triune_subject_elementary', 
			$fieldName = array('ID'), 
			$where = array($row['ID']), $recordUpdate);

			//$actionName1 = "Update Elementary Section";
			//$for1 = $employeeNumber . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $employeeNumber;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		//$fileName1 = "triune_section_junior_high-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_section_junior_high ";
		//$text1 = $text1 .  "SET employeeNumber = '" .  $employeeNumber . "', ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

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



    public function getSubjectJuniorHighEGIS() {
		
		$results = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_subject_junior_high'), 
			$fieldName = null, $where = null, 
			$join = null, $joinType = null, 
			$sortBy = array('subjectDescription'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	

	
	public function updateSubjectDepartmentJHEGIS() {
		$row = $_POST["row"];
		$i = $_POST["i"];
		$userName = $this->_getUserName(1);

	
		//$systemForAuditName = "EGIS";
		//$moduleName = "FIRSTGRADINGSCORESHEETUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'departmentCode' => $row['departmentCode'],
			);

			$this->_updateRecords($tableName = 'triune_subject_junior_high', 
			$fieldName = array('ID'), 
			$where = array($row['ID']), $recordUpdate);

			//$actionName1 = "Update Elementary Section";
			//$for1 = $employeeNumber . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $employeeNumber;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		//$fileName1 = "triune_section_junior_high-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_section_junior_high ";
		//$text1 = $text1 .  "SET employeeNumber = '" .  $employeeNumber . "', ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

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
	
    public function getGradeDescriptorEGIS() {
		
		$results1 = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_grading_descriptor'), 
			$fieldName = null, $where = null, 
			$join = null, $joinType = null, 
			$sortBy = array('higherScale'), $sortOrder = array('desc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results1);
    }	

	public function insertGradeDescriptorEGIS() {
		$lowerScale = $_POST["lowerScale"];
		$higherScale = $_POST["higherScale"];
		$descriptor = $_POST["descriptor"];
		$remarks = $_POST["remarks"];
			
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_grading_descriptor'), 
		$fieldName = array('lowerScale', 'higherScale'), 
		$where = array($lowerScale, $higherScale), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$systemForAuditName = "EGIS";
			$moduleName = "GRADEDESCRIPTORCREATE";
			
			
			$insertData1 = null;
			$insertData1 = array(
				'lowerScale' => $lowerScale,
				'higherScale' => $higherScale,
				'descriptor' => $descriptor,
				'remarks' => $remarks,
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grading_descriptor', $insertData1);        			 


				$actionName1 = "Insert Grade Descriptor";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_grading_descriptor-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_grading_descriptor ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$lowerScale . "', ";
			$text1 = $text1 .  "'".$higherScale . "', ";
			$text1 = $text1 .  "'".$descriptor . "', ";
			$text1 = $text1 .  "'".$remarks . "', ";
			$text1 = $text1 .  "'".$userName. "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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
	

	public function updateGradeDescriptorEGIS() {
		$lowerScale = $_POST["lowerScale"];
		$higherScale = $_POST["higherScale"];
		$descriptor = $_POST["descriptor"];
		$remarks = $_POST["remarks"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "EGIS";
		$moduleName = "GRADEDESCRIPTORUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'lowerScale' => $lowerScale,
				'higherScale' => $higherScale,
				'descriptor' => $descriptor,
				'remarks' => $remarks,
			);
		
			$this->_updateRecords($tableName = 'triune_grading_descriptor', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Grade Descriptor";
			$for1 = $ID . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $recordUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_grading_descriptor-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_grading_descriptor ";
		$text1 = $text1 .  "SET lowerScale = '" .  $lowerScale . "', ";
		$text1 = $text1 .  "higherScale = '" .  $higherScale . "', ";
		$text1 = $text1 .  "descriptor = '" .  $descriptor . "', ";
		$text1 = $text1 .  "remarks = '" .  $remarks . "' ";
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

	
	public function deleteTrasmutationEGIS() {
		$ID = $_POST["ID"];
			
		$userName = $this->_getUserName(1);

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_transmutation_k12'), 
		$fieldName = array('ID'), 
		$where = array($ID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		
		$systemForAuditName = "EGIS";
		$moduleName = "TRANSMUTATIONDELETE";
		

		

		$this->db->trans_start();
			//CONDITION AND ACTION FOR DELETION
			$where = array($ID);
			$fieldName = array('ID');
			$this->_deleteRecords('triune_transmutation_k12', $fieldName, $where);


			$actionName1 = "Delete Transmutation";
			$for1 = $ID . ";" . $userName;
			$oldValue1 = $record;
			$newValue1 =  null;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_transmutation_k12-delete" . $this->_getCurrentDate();
		$text1 = "INSERT INTO triune_transmutation_k12 ";
		$text1 = $text1 .  "VALUES (" .  $ID . ", ";
		$text1 = $text1 .  "'".$record[0]->lowScore . "', ";
		$text1 = $text1 .  "'".$record[0]->highScore . "', ";
		$text1 = $text1 .  "'".$record[0]->transmutedScore . "', ";
		$text1 = $text1 .  "'".$userName. "', ";
		$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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
	
	
	
	public function deleteGradeDescriptorEGIS() {
		$ID = $_POST["ID"];
			
		$userName = $this->_getUserName(1);

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_grading_descriptor'), 
		$fieldName = array('ID'), 
		$where = array($ID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		
		$systemForAuditName = "EGIS";
		$moduleName = "GRADEDESCRIPTORDELETE";
		

		

		$this->db->trans_start();
			//CONDITION AND ACTION FOR DELETION
			$where = array($ID);
			$fieldName = array('ID');
			$this->_deleteRecords('triune_grading_descriptor', $fieldName, $where);


			$actionName1 = "Delete Grade Descriptor";
			$for1 = $ID . ";" . $userName;
			$oldValue1 = $record;
			$newValue1 =  null;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_grading_descriptor-delete" . $this->_getCurrentDate();
		$text1 = "INSERT INTO triune_grading_descriptor ";
		$text1 = $text1 .  "VALUES (" .  $ID . ", ";
		$text1 = $text1 .  "'".$record[0]->lowerScale . "', ";
		$text1 = $text1 .  "'".$record[0]->higherScale . "', ";
		$text1 = $text1 .  "'".$record[0]->descriptor . "', ";
		$text1 = $text1 .  "'".$record[0]->remarks . "', ";
		$text1 = $text1 .  "'".$userName. "', ";
		$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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


	
	
    public function getSectionSeniorHighSemAEGIS() {
		$selectFields = "triune_section_senior_high.ID, triune_section_senior_high.sectionCode, triune_section_senior_high.subjectCode, ";
		$selectFields = $selectFields . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName, ';' , triune_employee_data.employeeNumber) as fullName, ";
		$selectFields = $selectFields . "triune_subject_senior_high.subjectDescription, triune_employee_data.employeeNumber";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_senior_high', 'triune_employee_data', 'triune_subject_senior_high'), 
			$fieldName = array('sy', 'triune_subject_senior_high.sem'), $where = array($_SESSION['sy'], 'A'), 
			$join = array('triune_section_senior_high.employeeNumber = triune_employee_data.employeeNumber', 'triune_section_senior_high.subjectCode = triune_subject_senior_high.subjectCode'), $joinType = array('left', 'left'), 
			$sortBy = array('sectionCode', 'subjectDescription', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	
	
	

    public function getSectionSeniorHighSemBEGIS() {
		$selectFields = "triune_section_senior_high.ID, triune_section_senior_high.sectionCode, triune_section_senior_high.subjectCode, ";
		$selectFields = $selectFields . "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName, ';' , triune_employee_data.employeeNumber) as fullName, ";
		$selectFields = $selectFields . "triune_subject_senior_high.subjectDescription, triune_employee_data.employeeNumber";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_senior_high', 'triune_employee_data', 'triune_subject_senior_high'), 
			$fieldName = array('sy', 'triune_subject_senior_high.sem'), $where = array($_SESSION['sy'], 'B'), 
			$join = array('triune_section_senior_high.employeeNumber = triune_employee_data.employeeNumber', 'triune_section_senior_high.subjectCode = triune_subject_senior_high.subjectCode'), $joinType = array('left', 'left'), 
			$sortBy = array('sectionCode', 'subjectDescription', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	
	


	public function updateSectionSeniorHighEGIS() {
		$fullName = $_POST["fullName"];
		if(!empty($fullName)) {
			$ID = $_POST["ID"];
			$userName = $this->_getUserName(1);

			$fN = explode(";", $fullName);
			$employeeNumber = $fN[1];

		
			$systemForAuditName = "EGIS";
			$moduleName = "SENIORHIGHSECTIONUPDATE";

			$this->db->trans_start();

				$recordUpdate = array(
					'employeeNumber' => $employeeNumber,
				);
			
				$this->_updateRecords($tableName = 'triune_section_senior_high', 
				$fieldName = array('ID'), 
				$where = array($ID), $recordUpdate);


				$actionName1 = "Update Senior High Section";
				$for1 = $employeeNumber . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $employeeNumber;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_section_senior_high-update-" . $this->_getCurrentDate();
			$text1 = "UPDATE triune_section_senior_high ";
			$text1 = $text1 .  "SET employeeNumber = '" .  $employeeNumber . "', ";
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
		
		}
		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}	


    public function getGradeComponentSHEGIS() {
		
		$results = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_grading_components_sh'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = null, $joinType =null, 
			$sortBy = array('subjectComponentCode', 'gradingComponentCode'), $sortOrder = array('asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	


	public function insertGradeComponentSHEGIS() {
		$levelCode = 'Z';
		$subjectComponentCode = $_POST["subjectComponentCode"];
		$gradingComponentCode = $_POST["gradingComponentCode"];
		$componentPercentage = $_POST["componentPercentage"];
			
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_grading_components_sh'), 
		$fieldName = array('sy', 'levelCode', 'subjectComponentCode', 'gradingComponentCode'), 
		$where = array($_SESSION['sy'], $levelCode, $subjectComponentCode, $gradingComponentCode), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$systemForAuditName = "EGIS";
			$moduleName = "WEIGHTCOMPONENTCREATE";
			
			
			$insertData1 = null;
			$insertData1 = array(
				'sy' => $_SESSION['sy'],
				'levelCode' => $levelCode,
				'subjectComponentCode' => $subjectComponentCode,
				'gradingComponentCode' => $gradingComponentCode,
				'componentPercentage' => $componentPercentage,
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grading_components_sh', $insertData1);        			 


				$actionName1 = "Insert Weight Component";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_grading_components_sh-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_grading_components_sh ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
			$text1 = $text1 .  "'".$levelCode . "', ";
			$text1 = $text1 .  "'".$subjectComponentCode . "', ";
			$text1 = $text1 .  "'".$gradingComponentCode . "', ";
			$text1 = $text1 .  "'".$componentPercentage . "', ";
			$text1 = $text1 .  "'".$userName. "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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


	
	public function deleteGradeComponentSHEGIS() {
		$ID = $_POST["ID"];
			
		$userName = $this->_getUserName(1);

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_grading_components_sh'), 
		$fieldName = array('ID'), 
		$where = array($ID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		
		$systemForAuditName = "EGIS";
		$moduleName = "GRADECOMPONENTSHDELETE";
		

		

		$this->db->trans_start();
			//CONDITION AND ACTION FOR DELETION
			$where = array($ID);
			$fieldName = array('ID');
			$this->_deleteRecords('triune_grading_components_sh', $fieldName, $where);


			$actionName1 = "Delete Grade Component SH";
			$for1 = $ID . ";" . $userName;
			$oldValue1 = $record;
			$newValue1 =  null;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_grading_components_sh-delete" . $this->_getCurrentDate();
		$text1 = "INSERT INTO triune_grading_components_sh ";
		$text1 = $text1 .  "VALUES (" .  $ID . ", ";
		$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
		$text1 = $text1 .  "'".$record[0]->levelCode . "', ";
		$text1 = $text1 .  "'".$record[0]->subjectComponentCode . "', ";
		$text1 = $text1 .  "'".$record[0]->gradingComponentCode . "', ";
		$text1 = $text1 .  "".$record[0]->componentPercentage . ", ";
		$text1 = $text1 .  "'".$userName. "', ";
		$text1 = $text1 .  "'".$this->_getTimeStamp(). "'";
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
	
	

	
	public function updateGradingComponentSHEGIS() {
		$subjectComponentCode = $_POST["subjectComponentCode"];
		$gradingComponentCode = $_POST["gradingComponentCode"];
		$componentPercentage = $_POST["componentPercentage"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "EGIS";
		$moduleName = "GRADINGCOMPONENTSHUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'subjectComponentCode' => $subjectComponentCode,
				'gradingComponentCode' => $gradingComponentCode,
				'componentPercentage' => $componentPercentage,
			);
		
			$this->_updateRecords($tableName = 'triune_grading_components_sh', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Grading SH Component";
			$for1 = $recordUpdate . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $subjectComponentCode . ';' . $gradingComponentCode . ';' . $componentPercentage;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_grading_components-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_grading_components ";
		$text1 = $text1 .  "SET subjectComponentCode = '" .  $subjectComponentCode . "', ";
		$text1 = $text1 .  "gradingComponentCode = '" .  $gradingComponentCode . "' ";
		$text1 = $text1 .  "componentPercentage = '" .  $componentPercentage . "' ";
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
	
	
    public function getSubjectSeniorHighEGIS() {
		
		$results = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_subject_senior_high'), 
			$fieldName = null, $where = null, 
			$join = null, $joinType = null, 
			$sortBy = array('sem', 'yearLevel', 'courseCode', 'subjectDescription'), $sortOrder = array('asc', 'asc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	
	

	public function updateSubjectComponentSHEGIS() {
		$row = $_POST["row"];
		$i = $_POST["i"];
		$userName = $this->_getUserName(1);

	
		//$systemForAuditName = "EGIS";
		//$moduleName = "FIRSTGRADINGSCORESHEETUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'subjectComponentCode' => $row['subjectComponentCode'],
			);

			$this->_updateRecords($tableName = 'triune_subject_senior_high', 
			$fieldName = array('ID'), 
			$where = array($row['ID']), $recordUpdate);

			//$actionName1 = "Update Elementary Section";
			//$for1 = $employeeNumber . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $employeeNumber;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		//$fileName1 = "triune_section_junior_high-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_section_junior_high ";
		//$text1 = $text1 .  "SET employeeNumber = '" .  $employeeNumber . "', ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

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


    public function getMyJuniorHighSectionsEGIS() {
		$selectFields = "triune_section_junior_high.ID, triune_section_junior_high.sectionCode, triune_section_junior_high.subjectCode, ";
		$selectFields = $selectFields . "triune_subject_junior_high.subjectDescription, triune_subject_junior_high.departmentCode";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_junior_high', 'triune_subject_junior_high'), 
			$fieldName = array('sy', 'employeeNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
			$join = array('triune_section_junior_high.subjectCode = triune_subject_junior_high.subjectCode'), $joinType = array('inner'), 
			$sortBy = array('subjectDescription'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	

    public function getMySeniorHighSectionsEGIS() {
		$selectFields = "triune_section_senior_high.ID, triune_section_senior_high.sectionCode, triune_section_senior_high.subjectCode, ";
		$selectFields = $selectFields . "triune_subject_senior_high.subjectDescription, triune_subject_senior_high.subjectComponentCode";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_senior_high', 'triune_subject_senior_high'), 
			$fieldName = array('sy', 'employeeNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
			$join = array('triune_section_senior_high.subjectCode = triune_subject_senior_high.subjectCode'), $joinType = array('inner'), 
			$sortBy = array('subjectDescription'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }	

	
    public function getMySectionScoreSheet1EGISExcel() {
		$sectionCode = $_GET["sectionCode"];
		$subjectCode = $_GET["subjectCode"];
		$subjectDescription = $_GET["subjectDescription"];

		//$sectionCode = '1001 5-HUMILITY';
		//$subjectCode = 'HELED5E';

		$results1 = null;
		$results2 = null;
		$gradingPeriod = $_SESSION['gP'];
		
		if($gradingPeriod == 1) {
			$selectFields = "triune_grades_score_sheet_1.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_1', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = array('triune_grades_score_sheet_1.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			$selectFields2 = "triune_grades_score_sheet_1_title.*";
			
			$results2 = $this->_getRecordsData($dataSelect = array($selectFields2), 
				$tables = array('triune_grades_score_sheet_1_title'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, 
				$sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 2) {
			$selectFields = "triune_grades_score_sheet_2.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_2', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = array('triune_grades_score_sheet_2.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			$selectFields2 = "triune_grades_score_sheet_2_title.*";
			
			$results2 = $this->_getRecordsData($dataSelect = array($selectFields2), 
				$tables = array('triune_grades_score_sheet_2_title'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, 
				$sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 3) {
			$selectFields = "triune_grades_score_sheet_3.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_3', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = array('triune_grades_score_sheet_3.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			$selectFields2 = "triune_grades_score_sheet_3_title.*";
			
			$results2 = $this->_getRecordsData($dataSelect = array($selectFields2), 
				$tables = array('triune_grades_score_sheet_3_title'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, 
				$sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 4) {
			$selectFields = "triune_grades_score_sheet_4.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_4', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = array('triune_grades_score_sheet_4.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			$selectFields2 = "triune_grades_score_sheet_4_title.*";
			
			$results2 = $this->_getRecordsData($dataSelect = array($selectFields2), 
				$tables = array('triune_grades_score_sheet_4_title'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, 
				$sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		}		
		
		
		$data['details'] =	$results1;
		$data['titles'] =	$results2;
		$data['subjectDescription'] =	$subjectDescription;
		$data['subjectCode'] =	$subjectCode;
		$data['sectionCode'] =	$sectionCode;
		
		echo json_encode($data);
    }	
	


	public function updateScoreSheet1EGISExcel() {
		$sectionCode = $_POST["sectionCode"];
		$subjectCode = $_POST["subjectCode"];
		$studentNumber = $_POST["studentNumber"];
		$fieldName = $_POST["fieldName"];
		$value = $_POST["value"];

		$userName = $this->_getUserName(1);
		$gradingPeriod = $_SESSION['gP'];
	
		//$systemForAuditName = "EGIS";
		//$moduleName = "TRANSMUTATIONUPDATE";

		//$this->db->trans_start();

			$recordUpdate = array(
				$fieldName => $value,
			);

			if($gradingPeriod == 1) {		
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_1', 
				$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber' ), 
				$where = array($_SESSION['sy'], $sectionCode, $subjectCode, $studentNumber), $recordUpdate);
			} elseif($gradingPeriod == 2) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_2', 
				$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber' ), 
				$where = array($_SESSION['sy'], $sectionCode, $subjectCode, $studentNumber), $recordUpdate);
			} elseif($gradingPeriod == 3) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_3', 
				$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber' ), 
				$where = array($_SESSION['sy'], $sectionCode, $subjectCode, $studentNumber), $recordUpdate);
			} elseif($gradingPeriod == 4) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_4', 
				$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber' ), 
				$where = array($_SESSION['sy'], $sectionCode, $subjectCode, $studentNumber), $recordUpdate);
			}

			//$actionName1 = "Update Transmutation";
			//$for1 = $transmutedScore . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $lowScore . ';' . $highScore . ';' . $transmutedScore;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		//$this->db->trans_complete();
	
		//$fileName1 = "triune_transmutation_k12-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_transmutation_k12 ";
		//$text1 = $text1 .  "SET lowScore = '" .  $lowScore . "', ";
		//$text1 = $text1 .  "highScore = '" .  $highScore . "', ";
		//$text1 = $text1 .  "transmutedScore = '" .  $transmutedScore . "' ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		//if($this->db->trans_status() === FALSE) {
		//	$this->_transactionFailed();
		//	return FALSE;  
		//} 

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


    public function getMySectionScoreSheet1TitleEGISExcel() {
		$sectionCode = $_GET["sectionCode"];
		$subjectCode = $_GET["subjectCode"];
		$subjectDescription = $_GET["subjectDescription"];

		//$sectionCode = '1001 5-HUMILITY';
		//$subjectCode = 'HELED5E';

		$gradingPeriod = $_SESSION['gP'];

		if($gradingPeriod == '1') {	
			$selectFields2 = "triune_grades_score_sheet_1_title.*";
			
			$results2 = $this->_getRecordsData($dataSelect = array($selectFields2), 
				$tables = array('triune_grades_score_sheet_1_title'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, 
				$sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );			
		} elseif($gradingPeriod == '2') {
			$selectFields2 = "triune_grades_score_sheet_2_title.*";
			
			$results2 = $this->_getRecordsData($dataSelect = array($selectFields2), 
				$tables = array('triune_grades_score_sheet_2_title'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, 
				$sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );			
		} elseif($gradingPeriod == '3') {
			$selectFields2 = "triune_grades_score_sheet_3_title.*";
			
			$results2 = $this->_getRecordsData($dataSelect = array($selectFields2), 
				$tables = array('triune_grades_score_sheet_3_title'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, 
				$sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );			
		} elseif($gradingPeriod == '4') {
			$selectFields2 = "triune_grades_score_sheet_4_title.*";
			
			$results2 = $this->_getRecordsData($dataSelect = array($selectFields2), 
				$tables = array('triune_grades_score_sheet_4_title'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, 
				$sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );			
		}
			
			
		$data['titles'] =	$results2;
		$data['subjectDescription'] =	$subjectDescription;
		$data['subjectCode'] =	$subjectCode;
		$data['sectionCode'] =	$sectionCode;
		
		echo json_encode($data);
    }	


	public function updateScoreSheet1TitleEGISExcel() {
		$sectionCode = $_POST["sectionCode"];
		$subjectCode = $_POST["subjectCode"];
		$fieldName = $_POST["fieldName"];
		$value = $_POST["value"];

		$userName = $this->_getUserName(1);

	
		//$systemForAuditName = "EGIS";
		//$moduleName = "TRANSMUTATIONUPDATE";

		//$this->db->trans_start();

			$recordUpdate = array(
				$fieldName => $value,
			);

			$gradingPeriod = $_SESSION['gP'];
			
			if($gradingPeriod == 1) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_1_title', 
				$fieldName = array('sy', 'sectionCode', 'subjectCode'), 
				$where = array($_SESSION['sy'], $sectionCode, $subjectCode), $recordUpdate);
			} elseif($gradingPeriod == 2) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_2_title', 
				$fieldName = array('sy', 'sectionCode', 'subjectCode'), 
				$where = array($_SESSION['sy'], $sectionCode, $subjectCode), $recordUpdate);
			} elseif($gradingPeriod == 3) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_3_title', 
				$fieldName = array('sy', 'sectionCode', 'subjectCode'), 
				$where = array($_SESSION['sy'], $sectionCode, $subjectCode), $recordUpdate);
			} elseif($gradingPeriod == 4) {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_4_title', 
				$fieldName = array('sy', 'sectionCode', 'subjectCode'), 
				$where = array($_SESSION['sy'], $sectionCode, $subjectCode), $recordUpdate);
			}

			//$actionName1 = "Update Transmutation";
			//$for1 = $transmutedScore . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $lowScore . ';' . $highScore . ';' . $transmutedScore;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		//$this->db->trans_complete();
	
		//$fileName1 = "triune_transmutation_k12-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_transmutation_k12 ";
		//$text1 = $text1 .  "SET lowScore = '" .  $lowScore . "', ";
		//$text1 = $text1 .  "highScore = '" .  $highScore . "', ";
		//$text1 = $text1 .  "transmutedScore = '" .  $transmutedScore . "' ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		//if($this->db->trans_status() === FALSE) {
		//	$this->_transactionFailed();
		//	return FALSE;  
		//} 

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
	

    public function getAttendanceSectionEGIS() {

		$selectFields = "triune_section_adviser_k12.*";
		
		$results = $this->_getRecordsData($dataSelect = array($selectFields), 
			$tables = array('triune_section_adviser_k12'), 
			$fieldName = array('sy', 'employeeNumber' ), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );			

		$data =	$results;
		
		echo json_encode($data);
    }	

    public function getSchoolDaysEGISExcel() {

		$selectFields = "triune_grades_school_days.*";
		
		$results = $this->_getRecordsData($dataSelect = array($selectFields), 
			$tables = array('triune_grades_school_days'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );			

		$data =	$results;
		
		echo json_encode($data);
    }	
	
	

	public function updateSchoolDaysEGISExcel() {
		$fieldName = $_POST["fieldName"];
		$value = $_POST["value"];

		$userName = $this->_getUserName(1);

	
		//$systemForAuditName = "EGIS";
		//$moduleName = "TRANSMUTATIONUPDATE";

		//$this->db->trans_start();

			$recordUpdate = array(
				$fieldName => $value,
			);
		
			$this->_updateRecords($tableName = 'triune_grades_school_days', 
			$fieldName = array('sy'), 
			$where = array($_SESSION['sy']), $recordUpdate);


			//$actionName1 = "Update Transmutation";
			//$for1 = $transmutedScore . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $lowScore . ';' . $highScore . ';' . $transmutedScore;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		//$this->db->trans_complete();
	
		//$fileName1 = "triune_transmutation_k12-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_transmutation_k12 ";
		//$text1 = $text1 .  "SET lowScore = '" .  $lowScore . "', ";
		//$text1 = $text1 .  "highScore = '" .  $highScore . "', ";
		//$text1 = $text1 .  "transmutedScore = '" .  $transmutedScore . "' ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		//if($this->db->trans_status() === FALSE) {
		//	$this->_transactionFailed();
		//	return FALSE;  
		//} 

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
	
	
    public function getMyAdviseeScoreSheet1AttendanceEGISExcel() {
		$sectionCode = $_GET["sectionCode"];

		$selectFields = "triune_grades_score_sheet_1_attendance.*, ";
		$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
		
		$results1 = $this->_getRecordsData($dataSelect = array($selectFields), 
			$tables = array('triune_grades_score_sheet_1_attendance', 'triune_students_k12'), 
			$fieldName = array('sy', 'sectionCode' ), $where = array($_SESSION['sy'], $sectionCode), 
			$join = array('triune_grades_score_sheet_1_attendance.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
			$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

		$data['attendance'] =	$results1;
		
		echo json_encode($data);
    }	
	

	public function updateScoreSheet1AttendanceEGISExcel() {
		$sectionCode = $_POST["sectionCode"];
		$studentNumber = $_POST["studentNumber"];
		$fieldName = $_POST["fieldName"];
		$value = $_POST["value"];

		$userName = $this->_getUserName(1);
	
		//$systemForAuditName = "EGIS";
		//$moduleName = "TRANSMUTATIONUPDATE";

		//$this->db->trans_start();

			$recordUpdate = array(
				$fieldName => $value,
			);
			
			$this->_updateRecords($tableName = 'triune_grades_score_sheet_1_attendance', 
			$fieldName = array('sy', 'sectionCode',  'studentNumber' ), 
			$where = array($_SESSION['sy'], $sectionCode,  $studentNumber), $recordUpdate);

			//$actionName1 = "Update Transmutation";
			//$for1 = $transmutedScore . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $lowScore . ';' . $highScore . ';' . $transmutedScore;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		//$this->db->trans_complete();
	
		//$fileName1 = "triune_transmutation_k12-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_transmutation_k12 ";
		//$text1 = $text1 .  "SET lowScore = '" .  $lowScore . "', ";
		//$text1 = $text1 .  "highScore = '" .  $highScore . "', ";
		//$text1 = $text1 .  "transmutedScore = '" .  $transmutedScore . "' ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		//if($this->db->trans_status() === FALSE) {
		//	$this->_transactionFailed();
		//	return FALSE;  
		//} 

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


    public function getTraitsSetupEGISExcel() {

		$selectFields = "triune_grades_traits_header.*";
		
		$results = $this->_getRecordsData($dataSelect = array($selectFields), 
			$tables = array('triune_grades_traits_header'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );			

		$data =	$results;
		
		echo json_encode($data);
    }	


    public function getMyAdviseeScoreSheet1TraitsEGISExcel() {
		$sectionCode = $_GET["sectionCode"];

		$gradingPeriod = $_SESSION['gP'];
		$results1 = null;
		
		if($gradingPeriod == 1) {
			$selectFields = "triune_grades_score_sheet_1_traits.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_1_traits', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode' ), $where = array($_SESSION['sy'], $sectionCode), 
				$join = array('triune_grades_score_sheet_1_traits.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 2) {
			$selectFields = "triune_grades_score_sheet_2_traits.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_2_traits', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode' ), $where = array($_SESSION['sy'], $sectionCode), 
				$join = array('triune_grades_score_sheet_2_traits.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 3) {
			$selectFields = "triune_grades_score_sheet_3_traits.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_3_traits', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode' ), $where = array($_SESSION['sy'], $sectionCode), 
				$join = array('triune_grades_score_sheet_3_traits.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 4) {
			$selectFields = "triune_grades_score_sheet_4_traits.*, ";
			$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			
			$results1 = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_4_traits', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode' ), $where = array($_SESSION['sy'], $sectionCode), 
				$join = array('triune_grades_score_sheet_4_traits.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		}
			
			
		$selectFields2 = "triune_grades_traits_header.*";
		
		$results2 = $this->_getRecordsData($dataSelect = array($selectFields2), 
			$tables = array('triune_grades_traits_header'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );			
			
			
			
		$data['traits'] =	$results1;
		$data['traitsHeader'] =	$results2;
		
		echo json_encode($data);
    }	


	public function updateScoreSheet1TraitsEGISExcel() {
		$sectionCode = $_POST["sectionCode"];
		$studentNumber = $_POST["studentNumber"];
		$fieldName = $_POST["fieldName"];
		$value = $_POST["value"];

		$userName = $this->_getUserName(1);
		$gradingPeriod = $_SESSION['gP'];
	
		//$systemForAuditName = "EGIS";
		//$moduleName = "TRANSMUTATIONUPDATE";

		//$this->db->trans_start();

			$recordUpdate = array(
				$fieldName => $value,
			);

		
		if($gradingPeriod == 1) {
			$this->_updateRecords($tableName = 'triune_grades_score_sheet_1_traits', 
			$fieldName = array('sy', 'sectionCode',  'studentNumber' ), 
			$where = array($_SESSION['sy'], $sectionCode,  $studentNumber), $recordUpdate);
		} elseif($gradingPeriod == 2) {
			$this->_updateRecords($tableName = 'triune_grades_score_sheet_2_traits', 
			$fieldName = array('sy', 'sectionCode',  'studentNumber' ), 
			$where = array($_SESSION['sy'], $sectionCode,  $studentNumber), $recordUpdate);
		} elseif($gradingPeriod == 3) {
			$this->_updateRecords($tableName = 'triune_grades_score_sheet_3_traits', 
			$fieldName = array('sy', 'sectionCode',  'studentNumber' ), 
			$where = array($_SESSION['sy'], $sectionCode,  $studentNumber), $recordUpdate);
		} elseif($gradingPeriod == 4) {
			$this->_updateRecords($tableName = 'triune_grades_score_sheet_4_traits', 
			$fieldName = array('sy', 'sectionCode',  'studentNumber' ), 
			$where = array($_SESSION['sy'], $sectionCode,  $studentNumber), $recordUpdate);
		}

			//$actionName1 = "Update Transmutation";
			//$for1 = $transmutedScore . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $lowScore . ';' . $highScore . ';' . $transmutedScore;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		//$this->db->trans_complete();
	
		//$fileName1 = "triune_transmutation_k12-update-" . $this->_getCurrentDate();
		//$text1 = "UPDATE triune_transmutation_k12 ";
		//$text1 = $text1 .  "SET lowScore = '" .  $lowScore . "', ";
		//$text1 = $text1 .  "highScore = '" .  $highScore . "', ";
		//$text1 = $text1 .  "transmutedScore = '" .  $transmutedScore . "' ";
		//$text1 = $text1 .  "WHERE ID = ".$ID;
		//$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		//if($this->db->trans_status() === FALSE) {
		//	$this->_transactionFailed();
		//	return FALSE;  
		//} 

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




    public function postSubjectGradesSummaryEGIS() {

		$sectionCode = $_POST['sectionCode']; 
		$subjectCode = $_POST['subjectCode'];
		$userName = $this->_getUserName(1);

		//$sectionCode = '1002 2-8-INNOVATION'; 
		//$subjectCode = 'FILVIIIH';
		$gradingPeriod = $_SESSION['gP'];
		
		$rC = $this->_getRecordsData($dataSelect = array('*'), 
			$tables = array('triune_subject_elementary'), 
			$fieldName = array('subjectCode'), $where = array($subjectCode), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		if(empty($rC)) {
			$rC = $this->_getRecordsData($dataSelect1 = array('*'), 
				$tables = array('triune_subject_junior_high'), 
				$fieldName = array('subjectCode'), $where = array($subjectCode), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				
				if(empty($rC)) {
					$rC = $this->_getRecordsData($dataSelect2 = array('*'), 
						$tables = array('triune_subject_senior_high'), 
						$fieldName = array('subjectCode'), $where = array($subjectCode), 
						$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				}
				
		}
		

		
		$reportCategory = $rC[0]->reportCategory;
		$scoreList = null;
		if($reportCategory == 1) {
			
			if($gradingPeriod == 1) {
				$selectFields = "triune_grades_score_sheet_1.*";
				$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
					$tables = array('triune_grades_score_sheet_1'), 
					$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
					$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($gradingPeriod == 2) {
				$selectFields = "triune_grades_score_sheet_2.*";
				$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
					$tables = array('triune_grades_score_sheet_2'), 
					$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
					$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($gradingPeriod == 3) {
				$selectFields = "triune_grades_score_sheet_3.*";
				$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
					$tables = array('triune_grades_score_sheet_3'), 
					$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
					$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($gradingPeriod == 4) {
				$selectFields = "triune_grades_score_sheet_4.*";
				$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
					$tables = array('triune_grades_score_sheet_4'), 
					$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
					$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			}
			
				$wwColumnCtr = 0;
				$ptColumnCtr = 0;			
				$qaColumnCtr = 0;			
				
				//var_dump($scoreList);
				$maxScoreCounter = (array) $scoreList[0];
				
				//var_dump($maxScoreCounter);
				$maxScoreCount = count($maxScoreCounter); 
				$maxScoreRow = $maxScoreCounter;
				
				for($w = 1; $w < 16; $w++) {
					if($maxScoreCounter['WW'.$w] > 0) {
						$wwColumnCtr++;
					}				
				}
				
				for($p = 1; $p < 11; $p++) {
					if($maxScoreCounter['PT'.$p] > 0) {
						$ptColumnCtr++;
					}				
				}

				for($q = 1; $q < 2; $q++) {
					if($maxScoreCounter['QA'.$q] > 0) {
						$qaColumnCtr++;
					}				
				}
				
				//echo $wwColumnCtr . "<br>";
				//echo $ptColumnCtr . "<br>";			
				//echo $qaColumnCtr . "<br>";		
				
			$selectSP = "triune_grading_components.levelCode, triune_grading_components.departmentCode, triune_grading_components.gradingComponentCode, ";
			$selectSP = $selectSP . "triune_grading_components.componentPercentage, triune_grading_components.sy";

			$courseCode = substr($sectionCode, 0, 4);
			$scorePercentage = null;
			
			if($courseCode == '1001') {
				$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
					$tables = array('triune_subject_elementary', 'triune_grading_components'), 
					$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
					$join = array('triune_subject_elementary.departmentCode = triune_grading_components.departmentCode'), $joinType = array('inner'), 
					$sortBy = null, $sortOrder = null, $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($courseCode == '1002') {
				$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
					$tables = array('triune_subject_junior_high', 'triune_grading_components'), 
					$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
					$join = array('triune_subject_junior_high.departmentCode = triune_grading_components.departmentCode'), $joinType = array('inner'), 
					$sortBy = null, $sortOrder = null, $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($courseCode == '1005') {
				
				$selectSP = "triune_grading_components_sh.levelCode, triune_grading_components_sh.subjectComponentCode, triune_grading_components_sh.gradingComponentCode, ";
				$selectSP = $selectSP . "triune_grading_components_sh.componentPercentage, triune_grading_components_sh.sy";
				
				$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
					$tables = array('triune_subject_senior_high', 'triune_grading_components_sh'), 
					$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
					$join = array('triune_subject_senior_high.subjectComponentCode = triune_grading_components_sh.subjectComponentCode'), $joinType = array('inner'), 
					$sortBy = null, $sortOrder = null, $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			}
				
			$wwPct = 0;
			$ptPct = 0;
			$qaPct = 0;

			foreach($scorePercentage as $row) {
				if($row->gradingComponentCode == 'WW') {
					$wwPct = $row->componentPercentage;
				} else if($row->gradingComponentCode == 'PT') {
					$ptPct = $row->componentPercentage;
				} else if($row->gradingComponentCode == 'QA') {
					$qaPct = $row->componentPercentage;
				}
			}
			//echo $wwPct . "<br>";
			//echo $ptPct . "<br>";
			//echo $qaPct . "<br>";


			$transmutation = $this->_getRecordsData($dataSelect = array('*'), 
				$tables = array('triune_transmutation_k12'), 
				$fieldName = null, $where = null, 
				$join = null, $joinType = null, 
				$sortBy = array('transmutedScore'), $sortOrder = array('desc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			//var_dump($transmutation);
				
				
			$maxScoreTotalWW = 0;
			for($ww = 1; $ww <= $wwColumnCtr; $ww++) {
				$iWW = "WW".$ww;
				$maxScoreTotalWW = $maxScoreTotalWW + $maxScoreRow[$iWW];
				//echo $maxScoreRow[$iWW] . "<br>";
			}
			//echo $maxScoreTotalWW;


			$maxScoreTotalPT = 0;
			for($pt = 1; $pt <= $ptColumnCtr; $pt++) {
				$iPT = "PT".$pt;
				$maxScoreTotalPT = $maxScoreTotalPT + $maxScoreRow[$iPT];
				//echo $maxScoreRow[$iPT] . "<br>";
			}
			//echo $maxScoreTotalPT;


			$maxScoreTotalQA = 0;
			for($qa = 1; $qa <= $qaColumnCtr; $qa++) {
				$iQA = "QA".$qa;
				$maxScoreTotalQA = $maxScoreTotalQA + $maxScoreRow[$iQA];
				// echo $maxScoreRow[$iQA] . "<br>";
			}
			//echo $maxScoreTotalQA;


			//CLEAR SUBJECT'S RECORDS
			$where = array($_SESSION['sy'], $subjectCode, $sectionCode);
			$fieldName = array('sy', 'subjectCode', 'sectionCode');
			//CLEAR SUBJECT'S RECORDS
			
			$this->db->trans_start();
			if($gradingComponent == '1') {
				$this->_deleteRecords('triune_grades_score_sheet_1_summary', $fieldName, $where);
			} elseif($gradingComponent == '2') {
				$this->_deleteRecords('triune_grades_score_sheet_2_summary', $fieldName, $where);
			} elseif($gradingComponent == '3') {
				$this->_deleteRecords('triune_grades_score_sheet_3_summary', $fieldName, $where);
			} elseif($gradingComponent == '4') {
				$this->_deleteRecords('triune_grades_score_sheet_4_summary', $fieldName, $where);
			}

			foreach($scoreList as $index=>$key ) {
				if ($index < 1) continue;	
				$scoreArr = (array) $scoreList[$index];

				//------------------WRITTEN WORKS SCORES------------------------------------------------------------------------
				$totalScoreWW = array();
				$psScoreWW = array();
				$wsScoreWW = array();
				$totalScoreWW[$index] = 0;
				for($ww = 1; $ww <= $wwColumnCtr; $ww++) {
					$iWW = "WW".$ww;
					$totalScoreWW[$index] = $totalScoreWW[$index] + $scoreArr[$iWW];	           
					//echo $scoreArr[$iWW] . "<br>";
					// echo $totalScoreWW[$index] . "<br>";

				}		
				//echo $totalScoreWW[$index] . "<br>";

				$psScoreWW[$index] = number_format((($totalScoreWW[$index] / $maxScoreTotalWW) * 100) , 2);
				$wsScoreWW[$index] = number_format((($totalScoreWW[$index] / $maxScoreTotalWW) * 100) * ($wwPct / 100), 2);	
				//echo $totalScoreWW[$index] . " " . $psScoreWW[$index] . " " . $wsScoreWW[$index] . "<br>";
				//------------------WRITTEN WORKS SCORES------------------------------------------------------------------------


				//------------------PERFORMANCE TASKS SCORES------------------------------------------------------------------------
				$totalScorePT = array();
				$psScorePT = array();
				$wsScorePT = array();
				$totalScorePT[$index] = 0;
				for($pt = 1; $pt <= $ptColumnCtr; $pt++) {
					$iPT = "PT".$pt;
					$totalScorePT[$index] = $totalScorePT[$index] + $scoreArr[$iPT];	           
				}		
				$psScorePT[$index] = number_format((($totalScorePT[$index] / $maxScoreTotalPT) * 100) , 2);
				$wsScorePT[$index] = number_format((($totalScorePT[$index] / $maxScoreTotalPT) * 100) * ($ptPct / 100), 2);	
				//echo $totalScorePT[$index] . " " . $psScorePT[$index] . " " . $wsScorePT[$index] . "<br>"; 
				//------------------PERFORMANCE TASKS SCORES------------------------------------------------------------------------


				//------------------QUARTERLY ASSESSMENT SCORES------------------------------------------------------------------------
				$totalScoreQA = array();
				$psScoreQA = array();
				$wsScoreQA = array();
				$totalScoreQA[$index] = 0;
				for($qa = 1; $qa <= $qaColumnCtr; $qa++) {
					$iQA = "QA".$qa;
					$totalScoreQA[$index] = $totalScoreQA[$index] + $scoreArr[$iQA];	           
				}		
				$psScoreQA[$index] = number_format((($totalScoreQA[$index] / $maxScoreTotalQA) * 100) , 2);
				$wsScoreQA[$index] = number_format((($totalScoreQA[$index] / $maxScoreTotalQA) * 100) * ($qaPct / 100), 2);	
				//echo $totalScoreQA[$index] . " " . $psScoreQA[$index] . " " . $wsScoreQA[$index] . "<br>";
				//------------------QUARTERLY ASSESSMENT SCORES------------------------------------------------------------------------


				$initialGrade = array();
				$transmutedGrade = array();
				$initialGrade[$index] = ($wsScoreWW[$index] + $wsScorePT[$index] + $wsScoreQA[$index]);
		
				foreach($transmutation as $transmute) {
					if($transmute->lowScore <= $initialGrade[$index] && $transmute->highScore >= $initialGrade[$index]) {
						$transmutedGrade[$index] = $transmute->transmutedScore;
					}
				}	
				
				//echo $scoreArr['studentNumber'] . " " . $scoreArr['subjectCode'] . " " .  $scoreArr['sectionCode'] . " " . $transmutedGrade[$index] . "<br>";

				
				$insertData = null;
				$insertData = array(
					'sy' => $_SESSION['sy'],
					'sectionCode' => $scoreArr['sectionCode'],
					'subjectCode' => $scoreArr['subjectCode'],
					'studentNumber' => $scoreArr['studentNumber'],
					'writtenWorksGrade' => $wsScoreWW[$index],
					'performanceTasksGrade' =>  $wsScorePT[$index],
					'quarterlyAssessmentGrade' => $wsScoreQA[$index],
					'initialGrade' => $initialGrade[$index],
					'transmutedGrade' => $transmutedGrade[$index],
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),
				);				 

				
				//CLEAR SUBJECT'S RECORDS
				$where = array($_SESSION['sy'], $subjectCode, $sectionCode);
				$fieldName = array('sy', 'subjectCode', 'sectionCode');
				//CLEAR SUBJECT'S RECORDS

				$insertedRecord1 = null;
				
				if($gradingPeriod == '1') {
					$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grades_score_sheet_1_summary', $insertData);        			 
				} elseif($gradingPeriod == '2') {
					$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grades_score_sheet_2_summary', $insertData);        			 
				} elseif($gradingPeriod == '3') {
					$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grades_score_sheet_3_summary', $insertData);        			 
				} elseif($gradingPeriod == '4') {
					$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grades_score_sheet_4_summary', $insertData);        			 
				}
			} //foreach($scoreList as $index=>$key )

			$encodingStatus = array(
				'status' => 1,
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),

			);
			if($gradingPeriod == '1') {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_1_status', 
				$fieldName = array('sy', 'subjectCode', 'sectionCode'), 
				$where = array($_SESSION['sy'], $subjectCode, $sectionCode), $encodingStatus);
			} elseif($gradingPeriod == '2') {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_2_status', 
				$fieldName = array('sy', 'subjectCode', 'sectionCode'), 
				$where = array($_SESSION['sy'], $subjectCode, $sectionCode), $encodingStatus);
			} elseif($gradingPeriod == '3') {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_3_status', 
				$fieldName = array('sy', 'subjectCode', 'sectionCode'), 
				$where = array($_SESSION['sy'], $subjectCode, $sectionCode), $encodingStatus);
			} elseif($gradingPeriod == '4') {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_4_status', 
				$fieldName = array('sy', 'subjectCode', 'sectionCode'), 
				$where = array($_SESSION['sy'], $subjectCode, $sectionCode), $encodingStatus);
			}
			
			$this->db->trans_complete();
		} else {

			if($gradingPeriod == '1') {
				$selectFields = "triune_grades_score_sheet_1.*";
				
				$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
					$tables = array('triune_grades_score_sheet_1'), 
					$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
					$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($gradingPeriod == '2') {
				$selectFields = "triune_grades_score_sheet_2.*";
				
				$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
					$tables = array('triune_grades_score_sheet_2'), 
					$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
					$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($gradingPeriod == '3') {
				$selectFields = "triune_grades_score_sheet_3.*";
				
				$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
					$tables = array('triune_grades_score_sheet_3'), 
					$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
					$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($gradingPeriod == '4') {
				$selectFields = "triune_grades_score_sheet_4.*";
				
				$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
					$tables = array('triune_grades_score_sheet_4'), 
					$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
					$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			}
		
	
			//CLEAR SUBJECT'S RECORDS
			$where = array($_SESSION['sy'], $subjectCode, $sectionCode);
			$fieldName = array('sy', 'subjectCode', 'sectionCode');
			//CLEAR SUBJECT'S RECORDS
			
			$this->db->trans_start();

				if($gradingPeriod == '1') {
					$this->_deleteRecords('triune_grades_score_sheet_1_summary', $fieldName, $where);
				} elseif($gradingPeriod == '2') {
					$this->_deleteRecords('triune_grades_score_sheet_2_summary', $fieldName, $where);
				} elseif($gradingPeriod == '3') {
					$this->_deleteRecords('triune_grades_score_sheet_3_summary', $fieldName, $where);
				} elseif($gradingPeriod == '4') {
					$this->_deleteRecords('triune_grades_score_sheet_4_summary', $fieldName, $where);
				}
				
		
			foreach($scoreList as $index=>$key ) {
				if ($index < 1) continue;	
				$scoreArr = (array) $scoreList[$index];
			
					
				$insertData = null;
				$insertData = array(
					'sy' => $_SESSION['sy'],
					'sectionCode' => $scoreArr['sectionCode'],
					'subjectCode' => $scoreArr['subjectCode'],
					'studentNumber' => $scoreArr['studentNumber'],
					'writtenWorksGrade' => 0,
					'performanceTasksGrade' =>  0,
					'quarterlyAssessmentGrade' => 0,
					'initialGrade' => $scoreArr['WW1'],
					'transmutedGrade' => $scoreArr['WW1'],
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),
				);				 


				$insertedRecord1 = null;        			 

				if($gradingPeriod == '1') {
					$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grades_score_sheet_1_summary', $insertData);        			 
				} elseif($gradingPeriod == '2') {
					$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grades_score_sheet_2_summary', $insertData);        			 
				} elseif($gradingPeriod == '3') {
					$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grades_score_sheet_3_summary', $insertData);        			 
				} elseif($gradingPeriod == '4') {
					$insertedRecord1 =$this->_insertRecords($tableName = 'triune_grades_score_sheet_4_summary', $insertData);        			 
				}
				
					
			}
			
			$encodingStatus = array(
				'status' => 1,
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),

			);

			if($gradingPeriod == '1') {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_1_status', 
				$fieldName = array('sy', 'subjectCode', 'sectionCode'), 
				$where = array($_SESSION['sy'], $subjectCode, $sectionCode), $encodingStatus);
			} elseif($gradingPeriod == '2') {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_2_status', 
				$fieldName = array('sy', 'subjectCode', 'sectionCode'), 
				$where = array($_SESSION['sy'], $subjectCode, $sectionCode), $encodingStatus);
			} elseif($gradingPeriod == '3') {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_3_status', 
				$fieldName = array('sy', 'subjectCode', 'sectionCode'), 
				$where = array($_SESSION['sy'], $subjectCode, $sectionCode), $encodingStatus);
			} elseif($gradingPeriod == '4') {
				$this->_updateRecords($tableName = 'triune_grades_score_sheet_4_status', 
				$fieldName = array('sy', 'subjectCode', 'sectionCode'), 
				$where = array($_SESSION['sy'], $subjectCode, $sectionCode), $encodingStatus);
			}

			
			$this->db->trans_complete();
			
			
			
		}
		
    } //public function postSubjectGradesSummaryEGIS()	

    public function getMySectionScoreSheet1StatusEGISExcel() {
		$sectionCode = $_GET["sectionCode"];
		$subjectCode = $_GET["subjectCode"];

		//$sectionCode = "1002 2-8-INNOVATION";
		//$subjectCode = "FORELAN2";
		
		$results = null;
		
		$gradingPeriod = $_SESSION['gP'];
		
		if($gradingPeriod == 1) {
		
			$selectFields = "triune_grades_score_sheet_1_status.status";
			
			$results = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_1_status'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} else if($gradingPeriod == 2) {
			$selectFields = "triune_grades_score_sheet_2_status.status";
			
			$results = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_2_status'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} else if($gradingPeriod == 3) {
			$selectFields = "triune_grades_score_sheet_3_status.status";
			
			$results = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_3_status'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} else if($gradingPeriod == 4) {
			$selectFields = "triune_grades_score_sheet_4_status.status";
			
			$results = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_4_status'), 
				$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		}
		
		
		$data['status'] = $results[0]->status;	
		
		echo json_encode($data);
    }	

	
    public function getStudentSubjectsEGIS() {

		$results = null;
		$gradingPeriod = $_SESSION['gP'];		

		if($gradingPeriod == 1) {
			$selectFields = "triune_grades_score_sheet_1.sy, triune_grades_score_sheet_1.studentNumber, triune_grades_score_sheet_1.sectionCode, ";
			$selectFields = $selectFields . "triune_grades_score_sheet_1.subjectCode, triune_subject_junior_high.subjectDescription";
			
			$results = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_1', 'triune_subject_junior_high'), 
				$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
				$join = array('triune_grades_score_sheet_1.subjectCode = triune_subject_junior_high.subjectCode'), $joinType = array('inner'), 
				$sortBy = array('triune_grades_score_sheet_1.sectionCode', 'triune_subject_junior_high.subjectDescription'), $sortOrder = array('asc', 'asc'), 
				$limit = null, $fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			if(empty($results)) {
				$selectFields2 = "triune_grades_score_sheet_1.sy, triune_grades_score_sheet_1.studentNumber, triune_grades_score_sheet_1.sectionCode, ";
				$selectFields2 = $selectFields2 . "triune_grades_score_sheet_1.subjectCode, triune_subject_elementary.subjectDescription";
				
				$results = $this->_getRecordsData($dataSelect = array($selectFields2), 
					$tables = array('triune_grades_score_sheet_1', 'triune_subject_elementary'), 
					$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
					$join = array('triune_grades_score_sheet_1.subjectCode = triune_subject_elementary.subjectCode'), $joinType = array('inner'), 
					$sortBy = array('triune_grades_score_sheet_1.sectionCode', 'triune_subject_elementary.subjectDescription'), $sortOrder = array('asc', 'asc'), 
					$limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
					
					if(empty($results)) {
						$selectFields2 = "triune_grades_score_sheet_1.sy, triune_grades_score_sheet_1.studentNumber, triune_grades_score_sheet_1.sectionCode, ";
						$selectFields2 = $selectFields2 . "triune_grades_score_sheet_1.subjectCode, triune_subject_senior_high.subjectDescription";
						
						$results = $this->_getRecordsData($dataSelect = array($selectFields2), 
							$tables = array('triune_grades_score_sheet_1', 'triune_subject_senior_high'), 
							$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
							$join = array('triune_grades_score_sheet_1.subjectCode = triune_subject_senior_high.subjectCode'), $joinType = array('inner'), 
							$sortBy = array('triune_grades_score_sheet_1.sectionCode', 'triune_subject_senior_high.subjectDescription'), $sortOrder = array('asc', 'asc'), 
							$limit = null, $fieldNameLike = null, $like = null, 
							$whereSpecial = null, $groupBy = null );
					}
			}	
		} elseif($gradingPeriod == 2) {
			$selectFields = "triune_grades_score_sheet_2.sy, triune_grades_score_sheet_2.studentNumber, triune_grades_score_sheet_2.sectionCode, ";
			$selectFields = $selectFields . "triune_grades_score_sheet_2.subjectCode, triune_subject_junior_high.subjectDescription";
			
			$results = $this->_getRecordsData($dataSelect = array($selectFields), 
				$tables = array('triune_grades_score_sheet_2', 'triune_subject_junior_high'), 
				$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
				$join = array('triune_grades_score_sheet_2.subjectCode = triune_subject_junior_high.subjectCode'), $joinType = array('inner'), 
				$sortBy = array('triune_grades_score_sheet_2.sectionCode', 'triune_subject_junior_high.subjectDescription'), $sortOrder = array('asc', 'asc'), 
				$limit = null, $fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			if(empty($results)) {
				$selectFields2 = "triune_grades_score_sheet_2.sy, triune_grades_score_sheet_2.studentNumber, triune_grades_score_sheet_2.sectionCode, ";
				$selectFields2 = $selectFields2 . "triune_grades_score_sheet_2.subjectCode, triune_subject_elementary.subjectDescription";
				
				$results = $this->_getRecordsData($dataSelect = array($selectFields2), 
					$tables = array('triune_grades_score_sheet_2', 'triune_subject_elementary'), 
					$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
					$join = array('triune_grades_score_sheet_2.subjectCode = triune_subject_elementary.subjectCode'), $joinType = array('inner'), 
					$sortBy = array('triune_grades_score_sheet_2.sectionCode', 'triune_subject_elementary.subjectDescription'), $sortOrder = array('asc', 'asc'), 
					$limit = null, $fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
					
					if(empty($results)) {
						$selectFields2 = "triune_grades_score_sheet_2.sy, triune_grades_score_sheet_2.studentNumber, triune_grades_score_sheet_2.sectionCode, ";
						$selectFields2 = $selectFields2 . "triune_grades_score_sheet_2.subjectCode, triune_subject_senior_high.subjectDescription";
						
						$results = $this->_getRecordsData($dataSelect = array($selectFields2), 
							$tables = array('triune_grades_score_sheet_2', 'triune_subject_senior_high'), 
							$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']), 
							$join = array('triune_grades_score_sheet_2.subjectCode = triune_subject_senior_high.subjectCode'), $joinType = array('inner'), 
							$sortBy = array('triune_grades_score_sheet_2.sectionCode', 'triune_subject_senior_high.subjectDescription'), $sortOrder = array('asc', 'asc'), 
							$limit = null, $fieldNameLike = null, $like = null, 
							$whereSpecial = null, $groupBy = null );
					}
			}	
			
			
		}
			
		
		echo json_encode($results);
    }	


	public function processGradesRequestEGIS() {

		$allowStatus = $this->_getRecordsData($dataSelect = array('*'), 
			$tables = array('triune_grades_request_flag'),  $fieldName = null, $where = null, $join = null, 
			$joinType =null, $sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		$allowed = $allowStatus[0]->status;	

		$gradingPeriod = $_SESSION['gP'];
		
		if($allowed)
		{
	
						$sectionCode = $_POST["sectionCode"];
						$subjectCode = $_POST["subjectCode"];
						
						//$sectionCode = '1002 4-10-INNOVATION';
						//$subjectCode = 'APNH4H';
						
						//$attachmentPath = base_url() . "assets/pdf/subjectGradesSummary" . $_SESSION['studentNumber'] . ".pdf";
						$attachmentPath = $_SERVER['DOCUMENT_ROOT'] . "/trinity/assets/pdf/sample.txt";
						$message = "This email is very confidential, you should not share this";
						$emailAddress = $_SESSION['emailAddress'];
						//$emailAddress = 'dpo@tua.edu.ph';

						$selectFieldsName = "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', SUBSTR(triune_students_k12.middleName, 1, 1), '.') as fullName";
						
						$resultsName = $this->_getRecordsData($dataSelect = array($selectFieldsName), 
							$tables = array('triune_students_k12'), 
							$fieldName = array('studentNumber' ), $where = array($_SESSION['userNumber']),  //$_SESSION['userNumber']
							$join = null, $joinType =null, $sortBy = null, $sortOrder = null, $limit = null, 
							$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


							$scoreList = null;
							$maxScoreList = null;
							
							
								if($gradingPeriod == 1) {
									$selectFields = "triune_grades_score_sheet_1.*";
									$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
										$tables = array('triune_grades_score_sheet_1'), 
										$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber'), $where = array($_SESSION['sy'], $sectionCode, $subjectCode, $_SESSION['userNumber']),  //$_SESSION['userNumber']
										$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
										$whereSpecial = null, $groupBy = null );


									$maxScoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
										$tables = array('triune_grades_score_sheet_1'), 
										$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber'), $where = array($_SESSION['sy'], $sectionCode, $subjectCode, 'MAXSCORE'),  //$_SESSION['userNumber']
										$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
										$whereSpecial = null, $groupBy = null );
								} elseif($gradingPeriod == 1) {
									
									$selectFields = "triune_grades_score_sheet_2.*";
									$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
										$tables = array('triune_grades_score_sheet_2'), 
										$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber'), $where = array($_SESSION['sy'], $sectionCode, $subjectCode, $_SESSION['userNumber']),  //$_SESSION['userNumber']
										$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
										$whereSpecial = null, $groupBy = null );


									$maxScoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
										$tables = array('triune_grades_score_sheet_2'), 
										$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber'), $where = array($_SESSION['sy'], $sectionCode, $subjectCode, 'MAXSCORE'),  //$_SESSION['userNumber']
										$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
										$whereSpecial = null, $groupBy = null );
									
								}
								
								$wwColumnCtr = 0;
								$ptColumnCtr = 0;			
								$qaColumnCtr = 0;			
								
								//var_dump($scoreList);
								$maxScoreCounter = (array) $maxScoreList[0];
								
								
								
						//var_dump($scoreList);		
								//var_dump($maxScoreCounter);
								$maxScoreCount = count($maxScoreCounter); 
								$maxScoreRow = $maxScoreCounter;
								
								for($w = 1; $w < 16; $w++) {
									if($maxScoreCounter['WW'.$w] > 0) {
										$wwColumnCtr++;
									}				
								}
								
								for($p = 1; $p < 11; $p++) {
									if($maxScoreCounter['PT'.$p] > 0) {
										$ptColumnCtr++;
									}				
								}

								for($q = 1; $q < 2; $q++) {
									if($maxScoreCounter['QA'.$q] > 0) {
										$qaColumnCtr++;
									}				
								}
								
								//echo $wwColumnCtr . "<br>";
								//echo $ptColumnCtr . "<br>";			
								//echo $qaColumnCtr . "<br>";		
								
							$selectSP = "triune_grading_components.levelCode, triune_grading_components.departmentCode, triune_grading_components.gradingComponentCode, ";
							$selectSP = $selectSP . "triune_grading_components.componentPercentage, triune_grading_components.sy";

							$courseCode = substr($sectionCode, 0, 4);
							$scorePercentage = null;
							
							if($courseCode == '1001') {
								$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
									$tables = array('triune_subject_elementary', 'triune_grading_components'), 
									$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
									$join = array('triune_subject_elementary.departmentCode = triune_grading_components.departmentCode'), $joinType = array('inner'), 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($courseCode == '1002') {
								$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
									$tables = array('triune_subject_junior_high', 'triune_grading_components'), 
									$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
									$join = array('triune_subject_junior_high.departmentCode = triune_grading_components.departmentCode'), $joinType = array('inner'), 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($courseCode == '1005') {
								
								$selectSP = "triune_grading_components_sh.levelCode, triune_grading_components_sh.subjectComponentCode, triune_grading_components_sh.gradingComponentCode, ";
								$selectSP = $selectSP . "triune_grading_components_sh.componentPercentage, triune_grading_components_sh.sy";
								
								$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
									$tables = array('triune_subject_senior_high', 'triune_grading_components_sh'), 
									$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
									$join = array('triune_subject_senior_high.subjectComponentCode = triune_grading_components_sh.subjectComponentCode'), $joinType = array('inner'), 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							}

							if($gradingPeriod == 1) {
								$titlesFields = "triune_grades_score_sheet_1_title.*";
								$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
									$tables = array('triune_grades_score_sheet_1_title'), 
									$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
									$join = null, $joinType = null, 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($gradingPeriod == 2) {
								$titlesFields = "triune_grades_score_sheet_2_title.*";
								$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
									$tables = array('triune_grades_score_sheet_2_title'), 
									$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
									$join = null, $joinType = null, 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($gradingPeriod == 3) {
								$titlesFields = "triune_grades_score_sheet_3_title.*";
								$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
									$tables = array('triune_grades_score_sheet_3_title'), 
									$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
									$join = null, $joinType = null, 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($gradingPeriod == 4) {
								$titlesFields = "triune_grades_score_sheet_4_title.*";
								$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
									$tables = array('triune_grades_score_sheet_4_title'), 
									$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
									$join = null, $joinType = null, 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							}
								
							$titlesHeader = (array) $titlesData[0];
							//var_dump($titlesHeader);	
							$wwPct = 0;
							$ptPct = 0;
							$qaPct = 0;

							foreach($scorePercentage as $row) {
								if($row->gradingComponentCode == 'WW') {
									$wwPct = $row->componentPercentage;
								} else if($row->gradingComponentCode == 'PT') {
									$ptPct = $row->componentPercentage;
								} else if($row->gradingComponentCode == 'QA') {
									$qaPct = $row->componentPercentage;
								}
							}
							//echo $wwPct . "<br>";
							//echo $ptPct . "<br>";
							//echo $qaPct . "<br>";


							$transmutation = $this->_getRecordsData($dataSelect = array('*'), 
								$tables = array('triune_transmutation_k12'), 
								$fieldName = null, $where = null, 
								$join = null, $joinType = null, 
								$sortBy = array('transmutedScore'), $sortOrder = array('desc'), $limit = null, 
								$fieldNameLike = null, $like = null, 
								$whereSpecial = null, $groupBy = null );

							//var_dump($transmutation);
								
								
							$maxScoreTotalWW = 0;
							for($ww = 1; $ww <= $wwColumnCtr; $ww++) {
								$iWW = "WW".$ww;
								$maxScoreTotalWW = $maxScoreTotalWW + $maxScoreRow[$iWW];
								//echo $maxScoreRow[$iWW] . "<br>";
							}
							//echo $maxScoreTotalWW;


							$maxScoreTotalPT = 0;
							for($pt = 1; $pt <= $ptColumnCtr; $pt++) {
								$iPT = "PT".$pt;
								$maxScoreTotalPT = $maxScoreTotalPT + $maxScoreRow[$iPT];
								//echo $maxScoreRow[$iPT] . "<br>";
							}
							//echo $maxScoreTotalPT;


							$maxScoreTotalQA = 0;
							for($qa = 1; $qa <= $qaColumnCtr; $qa++) {
								$iQA = "QA".$qa;
								$maxScoreTotalQA = $maxScoreTotalQA + $maxScoreRow[$iQA];
								// echo $maxScoreRow[$iQA] . "<br>";
							}
							//echo $maxScoreTotalQA;

							$wwColumnCount = $wwColumnCtr + 3;
							$ptColumnCount = $ptColumnCtr + 3;
							$qaColumnCount = $qaColumnCtr + 2;

						
							$message = "<div><h3> Grades Summary for " . $sectionCode . " : " . $subjectCode . "</h3></div>"; 
							
							
					$message = $message . '<table border="1" cellpadding="1" cellspacing="1" nobr="true" width="100%" >';
					$message = $message . '<tr align="center">';
					$message = $message . '<td width="6%"></td>';
					$message = $message . '<td width="16%"></td>';
					$message = $message . '<td width="35%" colspan="' .$wwColumnCount . '" >Written Work' . $wwPct .'%</td>';
					$message = $message . '<td width="30%" colspan="' .$ptColumnCount . '">Performance Task' . $ptPct .'%</td>';
					$message = $message . '<td width="7%" colspan="' .$qaColumnCount . '">Quarterly Assessment' . $qaPct . '%</td>';
					$message = $message . '<td width="3%"> Initial Grade</td>';
					$message = $message . '<td width="3%"> Quarterly Grade</td>';
					$message = $message . '</tr>';		


					$message = $message . '<tr align="center">';
					$message = $message . '<td>Student Number</td>';
					$message = $message . '<td>Full Name</td>';

					for($ww = 1; $ww <= ($wwColumnCount - 3); $ww++) {
					$indexWW = "titleWW".$ww;
						$message = $message . '<td>' . $titlesHeader[$indexWW] . '</td>';
					}	

					$message = $message . '<td>Total</td>';
					$message = $message .  '<td>PS</td>';
					$message = $message .  '<td>WS</td>';


					for($pt = 1; $pt <= ($ptColumnCount - 3); $pt++) {
					$indexPT = "titlePT".$pt;
					 $message = $message . '<td>' . $titlesHeader[$indexPT] . '</td>';
					}	
					$message = $message . '<td>Total</td>';
					$message = $message .  '<td>PS</td>';
					$message = $message .  '<td>WS</td>';

					for($qa = 1; $qa <= ($qaColumnCount - 2); $qa++) {
					$indexQA = "titleQA".$qa;
					 $message = $message . '<td>' . $titlesHeader[$indexQA] . '</td>';
					}	


					$message = $message .  '<td>PS</td>';
					$message = $message .  '<td>WS</td>';
					$message = $message .  '<td></td>';
					$message = $message .  '<td></td>';
					$message = $message .  '</tr>'; 

					$message = $message .  	'<tr>';
					$message = $message .  	'<td colspan="2" align="center">Highest Possible Score</td>';



					$maxScoreTotalWW = 0;
					for($ww = 1; $ww <= ($wwColumnCount - 3); $ww++) {
					$iWW = "WW".$ww;
					$maxScoreTotalWW = $maxScoreTotalWW + $maxScoreRow[$iWW];
					$message = $message .  '<td align="right">' .$maxScoreRow[$iWW]. '</td>';
					}

					$message = $message .  	'<td align="right">' .$maxScoreTotalWW . '</td>';
					$message = $message .  	'<td align="right">100</td>';	
					$message = $message .  	'<td align="right">' .$wwPct . '%</td>';	


					$maxScoreTotalPT = 0;
					for($pt = 1; $pt <= ($ptColumnCount - 3); $pt++) {
					$iPT = "PT".$pt;
					$maxScoreTotalPT = $maxScoreTotalPT + $maxScoreRow[$iPT];
					$message = $message .  '<td align="right">' .$maxScoreRow[$iPT]. '</td>';

					}


					$message = $message .  	'<td align="right">' .$maxScoreTotalPT . '</td>';
					$message = $message .  	'<td align="right">100</td>';	
					$message = $message .  	'<td align="right">' .$ptPct . '%</td>';	



					$maxScoreTotalQA = 0;
					for($qa = 1; $qa <= ($qaColumnCount - 2); $qa++) {
					$iQA = "QA".$qa;
					$maxScoreTotalQA = $maxScoreTotalQA + $maxScoreRow[$iQA];
					$message = $message .  	'<td align="right">' . $maxScoreRow[$iQA] . '</td>';
					}

					$message = $message . '<td align="right">100</td>';	
					$message = $message . '<td align="right">'. $qaPct . '%</td>';	


					$message = $message . '<td align="right">100</td>';	
					$message = $message . '<td align="right">100</td>';	
					$message = $message . '</tr>';

							
							foreach($scoreList as $index=>$key ) {
								//if ($index < 1) continue;	
								$studentNumber = $resultsName[0]->studentNumber;
								$fullName = $resultsName[0]->fullName;
								 
					$message = $message . '<tr>';
					$message = $message . '<td>' . $studentNumber . '</td>';
					$message = $message . '<td>' . $fullName . '</td>';
								
								$scoreArr = (array) $scoreList[$index];

								//------------------WRITTEN WORKS SCORES------------------------------------------------------------------------
								$totalScoreWW = array();
								$psScoreWW = array();
								$wsScoreWW = array();
								$totalScoreWW[$index] = 0;
								for($ww = 1; $ww <= $wwColumnCtr; $ww++) {
									$iWW = "WW".$ww;
									$totalScoreWW[$index] = $totalScoreWW[$index] + $scoreArr[$iWW];	           
					$message = $message . '<td align="right">' . $scoreArr[$iWW] . '</td>';
								}		
								//echo $totalScoreWW[$index] . "<br>";

								$psScoreWW[$index] = number_format((($totalScoreWW[$index] / $maxScoreTotalWW) * 100) , 2);
								$wsScoreWW[$index] = number_format((($totalScoreWW[$index] / $maxScoreTotalWW) * 100) * ($wwPct / 100), 2);	
								//echo $totalScoreWW[$index] . " " . $psScoreWW[$index] . " " . $wsScoreWW[$index] . "<br>";
								
					$message = $message . '<td align="right">' . $totalScoreWW[$index] . '</td>';
					$message = $message . '<td align="right">' . $psScoreWW[$index] . '</td>';
					$message = $message . '<td align="right">' . $wsScoreWW[$index] . '</td>';
								
								//------------------WRITTEN WORKS SCORES------------------------------------------------------------------------


								//------------------PERFORMANCE TASKS SCORES------------------------------------------------------------------------
								$totalScorePT = array();
								$psScorePT = array();
								$wsScorePT = array();
								$totalScorePT[$index] = 0;
								for($pt = 1; $pt <= $ptColumnCtr; $pt++) {
									$iPT = "PT".$pt;
									$totalScorePT[$index] = $totalScorePT[$index] + $scoreArr[$iPT];	   
					$message = $message . '<td align="right">' . $scoreArr[$iPT] . '</td>';
									
								}		
								$psScorePT[$index] = number_format((($totalScorePT[$index] / $maxScoreTotalPT) * 100) , 2);
								$wsScorePT[$index] = number_format((($totalScorePT[$index] / $maxScoreTotalPT) * 100) * ($ptPct / 100), 2);	
								//echo $totalScorePT[$index] . " " . $psScorePT[$index] . " " . $wsScorePT[$index] . "<br>"; 
					$message = $message . '<td align="right">'. $totalScorePT[$index] . '</td>';
					$message = $message . '<td align="right">' . $psScorePT[$index] . '</td>';
					$message = $message . '<td align="right">'. $wsScorePT[$index]. '</td>';			
								
								//------------------PERFORMANCE TASKS SCORES------------------------------------------------------------------------


								//------------------QUARTERLY ASSESSMENT SCORES------------------------------------------------------------------------
								$totalScoreQA = array();
								$psScoreQA = array();
								$wsScoreQA = array();
								$totalScoreQA[$index] = 0;
								for($qa = 1; $qa <= $qaColumnCtr; $qa++) {
									$iQA = "QA".$qa;
									$totalScoreQA[$index] = $totalScoreQA[$index] + $scoreArr[$iQA];	 
					$message = $message . '<td align="right">' . $scoreArr[$iQA] . '</td>';
								}		
								$psScoreQA[$index] = number_format((($totalScoreQA[$index] / $maxScoreTotalQA) * 100) , 2);
								$wsScoreQA[$index] = number_format((($totalScoreQA[$index] / $maxScoreTotalQA) * 100) * ($qaPct / 100), 2);	
								//echo $totalScoreQA[$index] . " " . $psScoreQA[$index] . " " . $wsScoreQA[$index] . "<br>";
					$message = $message . '<td align="right">' . $psScoreQA[$index] . '</td>';
					$message = $message . '<td align="right">' . $wsScoreQA[$index] . '</td>';			
								//------------------QUARTERLY ASSESSMENT SCORES------------------------------------------------------------------------


								$initialGrade = array();
								$transmutedGrade = array();
								$initialGrade[$index] = ($wsScoreWW[$index] + $wsScorePT[$index] + $wsScoreQA[$index]);
						
								foreach($transmutation as $transmute) {
									if($transmute->lowScore <= $initialGrade[$index] && $transmute->highScore >= $initialGrade[$index]) {
										$transmutedGrade[$index] = $transmute->transmutedScore;
									}
								}	
					$message = $message . '<td align="right">' . $initialGrade[$index] . '</td>';
					$message = $message . '<td align="right">' . $transmutedGrade[$index] . '</td>';
					$message = $message . '</tr>';		
					$message = $message . '</table>';			
							}
							
							
					//echo $message;
							
							
							
							
							
							$emailSent = $this->_sendMail($toEmail =$emailAddress, $subject = "Grades Request", $message);
							if(!$emailSent) {
								//$this->session->set_flashdata('emailSent', '1');
								//echo "HELLO";
							} else {
								//$this->session->set_flashdata('emailSent', '1');
								//$this->session->set_flashdata('emailAddress', $emailAddress);
								//redirect(base_url().'user-acct/sign-in');

							}
		}

	}	

	
	public function processAllGradesRequestEGIS() {
		
		$allowStatus = $this->_getRecordsData($dataSelect = array('*'), 
			$tables = array('triune_grades_request_flag'),  $fieldName = null, $where = null, $join = null, 
			$joinType =null, $sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		$allowed = $allowStatus[0]->status;	

		$gradingPeriod = $_SESSION['gP'];
		
		if($allowed)
		{
	
						//$sectionCode = $_POST["sectionCode"];
						//$subjectCode = $_POST["subjectCode"];
						
						//$sectionCode = '1002 4-10-INNOVATION';
						//$subjectCode = 'APNH4H';
						
						//$attachmentPath = base_url() . "assets/pdf/subjectGradesSummary" . $_SESSION['studentNumber'] . ".pdf";
						//$attachmentPath = $_SERVER['DOCUMENT_ROOT'] . "/trinity/assets/pdf/sample.txt";
						//$message = "This email is very confidential, you should not share this";
						$emailAddress = $_SESSION['emailAddress'];
						//$emailAddress = 'dpo@tua.edu.ph';

						$selectFieldsName = "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', SUBSTR(triune_students_k12.middleName, 1, 1), '.') as fullName";
						
						$resultsName = $this->_getRecordsData($dataSelect = array($selectFieldsName), 
							$tables = array('triune_students_k12'), 
							$fieldName = array('studentNumber' ), $where = array($_SESSION['userNumber']),  //$_SESSION['userNumber']
							$join = null, $joinType =null, $sortBy = null, $sortOrder = null, $limit = null, 
							$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


							$scoreList = null;
							$maxScoreList = null;
							$subjectSectionList = null;
							
							if($gradingPeriod == 1) {
								$selectFields = "triune_grades_score_sheet_1.*";
								$subjectSectionList = $this->_getRecordsData($dataSelect = array($selectFields), 
									$tables = array('triune_grades_score_sheet_1'), 
									$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']),  //$_SESSION['userNumber']
									$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );

							} elseif($gradingPeriod == 2) {
								
								$selectFields = "triune_grades_score_sheet_2.*";
								$subjectSectionList = $this->_getRecordsData($dataSelect = array($selectFields), 
									$tables = array('triune_grades_score_sheet_2'), 
									$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $_SESSION['userNumber']),  //$_SESSION['userNumber']
									$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
								
							}

							$message = null;
							foreach($subjectSectionList as $row) {
								$sectionCode = $row->sectionCode;
								$subjectCode = $row->subjectCode;
							
								if($gradingPeriod == 1) {
									$selectFields = "triune_grades_score_sheet_1.*";
									$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
										$tables = array('triune_grades_score_sheet_1'), 
										$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber'), $where = array($_SESSION['sy'], $sectionCode, $subjectCode, $_SESSION['userNumber']),  //$_SESSION['userNumber']
										$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
										$whereSpecial = null, $groupBy = null );


									$maxScoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
										$tables = array('triune_grades_score_sheet_1'), 
										$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber'), $where = array($_SESSION['sy'], $sectionCode, $subjectCode, 'MAXSCORE'),  //$_SESSION['userNumber']
										$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
										$whereSpecial = null, $groupBy = null );
								} elseif($gradingPeriod == 2) {
									
									$selectFields = "triune_grades_score_sheet_2.*";
									$scoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
										$tables = array('triune_grades_score_sheet_2'), 
										$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber'), $where = array($_SESSION['sy'], $sectionCode, $subjectCode, $_SESSION['userNumber']),  //$_SESSION['userNumber']
										$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
										$whereSpecial = null, $groupBy = null );


									$maxScoreList = $this->_getRecordsData($dataSelect = array($selectFields), 
										$tables = array('triune_grades_score_sheet_2'), 
										$fieldName = array('sy', 'sectionCode', 'subjectCode', 'studentNumber'), $where = array($_SESSION['sy'], $sectionCode, $subjectCode, 'MAXSCORE'),  //$_SESSION['userNumber']
										$join = null, $joinType = null, $sortBy = array('studentNumber'), $sortOrder = array('desc'), $limit = null, $fieldNameLike = null, $like = null, 
										$whereSpecial = null, $groupBy = null );
									
								}
								
								$wwColumnCtr = 0;
								$ptColumnCtr = 0;			
								$qaColumnCtr = 0;			
								
								//var_dump($scoreList);
								$maxScoreCounter = (array) $maxScoreList[0];
								
								
								
						//var_dump($scoreList);		
								//var_dump($maxScoreCounter);
								$maxScoreCount = count($maxScoreCounter); 
								$maxScoreRow = $maxScoreCounter;
								
								for($w = 1; $w < 16; $w++) {
									if($maxScoreCounter['WW'.$w] > 0) {
										$wwColumnCtr++;
									}				
								}
								
								for($p = 1; $p < 11; $p++) {
									if($maxScoreCounter['PT'.$p] > 0) {
										$ptColumnCtr++;
									}				
								}

								for($q = 1; $q < 2; $q++) {
									if($maxScoreCounter['QA'.$q] > 0) {
										$qaColumnCtr++;
									}				
								}
								
								//echo $wwColumnCtr . "<br>";
								//echo $ptColumnCtr . "<br>";			
								//echo $qaColumnCtr . "<br>";		
								
							$selectSP = "triune_grading_components.levelCode, triune_grading_components.departmentCode, triune_grading_components.gradingComponentCode, ";
							$selectSP = $selectSP . "triune_grading_components.componentPercentage, triune_grading_components.sy";

							$courseCode = substr($sectionCode, 0, 4);
							$scorePercentage = null;
							
							if($courseCode == '1001') {
								$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
									$tables = array('triune_subject_elementary', 'triune_grading_components'), 
									$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
									$join = array('triune_subject_elementary.departmentCode = triune_grading_components.departmentCode'), $joinType = array('inner'), 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($courseCode == '1002') {
								$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
									$tables = array('triune_subject_junior_high', 'triune_grading_components'), 
									$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
									$join = array('triune_subject_junior_high.departmentCode = triune_grading_components.departmentCode'), $joinType = array('inner'), 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($courseCode == '1005') {
								
								$selectSP = "triune_grading_components_sh.levelCode, triune_grading_components_sh.subjectComponentCode, triune_grading_components_sh.gradingComponentCode, ";
								$selectSP = $selectSP . "triune_grading_components_sh.componentPercentage, triune_grading_components_sh.sy";
								
								$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
									$tables = array('triune_subject_senior_high', 'triune_grading_components_sh'), 
									$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
									$join = array('triune_subject_senior_high.subjectComponentCode = triune_grading_components_sh.subjectComponentCode'), $joinType = array('inner'), 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							}

							if($gradingPeriod == 1) {
								$titlesFields = "triune_grades_score_sheet_1_title.*";
								$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
									$tables = array('triune_grades_score_sheet_1_title'), 
									$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
									$join = null, $joinType = null, 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($gradingPeriod == 2) {
								$titlesFields = "triune_grades_score_sheet_2_title.*";
								$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
									$tables = array('triune_grades_score_sheet_2_title'), 
									$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
									$join = null, $joinType = null, 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($gradingPeriod == 3) {
								$titlesFields = "triune_grades_score_sheet_3_title.*";
								$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
									$tables = array('triune_grades_score_sheet_3_title'), 
									$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
									$join = null, $joinType = null, 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							} elseif($gradingPeriod == 4) {
								$titlesFields = "triune_grades_score_sheet_4_title.*";
								$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
									$tables = array('triune_grades_score_sheet_4_title'), 
									$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
									$join = null, $joinType = null, 
									$sortBy = null, $sortOrder = null, $limit = null, 
									$fieldNameLike = null, $like = null, 
									$whereSpecial = null, $groupBy = null );
							}
								
							$titlesHeader = (array) $titlesData[0];
							//var_dump($titlesHeader);	
							$wwPct = 0;
							$ptPct = 0;
							$qaPct = 0;

							foreach($scorePercentage as $row) {
								if($row->gradingComponentCode == 'WW') {
									$wwPct = $row->componentPercentage;
								} else if($row->gradingComponentCode == 'PT') {
									$ptPct = $row->componentPercentage;
								} else if($row->gradingComponentCode == 'QA') {
									$qaPct = $row->componentPercentage;
								}
							}
							//echo $wwPct . "<br>";
							//echo $ptPct . "<br>";
							//echo $qaPct . "<br>";


							$transmutation = $this->_getRecordsData($dataSelect = array('*'), 
								$tables = array('triune_transmutation_k12'), 
								$fieldName = null, $where = null, 
								$join = null, $joinType = null, 
								$sortBy = array('transmutedScore'), $sortOrder = array('desc'), $limit = null, 
								$fieldNameLike = null, $like = null, 
								$whereSpecial = null, $groupBy = null );

							//var_dump($transmutation);
								
								
							$maxScoreTotalWW = 0;
							for($ww = 1; $ww <= $wwColumnCtr; $ww++) {
								$iWW = "WW".$ww;
								$maxScoreTotalWW = $maxScoreTotalWW + $maxScoreRow[$iWW];
								//echo $maxScoreRow[$iWW] . "<br>";
							}
							//echo $maxScoreTotalWW;


							$maxScoreTotalPT = 0;
							for($pt = 1; $pt <= $ptColumnCtr; $pt++) {
								$iPT = "PT".$pt;
								$maxScoreTotalPT = $maxScoreTotalPT + $maxScoreRow[$iPT];
								//echo $maxScoreRow[$iPT] . "<br>";
							}
							//echo $maxScoreTotalPT;


							$maxScoreTotalQA = 0;
							for($qa = 1; $qa <= $qaColumnCtr; $qa++) {
								$iQA = "QA".$qa;
								$maxScoreTotalQA = $maxScoreTotalQA + $maxScoreRow[$iQA];
								// echo $maxScoreRow[$iQA] . "<br>";
							}
							//echo $maxScoreTotalQA;

							$wwColumnCount = $wwColumnCtr + 3;
							$ptColumnCount = $ptColumnCtr + 3;
							$qaColumnCount = $qaColumnCtr + 2;

						
							$message = $message . "<div><h3> Grades Summary for " . $sectionCode . " : " . $subjectCode . "</h3></div>"; 
							
							
					$message = $message . '<table border="1" cellpadding="1" cellspacing="1" nobr="true" width="100%" >';
					$message = $message . '<tr align="center">';
					$message = $message . '<td width="6%"></td>';
					$message = $message . '<td width="16%"></td>';
					$message = $message . '<td width="35%" colspan="' .$wwColumnCount . '" >Written Work' . $wwPct .'%</td>';
					$message = $message . '<td width="30%" colspan="' .$ptColumnCount . '">Performance Task' . $ptPct .'%</td>';
					$message = $message . '<td width="7%" colspan="' .$qaColumnCount . '">Quarterly Assessment' . $qaPct . '%</td>';
					$message = $message . '<td width="3%"> Initial Grade</td>';
					$message = $message . '<td width="3%"> Quarterly Grade</td>';
					$message = $message . '</tr>';		


					$message = $message . '<tr align="center">';
					$message = $message . '<td>Student Number</td>';
					$message = $message . '<td>Full Name</td>';

					for($ww = 1; $ww <= ($wwColumnCount - 3); $ww++) {
					$indexWW = "titleWW".$ww;
						$message = $message . '<td>' . $titlesHeader[$indexWW] . '</td>';
					}	

					$message = $message . '<td>Total</td>';
					$message = $message .  '<td>PS</td>';
					$message = $message .  '<td>WS</td>';


					for($pt = 1; $pt <= ($ptColumnCount - 3); $pt++) {
					$indexPT = "titlePT".$pt;
					 $message = $message . '<td>' . $titlesHeader[$indexPT] . '</td>';
					}	
					$message = $message . '<td>Total</td>';
					$message = $message .  '<td>PS</td>';
					$message = $message .  '<td>WS</td>';

					for($qa = 1; $qa <= ($qaColumnCount - 2); $qa++) {
					$indexQA = "titleQA".$qa;
					 $message = $message . '<td>' . $titlesHeader[$indexQA] . '</td>';
					}	


					$message = $message .  '<td>PS</td>';
					$message = $message .  '<td>WS</td>';
					$message = $message .  '<td></td>';
					$message = $message .  '<td></td>';
					$message = $message .  '</tr>'; 

					$message = $message .  	'<tr>';
					$message = $message .  	'<td colspan="2" align="center">Highest Possible Score</td>';



					$maxScoreTotalWW = 0;
					for($ww = 1; $ww <= ($wwColumnCount - 3); $ww++) {
					$iWW = "WW".$ww;
					$maxScoreTotalWW = $maxScoreTotalWW + $maxScoreRow[$iWW];
					$message = $message .  '<td align="right">' .$maxScoreRow[$iWW]. '</td>';
					}

					$message = $message .  	'<td align="right">' .$maxScoreTotalWW . '</td>';
					$message = $message .  	'<td align="right">100</td>';	
					$message = $message .  	'<td align="right">' .$wwPct . '%</td>';	


					$maxScoreTotalPT = 0;
					for($pt = 1; $pt <= ($ptColumnCount - 3); $pt++) {
					$iPT = "PT".$pt;
					$maxScoreTotalPT = $maxScoreTotalPT + $maxScoreRow[$iPT];
					$message = $message .  '<td align="right">' .$maxScoreRow[$iPT]. '</td>';

					}


					$message = $message .  	'<td align="right">' .$maxScoreTotalPT . '</td>';
					$message = $message .  	'<td align="right">100</td>';	
					$message = $message .  	'<td align="right">' .$ptPct . '%</td>';	



					$maxScoreTotalQA = 0;
					for($qa = 1; $qa <= ($qaColumnCount - 2); $qa++) {
					$iQA = "QA".$qa;
					$maxScoreTotalQA = $maxScoreTotalQA + $maxScoreRow[$iQA];
					$message = $message .  	'<td align="right">' . $maxScoreRow[$iQA] . '</td>';
					}

					$message = $message . '<td align="right">100</td>';	
					$message = $message . '<td align="right">'. $qaPct . '%</td>';	


					$message = $message . '<td align="right">100</td>';	
					$message = $message . '<td align="right">100</td>';	
					$message = $message . '</tr>';

							
							foreach($scoreList as $index=>$key ) {
								//if ($index < 1) continue;	
								$studentNumber = $resultsName[0]->studentNumber;
								$fullName = $resultsName[0]->fullName;
								 
					$message = $message . '<tr>';
					$message = $message . '<td>' . $studentNumber . '</td>';
					$message = $message . '<td>' . $fullName . '</td>';
								
								$scoreArr = (array) $scoreList[$index];

								//------------------WRITTEN WORKS SCORES------------------------------------------------------------------------
								$totalScoreWW = array();
								$psScoreWW = array();
								$wsScoreWW = array();
								$totalScoreWW[$index] = 0;
								for($ww = 1; $ww <= $wwColumnCtr; $ww++) {
									$iWW = "WW".$ww;
									$totalScoreWW[$index] = $totalScoreWW[$index] + $scoreArr[$iWW];	           
					$message = $message . '<td align="right">' . $scoreArr[$iWW] . '</td>';
								}		
								//echo $totalScoreWW[$index] . "<br>";

								$psScoreWW[$index] = number_format((($totalScoreWW[$index] / $maxScoreTotalWW) * 100) , 2);
								$wsScoreWW[$index] = number_format((($totalScoreWW[$index] / $maxScoreTotalWW) * 100) * ($wwPct / 100), 2);	
								//echo $totalScoreWW[$index] . " " . $psScoreWW[$index] . " " . $wsScoreWW[$index] . "<br>";
								
					$message = $message . '<td align="right">' . $totalScoreWW[$index] . '</td>';
					$message = $message . '<td align="right">' . $psScoreWW[$index] . '</td>';
					$message = $message . '<td align="right">' . $wsScoreWW[$index] . '</td>';
								
								//------------------WRITTEN WORKS SCORES------------------------------------------------------------------------


								//------------------PERFORMANCE TASKS SCORES------------------------------------------------------------------------
								$totalScorePT = array();
								$psScorePT = array();
								$wsScorePT = array();
								$totalScorePT[$index] = 0;
								for($pt = 1; $pt <= $ptColumnCtr; $pt++) {
									$iPT = "PT".$pt;
									$totalScorePT[$index] = $totalScorePT[$index] + $scoreArr[$iPT];	   
					$message = $message . '<td align="right">' . $scoreArr[$iPT] . '</td>';
									
								}		
								$psScorePT[$index] = number_format((($totalScorePT[$index] / $maxScoreTotalPT) * 100) , 2);
								$wsScorePT[$index] = number_format((($totalScorePT[$index] / $maxScoreTotalPT) * 100) * ($ptPct / 100), 2);	
								//echo $totalScorePT[$index] . " " . $psScorePT[$index] . " " . $wsScorePT[$index] . "<br>"; 
					$message = $message . '<td align="right">'. $totalScorePT[$index] . '</td>';
					$message = $message . '<td align="right">' . $psScorePT[$index] . '</td>';
					$message = $message . '<td align="right">'. $wsScorePT[$index]. '</td>';			
								
								//------------------PERFORMANCE TASKS SCORES------------------------------------------------------------------------


								//------------------QUARTERLY ASSESSMENT SCORES------------------------------------------------------------------------
								$totalScoreQA = array();
								$psScoreQA = array();
								$wsScoreQA = array();
								$totalScoreQA[$index] = 0;
								for($qa = 1; $qa <= $qaColumnCtr; $qa++) {
									$iQA = "QA".$qa;
									$totalScoreQA[$index] = $totalScoreQA[$index] + $scoreArr[$iQA];	 
					$message = $message . '<td align="right">' . $scoreArr[$iQA] . '</td>';
								}		
								$psScoreQA[$index] = number_format((($totalScoreQA[$index] / $maxScoreTotalQA) * 100) , 2);
								$wsScoreQA[$index] = number_format((($totalScoreQA[$index] / $maxScoreTotalQA) * 100) * ($qaPct / 100), 2);	
								//echo $totalScoreQA[$index] . " " . $psScoreQA[$index] . " " . $wsScoreQA[$index] . "<br>";
					$message = $message . '<td align="right">' . $psScoreQA[$index] . '</td>';
					$message = $message . '<td align="right">' . $wsScoreQA[$index] . '</td>';			
								//------------------QUARTERLY ASSESSMENT SCORES------------------------------------------------------------------------


								$initialGrade = array();
								$transmutedGrade = array();
								$initialGrade[$index] = ($wsScoreWW[$index] + $wsScorePT[$index] + $wsScoreQA[$index]);
						
								foreach($transmutation as $transmute) {
									if($transmute->lowScore <= $initialGrade[$index] && $transmute->highScore >= $initialGrade[$index]) {
										$transmutedGrade[$index] = $transmute->transmutedScore;
									}
								}	
					$message = $message . '<td align="right">' . $initialGrade[$index] . '</td>';
					$message = $message . '<td align="right">' . $transmutedGrade[$index] . '</td>';
					$message = $message . '</tr>';		
					$message = $message . '</table>';		

					$message = $message . '<table><tr><td></br></td></tr></table>';		
						
							}
							
					} //foreach($subjectSectionList)		
					//echo $message
					//echo $subj;		
							
							
							
							
							
					$emailSent = $this->_sendMail($toEmail =$emailAddress, $subject = "Grades Request", $message);
					if(!$emailSent) {
						//$this->session->set_flashdata('emailSent', '1');
						//echo "HELLO";
					} else {
						//$this->session->set_flashdata('emailSent', '1');
						//$this->session->set_flashdata('emailAddress', $emailAddress);
						//redirect(base_url().'user-acct/sign-in');

					}
						
		}
		
		
		
	}
	
	
	
	public function getEnrolledK12StudentsEGIS() {
		
		$sectionCode = $_GET['sectionCode'];
		//$sectionCode = '1001 5-HUMILITY';
		$gradingPeriod = $_SESSION['gP'];		
		$results1 = null;
		
		if($gradingPeriod == 1) {
			$selectFields =  "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			$results1 = $this->_getRecordsData($data = array($selectFields), 
				$tables = array('triune_grades_score_sheet_1', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode' ), $where = array($_SESSION['sy'], $sectionCode), 
				$join = array('triune_grades_score_sheet_1.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('lastName', 'firstName'), $sortOrder = array('asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 2) {
			$selectFields =  "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName";
			$results1 = $this->_getRecordsData($data = array($selectFields), 
				$tables = array('triune_grades_score_sheet_2', 'triune_students_k12'), 
				$fieldName = array('sy', 'sectionCode' ), $where = array($_SESSION['sy'], $sectionCode), 
				$join = array('triune_grades_score_sheet_2.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
				$sortBy = array('lastName', 'firstName'), $sortOrder = array('asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		}
		
		echo json_encode($results1);
		
			
	}
	
	public function getGradesRequestFlagEGIS() {
		$allowStatus = $this->_getRecordsData($dataSelect = array('*'), 
			$tables = array('triune_grades_request_flag'),  $fieldName = null, $where = null, $join = null, 
			$joinType =null, $sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
		echo json_encode($allowStatus);	
	}


	public function updateAllowStatusEGIS() {
		$status = $_POST["status"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "EGIS";
		$moduleName = "GRADESREQUESTSTATUSUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'status' => $status,
			);
		
			$this->_updateRecords($tableName = 'triune_grades_request_flag', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Grades Request Status";
			$for1 = $status . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $status;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_grades_request_flag-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_grades_request_flag ";
		$text1 = $text1 .  "SET status = '" .  $status . "', ";
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


	public function getGradesPostingEGIS() {
		$allowStatus = null;
		$gradingPeriod = $_SESSION['gP'];		

		if($gradingPeriod == 1) {
			$allowStatus = $this->_getRecordsData($dataSelect = array('*'), 
				$tables = array('triune_grades_score_sheet_1_status'),  $fieldName = null, $where = null, $join = null, 
				$joinType =null, $sortBy = array('sectionCode', 'subjectCode'), $sortOrder = array('asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == 2) {
			$allowStatus = $this->_getRecordsData($dataSelect = array('*'), 
				$tables = array('triune_grades_score_sheet_2_status'),  $fieldName = null, $where = null, $join = null, 
				$joinType =null, $sortBy = array('sectionCode', 'subjectCode'), $sortOrder = array('asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		}
		
		echo json_encode($allowStatus);	
	}
	

	public function updateGradesPostingsEGIS() {
		$status = $_POST["status"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

		$gradingPeriod = $_SESSION['gP'];		
	
		$systemForAuditName = "EGIS";
		$moduleName = "UNPOSTGRADESPOSTINGUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'status' => $status,
			);
		
			if($status == 0) {
				if($gradingPeriod == 1) {
					$this->_updateRecords($tableName = 'triune_grades_score_sheet_1_status', 
					$fieldName = array('ID'), 
					$where = array($ID), $recordUpdate);
				} elseif($gradingPeriod == 2) {
					$this->_updateRecords($tableName = 'triune_grades_score_sheet_2_status', 
					$fieldName = array('ID'), 
					$where = array($ID), $recordUpdate);
				}
			}

			
			$actionName1 = "Update Unpost Grades status";
			$for1 = $status . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $status;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_grades_score_sheet_1_status-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_grades_score_sheet_1_status ";
		$text1 = $text1 .  "SET status = '" .  $status . "', ";
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

	public function getYearLevelEGIS() {
		$yearLevel = $this->_getRecordsData($dataSelect = array('*'), 
			$tables = array('triune_yearlevel_k12'),  $fieldName = null, $where = null, $join = null, 
			$joinType =null, $sortBy = array('yearLevel'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
		echo json_encode($yearLevel);	
	}





	public function updateEmailAddress() {
		$this->form_validation->set_rules('emailAddress', 'Email Address', 'required|valid_email');  
		$emailAddress = $this->input->post('emailAddress');
		$userName = $this->_getUserName(1);
		if ($this->form_validation->run() == FALSE) {   

			//$this->session->set_flashdata('msg', 'All fields are required to be proper. Please try again!');
			//redirect(base_url().'user-acct/sign-up');
		}else{    
			

			$emailAddressExist = $userRecord = $this->_getRecordsData($data = array('emailAddress'), $tables = array('triune_user'), $fieldName = array('emailAddress'), $where = array($emailAddress), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
	
			 if(!empty($emailAddressExist)) {
				
				//$this->session->set_flashdata('msg', 'Email Address Already Exist!');
				//redirect(base_url().'user-acct/sign-up');
				
			} else {

			$this->db->trans_start();

				$recordUpdate = array(
					'emailAddress' => $emailAddress,
				);
			
				$this->_updateRecords($tableName = 'triune_user', 
				$fieldName = array('userName'), 
				$where = array($userName), $recordUpdate);

			$this->db->trans_complete();
			
			}           
		}
		$this->session->set_userdata('emailAddress', $emailAddress);
		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}









	
}