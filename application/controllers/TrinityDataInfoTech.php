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
				'sy' => $_SESSION['sy'],
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
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
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
			$text2 = $text2 .  "'".$_SESSION['sy'] . "', ";
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

			$rE = $this->_getRecordsData($data = array('receiverEmail'), 
			$tables = array('triune_email_receiver'), $fieldName = array('systemName', 'role'), $where = array('ICTJRS', 'N'), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 	$limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
			$receiverEmail =  $rE[0]->receiverEmail;
			//$receiverEmail = 'rdlagdaan@tua.edu.ph';
			
            $message = '';                     
            $message .= '<strong>New ICTJRS Request from user ' . $userName . ' for<u> ' . $requestSummary . '</u></strong><br>';
            $message .= '<strong>Request Type<u> ' . $requestType . '</u></strong><br>';
            $message .= '<strong>With the following details: <u>' . $requestDetails . '</u></strong><br>';
 
					
			$emailSent = $this->_sendMail($toEmail = $receiverEmail, $subject = "Email Notification from: " . $userName . "(NEW)" , $message);
            if($emailSent) {
                $this->session->set_flashdata('emailSent', '1');
                //echo "HELLO";
				$returnValue = array();
				$returnValue['ID'] = $insertedRecord1;
				$returnValue['success'] = 1;
				echo json_encode($returnValue);
				
            } else {
                $this->session->set_flashdata('emailSent', '0');
				$returnValue = array();
				$returnValue['ID'] = $insertedRecord1;
				$returnValue['success'] = 0;
				echo json_encode($returnValue);
				
                //redirect(base_url().'user-acct/sign-up');
            }
			
			
			//$returnValue = array();
			//$returnValue['ID'] = $insertedRecord1;
			//$returnValue['success'] = 1;
			//echo json_encode($returnValue);

		} //if(empty($transactionExist))

	}
	

    public function getWorkstationInventoryICTJRS() {
		
		$selectField = "triune_inventory_workstation.*, concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName, '; ', triune_employee_data.employeeNumber) as fullName";
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
	
	
}