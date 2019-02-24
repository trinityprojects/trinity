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

		
		if($reportFileName == 'employee-profile') {
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

		} else if($reportFileName == 'evaluation-summary'){
                  
			$results = $this->_getRecordsData($dataSelect1 = array('triune_faculty_profile.LName,triune_faculty_profile.FName,
			triune_faculty_profile.MName,triune_faculty_profile.int_courseGroup,'),
						$tables = array('triune_faculty_profile'), $fieldName = 
						array('FCode'), 
						$where = array($employeeNumber), $join = null, $joinType = null,
						$sortBy = null, $sortOrder = null, $limit = null,
						$fieldNameLike = null, $like = null,
						$whereSpecial = null, $groupBy = null);
			
					$data['rows'] = $results;
			
					
					$selectField = "triune_faculty_evaluation_answers.EvaId,triune_faculty_evaluation_answers.employeeNumber,triune_faculty_evaluation_answers.studentNumber,
					triune_faculty_evaluation_answers.EvaId,triune_faculty_evaluation_answers.EvaId1,
					triune_faculty_evaluation_answers.sem,triune_faculty_evaluation_answers.sy,triune_eval_sections.SectID,triune_eval_sections.SectDesc,
					triune_eval_sections.SectPct,triune_eval_sections.NoOfQuestions,triune_faculty_evaluation_answers.subjectCode,
					triune_faculty_evaluation_answers.sectionCode,avg(triune_faculty_evaluation_answers.question1) as A1,
					avg(triune_faculty_evaluation_answers.question2) as A2, avg(triune_faculty_evaluation_answers.question3) as A3,
					avg(triune_faculty_evaluation_answers.question4) as A4, avg(triune_faculty_evaluation_answers.question5) as A5,
					avg(triune_faculty_evaluation_answers.question6) as A6, avg(triune_faculty_evaluation_answers.question7) as A7,
					avg(triune_faculty_evaluation_answers.question8) as A8, avg(triune_faculty_evaluation_answers.question9) as A9,
					avg(triune_faculty_evaluation_answers.question10) as A10, avg(triune_faculty_evaluation_answers.question11) as A11,
					avg(triune_faculty_evaluation_answers.question12) as A12, avg(triune_faculty_evaluation_answers.question13) as A13,
					avg(triune_faculty_evaluation_answers.question14) as A14, avg(triune_faculty_evaluation_answers.question15) as A15,
					avg(triune_faculty_evaluation_answers.question16 ) as A16 ,avg(triune_faculty_evaluation_answers.question17 ) as A17 ,
					avg(triune_faculty_evaluation_answers.question18 ) as A18 ,avg(triune_faculty_evaluation_answers.question19 ) as A19 ,
					avg(triune_faculty_evaluation_answers.question20 ) as A20 ,avg(triune_faculty_evaluation_answers.question21 ) as A21 ,
					avg(triune_faculty_evaluation_answers.question22 ) as A22 ,avg(triune_faculty_evaluation_answers.question23 ) as A23 ,
					avg(triune_faculty_evaluation_answers.question24 ) as A24 ,avg(triune_faculty_evaluation_answers.question25 ) as A25 ,
					avg(triune_faculty_evaluation_answers.question26 ) as A26 ,avg(triune_faculty_evaluation_answers.question27 ) as A27 ,
					avg(triune_faculty_evaluation_answers.question28 ) as A28 ,avg(triune_faculty_evaluation_answers.question29 ) as A29 ,
					avg(triune_faculty_evaluation_answers.question30 ) as A30 ,avg(triune_faculty_evaluation_answers.question31 ) as A31 ,
					avg(triune_faculty_evaluation_answers.question32 ) as A32 ,avg(triune_faculty_evaluation_answers.question33 ) as A33 ,
					avg(triune_faculty_evaluation_answers.question34 ) as A34 ,avg(triune_faculty_evaluation_answers.question35 ) as A35 ,
					avg(triune_faculty_evaluation_answers.question36 ) as A36 ,avg(triune_faculty_evaluation_answers.question37 ) as A37 ,
					avg(triune_faculty_evaluation_answers.question38 ) as A38 ,avg(triune_faculty_evaluation_answers.question39 ) as A39 ,
					avg(triune_faculty_evaluation_answers.question40 ) as A40 ,avg(triune_faculty_evaluation_answers.question41 ) as A41 ,
					avg(triune_faculty_evaluation_answers.question42 ) as A42 ,avg(triune_faculty_evaluation_answers.question43 ) as A43 ,
					";
					$selectField = $selectField . "triune_eval_sections.EvalID,triune_eval_sections.EvalID1,triune_eval_sections.SectID,
					triune_eval_sections.SectDesc,triune_eval_sections.SectPct,triune_eval_sections.NoOfQuestions ";
					
					
					$studentEvalSections = $this->_getRecordsData($dataSelect2 = array($selectField),
						$tables = array('triune_faculty_evaluation_answers','triune_faculty_profile', 'triune_eval_sections'),
						$fieldName = array('triune_faculty_evaluation_answers.employeeNumber','triune_faculty_evaluation_answers.sy','triune_faculty_evaluation_answers.sem','triune_eval_sections.EvalID','triune_eval_sections.EvalID1'),
						$where = array($employeeNumber,$_SESSION['sy'],$_SESSION['sem'],1,7),
						$join = array('triune_faculty_profile.FCode = triune_faculty_evaluation_answers.employeeNumber', 'triune_eval_sections.EvalID = triune_faculty_evaluation_answers.EvaId'),
						$joinType = array('left', 'left'),
						$sortBy = array('triune_eval_sections.SectID'), $sortOrder = array('asc'), $limit = null,
						$fieldNameLike = null, $like = null,
						$whereSpecial = null, $groupBy = array('triune_faculty_evaluation_answers.EvaId','triune_faculty_evaluation_answers.EvaId1','triune_eval_sections.SectID'));
					$data['studentEvalSections'] = $studentEvalSections;	
	


					$selectField1 = "triune_eval_evafield.Evalid,triune_eval_evafield.EmpID,triune_eval_evafield.snumber,
					triune_eval_evafield.depId,triune_eval_evafield.Subid,triune_eval_evafield.EvaId,triune_eval_evafield.EvaId1,
					triune_eval_evafield.Semid,triune_eval_evafield.YearId,triune_eval_sections.SectID,triune_eval_sections.SectDesc,
					triune_eval_sections.SectPct,triune_eval_sections.NoOfQuestions,triune_eval_evafield.`subject`,
					triune_eval_evafield.section,avg(triune_eval_evafield.Ans1) as A1,
					avg(triune_eval_evafield.Ans2) as A2, avg(triune_eval_evafield.Ans3) as A3,
					avg(triune_eval_evafield.Ans4) as A4, avg(triune_eval_evafield.Ans5) as A5,
					avg(triune_eval_evafield.Ans6) as A6, avg(triune_eval_evafield.Ans7) as A7,
					avg(triune_eval_evafield.Ans8) as A8, avg(triune_eval_evafield.Ans9) as A9,
					avg(triune_eval_evafield.Ans10) as A10, avg(triune_eval_evafield.Ans11) as A11,
					avg(triune_eval_evafield.Ans12) as A12, avg(triune_eval_evafield.Ans13) as A13,
					avg(triune_eval_evafield.Ans14) as A14, avg(triune_eval_evafield.Ans15) as A15,
					avg(triune_eval_evafield.Ans16 ) as A16 ,avg(triune_eval_evafield.Ans17 ) as A17 ,
					avg(triune_eval_evafield.Ans18 ) as A18 ,avg(triune_eval_evafield.Ans19 ) as A19 ,
					avg(triune_eval_evafield.Ans20 ) as A20 ,avg(triune_eval_evafield.Ans21 ) as A21 ,
					avg(triune_eval_evafield.Ans22 ) as A22 ,avg(triune_eval_evafield.Ans23 ) as A23 ,
					avg(triune_eval_evafield.Ans24 ) as A24 ,avg(triune_eval_evafield.Ans25 ) as A25 ,
					avg(triune_eval_evafield.Ans26 ) as A26 ,avg(triune_eval_evafield.Ans27 ) as A27 ,
					avg(triune_eval_evafield.Ans28 ) as A28 ,avg(triune_eval_evafield.Ans29 ) as A29 ,
					avg(triune_eval_evafield.Ans30 ) as A30 ,avg(triune_eval_evafield.Ans31 ) as A31 ,
					avg(triune_eval_evafield.Ans32 ) as A32 ,avg(triune_eval_evafield.Ans33 ) as A33 ,
					avg(triune_eval_evafield.Ans34 ) as A34 ,avg(triune_eval_evafield.Ans35 ) as A35 ,
					avg(triune_eval_evafield.Ans36 ) as A36 ,avg(triune_eval_evafield.Ans37 ) as A37 ,
					avg(triune_eval_evafield.Ans38 ) as A38 ,avg(triune_eval_evafield.Ans39 ) as A39 ,
					avg(triune_eval_evafield.Ans40 ) as A40 ,avg(triune_eval_evafield.Ans41 ) as A41 ,
					avg(triune_eval_evafield.Ans42 ) as A42 ,avg(triune_eval_evafield.Ans43 ) as A43 ,
					avg(triune_eval_evafield.Ans44 ) as A44 ,avg(triune_eval_evafield.Ans45 ) as A45 ,
					avg(triune_eval_evafield.Ans46 ) as A46 ,avg(triune_eval_evafield.Ans47 ) as A47 ,
					avg(triune_eval_evafield.Ans48 ) as A48 ,avg(triune_eval_evafield.Ans49 ) as A49 ,
					avg(triune_eval_evafield.Ans50 ) as A50 ,
					";
					$selectField1 = $selectField1 . "triune_eval_sections.EvalID,triune_eval_sections.EvalID1,triune_eval_sections.SectID,
					triune_eval_sections.SectDesc,triune_eval_sections.SectPct,triune_eval_sections.NoOfQuestions ";


	

					$selfEvalSections = $this->_getRecordsData($dataSelect2 = array($selectField1),
						$tables = array('triune_eval_evafield','triune_faculty_profile', 'triune_eval_sections'),
						$fieldName = array('triune_eval_evafield.EmpID','triune_eval_evafield.YearId','triune_eval_evafield.Semid','triune_eval_sections.EvalID','triune_eval_sections.EvalID1'),
						$where = array($employeeNumber,$_SESSION['sy'],$_SESSION['sem'],2,2),
						$join = array('triune_faculty_profile.FCode = triune_eval_evafield.EmpID', 'triune_eval_sections.EvalID = triune_eval_evafield.EvaId'),
						$joinType = array('left', 'left'),
						$sortBy = array('triune_eval_sections.SectID'), $sortOrder = array('asc'), $limit = null,
						$fieldNameLike = null, $like = null,
						$whereSpecial = null, $groupBy = array('triune_eval_evafield.EvaId','triune_eval_evafield.EvaId1','triune_eval_sections.SectID'));
					$data['selfEvalSections'] = $selfEvalSections;	


					$dhEvalSections = $this->_getRecordsData($dataSelect2 = array($selectField1),
						$tables = array('triune_eval_evafield','triune_faculty_profile', 'triune_eval_sections'),
						$fieldName = array('triune_eval_evafield.EmpID','triune_eval_evafield.YearId','triune_eval_evafield.Semid','triune_eval_sections.EvalID','triune_eval_sections.EvalID1'),
						$where = array($employeeNumber,$_SESSION['sy'],$_SESSION['sem'],3,3),
						$join = array('triune_faculty_profile.FCode = triune_eval_evafield.EmpID', 'triune_eval_sections.EvalID = triune_eval_evafield.EvaId'),
						$joinType = array('left', 'left'),
						$sortBy = array('triune_eval_sections.SectID'), $sortOrder = array('asc'), $limit = null,
						$fieldNameLike = null, $like = null,
						$whereSpecial = null, $groupBy = array('triune_eval_evafield.EvaId','triune_eval_evafield.EvaId1','triune_eval_sections.SectID'));
					$data['dhEvalSections'] = $dhEvalSections;	

					
					$deanEvalSections = $this->_getRecordsData($dataSelect2 = array($selectField1),
						$tables = array('triune_eval_evafield','triune_faculty_profile', 'triune_eval_sections'),
						$fieldName = array('triune_eval_evafield.EmpID','triune_eval_evafield.YearId','triune_eval_evafield.Semid','triune_eval_sections.EvalID','triune_eval_sections.EvalID1'),
						$where = array($employeeNumber,$_SESSION['sy'],$_SESSION['sem'],4,4),
						$join = array('triune_faculty_profile.FCode = triune_eval_evafield.EmpID', 'triune_eval_sections.EvalID = triune_eval_evafield.EvaId'),
						$joinType = array('left', 'left'),
						$sortBy = array('triune_eval_sections.SectID'), $sortOrder = array('asc'), $limit = null,
						$fieldNameLike = null, $like = null,
						$whereSpecial = null, $groupBy = array('triune_eval_evafield.EvaId','triune_eval_evafield.EvaId1','triune_eval_sections.SectID'));
					$data['deanEvalSections'] = $deanEvalSections;	

				$data['LName'] = $results[0]->LName;
				$data['FName'] = $results[0]->FName;
				$data['MName'] = $results[0]->MName;

				
					$studentEvalItems = $this->_getRecordsData($dataStudItem = array('*'), 
						$tables = array('triune_eval_item'), $fieldName = array('EvalID', 'evaID1'), $where = array('1', '7'), $join = null, $joinType = null, 
						$sortBy = array('iteIndex'), $sortOrder = array('asc'), $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
					$data['studentEvalItems'] = $studentEvalItems;	
					
					$studentEvalType = $this->_getRecordsData($dataStudType= array('TypePct'), 
						$tables = array('triune_eval_types'), $fieldName = array('EvalID', 'EvalID1','TypeID'), $where = array('1', '1', '1'), $join = null, $joinType = null, 
						$sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
					$data['studentEvalType'] = $studentEvalType;	

					
					$selfEvalItems = $this->_getRecordsData($dataSelfItem = array('*'), 
						$tables = array('triune_eval_item'), $fieldName = array('EvalID', 'evaID1'), $where = array('2', '2'), $join = null, $joinType = null, 
						$sortBy = array('iteIndex'), $sortOrder = array('asc'), $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
					$data['selfEvalItems'] = $selfEvalItems;	

					$selfEvalType = $this->_getRecordsData($dataSelfType = array('TypePct'), 
						$tables = array('triune_eval_types'), $fieldName = array('EvalID', 'EvalID1','TypeID'), $where = array('4', '4','1'), $join = null, $joinType = null, 
						$sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
					$data['selfEvalType'] = $selfEvalType;	

									
					$dhEvalItems = $this->_getRecordsData($dataDhItem = array('*'), 
						$tables = array('triune_eval_item'), $fieldName = array('EvalID', 'evaID1'), $where = array('3', '3'), $join = null, $joinType = null, 
						$sortBy = array('iteIndex'), $sortOrder = array('asc'), $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
					$data['dhEvalItems'] = $dhEvalItems;	

					$dhEvalIType = $this->_getRecordsData($dataDhType = array('TypePct'), 
						$tables = array('triune_eval_types'), $fieldName = array('EvalID', 'EvalID1','TypeID'), $where = array('3', '3','1'), $join = null, $joinType = null, 
						$sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
					$data['dhEvalIType'] = $dhEvalIType;	

					$deanEvalItems = $this->_getRecordsData($dataDeanItem = array('*'), 
						$tables = array('triune_eval_item'), $fieldName = array('EvalID', 'evaID1'), $where = array('4', '4'), $join = null, $joinType = null, 
						$sortBy = array('iteIndex'), $sortOrder = array('asc'), $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
					$data['deanEvalItems'] = $deanEvalItems;	
					
					$deanEvalType = $this->_getRecordsData($dataDeanType = array('TypePct'), 
						$tables = array('triune_eval_types'), $fieldName = array('EvalID', 'EvalID1','TypeID'), $where = array('2', '2','1'), $join = null, $joinType = null, 
						$sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
					$data['deanEvalType'] = $deanEvalType;	
					
					$data['sy'] = $this->_getSchoolYearDesc($_SESSION['sy']);
					$data['sem'] = $this->_getSemesterDesc($_SESSION['sem']);

					$departmentDescription = $this->_getRecordsData($datadepartment = array('DESCRIPTION'),
						$tables = array('triune_faculty_profile','triune_course_category'),
						$fieldName = array('triune_faculty_profile.FCode'),
						$where = array($employeeNumber),
						$join = array('triune_course_category.GROUP_ID = triune_faculty_profile.int_courseGroup'),
						$joinType = array('left'),
						$sortBy = null, $sortOrder = array('asc'), $limit = null,
						$fieldNameLike = null, $like = null,
						$whereSpecial = null, $groupBy = null);
					$data['departmentDescription'] = $departmentDescription;

						
					$evaluationComments = $this->_getRecordsData($datacomment= array('*'),
						$tables = array('triune_faculty_evaluation_answers'),
						$fieldName = array('employeeNumber','sy','sem'),
						$where = array($employeeNumber, $_SESSION['sy'], $_SESSION['sem']),
						$join = null,
						$joinType = null,
						$sortBy =  array('comments'), $sortOrder = array('desc'), $limit = null,
						$fieldNameLike = null, $like = null,
						$whereSpecial = null, $groupBy = null);
					$data['evaluationComments'] = $evaluationComments;


					$data['departmentDescription'] = $departmentDescription[0]->DESCRIPTION;
					$data['studentEvalType'] = $studentEvalType[0]->TypePct;
					$data['selfEvalType'] = $selfEvalType[0]->TypePct;
					$data['dhEvalType'] = $dhEvalIType[0]->TypePct;
					$data['deanEvalType'] = $deanEvalType[0]->TypePct;
					$data['deanEvalType'] = $deanEvalType[0]->TypePct;
				
					$data['sy'] = $this->_getSchoolYearDesc($_SESSION['sy']);
					$data['sem'] = $this->_getSemesterDesc($_SESSION['sem']);


					$this->load->library('Pdf');		
					$this->load->view('THRIMS/' . $reportFileName, $data);
			
		}

	}
	


    public function showGenderTHRIMS() {
        //echo "HELLO WORLD";
        $this->load->view('THRIMS/references-gender');
    }

    public function showFacultyEvaluationTHRIMS() {
        //echo "HELLO WORLD";
        $this->load->view('THRIMS/faculty-evaluation-list');
    }
	

    public function showEvaluationRecordsTHRIMS() {
        //echo "HELLO WORLD";
        $this->load->view('THRIMS/reports-evaluation-records-setup-list');
    }
	
	
}