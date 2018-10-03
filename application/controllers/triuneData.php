<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class triuneData extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Data Controller.  
	 * DATE CREATED: April 22, 2018
     * DATE UPDATED: May 14, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('form_validation'); 
    }//function __construct()


    public function getLocationCode() {
		$results = $this->_getRecordsData($data = array('locationCode', 'locationDescription'), 
			$tables = array('triune_location'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('locationDescription'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
	}

    public function getFloor() {
		$locationCode = $_GET["locationCode"];
		//echo $locationCode;
		$results = $this->_getRecordsData($data = array('floor', 'locationCode'), 
			$tables = array('triune_rooms'), $fieldName = array('locationCode'), $where = array($locationCode), $join = null, $joinType = null, 
			$sortBy = array('floor'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
	}

	public function getRoomNumber() {
		$floor = $_GET["floor"];
		$locationCode = $_GET["locationCode"];

		$results = $this->_getRecordsData($data = array('roomNumber', 'roomDescription'), 
			$tables = array('triune_rooms'), $fieldName = array('floor', 'locationCode'), $where = array($floor, $locationCode), $join = null, $joinType = null, 
			$sortBy = array('roomNumber'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			echo json_encode($results);
	}


	public function setRequestBAM() {

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

	public function insertRequestBAM() {
		$locationCode = $_POST["locationCode"];
		$floor = $_POST["floor"];
		$roomNumber = $_POST["roomNumber"];
		$projectTitle = $_POST["projectTitle"];
		$scopeOfWorks = $_POST["scopeOfWorks"];
		$projectJustification = $_POST["projectJustification"];
		$dateNeeded = $_POST["dateNeeded"];
		
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('locationCode'), 
		$tables = array('triune_job_request_transaction_bam'), 
		$fieldName = array('locationCode', 'floor', 'roomNumber', 'projectTitle', 'scopeOfWorks', 'projectJustification', 'dateNeeded', 'userName'), 
		$where = array($locationCode, $floor, $roomNumber, $projectTitle, $scopeOfWorks, $projectJustification, $dateNeeded, $userName), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		

		if(empty($transactionExist)) {

			$systemForAuditName = "BAMJRS";
			$moduleName = "Create Request";

			$insertData1 = null;
			$insertData1 = array(
				'locationCode' => $locationCode,
				'floor' => $floor,
				'roomNumber' => $roomNumber,
				'projectTitle' => $projectTitle,
				'scopeOfWorks' => $scopeOfWorks, 
				'projectJustification' => $projectJustification,
				'requestStatus' => $this->_getRequestStatus('NEW', 'BAM'),
				'dateNeeded' => $dateNeeded,
				'dateCreated' => $this->_getCurrentDate(),
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
			);				 

			$this->db->trans_start();
				$this->_insertRecords($tableName = 'triune_job_request_transaction_bam', $insertData1);        			 

				$insertedRecord1 = $this->_getRecordsData($data = array('ID'), 
				$tables = array('triune_job_request_transaction_bam'), 
				$fieldName = array('locationCode', 'floor', 'roomNumber', 'projectTitle', 'scopeOfWorks', 'projectJustification', 'dateNeeded', 'userName'), 
				$where = array($locationCode, $floor, $roomNumber, $projectTitle, $scopeOfWorks, $projectJustification, $dateNeeded, $userName), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

				$actionName1 = "Insert New Transaction Request";
				$for1 = $insertedRecord1[0]->ID . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1);		


			$insertData2 = null;
			$insertData2 = array(
				'requestNumber' =>$insertedRecord1[0]->ID,
				'requestStatus' => $this->_getRequestStatus('NEW', 'BAM'),
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
			);				 

				$this->_insertRecords($tableName = 'triune_job_request_transaction_bam_status_history', $insertData2);        			 

				$insertedRecord2 = $this->_getRecordsData($data = array('ID'), 
				$tables = array('triune_job_request_transaction_bam_status_history'), 
				$fieldName = array('requestNumber', 'requestStatus', 'userName'), 
				$where = array($insertedRecord1[0]->ID, $this->_getRequestStatus('NEW', 'BAM'), $userName), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

				$actionName2 = "Insert New Transaction Request Status History";
				$for2 = $insertedRecord2[0]->ID . ";" .$userName;
				$oldValue2 = null;
				$newValue2 =  $insertData2;
				$this->_insertAuditTrail($actionName2, $systemForAuditName, $moduleName, $for2, $oldValue2, $newValue2);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_job_request_transaction_bam-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_bam ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1[0]->ID . ", ";
			$text1 = $text1 .  "'".$locationCode . "', ";
			$text1 = $text1 .  "'".$floor . "', ";
			$text1 = $text1 .  "'".$roomNumber . "', ";
			$text1 = $text1 .  "'".$projectTitle . "', ";
			$text1 = $text1 .  "'".$scopeOfWorks . "', ";
			$text1 = $text1 .  "'".$projectJustification . "', ";
			$text1 = $text1 .  "'".$this->_getRequestStatus('NEW', 'BAM') . "', ";
			$text1 = $text1 .  "'".$dateNeeded . "', ";
			$text1 = $text1 .  "'".$this->_getCurrentDate() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp();
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1);

			$fileName2 = "triune_job_request_transaction_bam_status_history-" . $this->_getCurrentDate();
			$text2 = "INSERT INTO triune_job_request_transaction_bam_status_history ";
			$text2 = $text2 .  "VALUES (" .  $insertedRecord2[0]->ID . ", ";
			$text2 = $text2 .  "'".$insertedRecord1[0]->ID . "', ";
			$text2 = $text2 .  "'".$this->_getRequestStatus('NEW', 'BAM') . "', ";
			$text2 = $text2 .  "'".$userName . "', ";
			$text2 = $text2 .  "'".$this->_getIPAddress() . "', ";
			$text2 = $text2 .  "'".$this->_getTimeStamp();
			$text2 = $text2 . "');";
			$this->_insertTextLog($fileName2, $text2);
			

			if($this->db->trans_status() === FALSE) {
				$this->_transactionFailed();
				return FALSE;  
			} 

			$returnValue = array();
			$returnValue['ID'] = $insertedRecord1[0]->ID;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} //if(empty($transactionExist))

	}


    public function getBAMJRSMyRequestList() {
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
		$whereSpcl = "triune_job_request_transaction_bam.userName = '$userName'"; 
		$whereSpcl =  $whereSpcl . " and triune_job_request_transaction_bam.ID like '$ID%'"; 
		$whereSpcl =  $whereSpcl . " and triune_job_request_transaction_bam.locationCode like '$locationCode%'";
		$whereSpcl =  $whereSpcl . " and triune_job_request_transaction_bam.requestStatus like '$requestStatus%'";
	 
		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_job_request_transaction_bam'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('triune_job_request_transaction_bam.*', 'triune_request_status_reference.requestStatusDescription'), 
			$tables = array('triune_job_request_transaction_bam', 'triune_request_status_reference'), 
			$fieldName = array('triune_request_status_reference.application'), $where = array('BAM'), 
			$join = array('triune_job_request_transaction_bam.requestStatus = triune_request_status_reference.requestStatusCode'), 
			$joinType = array('left'), 
			$sortBy = array('triune_job_request_transaction_bam.ID'), $sortOrder = array('desc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;

			$result["ID"] = $ID;
			$result["locationCode"] = $locationCode;

			echo json_encode($result);
	}



    public function getBAMJRSRequestList() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$page = isset($clean['page']) ? intval($clean['page']) : 1;
		$rows = isset($clean['rows']) ? intval($clean['rows']) : 10;
		$ID = isset($clean['ID']) ? $clean['ID'] : '';
		$locationCode = isset($clean['locationCode']) ? $clean['locationCode'] : '';
		$requestStatus = isset($clean['requestStatus']) ? $clean['requestStatus'] : '';
		$offset = ($page-1)*$rows;
		$result = array();
		$whereSpcl = "triune_job_request_transaction_bam.requestStatus = '$requestStatus' and triune_job_request_transaction_bam.ID like '$ID%' and triune_job_request_transaction_bam.locationCode like '$locationCode%'";
	 


		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_job_request_transaction_bam'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('triune_job_request_transaction_bam.*', 'triune_request_status_reference.requestStatusDescription'), 
			$tables = array('triune_job_request_transaction_bam', 'triune_request_status_reference'), 
			$fieldName = array('triune_request_status_reference.application'), $where = array('BAM'), 
			$join = array('triune_job_request_transaction_bam.requestStatus = triune_request_status_reference.requestStatusCode'), 
			$joinType = array('left'), 
			$sortBy = array('triune_job_request_transaction_bam.ID'), $sortOrder = array('desc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;

			$result["ID"] = $ID;
			$result["locationCode"] = $locationCode;


			echo json_encode($result);
	}


	public function updateBAMRequestStatus() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$ID =  $clean['ID'];
		$requestStatus =  $clean['requestStatus'];
		$specialInstructions =  $clean['specialInstructions'];
		$scopeDetails =  $clean['scopeDetails'];
		$qty =  $clean['qty'];
		$materialsID =  $clean['materialsID'];

		//print_r($qty);
		echo json_encode($ID . $requestStatus . trim($specialInstructions) . trim($scopeDetails) . $qty[2] . $materialsID[2]) ;
		//echo json_encode("Hello");
		/*$userName = $this->_getUserName(1);

		$requestStatusUpdate = array(
			'requestStatus' => $requestStatus,
		);
		$this->_updateRecords($tableName = 'triune_job_request_transaction_bam', 
		$fieldName = array('ID'), 
		$where = array($ID), $requestStatusUpdate);


		$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_bam');


		$insertData2 = null;
		$insertData2 = array(
			'requestNumber' =>$ID,
			'requestStatus' => $requestStatus,
			'specialInstructions' => $specialInstructions,
			'userName' => $details[0]->userName,
			'workstationID' => $this->_getIPAddress(),
			'timeStamp' => $this->_getTimeStamp(),
			'updatedBy' => $userName,
			
		);				 
		$this->_insertRecords($tableName = 'triune_job_request_transaction_bam_status_history', $insertData2);        			 
		$returnValue = array();
					
		$returnValue['success'] = 1;
		echo json_encode($returnValue);*/


	}


}