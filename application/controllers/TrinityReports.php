<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityReports extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: File Controller.  
	 * DATE CREATED: July 15, 2018
     * DATE UPDATED: July 15, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation'); 

    }//function __construct()


	public function printReports() {
		$fieldNames = $_POST['fieldNames'];
		$fieldValues = $_POST['fieldValues'];
		$type = $_POST['type'];
		$report = $_POST['report'];
		$data['fieldNames'] = $fieldNames;
		$data['fieldValues'] = $fieldValues;
		$data['type'] = $type;


		$fiedlValArr = explode(",", $fieldValues);
		$fiedlNamArr = explode(",", $fieldNames);

		$fieldVarCount = count($fiedlValArr);

		for($i = 0; $i < $fieldVarCount; $i++) {
		  $fieldIndex = $fiedlNamArr[$i];
		  //echo $fieldIndex;
		  $data[$fieldIndex] = $fiedlValArr[$i];
		}
		if($type == 'requestSet') {

			$selectField1 = "triune_job_request_transaction_tbamims.sy, triune_job_request_transaction_tbamims.projectTitle, triune_job_request_transaction_tbamims.scopeOfWorks, ";
			$selectField1 = $selectField1 . "triune_job_request_transaction_tbamims.projectJustification, triune_job_request_transaction_tbamims.dateNeeded, triune_job_request_transaction_tbamims.dateCreated, ";
			$selectField1 = $selectField1 . "triune_job_request_transaction_tbamims.dateCompleted, triune_job_request_transaction_tbamims.dateClosed, triune_job_request_transaction_tbamims.userName, ";
			$selectField1 = $selectField1 . "triune_location.locationDescription, triune_location.locationType, triune_rooms.floor, triune_rooms.roomType, triune_rooms.roomNumber ";
			$jobRequest = $this->_getRecordsData($dataSelect1 = array($selectField1),
			$tables = array('triune_job_request_transaction_tbamims', 'triune_location', 'triune_rooms'), 
			$fieldName = array('triune_job_request_transaction_tbamims.ID'), $where = array($fiedlValArr[0]), 
			$join = array('triune_job_request_transaction_tbamims.locationCode = triune_location.locationCode', 'triune_job_request_transaction_tbamims.roomNumber = triune_rooms.roomNumber'), 
			$joinType = array('left', 'left'), 
			$sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$data['jobRequest'] = $jobRequest;
			

			$selectField2 = "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName) as fullName, ";
			$selectField2 = $selectField2 . "triune_employee_data.currentDepartment";
			$requestor = $this->_getRecordsData($dataSelect2 = array($selectField2),
			$tables = array('triune_user', 'triune_employee_data'), 
			$fieldName = array('triune_user.userName'), $where = array($jobRequest[0]->userName), 
			$join = array('triune_user.userNumber = triune_employee_data.employeeNumber'), 
			$joinType = array('inner'), $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$data['requestor'] = $requestor;

			
			$selectField3 = "*";
			$instructions = $this->_getRecordsData($dataSelect3 = array($selectField3),
			$tables = array('triune_job_request_transaction_tbamims_special_instructions'), 
			$fieldName = array('triune_job_request_transaction_tbamims_special_instructions.requestNumber'), $where = array($fiedlValArr[0]), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$data['instructions'] = $instructions;

			
			$selectField4 = "triune_job_request_status.statusDescription, triune_job_request_transaction_tbamims_status_remarks.updatedBy, triune_job_request_transaction_tbamims_status_remarks.userName";
			$statusRemarks = $this->_getRecordsData($dataSelect4 = array($selectField4),
			$tables = array('triune_job_request_transaction_tbamims_status_remarks', 'triune_job_request_status'), 
			$fieldName = array('triune_job_request_transaction_tbamims_status_remarks.requestNumber'), $where = array($fiedlValArr[0]), 
			$join = array('triune_job_request_transaction_tbamims_status_remarks.requestStatusRemarksID = triune_job_request_status.ID'), $joinType = array('inner'), 
			$sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$data['statusRemarks'] = $statusRemarks;

			$selectField5 = "triune_job_request_transaction_tbamims_materials.quantity, triune_job_request_materials_tbamims.particulars, triune_job_request_materials_tbamims.units, ";
			$selectField5 = $selectField5 . "triune_job_request_transaction_tbamims_materials.materialsAmount, triune_job_request_transaction_tbamims_materials.actualAmount";
			$materials = $this->_getRecordsData($dataSelect5 = array($selectField5),
			$tables = array('triune_job_request_transaction_tbamims_materials', 'triune_job_request_materials_tbamims'), 
			$fieldName = array('triune_job_request_transaction_tbamims_materials.requestNumber'), $where = array($fiedlValArr[0]), 
			$join = array('triune_job_request_transaction_tbamims_materials.materialsID = triune_job_request_materials_tbamims.ID'), $joinType = array('inner'), 
			$sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$data['materials'] = $materials;
			
			$this->load->library('Pdf');
			$this->load->view('TrinityReports/requestSet', $data);
			
		} elseif($type == 'requestInProgress') {
			
			$selectField1 = "triune_job_request_transaction_asrs.sy, triune_job_request_transaction_asrs.requestPurpose, triune_job_request_transaction_asrs.requestRemarks, ";
			$selectField1 = $selectField1 . "triune_job_request_transaction_asrs.requestStatus, triune_job_request_transaction_asrs.requestType, triune_job_request_transaction_asrs.departmentUnit, ";
			$selectField1 = $selectField1 . "triune_job_request_transaction_asrs.unitReviewer, triune_job_request_transaction_asrs.returnedFrom, triune_job_request_transaction_asrs.dateNeeded, ";
			$selectField1 = $selectField1 . "triune_job_request_transaction_asrs.dateCreated, triune_job_request_transaction_asrs.dateClosed, triune_job_request_transaction_asrs.userName, ";
			$selectField1 = $selectField1 . "triune_job_request_transaction_asrs.workstationID, triune_job_request_transaction_asrs.timeStamp, triune_job_request_transaction_asrs.updatedBy";
			
			$jobRequest = $this->_getRecordsData($dataSelect1 = array($selectField1),
			$tables = array('triune_job_request_transaction_asrs'), 
			$fieldName = array('triune_job_request_transaction_asrs.ID'), $where = array($fiedlValArr[0]), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, 
			$like = null, $whereSpecial = null, $groupBy = null );

			$data['jobRequest'] = $jobRequest;
		

			$selectField2 = "concat(triune_employee_data.lastName, ', ', triune_employee_data.firstName, ' ', triune_employee_data.middleName) as fullName, ";
			$selectField2 = $selectField2 . "triune_employee_data.currentDepartment";
			$requestor = $this->_getRecordsData($dataSelect2 = array($selectField2),
			$tables = array('triune_user', 'triune_employee_data'), 
			$fieldName = array('triune_user.userName'), $where = array($jobRequest[0]->userName), 
			$join = array('triune_user.userNumber = triune_employee_data.employeeNumber'), 
			$joinType = array('inner'), $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$data['requestor'] = $requestor;

			
			$selectField3 = "*";
			$instructions = $this->_getRecordsData($dataSelect3 = array($selectField3),
			$tables = array('triune_job_request_transaction_asrs_special_instructions'), 
			$fieldName = array('triune_job_request_transaction_asrs_special_instructions.requestNumber'), $where = array($fiedlValArr[0]), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$data['instructions'] = $instructions;

			
			$selectField4 = "triune_job_request_status.statusDescription, triune_job_request_transaction_asrs_status_remarks.updatedBy, triune_job_request_transaction_asrs_status_remarks.userName";
			$statusRemarks = $this->_getRecordsData($dataSelect4 = array($selectField4),
			$tables = array('triune_job_request_transaction_asrs_status_remarks', 'triune_job_request_status'), 
			$fieldName = array('triune_job_request_transaction_asrs_status_remarks.requestNumber'), $where = array($fiedlValArr[0]), 
			$join = array('triune_job_request_transaction_asrs_status_remarks.requestStatusRemarksID = triune_job_request_status.ID'), $joinType = array('inner'), 
			$sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$data['statusRemarks'] = $statusRemarks;
			

			$selectField5 = "*";
			$items = $this->_getRecordsData($dataSelect5 = array($selectField5),
			$tables = array('triune_job_request_transaction_asrs_items'), 
			$fieldName = array('triune_job_request_transaction_asrs_items.requestNumber'), $where = array($fiedlValArr[0]), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$data['items'] = $items;
			

			
			$this->load->library('Pdf');
			$this->load->view('TrinityReports/requestInProgress', $data);



			
		}
		
	}

   

}