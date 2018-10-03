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
        $this->load->view('ICTJRS/request-created-details', $data);
    }

}