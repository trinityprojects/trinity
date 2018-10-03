<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityDataInfoTechQueueSys extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Data InfoTech - Queueing System
	 * DATE CREATED: June 20, 2018
     * DATE UPDATED: June 20, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('form_validation'); 
    }//function __construct()



	public function insertCustomerNumberQueueSys() {

		$this->form_validation->set_rules('customerNumber', 'Customer Number', 'required');
		$this->form_validation->set_rules('group', 'Group', 'required');  
		$this->form_validation->set_rules('source', 'Source', 'required');  

		if ($this->form_validation->run() == FALSE) {   
			echo json_encode($this->form_validation->error_array());
		}else{    
			$returnValue = array();
			$recordID = null;
			$post = $this->input->post();  
			$clean = $this->security->xss_clean($post);
			
			$customerNumber =  $clean['customerNumber'];
			$group =  $clean['group'];
			$source =  $clean['source'];


			$systemForAuditName = "QUEUESYS";
			$moduleName = "CUSTOMER-MDL";

	
				$transactionExist = $this->_getRecordsData($selectfields = array('ID'), 
				$tables = array('triune_queue_number'), 
				$fieldName = array('customerNumber', 'status'), 
				$where = array($customerNumber, '0'), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				
				$userName = $this->_getUserName(0);
		
				if(empty($transactionExist)) {
		
					$insertData1 = null;
					$insertData1 = array(
						'group' => $group,
						'customerNumber' => $customerNumber,
						'status' => '0',
						'userNumber' => $userName,
						'timeStamp' => $this->_getTimeStamp(),
					);				 
		

					$insertSurvey = null;
					$insertSurvey = array(
						'source' => $source,
						'customerNumber' => $customerNumber,
						'timeStamp' => $this->_getTimeStamp(),
					);				 

					$this->db->trans_start();
						$recordID = $this->_insertRecords($tableName = 'triune_queue_number', $insertData1);        			 
						$recordID = $this->_insertRecords($tableName = 'triune_survey_marketing_source', $insertSurvey);        			 
		
						$actionName1 = "Insert New Customer Queue";
						$for1 =  $recordID . ";" . $userName;
						$oldValue1 = null;
						$newValue1 =  $insertData1;
						$userType = 0;
						$this->_insertAuditTrail($actionName1, $systemForAuditName, $moduleName, $for1, $oldValue1, $newValue1, $userType);		
		
						$queueNumberStatus = array(
							'status' => 0,
						);
						$this->_updateRecords($tableName = 'triune_queue_number_status', 		
						$fieldName = array('group'), 
						$where = array('Operator'), $queueNumberStatus);	

					$this->db->trans_complete();

				
					$fileName1 = "triune_queue_number-" . $this->_getCurrentDate();
					$text1 = "INSERT INTO triune_queue_number ";
					$text1 = $text1 .  "VALUES (" .  $recordID . ", ";
					$text1 = $text1 .  "'".$group . "', ";
					$text1 = $text1 .  "'".$customerNumber. "', ";
					$text1 = $text1 .  "'0', ";
					$text1 = $text1 .  "'".$userName . "', ";
					$text1 = $text1 .  "'".$this->_getTimeStamp();
					$text1 = $text1 . "');";
					$this->_insertTextLog($fileName1, $text1, 'quesys');


					if ($this->db->trans_status() === FALSE) {
						$this->_transactionFailed();
						$this->db->trans_rollback();
						return FALSE;
					} 
					else {
						$this->db->trans_commit();
						//return TRUE;
					}
					
					$returnValue['ID'] = $recordID;
					$returnValue['customerNumber'] = $customerNumber;
					$returnValue['success'] = 1;
					echo json_encode($returnValue);
				} else {
					$returnValue['ID'] = $recordID;
					$returnValue['customerNumber'] = $customerNumber;
					$returnValue['success'] = 1;
					echo json_encode($returnValue);
				
				} //if(empty($transactionExist))
		}	//($this->form_validation->run() == FALSE)
		


	}

	public function callCustomerNumberQueueSys() {
		$ID = $_POST['ID'];
		$customerNumber = $_POST['customerNumber'];

		$queueNumberCurrentUpdate = array(
			'queueNumberCurrent' => $ID,
		);
		$this->_updateRecords($tableName = 'triune_queue_number_current', 		
		$fieldName = array('group'), 
		$where = array('IDSys'), $queueNumberCurrentUpdate);	

		$queueNumberStatus = array(
			'status' => 0,
		);
		$this->_updateRecords($tableName = 'triune_queue_number_status', 		
		$fieldName = array('group'), 
		$where = array('IDSys'), $queueNumberStatus);	


		$returnValue = array();
		$returnValue['ID'] = $ID;
		$returnValue['customerNumber'] = $customerNumber;
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}

	public function finishQueueNumberQueueSys() {
		$ID = $_POST['ID'];
		$customerNumber = $_POST['customerNumber'];

		$queueNumberUpdate = array(
			'status' => $ID,
		);
		$this->_updateRecords($tableName = 'triune_queue_number', 		
		$fieldName = array('ID', 'customerNumber'), 
		$where = array($ID, $customerNumber), $queueNumberUpdate);	

		$returnValue = array();
		$returnValue['ID'] = $ID;
		$returnValue['customerNumber'] = $customerNumber;
		$returnValue['success'] = 1;
		echo json_encode($returnValue);		
	}

	public function reloadOperatorQueueSys() {
		
	}	

    public function viewViewerQueueQueueSys() {
		//echo "HELLO WORLD";
		//$data['ID'] = $_POST['ID'];
		//$data['customerNumber'] = $_POST['customerNumber'];
		unset($data);
		unset($records1);
		unset($records2);

		$records = $this->_getRecordsData($selectFields = array('ID', 'customerNumber'), 
		$tables = array('triune_queue_number'), 
		$fieldName = array('status'), 
		$where = array('0'), 
		$join = null, $joinType = null, 
		$sortBy = array('ID'), $sortOrder = array('asc'), 
		$limit = array(10, 1), 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );


		$records1 = $this->_getRecordsData($selectFields = array('triune_queue_number.ID', 'triune_queue_number.customerNumber'), 
		$tables = array('triune_queue_number', 'triune_queue_number_current'), 
		$fieldName = array('triune_queue_number.status'), 
		$where = array('0'), 
		$join = array('triune_queue_number.ID = triune_queue_number_current.queueNumberCurrent'), $joinType = array('inner'), 
		$sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );



		$records3 = $this->_getRecordsData($selectFields = array('status'), 
		$tables = array('triune_queue_number_status'), 
		$fieldName = array('group'), 
		$where = array('IDSys'), 
		$join = null, $joinType = null, 
		$sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );


		$returnValue = array();
		foreach($records1 as $row) {
			$returnValue['currentQueueNumber']['ID'] = $row->ID;
			$returnValue['currentQueueNumber']['customerNumber'] = $row->customerNumber;

		}

		$i = 0;
		foreach($records as $row) {
			$returnValue['nextQueueNumbers']['ID'][$i] = $row->ID;
			$returnValue['nextQueueNumbers']['customerNumber'][$i] = $row->customerNumber;
			$i++;
		}

		$returnValue['status'] = $records3[0]->status;


		echo json_encode($returnValue);		

    }

	
	public function updateStatusViewerQueueQueueSys() {

		$queueNumberStatus = array(
			'status' => 1,
		);
		$this->_updateRecords($tableName = 'triune_queue_number_status', 		
		$fieldName = array('group'), 
		$where = array('IDSys'), $queueNumberStatus);	
		echo json_encode('1');	
	}

	public function notifyOperatorQueueSys() {
		$queueNumberStatus = array(
			'status' => 0,
		);
		$this->_updateRecords($tableName = 'triune_queue_number_status', 		
		$fieldName = array('group'), 
		$where = array('Operator'), $queueNumberStatus);	

		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}
	

    public function viewNotifyOperatorQueueQueueSys() {

		$records3 = $this->_getRecordsData($selectFields = array('status'), 
		$tables = array('triune_queue_number_status'), 
		$fieldName = array('group'), 
		$where = array('Operator'), 
		$join = null, $joinType = null, 
		$sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );


		$returnValue = array();
		$returnValue['status'] = $records3[0]->status;


		echo json_encode($returnValue);		

    }

    public function updateStatusViewerQueueQueueSysOperator() {

		$queueNumberStatus = array(
			'status' => 1,
		);
		$this->_updateRecords($tableName = 'triune_queue_number_status', 		
		$fieldName = array('group'), 
		$where = array('Operator'), $queueNumberStatus);	

		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

    }

	
	
}