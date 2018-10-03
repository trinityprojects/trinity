<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityPurchasing extends MY_Controller {

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
	 * DATE CREATED: July 15, 2018
     * DATE UPDATED: July 15, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function aSRSCreateRequest() {
        //echo "HELLO WORLD";
        $this->load->view('ASRS/request-create-form');
    }

	
    public function aSRSCreateRequestConfirmation() {
		$data['requestPurpose'] = $_POST["requestPurpose"];
		$data['requestRemarks'] = $_POST["requestRemarks"];
		$data['dateNeeded'] = $_POST["dateNeeded"];
		$this->load->view('ASRS/request-create-confirmation', $data);
    }
	
    public function aSRSCreatedRequest() {
		$data['ID'] = $_POST["ID"];
        $this->load->view('ASRS/request-created-details', $data);
    }


	public function aSRSShowUploadedFiles() {
		

		$get = $this->input->get();  
		$clean = $this->security->xss_clean($get);
		
		$ID = isset($clean['ID']) ? $clean['ID'] : '';
		$userName = $this->_getUserName(1);
		 
		//$results = array();

		$recsImages = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_job_request_transaction_asrs_attachments'), 
		$fieldName = array('requestNumber'), $where = array($ID), 
		$join = null, $joinType = null, 
		$sortBy = array('fileType', 'attachments'), $sortOrder = array('asc', 'asc'), 
		$limit = null, 	$fieldNameLike = null, $like = null, 
		$whereSpecial = array("fileType like 'image%'"), $groupBy = null );

		$recsApps = $this->_getRecordsData($data = array('*'), 
		$tables = array('triune_job_request_transaction_asrs_attachments'), 
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
		
        $this->load->view('ASRS/request-uploaded-images-list', $results);
		
	}

	public function aSRSDeleteUploadedFiles() {

		$get = $this->input->get();  
		$clean = $this->security->xss_clean($get);
		
		$attachment = isset($clean['attachment']) ? $clean['attachment'] : '';
		$type = isset($clean['type']) ? $clean['type'] : '';
		
		$userName = $this->_getUserName(1);

		//DELETE PREVIOUS PENALTY RECORD
		$where = array($attachment);
		$fieldName = array('attachments');
		$this->_deleteRecords('triune_job_request_transaction_asrs_attachments', $fieldName, $where);
		//DELETE PREVIOUS PENALTY RECORD
		
		
		$file = $_SERVER['DOCUMENT_ROOT'] . "/trinity/assets/uploads/asrs/" . $attachment;
		if (!unlink($file))
		  {
		  //echo ("Error deleting $file");
		  }
		else
		  {
		  //echo ("Deleted $file");
		  }		
		//echo $file;
		
		$returnValue['success'] = 1;
		$returnValue['type'] = $type;
			
		echo json_encode($returnValue);
		
		
	}	

	public function aSRSMyRequestList() {
        $this->load->view('ASRS/request-my-list');
	}	
	
	
    public function aSRSRequestItems() {
		$data['ID'] = $_POST["ID"];
		$data['accessType'] = $_POST["accessType"];

		$recs= $this->_getRecordsData($dataSelect = array('*'), 
		$tables = array('triune_job_request_transaction_asrs_items'), 
		$fieldName = array('requestNumber'), $where = array($data['ID']), 
		$join = null, $joinType = null, 
		$sortBy = array('ID'), $sortOrder = array('asc'), 
		$limit = null, 	$fieldNameLike = null, $like = null, 
		$whereSpecial = null, $groupBy = null );
		
		$data['itemsList'] = $recs;		
        $this->load->view('ASRS/request-items-list', $data);
    }

    public function aSRSSupplierNames() {
		$data['ID'] = $_POST["ID"];
		$data['accessType'] = $_POST["accessType"];


		$data['supplierNames'] = null;
		$selectData = "triune_supplier.supplierName, triune_supplier.supplierAddress, triune_supplier.supplierTelNumber, triune_job_request_transaction_asrs_supplier.updatedBy, ";
		$selectData = $selectData . "triune_supplier.supplierMobileNumber, triune_supplier.supplierEmailAddress, triune_supplier.supplierContactPerson, triune_job_request_transaction_asrs_supplier.supplierBidStatus, ";
		$selectData = $selectData . "triune_job_request_transaction_asrs_supplier.ID";

		$recs = $this->_getRecordsData($rec = array($selectData), 
		$tables = array('triune_job_request_transaction_asrs_supplier', 'triune_supplier'), 
		$fieldName = array('requestNumber'), 
		$where = array($data['ID']), 
		$join = array('triune_job_request_transaction_asrs_supplier.supplierID = triune_supplier.ID'), 
		$joinType = array('inner'), $sortBy = array('triune_job_request_transaction_asrs_supplier.ID'), $sortOrder = array('asc'), 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );

		if(!empty($recs)) {
			$data['supplierNames'] = $recs;
		}

        $this->load->view('ASRS/request-supplier-names', $data);
    }

    public function aSRSBiddingPreparation() {
		$data['ID'] = $_POST["ID"];
		$data['accessType'] = $_POST["accessType"];


		$data['supplierNames'] = null;
		$selectData = "triune_supplier.supplierName, triune_supplier.supplierAddress, triune_supplier.supplierTelNumber, triune_job_request_transaction_asrs_supplier.updatedBy, ";
		$selectData = $selectData . "triune_supplier.supplierMobileNumber, triune_supplier.supplierEmailAddress, triune_supplier.supplierContactPerson, triune_job_request_transaction_asrs_supplier.supplierBidStatus, ";
		$selectData = $selectData . "triune_job_request_transaction_asrs_supplier.ID";

		$recs = $this->_getRecordsData($rec = array($selectData), 
		$tables = array('triune_job_request_transaction_asrs_supplier', 'triune_supplier'), 
		$fieldName = array('requestNumber'), 
		$where = array($data['ID']), 
		$join = array('triune_job_request_transaction_asrs_supplier.supplierID = triune_supplier.ID'), 
		$joinType = array('inner'), $sortBy = array('triune_job_request_transaction_asrs_supplier.ID'), $sortOrder = array('asc'), 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );

		if(!empty($recs)) {
			$data['supplierNames'] = $recs;
		}

        $this->load->view('ASRS/request-bidding-preparation', $data);
    }	
	

    public function showPBACMember() {
		$data['ID'] = $_POST["ID"];
		$data['accessType'] = $_POST["accessType"];

		$data['PBACMembers'] = null;
		$selectData = "triune_organization_unit.orgUnitCode, triune_organization_unit.orgUnitName, triune_organization_unit.headTitle, triune_job_request_transaction_asrs_bidding_member.ID, ";
		$selectData = $selectData . "triune_employee_data.lastName, triune_employee_data.firstName, triune_employee_data.middleName, triune_employee_data.prefixName ";

		$recs = $this->_getRecordsData($rec = array($selectData), 
		$tables = array('triune_organization_unit', 'triune_job_request_transaction_asrs_bidding_member', 'triune_employee_data'), 
		$fieldName = array('triune_job_request_transaction_asrs_bidding_member.requestNumber'), 
		$where = array($data['ID']), 
		$join = array('triune_job_request_transaction_asrs_bidding_member.pbacUnit = triune_organization_unit.orgUnitCode', 'triune_organization_unit.currentUnitHead = triune_employee_data.employeeNumber'), 
		$joinType = array('inner', 'inner'), $sortBy = array('triune_job_request_transaction_asrs_bidding_member.ID'), $sortOrder = array('asc'), 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );

		if(!empty($recs)) {
			$data['PBACMembers'] = $recs;
		}

        $this->load->view('ASRS/request-pbac-member', $data);
    }	

	
	public function aSRSRequestList() {

		$data['requestStatus'] = $_GET["param"];
		$data['sequence'] = $_GET["sequence"];;
		$data['system'] = $_GET["system"];
		$userName = $this->_getUserName(1);

		$results = $this->_getRecordsData($records = array('triune_privilege.param'), 
			$tables = array('triune_user_privilege', 'triune_privilege'), 
			$fieldName = array('triune_user_privilege.userNumber', 'triune_user_privilege.groupSystemID', 'triune_user_privilege.sourceSystemID'), 
			$where = array($userName, 'Purchasing', $data['system']), 
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
			} elseif($row->param == 'A') {
				array_push($data['statusD'], 'UnitApproval');
				$x++;
			} elseif($row->param == 'S') {
				array_push($data['statusD'], 'Submitted');
				$x++;
			} elseif($row->param == 'U') {
				array_push($data['statusD'], 'UnitReview');
				$x++;

			} elseif($row->param == 'E') {
				array_push($data['statusD'], 'Estimated');
				$x++;
			} elseif($row->param == 'I') {
				array_push($data['statusD'], 'InProgress');
				$x++;
			} elseif($row->param == 'R') {
				array_push($data['statusD'], 'Returned');
				$x++;
			} elseif($row->param == 'C') {
				array_push($data['statusD'], 'Completed');
				$x++;
			} elseif($row->param == 'X') {
				array_push($data['statusD'], 'Closed');
				$x++;
			}
		}

		for($i = 0; $i < $x; $i++) {
			if($data['statusR'][$i] == $data['requestStatus']) {
				$data['sequence'] = ($i + 1);
				break;
			}
			
		}
        $this->load->view('ASRS/request-list', $data);
	}




	public function aSRSRequestDetails() {

		$data['ID'] = $_POST["ID"];

		$details = $this->_getTransactionDetails($data['ID'], $from = 'triune_job_request_transaction_asrs');

		$data['requestPurpose'] = $details[0]->requestPurpose;
		$data['requestRemarks'] = $details[0]->requestRemarks;
		$data['returnedFrom'] = $details[0]->returnedFrom;
		$data['dateNeeded'] = $details[0]->dateNeeded;
		$data['dateCreated'] = $details[0]->dateCreated;
		$data['dateClosed'] = $details[0]->dateClosed;
		$data['requestStatus'] = $details[0]->requestStatus;
		$data['departmentUnit'] = $details[0]->departmentUnit;
		$data['unitReviewer'] = $details[0]->unitReviewer;
		$data['returnedFrom'] = $details[0]->returnedFrom;

	
		$results1 = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_asrs_attachments'), 
		$fieldName = array('requestNumber'), $where = array($data['ID']), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, 
		$whereSpecial = array("fileType like 'image%'"), 
		$groupBy = null );
		
		$data['attachments'] = $results1;
		$data['requestStatusDescription'] = $this->_getRequestStatusDescription($data['requestStatus'], 'ASRS');


		$results1App = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_asrs_attachments'), 
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
		$data['currentDepartment'] = $results2[0]->currentDepartment;
		$data['userNumber'] = $this->_getUserName(1);

		
		$data['owner'] = 0;
		if($data['userName'] == $data['userNumber']) { 
			$data['owner'] = 1;
		}
		

		$details1 = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_asrs_status_history'), 
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

		$data['items'] = null;
		
		$data['statusHistory'] = null;
		


			$itemsSelect = "triune_job_request_transaction_asrs_items.*";

			$results = $this->_getRecordsData($rec = array($itemsSelect), 
			$tables = array('triune_job_request_transaction_asrs_items'), 
			$fieldName = array('requestNumber'), 
			$where = array($data['ID']), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );
			if(!empty($results)) {
				$data['items'] = $results;
			}

			$statusHistorySelect = "triune_job_request_transaction_asrs_status_history.requestStatus, ";
			$statusHistorySelect = $statusHistorySelect . "triune_job_request_transaction_asrs_status_history.timeStamp, ";
			$statusHistorySelect = $statusHistorySelect . "triune_job_request_transaction_asrs_status_history.updatedBy, ";
			$statusHistorySelect = $statusHistorySelect . "triune_request_status_reference.requestStatusDescription ";
			
			$results1 = $this->_getRecordsData($rec = array($statusHistorySelect), 
			$tables = array('triune_job_request_transaction_asrs_status_history', 'triune_request_status_reference'), 
			$fieldName = array('triune_job_request_transaction_asrs_status_history.requestNumber', 'triune_request_status_reference.application'), 
			$where = array($data['ID'], 'ASRS'), 
			$join = array('triune_job_request_transaction_asrs_status_history.requestStatus = triune_request_status_reference.requestStatusCode'), $joinType = array('left'), 
			$sortBy = array('triune_job_request_transaction_asrs_status_history.ID'), $sortOrder = array('asc'), 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );

			if(!empty($results1)) {
				$data['statusHistory'] = $results1;
			}


			

			$data['specialInstructions'] = null;
			$results2 = $this->_getRecordsData($rec = array('*'), 
			$tables = array('triune_job_request_transaction_asrs_special_instructions'), 
			$fieldName = array('requestNumber'), 
			$where = array($data['ID']), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );
			if(!empty($results2)) {
				$data['specialInstructions'] = $results2;
			}
			
			$data['requestNotes'] = null;
			$results3 = $this->_getRecordsData($rec = array('*'), 
			$tables = array('triune_job_request_transaction_asrs_request_notes'), 
			$fieldName = array('requestNumber'), 
			$where = array($data['ID']), 
			$join = null, $joinType = null, $sortBy = array('ID'), $sortOrder = array('asc'), 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );

			if(!empty($results3)) {
				$data['requestNotes'] = $results3;
			}

			$data['itemsList'] = null;
			$results4= $this->_getRecordsData($dataSelect = array('*'), 
			$tables = array('triune_job_request_transaction_asrs_items'), 
			$fieldName = array('requestNumber'), $where = array($data['ID']), 
			$join = null, $joinType = null, 
			$sortBy = array('ID'), $sortOrder = array('asc'), 
			$limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			if(!empty($results4)) {
				$data['itemsList'] = $results4;		
			}

			$data['supplierName'] = null;
			$selectData = "triune_supplier.supplierName, triune_supplier.supplierAddress, triune_supplier.supplierTelNumber, triune_job_request_transaction_asrs_supplier.updatedBy, ";
			$selectData = $selectData . "triune_supplier.supplierMobileNumber, triune_supplier.supplierEmailAddress, triune_supplier.supplierContactPerson, triune_job_request_transaction_asrs_supplier.supplierBidStatus";
			$results5 = $this->_getRecordsData($rec = array($selectData), 
			$tables = array('triune_job_request_transaction_asrs_supplier', 'triune_supplier'), 
			$fieldName = array('requestNumber'), 
			$where = array($data['ID']), 
			$join = array('triune_job_request_transaction_asrs_supplier.supplierID = triune_supplier.ID'), 
			$joinType = array('inner'), $sortBy = array('triune_job_request_transaction_asrs_supplier.ID'), $sortOrder = array('asc'), 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );

			if(!empty($results5)) {
				$data['supplierName'] = $results5;
			}


			$data['actualBudgetAmount'] = null;
			$results6 = $this->_getRecordsData($rec = array('*'), 
			$tables = array('triune_job_request_transaction_asrs_actual_budget'), 
			$fieldName = array('requestNumber'), $where = array($data['ID']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			if(!empty($results6)) {
				$data['actualBudgetAmount'] = $results6[0]->actualBudgetAmount;
			}

			$data['requestCategory'] = null;
			$data['requestCategoryType'] = null;
			$results7 = $this->_getRecordsData($rec = array('*'), 
			$tables = array('triune_job_request_transaction_asrs_request_category'), 
			$fieldName = array('requestNumber'), $where = array($data['ID']), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 	$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			if(!empty($results7)) {
				$data['requestCategory'] = $results7;

				foreach($results7 as $row) {
					$data['requestCategoryType'] = $row->requestCategoryText;
				}
			}
			

		$this->load->view('ASRS/request-details', $data);
	}
	
}