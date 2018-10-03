<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityInfoTechQueueSys extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: InfoTech - Queueing System
	 * DATE CREATED: June 19, 2018
     * DATE UPDATED: June 20, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function queueSysCreateCustomerQueue() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$reset = isset($clean['reset']) ? intval($clean['reset']) : 0;
		$customerNumber = isset($clean['customerNumber']) ? intval($clean['customerNumber']) : 0;

		if($reset == '1') {
			$queueNumberStatusUpdate = array(
				'status' => '1',
			);
			$this->_updateRecords($tableName = 'triune_queue_number', 		
			$fieldName = array('customerNumber'), 
			$where = array($customerNumber), $queueNumberStatusUpdate);	
		}
        $this->load->view('QUEUESYS/customer-queue-form');
    }

    public function queueSysCreatedQueueNumber() {
		//echo "HELLO WORLD";
		$data['ID'] = $_POST['ID'];
		$data['customerNumber'] = $_POST['customerNumber'];

        $this->load->view('QUEUESYS/created-queue-number', $data);
    }

    public function queueSysServerOperator() {
		//echo "HELLO WORLD";
		//$data['ID'] = $_POST['ID'];
		//$data['customerNumber'] = $_POST['customerNumber'];
		$records = $this->_getRecordsData($selectFields = array('ID', 'customerNumber'), 
		$tables = array('triune_queue_number'), 
		$fieldName = array('status'), 
		$where = array('0'), 
		$join = null, $joinType = null, 
		$sortBy = array('ID'), $sortOrder = array('asc'), 
		$limit = array(10, 0), 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
		$groupBy = null );

		$data['queueNumbers'] = $records;

        $this->load->view('QUEUESYS/queue-server-operator', $data);
    }

	public function displayCurrentQueueQueueSys() {
		$data['ID'] = $_POST['ID'];
		$data['customerNumber'] = $_POST['customerNumber'];
		$this->load->view('QUEUESYS/current-queue', $data);
		
	}

		

    public function queueSysViewQueueQueueSys() {
		$this->load->view('QUEUESYS/queue-server-view');

    }

	
    public function queueSysNotifyOperator() {
		//echo "HELLO WORLD";
        $this->load->view('QUEUESYS/queue-notify-operator');
    }
	
    public function queueSysONotifyOperatorQueueSys() {
		$this->load->view('QUEUESYS/queue-operator_notification-view');

    }	
	
}