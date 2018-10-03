<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityDataPurchasing extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Purchasing Data Controller.  
	 * DATE CREATED: July 15, 2018
     * DATE UPDATED: July 15, 2018
	 */
	var	$LOGFOLDER = 'asrs';

    function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('form_validation'); 
    }//function __construct()



	public function validateRequestASRS() {

		$this->form_validation->set_rules('requestPurpose', 'Request Purpose', 'required');
		$this->form_validation->set_rules('requestRemarks', 'Request Remarks', 'required');  
		$this->form_validation->set_rules('dateNeeded', 'Date Needed', 'required|regex_match[/\d{4}\-\d{2}-\d{2}/]');    

		$requestPurpose = $_POST["requestPurpose"];
		$requestRemarks = $_POST["requestRemarks"];
		$dateNeeded = $_POST["dateNeeded"];

		$this->session->set_flashdata('requestPurpose', $requestPurpose);
		$this->session->set_flashdata('requestRemarks', $requestRemarks);
		$this->session->set_flashdata('dateNeeded', $dateNeeded);


		if ($this->form_validation->run() == FALSE) {   
			echo json_encode($this->form_validation->error_array());
		}else{    

			$returnValue = array();
			
			$returnValue['requestPurpose'] = $requestPurpose;
			$returnValue['requestRemarks'] = $requestRemarks;
			$returnValue['dateNeeded'] = $dateNeeded;

			$returnValue['success'] = 1;
			echo json_encode($returnValue);
			
		}	

	}

	public function insertRequestASRS() {
		$requestPurpose = $_POST["requestPurpose"];
		$requestRemarks = $_POST["requestRemarks"];
		$dateNeeded = $_POST["dateNeeded"];
		
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('requestPurpose'), 
		$tables = array('triune_job_request_transaction_asrs'), 
		$fieldName = array('requestPurpose', 'requestRemarks', 'dateNeeded', 'userName'), 
		$where = array($requestPurpose, $requestRemarks, $dateNeeded, $userName), 
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
		
		
		
		
			$systemForAuditName = "ASRS";
			$moduleName = "REQUESTCREATE";

			$insertData1 = null;
			$insertData1 = array(
				'requestPurpose' => $requestPurpose,
				'requestRemarks' => $requestRemarks,
				'requestStatus' => $this->_getRequestStatus('NEW', 'ASRS'),
				'departmentUnit' => $departmentUnit,
				'dateNeeded' => $dateNeeded,
				'dateCreated' => $this->_getCurrentDate(),
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 

			$this->db->trans_start();
				$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs', $insertData1);        			 

				$insertedRecord1 = $this->_getRecordsData($data = array('ID'), 
				$tables = array('triune_job_request_transaction_asrs'), 
				$fieldName = array('requestPurpose', 'requestRemarks', 'dateNeeded', 'userName'), 
				$where = array($requestPurpose, $requestRemarks, $dateNeeded, $userName), 
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
				'requestNumber' =>$insertedRecord1[0]->ID,
				'requestStatus' => $this->_getRequestStatus('NEW', 'ASRS'),
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
			);				 

				$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_status_history', $insertData2);        			 

				$insertedRecord2 = $this->_getRecordsData($data = array('ID'), 
				$tables = array('triune_job_request_transaction_asrs_status_history'), 
				$fieldName = array('requestNumber', 'requestStatus', 'userName'), 
				$where = array($insertedRecord1[0]->ID, $this->_getRequestStatus('NEW', 'ASRS'), $userName), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

				$actionName2 = "Insert New Transaction Request Status History";
				$for2 = $insertedRecord2[0]->ID . ";" .$userName;
				$oldValue2 = null;
				$newValue2 =  $insertData2;
				$userType = 1; 
				$this->_insertAuditTrail($actionName2, $systemForAuditName, $moduleName, $for2, $oldValue2, $newValue2, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_job_request_transaction_asrs-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_asrs ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1[0]->ID . ", ";
			$text1 = $text1 .  "'".$requestPurpose . "', ";
			$text1 = $text1 .  "'".$requestRemarks . "', ";
			$text1 = $text1 .  "'".$this->_getRequestStatus('NEW', 'ASRS') . "', ";
			$text1 = $text1 .  "'".$dateNeeded . "', ";
			$text1 = $text1 .  "'".$this->_getCurrentDate() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp();
			$text1 = $text1 .  "'".$userName;
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);

			$fileName2 = "triune_job_request_transaction_asrs_status_history-" . $this->_getCurrentDate();
			$text2 = "INSERT INTO triune_job_request_transaction_asrs_status_history ";
			$text2 = $text2 .  "VALUES (" .  $insertedRecord2[0]->ID . ", ";
			$text2 = $text2 .  "'".$insertedRecord1[0]->ID . "', ";
			$text2 = $text2 .  "'".$this->_getRequestStatus('NEW', 'ASRS') . "', ";
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
			$returnValue['ID'] = $insertedRecord1[0]->ID;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} //if(empty($transactionExist))

	}

	public function validateRequestItemsASRS() {

		$this->form_validation->set_rules('quantity', 'Quantiy', 'required');
		$this->form_validation->set_rules('unitCode', 'Unit', 'required');  
		$this->form_validation->set_rules('assetName', 'Asset Description', 'required');    

		$quantity = $_POST["quantity"];
		$unitCode = $_POST["unitCode"];
		$assetName = $_POST["assetName"];

		$this->session->set_flashdata('quantity', $quantity);
		$this->session->set_flashdata('unitCode', $unitCode);
		$this->session->set_flashdata('assetName', $assetName);


		if ($this->form_validation->run() == FALSE) {   
			echo json_encode($this->form_validation->error_array());
		}else{    

			$returnValue = array();
			
			$returnValue['quantity'] = $quantity;
			$returnValue['unitCode'] = $unitCode;
			$returnValue['assetName'] = $assetName;

			$returnValue['success'] = 1;
			echo json_encode($returnValue);
			
		}	

	}


	public function validateSupplierNameASRS() {

		$this->form_validation->set_rules('supplierName', 'Supplier Name', 'required');
		$this->form_validation->set_rules('supplierNameText', 'Supplier Name Text', 'required');  

		$supplierName = $_POST["supplierName"];
		$supplierNameText = $_POST["supplierNameText"];

		$this->session->set_flashdata('supplierName', $supplierName);
		$this->session->set_flashdata('supplierNameText', $supplierNameText);


		if ($this->form_validation->run() == FALSE) {   
			echo json_encode($this->form_validation->error_array());
		}else{    

			$returnValue = array();
			
			$returnValue['supplierName'] = $supplierName;
			$returnValue['supplierNameText'] = $supplierNameText;

			$returnValue['success'] = 1;
			echo json_encode($returnValue);
			
		}	

	}
		

	public function validatePBACMemberASRS() {

		$this->form_validation->set_rules('pbacUnit', 'PBAC Member Unit', 'required');
		$this->form_validation->set_rules('pbacUnitText', 'PBAC Member Unit', 'required');  

		$pbacUnit = $_POST["pbacUnit"];
		$pbacUnitText = $_POST["pbacUnitText"];

		$this->session->set_flashdata('pbacUnit', $pbacUnit);
		$this->session->set_flashdata('pbacUnitText', $pbacUnitText);


		if ($this->form_validation->run() == FALSE) {   
			echo json_encode($this->form_validation->error_array());
		}else{    

			$returnValue = array();
			
			$returnValue['pbacUnit'] = $pbacUnit;
			$returnValue['pbacUnitText'] = $pbacUnitText;

			$returnValue['success'] = 1;
			echo json_encode($returnValue);
			
		}	

	}
		
	public function insertRequestItemsASRS() {
		$ID = $_POST["ID"];
		$quantity = $_POST["quantity"];
		$unitCode = $_POST["unitCode"];
		$assetName = $_POST["assetName"];
		$unitCodeText = $_POST["unitCodeText"];
		$assetNameText = $_POST["assetNameText"];
		
		$uct = explode(";", $assetName);

		$assetGroupCd =  null;
		$assetSubGroupCd =  null;
		$assetCompGroupCd =  null;
		
		if(count($uct) > 1) {
			$assetGroupCd =  $uct[0];
			$assetSubGroupCd =  $uct[1];
			$assetCompGroupCd =  $uct[2];
		} else {
			$assetGroupCd =  'FA';
			$assetSubGroupCd =  null;
			$assetCompGroupCd =  null;
			
		}
			
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('requestNumber'), 
		$tables = array('triune_job_request_transaction_asrs_items'), 
		$fieldName = array('requestNumber', 'assetName'), 
		$where = array($ID, $assetNameText), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		

		if(empty($transactionExist)) {

			$systemForAuditName = "ASRS";
			$moduleName = "REQUESTITEMSCREATE";


			$insertData1 = null;
			$insertData1 = array(
				'requestNumber' => $ID,
				'quantity' => $quantity,
				'unitID' => $unitCode,
				'unitCode' => $unitCodeText,
				'assetGroupCd' => $assetGroupCd,
				'assetSubGroupCd' => $assetSubGroupCd,
				'assetCompGroupCd' => $assetCompGroupCd,
				'assetName' => $assetNameText,
				'createdDate' => $this->_getCurrentDate(),
				'userName' => $userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
			
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_items', $insertData1);        			 


				$actionName1 = "Insert New Transaction Request";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_job_request_transaction_asrs_items-" . $this->_getCurrentDate();
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
			$text1 = $text1 .  "'".$userName . "', ";
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
			

			$returnValue['ID'] = $ID;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} else  {//if(empty($transactionExist))
			$returnValue['ID'] = $ID;
			$returnValue = array();
			$returnValue['success'] = 0;
			echo json_encode($returnValue);
		
		}
	}
	


	public function insertSupplierNameASRS() {
		$ID = $_POST["ID"];
		$supplierID = $_POST["supplierID"];
		$supplierName = $_POST["supplierName"];
		$requestStatus = $_POST["requestStatus"];
		$supplierBidStatus = 'CAN';		
			
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('requestNumber'), 
		$tables = array('triune_job_request_transaction_asrs_supplier'), 
		$fieldName = array('requestNumber', 'supplierID'), 
		$where = array($ID, $supplierID), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		

		if(empty($transactionExist)) {

			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_asrs');
		
		
			$systemForAuditName = "ASRS";
			$moduleName = "REQUESTSUPPLIERCREATE";


			$insertData1 = null;
			$insertData1 = array(
				'requestNumber' => $ID,
				'requestStatus' => $requestStatus,
				'supplierID' => $supplierID,
				'supplierName' => $supplierName,
				'supplierBidStatus' => $supplierBidStatus,
				'createdDate' => $this->_getCurrentDate(),
				'userName' => $details[0]->userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
				
				
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_supplier', $insertData1);        			 


				$actionName1 = "Insert Supplier Name";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_job_request_transaction_asrs_supplier-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_asrs_supplier ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$ID . "', ";
			$text1 = $text1 .  "'".$requestStatus . "', ";
			$text1 = $text1 .  "'".$supplierID . "', ";
			$text1 = $text1 .  "'".$supplierName . "', ";
			$text1 = $text1 .  "'".$supplierBidStatus . "', ";
			$text1 = $text1 .  "'".$this->_getCurrentDate() . "', ";
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp();
			$text1 = $text1 .  "'".$userName;
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
			

			$returnValue['ID'] = $ID;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} else  {//if(empty($transactionExist))
			$returnValue['ID'] = $ID;
			$returnValue = array();
			$returnValue['success'] = 0;
			echo json_encode($returnValue);
		
		}
	}


	public function insertPBACMemberASRS() {
		$ID = $_POST["ID"];
		$pbacUnit = $_POST["pbacUnit"];
		$requestStatus = $_POST["requestStatus"];
			
		$userName = $this->_getUserName(1);

		$transactionExist = $this->_getRecordsData($data = array('requestNumber'), 
		$tables = array('triune_job_request_transaction_asrs_bidding_member'), 
		$fieldName = array('requestNumber', 'pbacUnit'), 
		$where = array($ID, $pbacUnit), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


		if(empty($transactionExist)) {

			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_asrs');
		
		
			$systemForAuditName = "ASRS";
			$moduleName = "REQUESTPBACMEMBERCREATE";


			$insertData1 = null;
			$insertData1 = array(
				'requestNumber' => $ID,
				'requestStatus' => $requestStatus,
				'pbacUnit' => $pbacUnit,
				'createdDate' => $this->_getCurrentDate(),
				'userName' => $details[0]->userName,
				'workstationID' => $this->_getIPAddress(),
				'timeStamp' => $this->_getTimeStamp(),
				'updatedBy' => $userName,
			);				 

			$this->db->trans_start();
			$insertedRecord1 =$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_bidding_member', $insertData1);        			 


				$actionName1 = "Insert PBAC Member";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = null;
				$newValue1 =  $insertData1;
				$userType = 1;
				$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		

			$this->db->trans_complete();
		
			$fileName1 = "triune_job_request_transaction_asrs_bidding_member-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_asrs_bidding_member ";
			$text1 = $text1 .  "VALUES (" .  $insertedRecord1 . ", ";
			$text1 = $text1 .  "'".$ID . "', ";
			$text1 = $text1 .  "'".$requestStatus . "', ";
			$text1 = $text1 .  "'".$pbacUnit . "', ";
			$text1 = $text1 .  "'".$this->_getCurrentDate() . "', ";
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp();
			$text1 = $text1 .  "'".$userName;
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
			

			$returnValue['ID'] = $ID;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

		} else  {//if(empty($transactionExist))
			$returnValue['ID'] = $ID;
			$returnValue = array();
			$returnValue['success'] = 0;
			echo json_encode($returnValue);
		
		}
	}

	
	public function deleteRequestItemsASRS() {
		$ID = $_POST["ID"];
		$requestID = $_POST["requestID"];
		$userName = $this->_getUserName(1);


		$systemForAuditName = "ASRS";
		$moduleName = "REQUESTITEMSDELETE";


			//DELETE ITEMS
			$where = array($ID);
			$fieldName = array('ID');
			//DELETE ITEMS
			
			$this->db->trans_start();
				$insertedRecord1 = $this->_deleteRecords('triune_job_request_transaction_asrs_items', $fieldName, $where);       			 


				$actionName1 = "Delete ASRS Item";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = $ID . ";" . $requestID;
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
			

			$returnValue['ID'] = $requestID;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

	}	

	public function deleteSupplierNamesASRS() {
		$ID = $_POST["ID"];
		$requestID = $_POST["requestID"];
		$userName = $this->_getUserName(1);


		$systemForAuditName = "ASRS";
		$moduleName = "REQUESTSUPPLIERDELETE";


			//DELETE ITEMS
			$where = array($ID);
			$fieldName = array('ID');
			//DELETE ITEMS
			
			$this->db->trans_start();
				$insertedRecord1 = $this->_deleteRecords('triune_job_request_transaction_asrs_supplier', $fieldName, $where);       			 


				$actionName1 = "Delete ASRS Supplier Name";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = $ID . ";" . $requestID;
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
			

			$returnValue['ID'] = $requestID;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

	}	
	
	
	public function deletePBACMemberASRS() {
		$ID = $_POST["ID"];
		$requestID = $_POST["requestID"];
		$userName = $this->_getUserName(1);


		$systemForAuditName = "ASRS";
		$moduleName = "REQUESTPBACMEMBERDELETE";


			//DELETE ITEMS
			$where = array($ID);
			$fieldName = array('ID');
			//DELETE ITEMS
			
			$this->db->trans_start();
				$insertedRecord1 = $this->_deleteRecords('triune_job_request_transaction_asrs_bidding_member', $fieldName, $where);       			 


				$actionName1 = "Delete ASRS PBAC Member";
				$for1 = $insertedRecord1 . ";" . $userName;
				$oldValue1 = $ID . ";" . $requestID;
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
			

			$returnValue['ID'] = $requestID;
			$returnValue['success'] = 1;
			echo json_encode($returnValue);

	}	
	
	
    public function getMyRequestListASRS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$page = isset($clean['page']) ? intval($clean['page']) : 1;
		$rows = isset($clean['rows']) ? intval($clean['rows']) : 10;
		$ID = isset($clean['ID']) ? $clean['ID'] : '';
		$requestStatus = isset($clean['requestStatus']) ? $clean['requestStatus'] : '';
		$userName = $this->_getUserName(1);
		 
		$offset = ($page-1)*$rows;
		$result = array();
		$whereSpcl = "triune_job_request_transaction_asrs.userName = '$userName'"; 
		$whereSpcl =  $whereSpcl . " and triune_job_request_transaction_asrs.ID like '$ID%'"; 
		$whereSpcl =  $whereSpcl . " and triune_job_request_transaction_asrs.requestStatus like '$requestStatus%'";
	 
		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_job_request_transaction_asrs'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('triune_job_request_transaction_asrs.*', 'triune_request_status_reference.requestStatusDescription'), 
			$tables = array('triune_job_request_transaction_asrs', 'triune_request_status_reference'), 
			$fieldName = array('triune_request_status_reference.application'), $where = array('ASRS'), 
			$join = array('triune_job_request_transaction_asrs.requestStatus = triune_request_status_reference.requestStatusCode'), 
			$joinType = array('left'), 
			$sortBy = array('triune_job_request_transaction_asrs.ID'), $sortOrder = array('desc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;

			$result["ID"] = $ID;

			echo json_encode($result);
	}



    public function getRequestListASRS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$page = isset($clean['page']) ? intval($clean['page']) : 1;
		$rows = isset($clean['rows']) ? intval($clean['rows']) : 10;
		$ID = isset($clean['ID']) ? $clean['ID'] : '';
		$requestStatus = isset($clean['requestStatus']) ? $clean['requestStatus'] : '';
		$userName = isset($clean['userName']) ? $clean['userName'] : '';

		$offset = ($page-1)*$rows;
		$result = array();

		$results2 = null;
		$whereSpcl = null;	
		$departmentUnit = null;	

		$currentUser = $this->_getUserName(1);

		$results2 = $this->_getRecordsData($rec = array('triune_employee_data.*'), 
		$tables = array('triune_user', 'triune_employee_data'), 
		$fieldName = array('triune_user.userName'), $where = array($currentUser), 
		$join = array('triune_user.userNumber = triune_employee_data.employeeNumber'), $joinType = array('left'), $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );

		$departmentUnit = $results2[0]->currentDepartment;
		
		if($requestStatus == 'A') {
			$whereSpcl = "triune_job_request_transaction_asrs.requestStatus = '$requestStatus'";
			$whereSpcl = $whereSpcl . " and triune_job_request_transaction_asrs.departmentUnit = '$departmentUnit'";
			$whereSpcl = $whereSpcl . " and triune_job_request_transaction_asrs.ID like '$ID%'";
			$whereSpcl = $whereSpcl . " and triune_job_request_transaction_asrs.userName like '$userName%'";
		} elseif($requestStatus == 'U') {
			$whereSpcl = "triune_job_request_transaction_asrs.requestStatus = '$requestStatus'";
			$whereSpcl = $whereSpcl . " and triune_job_request_transaction_asrs.unitReviewer = '$departmentUnit'";
			$whereSpcl = $whereSpcl . " and triune_job_request_transaction_asrs.ID like '$ID%'";
			$whereSpcl = $whereSpcl . " and triune_job_request_transaction_asrs.userName like '$userName%'";
		} else {
			$whereSpcl = "triune_job_request_transaction_asrs.requestStatus = '$requestStatus'";
			$whereSpcl = $whereSpcl . " and triune_job_request_transaction_asrs.ID like '$ID%'";
			$whereSpcl = $whereSpcl . " and triune_job_request_transaction_asrs.userName like '$userName%'";
			
		}



	 
		$results = $this->_getRecordsData($data = array('count(*) as totalRecs'), 
			$tables = array('triune_job_request_transaction_asrs'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('triune_job_request_transaction_asrs.*', 'triune_request_status_reference.requestStatusDescription'), 
			$tables = array('triune_job_request_transaction_asrs', 'triune_request_status_reference'), 
			$fieldName = array('triune_request_status_reference.application'), $where = array('ASRS'), 
			$join = array('triune_job_request_transaction_asrs.requestStatus = triune_request_status_reference.requestStatusCode'), 
			$joinType = array('left'), 
			$sortBy = array('triune_job_request_transaction_asrs.ID'), $sortOrder = array('desc'), 
			$limit = array($rows, $offset), 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );
			
			$result["rows"] = $results;
			$result["departmentUnit"] = $departmentUnit;

			$result["ID"] = $ID;


			echo json_encode($result);
	}


	public function updateRequestASRS() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$ID =  $clean['ID'];
		$requestStatus =  $clean['requestStatus'];
		$specialInstructions = $clean['specialInstructions'];
		$requestNotes =  $clean['requestNotes'];
		$requestCategory = null;
		$requestCategoryText = null;
		$currentSupplier = null;
		$currentSupplierText =  null;
		$supplierBidStatus =  null;
		$itemAmount = null;
		$itemID =  null;
		$orgUnitCode = null;		
		$returnedFrom = isset($clean['returnedFrom']) ? $clean['returnedFrom'] : null;
		$actualBudgetAmount = null;
		
		if($requestStatus == 'S') {
			if((strlen($returnedFrom) < 1)) {
				$requestCategory = isset($clean['requestCategory']) ? $clean['requestCategory'] : null; 
				$requestCategoryText =  isset($clean['requestCategoryText']) ? $clean['requestCategoryText'] : null;
				$currentSupplier = isset($clean['currentSupplier']) ? $clean['currentSupplier'] : null; 
				$currentSupplierText =  isset($clean['currentSupplierText']) ? $clean['currentSupplierText'] : null; 
				$supplierBidStatus =  'CUR';
			}
		}
		if($requestStatus == 'E') {
			$requestCategory = $clean['requestCategory'];
			$requestCategoryText =  $clean['requestCategoryText'];
			$itemAmount = $clean['itemAmount'];
			$itemID =  $clean['itemID'];
		}
		if($requestStatus == 'U') {
			$orgUnitCode =  $clean['orgUnitCode'];
		}
		if($requestStatus == 'I') {
			$actualBudgetAmount =  $clean['actualBudgetAmount'];
		}
		
		
		$userName = $this->_getUserName(1);


		$this->db->trans_start();

			//--------------UPDATE REQUEST STATUS-------------------
			$systemForAuditName0 = "ASRS";
			$moduleName0 = "REQUESTUPDATE";

			$requestStatusUpdate = null;
			
			if($requestStatus == 'U') {
				$requestStatusUpdate = array(
					'requestStatus' => $requestStatus,
					'unitReviewer' => $orgUnitCode,
				);
			} elseif( ($requestStatus == 'S') && ((strlen($returnedFrom)) > 0) ){
				$requestStatusUpdate = array(
					'requestStatus' => $requestStatus,
					'returnedFrom' => $returnedFrom,
				);
				
			} else {
				$requestStatusUpdate = array(
					'requestStatus' => $requestStatus,
				);
			}	

			$this->_updateRecords($tableName = 'triune_job_request_transaction_asrs', 
			$fieldName = array('ID'), 
			$where = array($ID), $requestStatusUpdate);
			
			$actionName0 = "Update Transaction Request to: " . $requestStatus;
			$for0 = $ID . ";" . $userName;
			$oldValue0 = null;
			$newValue0 =  $requestStatusUpdate;
			$userType = 1;
			$this->_insertAuditTrail($actionName0, $systemForAuditName0, $moduleName0, $for0, $oldValue0, $newValue0, $userType);		

			$fileName0 = "triune_job_request_transaction_asrs-" . $this->_getCurrentDate();
			$text0 = "UPDATE triune_job_request_transaction_asrs ";
			$text0 = $text0 .  "SET requestStatus = '" .  $requestStatus . "', ";
			if($requestStatus == 'U') {
				$text0 = $text0 .  "orgUnitCode = '" .  $orgUnitCode . "' ";
			} elseif( ($requestStatus == 'S') && ((strlen($returnedFrom)) > 0) ){
				$text0 = $text0 .  "returnedFrom = '" .  $returnedFrom . "' ";
			}
			$text0 = $text0 .  "WHERE ID = ".$ID;
			$this->_insertTextLog($fileName0, $text0, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATUS-------------------



			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_asrs');


			//--------------UPDATE REQUEST STATATUS HISTORY-------------------
			$systemForAuditName1 = "ASRS";
			$moduleName1 = "REQUESTSTATUSHISTORY";

			$insertData1 = null;

			if( ($requestStatus == 'S') && ((strlen($returnedFrom)) > 0) ){
				$insertData1 = array(
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'returnedFrom' => $returnedFrom,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);			
			} else {
				$insertData1 = array(
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);			
				
			}

			$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_status_history', $insertData1);        			 


			$actionName1 = "Update Request Status History with: " . $requestStatus;
			$for1 = $ID . ";" . $userName;
			$oldValue1 = null;
			$newValue1 =  $insertData1;
			$userType = 1;
			$this->_insertAuditTrail($actionName1, $systemForAuditName1, $moduleName1, $for1, $oldValue1, $newValue1, $userType);		

			$fileName1 = "triune_job_request_transaction_asrs_status_history-" . $this->_getCurrentDate();
			$text1 = "INSERT INTO triune_job_request_transaction_asrs_status_history ";
			$text1 = $text1 .  "VALUES ('".$ID . "', ";
			$text1 = $text1 .  "'".$requestStatus . "', ";
			if( ($requestStatus == 'S') && ((strlen($returnedFrom)) > 0) ){
				$text1 = $text1 .  "'".$returnedFrom . "', ";
			}
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp() . "', ";
			$text1 = $text1 .  "'".$userName . "'";
			$text1 = $text1 . ");";
			$this->_insertTextLog($fileName1, $text1, $this->LOGFOLDER);
			//--------------UPDATE REQUEST STATATUS HISTORY-------------------


			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------
			if( (strlen($specialInstructions)) > 0) {
				$systemForAuditName2 = "ASRS";
				$moduleName2 = "REQUESTSPECIALINSTRUCTIONS";

				$insertData2 = null;
				$instrtnType = 'I';
				if( ($requestStatus == 'S') && ((strlen($returnedFrom)) > 0) ){
					$instrtnType = 'R';
				}
				
				
				$insertData2 = array(
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'specialInstructions' => $specialInstructions,
					'instrtnType' => $instrtnType,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_special_instructions', $insertData2);        			 

				$actionName2 = "Insert Request Special Instructions";
				$for2 = $ID . ";" . $userName;
				$oldValue2 = null;
				$newValue2 =  $insertData2;
				$userType = 1;
				$this->_insertAuditTrail($actionName2, $systemForAuditName2, $moduleName2, $for2, $oldValue2, $newValue2, $userType);		

				$fileName2 = "triune_job_request_transaction_asrs_special_instructions-" . $this->_getCurrentDate();
				$text2 = "INSERT INTO triune_job_request_transaction_asrs_special_instructions ";
				$text2 = $text2 .  "VALUES ('".$ID . "', ";
				$text2 = $text2 .  "'".$requestStatus . "', ";
				$text2 = $text2 .  "'".$specialInstructions . "', ";
				$text2 = $text2 .  "'".$instrtnType . "', ";
				$text2 = $text2 .  "'".$details[0]->userName . "', ";
				$text2 = $text2 .  "'".$this->_getIPAddress() . "', ";
				$text2 = $text2 .  "'".$this->_getTimeStamp() . "', ";
				$text2 = $text2 .  "'".$userName . "'";
				$text2 = $text2 . ");";
				$this->_insertTextLog($fileName2, $text2, $this->LOGFOLDER);
					

			}
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------


			//--------------INSERT REQUEST REQUEST NOTES-------------------
			$systemForAuditName3 = "TBAMIMS";
			$moduleName3 = "REQUESTREQUESTNOTES";

			if( (strlen($requestNotes)) > 0) {
				$insertData3 = null;
				$insertData3 = array(
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'requestNotes' => $requestNotes,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_request_notes', $insertData3);        			 
				
				$actionName3 = "Insert Request Request Notes";
				$for3 = $ID . ";" . $userName;
				$oldValue3 = null;
				$newValue3 =  $insertData3;
				$userType = 1;
				$this->_insertAuditTrail($actionName3, $systemForAuditName3, $moduleName3, $for3, $oldValue3, $newValue3, $userType);		

				$fileName3 = "triune_job_request_transaction_asrs_request_notes-" . $this->_getCurrentDate();
				$text3 = "INSERT INTO triune_job_request_transaction_asrs_request_notes ";
				$text3 = $text3 .  "VALUES ('".$ID . "', ";
				$text3 = $text3 .  "'".$requestStatus . "', ";
				$text3 = $text3 .  "'".$requestNotes . "', ";
				$text3 = $text3 .  "'".$details[0]->userName . "', ";
				$text3 = $text3 .  "'".$this->_getIPAddress() . "', ";
				$text3 = $text3 .  "'".$this->_getTimeStamp() . "', ";
				$text3 = $text3 .  "'".$userName . "'";
				$text3 = $text3 . ");";
				$this->_insertTextLog($fileName3, $text3, $this->LOGFOLDER);
			}
			//--------------INSERT REQUEST REQUEST NOTES-------------------

			
			//--------------INSERT REQUEST REQUEST CATEGORY-------------------
			if( (strlen($requestCategory)) > 0) {
				$systemForAuditName4 = "ASRS";
				$moduleName4 = "REQUESTSREQUESTCATEGORY";

				$insertData4 = null;
				$insertData4 = array(
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'requestCategory' => $requestCategory,
					'requestCategoryText' => $requestCategoryText,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_request_category', $insertData4);        			 

				$actionName4 = "Insert Request Request Category";
				$for4 = $ID . ";" . $userName;
				$oldValue4 = null;
				$newValue4 =  $insertData4;
				$userType = 1;
				$this->_insertAuditTrail($actionName4, $systemForAuditName4, $moduleName4, $for4, $oldValue4, $newValue4, $userType);		

				$fileName4 = "triune_job_request_transaction_asrs_request_category-" . $this->_getCurrentDate();
				$text4 = "INSERT INTO triune_job_request_transaction_asrs_request_category ";
				$text4 = $text4 .  "VALUES ('".$ID . "', ";
				$text4 = $text4 .  "'".$requestStatus . "', ";
				$text4 = $text4 .  "'".$requestCategory . "', ";
				$text4 = $text4 .  "'".$requestCategoryText . "', ";
				$text4 = $text4 .  "'".$details[0]->userName . "', ";
				$text4 = $text4 .  "'".$this->_getIPAddress() . "', ";
				$text4 = $text4 .  "'".$this->_getTimeStamp() . "', ";
				$text4 = $text4 .  "'".$userName . "'";
				$text4 = $text4 . ");";
				$this->_insertTextLog($fileName4, $text4, $this->LOGFOLDER);
					

			}
			//--------------INSERT REQUEST REQUEST CATEGORY-------------------
			
			//--------------INSERT REQUEST SUPPLIER-------------------
			if( (strlen($currentSupplier)) > 0) {
				$systemForAuditName5 = "ASRS";
				$moduleName5 = "REQUESTSREQUESTSUPPLIER";

				$insertData5 = null;
				$insertData5 = array(
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'supplierID' => $currentSupplier,
					'supplierName' => $currentSupplierText,
					'supplierBidStatus' => $supplierBidStatus,
					'createdDate' => $this->_getCurrentDate(),
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_supplier', $insertData5);        			 

				$actionName5 = "Insert Request Supplier";
				$for5 = $ID . ";" . $userName;
				$oldValue5 = null;
				$newValue5 =  $insertData5;
				$userType = 1;
				$this->_insertAuditTrail($actionName5, $systemForAuditName5, $moduleName5, $for5, $oldValue5, $newValue5, $userType);		

				$fileName5 = "triune_job_request_transaction_asrs_supplier-" . $this->_getCurrentDate();
				$text5 = "INSERT INTO triune_job_request_transaction_asrs_supplier ";
				$text5 = $text5 .  "VALUES ('".$ID . "', ";
				$text5 = $text5 .  "'".$requestStatus . "', ";
				$text5 = $text5 .  "'".$currentSupplier . "', ";
				$text5 = $text5 .  "'".$currentSupplierText . "', ";
				$text5 = $text5 .  "'".$supplierBidStatus . "', ";
				$text5 = $text5 .  "'".$this->_getCurrentDate(). "', ";
				$text5 = $text5 .  "'".$details[0]->userName . "', ";
				$text5 = $text5 .  "'".$this->_getIPAddress() . "', ";
				$text5 = $text5 .  "'".$this->_getTimeStamp() . "', ";
				$text5 = $text5 .  "'".$userName . "'";
				$text5 = $text5 . ");";
				$this->_insertTextLog($fileName5, $text5, $this->LOGFOLDER);
					
			}
			//--------------INSERT REQUEST SUPPLIER-------------------



			if($itemID != null){
				//--------------UPDATE REQUEST ITEMS AMOUNT-------------------
				$systemForAuditName6 = "ASRS";
				$moduleName6 = "REQUESTITEMSAMOUNT";
				
				$amawnt = explode(",",$itemAmount);
				$aytemID = explode(",",$itemID);
				$validAmount = 0;
				
				for($i = 0; $i < count($aytemID); $i++ ) {
					
					if(is_numeric($amawnt[$i]) && $amawnt[$i] > 0){
						$validAmount = $amawnt[$i];
					} else {
						$validAmount = 0;
					}
					
					$itemAmountUpdate = null;

					$itemAmountUpdate = array(
						'itemAmount' => $validAmount,
						'workstationID' => $this->_getIPAddress(),
						'timeStamp' => $this->_getTimeStamp(),
						'updatedBy' => $userName,
						
					);	

					
					$this->_updateRecords($tableName = 'triune_job_request_transaction_asrs_items', 
					$fieldName = array('ID'), 
					$where = array($aytemID[$i]), $itemAmountUpdate);
					
					$actionName6 = "Update itemsAmount to: " . $validAmount;
					$for6 = $aytemID[$i] . ";" . $userName;
					$oldValue6 = null;
					$newValue6 =  $requestStatusUpdate;
					$userType = 1;
					$this->_insertAuditTrail($actionName6, $systemForAuditName6, $moduleName6, $for6, $oldValue6, $newValue6, $userType);		

					$fileName6 = "triune_job_request_transaction_asrs_items-" . $this->_getCurrentDate();
					$text6 = "UPDATE triune_job_request_transaction_asrs_items ";
					$text6 = $text6 .  "SET itemAmount = " . $validAmount . ", ";
					$text6 = $text6 .  "workstationID = '" . $this->_getIPAddress() . "', ";
					$text6 = $text6 .  "timeStamp = '" . $this->_getTimeStamp() . "', ";
					$text6 = $text6 .  "updatedBy = '" . $userName . "' ";
					$text6 = $text6 .  "WHERE ID = ".$aytemID[$i];
					$this->_insertTextLog($fileName6, $text6, $this->LOGFOLDER);
				}
				//--------------UPDATE REQUEST ITEMS AMOUNT-------------------
			}
			
			//--------------INSERT REQUEST ACTUAL BUDGET AMOUNT-------------------
			$systemForAuditName7 = "ASRS";
			$moduleName7 = "REQUESTACTUALBUDGET";

			if( (strlen($actualBudgetAmount)) > 0) {
				$insertData7 = null;
				$insertData7 = array(
					'requestNumber' =>$ID,
					'requestStatus' => $requestStatus,
					'actualBudgetAmount' => $actualBudgetAmount,
					'userName' => $details[0]->userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					'updatedBy' => $userName,
					
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_asrs_actual_budget', $insertData7);        			 
				
				$actionName7 = "Insert Request Actual Budget Amount";
				$for7 = $ID . ";" . $userName;
				$oldValue7 = null;
				$newValue7 =  $insertData7;
				$userType = 1;
				$this->_insertAuditTrail($actionName7, $systemForAuditName7, $moduleName7, $for7, $oldValue7, $newValue7, $userType);		

				$fileName7 = "triune_job_request_transaction_asrs_actual_budget-" . $this->_getCurrentDate();
				$text7 = "INSERT INTO triune_job_request_transaction_asrs_actual_budget ";
				$text7 = $text7 .  "VALUES ('".$ID . "', ";
				$text7 = $text7 .  "'".$requestStatus . "', ";
				$text7 = $text7 .  "'".$actualBudgetAmount . "', ";
				$text7 = $text7 .  "'".$details[0]->userName . "', ";
				$text7 = $text7 .  "'".$this->_getIPAddress() . "', ";
				$text7 = $text7 .  "'".$this->_getTimeStamp() . "', ";
				$text7 = $text7 .  "'".$userName . "";
				$text7 = $text7 . ");";
				$this->_insertTextLog($fileName7, $text7, $this->LOGFOLDER);
			}
			//--------------INSERT REQUEST ACTUAL BUDGET AMOUNT-------------------
			
			
/*
			//--------------INSERT REQUEST STATUS REMARKS-------------------
			$systemForAuditName5 = "TBAMIMS";
			$moduleName5 = "REQUESTSTATUSREMARKS";

			if( (strlen($requestStatusRemarksID)) > 0) {
				$insertData5 = null;
				$insertData5 = array(
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
				$text5 = $text5 .  "'".$requestStatus . "', ";
				$text5 = $text5 .  "'".$requestStatusRemarksID . "', ";
				$text5 = $text5 .  "'".$details[0]->userName . "', ";
				$text5 = $text5 .  "'".$this->_getIPAddress() . "', ";
				$text5 = $text5 .  "'".$this->_getTimeStamp() . "', ";
				$text5 = $text5 .  "'".$userName . "', ";
				$text5 = $text5 . "');";
				$this->_insertTextLog($fileName5, $text5);
			}
			//--------------INSERT REQUEST STATUS REMARKS-------------------

			
			
			

*/

			
		$this->db->trans_complete();


		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);


	}



	public function insertMaterialsASRS() {

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
					$this->_insertTextLog($fileName1, $text1);


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



    public function getAllRequestListASRS() {
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
			$tables = array('triune_job_request_transaction_tbamims'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array($whereSpcl), $groupBy = null );

			//$row = mysql_fetch_row($results);
			$result["total"] = intval($results[0]->totalRecs);

			$results = $this->_getRecordsData($data = array('triune_job_request_transaction_tbamims.*', 'triune_request_status_reference.requestStatusDescription'), 
			$tables = array('triune_job_request_transaction_tbamims', 'triune_request_status_reference'), 
			$fieldName = array('triune_request_status_reference.application'), $where = array('TBAMIMS'), 
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






	public function closeRequestASRS() {
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
			$this->_insertTextLog($fileName0, $text0);
			//--------------UPDATE REQUEST STATUS-------------------



			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_tbamims');


			//--------------UPDATE REQUEST STATATUS HISTORY-------------------
			$systemForAuditName1 = "TBAMIMS";
			$moduleName1 = "REQUESTSTATUSHISTORY";

			$insertData1 = null;
			$insertData1 = array(
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
			$text1 = $text1 .  "'".$requestStatus . "', ";
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1);
			//--------------UPDATE REQUEST STATATUS HISTORY-------------------

			
		$this->db->trans_complete();


		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);


	}


	public function returnRequestASRS() {
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
			$this->_insertTextLog($fileName0, $text0);
			//--------------UPDATE REQUEST STATUS-------------------



			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_tbamims');


			//--------------UPDATE REQUEST STATATUS HISTORY-------------------
			$systemForAuditName1 = "TBAMIMS";
			$moduleName1 = "REQUESTSTATUSHISTORY";

			$insertData1 = null;
			$insertData1 = array(
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
			$text1 = $text1 .  "'".$requestStatus . "', ";
			$text1 = $text1 .  "'".$returnedFrom . "', ";
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1);
			//--------------UPDATE REQUEST STATATUS HISTORY-------------------

			
			
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------
			if( (strlen($specialInstructions)) > 0) {
				$systemForAuditName2 = "TBAMIMS";
				$moduleName2 = "REQUESTSPECIALINSTRUCTIONS";

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
				$text2 = $text2 .  "'".$requestStatus . "', ";
				$text2 = $text2 .  "'".$specialInstructions . "', ";
				$text2 = $text2 .  "'".$details[0]->userName . "', ";
				$text2 = $text2 .  "'".$this->_getIPAddress() . "', ";
				$text2 = $text2 .  "'".$this->_getTimeStamp() . "', ";
				$text2 = $text2 .  "'".$userName . "', ";
				$text2 = $text2 . "');";
				$this->_insertTextLog($fileName2, $text2);
					

			}
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------


			//--------------INSERT REQUEST SCOPE DETAILS-------------------
			$systemForAuditName3 = "TBAMIMS";
			$moduleName3 = "REQUESTSCOPEDETAILS";

			if( (strlen($scopeDetails)) > 0) {
				$insertData3 = null;
				$insertData3 = array(
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
				$text3 = $text3 .  "'".$requestStatus . "', ";
				$text3 = $text3 .  "'".$scopeDetails . "', ";
				$text3 = $text3 .  "'".$details[0]->userName . "', ";
				$text3 = $text3 .  "'".$this->_getIPAddress() . "', ";
				$text3 = $text3 .  "'".$this->_getTimeStamp() . "', ";
				$text3 = $text3 .  "'".$userName . "', ";
				$text3 = $text3 . "');";
				$this->_insertTextLog($fileName3, $text3);
			}
			//--------------INSERT REQUEST SCOPE DETAILS-------------------





			//--------------INSERT REQUEST STATUS REMARKS-------------------
			$systemForAuditName5 = "TBAMIMS";
			$moduleName5 = "REQUESTSTATUSREMARKS";

			if( (strlen($requestStatusRemarksID)) > 0) {
				$insertData5 = null;
				$insertData5 = array(
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
				$text5 = $text5 .  "'".$requestStatus . "', ";
				$text5 = $text5 .  "'".$requestStatusRemarksID . "', ";
				$text5 = $text5 .  "'".$details[0]->userName . "', ";
				$text5 = $text5 .  "'".$this->_getIPAddress() . "', ";
				$text5 = $text5 .  "'".$this->_getTimeStamp() . "', ";
				$text5 = $text5 .  "'".$userName . "', ";
				$text5 = $text5 . "');";
				$this->_insertTextLog($fileName5, $text5);
			}
			//--------------INSERT REQUEST STATUS REMARKS-------------------

			
			
			
		$this->db->trans_complete();


		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);


	}
	
	public function updateRequestMultipleStatusASRS() {
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
			$this->_insertTextLog($fileName0, $text0);
			//--------------UPDATE REQUEST STATUS-------------------



			$details = $this->_getTransactionDetails($ID, $from = 'triune_job_request_transaction_tbamims');

			//--------------UPDATE REQUEST STATATUS HISTORY APPROVED-------------------
			$systemForAuditNameA = "TBAMIMS";
			$moduleNameA = "REQUESTSTATUSHISTORY";

			$insertDataA = null;
			$insertDataA = array(
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
			$textA = $textA .  "'".'A'. "', ";
			$textA = $textA .  "'".$details[0]->userName . "', ";
			$textA = $textA .  "'".$this->_getIPAddress() . "', ";
			$textA = $textA .  "'".$this->_getTimeStamp() . "', ";
			$textA = $textA .  "'".$userName . "', ";
			$textA = $textA . "');";
			$this->_insertTextLog($fileNameA, $textA);
			//--------------UPDATE REQUEST STATATUS HISTORY APPROVED-------------------
			
			
			

			//--------------UPDATE REQUEST STATATUS HISTORY-------------------
			$systemForAuditName1 = "TBAMIMS";
			$moduleName1 = "REQUESTSTATUSHISTORY";

			$insertData1 = null;
			$insertData1 = array(
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
			$text1 = $text1 .  "'".$requestStatus . "', ";
			$text1 = $text1 .  "'".$details[0]->userName . "', ";
			$text1 = $text1 .  "'".$this->_getIPAddress() . "', ";
			$text1 = $text1 .  "'".$this->_getTimeStamp() . "', ";
			$text1 = $text1 .  "'".$userName . "', ";
			$text1 = $text1 . "');";
			$this->_insertTextLog($fileName1, $text1);
			//--------------UPDATE REQUEST STATATUS HISTORY-------------------

			
			
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------
			if( (strlen($specialInstructions)) > 0) {
				$systemForAuditName2 = "TBAMIMS";
				$moduleName2 = "REQUESTSPECIALINSTRUCTIONS";

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
				$text2 = $text2 .  "'".$requestStatus . "', ";
				$text2 = $text2 .  "'".$specialInstructions . "', ";
				$text2 = $text2 .  "'".$details[0]->userName . "', ";
				$text2 = $text2 .  "'".$this->_getIPAddress() . "', ";
				$text2 = $text2 .  "'".$this->_getTimeStamp() . "', ";
				$text2 = $text2 .  "'".$userName . "', ";
				$text2 = $text2 . "');";
				$this->_insertTextLog($fileName2, $text2);
					

			}
			//--------------INSERT REQUEST SPECIAL INSTRUCTIONS-------------------


			//--------------INSERT REQUEST SCOPE DETAILS-------------------
			$systemForAuditName3 = "TBAMIMS";
			$moduleName3 = "REQUESTSCOPEDETAILS";

			if( (strlen($scopeDetails)) > 0) {
				$insertData3 = null;
				$insertData3 = array(
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
				$text3 = $text3 .  "'".$requestStatus . "', ";
				$text3 = $text3 .  "'".$scopeDetails . "', ";
				$text3 = $text3 .  "'".$details[0]->userName . "', ";
				$text3 = $text3 .  "'".$this->_getIPAddress() . "', ";
				$text3 = $text3 .  "'".$this->_getTimeStamp() . "', ";
				$text3 = $text3 .  "'".$userName . "', ";
				$text3 = $text3 . "');";
				$this->_insertTextLog($fileName3, $text3);
			}
			//--------------INSERT REQUEST SCOPE DETAILS-------------------





			//--------------INSERT REQUEST STATUS REMARKS-------------------
			$systemForAuditName5 = "TBAMIMS";
			$moduleName5 = "REQUESTSTATUSREMARKS";

			if( (strlen($requestStatusRemarksID)) > 0) {
				$insertData5 = null;
				$insertData5 = array(
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
				$text5 = $text5 .  "'".$requestStatus . "', ";
				$text5 = $text5 .  "'".$requestStatusRemarksID . "', ";
				$text5 = $text5 .  "'".$details[0]->userName . "', ";
				$text5 = $text5 .  "'".$this->_getIPAddress() . "', ";
				$text5 = $text5 .  "'".$this->_getTimeStamp() . "', ";
				$text5 = $text5 .  "'".$userName . "', ";
				$text5 = $text5 . "');";
				$this->_insertTextLog($fileName5, $text5);
			}
			//--------------INSERT REQUEST STATUS REMARKS-------------------

			
			
			
		$this->db->trans_complete();


		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);


	}
	
}