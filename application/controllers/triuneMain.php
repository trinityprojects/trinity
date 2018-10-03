<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class triuneMain extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Main Controller. Included 
	 * DATE CREATED: April 19, 2018
     * DATE UPDATED: April 19, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()


    public function jobRequest() {
		ob_start();
		ob_end_clean();
        $this->load->view('main/menu');
    }

	public function viewPDF() {
		$this->load->library('Pdf');
		$this->load->view('viewPDF');		
	}

	
}