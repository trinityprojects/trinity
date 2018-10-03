<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityMain extends MY_Controller {

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
	 * DATE CREATED: June 03, 2018
     * DATE UPDATED: June 03, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()


	public function mainView() {
		header("Access-Control-Allow-Origin: *");
		$data['title'] = "MAIN";
		$userName = $_SESSION['userName'];
		$data["category"] = $this->_getUserPrivilegesCategory($userName, '-CAT');
		$data["group"] = $this->_getUserPrivileges($userName, '-GRP');
		$data["categoryset"] = $this->_getUserPrivilegesCategorySet($userName, '-CATSET');
		$data["groupset"] = $this->_getUserPrivileges($userName, '-GRPSET');

		$this->load->view('main/header', $data);
        $this->load->view('main/detail-area', $data);
		$this->load->view('useraccount/footer', $data);
	}

    public function sideMenu() {
		ob_start();
        ob_end_clean();
        $data = array();
        $userName = $_SESSION['userName'];
        $groupSystemID = $this->input->get("groupSystemID");
        $flag = $this->input->get("flag");
        $group = explode("/",$groupSystemID);
        
		$data['system'] = null;
		$data['module'] =  null;
		$data['menu'] = null;
		
		if($flag == '0') {
			$data['system'] = $this->_getUserPrivilegesDetails($userName, '-SYS', $group[0]);
			$data['module'] = $this->_getUserPrivilegesDetails($userName, '-MDL', $group[0]);
			$data['menu'] = $this->_getUserPrivilegesDetails($userName, '-MNU', $group[0]);
		} else {
			$data['system'] = $this->_getUserPrivilegesDetails($userName, '-SYSSET', $group[0]);
			$data['module'] = $this->_getUserPrivilegesDetails($userName, '-MDLSET', $group[0]);
			$data['menu'] = $this->_getUserPrivilegesDetails($userName, '-MNUSET', $group[0]);
		}
		
		$data['currentDate'] = $this->_getCurrentDate();
		
        $this->load->view('main/side-menu', $data);

    }

	public function modalForm() {
		
		$data['sys'] = $this->_getRecordsData($selectData = array('*'), $tables = array('triune_sy_list'), 
			$fieldName = null, $where = null, 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

		$data['sems'] = $this->_getRecordsData($selectData = array('*'), $tables = array('triune_sem_list'), 
			$fieldName = null, $where = null, 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

			
        $this->load->view('main/modal-form', $data);
	}
	

	public function setSessionTerm() {
		$post = $this->input->post();  
		$clean = $this->security->xss_clean($post);
		
		$sY = isset($clean['sY']) ? $clean['sY'] : '';
		$sem = isset($clean['sem']) ? $clean['sem'] : '';
		$this->session->set_userdata('sy', $sY);
		$this->session->set_userdata('sem', $sem);

		$returnValue = array();
		$returnValue['success'] = 1;
		echo json_encode($returnValue);

	}
}