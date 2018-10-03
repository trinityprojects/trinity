<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityDataK12Records extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: K12Records Data Controller. Included 
	 * DATE CREATED: August 14, 2018
     * DATE UPDATED: August 14, 2018
	 */

	var	$LOGFOLDER = 'k12records';

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function getSeniorHighCourseListK12Records() {
		$selectFields = "triune_section_senior_high.courseCode";

		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_senior_high'), $fieldName = array('sy', 'sem'), $where = array($_SESSION['sy'], 'A'), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }


	
    public function getSeniorHighStudentsListK12Records() {
		$courseCode = $_GET["courseCode"];
		
		
		$selectFields = "triune_students_k12.studentNumber,  ";
		$selectFields = $selectFields . "concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName, ";
		$selectFields = $selectFields . "triune_student_roster_senior_high.sectionCode";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_student_roster_senior_high', 'triune_students_k12'), $fieldName = array('sy', 'triune_student_roster_senior_high.courseCode'), $where = array($_SESSION['sy'], $courseCode), 
			$join = array('triune_student_roster_senior_high.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
			$sortBy = array('triune_student_roster_senior_high.sectionCode', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }
	

    public function getSectionByCourseSHK12Records() {
		$courseCode = $_GET["courseCode"];
		
		
		$selectFields = "triune_section_senior_high.sectionCode";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_senior_high'), $fieldName = array('sy', 'triune_section_senior_high.courseCode'), $where = array($_SESSION['sy'], $courseCode), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }



	public function updateSectioningSeniorHighK12Records() {
		$row = $_POST["row"];
		$i = $_POST["i"];
		$userName = $this->_getUserName(1);

	
		//$systemForAuditName = "EGIS";
		//$moduleName = "FIRSTGRADINGSCORESHEETUPDATE";

		$this->db->trans_start();

			$recordUpdate1 = array(
				'sectionCode' => $row['sectionCode'],
			);

			$this->_updateRecords($tableName1 = 'triune_student_roster_senior_high', 
			$fieldName1 = array('studentNumber'), 
			$where1 = array($row['studentNumber']), $recordUpdate1);

			//$actionName1 = "Update Elementary Section";
			//$for1 = $employeeNumber . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $employeeNumber;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			
			$recordUpdate2 = array(
				'sectionCode' => $row['sectionCode'],
			);

			$this->_updateRecords($tableName2 = 'triune_grades_score_sheet_1', 
			$fieldName2 = array('studentNumber'), 
			$where2 = array($row['studentNumber']), $recordUpdate2);
			
			
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


    public function getJuniorHighCourseListK12Records() {
		$selectFields = "triune_section_junior_high.yearLevel";

		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_junior_high'), $fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }

    public function getJuniorHighStudentsListK12Records() {
		$yearLevel = $_GET["yearLevel"];
		
		
		$selectFields = "triune_students_k12.studentNumber,  ";
		$selectFields = $selectFields . "concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', triune_students_k12.middleName) as fullName, ";
		$selectFields = $selectFields . "triune_student_roster_junior_high.sectionCode";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_student_roster_junior_high', 'triune_students_k12'), $fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = array('triune_student_roster_junior_high.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
			$sortBy = array('triune_student_roster_junior_high.sectionCode', 'lastName', 'firstName'), $sortOrder = array('asc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array("SUBSTR(triune_student_roster_junior_high.sectionCode, 6, 1) = " . $yearLevel ), $groupBy = null );

			echo json_encode($results);
    }

	public function updateSectioningJuniorHighK12Records() {
		$row = $_POST["row"];
		$i = $_POST["i"];
		$userName = $this->_getUserName(1);

	
		//$systemForAuditName = "EGIS";
		//$moduleName = "FIRSTGRADINGSCORESHEETUPDATE";

		$this->db->trans_start();

			$recordUpdate1 = array(
				'sectionCode' => $row['sectionCode'],
			);

			$this->_updateRecords($tableName1 = 'triune_student_roster_junior_high', 
			$fieldName1 = array('studentNumber'), 
			$where1 = array($row['studentNumber']), $recordUpdate1);

			//$actionName1 = "Update Elementary Section";
			//$for1 = $employeeNumber . ";" . $userName;
			//$oldValue1 = null;
			//$newValue1 =  $employeeNumber;
			//$userType = 1;
			//$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			
			$recordUpdate2 = array(
				'sectionCode' => $row['sectionCode'],
			);

			$this->_updateRecords($tableName2 = 'triune_grades_score_sheet_1', 
			$fieldName2 = array('studentNumber'), 
			$where2 = array($row['studentNumber']), $recordUpdate2);
			
			
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

    public function getSectionByLevelJHK12Records() {
		$yearLevel = $_GET["yearLevel"];
		
		
		$selectFields = "triune_section_junior_high.sectionCode";
		
		$results = $this->_getRecordsData($data = array($selectFields), 
			$tables = array('triune_section_junior_high'), $fieldName = array('sy', 'triune_section_junior_high.yearLevel'), $where = array($_SESSION['sy'], $yearLevel), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
    }
	
}