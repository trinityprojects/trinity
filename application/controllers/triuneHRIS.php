<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class triuneHRIS extends MY_Controller {

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

    public function HRISView() {
        $this->load->view('hris/sidebar');
    }
    
}