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

		$requestStatus = $this->_getRequestStatus('ASSIGNED', 'ICTJRS');
		if($requestType == 'ICWA' || $requestType == 'ICSA') {
			$requestStatus = $this->_getRequestStatus('FOR APPROVAL', 'ICTJRS');
		}
		
		
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
				'sy' => $_SESSION['sy'],
				'requestSummary' => $requestSummary,
				'requestDetails' => $requestDetails,
				'requestStatus' => $requestStatus,
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

				
				$actionName1 = "Insert New Transaction Request";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		


			$insertData2 = null;
			$insertData2 = array(
				'sy' => $_SESSION['sy'],
				'requestNumber' =>$insertedRecord1,
				'requestStatus' => $requestStatus,
				'assignedTo' => ltrim($assignedTo),
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
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
			$text1 = $text1 .  "'".$requestSummary . "', ";
			$text1 = $text1 .  "'".$requestDetails . "', ";
			$text1 = $text1 .  "'".$requestStatus . "', ";
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
			$text2 = $text2 .  "'".$_SESSION['sy'] . "', ";
			$text2 = $text2 .  "'".$insertedRecord1 . "', ";
			$text2 = $text2 .  "'".$requestStatus . "', ";
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

			//$rE = $this->_getRecordsData($data = array('triune_user.emailAddress'), 
			//$tables = array('triune_user'), $fieldName = array('triune_user.userNumber'), $where = array($assignedTo), 
			//$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 	$limit = null, 	$fieldNameLike = null, $like = null, 
			//$whereSpecial = null, $groupBy = null );
			
			//$receiverEmail =  $rE[0]->emailAddress;
			//$receiverEmail = 'rdlagdaan@tua.edu.ph';
			
            //$message = '';                     
            //$message .= '<strong>New ICTJRS Request from user ' . $userName . ' for<u> ' . $requestSummary . '</u></strong><br>';
            //$message .= '<strong>Request Type<u> ' . $requestType . '</u></strong><br>';
            //$message .= '<strong>With the following details: <u>' . $requestDetails . '</u></strong><br>';
 
					
			//$emailSent = $this->_sendMail($toEmail = $receiverEmail, $subject = "Email Notification from: " . $userName . "(ASSIGNED)" , $message);
            //if($emailSent) {
                //$this->session->set_flashdata('emailSent', '1');
                //echo "HELLO";
				$returnValue = array();
				$returnValue['ID'] = $insertedRecord1;
				$returnValue['requestType'] = $requestType;		
				$returnValue['requestSummary'] = $requestSummary;				
				$returnValue['success'] = 1;
				echo json_encode($returnValue);
				
            //} else {
            //    $this->session->set_flashdata('emailSent', '0');
			//	$returnValue = array();
			//	$returnValue['ID'] = $insertedRecord1;
			//	$returnValue['requestType'] = $requestType;				
			//	$returnValue['success'] = 0;
			//	echo json_encode($returnValue);
				
                //redirect(base_url().'user-acct/sign-up');
            //}
			
			
			//$returnValue = array();
			//$returnValue['ID'] = $insertedRecord1;
			//$returnValue['success'] = 1;
			//echo json_encode($returnValue);

		} //if(empty($transactionExist))

	}
	

    public function getWorkstationInventoryICTJRS() {
		
		$selectField = "triune_inventory_workstation.*, concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName, ';', triune_employee_data.employeeNumber) as fullName";
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_inventory_workstation', 'triune_employee_data'), 
			$fieldName = null, $where = null, 
			$join = array('triune_inventory_workstation.assignedTo = triune_employee_data.employeeNumber'), $joinType = array('left'), 
			$sortBy = array('hardwareSpecs'), $sortOrder = array('desc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results1);
    }	



	public function insertWorkstationInventoryICTJRS() {
		$roomNumber = $_POST["roomNumber"];
		$assignedToFull = $_POST["assignedTo"];
		$hardwareSpecs = $_POST["hardwareSpecs"];
		$peripheralsSpecs = $_POST["peripheralsSpecs"];
		$printerSpecs = $_POST["printerSpecs"];
		
		$systemSoftwareSpecs = $_POST["systemSoftwareSpecs"];
		$applicationSoftwareSpecs = $_POST["applicationSoftwareSpecs"];
		$processorSpecs = $_POST["processorSpecs"];
		$hardDiskSpecs = $_POST["hardDiskSpecs"];
		$memorySpecs = $_POST["memorySpecs"];
		
		$monitorSpecs = $_POST["monitorSpecs"];
		$mouseSpecs = $_POST["mouseSpecs"];
		$keyboardSpecs = $_POST["keyboardSpecs"];
		$internetAccessFlag = $_POST["internetAccessFlag"];
		$iPAddress = $_POST["iPAddress"];
		
		$subnetMask = $_POST["subnetMask"];
		$defaultGateway = $_POST["defaultGateway"];
		$dNS = $_POST["dNS"];

		$assignedTemp = explode(";", $assignedToFull);
		$assignedTo = $assignedTemp[1];
		
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_inventory_workstation'), $fieldName = array('roomNumber', 'assignedTo', 'hardwareSpecs'), 
		$where = array($roomNumber, $assignedTo, $hardwareSpecs), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$systemForAuditName = "ICTJRS";
			$moduleName = "WORKSTATIONINVENTORYCREATE";
			
			
			$insertData1 = null;
			$insertData1 = array(
				'roomNumber' => $roomNumber,
				'assignedTo' => $assignedTo,
				'hardwareSpecs' => $hardwareSpecs,
				'peripheralsSpecs' => $peripheralsSpecs,
				'printerSpecs' => $printerSpecs,
				'systemSoftwareSpecs' => $systemSoftwareSpecs,
				'applicationSoftwareSpecs' => $applicationSoftwareSpecs,
				'processorSpecs' => $processorSpecs,
				'hardDiskSpecs' => $hardDiskSpecs,
				'memorySpecs' => $memorySpecs,
				'monitorSpecs' => $monitorSpecs,
				'mouseSpecs' => $mouseSpecs,
				'keyboardSpecs' => $keyboardSpecs,
				'internetAccessFlag' => $internetAccessFlag,
				'iPAddress' => $iPAddress,
				'subnetMask' => $subnetMask,
				'defaultGateway' => $defaultGateway,
				'dNS' => $dNS,
				'workstationID' => $this->_getIPAddress(),
				'userName' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_inventory_workstation', $insertData1);        			 


				$actionName1 = "Insert Workstation Inventory";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_inventory_workstation-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_inventory_workstation ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$roomNumber . "', ";
			$text1 = $text1 .  "'".$assignedTo . "', ";
			$text1 = $text1 .  "'".$hardwareSpecs . "', ";
			$text1 = $text1 .  "'".$peripheralsSpecs . "', ";
			$text1 = $text1 .  "'".$printerSpecs . "', ";
			$text1 = $text1 .  "'".$systemSoftwareSpecs . "', ";
			$text1 = $text1 .  "'".$applicationSoftwareSpecs . "', ";
			$text1 = $text1 .  "'".$processorSpecs . "', ";
			$text1 = $text1 .  "'".$hardDiskSpecs . "', ";
			$text1 = $text1 .  "'".$memorySpecs . "', ";
			$text1 = $text1 .  "'".$monitorSpecs . "', ";
			$text1 = $text1 .  "'".$mouseSpecs . "', ";
			$text1 = $text1 .  "'".$keyboardSpecs . "', ";
			$text1 = $text1 .  "'".$internetAccessFlag . "', ";
			$text1 = $text1 .  "'".$iPAddress . "', ";
			$text1 = $text1 .  "'".$subnetMask . "', ";
			$text1 = $text1 .  "'".$defaultGateway . "', ";
			$text1 = $text1 .  "'".$dNS . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
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
	
	public function deleteWorkstationInventoryICTJRS() {
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


	public function updateWorkstationInventoryICTJRS() {
		$roomNumber = $_POST["roomNumber"];
		$assignedToFull = $_POST["assignedTo"];
		$hardwareSpecs = $_POST["hardwareSpecs"];
		$peripheralsSpecs = $_POST["peripheralsSpecs"];
		$printerSpecs = $_POST["printerSpecs"];
		
		$systemSoftwareSpecs = $_POST["systemSoftwareSpecs"];
		$applicationSoftwareSpecs = $_POST["applicationSoftwareSpecs"];
		$processorSpecs = $_POST["processorSpecs"];
		$hardDiskSpecs = $_POST["hardDiskSpecs"];
		$memorySpecs = $_POST["memorySpecs"];
		
		$monitorSpecs = $_POST["monitorSpecs"];
		$mouseSpecs = $_POST["mouseSpecs"];
		$keyboardSpecs = $_POST["keyboardSpecs"];
		$internetAccessFlag = $_POST["internetAccessFlag"];
		$iPAddress = $_POST["iPAddress"];
		
		$subnetMask = $_POST["subnetMask"];
		$defaultGateway = $_POST["defaultGateway"];
		$dNS = $_POST["dNS"];

		$assignedTemp = explode(";", $assignedToFull);
		$assignedTo = $assignedTemp[1];

		$ID = $_POST["ID"];

		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "ICTJRS";
		$moduleName = "WORKSTATIONINVENTORYUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'roomNumber' => $roomNumber,
				'assignedTo' => $assignedTo,
				'hardwareSpecs' => $hardwareSpecs,
				'peripheralsSpecs' => $peripheralsSpecs,
				'printerSpecs' => $printerSpecs,
				'systemSoftwareSpecs' => $systemSoftwareSpecs,
				'applicationSoftwareSpecs' => $applicationSoftwareSpecs,
				'processorSpecs' => $processorSpecs,
				'hardDiskSpecs' => $hardDiskSpecs,
				'memorySpecs' => $memorySpecs,
				'monitorSpecs' => $monitorSpecs,
				'mouseSpecs' => $mouseSpecs,
				'keyboardSpecs' => $keyboardSpecs,
				'internetAccessFlag' => $internetAccessFlag,
				'iPAddress' => $iPAddress,
				'subnetMask' => $subnetMask,
				'defaultGateway' => $defaultGateway,
				'dNS' => $dNS,
				'workstationID' => $this->_getIPAddress(),
				'userName' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);
		
			$this->_updateRecords($tableName = 'triune_inventory_workstation', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Workstation Inventory";
			$for1 =  $userName;
			$oldValue1 = null;
			$newValue1 =  $recordUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			
		$this->db->trans_complete();

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_inventory_workstation'), $fieldName = array('ID'), 
		$where = array($ID), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
	
		$fileName1 = "triune_inventory_workstation-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_inventory_workstation ";
		$text1 = $text1 .  "SET roomNumber = '" .  $record[0]->roomNumber . "', ";
		$text1 = $text1 .  "assignedTo = '" .  $record[0]->assignedTo . "', ";
		$text1 = $text1 .  "hardwareSpecs = '" .  $record[0]->hardwareSpecs . "' ";
		$text1 = $text1 .  "peripheralsSpecs = '" .  $record[0]->peripheralsSpecs . "' ";
		$text1 = $text1 .  "printerSpecs = '" .  $record[0]->printerSpecs . "', ";
		$text1 = $text1 .  "systemSoftwareSpecs = '" .  $record[0]->systemSoftwareSpecs . "', ";
		$text1 = $text1 .  "applicationSoftwareSpecs = '" .  $record[0]->applicationSoftwareSpecs . "' ";
		$text1 = $text1 .  "processorSpecs = '" .  $record[0]->processorSpecs . "' ";
		$text1 = $text1 .  "hardDiskSpecs = '" .  $record[0]->hardDiskSpecs . "', ";
		$text1 = $text1 .  "memorySpecs = '" .  $record[0]->memorySpecs . "', ";
		$text1 = $text1 .  "monitorSpecs = '" .  $record[0]->monitorSpecs . "' ";
		$text1 = $text1 .  "mouseSpecs = '" .  $record[0]->mouseSpecs . "' ";
		$text1 = $text1 .  "keyboardSpecs = '" .  $record[0]->keyboardSpecs . "' ";
		$text1 = $text1 .  "internetAccessFlag = '" .  $record[0]->internetAccessFlag . "', ";
		$text1 = $text1 .  "iPAddress = '" .  $record[0]->iPAddress . "', ";
		$text1 = $text1 .  "defaultGateway = '" .  $record[0]->defaultGateway . "' ";
		$text1 = $text1 .  "dNS = '" .  $record[0]->dNS . "' ";
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



    public function getLCDInventoryICTJRS() {
		$selectField = "triune_inventory_lcd_projector.*";
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_inventory_lcd_projector'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('locationCode', 'floor'), $sortOrder = array('asc', 'asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }	



	public function insertLCDInventoryICTJRS() {
		$roomNumber = $_POST["roomNumber"];
		$projectorBrand = $_POST["projectorBrand"];
		$projectorModel = $_POST["projectorModel"];
		$projectorLampLimit = $_POST["projectorLampLimit"];
		$projectorLampCounter = $_POST["projectorLampCounter"];
		$screenBrand = $_POST["screenBrand"];
		$notes = $_POST["notes"];
		
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_inventory_lcd_projector'), $fieldName = array('roomNumber', 'projectorBrand', 'projectorModel'), 
		$where = array($roomNumber, $projectorBrand, $projectorModel), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$systemForAuditName = "ICTJRS";
			$moduleName = "LCDINVENTORYCREATE";
			

			$location = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_rooms'), $fieldName = array('roomNumber'), 
			$where = array($roomNumber), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$floor = null;
			$locationCode = null;
			if(!empty($location)) {
				$floor = $location[0]->floor;
				$locationCode = $location[0]->locationCode;
			}
			
			$insertData1 = null;
			$insertData1 = array(
				'roomNumber' => $roomNumber,
				'floor' => $floor,
				'locationCode' => $locationCode,
				'projectorBrand' => $projectorBrand,
				'projectorModel' => $projectorModel,
				'projectorLampLimit' => $projectorLampLimit,
				'projectorLampCounter' => $projectorLampCounter,
				'screenBrand' => $screenBrand,
				'notes' => $notes,
				'updatedBy' => $userName,
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_inventory_lcd_projector', $insertData1);        			 


				$actionName1 = "Insert LCD Inventory";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_inventory_lcd_projector-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_inventory_lcd_projector ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$floor . "', ";
			$text1 = $text1 .  "'".$locationCode . "', ";
			$text1 = $text1 .  "'".$projectorBrand . "', ";
			$text1 = $text1 .  "'".$projectorModel . "', ";
			$text1 = $text1 .  "'".$projectorLampLimit . "', ";
			$text1 = $text1 .  "'".$projectorLampCounter . "', ";
			$text1 = $text1 .  "'".$screenBrand . "', ";
			$text1 = $text1 .  "'".$notes . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
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


	public function updateLCDInventoryICTJRS() {
		$roomNumber = $_POST["roomNumber"];
		$projectorBrand = $_POST["projectorBrand"];
		$projectorModel = $_POST["projectorModel"];
		$projectorLampLimit = $_POST["projectorLampLimit"];
		$projectorLampCounter = $_POST["projectorLampCounter"];
		$screenBrand = $_POST["screenBrand"];
		$notes = $_POST["notes"];

		$ID = $_POST["ID"];

		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "ICTJRS";
		$moduleName = "LCDINVENTORYUPDATE";

		$this->db->trans_start();

			$location = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_rooms'), $fieldName = array('roomNumber'), 
			$where = array($roomNumber), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$floor = null;
			$locationCode = null;
			if(!empty($location)) {
				$floor = $location[0]->floor;
				$locationCode = $location[0]->locationCode;
			}
		
		
			$recordUpdate = array(
				'roomNumber' => $roomNumber,
				'floor' => $floor,
				'locationCode' => $locationCode,
				'projectorBrand' => $projectorBrand,
				'projectorModel' => $projectorModel,
				'projectorLampLimit' => $projectorLampLimit,
				'projectorLampCounter' => $projectorLampCounter,
				'screenBrand' => $screenBrand,
				'notes' => $notes,
				'updatedBy' => $userName,
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);
		
			$this->_updateRecords($tableName = 'triune_inventory_lcd_projector', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update LCD Inventory";
			$for1 =  $userName;
			$oldValue1 = null;
			$newValue1 =  $recordUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			
		$this->db->trans_complete();

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_inventory_lcd_projector'), $fieldName = array('ID'), 
		$where = array($ID), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
	
		$fileName1 = "triune_inventory_lcd_projector-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_inventory_lcd_projector ";
		$text1 = $text1 .  "SET roomNumber = '" .  $record[0]->roomNumber . "', ";
		$text1 = $text1 .  "floor = '" .  $record[0]->floor . "', ";
		$text1 = $text1 .  "locationCode = '" .  $record[0]->locationCode . "' ";
		$text1 = $text1 .  "projectorBrand = '" .  $record[0]->projectorBrand . "' ";
		$text1 = $text1 .  "projectorModel = '" .  $record[0]->projectorModel . "' ";
		$text1 = $text1 .  "projectorLampLimit = '" .  $record[0]->projectorLampLimit . "', ";
		$text1 = $text1 .  "projectorLampCounter = '" .  $record[0]->projectorLampCounter . "', ";
		$text1 = $text1 .  "screenBrand = '" .  $record[0]->screenBrand . "' ";
		$text1 = $text1 .  "notes = '" .  $record[0]->notes . "' ";
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
	

    public function getTelephoneInventoryICTJRS() {
		$selectField = "triune_inventory_telephone.*";
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_inventory_telephone'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('locationCode', 'floor'), $sortOrder = array('asc', 'asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }	

	
	
	public function insertTelephoneInventoryICTJRS() {
		$roomNumber = $_POST["roomNumber"];
		$phoneUser = $_POST["phoneUser"];
		$phoneNumber = $_POST["phoneNumber"];
		
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_inventory_telephone'), $fieldName = array('roomNumber', 'phoneUser', 'phoneNumber'), 
		$where = array($roomNumber, $phoneUser, $phoneNumber), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$systemForAuditName = "ICTJRS";
			$moduleName = "TELEPHONEINVENTORYCREATE";
			

			$location = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_rooms'), $fieldName = array('roomNumber'), 
			$where = array($roomNumber), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$floor = null;
			$locationCode = null;
			if(!empty($location)) {
				$floor = $location[0]->floor;
				$locationCode = $location[0]->locationCode;
			}
			
			$insertData1 = null;
			$insertData1 = array(
				'roomNumber' => $roomNumber,
				'floor' => $floor,
				'locationCode' => $locationCode,
				'phoneUser' => $phoneUser,
				'phoneNumber' => $phoneNumber,
				'workstationID' => $this->_getIPAddress(),
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_inventory_telephone', $insertData1);        			 


				$actionName1 = "Insert Telephone Inventory";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_inventory_telephone-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_inventory_telephone ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$floor . "', ";
			$text1 = $text1 .  "'".$locationCode . "', ";
			$text1 = $text1 .  "'".$phoneUser . "', ";
			$text1 = $text1 .  "'".$phoneNumber . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
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


	public function updateTelephoneInventoryICTJRS() {
		$roomNumber = $_POST["roomNumber"];
		$phoneUser = $_POST["phoneUser"];
		$phoneNumber = $_POST["phoneNumber"];

		$ID = $_POST["ID"];

		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "ICTJRS";
		$moduleName = "TELEPHONEINVENTORYUPDATE";

		$this->db->trans_start();

			$location = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_rooms'), $fieldName = array('roomNumber'), 
			$where = array($roomNumber), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$floor = null;
			$locationCode = null;
			if(!empty($location)) {
				$floor = $location[0]->floor;
				$locationCode = $location[0]->locationCode;
			}
		
		
			$recordUpdate = array(
				'roomNumber' => $roomNumber,
				'floor' => $floor,
				'locationCode' => $locationCode,
				'phoneUser' => $phoneUser,
				'phoneNumber' => $phoneNumber,
				'workstationID' => $this->_getIPAddress(),
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);
		
			$this->_updateRecords($tableName = 'triune_inventory_telephone', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Telephone Inventory";
			$for1 =  $userName;
			$oldValue1 = null;
			$newValue1 =  $recordUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			
		$this->db->trans_complete();

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_inventory_telephone'), $fieldName = array('ID'), 
		$where = array($ID), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
	
		$fileName1 = "triune_inventory_telephone-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_inventory_telephone ";
		$text1 = $text1 .  "SET roomNumber = '" .  $record[0]->roomNumber . "', ";
		$text1 = $text1 .  "floor = '" .  $record[0]->floor . "', ";
		$text1 = $text1 .  "locationCode = '" .  $record[0]->locationCode . "' ";
		$text1 = $text1 .  "phoneUser = '" .  $record[0]->phoneUser . "' ";
		$text1 = $text1 .  "phoneNumber = '" .  $record[0]->phoneNumber . "' ";
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

    public function getCCTVInventoryICTJRS() {
		$selectField = "triune_inventory_cctv.*";
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_inventory_cctv'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('jurisdiction', 'location'), $sortOrder = array('asc', 'asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }	




	public function insertCCTVInventoryICTJRS() {
		$location = $_POST["location"];
		$serialNumber = $_POST["serialNumber"];
		$status = $_POST["status"];
		$iPAddress = $_POST["iPAddress"];
		$model = $_POST["model"];
		$jurisdiction = $_POST["jurisdiction"];
		
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_inventory_cctv'), $fieldName = array('location', 'serialNumber', 'iPAddress', 'model'), 
		$where = array($location, $serialNumber, $iPAddress, $model), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$systemForAuditName = "ICTJRS";
			$moduleName = "CCTVINVENTORYCREATE";
			
			$insertData1 = null;
			$insertData1 = array(
				'location' => $location,
				'serialNumber' => $serialNumber,
				'status' => $status,
				'iPAddress' => $iPAddress,
				'model' => $model,
				'jurisdiction' => $jurisdiction,
				'workstationID' => $this->_getIPAddress(),
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_inventory_cctv', $insertData1);        			 


				$actionName1 = "Insert CCTV Inventory";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_inventory_cctv-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_inventory_cctv ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$location . "', ";
			$text1 = $text1 .  "'".$serialNumber . "', ";
			$text1 = $text1 .  "'".$status . "', ";
			$text1 = $text1 .  "'".$iPAddress . "', ";
			$text1 = $text1 .  "'".$model . "', ";
			$text1 = $text1 .  "'".$jurisdiction . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
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


	public function updateCCTVInventoryICTJRS() {
		$location = $_POST["location"];
		$serialNumber = $_POST["serialNumber"];
		$status = $_POST["status"];
		$iPAddress = $_POST["iPAddress"];
		$model = $_POST["model"];
		$jurisdiction = $_POST["jurisdiction"];

		$ID = $_POST["ID"];

		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "ICTJRS";
		$moduleName = "CCTVINVENTORYUPDATE";

		$this->db->trans_start();

		
		
			$recordUpdate = array(
				'location' => $location,
				'serialNumber' => $serialNumber,
				'status' => $status,
				'iPAddress' => $iPAddress,
				'model' => $model,
				'jurisdiction' => $jurisdiction,
				'workstationID' => $this->_getIPAddress(),
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);
		
			$this->_updateRecords($tableName = 'triune_inventory_cctv', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update CCTV Inventory";
			$for1 =  $userName;
			$oldValue1 = null;
			$newValue1 =  $recordUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			
		$this->db->trans_complete();

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_inventory_cctv'), $fieldName = array('ID'), 
		$where = array($ID), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
	
		$fileName1 = "triune_inventory_cctv-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_inventory_cctv ";
		$text1 = $text1 .  "SET location = '" .  $record[0]->location . "', ";
		$text1 = $text1 .  "serialNumber = '" .  $record[0]->serialNumber . "', ";
		$text1 = $text1 .  "status = '" .  $record[0]->status . "' ";
		$text1 = $text1 .  "iPAddress = '" .  $record[0]->iPAddress . "' ";
		$text1 = $text1 .  "model = '" .  $record[0]->model . "' ";
		$text1 = $text1 .  "jurisdiction = '" .  $record[0]->jurisdiction . "' ";
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

    public function getWiFiInventoryICTJRS() {
		$selectField = "triune_inventory_wifi.*";
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_inventory_wifi'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('jurisdiction', 'location'), $sortOrder = array('asc', 'asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }	


	public function insertWIFIInventoryICTJRS() {
		$location = $_POST["location"];
		$floor = $_POST["floor"];
		$wifiName = $_POST["wifiName"];
		$serialNumber = $_POST["serialNumber"];
		$status = $_POST["status"];
		$iPAddress = $_POST["iPAddress"];
		$model = $_POST["model"];
		$jurisdiction = $_POST["jurisdiction"];
		
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('ID'), 
		$tables = array('triune_inventory_wifi'), $fieldName = array('location', 'floor', 'wifiName', 'serialNumber', 'iPAddress', 'model'), 
		$where = array($location, $floor, $wifiName, $serialNumber, $iPAddress, $model), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$systemForAuditName = "ICTJRS";
			$moduleName = "WIFIINVENTORYCREATE";
			
			$insertData1 = null;
			$insertData1 = array(
				'location' => $location,
				'floor' => $floor,
				'wifiName' => $wifiName,
				'serialNumber' => $serialNumber,
				'status' => $status,
				'iPAddress' => $iPAddress,
				'model' => $model,
				'jurisdiction' => $jurisdiction,
				'workstationID' => $this->_getIPAddress(),
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_inventory_wifi', $insertData1);        			 


				$actionName1 = "Insert WIFI Inventory";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_inventory_wifi-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_inventory_wifi ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$location . "', ";
			$text1 = $text1 .  "'".$floor . "', ";
			$text1 = $text1 .  "'".$wifiName . "', ";
			$text1 = $text1 .  "'".$serialNumber . "', ";
			$text1 = $text1 .  "'".$status . "', ";
			$text1 = $text1 .  "'".$iPAddress . "', ";
			$text1 = $text1 .  "'".$model . "', ";
			$text1 = $text1 .  "'".$jurisdiction . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
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


	public function updateWIFIInventoryICTJRS() {
		$location = $_POST["location"];
		$floor = $_POST["floor"];
		$wifiName = $_POST["wifiName"];
		$serialNumber = $_POST["serialNumber"];
		$status = $_POST["status"];
		$iPAddress = $_POST["iPAddress"];
		$model = $_POST["model"];
		$jurisdiction = $_POST["jurisdiction"];

		$ID = $_POST["ID"];

		$userName = $this->_getUserName(1);

	
		$systemForAuditName = "ICTJRS";
		$moduleName = "CCTVINVENTORYUPDATE";

		$this->db->trans_start();

		
		
			$recordUpdate = array(
				'location' => $location,
				'floor' => $floor,
				'wifiName' => $wifiName,
				'serialNumber' => $serialNumber,
				'status' => $status,
				'iPAddress' => $iPAddress,
				'model' => $model,
				'jurisdiction' => $jurisdiction,
				'workstationID' => $this->_getIPAddress(),
				'userNumber' => $userName,
				'timeStamp' => $this->_getTimeStamp(),
			);
		
			$this->_updateRecords($tableName = 'triune_inventory_wifi', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update CCTV Inventory";
			$for1 =  $userName;
			$oldValue1 = null;
			$newValue1 =  $recordUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			
		$this->db->trans_complete();

		$record = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_inventory_wifi'), $fieldName = array('ID'), 
		$where = array($ID), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
	
		$fileName1 = "triune_inventory_wifi-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_inventory_wifi ";
		$text1 = $text1 .  "SET location = '" .  $record[0]->location . "', ";
		$text1 = $text1 .  "floor = '" .  $record[0]->floor . "', ";
		$text1 = $text1 .  "wifiName = '" .  $record[0]->wifiName . "', ";
		$text1 = $text1 .  "serialNumber = '" .  $record[0]->serialNumber . "', ";
		$text1 = $text1 .  "status = '" .  $record[0]->status . "' ";
		$text1 = $text1 .  "iPAddress = '" .  $record[0]->iPAddress . "' ";
		$text1 = $text1 .  "model = '" .  $record[0]->model . "' ";
		$text1 = $text1 .  "jurisdiction = '" .  $record[0]->jurisdiction . "' ";
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



	public function validateRequestItemsICTJRS() {
		$requestType = $_POST["requestType"];
		$item = '';
		$startDate = '';
		$endDate = '';
		
		if($requestType == "CCTA" || $requestType == "GSAS" || $requestType == "HWRS" || $requestType == "LPI"  || $requestType == "PTRS" || $requestType == "SWTI") {
			$this->form_validation->set_rules('itemID', 'itemID', 'required');
			$this->form_validation->set_rules('requestNumber', 'requestNumber', 'required');
			$this->form_validation->set_rules('requestType', 'requestType', 'required');
			$this->form_validation->set_rules('itemDetails', 'itemDetails', 'required');
		} elseif($requestType == "ICWA") {
			$this->form_validation->set_rules('deliveryDate', 'deliveryDate', 'required');
			$this->form_validation->set_rules('otherDetails', 'otherDetails', 'required');
			$this->form_validation->set_rules('location', 'location', 'required');
		} elseif($requestType == "ICSA") {
			$this->form_validation->set_rules('item', 'item', 'required');
			$this->form_validation->set_rules('itemDetails', 'itemDetails', 'required');
			$this->form_validation->set_rules('otherDetails', 'otherDetails', 'required');
			$this->form_validation->set_rules('startDate', 'startDate', 'required');
			$this->form_validation->set_rules('endDate', 'endDate', 'required');
		
			$item = $_POST["item"];
			$startDate = $_POST["startDate"];
			$endDate = $_POST["endDate"];
			
			$this->session->set_flashdata('item', $item);
			$this->session->set_flashdata('startDate', $startDate);
			$this->session->set_flashdata('endDate', $endDate);
			
		}

		$itemID = $_POST["itemID"];
		$requestNumber = $_POST["requestNumber"];
		$requestType = $_POST["requestType"];
		$itemDetails = $_POST["itemDetails"];
		$deliveryDate = $_POST["deliveryDate"];
		$otherDetails = $_POST["otherDetails"];
		$location = $_POST["location"];

		$this->session->set_flashdata('itemID', $itemID);
		$this->session->set_flashdata('requestNumber', $requestNumber);
		$this->session->set_flashdata('requestType', $requestType);
		$this->session->set_flashdata('itemDetails', $itemDetails);
		$this->session->set_flashdata('deliveryDate', $deliveryDate);
		$this->session->set_flashdata('otherDetails', $otherDetails);
		$this->session->set_flashdata('location', $location);

		if ($this->form_validation->run() == FALSE) {   
			echo json_encode($this->form_validation->error_array());
		}else{    

			$returnValue = array();
			$returnValue['itemID'] = $itemID;
			$returnValue['requestNumber'] = $requestNumber;
			$returnValue['requestType'] = $requestType;
			$returnValue['itemDetails'] = $itemDetails;
			$returnValue['deliveryDate'] = $deliveryDate;
			$returnValue['otherDetails'] = $otherDetails;
			$returnValue['location'] = $location;
			$returnValue['item'] = $item;
			$returnValue['startDate'] = $startDate;
			$returnValue['endDate'] = $endDate;

			$returnValue['success'] = 1;
			echo json_encode($returnValue);
			
		}	

	}


	public function insertRequestItemsICTJRS() {
		$itemID = $_POST["itemID"];
		$requestNumber = $_POST["requestNumber"];
		$requestType = $_POST["requestType"];
		$itemDetails = $_POST["itemDetails"];
		$deliveryDate = $_POST["deliveryDate"];
		$otherDetails = $_POST["otherDetails"];
		$location = $_POST["location"];

		$item = null;
		$inventory = null;
		$startDate = null;
		
		$userName = $this->_getUserName(1);

		if($requestType == "CCTA") {
			$inventory = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_inventory_cctv'), $fieldName = array('ID'), $where = array($itemID), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
			
			if(!empty($inventory)) {
				$item = $inventory[0]->location;
			}
			$startDate = $this->_getCurrentDate();
			
		} else if($requestType == "GSAS") {
			$inventory = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_request_reference_gsuite'), $fieldName = array('ID'), $where = array($itemID), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
			
			if(!empty($inventory)) {
				$item = $inventory[0]->requestCategory;
			}
			$startDate = $this->_getCurrentDate();
			
		} else if($requestType == "HWRS") {
			$inventory = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_request_reference_workstation'), $fieldName = array('ID'), $where = array($itemID), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
			
			if(!empty($inventory)) {
				$item = $inventory[0]->requestCategory;
			}
			$startDate = $this->_getCurrentDate();
		} else if($requestType == "ICSA") {
				$item = $_POST["item"];
				$startDate = $_POST["startDate"];
				$deliveryDate = $_POST["endDate"];
		} else if($requestType == "LPI") {
			$inventory = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_inventory_lcd_projector'), $fieldName = array('ID'), $where = array($itemID), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
			
			if(!empty($inventory)) {
				$item = $inventory[0]->projectorBrand . "-" . $inventory[0]->projectorModel;
				$location = $inventory[0]->roomNumber;
				$otherDetails = $inventory[0]->underWarranty;
				
			}
			$startDate = $this->_getCurrentDate();
		} else if($requestType == "PTRS") {
			$inventory = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_inventory_telephone'), $fieldName = array('ID'), $where = array($itemID), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
			
			if(!empty($inventory)) {
				$item = $inventory[0]->phoneUser;
				$location = $inventory[0]->roomNumber . "-" . $inventory[0]->floor;
				$otherDetails = $inventory[0]->phoneNumber;
				
			}
			$startDate = $this->_getCurrentDate();
		} else if($requestType == "SWTI") {
			$inventory = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_inventory_software'), $fieldName = array('ID'), $where = array($itemID), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
			
			if(!empty($inventory)) {
				$item = $inventory[0]->softwareName;
			}
			$startDate = $this->_getCurrentDate();
				
		}

		
		$transactionExist = null;
		
		if($requestType == "CCTA" || $requestType == "GSAS" || $requestType == "HWRS") {
			$transactionExist = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_job_request_transaction_ict_request_items'), $fieldName = array('requestNumber', 'item'), $where = array($requestNumber, $item), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
		} elseif($requestType == "ICWA") {
			$transactionExist = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_job_request_transaction_ict_request_items'), $fieldName = array('requestNumber', 'otherDetails', 'location'), 
			$where = array($requestNumber, $otherDetails, $location), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
		} elseif($requestType == "ICSA") {
			$transactionExist = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_job_request_transaction_ict_request_items'), $fieldName = array('requestNumber', 'item', 'otherDetails'), 
			$where = array($requestNumber, $item, $otherDetails), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
		}
	



	

		if(empty($transactionExist)) {

			$systemForAuditName = "ICTJRS";
			$moduleName = "REQUESTITEMSCREATE";

			$insertData1 = null;
			$insertData1 = array(
				'requestType' => $requestType,
				'requestNumber' => $requestNumber,
				'itemID' => $itemID,
				'item' => $item,
				'itemDetails' => $itemDetails,
				'otherDetails' => $otherDetails,
				'location' => $location,
				'startDate' => $startDate,
				'endDate' => $deliveryDate,
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_job_request_transaction_ict_request_items', $insertData1);        			 


				$actionName1 = "Insert New Transaction Request";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_job_request_transaction_ict_request_items-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_ict_request_items ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$requestType . "', ";
			$text1 = $text1 .  "'".$requestNumber . "', ";
			$text1 = $text1 .  "'".$itemID . "', ";
			$text1 = $text1 .  "'".$item . "', ";
			$text1 = $text1 .  "'".$itemDetails . "', ";
			$text1 = $text1 .  "'".$otherDetails . "', ";
			$text1 = $text1 .  "'".$location . "', ";
			$text1 = $text1 .  "'".$deliveryDate . "', ";
			$text1 = $text1 .  "'".$this->_getCurrentDate() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp();
			$text1 = $text1 . "');";
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
			$returnValue['itemID'] = $itemID;
			$returnValue['requestNumber'] = $requestNumber;
			$returnValue['requestType'] = $requestType;
			$returnValue['itemDetails'] = $itemDetails;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} else  {//if(empty($transactionExist))
			$returnValue = array();
			$returnValue['itemID'] = $itemID;
			$returnValue['requestNumber'] = $requestNumber;
			$returnValue['requestType'] = $requestType;
			$returnValue['itemDetails'] = $itemDetails;
			
			$returnValue['success'] = 0;
			echo json_encode($returnValue);
		
		}
	}



	public function deleteRequestItemsICTJRS() {
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);


		$systemForAuditName = "ICTJRS";
		$moduleName = "REQUESTITEMSDELETE";


			//DELETE ITEMS
			$where = array($ID);
			$fieldName = array('ID');
			//DELETE ITEMS
			
			$this->db->trans_start();
				$insertedRecord1 = $this->_deleteRecords('triune_job_request_transaction_ict_request_items', $fieldName, $where);       			 


				$actionName1 = "Delete ICTJRS Item";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = $ID;
				$newValue1 =  null;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			/*$fileName1 = "triune_job_request_transaction_asrs_items-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_asrs_items ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$ID . "', ";
			$text1 = $text1 .  "'".$quantity . "', ";
			$text1 = $text1 .  "'".$unitCode . "', ";
			$text1 = $text1 .  "'".$unitCodeText . "', ";
			$text1 = $text1 .  "'".$assetGroupCd . "', ";
			$text1 = $text1 .  "'".$assetSubGroupCd . "', ";
			$text1 = $text1 .  "'".$assetCompGroupCd . "', ";
			$text1 = $text1 .  "'".$assetNameText . "', ";
			$text1 = $text1 .  "'".$this->_getCurrentDate() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp();
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);*/

			if($this->db->trans_status() === FALSE) {
				$this->_transactionFailed();
				return FALSE;  
			} 

			
			$returnValue = array();
			

			$returnValue['ID'] = $ID;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

	}


    public function getRequestReferenceGSuiteICTJRS() {
		$selectField = "triune_request_reference_gsuite.*";
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_request_reference_gsuite'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('requestCategory'), $sortOrder = array('asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }	
	
    public function getRequestHardwareICTJRS() {
		$selectField = "triune_request_reference_workstation.*";
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_request_reference_workstation'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('requestCategory'), $sortOrder = array('asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }
	
    public function getDetailedLCDInventoryICTJRS() {
		$selectField = "triune_inventory_lcd_projector.*, ";
		$selectField = $selectField . "concat(roomNumber, ' - ', projectorBrand, ' - ', projectorModel) as projectorDetail";
		
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_inventory_lcd_projector'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('locationCode', 'floor'), $sortOrder = array('asc', 'asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }	
	
    public function getDetailedTelephoneInventoryICTJRS() {
		$selectField = "triune_inventory_telephone.*, ";
		$selectField = $selectField . " concat(phoneUser, '(', phoneNumber, ')') as phoneDetail";
		
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_inventory_telephone'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('locationCode', 'floor'), $sortOrder = array('asc', 'asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }	

	
    public function getSoftwareInventoryICTJRS() {
		$selectField = "triune_inventory_software.*";
		
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_inventory_software'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('softwareName'), $sortOrder = array('asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }	


    public function getLaboratoryList() {
		$selectField = "triune_inventory_comlab.*";
		
		$results1 = $this->_getRecordsData($data = array($selectField), 
			$tables = array('triune_inventory_comlab'), 	$fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('comlabName'), $sortOrder = array('asc'), $limit = null, $fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			echo json_encode($results1);
    }	
	

	
}