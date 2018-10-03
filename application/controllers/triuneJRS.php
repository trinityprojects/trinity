<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class triuneJRS extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: JRS Controller.  
	 * DATE CREATED: April 21, 2018
     * DATE UPDATED: May 14, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()


    public function BAMCreateRequest() {
        $this->load->view('bamjrs/create');
    }

    public function BAMCreateRequestConfirmation() {
		$data['locationCode'] = $_POST["locationCode"];
		$data['floor'] = $_POST["floor"];
		$data['roomNumber'] = $_POST["roomNumber"];
		$data['projectTitle'] = $_POST["projectTitle"];
		$data['scopeOfWorks'] = $_POST["scopeOfWorks"];
		$data['projectJustification'] = $_POST["projectJustification"];
		$data['dateNeeded'] = $_POST["dateNeeded"];


        $this->load->view('bamjrs/createConfirmation', $data);
    }

    public function BAMCreatedRequest() {
		$data['ID'] = $_POST["ID"];
        $this->load->view('bamjrs/createdRequest', $data);
    }

	public function BAMMyRequestList() {
        $this->load->view('bamjrs/listMyRequest');
	}

	public function BAMNewRequestList() {
		$data['requestStatus'] = 'N';
        $this->load->view('bamjrs/listRequest', $data);
	}


	public function BAMNewRequestVerification() {

		$data['ID'] = $_POST["ID"];

		$details = $this->_getTransactionDetails($data['ID'], $from = 'triune_job_request_transaction_bam');

		$data['locationCode'] = $details[0]->locationCode;
		$data['floor'] = $details[0]->floor;
		$data['roomNumber'] = $details[0]->roomNumber;
		$data['projectTitle'] = $details[0]->projectTitle;
		$data['scopeOfWorks'] = $details[0]->scopeOfWorks;
		$data['projectJustification'] = $details[0]->projectJustification;
		$data['dateNeeded'] = $details[0]->dateNeeded;
		$data['dateCreated'] = $details[0]->dateCreated;
		$data['requestStatus'] = $details[0]->requestStatus;

		$results1 = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_bam_attachments'), 
		$fieldName = array('requestNumber'), $where = array($data['ID']), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );
		
		$data['attachments'] = $results1;
		$data['requestStatusDescription'] = $this->_getRequestStatusDescription($data['requestStatus'], 'BAM');


		$results2 = $this->_getRecordsData($rec = array('triune_employees.*'), 
		$tables = array('triune_user', 'triune_employees'), 
		$fieldName = array('triune_user.userName'), $where = array($details[0]->userName), 
		$join = array('triune_user.userNumber = triune_employees.EmployeeNumber'), $joinType = array('left'), $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );

		$data['userName'] = $details[0]->userName;
		$data['fullName'] = $results2[0]->EmployeeLName . ", " . $results2[0]->EmployeeFName . " " . $results2[0]->EmployeeMName;


		$details1 = $this->_getRecordsData($rec = array('*'), 
		$tables = array('triune_job_request_transaction_bam_status_history'), 
		$fieldName = array('requestNumber'), $where = array($data['ID']), 
		$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
		$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );


		$data['specialInstructions'] = null;
		$data['dateClosed'] = null;
		
		foreach($details1 as $row) {
			if($row->requestStatus == 'R' || $row->requestStatus == 'X' ) {
				$data['specialInstructions'] = $row->specialInstructions;
			}
			if($row->requestStatus == 'X') {
				$createDate = new DateTime($row->timeStamp);
				$dateClosed = $createDate->format('Y-m-d');
				$data['dateClosed'] = $dateClosed;
			}
		}


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

		if($data['requestStatus'] == 'R' || $data['requestStatus'] == 'X') {
			$this->load->view('bamjrs/requestStatusDetails', $data);
		} else {
			$this->load->view('bamjrs/requestNewVerification', $data);
		}


	}

}