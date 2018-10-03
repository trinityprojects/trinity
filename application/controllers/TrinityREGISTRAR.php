<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityREGISTRAR extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: REGISTRAR Controller. Included 
	 * DATE CREATED: August 18, 2018
     * DATE UPDATED: August 18, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function curriculumSetupREGISTRAR() {
        //echo "HELLO WORLD";
        $this->load->view('REGISTRAR/curriculum-setup-list');
    }

    public function showCurriculumDetailsREGISTRAR() {
       $data['courseCode'] = $_POST['courseCode'];
       $data['sy'] = $_POST['sy'];
	   
       $this->load->view('REGISTRAR/curriculum-details', $data);
    }

    public function studentListREGISTRAR() {
        //echo "HELLO WORLD";
        $this->load->view('REGISTRAR/student-profile-list');
    }	
	
}