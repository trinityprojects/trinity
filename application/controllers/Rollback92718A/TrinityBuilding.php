<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityBuilding extends MY_Controller {

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

    public function tBAMIMSCreateRequest() {
        //echo "HELLO WORLD";
        $this->load->view('TBAMIMS/request-create-form');
    }

    public function tBAMIMSCreateRequestConfirmation() {
		$data['locationCode'] = $_POST["locationCode"];
		$data['floor'] = $_POST["floor"];
		$data['roomNumber'] = $_POST["roomNumber"];
		$data['projectTitle'] = $_POST["projectTitle"];
		$data['scopeOfWorks'] = $_POST["scopeOfWorks"];
		$data['projectJustification'] = $_POST["projectJustification"];
		$data['dateNeeded'] = $_POST["dateNeeded"];
		$this->load->view('TBAMIMS/request-create-confirmation', $data);
    }

    public function tBAMIMSCreatedRequest() {
		$data['ID'] = $_POST["ID"];
        $this->load->view('TBAMIMS/request-created-details', $data);
    }

	public function tBAMIMSMyRequestList() {
        $this->load->view('TBAMIMS/request-my-list');
	}


	
	public function tBAMIMSRequestVerification() {

		$data['ID'] = $_POST["ID"];

		$typeRequest = isset($_POST["type"]) ? intval($_POST["type"]) : 1;
		
		$details = $this->_getTransactionDetails($data['ID'], $from = 'triune_job_request_transaction_tbamims');

		$data['locationCode'] = $details[0]->locationCode;
		$data['floor'] = $details[0]->floor;
		$data['roomNumber'] = $details[0]->roomNumber;
		$data['projectTitle'] = $details[0]->projectTitle;
		$data['scopeOfWorks'] = $details[0]->scopeOfWorks;
		$data['projectJustification'] = $details[0]->projectJustification;
		$data['dateNeeded'] = $details[0]->dateNeeded;
		$data['dateCreated'] = $details[0]->dateCreated;
		$data['requestStatus'] = $details[0]->requestStatus;
		$data['returnedFrom'] = $details[0]->returnedFrom;

		$locationCode = $details[0]->locationCode;
		$data['locationDescription'] = null;
		
			$locationItem = $this->_getRecordsData($rec = array('*'), 
			$tables = array('triune_location'), 
			$fieldName = array('locationCode'), $where = array($locationCode), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
		if(!empty($locationItem)) {
			$data['locationDescription'] = $locationItem[0]->locationDescription;
		}
		
		
		$results1 = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_tbamims_attachments'), 
		$fieldName = array('requestNumber'), $where = array($data['ID']), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = array("fileType like 'image%'"), $groupBy = null );
		
		$data['attachments'] = $results1;
		$data['requestStatusDescription'] = $this->_getRequestStatusDescription($data['requestStatus'], 'TBAMIMS');


		$results1App = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_tbamims_attachments'), 
		$fieldName = array('requestNumber'), $where = array($data['ID']), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, 
		$whereSpecial = array("fileType like 'application%'"), 
		$groupBy = null );
		
		$data['attachmentsApp'] = $results1App;
		
		
		
		$results2 = $this->_getRecordsData($rec = array('triune_employee_data.*'), 
		$tables = array('triune_user', 'triune_employee_data'), 
		$fieldName = array('triune_user.userName'), $where = array($details[0]->userName), 
		$join = array('triune_user.userNumber = triune_employee_data.employeeNumber'), $joinType = array('left'), $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );

		$data['userName'] = $details[0]->userName;
		$data['fullName'] = $results2[0]->lastName . ", " . $results2[0]->firstName . " " . $results2[0]->middleName;
		$data['userNumber'] = $this->_getUserName(1);

		
		$data['owner'] = 0;
		if( ($data['userName'] == $data['userNumber']) || ( ($typeRequest == "all") && ($data['requestStatus'] != 'C') ) ){ 
			$data['owner'] = 1;
		}
		

		$details1 = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_tbamims_status_history'), 
		$fieldName = array('requestNumber'), $where = array($data['ID']), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );


		$data['dateClosed'] = null;

		$from = strtotime($data['dateCreated']);
		$today = time();
		$runningDays = $today - $from;
		
		$from = strtotime($data['dateCreated']);
		$deadline = strtotime($data['dateNeeded']);
		$totalDays = $deadline - $from;
		
		$from = strtotime($data['dateCreated']);
		$closedDate = strtotime($data['dateClosed']);
		$totalDaysTillClosing = $closedDate - $from;

		$data['runningDays'] = floor($runningDays / 86400);
		$data['totalDays'] = floor($totalDays / 86400);
		$data['totalDaysTillClosing'] = floor($totalDaysTillClosing / 86400);

		$data['scopeDetails'] = null;
		$data['materials'] = null;
		
		$data['statusHistory'] = null;
		
		if(($data['requestStatus'] == 'O') || ($data['requestStatus'] == 'A') || ($data['requestStatus'] == 'E') || ($data['requestStatus'] == 'S') || ($data['requestStatus'] == 'W') || ($data['requestStatus'] == 'C') || ($data['requestStatus'] == 'R')) {



			$materialsSelect = "triune_job_request_transaction_tbamims_materials.requestStatus, ";
			$materialsSelect = $materialsSelect . "triune_job_request_transaction_tbamims_materials.ID, ";
			$materialsSelect = $materialsSelect . "triune_job_request_transaction_tbamims_materials.quantity, ";
			$materialsSelect = $materialsSelect . "triune_job_request_materials_tbamims.particulars, ";
			$materialsSelect = $materialsSelect . "triune_job_request_materials_tbamims.units, ";
			$materialsSelect = $materialsSelect . "triune_job_request_transaction_tbamims_materials.materialsID, ";
			$materialsSelect = $materialsSelect . "triune_job_request_transaction_tbamims_materials.materialsAmount, ";
			$materialsSelect = $materialsSelect . "triune_job_request_transaction_tbamims_materials.actualAmount";

			$results5 = $this->_getRecordsData($rec = array($materialsSelect), 
			$tables = array('triune_job_request_transaction_tbamims_materials', 'triune_job_request_materials_tbamims'), 
			$fieldName = array('triune_job_request_transaction_tbamims_materials.requestNumber'), 
			$where = array($data['ID']), 
			$join = array('triune_job_request_transaction_tbamims_materials.materialsID = triune_job_request_materials_tbamims.ID'), $joinType = array('inner'), $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );
			if(!empty($results5)) {
				$data['materials'] = $results5;
			}

			$statusHistorySelect = "triune_job_request_transaction_tbamims_status_history.requestStatus, ";
			$statusHistorySelect = $statusHistorySelect . "triune_job_request_transaction_tbamims_status_history.timeStamp, ";
			$statusHistorySelect = $statusHistorySelect . "triune_job_request_transaction_tbamims_status_history.updatedBy, ";
			$statusHistorySelect = $statusHistorySelect . "triune_request_status_reference.requestStatusDescription ";
			
			$results10 = $this->_getRecordsData($rec = array($statusHistorySelect), 
			$tables = array('triune_job_request_transaction_tbamims_status_history', 'triune_request_status_reference'), 
			$fieldName = array('triune_job_request_transaction_tbamims_status_history.requestNumber', 'triune_request_status_reference.application'), 
			$where = array($data['ID'], 'TBAMIMS'), 
			$join = array('triune_job_request_transaction_tbamims_status_history.requestStatus = triune_request_status_reference.requestStatusCode'), $joinType = array('left'), 
			$sortBy = array('triune_job_request_transaction_tbamims_status_history.ID'), $sortOrder = array('asc'), 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );

			if(!empty($results10)) {
				$data['statusHistory'] = $results10;
			}



			
			$data['actualBudgetAmount'] = null;
			$results17 = $this->_getRecordsData($rec = array('*'), 
			$tables = array('triune_job_request_transaction_tbamims_actual_budget'), 
			$fieldName = array('requestNumber', 'requestStatus'), 
			$where = array($data['ID'], 'S'), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );

			if(!empty($results17)) {
				$data['actualBudgetAmount'] = $results17[0]->actualBudgetAmount;
			}



			$data['jobDescription'] = null;
			$data['jobOrderNumber'] = null;
			$results21 = $this->_getRecordsData($rec = array('*'), 
			$tables = array('triune_job_request_job_order'), 
			$fieldName = array('requestNumber', 'requestStatus'), 
			$where = array($data['ID'], 'W'), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );

			if(!empty($results21)) {
				$data['jobDescription'] = $results21[0]->jobDescription;
				$data['jobOrderNumber'] = $results21[0]->ID;
				
			}
			

			$data['specialInstructions'] = null;
			$results25 = $this->_getRecordsData($rec = array('*'), 
			$tables = array('triune_job_request_transaction_tbamims_special_instructions'), 
			$fieldName = array('requestNumber'), 
			$where = array($data['ID']), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );
			if(!empty($results25)) {
				$data['specialInstructions'] = $results25;
			}
			
			$data['scopeDetails'] = null;
			$results26 = $this->_getRecordsData($rec = array('*'), 
			$tables = array('triune_job_request_transaction_tbamims_scope_details'), 
			$fieldName = array('requestNumber'), 
			$where = array($data['ID']), 
			$join = null, $joinType = null, $sortBy = array('ID'), $sortOrder = array('asc'), 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );

			if(!empty($results26)) {
				$data['scopeDetails'] = $results26;
			}

            $data['requestStatusRemarksDescription'] = null;		
			$remarksSelect = "triune_job_request_status.statusDescription, triune_job_request_status.ID, triune_job_request_transaction_tbamims_status_remarks.updatedBy";
			
			$results27 = $this->_getRecordsData($rec = array($remarksSelect), 
			$tables = array('triune_job_request_transaction_tbamims_status_remarks', 'triune_job_request_status'), 
			$fieldName = array('triune_job_request_transaction_tbamims_status_remarks.requestNumber', 'triune_job_request_transaction_tbamims_status_remarks.requestStatus'), 
			$where = array($data['ID']), 
			$join = array('triune_job_request_transaction_tbamims_status_remarks.requestStatusRemarksID = triune_job_request_status.ID'), 
			$joinType = array('inner'), $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );
			if(!empty($results27)) {
				$data['requestStatusRemarksDescription'] = $results27;
			}


			
		}


		$this->load->view('TBAMIMS/request-verification', $data);
	}

	public function tBAMIMSRequestList() {

		$data['requestStatus'] = $_GET["param"];
		$data['sequence'] = $_GET["sequence"];;
		$data['system'] = $_GET["system"];
		$userName = $this->_getUserName(1);

		$results = $this->_getRecordsData($records = array('triune_privilege.param'), 
			$tables = array('triune_user_privilege', 'triune_privilege'), 
			$fieldName = array('triune_user_privilege.userNumber', 'triune_user_privilege.groupSystemID', 'triune_user_privilege.sourceSystemID'), 
			$where = array($userName, 'Building', $data['system']), 
			$join = array('triune_user_privilege.orgCode = triune_privilege.orgCode AND triune_user_privilege.branchOfficeCode = triune_privilege.branchOfficeCode AND triune_user_privilege.categorySystemID = triune_privilege.categorySystemID AND triune_user_privilege.groupSystemID = triune_privilege.groupSystemID AND triune_user_privilege.sourceSystemID = triune_privilege.sourceSystemID AND triune_user_privilege.dataElementID = triune_privilege.dataElementID AND triune_user_privilege.elementValueID = triune_privilege.elementValueID'), 
			$joinType = array('inner'), 
			$sortBy = array('triune_privilege.sequenceOrder'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = array("triune_user_privilege.dataElementID LIKE 'REQUEST%MNU'"), 
			$groupBy = null );

		$data['statusR'] = array();
		$data['statusD'] = array();

		$x = 0;
		foreach($results as $row) {
			array_push($data['statusR'], $row->param);
			if($row->param == 'N') {
				array_push($data['statusD'], 'New');
				$x++;
			} elseif($row->param == 'O') {
				array_push($data['statusD'], 'Open');
				$x++;
			} elseif($row->param == 'A') {
				array_push($data['statusD'], 'Approved');
				$x++;
			} elseif($row->param == 'E') {
				array_push($data['statusD'], 'Estimated');
				$x++;
			} elseif($row->param == 'S') {
				array_push($data['statusD'], 'Set');
				$x++;
			} elseif($row->param == 'W') {
				array_push($data['statusD'], 'WIP');
				$x++;
			} elseif($row->param == 'R') {
				array_push($data['statusD'], 'Returned');
				$x++;
			} elseif($row->param == 'X') {
				array_push($data['statusD'], 'Closed');
				$x++;
			} elseif($row->param == 'C') {
				array_push($data['statusD'], 'Completed');
				$x++;
			}
		}

		for($i = 0; $i < $x; $i++) {
			if($data['statusR'][$i] == $data['requestStatus']) {
				$data['sequence'] = ($i + 1);
				break;
			}
			
		}
        $this->load->view('TBAMIMS/request-list', $data);
	}

    public function tBAMIMSMaterialsList() {
		$data['ctr'] = $_GET["ctr"];
		//echo $data['ctr'];
		$results = $this->_getRecordsData($records = array('particulars', 'units', 'ID'), 
			$tables = array('triune_job_request_materials_tbamims'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('particulars'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			$rec = "[";

			foreach($results as $row) {

				$rec = $rec . "['" . trim($row->particulars) . "','" . trim($row->units, '     ') . "','" . $row->ID ."'], ";

			}
			$rec = $rec . "]";


		$data['items'] = $rec;
		
		//echo $rec;
		$this->load->view('TBAMIMS/materials-autocomplete', $data);
    }


	
    public function tBAMIMSRequestStatuList() {
		$data['unitCode'] = $_GET["unitCode"];
		$data['userNumber'] = $_GET["userNumber"];
		
		//echo $data['ctr'];
		$results = $this->_getRecordsData($records = array('statusDescription', 'ID'), 
			$tables = array('triune_job_request_status'), $fieldName = array('unitCode'), $where = array($data['unitCode']), $join = null, $joinType = null, 
			$sortBy = array('statusDescription'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			$rec = "[";

			foreach($results as $row) {

				$rec = $rec . "['" . trim($row->statusDescription) . "','" . $row->ID ."'], ";

			}
			$rec = $rec . "]";


		$data['items'] = $rec;
		
		//echo $rec;
		$this->load->view('TBAMIMS/request-status-autocomplete', $data);
    }


    public function tBAMIMSWorkerList() {
		$data['userNumber'] = $_GET["userNumber"];
		$data['ID'] = $_GET["requestID"];
		$data['requestStatus'] = $_GET["requestStatus"];
		$data['owner'] = $_GET["owner"];

		$resultsA = null;
		$data['workerName'] = null;
		$data['jobDescription'] = null;
		$data['startDatePlanned'] = null;
		$data['completionDateTarget'] = null;
		$data['jobOrderNumber'] = null;
		
		$data['days'] = null;
		$results1 = null;
		$results2 = null;
		$data['items'] = null;
		$data['jobDesc'] = null;
		

		$resultsA = $this->_getRecordsData($records = array('*'), 
			$tables = array('triune_job_request_job_order'), $fieldName = array('requestNumber'), $where = array($data['ID']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
		
		if(!empty($resultsA)) {
			$data['workerName'] = $resultsA[0]->workerName;
			$data['jobDescription'] = $resultsA[0]->jobDescription;
			$data['startDatePlanned'] = $resultsA[0]->startDatePlanned;
			$data['completionDateTarget'] = $resultsA[0]->completionDateTarget;
			$data['jobOrderNumber'] = $resultsA[0]->ID;
			
						
			$data['days'] = $this->_getWorkingDays($data['startDatePlanned'],$data['completionDateTarget']);

			
			
		}
		$data['jobOrderExist'] = $resultsA;
		
		if(empty($resultsA)) {
				$results1 = $this->_getRecordsData($records = array('employeeNumber', 'lastName', 'firstName'), 
					$tables = array('triune_employee_data'), $fieldName = array('currentDepartment'), $where = array('BAM'), $join = null, $joinType = null, 
					$sortBy = array('lastName', 'firstName'), $sortOrder = array('asc', 'asc'), $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
				
				$results2 = $this->_getRecordsData($records = array('ID', 'partnerName'), 
					$tables = array('triune_third_party_partner'), $fieldName = array('currentDepartment'), $where = array('BAM'), $join = null, $joinType = null, 
					$sortBy = array('partnerName'), $sortOrder = array('asc'), $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );

				$workerName = null;
				$workerID = null;
					
				$rec = "[";

				foreach($results1 as $row) {
					$workerName = trim($row->lastName . ", " . $row->firstName);
					$workerID =  $row->employeeNumber;
					
					$rec = $rec . "['" . $workerName . "','" . $workerID ."'], ";
				}


				foreach($results2 as $row) {
					$workerName = trim($row->partnerName);
					$workerID =  $row->ID;
					
					$rec = $rec . "['" . $workerName . "','" . $workerID ."'], ";
				}
				
				
				$rec = $rec . "]";


				$data['items'] = $rec;
				
				
				$data['jobDesc'] = null;
				$results21 = $this->_getRecordsData($rec = array('*'), 
				$tables = array('triune_job_order_job_description'), 
				$fieldName = null, 
				$where = null, 
				$join = null, $joinType = null, $sortBy = array('ID'), $sortOrder = array('asc'), 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
				$groupBy = null );

				if(!empty($results21)) {
					$data['jobDesc'] = $results21;
				}
		}
		
		//echo $rec;
		$this->load->view('TBAMIMS/job-order-worker-form', $data);
    }



    public function tBAMIMSWorkerListExist() {
		$data['userNumber'] = $_GET["userNumber"];
		$data['ID'] = $_GET["requestID"];

		$results1 = $this->_getRecordsData($records = array('*'), 
			$tables = array('triune_job_request_job_order'), $fieldName = array('requestNumber'), $where = array($data['ID']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		$data['workerName'] = $results1[0]->workerName;
		$data['jobDescription'] = $results1[0]->jobDescription;
		$data['startDatePlanned'] = $results1[0]->startDatePlanned;
		$data['completionDateTarget'] = $results1[0]->completionDateTarget;

		$this->load->view('TBAMIMS/job-order-created-record', $data);
    }


	
    public function tBAMIMSJobOrderEvaluation() {
		$data['userNumber'] = $_GET["userNumber"];
		$data['ID'] = $_GET["requestID"];
		$data['requestStatus'] = $_GET["requestStatus"];
		$data['jobOrderNumber'] = $_GET["jobOrderNumber"];
		$data['owner'] = $_GET["owner"];

		$questions = null;
		$selections = null;
		$answers = null;
		$data['answers'] =	null;	

		$answers = $this->_getRecordsData($records = array('*'), 
			$tables = array('triune_job_request_evaluation_answers'), 
			$fieldName = array('requestNumber', 'jobOrderNumber'), $where = array($data['requestStatus'], $data['jobOrderNumber']), $join = null, $joinType = null, 
			$sortBy = array('questionCategoryID'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
		
		if(!empty($answers)) {
			$data['answers'] = $answers;
		}
	
		$questions = $this->_getRecordsData($records = array('*'), 
			$tables = array('triune_job_request_evaluation_questions'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('ID'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		$data['questions'] = $questions;
		
		$selections = $this->_getRecordsData($records = array('*'), 
			$tables = array('triune_job_request_evaluation_questions_selection'), $fieldName = null, $where = null, $join = null, $joinType = null, 
			$sortBy = array('questionCategoryID', 'selectionCode'), $sortOrder = array('asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

		$data['selections'] = $selections;
		
		//echo $rec;
		$this->load->view('TBAMIMS/job-order-evaluation-form', $data);
    }
	
	
	public function tBAMIMSShowUploadedFiles() {
		

		$get = $this->input->get();  
		$clean = $this->security->xss_clean($get);
		
		$ID = isset($clean['ID']) ? $clean['ID'] : '';
		$userName = $this->_getUserName(1);
		 
		//$results = array();

		$recsImages = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_job_request_transaction_tbamims_attachments'), 
		$fieldName = array('requestNumber'), $where = array($ID), 
		$join = null, $joinType = null, 
		$sortBy = array('fileType', 'attachments'), $sortOrder = array('asc', 'asc'), 
		$limit = null, 	$fieldNameLike = null, $like = null, 
		$whereSpecial = array("fileType like 'image%'"), $groupBy = null );

		$recsApps = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_job_request_transaction_tbamims_attachments'), 
		$fieldName = array('requestNumber'), $where = array($ID), 
		$join = null, $joinType = null, 
		$sortBy = array('fileType', 'attachments'), $sortOrder = array('asc', 'asc'), 
		$limit = null, 	$fieldNameLike = null, $like = null, 
		$whereSpecial = array("fileType like 'application%'"), $groupBy = null );
		
		$results["userName"] = $userName;
		$results["baseURL"] = $this->config->base_url();

		$results["ID"] = $ID;
		$results["rowsImages"] = $recsImages;
		$results["rowsApps"] = $recsApps;

		//echo json_encode($results);
		
        $this->load->view('TBAMIMS/request-uploaded-images-list', $results);
		
	}

	
	public function tBAMIMSDeleteUploadedFiles() {

		$get = $this->input->get();  
		$clean = $this->security->xss_clean($get);
		
		$attachment = isset($clean['attachment']) ? $clean['attachment'] : '';
		$userName = $this->_getUserName(1);

		//DELETE PREVIOUS PENALTY RECORD
		$where = array($attachment);
		$fieldName = array('attachments');
		$this->_deleteRecords('triune_job_request_transaction_tbamims_attachments', $fieldName, $where);
		//DELETE PREVIOUS PENALTY RECORD
		
		
		$file = $_SERVER['DOCUMENT_ROOT'] . "/trinity/assets/uploads/tbamims/" . $attachment;
		if (!unlink($file))
		  {
		  echo ("Error deleting $file");
		  }
		else
		  {
		  echo ("Deleted $file");
		  }		
		echo $file;
	}	

	public function tBAMIMSJobOrder() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$jobOrderNumber = isset($clean['jobOrderNumber']) ? $clean['jobOrderNumber'] : '';
		$requestNumber = isset($clean['requestNumber']) ? $clean['requestNumber'] : '';

		$recJO = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_job_order'), 
		$fieldName = array('ID'), $where = array($jobOrderNumber), 
		$join = null, $joinType = null, 
		$sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, 
		$whereSpecial = null, $groupBy = null );
		
		
		$data['jobOrderNumber'] = $jobOrderNumber;
		$data['requestNumber'] = $requestNumber;
		$data['workerName'] = $recJO[0]->workerName;
		$data['jobDescription'] = $recJO[0]->jobDescription;
		$data['startDatePlanned'] = $recJO[0]->startDatePlanned;
		$data['completionDateTarget'] = $recJO[0]->completionDateTarget;
		$data['timeStamp'] = $recJO[0]->timeStamp;

		$data['days'] = $this->_getWorkingDays($data['startDatePlanned'],$data['completionDateTarget']);
		
		$recRequest = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_tbamims'), 
		$fieldName = array('ID'), $where = array($requestNumber), 
		$join = null, $joinType = null, 
		$sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, 
		$whereSpecial = null, $groupBy = null );
		$data['locationCode'] = $recRequest[0]->locationCode;
		$data['floor'] = $recRequest[0]->floor;
		$data['roomNumber'] = $recRequest[0]->roomNumber;
		$data['scopeOfWorks'] = $recRequest[0]->scopeOfWorks;
		$data['userName'] = $recRequest[0]->userName;
		
		$recScope = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_tbamims_scope_details'), 
		$fieldName = array('requestNumber'), $where = array($requestNumber), 
		$join = null, $joinType = null, 
		$sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, 
		$whereSpecial = null, $groupBy = null );

		$data['scopeDetails'] = $recScope;
	
		$this->load->library('Pdf');
		$this->load->view('viewPDF', $data);	

		//$this->load->library('pdf');
		//$this->load->view('viewPDF1', $data);		
		
	}	


	public function tBAMIMSJobOrderList() {
        $this->load->view('TBAMIMS/job-order-list');
	}



    public function tBAMIMSJobOrderDetails() {
		$data['ID'] = $_POST["ID"];

		$jobOrderRec = null;
		$data['workerName'] = null;
		$data['jobDescription'] = null;
		$data['startDatePlanned'] = null;
		$data['completionDateTarget'] = null;
		$data['jobOrderNumber'] = null;
		$data['days'] = null;
		$data['requestNumber'] = null;
		$data['dateCompleted'] = null;

		$data['locationCode'] = null;
		$data['floor'] = null;
		$data['roomNumber'] = null;
		$data['projectTitle'] = null;
		$data['scopeOfWorks'] = null;
		$data['projectJustification'] = null;
		$data['dateNeeded'] = null;
		$data['dateCreated'] = null;
		$data['dateClosed'] = null;
		$data['userName'] = null;


		

		$jobOrderRec = $this->_getRecordsData($records = array('*'), 
			$tables = array('triune_job_request_job_order'), $fieldName = array('ID'), $where = array($data['ID']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
		
		if(!empty($jobOrderRec)) {
			$data['workerName'] = $jobOrderRec[0]->workerName;
			$data['jobDescription'] = $jobOrderRec[0]->jobDescription;
			$data['startDatePlanned'] = $jobOrderRec[0]->startDatePlanned;
			$data['completionDateTarget'] = $jobOrderRec[0]->completionDateTarget;
			$data['jobOrderNumber'] = $jobOrderRec[0]->ID;
			$data['requestNumber']  = $jobOrderRec[0]->requestNumber;
			$data['dateCompleted']  = $jobOrderRec[0]->dateCompleted;
			
			$data['jobOrderDuration'] = $this->_getWorkingDays($data['startDatePlanned'],$data['completionDateTarget']);
			$data['jobOrderDurationActual'] = $this->_getWorkingDays($data['startDatePlanned'],$data['dateCompleted']);
			
		}
		
		$requestTransRec = $this->_getRecordsData($records = array('*'), 
			$tables = array('triune_job_request_transaction_tbamims'), $fieldName = array('ID'), $where = array($data['requestNumber']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

		if(!empty($requestTransRec)) {
			$data['locationCode'] = $requestTransRec[0]->locationCode;
			$data['floor'] = $requestTransRec[0]->floor;
			$data['roomNumber'] = $requestTransRec[0]->roomNumber;
			$data['projectTitle'] = $requestTransRec[0]->projectTitle;
			$data['scopeOfWorks'] = $requestTransRec[0]->scopeOfWorks;
			$data['projectJustification'] = $requestTransRec[0]->projectJustification;
			$data['dateNeeded'] = $requestTransRec[0]->dateNeeded;
			$data['dateCreated'] = $requestTransRec[0]->dateCreated;
			$data['dateClosed'] = $requestTransRec[0]->dateClosed;

			$data['userName'] = $requestTransRec[0]->userName;
	
			$data['projectDuration'] = $this->_getWorkingDays($data['dateCreated'],$data['dateNeeded']);
			$data['projectDurationActual'] = $this->_getWorkingDays($data['dateCreated'],$data['dateClosed']);
			
		}
			
	
		//echo $rec;
		$this->load->view('TBAMIMS/job-order-details', $data);
    }
	
	
	
	public function tBAMIMSAllRequestList() {
       $this->load->view('TBAMIMS/request-all-list');
	}
	

	public function tBAMIMSLocationList() {
        $this->load->view('TBAMIMS/location-list');
	}

	public function tBAMIMSRoomsList() {
        $this->load->view('TBAMIMS/rooms-list');
	}
	
	
}