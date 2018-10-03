<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityK12Records extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: K12Records Controller. Included 
	 * DATE CREATED: August 14, 2018
     * DATE UPDATED: August 14, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function sectioningK12Records() {
        //echo "HELLO WORLD";
        $this->load->view('K12Records/sectioning-list');
    }

    public function showStudentsListSHK12Records() {
		$data['courseCode'] = $_POST["courseCode"];
		
        $this->load->view('K12Records/sectioning-list-details', $data);
    }

    public function showStudentsListJHK12Records() {
		$data['yearLevel'] = $_POST["yearLevel"];
		
        $this->load->view('K12Records/sectioning-list-jh-details', $data);
    }

	
}