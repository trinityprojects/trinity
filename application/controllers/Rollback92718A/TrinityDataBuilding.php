<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityDataBuilding extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Building Data Controller.  
	 * DATE CREATED: June 05, 2018
     * DATE UPDATED: June 05, 2018
	 */
	var	$LOGFOLDER = 'tbamims';

    function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('form_validation'); 
    }//function __construct()


    public function getLocationCodeTBAMIMS() {
		$results = $this->_getRecordsData($data = array('locationCode', 'locationDescription'), 
			$tables = array('triune_location'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('locationDescription'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
	}

    public function getFloorTBAMIMS() {
		$locationCode = $_GET["locationCode"];
		//echo $locationCode;
		$results = $this->_getRecordsData($data = array('floor', 'locationCode'), 
			$tables = array('triune_rooms'), $fieldName = array('locationCode'), $where = array($locationCode), $join = null, $joinType = null, 
			$sortBy = array('floor'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
	}

	public function getRoomNumberTBAMIMS() {
		$floor = $_GET["floor"];
		$locationCode = $_GET["locationCode"];

		$results = $this->_getRecordsData($data = array('roomNumber', 'roomDescription'), 
			$tables = array('triune_rooms'), $fieldName = array('floor', 'locationCode'), $where = array($floor, $locationCode), $join = null, $joinType = null, 
			$sortBy = array('roomNumber'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
	}


	public function validateRequestTBAMIMS() {

		$this->form_validation->set_rules('locationCode', 'Location Code', 'required|alpha_numeric');
		$this->form_validation->set_rules('floor', 'Floor', 'required|alpha_numeric');  
		$this->form_validation->set_rules('roomNumber', 'Room Number', 'required');    
		$this->form_validation->set_rules('projectTitle', 'Project Title', 'required');    
		$this->form_validation->set_rules('scopeOfWorks', 'Scope of Works', 'required');    
		$this->form_validation->set_rules('projectJustification', 'Project Justification', 'required');    
		$this->form_validation->set_rules('dateNeeded', 'Date Needed', 'required|regex_match[/\d{4}\-\d{2}-\d{2}/]');    

		$locationCode = $_POST["locationCode"];
		$floor = $_POST["floor"];
		$roomNumber = $_POST["roomNumber"];
		$projectTitle = $_POST["projectTitle"];
		$scopeOfWorks = $_POST["scopeOfWorks"];
		$projectJustification = $_POST["projectJustification"];
		$dateNeeded = $_POST["dateNeeded"];

		$this->session->set_flashdata('locationCode', $locationCode);
		$this->session->set_flashdata('floor', $floor);
		$this->session->set_flashdata('roomNumber', $roomNumber);
		$this->session->set_flashdata('projectTitle', $projectTitle);
		$this->session->set_flashdata('scopeOfWorks', $scopeOfWorks);
		$this->session->set_flashdata('projectJustification', $projectJustification);
		$this->session->set_flashdata('dateNeeded', $dateNeeded);


		if ($this->form_validation->run() == FALSE) {   
			echo json_encode($this->form_validation->error_array());
		}else{    

			$resultsLoc = $this->_getRecordsData($data = array('locationCode'), 
			$tables = array('triune_location'), $fieldName = array('locationCode'), $where = array($locationCode), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = array('asc'), 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$resultsRm = $this->_getRecordsData($data = array('roomNumber', 'roomDescription'), 
			$tables = array('triune_rooms'), $fieldName = array('roomNumber'), $where = array($roomNumber), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$resultsFlr = $this->_getRecordsData($data = array('roomNumber', 'roomDescription'), 
			$tables = array('triune_rooms'), $fieldName = array('floor'), $where = array($floor), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$notExistMessage = array();
			if(empty($resultsLoc)) {
				$notExistMessage["locationCodeNotExist"] = "No reference for location codes in the database!";
			} 
			
			if(empty($resultsRm)) {
				$notExistMessage["roomNumberNotExist"] = "No reference for room numbers in the database!";

			} 
			
			if(empty($resultsFlr)) {
				$notExistMessage["floorNotExist"] = "No reference for floor in the database!";

			} 
			if(count($notExistMessage) > 0) {
				echo json_encode($notExistMessage);
			} elseif(count($notExistMessage) == 0) {

					$returnValue = array();
					
					$returnValue['locationCode'] = $locationCode;
					$returnValue['floor'] = $floor;
					$returnValue['roomNumber'] = $roomNumber;
					$returnValue['projectTitle'] = $projectTitle;
					$returnValue['scopeOfWorks'] = $scopeOfWorks;
					$returnValue['projectJustification'] = $projectJustification;
					$returnValue['dateNeeded'] = $dateNeeded;


					$returnValue['success'] = 1;
					echo json_encode($returnValue);
				//}
			}
			
		}	

	}

	public function insertRequestTBAMIMS() {
		$locationCode = $_POST["locationCode"];
		$floor = $_POST["floor"];
		$roomNumber = $_POST["roomNumber"];
		$projectTitle = $_POST["projectTitle"];
		$scopeOfWorks = $_POST["scopeOfWorks"];
		$projectJustification = $_POST["projectJustification"];
		$dateNeeded = $_POST["dateNeeded"];


		/*$locationCode = 'SSC';
		$floor = 5;
		$roomNumber = '5671';
		$projectTitle = 'good1';
		$scopeOfWorks = 'scope1';
		$projectJustification = 'just1';
		$dateNeeded = '2018-01-01';*/

		
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('locationCode'), 
		$tables = array('triune_job_request_transaction_tbamims'), 
		$fieldName = array('sy', 'locationCode', 'floor', 'roomNumber', 'projectTitle', 'scopeOfWorks', 'projectJustification', 'dateNeeded', 'userName'), 
		$where = array($_SESSION['sy'], $locationCode, $floor, $roomNumber, $projectTitle, $scopeOfWorks, $projectJustification, $dateNeeded, $userName), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		

		if(empty($transactionExist)) {

			$systemForAuditName = "TBAMIMS";
			$moduleName = "REQUESTCREATE";

			$insertData1 = null;
			$insertData1 = array(
				'sy' => $_SESSION['sy'],
				'locationCode' => $locationCode,
				'floor' => $floor,
				'roomNumber' => $roomNumber,
				'projectTitle' => $projectTitle,
				'scopeOfWorks' => $scopeOfWorks, 
				'projectJustification' => $projectJustification,
				'requestStatus' => $this->_getRequestStatus('NEW', 'TBAMIMS'),
				'dateNeeded' => $dateNeeded,
				'dateCreated' => $this->_getCurrentDate(),
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims', $insertData1);        			 

				$insertedRecord1 = $this->_getRecordsData($data = array('ID'), 
				$tables = array('triune_job_request_transaction_tbamims'), 
				$fieldName = array('sy', 'locationCode', 'floor', 'roomNumber', 'projectTitle', 'scopeOfWorks', 'projectJustification', 'dateNeeded', 'userName'), 
				$where = array($_SESSION['sy'], $locationCode, $floor, $roomNumber, $projectTitle, $scopeOfWorks, $projectJustification, $dateNeeded, $userName), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

				$actionName1 = "Insert New Transaction Request";
				$for1 = $insertedRecord1[0]->ID . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		


			$insertData2 = null;
			$insertData2 = array(
				'sy' => $_SESSION['sy'],
				'requestNumber' =>$insertedRecord1[0]->ID,
				'requestStatus' => $this->_getRequestStatus('NEW', 'TBAMIMS'),
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 

				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_status_history', $insertData2);        			 

				$insertedRecord2 = $this->_getRecordsData($data = array('ID'), 
				$tables = array('triune_job_request_transaction_tbamims_status_history'), 
				$fieldName = array('sy', 'requestNumber', 'requestStatus', 'userName'), 
				$where = array($_SESSION['sy'], $insertedRecord1[0]->ID, $this->_getRequestStatus('NEW', 'TBAMIMS'), $userName), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

				$actionName2 = "Insert New Transaction Request Status History";
				$for2 = $insertedRecord2[0]->ID . ";" .$userName;
				$oldValue2 = null;
				$newValue2 =  $insertData2;
				$userType = 1; 
				$this->_insertAuditTrail($actionName2, $systemForAuditName, $moduleName, $for2, $oldValue2, $newValue2, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_job_request_transaction_tbamims-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_tbamims ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1[0]->ID . ", ";
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
			$text1 = $text1 .  "'".$locationCode . "', ";
			$text1 = $text1 .  "'".$floor . "', ";
			$text1 = $text1 .  "'".$roomNumber . "', ";
			$text1 = $text1 .  "'".$projectTitle . "', ";
			$text1 = $text1 .  "'".$scopeOfWorks . "', ";
			$text1 = $text1 .  "'".$projectJustification . "', ";
			$text1 = $text1 .  "'".$this->_getRequestStatus('NEW', 'TBAMIMS') . "', ";
			$text1 = $text1 .  "'".$dateNeeded . "', ";
			$text1 = $text1 .  "'".$this->_getCurrentDate() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp();
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

			$fileName2 = "triune_job_request_transaction_bam_tbamims_history-" . $this->_getCurrentDate();
			$text2 = "INSERT INTO triune_job_request_transaction_tbamims_status_history ";
			$text2 = $text2 .  "VALUES (" .  $insertedRecord2[0]->ID . ", ";
			$text2 = $text2 .  "'".$_SESSION['sy'] . "', ";
			$text2 = $text2 .  "'".$insertedRecord1[0]->ID . "', ";
			$text2 = $text2 .  "'".$this->_getRequestStatus('NEW', 'TBAMIMS') . "', ";
			$text2 = $text2 .  "'".$userName . "', ";
			$text2 = $text2 .  "'".$this->_getIPAddress() . "', ";
			$text2 = $text2 .  "'".$this->_getTimeStamp() . "', ";
			$text2 = $text2 .  "'".$userName;
			$text2 = $text2 . "');";
			$this->_insertTextLog($fileName2, $text2, $this->LOGFOLDER);
			

			if($this->db->trans_status() === FALSE) {
				$this->_transactionFailed();
				return FALSE;  
			} 

			$rE = $this->_getRecordsData($data = array('receiverEmail'), 
			$tables = array('triune_email_receiver'), $fieldName = array('systemName', 'role'), $where = array('TBAMIMS', 'N'), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 	$limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
			$receiverEmail =  $rE[0]->receiverEmail;
			//$receiverEmail = 'rdlagdaan@tua.edu.ph';
			
            $message = '';                     
            $message .= '<strong>New TBAMIMS Request from user ' . $userName . ' for<u> ' . $projectTitle . '</u></strong><br>';
            $message .= '<strong>Location<u> ' . $locationCode . ' - ' . $floor . ' - ' . $roomNumber . '</u></strong><br>';
            $message .= '<strong>With the following scope: <u>' . $scopeOfWorks . '</u></strong><br>';
 
					
			$emailSent = $this->_sendMail($toEmail = $receiverEmail, $subject = "Email Notification from: " . $userName . "(NEW)" , $message);
            if($emailSent) {
                $this->session->set_flashdata('emailSent', '1');
                //echo "HELLO";
				$returnValue = array();
				$returnValue['ID'] = $insertedRecord1[0]->ID;
				$returnValue['success'] = 1;
				echo json_encode($returnValue);
				
            } else {
                $this->session->set_flashdata('emailSent', '0');
				$returnValue = array();
				$returnValue['ID'] = $insertedRecord1[0]->ID;
				$returnValue['success'] = 0;
				echo json_encode($returnValue);
				
                //redirect(base_url().'user-acct/sign-up');
            }
			
			

		} //if(empty($transactionExist))

	}


    public function getMyRequestListTBAMIMS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$page = isset($clean['page']) ? intval($clean['page']) : 1;
		$rows = isset($clean['rows']) ? intval($clean['rows']) : 10;
		$ID = isset($clean['ID']) ? $clean['ID'] : '';
		$locationCode = isset($clean['locationCode']) ? $clean['locationCode'] : '';
		$requestStatus = isset($clean['requestStatus']) ? $clean['requestStatus'] : '';
		$userName = $this->_getUserName(1);
		 
		$offset = ($page-1)*$rows;
		$result = array();
		$whereSpcl = "triune_job_request_transaction_tbamims.userName = '$userName'"; 
		$whereSpcl =  $whereSpcl . " and triune_job_request_transaction_tbamims.ID like '$ID%'"; 
		$whereSpcl =  $whereSpcl . " and triune_job_request_transaction_tbamims.locationCode like '$locationCode%'";
		$whereSpcl =  $whereSpcl . " and triune_job_request_transaction_tbamims.requestStatus like '$requestStatus%'";
	 
		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_job_request_transaction_tbamims'), $fieldName = array('sy'), $where = array($_SESSION['sy']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('triune_job_request_transaction_tbamims.*', 'triune_request_status_reference.requestStatusDescription'), 
			$tables = array('triune_job_request_transaction_tbamims', 'triune_request_status_reference'), 
			$fieldName = array('sy', 'triune_request_status_reference.application'), $where = array($_SESSION['sy'], 'TBAMIMS'), 
			$join = array('triune_job_request_transaction_tbamims.requestStatus = triune_request_status_reference.requestStatusCode'), 
			$joinType = array('left'), 
			$sortBy = array('triune_job_request_transaction_tbamims.ID'), $sortOrder = array('desc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;

			$result["ID"] = $ID;
			$result["locationCode"] = $locationCode;

			echo json_encode($result);
	}



    public function getRequestListTBAMIMS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$page = isset($clean['page']) ? intval($clean['page']) : 1;
		$rows = isset($clean['rows']) ? intval($clean['rows']) : 10;
		$ID = isset($clean['ID']) ? $clean['ID'] : '';
		$locationCode = isset($clean['locationCode']) ? $clean['locationCode'] : '';
		$requestStatus = isset($clean['requestStatus']) ? $clean['requestStatus'] : '';
		$userName = isset($clean['userName']) ? $clean['userName'] : '';

		$offset = ($page-1)*$rows;
		$result = array();
		$whereSpcl = "triune_job_request_transaction_tbamims.requestStatus = '$requestStatus'";
		$whereSpcl = $whereSpcl . " and triune_job_request_transaction_tbamims.ID like '$ID%'";
		$whereSpcl = $whereSpcl . " and triune_job_request_transaction_tbamims.locationCode like '$locationCode%'";
		$whereSpcl = $whereSpcl . " and triune_job_request_transaction_tbamims.userName like '$userName%'";
	 


		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_job_request_transaction_tbamims'), $fieldName = array('sy'), $where = array($_SESSION['sy']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('triune_job_request_transaction_tbamims.*', 'triune_request_status_reference.requestStatusDescription'), 
			$tables = array('triune_job_request_transaction_tbamims', 'triune_request_status_reference'), 
			$fieldName = array('sy', 'triune_request_status_reference.application'), $where = array($_SESSION['sy'], 'TBAMIMS'), 
			$join = array('triune_job_request_transaction_tbamims.requestStatus = triune_request_status_reference.requestStatusCode'), 
			$joinType = array('left'), 
			$sortBy = array('triune_job_request_transaction_tbamims.ID'), $sortOrder = array('desc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;

			$result["ID"] = $ID;
			$result["locationCode"] = $locationCode;


			echo json_encode($result);
	}


	public function updateRequestTBAMIMS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$ID =  $clean['ID'];
		$requestStatus =  $clean['requestStatus'];
		$specialInstructions = null;
		$scopeDetails =  null;
		$requestStatusRemarksID =  null;
		$quantity =  null;
		$materialsID =  null;
		$materialsRecordID =  null;
		$actualBudgetAmount =  null;
		$actualAmount = null;
		$jo = null;

		$selectionCode = null;
		$remarks = null;
		$questionCategoryID = null;
		$selectionDesciption = null;

		$startDateActual = null;
		$receivedDate = null;
		
		
		if($requestStatus == 'O') {
			$specialInstructions =  $clean['specialInstructions'];
			$scopeDetails =  $clean['scopeDetails'];
			$requestStatusRemarksID =  $clean['requestStatusRemarksID'];
			$quantity =  $clean['qty'];
			$materialsID =  $clean['materialsID'];
		} elseif($requestStatus == 'A') {
			$specialInstructions =  $clean['specialInstructions'];
			$scopeDetails =  $clean['scopeDetails'];
			$requestStatusRemarksID =  $clean['requestStatusRemarksID'];
		} elseif($requestStatus == 'E') {
			$specialInstructions =  $clean['specialInstructions'];
			$scopeDetails =  $clean['scopeDetails'];
			$requestStatusRemarksID =  $clean['requestStatusRemarksID'];
			$amount =  $clean['amount'];
			$materialsRecordID =  $clean['materialsRecordID'];
		} elseif($requestStatus == 'S') {
			$specialInstructions =  $clean['specialInstructions'];
			$scopeDetails =  $clean['scopeDetails'];
			$requestStatusRemarksID =  $clean['requestStatusRemarksID'];
			$actualBudgetAmount =  $clean['actualBudgetAmount'];
		} elseif($requestStatus == 'W') {
			$specialInstructions =  $clean['specialInstructions'];
			$scopeDetails =  $clean['scopeDetails'];
			$requestStatusRemarksID =  $clean['requestStatusRemarksID'];
			$amount =  $clean['actualAmount'];
			$materialsRecordID =  $clean['materialsRecordID'];
		} elseif($requestStatus == 'C') {
			$specialInstructions =  $clean['specialInstructions'];
			$scopeDetails =  $clean['scopeDetails'];
			$requestStatusRemarksID =  $clean['requestStatusRemarksID'];
			$jo =  $clean['jo'];
			$startDateActual =  $clean['startDateActual'];
			$receivedDate =  $clean['receivedDate'];
		} elseif($requestStatus == 'X') {
			$selectionCode = $clean['selectionCode'];
			$remarks = $clean['remarks'];
			$questionCategoryID = $clean['questionCategoryID'];
			$selectionDesciption = $clean['selectionDesciption'];
			$jo =  $clean['jo'];
		} elseif($requestStatus == 'R') {
			$specialInstructions =  $clean['specialInstructions'];
			$scopeDetails =  $clean['scopeDetails'];
			$requestStatusRemarksID =  $clean['requestStatusRemarksID'];
			
		}


		$userName = $this->_getUserName(1);


		$this->db->trans_start();

			//--------------UPDATE REQUEST STATUS-------------------
			$systemForAuditName0 = "TBAMIMS";
			$moduleName0 = "REQUESTUPDATE";
			
			$requestStatusUpdate = null;

			if($requestStatus == 'X') {
				$requestStatusUpdate = array(
					'requestStatus' => $requestStatus,
					'dateClosed' => $this->_getCurrentDate()
				);
			} else if($requestStatus == 'C') {
				$requestStatusUpdate = array(
					'requestStatus' => $requestStatus,
					'dateCompleted' => $this->_getCurrentDate()
				);
			} else {
				$requestStatusUpdate = array(
					'requestStatus' => $requestStatus,
				);
				
			}

			
			
			$this->_updateRecords($tableName = 'triune_job_request_transaction_tbamims', 
			$fieldName = array('ID'), 
			$where = array($ID), $requestStatusUpdate);
			
			$actionName0 = "Update Transaction Request to: " . $requestStatus;
			$for0 = $ID . ";" . $userName;
			$oldValue0 = null;
			$newValue0 =  $requestStatusUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName0, $systemForAuditName0, $moduleName0, $for0, $oldValue0, $newValue0, $userType);		

			$fileName0 = "triune_job_request_transaction_tbamims-" . $this->_getCurrentDate();
			$text0 = "UPDATE triune_job_request_transaction_tbamims ";
			$text0 = $text0 .  "SET requestStatus = '" .  $requestStatus . "' ";
			$text0 = $text0 .  "WHERE ID = ".$ID;
			$this->_insertTextLog($fileName0, $text0, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATUS-------------------



			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_tbamims');


			//--------------UPDATE REQUEST STATATUS HISTORY-------------------
			$systemForAuditName1 = "TBAMIMS";
			$moduleName1 = "REQUESTSTATUSHISTORY";

			$insertData1 = null;
			$insertData1 = array(
				'sy' => $_SESSION['sy'],
				'requestNumber' =>$ID,
				'requestStatus' => $requestStatus,
				'userName' => $details[0]->userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 
			$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_status_history', $insertData1);        			 


			$actionName1 = "Update Request Status History with: " . $requestStatus;
			$for1 = $ID . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $insertData1;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName1, $moduleName1, $for1, $oldValue1, $newValue1, $userType);		

			$fileName1 = "triune_job_request_transaction_tbamims_status_history-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_tbamims_status_history ";
			$text1 = $text1 .  "VALUES ('".$ID . "', ";
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
			$text1 = $text1 .  "'".$requestStatus . "', ";
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATATUS HISTORY-------------------


			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------
			if( (strlen($specialInstructions)) > 0) {
				$systemForAuditName2 = "TBAMIMS";
				$moduleName2 = "REQUESTSPECIALINSTRUCTIONS";

				$insertData2 = null;
				$insertData2 = array(
					'sy' => $_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'specialInstructions' => $specialInstructions,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_special_instructions', $insertData2);        			 

				$actionName2 = "Insert Request Special Instructions";
				$for2 = $ID . ";" . $userName;
				$oldValue2 = null;
				$newValue2 =  $insertData2;
				$userType = 1;
				$this->_insertAuditTrail($actionName2, $systemForAuditName2, $moduleName2, $for2, $oldValue2, $newValue2, $userType);		

				$fileName2 = "triune_job_request_transaction_tbamims_special_instructions-" . $this->_getCurrentDate();
				$text2 = "INSERT INTO triune_job_request_transaction_tbamims_special_instructions ";
				$text2 = $text2 .  "VALUES ('".$ID . "', ";
				$text2 = $text2 .  "'".$_SESSION['sy'] . "', ";
				$text2 = $text2 .  "'".$requestStatus . "', ";
				$text2 = $text2 .  "'".$specialInstructions . "', ";
				$text2 = $text2 .  "'".$details[0]->userName . "', ";
				$text2 = $text2 .  "'".$this->_getIPAddress() . "', ";
				$text2 = $text2 .  "'".$this->_getTimeStamp() . "', ";
				$text2 = $text2 .  "'".$userName . "', ";
				$text2 = $text2 . "');";
				$this->_insertTextLog($fileName2, $text2, $this->LOGFOLDER);
					

			}
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------


			//--------------INSERT REQUEST SCOPE DETAILS-------------------
			$systemForAuditName3 = "TBAMIMS";
			$moduleName3 = "REQUESTSCOPEDETAILS";

			if( (strlen($scopeDetails)) > 0) {
				$insertData3 = null;
				$insertData3 = array(
					'sy' => $_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'scopeDetails' => $scopeDetails,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_scope_details', $insertData3);        			 
				
				$actionName3 = "Insert Request Scope Details";
				$for3 = $ID . ";" . $userName;
				$oldValue3 = null;
				$newValue3 =  $insertData3;
				$userType = 1;
				$this->_insertAuditTrail($actionName3, $systemForAuditName3, $moduleName3, $for3, $oldValue3, $newValue3, $userType);		

				$fileName3 = "triune_job_request_transaction_tbamims_scope_details-" . $this->_getCurrentDate();
				$text3 = "INSERT INTO triune_job_request_transaction_tbamims_scope_details ";
				$text3 = $text3 .  "VALUES ('".$ID . "', ";
				$text3 = $text3 .  "'".$_SESSION['sy'] . "', ";
				$text3 = $text3 .  "'".$requestStatus . "', ";
				$text3 = $text3 .  "'".$scopeDetails . "', ";
				$text3 = $text3 .  "'".$details[0]->userName . "', ";
				$text3 = $text3 .  "'".$this->_getIPAddress() . "', ";
				$text3 = $text3 .  "'".$this->_getTimeStamp() . "', ";
				$text3 = $text3 .  "'".$userName . "', ";
				$text3 = $text3 . "');";
				$this->_insertTextLog($fileName3, $text3, $this->LOGFOLDER);
			}
			//--------------INSERT REQUEST SCOPE DETAILS-------------------

			if($materialsID != null){
				//--------------INSERT REQUEST MATERIALS-------------------
				$systemForAuditName4 = "TBAMIMS";
				$moduleName4 = "REQUESTMATERIALS";
				
				$quantt = explode(",",$quantity);
				$materyalsID = explode(",",$materialsID);

				for($i = 0; $i < count($quantt); $i++ ) {
					$insertData4 = null;
					$insertData4 = array(
						'sy' => $_SESSION['sy'],
						'requestNumber' =>$ID,
						'requestStatus' => $requestStatus,
						'quantity' => $quantt[$i],
						'materialsID' => $materyalsID[$i],
						'materialsAmount' => 0,
						'userName' => $details[0]->userName,
						'workstationID' => $this->_getIPAddress(),
						'timeStamp' => $this->_getTimeStamp(),
						'updatedBy' => $userName,
						
					);				 
					$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_materials', $insertData4);        			 
					$zero = 0;
					$fileName4 = "triune_job_request_transaction_tbamims_materials-" . $this->_getCurrentDate();
					$text4 = "INSERT INTO triune_job_request_transaction_tbamims_materials ";
					$text4 = $text4 .  "VALUES ('".$ID . "', ";
					$text4 = $text4 .  "'".$_SESSION['sy'] . "', ";
					$text4 = $text4 .  "'".$requestStatus . "', ";
					$text4 = $text4 .  "'".$quantt[$i] . "', ";
					$text4 = $text4 .  "'".$materyalsID[$i] . "', ";
					$text4 = $text4 .  $zero . ", ";
					$text4 = $text4 .  "'".$details[0]->userName . "', ";
					$text4 = $text4 .  "'".$this->_getIPAddress() . "', ";
					$text4 = $text4 .  "'".$this->_getTimeStamp() . "', ";
					$text4 = $text4 .  "'".$userName . "', ";
					$text4 = $text4 . "');";
					$this->_insertTextLog($fileName4, $text4, $this->LOGFOLDER);


				}
				$actionName4 = "Insert Request Materials";
				$for4 = $ID . ";" . $userName;
				$oldValue4 = null;
				$newValue4 =  $quantity . " " .$materialsID;
				$userType = 1;
				$this->_insertAuditTrail($actionName4, $systemForAuditName4, $moduleName4, $for4, $oldValue4, $newValue4, $userType);		
				//--------------INSERT REQUEST MATERIALS-------------------
			}

			//--------------INSERT REQUEST STATUS REMARKS-------------------
			$systemForAuditName5 = "TBAMIMS";
			$moduleName5 = "REQUESTSTATUSREMARKS";

			if( (strlen($requestStatusRemarksID)) > 0) {
				$insertData5 = null;
				$insertData5 = array(
					'sy' => $_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'requestStatusRemarksID' => $requestStatusRemarksID,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_status_remarks', $insertData5);        			 
				
				$actionName5 = "Insert Request Status Remarks";
				$for5 = $ID . ";" . $userName;
				$oldValue5 = null;
				$newValue5 =  $insertData5;
				$userType = 1;
				$this->_insertAuditTrail($actionName5, $systemForAuditName5, $moduleName5, $for5, $oldValue5, $newValue5, $userType);		

				$fileName5 = "triune_job_request_transaction_tbamims_status_remarks-" . $this->_getCurrentDate();
				$text5 = "INSERT INTO triune_job_request_transaction_tbamims_status_remarks ";
				$text5 = $text5 .  "VALUES ('".$ID . "', ";
				$text5 = $text5 .  "'".$_SESSION['sy'] . "', ";
				$text5 = $text5 .  "'".$requestStatus . "', ";
				$text5 = $text5 .  "'".$requestStatusRemarksID . "', ";
				$text5 = $text5 .  "'".$details[0]->userName . "', ";
				$text5 = $text5 .  "'".$this->_getIPAddress() . "', ";
				$text5 = $text5 .  "'".$this->_getTimeStamp() . "', ";
				$text5 = $text5 .  "'".$userName . "', ";
				$text5 = $text5 . "');";
				$this->_insertTextLog($fileName5, $text5, $this->LOGFOLDER);
			}
			//--------------INSERT REQUEST STATUS REMARKS-------------------

			
			if($materialsRecordID != null){
				//--------------UPDATE REQUEST MATERIALS AMOUNT-------------------
				$systemForAuditName6 = "TBAMIMS";
				$moduleName6 = "REQUESTMATERIALSAMOUNT";
				
				$amawnt = explode(",",$amount);
				$materyalsID = explode(",",$materialsRecordID);
				$validAmount = 0;
				
				for($i = 0; $i < count($materyalsID); $i++ ) {
					
					if(is_numeric($amawnt[$i]) && $amawnt[$i] > 0){
						$validAmount = $amawnt[$i];
					} else {
						$validAmount = 0;
					}
					
					$materialsAmountUpdate = null;

					if($requestStatus == 'W') {
						$materialsAmountUpdate = array(
							'actualAmount' => $validAmount,
							'workstationID' => $this->_getIPAddress(),
							'timeStamp' => $this->_getTimeStamp(),
							'updatedBy' => $userName,
							
						);	
						
					} else {
						$materialsAmountUpdate = array(
							'materialsAmount' => $validAmount,
							'workstationID' => $this->_getIPAddress(),
							'timeStamp' => $this->_getTimeStamp(),
							'updatedBy' => $userName,
							
						);	
					}						

					
					$this->_updateRecords($tableName = 'triune_job_request_transaction_tbamims_materials', 
					$fieldName = array('ID'), 
					$where = array($materyalsID[$i]), $materialsAmountUpdate);
					
					$actionName6 = "Update materialsAmount to: " . $validAmount;
					$for6 = $materyalsID[$i] . ";" . $userName;
					$oldValue6 = null;
					$newValue6 =  $requestStatusUpdate;
					$userType = 1;
					$this->_insertAuditTrail($actionName6, $systemForAuditName6, $moduleName6, $for6, $oldValue6, $newValue6, $userType);		

					$fileName6 = "triune_job_request_transaction_tbamims_materials-" . $this->_getCurrentDate();
					$text6 = "UPDATE triune_job_request_transaction_tbamims_materials ";
					$text6 = $text6 .  "SET materialsAmount = " . $validAmount . ", ";
					$text6 = $text6 .  "workstationID = '" . $this->_getIPAddress() . "', ";
					$text6 = $text6 .  "timeStamp = '" . $this->_getTimeStamp() . "', ";
					$text6 = $text6 .  "updatedBy = '" . $userName . "' ";
					$text6 = $text6 .  "WHERE ID = ".$materyalsID[$i];
					$this->_insertTextLog($fileName6, $text6, $this->LOGFOLDER);
				}
				//--------------UPDATE REQUEST MATERIALS AMOUNT-------------------
			}
			
			
			//--------------INSERT REQUEST SCOPE DETAILS-------------------
			$systemForAuditName7 = "TBAMIMS";
			$moduleName7 = "REQUESTACTUALBUDGET";

			if( (strlen($actualBudgetAmount)) > 0) {
				$insertData7 = null;
				$insertData7 = array(
					'sy' => $_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'actualBudgetAmount' => $actualBudgetAmount,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_actual_budget', $insertData7);        			 
				
				$actionName7 = "Insert Request Actual Budget Amount";
				$for7 = $ID . ";" . $userName;
				$oldValue7 = null;
				$newValue7 =  $insertData7;
				$userType = 1;
				$this->_insertAuditTrail($actionName7, $systemForAuditName7, $moduleName7, $for7, $oldValue7, $newValue7, $userType);		

				$fileName7 = "triune_job_request_transaction_tbamims_actual_budget-" . $this->_getCurrentDate();
				$text7 = "INSERT INTO triune_job_request_transaction_tbamims_actual_budget ";
				$text7 = $text7 .  "VALUES ('".$ID . "', ";
				$text7 = $text7 .  "'".$_SESSION['sy'] . "', ";
				$text7 = $text7 .  "'".$requestStatus . "', ";
				$text7 = $text7 .  "'".$actualBudgetAmount . "', ";
				$text7 = $text7 .  "'".$details[0]->userName . "', ";
				$text7 = $text7 .  "'".$this->_getIPAddress() . "', ";
				$text7 = $text7 .  "'".$this->_getTimeStamp() . "', ";
				$text7 = $text7 .  "'".$userName . "', ";
				$text7 = $text7 . "');";
				$this->_insertTextLog($fileName7, $text7, $this->LOGFOLDER);
			}
			//--------------INSERT REQUEST SCOPE DETAILS-------------------



			//--------------UPDATE JOB ORDER-------------------
			$systemForAuditName8 = "TBAMIMS";
			$moduleName8 = "JOBORDERCOMPLETED";
			
			$jobOrderUpdate = array(
				'completedFlag' => 'Y',
				'flaggedBy' => $userName,
				'dateCompleted' => $this->_getCurrentDate(),
				'startDateActual' => $startDateActual,
				'completedDateActual' => $this->_getCurrentDate(),
				'receivedDate' => $receivedDate
			);
			$this->_updateRecords($tableName = 'triune_job_request_job_order', 
			$fieldName = array('ID'), 
			$where = array($jo), $jobOrderUpdate);
			
			$actionName8 = "Update Job order to Completion ";
			$for8 = $jo . ";" . $ID . ";" . $userName;
			$oldValue8 = null;
			$newValue8 =  $jobOrderUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName8, $systemForAuditName8, $moduleName8, $for8, $oldValue8, $newValue8, $userType);		

			$fileName8 = "triune_job_request_job_order-" . $this->_getCurrentDate();
			$text8 = "UPDATE triune_job_request_job_order ";
			$text8 = $text8 .  "SET completedFlag = " .  'Y' . ", ";
			$text8 = $text8 .  "flaggedBy = '".$userName . "' ";
			$text8 = $text8 .  "WHERE ID = ".$jo;
			$this->_insertTextLog($fileName8, $text8, $this->LOGFOLDER);
			//--------------UPDATE JOB ORDER-------------------


			if($questionCategoryID != null){
				//--------------INSERT EVALUATION ANSWERS-------------------
				$systemForAuditName9 = "TBAMIMS";
				$moduleName9 = "EVALUATIONJOBORDER";
				
				$qcid = explode(",",$questionCategoryID);
				$sdesc = explode(",",$selectionDesciption);
				$scode = explode(",",$selectionCode);
				$rem = explode(",",$remarks);


				for($i = 0; $i < count($qcid); $i++ ) {
					$insertData9 = null;
					$insertData9 = array(
						'sy' => $_SESSION['sy'],
						'requestNumber' =>$ID,
						'jobOrderNumber' => $jo,
						'questionCategoryID' => $qcid[$i],
						'selectionCode' => $scode[$i],
						'selectionDescription' => $sdesc[$i],
						'evaluationRemarksJO' => $rem[$i],
						'userNumber' => $details[0]->userName,
						'workstationID' => $this->_getIPAddress(),
						'updatedBy' => $userName,
						'timeStamp' => $this->_getTimeStamp(),
						
					);				 
					$this->_insertRecords($tableName = 'triune_job_request_evaluation_answers', $insertData9);        			 
					$zero = 0;
					$fileName9 = "triune_job_request_evaluation_answers-" . $this->_getCurrentDate();
					$text9 = "INSERT INTO triune_job_request_evaluation_answers ";
					$text9 = $text9 .  "VALUES ('".$ID . "', ";
					$text9 = $text9 .  "'".$_SESSION['sy'] . "', ";
					$text9 = $text9 .  "'".$jo . "', ";
					$text9 = $text9 .  "'".$qcid[$i] . "', ";
					$text9 = $text9 .  "'".$scode[$i] . "', ";
					$text9 = $text9 .  "'".$sdesc[$i] . "', ";
					$text9 = $text9 .  "'".$rem[$i] . "', ";
					$text9 = $text9 .  "'".$details[0]->userName . "', ";
					$text9 = $text9 .  "'".$this->_getIPAddress() . "', ";
					$text9 = $text9 .  "'".$userName . "', ";
					$text9 = $text9 .  "'".$this->_getTimeStamp() . "', ";
					$text9 = $text9 . "');";
					$this->_insertTextLog($fileName9, $text9, $this->LOGFOLDER);


				}
				$actionName9 = "Insert Evaluation Answersw";
				$for9 = $ID . ";" . $userName;
				$oldValue9 = null;
				$newValue9 =  $questionCategoryID . " " .$selectionDesciption . " " . $selectionCode . " " . $remarks;
				$userType = 1;
				$this->_insertAuditTrail($actionName9, $systemForAuditName9, $moduleName9, $for9, $oldValue9, $newValue9, $userType);		
				//--------------INSERT EVALUATION ANSWERS-------------------
			}
			
			
		$this->db->trans_complete();

			$rS = $this->_getRecordsData($data = array('requestStatusDescription'), 
			$tables = array('triune_request_status_reference'), $fieldName = array('application', 'requestStatusCode'), $where = array('TBAMIMS', $requestStatus), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 	$limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

		
			$requestStatusDescription = $rS[0]->requestStatusDescription;
		
			$rE = $this->_getRecordsData($data = array('receiverEmail'), 
			$tables = array('triune_email_receiver'), $fieldName = array('systemName', 'role'), $where = array('TBAMIMS', $requestStatus), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 	$limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			$receiverEmail = null;
			if(!empty($rE)) {
				$receiverEmail =  $rE[0]->receiverEmail;
			} else {
				$receiverEmail = 'rdlagdaan@tua.edu.ph';
			}
			
            $message = '';                     
            $message .= '<strong>' .$requestStatusDescription. ' TBAMIMS Request from user <u>' . $userName .  '</u></strong><br>';
 
					
			$emailSent = $this->_sendMail($toEmail = $receiverEmail, $subject = "Email Notification from: " . $userName . "(" .$requestStatusDescription. ")" , $message);
            if($emailSent) {
               // $this->session->set_flashdata('emailSent', '1');
                //echo "HELLO";
				$returnValue = array();
				$returnValue['success'] = 1;
				echo json_encode($returnValue);
				
            } else {
                //$this->session->set_flashdata('emailSent', '1');
                //redirect(base_url().'user-acct/sign-up');
				$returnValue = array();
				$returnValue['success'] = 0;
				echo json_encode($returnValue);
				
            }		
		
		



	}



	public function insertMaterialsTBAMIMS() {

		$this->form_validation->set_rules('particulars', 'Particulars', 'required');
		$this->form_validation->set_rules('units', 'Units', 'required');  

		if ($this->form_validation->run() == FALSE) {   
			echo json_encode($this->form_validation->error_array());
		}else{    
			$returnValue = array();
			$post = $this->input->post();  
			$clean = $this->security->xss_clean($post);
			
			$particulars =  $clean['particulars'];
			$units =  $clean['units'];

			$quote1Found = substr_count($particulars,"'");
			$quote2Found = substr_count($units,"'");

			$systemForAuditName = "TBAMIMS";
			$moduleName = "REFERENCES-MDL";

			
			if( ($quote1Found > 0) || ($quote2Found > 0) ) {
	
				$returnValue['message'] = 'quote';

				$returnValue['success'] = 0;
				echo json_encode($returnValue);
			} else {
				
				$referenceExist = $this->_getRecordsData($selectfields = array('ID'), 
				$tables = array('triune_job_request_materials_tbamims'), 
				$fieldName = array('particulars', 'units'), 
				$where = array($particulars, $units), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				
				$userName = $this->_getUserName(1);
		
				if(empty($referenceExist)) {

	
		
					$insertData1 = null;
					$insertData1 = array(
						'particulars' => strtoupper($particulars),
						'units' => strtoupper($units),
						'userNumber' => $userName,
						'timeStamp' => $this->_getTimeStamp(),
					);				 
		
					$this->db->trans_start();
						$this->_insertRecords($tableName = 'triune_job_request_materials_tbamims', $insertData1);        			 
		
						$insertedRecord1 = $this->_getRecordsData($selectfields = array('ID'), 
						$tables = array('triune_job_request_materials_tbamims'), 
						$fieldName = array('particulars', 'units'), 
						$where = array($particulars, $units), 
						$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
						$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
						$actionName1 = "Insert New Materials";
						$for1 = $insertedRecord1[0]->ID . ";" . $userName;
						$oldValue1 = null;
						$newValue1 =  $insertData1;
						$userType = 1;
						$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		
		

					$this->db->trans_complete();

				
					$fileName1 = "triune_job_request_materials_tbamims-" . $this->_getCurrentDate();
					$text1 = "INSERT INTO triune_job_request_materials_tbamims ";
					$text1 = $text1 .  "VALUES (" .  $insertedRecord1[0]->ID . ", ";
					$text1 = $text1 .  "'".strtoupper($particulars) . "', ";
					$text1 = $text1 .  "'".strtoupper($units) . "', ";
					$text1 = $text1 .  "'".$userName . "', ";
					$text1 = $text1 .  "'".$this->_getTimeStamp();
					$text1 = $text1 . "');";
					$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);


					if ($this->db->trans_status() === FALSE) {
						$this->_transactionFailed();
						$this->db->trans_rollback();
						return FALSE;
					} 
					else {
						$this->db->trans_commit();
						//return TRUE;
					}
					
					$returnValue['ID'] = $insertedRecord1[0]->ID;
					$returnValue['success'] = 1;
					echo json_encode($returnValue);
				} else {
					$returnValue['message'] = 'exist';

					$returnValue['success'] = 0;
					echo json_encode($returnValue);
				
				} //if(empty($referenceExist))
			} //( ($quote1Found !== false) && ($quote2Found !== false) )
		}	//($this->form_validation->run() == FALSE)
	}


	public function insertJobOrderTBAMIMS() {
		
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$requestNumber =  $clean['requestNumber'];
		$requestStatus =  $clean['requestStatus'];
		$workerID =  $clean['workerID'];
		$workerName =  $clean['workerName'];
		$startDatePlanned =  $clean['startDatePlanned'];
		$completionDateTarget =  $clean['completionDateTarget'];
		$jobDescriptionCode =  $clean['jobDescriptionCode'];
		$jobDescription =  $clean['jobDescription'];

		$returnValue = array();

		$userName = $this->_getUserName(1);

		$details = $this->_getTransactionDetails($requestNumber, $from = 'triune_job_request_transaction_tbamims');

		
		$transactionExist = $this->_getRecordsData($selectfields = array('requestNumber'), 
		$tables = array('triune_job_request_job_order'), 
		$fieldName = array('requestNumber'), 
		$where = array($requestNumber), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
			
		if(empty($transactionExist)) {
			$this->db->trans_start();
				//--------------INSERT JOB ORDER-------------------
				if( (strlen($workerID)) > 0) {
					$systemForAuditName = "TBAMIMS";
					$moduleName = "CREATEJOBORDER";
					
					$insertData = null;
					$insertData = array(
						'sy' =>$_SESSION['sy'],
						'requestNumber' =>$requestNumber,
						'requestStatus' => $requestStatus,
						'workerID' => $workerID,
						'workerName' => $workerName,
						'jobDescriptionCode' => $jobDescriptionCode,
						'jobDescription' => $jobDescription,
						'startDatePlanned' => $startDatePlanned,
						'completionDateTarget' => $completionDateTarget,
						'completedFlag' => 'N',
						'userName' => $details[0]->userName,
						'workstationID' => $this->_getIPAddress(),
						'timeStamp' => $this->_getTimeStamp(),
						'updatedBy' => $userName,
						
					);				 
					$this->_insertRecords($tableName = 'triune_job_request_job_order', $insertData);        			 

					$actionName = "Insert Job Order";
					$for = $requestNumber . ";" . $userName;
					$oldValue = null;
					$newValue =  $insertData;
					$userType = 1;
					$this->_insertAuditTrail($actionName, $systemForAuditName, $moduleName, $for, $oldValue, $newValue, $userType);		

					$fileName = "triune_job_request_job_order-" . $this->_getCurrentDate();
					$text = "INSERT INTO triune_job_request_job_order ";
					$text = $text .  "VALUES ('".$requestNumber . "', ";
					$text = $text .  "'".$_SESSION['sy'] . "', ";
					$text = $text .  "'".$requestStatus . "', ";
					$text = $text .  "'".$workerID . "', ";
					$text = $text .  "'".$jobDescription . "', ";
					$text = $text .  "'".$startDatePlanned . "', ";
					$text = $text .  "'".$completionDateTarget . "', ";
					$text = $text .  "'".$details[0]->userName . "', ";
					$text = $text .  "'".$this->_getIPAddress() . "', ";
					$text = $text .  "'".$this->_getTimeStamp() . "', ";
					$text = $text .  "'".$userName . "', ";
					$text = $text . "');";
					$this->_insertTextLog($fileName, $text, $this->LOGFOLDER);
						

				}
				//--------------INSERT JOB ORDER-------------------

			$this->db->trans_complete();


			$returnValue['success'] = 1;
		} else {
			$returnValue['success'] = 0;
			
		}

		echo json_encode($returnValue);
		
	}


	
    public function getAllJobOrderListTBAMIMS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$page = isset($clean['page']) ? intval($clean['page']) : 1;
		$rows = isset($clean['rows']) ? intval($clean['rows']) : 10;
		$ID = isset($clean['ID']) ? $clean['ID'] : '';
		$requestNumber = isset($clean['requestNumber']) ? $clean['requestNumber'] : '';
		$workerName = isset($clean['workerName']) ? $clean['workerName'] : '';
		$completedFlag = isset($clean['completedFlag']) ? $clean['completedFlag'] : '';

		$userName = $this->_getUserName(1);
		 
		$offset = ($page-1)*$rows;
		$result = array();

		$whereSpcl =   "triune_job_request_job_order.ID like '$ID%'"; 
		$whereSpcl =  $whereSpcl . " and triune_job_request_job_order.requestNumber like '$requestNumber%'";
		$whereSpcl =  $whereSpcl . " and triune_job_request_job_order.workerName like '$workerName%'";
		$whereSpcl =  $whereSpcl . " and triune_job_request_job_order.completedFlag like '$completedFlag%'";
	 
		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_job_request_job_order'), $fieldName = array('sy'), $where = array($_SESSION['sy']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('*'), 
			$tables = array('triune_job_request_job_order'), 
			$fieldName = null, $where = null, 
			$join = null, 
			$joinType = null, 
			$sortBy = array('ID'), $sortOrder = array('desc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;

			$result["ID"] = $ID;
			$result["requestNumber"] = $requestNumber;

			echo json_encode($result);
	}
	

    public function getAllRequestListTBAMIMS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$page = isset($clean['page']) ? intval($clean['page']) : 1;
		$rows = isset($clean['rows']) ? intval($clean['rows']) : 10;
		$ID = isset($clean['ID']) ? $clean['ID'] : '';
		$requestStatus = isset($clean['requestStatus']) ? $clean['requestStatus'] : '';
		$userName = isset($clean['userName']) ? $clean['userName'] : '';

		$offset = ($page-1)*$rows;
		$result = array();
		$whereSpcl = "triune_job_request_transaction_tbamims.ID like '$ID%'";
		$whereSpcl = $whereSpcl . " and triune_job_request_transaction_tbamims.requestStatus like '$requestStatus%'";
		$whereSpcl = $whereSpcl . " and triune_job_request_transaction_tbamims.userName like '$userName%'";
	 


		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_job_request_transaction_tbamims'), $fieldName = array('sy'), $where = array($_SESSION['sy']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('triune_job_request_transaction_tbamims.*', 'triune_request_status_reference.requestStatusDescription'), 
			$tables = array('triune_job_request_transaction_tbamims', 'triune_request_status_reference'), 
			$fieldName = array('sy', 'triune_request_status_reference.application'), $where = array($_SESSION['sy'], 'TBAMIMS'), 
			$join = array('triune_job_request_transaction_tbamims.requestStatus = triune_request_status_reference.requestStatusCode'), 
			$joinType = array('left'), 
			$sortBy = array('triune_job_request_transaction_tbamims.ID'), $sortOrder = array('desc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;

			$result["ID"] = $ID;
			//$result["locationCode"] = $locationCode;


			echo json_encode($result);
	}






	public function closeRequestTBAMIMS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$ID =  $clean['ID'];
		$requestStatus =  $clean['requestStatus'];
		$userName = $this->_getUserName(1);


		$this->db->trans_start();

			//--------------UPDATE REQUEST STATUS-------------------
			$systemForAuditName0 = "TBAMIMS";
			$moduleName0 = "REQUESTUPDATE";
			
			$requestStatusUpdate = array(
				'requestStatus' => $requestStatus,
				'dateClosed' => $this->_getCurrentDate()
			);
				
			$this->_updateRecords($tableName = 'triune_job_request_transaction_tbamims', 
			$fieldName = array('ID'), 
			$where = array($ID), $requestStatusUpdate);
			
			$actionName0 = "Update Transaction Request to: " . $requestStatus;
			$for0 = $ID . ";" . $userName;
			$oldValue0 = null;
			$newValue0 =  $requestStatusUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName0, $systemForAuditName0, $moduleName0, $for0, $oldValue0, $newValue0, $userType);		

			$fileName0 = "triune_job_request_transaction_tbamims-" . $this->_getCurrentDate();
			$text0 = "UPDATE triune_job_request_transaction_tbamims ";
			$text0 = $text0 .  "SET requestStatus = '" .  $requestStatus . "', ";
			$text0 = $text0 .  "dateClosed = '" .  $this->_getCurrentDate() . "' ";
			$text0 = $text0 .  "WHERE ID = ".$ID;
			$this->_insertTextLog($fileName0, $text0, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATUS-------------------



			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_tbamims');


			//--------------UPDATE REQUEST STATATUS HISTORY-------------------
			$systemForAuditName1 = "TBAMIMS";
			$moduleName1 = "REQUESTSTATUSHISTORY";

			$insertData1 = null;
			$insertData1 = array(
				'sy' =>$_SESSION['sy'],
				'requestNumber' =>$ID,
				'requestStatus' => $requestStatus,
				'userName' => $details[0]->userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 
			$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_status_history', $insertData1);        			 


			$actionName1 = "Update Request Status History with: " . $requestStatus;
			$for1 = $ID . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $insertData1;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName1, $moduleName1, $for1, $oldValue1, $newValue1, $userType);		

			$fileName1 = "triune_job_request_transaction_tbamims_status_history-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_tbamims_status_history ";
			$text1 = $text1 .  "VALUES ('".$ID . "', ";
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
			$text1 = $text1 .  "'".$requestStatus . "', ";
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATATUS HISTORY-------------------

			
		$this->db->trans_complete();


		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);


	}


	public function returnRequestTBAMIMS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$ID =  $clean['ID'];
		$requestStatus =  $clean['requestStatus'];
		$returnedFrom =  $clean['returnedFrom'];
		$specialInstructions =  $clean['specialInstructions'];
		$scopeDetails =  $clean['scopeDetails'];
		$requestStatusRemarksID =  $clean['requestStatusRemarksID'];
		
		$userName = $this->_getUserName(1);


		$this->db->trans_start();

			//--------------UPDATE REQUEST STATUS-------------------
			$systemForAuditName0 = "TBAMIMS";
			$moduleName0 = "REQUESTUPDATE";
			
			$requestStatusUpdate = array(
				'requestStatus' => $requestStatus,
				'returnedFrom' => $returnedFrom
			);
				
			$this->_updateRecords($tableName = 'triune_job_request_transaction_tbamims', 
			$fieldName = array('ID'), 
			$where = array($ID), $requestStatusUpdate);
			
			$actionName0 = "Update Transaction Request to: " . $requestStatus;
			$for0 = $ID . ";" . $userName;
			$oldValue0 = null;
			$newValue0 =  $requestStatusUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName0, $systemForAuditName0, $moduleName0, $for0, $oldValue0, $newValue0, $userType);		

			$fileName0 = "triune_job_request_transaction_tbamims-" . $this->_getCurrentDate();
			$text0 = "UPDATE triune_job_request_transaction_tbamims ";
			$text0 = $text0 .  "SET requestStatus = '" .  $requestStatus . "', ";
			$text0 = $text0 .  "returnedFrom = '" .  $returnedFrom . "' ";
			$text0 = $text0 .  "WHERE ID = ".$ID;
			$this->_insertTextLog($fileName0, $text0, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATUS-------------------



			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_tbamims');


			//--------------UPDATE REQUEST STATATUS HISTORY-------------------
			$systemForAuditName1 = "TBAMIMS";
			$moduleName1 = "REQUESTSTATUSHISTORY";

			$insertData1 = null;
			$insertData1 = array(
				'sy' =>$_SESSION['sy'],
				'requestNumber' =>$ID,
				'requestStatus' => $requestStatus,
				'returnedFrom' => $returnedFrom,
				'userName' => $details[0]->userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 
			$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_status_history', $insertData1);        			 


			$actionName1 = "Update Request Status History with: " . $requestStatus;
			$for1 = $ID . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $insertData1;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName1, $moduleName1, $for1, $oldValue1, $newValue1, $userType);		

			$fileName1 = "triune_job_request_transaction_tbamims_status_history-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_tbamims_status_history ";
			$text1 = $text1 .  "VALUES ('".$ID . "', ";
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
			$text1 = $text1 .  "'".$requestStatus . "', ";
			$text1 = $text1 .  "'".$returnedFrom . "', ";
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATATUS HISTORY-------------------

			
			
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------
			if( (strlen($specialInstructions)) > 0) {
				$systemForAuditName2 = "TBAMIMS";
				$moduleName2 = "REQUESTSPECIALINSTRUCTIONS";

				$insertData2 = null;
				$insertData2 = array(
					'sy' =>$_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'specialInstructions' => $specialInstructions,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_special_instructions', $insertData2);        			 

				$actionName2 = "Insert Request Special Instructions";
				$for2 = $ID . ";" . $userName;
				$oldValue2 = null;
				$newValue2 =  $insertData2;
				$userType = 1;
				$this->_insertAuditTrail($actionName2, $systemForAuditName2, $moduleName2, $for2, $oldValue2, $newValue2, $userType);		

				$fileName2 = "triune_job_request_transaction_tbamims_special_instructions-" . $this->_getCurrentDate();
				$text2 = "INSERT INTO triune_job_request_transaction_tbamims_special_instructions ";
				$text2 = $text2 .  "VALUES ('".$ID . "', ";
				$text2 = $text2 .  "'".$_SESSION['sy'] . "', ";
				$text2 = $text2 .  "'".$requestStatus . "', ";
				$text2 = $text2 .  "'".$specialInstructions . "', ";
				$text2 = $text2 .  "'".$details[0]->userName . "', ";
				$text2 = $text2 .  "'".$this->_getIPAddress() . "', ";
				$text2 = $text2 .  "'".$this->_getTimeStamp() . "', ";
				$text2 = $text2 .  "'".$userName . "', ";
				$text2 = $text2 . "');";
				$this->_insertTextLog($fileName2, $text2, $this->LOGFOLDER);
					

			}
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------


			//--------------INSERT REQUEST SCOPE DETAILS-------------------
			$systemForAuditName3 = "TBAMIMS";
			$moduleName3 = "REQUESTSCOPEDETAILS";

			if( (strlen($scopeDetails)) > 0) {
				$insertData3 = null;
				$insertData3 = array(
					'sy' =>$_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'scopeDetails' => $scopeDetails,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_scope_details', $insertData3);        			 
				
				$actionName3 = "Insert Request Scope Details";
				$for3 = $ID . ";" . $userName;
				$oldValue3 = null;
				$newValue3 =  $insertData3;
				$userType = 1;
				$this->_insertAuditTrail($actionName3, $systemForAuditName3, $moduleName3, $for3, $oldValue3, $newValue3, $userType);		

				$fileName3 = "triune_job_request_transaction_tbamims_scope_details-" . $this->_getCurrentDate();
				$text3 = "INSERT INTO triune_job_request_transaction_tbamims_scope_details ";
				$text3 = $text3 .  "VALUES ('".$ID . "', ";
				$text3 = $text3 .  "'".$_SESSION['sy'] . "', ";
				$text3 = $text3 .  "'".$requestStatus . "', ";
				$text3 = $text3 .  "'".$scopeDetails . "', ";
				$text3 = $text3 .  "'".$details[0]->userName . "', ";
				$text3 = $text3 .  "'".$this->_getIPAddress() . "', ";
				$text3 = $text3 .  "'".$this->_getTimeStamp() . "', ";
				$text3 = $text3 .  "'".$userName . "', ";
				$text3 = $text3 . "');";
				$this->_insertTextLog($fileName3, $text3, $this->LOGFOLDER);
			}
			//--------------INSERT REQUEST SCOPE DETAILS-------------------





			//--------------INSERT REQUEST STATUS REMARKS-------------------
			$systemForAuditName5 = "TBAMIMS";
			$moduleName5 = "REQUESTSTATUSREMARKS";

			if( (strlen($requestStatusRemarksID)) > 0) {
				$insertData5 = null;
				$insertData5 = array(
					'sy' =>$_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'requestStatusRemarksID' => $requestStatusRemarksID,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_status_remarks', $insertData5);        			 
				
				$actionName5 = "Insert Request Status Remarks";
				$for5 = $ID . ";" . $userName;
				$oldValue5 = null;
				$newValue5 =  $insertData5;
				$userType = 1;
				$this->_insertAuditTrail($actionName5, $systemForAuditName5, $moduleName5, $for5, $oldValue5, $newValue5, $userType);		

				$fileName5 = "triune_job_request_transaction_tbamims_status_remarks-" . $this->_getCurrentDate();
				$text5 = "INSERT INTO triune_job_request_transaction_tbamims_status_remarks ";
				$text5 = $text5 .  "VALUES ('".$ID . "', ";
				$text5 = $text5 .  "'".$_SESSION['sy'] . "', ";
				$text5 = $text5 .  "'".$requestStatus . "', ";
				$text5 = $text5 .  "'".$requestStatusRemarksID . "', ";
				$text5 = $text5 .  "'".$details[0]->userName . "', ";
				$text5 = $text5 .  "'".$this->_getIPAddress() . "', ";
				$text5 = $text5 .  "'".$this->_getTimeStamp() . "', ";
				$text5 = $text5 .  "'".$userName . "', ";
				$text5 = $text5 . "');";
				$this->_insertTextLog($fileName5, $text5, $this->LOGFOLDER);
			}
			//--------------INSERT REQUEST STATUS REMARKS-------------------

			
			
			
		$this->db->trans_complete();


		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);


	}
	
	public function updateRequestMultipleStatusTBAMIMS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$ID =  $clean['ID'];
		$requestStatus =  $clean['requestStatus'];
		$specialInstructions =  $clean['specialInstructions'];
		$scopeDetails =  $clean['scopeDetails'];
		$requestStatusRemarksID =  $clean['requestStatusRemarksID'];
		
		$userName = $this->_getUserName(1);


		$this->db->trans_start();

			//--------------UPDATE REQUEST STATUS-------------------
			$systemForAuditName0 = "TBAMIMS";
			$moduleName0 = "REQUESTUPDATE";
			
			$requestStatusUpdate = array(
				'requestStatus' => $requestStatus,
			);
				
			$this->_updateRecords($tableName = 'triune_job_request_transaction_tbamims', 
			$fieldName = array('ID'), 
			$where = array($ID), $requestStatusUpdate);
			
			$actionName0 = "Update Transaction Request to: " . $requestStatus;
			$for0 = $ID . ";" . $userName;
			$oldValue0 = null;
			$newValue0 =  $requestStatusUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName0, $systemForAuditName0, $moduleName0, $for0, $oldValue0, $newValue0, $userType);		

			$fileName0 = "triune_job_request_transaction_tbamims-" . $this->_getCurrentDate();
			$text0 = "UPDATE triune_job_request_transaction_tbamims ";
			$text0 = $text0 .  "SET requestStatus = '" .  $requestStatus . "' ";
			$text0 = $text0 .  "WHERE ID = ".$ID;
			$this->_insertTextLog($fileName0, $text0, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATUS-------------------



			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_tbamims');

			//--------------UPDATE REQUEST STATATUS HISTORY APPROVED-------------------
			$systemForAuditNameA = "TBAMIMS";
			$moduleNameA = "REQUESTSTATUSHISTORY";

			$insertDataA = null;
			$insertDataA = array(
				'sy' =>$_SESSION['sy'],
				'requestNumber' =>$ID,
				'requestStatus' => 'A',
				'userName' => $details[0]->userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 
			$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_status_history', $insertDataA);        			 


			$actionNameA = "Update Request Status History with: A";
			$forA = $ID . ";" . $userName;
			$oldValueA = null;
			$newValueA =  $insertDataA;
			$userType = 1;
			$this->_insertAuditTrail($actionNameA, $systemForAuditNameA, $moduleNameA, $forA, $oldValueA, $newValueA, $userType);		

			$fileNameA = "triune_job_request_transaction_tbamims_status_history-" . $this->_getCurrentDate();
			$textA = "INSERT INTO triune_job_request_transaction_tbamims_status_history ";
			$textA = $textA .  "VALUES ('".$ID . "', ";
			$textA = $textA .  "'".$_SESSION['sy']. "', ";
			$textA = $textA .  "'".'A'. "', ";
			$textA = $textA .  "'".$details[0]->userName . "', ";
			$textA = $textA .  "'".$this->_getIPAddress() . "', ";
			$textA = $textA .  "'".$this->_getTimeStamp() . "', ";
			$textA = $textA .  "'".$userName . "', ";
			$textA = $textA . "');";
			$this->_insertTextLog($fileNameA, $textA, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATATUS HISTORY APPROVED-------------------
			
			
			

			//--------------UPDATE REQUEST STATATUS HISTORY-------------------
			$systemForAuditName1 = "TBAMIMS";
			$moduleName1 = "REQUESTSTATUSHISTORY";

			$insertData1 = null;
			$insertData1 = array(
				'sy' =>$_SESSION['sy'],
				'requestNumber' =>$ID,
				'requestStatus' => $requestStatus,
				'userName' => $details[0]->userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 
			$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_status_history', $insertData1);        			 


			$actionName1 = "Update Request Status History with: " . $requestStatus;
			$for1 = $ID . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $insertData1;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName1, $moduleName1, $for1, $oldValue1, $newValue1, $userType);		

			$fileName1 = "triune_job_request_transaction_tbamims_status_history-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_tbamims_status_history ";
			$text1 = $text1 .  "VALUES ('".$ID . "', ";
			$text1 = $text1 .  "'".$_SESSION['sy'] . "', ";
			$text1 = $text1 .  "'".$requestStatus . "', ";
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATATUS HISTORY-------------------

			
			
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------
			if( (strlen($specialInstructions)) > 0) {
				$systemForAuditName2 = "TBAMIMS";
				$moduleName2 = "REQUESTSPECIALINSTRUCTIONS";

				$insertData2 = null;
				$insertData2 = array(
					'sy' =>$_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'specialInstructions' => $specialInstructions,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_special_instructions', $insertData2);        			 

				$actionName2 = "Insert Request Special Instructions";
				$for2 = $ID . ";" . $userName;
				$oldValue2 = null;
				$newValue2 =  $insertData2;
				$userType = 1;
				$this->_insertAuditTrail($actionName2, $systemForAuditName2, $moduleName2, $for2, $oldValue2, $newValue2, $userType);		

				$fileName2 = "triune_job_request_transaction_tbamims_special_instructions-" . $this->_getCurrentDate();
				$text2 = "INSERT INTO triune_job_request_transaction_tbamims_special_instructions ";
				$text2 = $text2 .  "VALUES ('".$ID . "', ";
				$text2 = $text2 .  "'".$_SESSION['sy'] . "', ";
				$text2 = $text2 .  "'".$requestStatus . "', ";
				$text2 = $text2 .  "'".$specialInstructions . "', ";
				$text2 = $text2 .  "'".$details[0]->userName . "', ";
				$text2 = $text2 .  "'".$this->_getIPAddress() . "', ";
				$text2 = $text2 .  "'".$this->_getTimeStamp() . "', ";
				$text2 = $text2 .  "'".$userName . "', ";
				$text2 = $text2 . "');";
				$this->_insertTextLog($fileName2, $text2, $this->LOGFOLDER);
					

			}
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------


			//--------------INSERT REQUEST SCOPE DETAILS-------------------
			$systemForAuditName3 = "TBAMIMS";
			$moduleName3 = "REQUESTSCOPEDETAILS";

			if( (strlen($scopeDetails)) > 0) {
				$insertData3 = null;
				$insertData3 = array(
					'sy' =>$_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'scopeDetails' => $scopeDetails,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_scope_details', $insertData3);        			 
				
				$actionName3 = "Insert Request Scope Details";
				$for3 = $ID . ";" . $userName;
				$oldValue3 = null;
				$newValue3 =  $insertData3;
				$userType = 1;
				$this->_insertAuditTrail($actionName3, $systemForAuditName3, $moduleName3, $for3, $oldValue3, $newValue3, $userType);		

				$fileName3 = "triune_job_request_transaction_tbamims_scope_details-" . $this->_getCurrentDate();
				$text3 = "INSERT INTO triune_job_request_transaction_tbamims_scope_details ";
				$text3 = $text3 .  "VALUES ('".$ID . "', ";
				$text3 = $text3 .  "'".$_SESSION['sy'] . "', ";
				$text3 = $text3 .  "'".$requestStatus . "', ";
				$text3 = $text3 .  "'".$scopeDetails . "', ";
				$text3 = $text3 .  "'".$details[0]->userName . "', ";
				$text3 = $text3 .  "'".$this->_getIPAddress() . "', ";
				$text3 = $text3 .  "'".$this->_getTimeStamp() . "', ";
				$text3 = $text3 .  "'".$userName . "', ";
				$text3 = $text3 . "');";
				$this->_insertTextLog($fileName3, $text3, $this->LOGFOLDER);
			}
			//--------------INSERT REQUEST SCOPE DETAILS-------------------





			//--------------INSERT REQUEST STATUS REMARKS-------------------
			$systemForAuditName5 = "TBAMIMS";
			$moduleName5 = "REQUESTSTATUSREMARKS";

			if( (strlen($requestStatusRemarksID)) > 0) {
				$insertData5 = null;
				$insertData5 = array(
					'sy' =>$_SESSION['sy'],
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'requestStatusRemarksID' => $requestStatusRemarksID,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_status_remarks', $insertData5);        			 
				
				$actionName5 = "Insert Request Status Remarks";
				$for5 = $ID . ";" . $userName;
				$oldValue5 = null;
				$newValue5 =  $insertData5;
				$userType = 1;
				$this->_insertAuditTrail($actionName5, $systemForAuditName5, $moduleName5, $for5, $oldValue5, $newValue5, $userType);		

				$fileName5 = "triune_job_request_transaction_tbamims_status_remarks-" . $this->_getCurrentDate();
				$text5 = "INSERT INTO triune_job_request_transaction_tbamims_status_remarks ";
				$text5 = $text5 .  "VALUES ('".$ID . "', ";
				$text5 = $text5 .  "'".$_SESSION['sy'] . "', ";
				$text5 = $text5 .  "'".$requestStatus . "', ";
				$text5 = $text5 .  "'".$requestStatusRemarksID . "', ";
				$text5 = $text5 .  "'".$details[0]->userName . "', ";
				$text5 = $text5 .  "'".$this->_getIPAddress() . "', ";
				$text5 = $text5 .  "'".$this->_getTimeStamp() . "', ";
				$text5 = $text5 .  "'".$userName . "', ";
				$text5 = $text5 . "');";
				$this->_insertTextLog($fileName5, $text5, $this->LOGFOLDER);
			}
			//--------------INSERT REQUEST STATUS REMARKS-------------------

			
			
			
		$this->db->trans_complete();


		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);


	}



	public function insertLocationTBAMIMS() {
		
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);

		$locationCode =  $clean['locationCode'];
		$locationDescription =  $clean['locationDescription'];
		$locationType =  $clean['locationType'];

		$returnValue = array();

		$userName = $this->_getUserName(1);


		
		$transactionExist = $this->_getRecordsData($selectfields = array('ID'), 
		$tables = array('triune_location'), 
		$fieldName = array('locationCode', 'locationDescription'), 
		$where = array($locationCode, $locationDescription), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
			
		if(empty($transactionExist)) {
			$this->db->trans_start();
				//--------------INSERT LOCATION-------------------
					$systemForAuditName = "TBAMIMS";
					$moduleName = "CREATELOCATION";
					
					$insertData = null;
					$insertData = array(
						'locationCode' =>$locationCode,
						'locationDescription' => $locationDescription,
						'locationType' => $locationType,
						'userNumber' => $userName,
						'timeStamp' => $this->_getTimeStamp(),
					);				 
					$newID = $this->_insertRecords($tableName = 'triune_location', $insertData);        			 

					$actionName = "Insert Location";
					$for = $newID . ";" . $userName;
					$oldValue = null;
					$newValue =  $insertData;
					$userType = 1;
					$this->_insertAuditTrail($actionName, $systemForAuditName, $moduleName, $for, $oldValue, $newValue, $userType);		

					$fileName = "triune_location-" . $this->_getCurrentDate();
					$text = "INSERT INTO triune_location ";
					$text = $text .  "VALUES ('".$newID . "', ";
					$text = $text .  "'".$locationCode . "', ";
					$text = $text .  "'".$locationDescription . "', ";
					$text = $text .  "'".$locationType . "', ";
					$text = $text .  "'".$userName . "', ";
					$text = $text .  "'".$this->_getTimeStamp() . "'";
					$text = $text . ");";
					$this->_insertTextLog($fileName, $text, $this->LOGFOLDER);
						

				//--------------INSERT LOCATION-------------------

			$this->db->trans_complete();


			$returnValue['success'] = 1;
		} else {
			$returnValue['success'] = 0;
			
		}

		echo json_encode($returnValue);
		
	}


	public function updateLocationTBAMIMS() {
		$locationCode = $_POST["locationCode"];
		$locationDescription = $_POST["locationDescription"];
		$locationType = $_POST["locationType"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

		$details = $this->_getTransactionDetails($ID, $from = 'triune_location');
	
		$systemForAuditName = "TBAMIMS";
		$moduleName = "LOCATIONSUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'locationDescription' => $locationDescription,
				'locationType' => $locationType,
			);
		
			$this->_updateRecords($tableName = 'triune_location', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Location";
			$for1 = $locationCode . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $locationDescription . ';' . $locationType;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_location-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_location ";
		$text1 = $text1 .  "SET locationDescription = '" .  $details[0]->locationDescription . "', ";
		$text1 = $text1 .  "locationType = '" .  $details[0]->locationType . "' ";
		$text1 = $text1 .  "WHERE ID = ".$ID;
		$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		if($this->db->trans_status() === FALSE) {
			$this->_transactionFailed();
			return FALSE;  
		} 

		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}	










	public function insertRoomsTBAMIMS() {
		
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);

		$roomNumber =  $clean['roomNumber'];
		$floor =  $clean['floor'];
		$locationCode =  $clean['locationCode'];
		$roomType =  $clean['roomType'];
		$occupantCount =  $clean['occupantCount'];
		$airconditionCount =  $clean['airconditionCount'];
		$roomDescription =  $clean['roomDescription'];
		$remarks =  $clean['remarks'];

		$returnValue = array();

		$userName = $this->_getUserName(1);


		
		$transactionExist = $this->_getRecordsData($selectfields = array('ID'), 
		$tables = array('triune_rooms'), 
		$fieldName = array('roomNumber'), 
		$where = array($roomNumber), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
			
		if(empty($transactionExist)) {
			$this->db->trans_start();
				//--------------INSERT LOCATION-------------------
					$systemForAuditName = "TBAMIMS";
					$moduleName = "CREATEROOM";
					
					$insertData = null;
					$insertData = array(
						'roomNumber' =>$roomNumber,
						'floor' => $floor,
						'locationCode' => $locationCode,
						'roomType' =>$roomType,
						'occupantCount' => $occupantCount,
						'airconditionCount' => $airconditionCount,
						'roomDescription' => $roomDescription . " - " . $roomNumber,
						'remarks' => $remarks,
						'userNumber' => $userName,
						'timeStamp' => $this->_getTimeStamp(),
					);				 
					$newID = $this->_insertRecords($tableName = 'triune_rooms', $insertData);        			 

					$actionName = "Insert Room";
					$for = $newID . ";" . $userName;
					$oldValue = null;
					$newValue =  $insertData;
					$userType = 1;
					$this->_insertAuditTrail($actionName, $systemForAuditName, $moduleName, $for, $oldValue, $newValue, $userType);		

					$fileName = "triune_rooms-" . $this->_getCurrentDate();
					$text = "INSERT INTO triune_rooms ";
					$text = $text .  "VALUES ('".$newID . "', ";
					$text = $text .  "'".$roomNumber . "', ";
					$text = $text .  "'".$floor . "', ";
					$text = $text .  "'".$locationType . "', ";
					$text = $text .  "'".$roomType . "', ";
					$text = $text .  "'".$occupantCount . "', ";
					$text = $text .  "'".$airconditionCount . "', ";
					$text = $text .  "'".$roomDescription . " - " . $roomNumber . "', ";
					$text = $text .  "'".$remarks . "', ";
					$text = $text .  "'".$userName . "', ";
					$text = $text .  "'".$this->_getTimeStamp() . "'";
					$text = $text . ");";
					$this->_insertTextLog($fileName, $text, $this->LOGFOLDER);
						

				//--------------INSERT LOCATION-------------------

			$this->db->trans_complete();


			$returnValue['success'] = 1;
		} else {
			$returnValue['success'] = 0;
			
		}

		echo json_encode($returnValue);
		
	}
	
	
	public function updateRoomTBAMIMS() {
		$roomType = $_POST["roomType"];
		$occupantCount = $_POST["occupantCount"];
		$airconditionCount = $_POST["airconditionCount"];
		$roomDescription = $_POST["roomDescription"];
		$remarks = $_POST["remarks"];
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);

		$details = $this->_getTransactionDetails($ID, $from = 'triune_rooms');
	
		$systemForAuditName = "TBAMIMS";
		$moduleName = "ROOMUPDATE";

		$this->db->trans_start();

			$recordUpdate = array(
				'roomType' => $roomType,
				'occupantCount' => $occupantCount,
				'airconditionCount' => $airconditionCount,
				'roomDescription' => $roomDescription,
				'remarks' => $remarks,
			);
		
			$this->_updateRecords($tableName = 'triune_rooms', 
			$fieldName = array('ID'), 
			$where = array($ID), $recordUpdate);


			$actionName1 = "Update Room";
			$for1 = $ID . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $recordUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

		$this->db->trans_complete();
	
		$fileName1 = "triune_rooms-update-" . $this->_getCurrentDate();
		$text1 = "UPDATE triune_rooms ";
		$text1 = $text1 .  "SET roomType = '" .  $details[0]->roomType . "', ";
		$text1 = $text1 .  "occupantCount = '" .  $details[0]->occupantCount . "' ";
		$text1 = $text1 .  "airconditionCount = '" .  $details[0]->airconditionCount . "' ";
		$text1 = $text1 .  "roomDescription = '" .  $details[0]->roomDescription . "' ";
		$text1 = $text1 .  "remarks = '" .  $details[0]->remarks . "' ";
		$text1 = $text1 .  "WHERE ID = ".$ID;
		$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

		if($this->db->trans_status() === FALSE) {
			$this->_transactionFailed();
			return FALSE;  
		} 

		
		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}	

	
	
}