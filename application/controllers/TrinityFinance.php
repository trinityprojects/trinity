<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityFinance extends MY_Controller {

	/**
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Finance Controller. Included 
	 * DATE CREATED: October 3, 2018
     * DATE UPDATED: October 3, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function curriculumSetupREGISTRAR() {
        //echo "HELLO WORLD";
        $this->load->view('REGISTRAR/curriculum-setup-list');
    }

	
}