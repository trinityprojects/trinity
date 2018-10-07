<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityInfoTech extends MY_Controller {

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
	 * DATE CREATED: June 04, 2018
     * DATE UPDATED: June 04, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function iCTJRSCreateRequest() {
        //echo "HELLO WORLD";
        $this->load->view('ICTJRS/request-create-form');
    }

    public function iCTJRSCreateRequestConfirmation() {
		$data['requestSummary'] = $_POST["requestSummary"];
		$data['requestDetails'] = $_POST["requestDetails"];
		$data['requestType'] = $_POST["requestType"];
		$this->load->view('ICTJRS/request-create-confirmation', $data);
    }

    public function iCTJRSCreatedRequest() {
		$data['ID'] = $_POST["ID"];
		$data['requestType'] = $_POST["requestType"];
		$data['requestSummary'] = $_POST["requestSummary"];
		
		$userName = $this->_getUserName(1);
		
		$selectFields = "triune_employee_data.employeeNumber, ";
		$selectFields = $selectFields . "concat(triune_employee_data.lastName, '; ', triune_employee_data.firstName, ' ', triune_employee_data.middleName) as assignedTo";
		
		$result = $this->_getRecordsData($rec = array($selectFields), 
		$tables = array('triune_job_request_transaction_ict', 'triune_employee_data'), 
		$fieldName = array('triune_job_request_transaction_ict.ID'), $where = array($data['ID']), 
		$join = array('triune_job_request_transaction_ict.assignedTo = triune_employee_data.employeeNumber'), $joinType = array('inner'), 
		$sortBy = null, $sortOrder = null, 	$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		$data['assignedTo'] = null;
		if(!empty($result)) {
			$data['assignedTo'] = $result[0]->assignedTo;
		}
		
		$result1 = $this->_getRecordsData($rec1 = array('*'), 
		$tables = array('triune_request_type_reference'), $fieldName = array('requestTypeCode'), $where = array('CCTA'), $join = null, $joinType = null, 
		$sortBy = null, $sortOrder = null, 	$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		$data['serviceLevelAgreementPeriod'] = null;
		$data['deliveryDate'] = null;
		
		$data['currentDate'] = $this->_getCurrentDate();
		if(!empty($result1)) {
			$sla = $result1[0]->serviceLevelAgreementPeriod;
			$data['serviceLevelAgreementPeriod'] = $sla;
			if($sla <> -1) {
				$data['deliveryDate'] =  date('Y-m-d', strtotime($data['currentDate']. ' + ' . $sla . 'days'));
			} else {
				$data['deliveryDate'] = "NO SLA";
			}
		}
		



















		
		if($data['requestType'] == "HWRS") {
			
			$result2 = $this->_getRecordsData($rec2 = array('*'), 
			$tables = array('triune_inventory_workstation'), $fieldName = array('assignedTo'), $where = array($userName), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, 	$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			$itemHardware = array();
			if(!empty($result2)) {
				$itemHardware[0] = 	$result2[0]->roomNumber;
				$itemHardware[1] = 	$result2[0]->hardwareSpecs;
				$itemHardware[2] = 	$result2[0]->peripheralsSpecs;
				$itemHardware[3] = 	$result2[0]->printerSpecs;
				$itemHardware[4] = 	$result2[0]->systemSoftwareSpecs;
				$itemHardware[5] = 	$result2[0]->applicationSoftwareSpecs;
				$itemHardware[6] = 	$result2[0]->processorSpecs;
				$itemHardware[7] = 	$result2[0]->hardDiskSpecs;
				$itemHardware[8] = 	$result2[0]->memorySpecs;
				$itemHardware[9] = 	$result2[0]->monitorSpecs;
				$itemHardware[10] = 	$result2[0]->mouseSpecs;
				$itemHardware[11] = 	$result2[0]->keyboardSpecs;
				$itemHardware[12] = 	$result2[0]->internetAccessFlag;
				$itemHardware[13] = 	$result2[0]->iPAddress;
				$itemHardware[14] = 	$result2[0]->subnetMask;
				$itemHardware[15] = 	$result2[0]->defaultGateway;
				$itemHardware[15] = 	$result2[0]->dNS;
				
			}
			
			foreach($result2 as $row) {

				$insertData1 = null;
				$insertData1 = array(
					'requestCategory' => $row->,
					'userName' => $userName,
					'workstationID' => $this->_getIPAddress(),
					'timeStamp' => $this->_getTimeStamp(),
					
				);				 

				$this->db->trans_start();
					$insertedRecord1 = $this->_insertRecords($tableName = 'triune_job_request_transaction_ict', $insertData1);        			 
				$this->db->trans_complete();
			
			}
		}

        $this->load->view('ICTJRS/request-created-details', $data);
    }

    public function iCTJRSWorkstationInventory() {
        $this->load->view('ICTJRS/workstation-inventory-list');
    }

    public function iCTJRSLCDInventory() {
        $this->load->view('ICTJRS/lcd-inventory-list');
    }
	
    public function iCTJRSTelephoneInventory() {
        $this->load->view('ICTJRS/telephone-inventory-list');
    }

    public function iCTJRSCCTVInventory() {
        $this->load->view('ICTJRS/cctv-inventory-list');
    }

    public function iCTJRSWIFIInventory() {
        $this->load->view('ICTJRS/wifi-inventory-list');
    }
	
    public function iCTJRSRequestItems() {
		$data['itemID'] = $_POST["itemID"];
		$data['requestNumber'] = $_POST["requestNumber"];
		$data['requestType'] = $_POST["requestType"];
		$data['accessType'] = $_POST["accessType"];
		
		//$recs=null;
		//if($data['requestType'] == 'CCTA') {
			$recs= $this->_getRecordsData($dataSelect = array('*'), 
			$tables = array('triune_job_request_transaction_ict_request_items'), 
			$fieldName = array('requestNumber'), $where = array($data['requestNumber']), $join = null, $joinType = null, 
			$sortBy = array('ID'), $sortOrder = array('asc'), $limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		//} else if($data['requestType'] == 'GSAS') {
		//	$recs= $this->_getRecordsData($dataSelect = array('*'), 
		//	$tables = array('triune_job_request_transaction_ict_request_items'), 
		//	$fieldName = array('requestNumber'), $where = array($data['requestNumber']), $join = null, $joinType = null, 
		//	$sortBy = array('ID'), $sortOrder = array('asc'), $limit = null, 	$fieldNameLike = null, $like = null, 
		//	$whereSpecial = null, $groupBy = null );
			
		//}
		
		
		$data['itemsList'] = $recs;		
        $this->load->view('ICTJRS/request-items-list', $data);
    }

	
}