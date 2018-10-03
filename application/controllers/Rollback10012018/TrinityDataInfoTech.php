<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityDataInfoTech extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: InfoTech Data Controller.  
	 * DATE CREATED: July 23, 2018
     * DATE UPDATED: July 23, 2018
	 */
	var	$LOGFOLDER = 'ictjrs';

    function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('form_validation'); 
    }//function __construct()


	public function validateRequestICTJRS() {

		$this->form_validation->set_rules('requestSummary', 'Request Summary', 'required');
		$this->form_validation->set_rules('requestDetails', 'Request Details', 'required');  
		$this->form_validation->set_rules('requestType', 'Room Number', 'required');    

		$requestSummary = $_POST["requestSummary"];
		$requestDetails = $_POST["requestDetails"];
		$requestType = $_POST["requestType"];

		$this->session->set_flashdata('requestSummary', $requestSummary);
		$this->session->set_flashdata('requestDetails', $requestDetails);
		$this->session->set_flashdata('requestType', $requestType);


		if ($this->form_validation->run() == FALSE) {   
			echo json_encode($this->form_validation->error_array());
		}else{    

			$resultsRT = $this->_getRecordsData($data = array('requestTypeCode'), 
			$tables = array('triune_request_type_reference'), $fieldName = array('requestTypeCode'), $where = array($requestType), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


			$notExistMessage = array();
			if(empty($resultsRT)) {
				$notExistMessage["resultsRTNotExist"] = "No reference for request type in the database!";
			} 
			
			if(count($notExistMessage) > 0) {
				echo json_encode($notExistMessage);
			} elseif(count($notExistMessage) == 0) {

					$returnValue = array();
					
					$returnValue['requestSummary'] = $requestSummary;
					$returnValue['requestDetails'] = $requestDetails;
					$returnValue['requestType'] = $requestType;

					$returnValue['success'] = 1;
					echo json_encode($returnValue);
				//}
			}
			
		}	

	}

	
	public function insertRequestICTJRS() {
		$requestSummary = $_POST["requestSummary"];
		$requestDetails = $_POST["requestDetails"];
		$requestType = $_POST["requestType"];

		//$requestSummary = '$_POST["requestSummary"]';
		//$requestDetails = '$_POST["requestDetails"]';
		//$requestType = 'CCTA';

		
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('requestSummary'), 
		$tables = array('triune_job_request_transaction_ict'), 
		$fieldName = array('requestSummary', 'requestDetails', 'requestType', 'userName'), 
		$where = array($requestSummary, $requestDetails, $requestType, $userName), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		

		if(empty($transactionExist)) {

		
			$results2 = $this->_getRecordsData($rec = array('triune_employee_data.*'), 
			$tables = array('triune_user', 'triune_employee_data'), 
			$fieldName = array('triune_user.userName'), $where = array($userName), 
			$join = array('triune_user.userNumber = triune_employee_data.employeeNumber'), $joinType = array('left'), $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );

			$departmentUnit = $results2[0]->currentDepartment;
		

			$requestTypeRec = $this->_getRecordsData($data = array('serviceLevelAgreementPeriod', 'responsibleResource'), 
			$tables = array('triune_request_type_reference'), 
			$fieldName = array('requestTypeCode'), 
			$where = array($requestType), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$responsibleResource = $requestTypeRec[0]->responsibleResource;
			$serviceLevelAgreementPeriod = $requestTypeRec[0]->serviceLevelAgreementPeriod;
			
			$dateNeeded = null;
			if($serviceLevelAgreementPeriod > 0) {
				$currentDate = $this->_getCurrentDate();
				$dateNeeded = $this->_endDateAutoAssignSLA($serviceLevelAgreementPeriod, $currentDate);
			}

			$assignedTo = $this->_getResponsibleResource($requestType);
			
			
			
			$systemForAuditName = "ICTJRS";
			$moduleName = "REQUESTCREATE";

			$insertData1 = null;
			$insertData1 = array(
				'requestSummary' => $requestSummary,
				'requestDetails' => $requestDetails,
				'requestStatus' => $this->_getRequestStatus('NEW', 'ICTJRS'),
				'requestType' => $requestType,
				'departmentUnit' => $departmentUnit,
				'assignedTo' => $assignedTo,
				'dateNeeded' => $dateNeeded,
				'dateCreated' => $this->_getCurrentDate(),
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 

			$this->db->trans_start();
				$insertedRecord1 = $this->_insertRecords($tableName = 'triune_job_request_transaction_ict', $insertData1);        			 

				/*$insertedRecord1 = $this->_getRecordsData($data = array('ID'), 
				$tables = array('triune_job_request_transaction_ict'), 
				$fieldName = array('requestPurpose', 'requestRemarks', 'dateNeeded', 'userName'), 
				$where = array($requestPurpose, $requestRemarks, $dateNeeded, $userName), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				*/
				
				$actionName1 = "Insert New Transaction Request";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		


			$insertData2 = null;
			$insertData2 = array(
				'requestNumber' =>$insertedRecord1,
				'requestStatus' => $this->_getRequestStatus('NEW', 'ICTJRS'),
				'assignedTo' => $assignedTo,
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 

				$insertedRecord2 = $this->_insertRecords($tableName = 'triune_job_request_transaction_ict_status_history', $insertData2);        			 

				/*$insertedRecord2 = $this->_getRecordsData($data = array('ID'), 
				$tables = array('triune_job_request_transaction_ict_status_history'), 
				$fieldName = array('requestNumber', 'requestStatus', 'userName'), 
				$where = array($insertedRecord1, $this->_getRequestStatus('NEW', 'ICTJRS'), $userName), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );*/

				$actionName2 = "Insert New Transaction Request Status History";
				$for2 = $insertedRecord1 . ";" .$userName;
				$oldValue2 = null;
				$newValue2 =  $insertData2;
				$userType = 1; 
				$this->_insertAuditTrail($actionName2, $systemForAuditName, $moduleName, $for2, $oldValue2, $newValue2, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_job_request_transaction_ict-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_ict ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$requestSummary . "', ";
			$text1 = $text1 .  "'".$requestDetails . "', ";
			$text1 = $text1 .  "'".$this->_getRequestStatus('NEW', 'ICTJRS') . "', ";
			$text1 = $text1 .  "'".$requestType . "', ";
			$text1 = $text1 .  "'".$departmentUnit . "', ";
			$text1 = $text1 .  "'".$assignedTo . "', ";
			$text1 = $text1 .  "'', ";
			$text1 = $text1 .  "'".$dateNeeded . "', ";
			$text1 = $text1 .  "'".$this->_getCurrentDate();
			$text1 = $text1 .  "'', ";
			$text1 = $text1 .  "'".$userName;
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp();
			$text1 = $text1 .  "'".$userName;
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

			$fileName2 = "triune_job_request_transaction_ict_status_history-" . $this->_getCurrentDate();
			$text2 = "INSERT INTO triune_job_request_transaction_ict_status_history ";
			$text2 = $text2 .  "VALUES (" .  $insertedRecord2 . ", ";
			$text2 = $text2 .  "'".$insertedRecord1 . "', ";
			$text2 = $text2 .  "'".$this->_getRequestStatus('NEW', 'ICTJRS') . "', ";
			$text1 = $text1 .  "'', ";
			$text1 = $text1 .  "'".$assignedTo . "', ";
			$text2 = $text2 .  "'".$userName . "', ";
			$text2 = $text2 .  "'".$this->_getIPAddress() . "', ";
			$text2 = $text2 .  "'".$this->_getTimeStamp() . "', ";
			$text2 = $text2 .  "'".$userName;
			$text2 = $text2 . "');";
			$this->_insertTextLog($fileName2, $text2,  $this->LOGFOLDER);
			

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
			$returnValue['ID'] = $insertedRecord1;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} //if(empty($transactionExist))

	}
	
	
	
}