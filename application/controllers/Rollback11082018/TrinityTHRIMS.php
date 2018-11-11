<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityTHRIMS extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/triune/auth
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/triune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: THRIMS Controller. Included 
	 * DATE CREATED: August 16, 2018
     * DATE UPDATED: August 16, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function employeeProfileTHRIMS() {
        //echo "HELLO WORLD";
        $this->load->view('THRIMS/employee-profile-list');
    }


    public function showEmployeeProfileDetailsTHRIMS() {
        //echo "HELLO WORLD";
		$ID = $_POST["ID"];

		$results = $this->_getRecordsData($dataSelect1 = array('*'), 
			$tables = array('triune_employee_data'), $fieldName = array('ID'), $where = array($ID), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		$data['rows'] = $results;	

		$data['yearsInService'] = $this->_getYearsMonthsDays($results[0]->dateHired);
		$data['age'] = $this->_getYearsMonthsDays($results[0]->birthDate);
		$data['spouseAge'] = $this->_getYearsMonthsDays($results[0]->spouseBirthDay);
		$data['fatherAge'] = $this->_getYearsMonthsDays($results[0]->fatherBirthDay);
		$data['motherAge'] = $this->_getYearsMonthsDays($results[0]->motherBirthDay);
		
		
		$selectField = "triune_employee_job_title.jobTitleDescription, triune_employee_department.departmentDescription, ";
		$selectField = $selectField . "triune_employee_job_status.jobStatusDescription, triune_employee_job_status.statusCategory, triune_employee_position_class.positionClass, ";
		$selectField = $selectField . "triune_employment_career.startDate, triune_employment_career.expiryDate, triune_employment_career.employeeStatusID";

		$resultsCareer = $this->_getRecordsData($dataSelect2 = array($selectField), 
			$tables = array('triune_employment_career', 'triune_employee_job_title', 'triune_employee_department', 'triune_employee_job_status', 'triune_employee_position_class'), 
			$fieldName = array('employeeNumber'), $where = array($results[0]->employeeNumber), 
			$join = array('triune_employment_career.jobTitleID = triune_employee_job_title.jobTitleID', 'triune_employment_career.departmentID = triune_employee_department.departmentID', 'triune_employment_career.employeeStatusID = triune_employee_job_status.jobStatusID', 'triune_employment_career.positionClassID = triune_employee_position_class.positionClassID'), 
			$joinType = array('left', 'left', 'left', 'left'), 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		$data['rowsCareer'] = $resultsCareer;	


		
        $this->load->view('THRIMS/employee-profile-details', $data);
    }
	
	

    public function showEmployeeRecordsTHRIMS() {
        //echo "HELLO WORLD";
        $this->load->view('THRIMS/reports-employee-records-setup-list');
    }
	
    public function showReportsDetailsTHRIMS() {
		$reportFileName = $_POST["reportFileName"];
		$employeeNumber = $_POST["employeeNumber"];

		$results = $this->_getRecordsData($dataSelect1 = array('*'), 
			$tables = array('triune_employee_data'), $fieldName = array('employeeNumber'), $where = array($employeeNumber), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		$data['rows'] = $results;	

		$data['yearsInService'] = $this->_getYearsMonthsDays($results[0]->dateHired);
		$data['age'] = $this->_getYearsMonthsDays($results[0]->birthDate);
		$data['spouseAge'] = $this->_getYearsMonthsDays($results[0]->spouseBirthDay);
		$data['fatherAge'] = $this->_getYearsMonthsDays($results[0]->fatherBirthDay);
		$data['motherAge'] = $this->_getYearsMonthsDays($results[0]->motherBirthDay);
		
		
		$selectField = "triune_employee_job_title.jobTitleDescription, triune_employee_department.departmentDescription, ";
		$selectField = $selectField . "triune_employee_job_status.jobStatusDescription, triune_employee_job_status.statusCategory, triune_employee_position_class.positionClass, ";
		$selectField = $selectField . "triune_employment_career.startDate, triune_employment_career.expiryDate, triune_employment_career.employeeStatusID";

		$resultsCareer = $this->_getRecordsData($dataSelect2 = array($selectField), 
			$tables = array('triune_employment_career', 'triune_employee_job_title', 'triune_employee_department', 'triune_employee_job_status', 'triune_employee_position_class'), 
			$fieldName = array('employeeNumber'), $where = array($results[0]->employeeNumber), 
			$join = array('triune_employment_career.jobTitleID = triune_employee_job_title.jobTitleID', 'triune_employment_career.departmentID = triune_employee_department.departmentID', 'triune_employment_career.employeeStatusID = triune_employee_job_status.jobStatusID', 'triune_employment_career.positionClassID = triune_employee_position_class.positionClassID'), 
			$joinType = array('left', 'left', 'left', 'left'), 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		$data['rowsCareer'] = $resultsCareer;	

		$data['jobTitleDescription'] = $resultsCareer[0]->jobTitleDescription;
		$data['gender'] = $results[0]->gender;
		$data['ID'] = $results[0]->ID;
		$data['jobStatusDescription'] = $resultsCareer[0]->jobStatusDescription;		
		$data['departmentDescription'] = $resultsCareer[0]->departmentDescription;

		$data['lastName'] = $results[0]->lastName; 
		$data['firstName'] = $results[0]->firstName;
		$data['middleName'] = $results[0]->middleName;
		$data['positionClass'] = $resultsCareer[0]->positionClass;		
		$data['tuaEmailAddress'] = $results[0]->tuaEmailAddress;
		$data['civilStatus'] = $results[0]->civilStatus;
		$data['emailAddress'] = $results[0]->emailAddress;
		$data['dateHired'] = $results[0]->dateHired;
		$data['mobileNumber'] = $results[0]->mobileNumber;
		$data['telephoneNumber'] = $results[0]->telephoneNumber;
		
		$data['employeeNumber'] = $employeeNumber;
		$data['reportFileName'] = $reportFileName;
		
		$this->load->library('Pdf');		
        $this->load->view('THRIMS/' . $reportFileName, $data);

    }

    public function showGenderTHRIMS() {
        //echo "HELLO WORLD";
        $this->load->view('THRIMS/references-gender');
    }

	

}