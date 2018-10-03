<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityFileBuilding extends MY_Controller {

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
	 * DATE CREATED: June 05, 2018
     * DATE UPDATED: June 05, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation'); 

    }//function __construct()



	public function uploadFileTBAMIMS() {
		$ID = $_POST["ID"];
		$userName = $this->_getUserName(1);
		$insertData = null;
		$workstationID = $this->_getIPAddress();
		$timeStamp = $this->_getTimeStamp();
		sleep(3);
		if($_FILES["files"]["name"] != '') {
			$output = '';
			$config["upload_path"] = './assets/uploads/tbamims/';
	  		$config["allowed_types"] = 'gif|jpg|png|pdf|jpeg';
	  		$this->load->library('upload', $config);
	  		$this->upload->initialize($config);
			
	
			for($count = 0; $count<count($_FILES["files"]["name"]); $count++) {
				$_FILES["file"]["name"] = $ID . "-" . $_FILES["files"]["name"][$count];
				$_FILES["file"]["type"] = $_FILES["files"]["type"][$count];
				$_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$count];
				$_FILES["file"]["error"] = $_FILES["files"]["error"][$count];
				$_FILES["file"]["size"] = $_FILES["files"]["size"][$count];
		
				if($this->upload->do_upload('file')) {
					$data = $this->upload->data();
					$output .= '
					<div class="col-md-3">
					<img src="'.base_url().'assets/uploads/tbamims/'.$data["file_name"].'" class="img-responsive img-thumbnail" />
					</div>
					';
				}
				$insertData = array(
					'requestNumber' => $ID,
					'attachments' => $_FILES["file"]["name"] ,
					'fileType' => $_FILES["file"]["type"] ,
					'userName' => $userName,
					'workstationID' => $workstationID,
					'timeStamp' => $timeStamp,
				);				 
				$this->_insertRecords($tableName = 'triune_job_request_transaction_tbamims_attachments', $insertData);        			 
					

			
			
			}
			echo $output;   
		}
	}
   

}