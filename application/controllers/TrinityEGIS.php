<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityEGIS extends MY_Controller {

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
	 * DATE CREATED: August 04, 2018
     * DATE UPDATED: August 04, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
    }//function __construct()

    public function officerSetupEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/officer-setup');
    }

    public function facultyAssignmentEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/faculty-assignment');
    }

    public function transmutationTableEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/tansmutation-table');
    }
	
    public function scoreSheetEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/score-sheet-list');
    }

	
    public function showScoreScheetDetailsEGIS() {
		$data['sectionCode'] = $_POST["sectionCode"];
		$data['subjectCode'] = $_POST["subjectCode"];
		$data['subjectDescription'] = $_POST["subjectDescription"];
		
        $this->load->view('EGIS/score-sheet-details', $data);
    }	
	
    public function adviserAssignmentEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/adviser-assignment');
    }

    public function gradeComponentEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/grade-component');
    }

    public function subjectDepartmentEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/subject-department');
    }	
	
	
    public function gradeDescriptorEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/grade-descriptor');
    }
	
    public function scoreSheetJHEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/score-sheet-jh-list');
    }

    public function scoreSheetSHEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/score-sheet-sh-list');
    }

    public function showScoreScheetSHDetailsEGIS() {
		$data['sectionCode'] = $_POST["sectionCode"];
		$data['subjectCode'] = $_POST["subjectCode"];
		$data['subjectDescription'] = $_POST["subjectDescription"];
		
        $this->load->view('EGIS/score-sheet-sh-details', $data);
    }	

    public function showSubjectGradesSummaryEGIS() {
		$data['sectionCode'] = $_POST["sectionCode"];
		$data['subjectCode'] = $_POST["subjectCode"];
		$data['subjectDescription'] = $_POST["subjectDescription"];
		$data['sectionCodeNS'] = $_POST["sectionCodeNS"];
		$data['subjectCodeNS'] = $_POST["subjectCodeNS"];

		$sectionCode = $data['sectionCode']; 
		$subjectCode = $data['subjectCode'];

		//$sectionCode = '1001 5-HUMILITY'; 
		//$subjectCode = 'ARTED5E';

		$gradingPeriod = $_SESSION['gP'];
		
		$rC = $this->_getRecordsData($dataSelect = array('*'), 
			$tables = array('triune_subject_elementary'), 
			$fieldName = array('subjectCode'), $where = array($subjectCode), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		if(empty($rC)) {
			$rC = $this->_getRecordsData($dataSelect1 = array('*'), 
				$tables = array('triune_subject_junior_high'), 
				$fieldName = array('subjectCode'), $where = array($subjectCode), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				
				if(empty($rC)) {
					$rC = $this->_getRecordsData($dataSelect2 = array('*'), 
						$tables = array('triune_subject_senior_high'), 
						$fieldName = array('subjectCode'), $where = array($subjectCode), 
						$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				}
				
		}
		

		
		$reportCategory = $rC[0]->reportCategory;
		//$reportCategory = 1;
		if($reportCategory == 1) {
				$results = null;
				
				if($gradingPeriod == '1') {
					$selectFields = "triune_grades_score_sheet_1.*, ";
					$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', SUBSTR(triune_students_k12.middleName, 1, 1), '.') as fullName";
					$results = $this->_getRecordsData($dataSelect = array($selectFields), 
						$tables = array('triune_grades_score_sheet_1', 'triune_students_k12'), 
						$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
						$join = array('triune_grades_score_sheet_1.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
						$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
				} elseif($gradingPeriod == '2') {
					$selectFields = "triune_grades_score_sheet_2.*, ";
					$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', SUBSTR(triune_students_k12.middleName, 1, 1), '.') as fullName";
					$results = $this->_getRecordsData($dataSelect = array($selectFields), 
						$tables = array('triune_grades_score_sheet_2', 'triune_students_k12'), 
						$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
						$join = array('triune_grades_score_sheet_2.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
						$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
					
				}
					
					$data['scoreList'] = (array) $results;
					$wwColumnCtr = 0;
					$ptColumnCtr = 0;			
					$qaColumnCtr = 0;			
					
					$maxScoreCounter = (array) $results[0];
					$data['maxScoreRow'] = $maxScoreCounter;
					$maxScoreCount = count($maxScoreCounter); 
					for($w = 1; $w < 16; $w++) {
						if($maxScoreCounter['WW'.$w] > 0) {
							$wwColumnCtr++;
						}				
					}
					
					for($p = 1; $p < 11; $p++) {
						if($maxScoreCounter['PT'.$p] > 0) {
							$ptColumnCtr++;
						}				
					}

					for($q = 1; $q < 2; $q++) {
						if($maxScoreCounter['QA'.$q] > 0) {
							$qaColumnCtr++;
						}				
					}
					
					
					$data['wwColumnCount'] = $wwColumnCtr + 3;
					$data['ptColumnCount'] = $ptColumnCtr + 3;
					$data['qaColumnCount'] = $qaColumnCtr + 2;

					$titlesData = null;

					if($gradingPeriod == '1') {
						$titlesFields = "triune_grades_score_sheet_1_title.*";
						$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
							$tables = array('triune_grades_score_sheet_1_title'), 
							$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
							$join = null, $joinType = null, 
							$sortBy = null, $sortOrder = null, $limit = null, 
							$fieldNameLike = null, $like = null, 
							$whereSpecial = null, $groupBy = null );
					} elseif($gradingPeriod == '2') {
						$titlesFields = "triune_grades_score_sheet_2_title.*";
						$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
							$tables = array('triune_grades_score_sheet_2_title'), 
							$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
							$join = null, $joinType = null, 
							$sortBy = null, $sortOrder = null, $limit = null, 
							$fieldNameLike = null, $like = null, 
							$whereSpecial = null, $groupBy = null );
						
					}
				$data['titles'] = (array) $titlesData[0];
				
				//echo $data['scoreList'][0]->studentNumber;

				//echo $data['titles']['titleWW1'];
				$data['hoy'] = $data['titles']['titleWW1'];
				$selectSP = "triune_grading_components.levelCode, triune_grading_components.departmentCode, triune_grading_components.gradingComponentCode, ";
				$selectSP = $selectSP . "triune_grading_components.componentPercentage, triune_grading_components.sy";

				$courseCode = substr($sectionCode, 0, 4);
				$scorePercentage = null;
				
				if($courseCode == '1001') {
					$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
						$tables = array('triune_subject_elementary', 'triune_grading_components'), 
						$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
						$join = array('triune_subject_elementary.departmentCode = triune_grading_components.departmentCode'), $joinType = array('inner'), 
						$sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
				} elseif($courseCode == '1002') {
					$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
						$tables = array('triune_subject_junior_high', 'triune_grading_components'), 
						$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
						$join = array('triune_subject_junior_high.departmentCode = triune_grading_components.departmentCode'), $joinType = array('inner'), 
						$sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
				} elseif($courseCode == '1005') {

					$selectSP = "triune_grading_components_sh.sy, triune_grading_components_sh.levelCode, triune_grading_components_sh.subjectComponentCode, ";
					$selectSP = $selectSP . "triune_grading_components_sh.gradingComponentCode, triune_grading_components_sh.componentPercentage";

					$scorePercentage = $this->_getRecordsData($dataSelect = array($selectSP), 
							$tables = array('triune_subject_senior_high', 'triune_grading_components_sh'), 
							$fieldName = array('sy', 'subjectCode' ), $where = array($_SESSION['sy'], $subjectCode), 
							$join = array('triune_subject_senior_high.subjectComponentCode = triune_grading_components_sh.subjectComponentCode'), $joinType = array('inner'), 
							$sortBy = null, $sortOrder = null, $limit = null, 
							$fieldNameLike = null, $like = null, 
							$whereSpecial = null, $groupBy = null );
				}

						
					
				$wwPct = 0;
				$ptPct = 0;
				$qaPct = 0;

				foreach($scorePercentage as $row) {
					if($row->gradingComponentCode == 'WW') {
						$wwPct = $row->componentPercentage;
					} else if($row->gradingComponentCode == 'PT') {
						$ptPct = $row->componentPercentage;
					} else if($row->gradingComponentCode == 'QA') {
						$qaPct = $row->componentPercentage;
					}
				}
				$data['wwPct'] = $wwPct;
				$data['ptPct'] = $ptPct;
				$data['qaPct'] = $qaPct;


				$transmutation = $this->_getRecordsData($dataSelect = array('*'), 
					$tables = array('triune_transmutation_k12'), 
					$fieldName = null, $where = null, 
					$join = null, $joinType = null, 
					$sortBy = array('transmutedScore'), $sortOrder = array('desc'), $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
				
				$data['transmutationTable'] = $transmutation;
				
				$this->load->library('Pdf');
				$this->load->view('EGIS/subject-grades-summary', $data);
		} else {
				$results = null;
				if($gradingPeriod == '1') {
					$selectFields = "triune_grades_score_sheet_1.*, ";
					$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', SUBSTR(triune_students_k12.middleName, 1, 1), '.') as fullName";
					
					$results = $this->_getRecordsData($dataSelect = array($selectFields), 
						$tables = array('triune_grades_score_sheet_1', 'triune_students_k12'), 
						$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
						$join = array('triune_grades_score_sheet_1.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
						$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
				} elseif($gradingPeriod == '2') {
					$selectFields = "triune_grades_score_sheet_2.*, ";
					$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', SUBSTR(triune_students_k12.middleName, 1, 1), '.') as fullName";
					
					$results = $this->_getRecordsData($dataSelect = array($selectFields), 
						$tables = array('triune_grades_score_sheet_2', 'triune_students_k12'), 
						$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
						$join = array('triune_grades_score_sheet_2.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
						$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
				}
					$data['scoreList'] = (array) $results;

					$maxScoreCounter = (array) $results[0];
					$data['maxScoreRow'] = $maxScoreCounter;
				
					$titlesData = null;
					if($gradingPeriod == '1') {
						$titlesFields = "triune_grades_score_sheet_1_title.*";
						$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
							$tables = array('triune_grades_score_sheet_1_title'), 
							$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
							$join = null, $joinType = null, 
							$sortBy = null, $sortOrder = null, $limit = null, 
							$fieldNameLike = null, $like = null, 
							$whereSpecial = null, $groupBy = null );
					} elseif($gradingPeriod == '2') {
						$titlesFields = "triune_grades_score_sheet_2_title.*";
						$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
							$tables = array('triune_grades_score_sheet_2_title'), 
							$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
							$join = null, $joinType = null, 
							$sortBy = null, $sortOrder = null, $limit = null, 
							$fieldNameLike = null, $like = null, 
							$whereSpecial = null, $groupBy = null );
					}
				$data['titles'] = (array) $titlesData[0];
					
				$this->load->library('Pdf');
				$this->load->view('EGIS/subject-grades-summary-2', $data);
		}
    }	


    public function attendanceEGIS() {
		
        $this->load->view('EGIS/attendance-sheet-list');
    }	

    public function schoolDaysEGIS() {
		
        $this->load->view('EGIS/school-days-list');
    }	
	
    public function traitsEGIS() {
		
        $this->load->view('EGIS/traits-sheet-list');
    }	

    public function gradesRequestEGIS() {
		
        $this->load->view('EGIS/student-subject-list');
    }	


	
    public function classCardEGIS() {
        //echo "HELLO WORLD";
        $this->load->view('EGIS/classcard-setup');
    }	
	
	
    public function showClassCardDetailsEGIS() {
		$sectionCode = $_POST["sectionCode"];
		$studentNumber = $_POST["studentNumber"];
		$sectionCodeNS = $_POST["sectionCodeNS"];
		$userName = $this->_getUserName(1);

		//$sectionCode = '1001 6-DILIGENCE';
		//$studentNumber = '13-100001';
		//$sectionCodeNS = '10016-DILIGENCE';
		$gradingPeriod = $_SESSION['gP'];
		
		$data['sectionCode'] = $sectionCode;
		$data['studentNumber'] = $studentNumber;
		$data['sectionCodeNS'] = $sectionCodeNS;
		
		$results = $this->_getRecordsData($dataSelect1 = array('*'), 
			$tables = array('triune_students_k12'), $fieldName = array('studentNumber'), $where = array($studentNumber), $join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		
		$data['lastName'] = $results[0]->lastName;
		$data['firstName'] = $results[0]->firstName;
		$data['middleName'] = $results[0]->middleName;
		$data['gender'] = $results[0]->gender;
		$data['sYear'] = $_SESSION['sy'];
		$age = $this->_getYearsMonthsDays($results[0]->birthDate);
		$data['age'] = $age->y;
		$data['yearLevel'] = $results[0]->yearLevel;
		

		$courseCode = substr($sectionCode, 0, 4);
		$selectField1 = null;
		$selectField2 = null;
		
		$resultsGrades = null;
		if($courseCode == '1002') {

			$selectField1 = "triune_subject_junior_high.subjectDescription, triune_subject_junior_high.weight, triune_subject_junior_high.subjectCode, ";
			$selectField1 = $selectField1 . "triune_grades_score_sheet_1_summary.initialGrade, triune_grades_score_sheet_1_summary.transmutedGrade, ";
			$selectField1 = $selectField1 . "triune_subject_junior_high.displaySequence";
			$resultsGrades1 = $this->_getRecordsData($dataSelect2 = array($selectField1), 
				$tables = array('triune_grades_score_sheet_1_summary', 'triune_subject_junior_high'), 
				$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $studentNumber), 
				$join = array('triune_subject_junior_high ON triune_grades_score_sheet_1_summary.subjectCode = triune_subject_junior_high.subjectCode'), 
				$joinType = array('inner'), $sortBy = array('triune_subject_junior_high.displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			$selectField2 = "triune_subject_junior_high.subjectDescription, triune_subject_junior_high.weight, triune_subject_junior_high.subjectCode, ";
			$selectField2 = $selectField2 . "triune_grades_score_sheet_2_summary.initialGrade, triune_grades_score_sheet_2_summary.transmutedGrade, ";
			$selectField2 = $selectField2 . "triune_subject_junior_high.displaySequence";
			$resultsGrades2 = $this->_getRecordsData($dataSelect2 = array($selectField2), 
				$tables = array('triune_grades_score_sheet_2_summary', 'triune_subject_junior_high'), 
				$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $studentNumber), 
				$join = array('triune_subject_junior_high ON triune_grades_score_sheet_2_summary.subjectCode = triune_subject_junior_high.subjectCode'), 
				$joinType = array('inner'), $sortBy = array('triune_subject_junior_high.displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

				
				
				
				
		} else if($courseCode == '1001') {

			$selectField1 = "triune_subject_elementary.subjectDescription, triune_subject_elementary.weight, triune_subject_elementary.subjectCode, ";
			$selectField1 = $selectField1 . "triune_grades_score_sheet_1_summary.initialGrade, triune_grades_score_sheet_1_summary.transmutedGrade, ";
			$selectField1 = $selectField1 . "triune_subject_elementary.displaySequence";
			$resultsGrades1 = $this->_getRecordsData($dataSelect2 = array($selectField1), 
				$tables = array('triune_grades_score_sheet_1_summary', 'triune_subject_elementary'), 
				$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $studentNumber), 
				$join = array('triune_subject_elementary ON triune_grades_score_sheet_1_summary.subjectCode = triune_subject_elementary.subjectCode'), 
				$joinType = array('inner'),  $sortBy = array('triune_subject_elementary.displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


			$selectField2 = "triune_subject_elementary.subjectDescription, triune_subject_elementary.weight, triune_subject_elementary.subjectCode, ";
			$selectField2 = $selectField2 . "triune_grades_score_sheet_2_summary.initialGrade, triune_grades_score_sheet_2_summary.transmutedGrade, ";
			$selectField2 = $selectField2 . "triune_subject_elementary.displaySequence";
			$resultsGrades2 = $this->_getRecordsData($dataSelect2 = array($selectField2), 
				$tables = array('triune_grades_score_sheet_2_summary', 'triune_subject_elementary'), 
				$fieldName = array('sy','studentNumber'), $where = array($_SESSION['sy'], $studentNumber), 
				$join = array('triune_subject_elementary ON triune_grades_score_sheet_2_summary.subjectCode = triune_subject_elementary.subjectCode'), 
				$joinType = array('inner'),  $sortBy = array('triune_subject_elementary.displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		} else if($courseCode == '1005') {

			$selectField1 = "triune_subject_senior_high.subjectDescription, triune_subject_senior_high.weight, triune_subject_senior_high.subjectCode, ";
			$selectField1 = $selectField1 . "triune_grades_score_sheet_1_summary.initialGrade, triune_grades_score_sheet_1_summary.transmutedGrade, ";
			$selectField1 = $selectField1 . "triune_subject_senior_high.displaySequence";
			$resultsGrades1 = $this->_getRecordsData($dataSelect2 = array($selectField1), 
				$tables = array('triune_grades_score_sheet_1_summary', 'triune_subject_senior_high'), 
				$fieldName = array('sy', 'studentNumber'), $where = array($_SESSION['sy'], $studentNumber), 
				$join = array('triune_subject_senior_high ON triune_grades_score_sheet_1_summary.subjectCode = triune_subject_senior_high.subjectCode'), 
				$joinType = array('inner'),  $sortBy = array('triune_subject_senior_high.displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


			$selectField2 = "triune_subject_senior_high.subjectDescription, triune_subject_senior_high.weight, triune_subject_senior_high.subjectCode, ";
			$selectField2 = $selectField2 . "triune_grades_score_sheet_2_summary.initialGrade, triune_grades_score_sheet_2_summary.transmutedGrade, ";
			$selectField2 = $selectField2 . "triune_subject_senior_high.displaySequence";
			$resultsGrades2 = $this->_getRecordsData($dataSelect2 = array($selectField2), 
				$tables = array('triune_grades_score_sheet_2_summary', 'triune_subject_senior_high'), 
				$fieldName = array('sy','studentNumber'), $where = array($_SESSION['sy'], $studentNumber), 
				$join = array('triune_subject_senior_high ON triune_grades_score_sheet_2_summary.subjectCode = triune_subject_senior_high.subjectCode'), 
				$joinType = array('inner'),  $sortBy = array('triune_subject_senior_high.displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		}


		$lE = $this->_getRecordsData($dataSelect2 = array('*'), 
			$tables = array('triune_grading_descriptor'), $fieldName = null, $where = null, $join = null, $joinType = null,  
			$sortBy = array('higherScale'), $sortOrder = array('desc'), 
			$limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
		$data['lE'] = $lE;


		$gD = $this->_getRecordsData($dataSelect2 = array('*'), 
			$tables = array('triune_grading_descriptor_traits'), $fieldName = null, $where = null, $join = null, $joinType = null,  
			$sortBy = array('letterEquivalent'), $sortOrder = array('asc'), 
			$limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
		$data['gD'] = $gD;

		
		$schoolDays = $this->_getRecordsData($dataSelect2 = array('*'), 
			$tables = array('triune_grades_school_days'), $fieldName = null, $where = null, $join = null, $joinType = null,  
			$sortBy = null, $sortOrder = null, 	$limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
		$data['schoolDays'] = $schoolDays;
		

		$presentDays = $this->_getRecordsData($dataSelect2 = array('*'), 
			$tables = array('triune_grades_score_sheet_1_attendance'), 
			$fieldName = array('studentNumber', 'sectionCode'), $where = array($studentNumber, $sectionCode), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 	$limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );
		
		$data['presentDays'] = $presentDays;



		$traitsHeader = $this->_getRecordsData($dataSelect2 = array('*'), 
			$tables = array('triune_grades_traits_header'), 
			$fieldName = array('sy'), $where = array($_SESSION['sy']), 
			$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 	$limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, 
			$groupBy = null );
		
		$traits1 = $this->_getRecordsData($dataSelect3 = array('*'), 
			$tables = array('triune_grades_score_sheet_1_traits'), $fieldName = array('sy', 'studentNumber', 'sectionCode'), 
			$where = array($_SESSION['sy'], $studentNumber, $sectionCode), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

		$traits2 = $this->_getRecordsData($dataSelect3 = array('*'), 
			$tables = array('triune_grades_score_sheet_2_traits'), $fieldName = array('sy', 'studentNumber', 'sectionCode'), 
			$where = array($_SESSION['sy'], $studentNumber, $sectionCode), $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
			$limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
		 $traits1g = (array) $traits1[0];
		 $traits2g = (array) $traits2[0];
		 
		 //echo $traits1g['traits1'];
		 //echo $traits1g['traits2'];

		//CLEAR CLASS CARD DATA
		$where = array($studentNumber, $sectionCode, $userName);
		$fieldName = array('studentNumber', 'sectionCode', 'userNumber');
		//CLEAR CLASS CARD DATA
		
		$this->db->trans_start();
			$this->_deleteRecords('triune_wip_grades_class_card', $fieldName, $where);
			$this->_deleteRecords('triune_wip_grades_class_card_traits', $fieldName, $where);

		
		foreach($resultsGrades1 as $row1) {
				$letterEquivalent = null;
				foreach($lE as $eRow) {
					if( ($eRow->lowerScale <= $row1->transmutedGrade) && ($eRow->higherScale >= $row1->transmutedGrade) ){
						
						$letterEquivalent = $eRow->letterEquivalent;
					}
				}

				$insertData = null;
				$insertData = array(
					'studentNumber' => $studentNumber,
					'sectionCode' => $sectionCode,
					'yearLevel' => $data['yearLevel'],
					'subjectCode' => $row1->subjectCode,
					'subjectDescription' => $row1->subjectDescription,
					'grades1' =>  $row1->transmutedGrade,
					'letterEquivalent1' => $letterEquivalent,
					'weight' => $row1->weight,
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),
				);				 

				$insertedRecord1 =$this->_insertRecords($tableName = 'triune_wip_grades_class_card', $insertData);        			 
		}		


		foreach($resultsGrades2 as $row2) {
				$letterEquivalent2 = null;
				foreach($lE as $eRow) {
					if( ($eRow->lowerScale <= $row2->transmutedGrade) && ($eRow->higherScale >= $row2->transmutedGrade) ){
						
						$letterEquivalent2 = $eRow->letterEquivalent;
					}
				}

				$grades2 = array(
					'grades2' => $row2->transmutedGrade,
					'letterEquivalent2' => $letterEquivalent2,
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),

				);
				$this->_updateRecords($tableName = 'triune_wip_grades_class_card', 
				$fieldName = array('studentNumber', 'sectionCode', 'subjectCode'), 
				$where = array($studentNumber, $sectionCode, $row->subjectCode), $grades2);
		}		

		$traitsCount = 10;
		
		for($t = 1; $t <= $traitsCount; $t++) {
				$traitsCol = "traits".$t;

				$insertT = null;
				$insertT = array(
					'studentNumber' => $studentNumber,
					'sectionCode' => $sectionCode,
					'yearLevel' => $data['yearLevel'],
					'traitsCode' => $traitsCol,
					'traitsDescription' => $traitsHeader[0]->$traitsCol,
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),
				);				 

				$insertedRecord1 =$this->_insertRecords($tableName = 'triune_wip_grades_class_card_traits', $insertT);  




				
		}

		for($t1 = 1; $t1 <= 10; $t1++) {
				$traitsCol = "traits".$t1;
		
		//echo $traitsCol . " " . $traits1g[$traitsCol] . "<br>";
				$traits1 = array(
					'traitsScore1' => $traits1g[$traitsCol],
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),

				);
				$this->_updateRecords($tableName = 'triune_wip_grades_class_card_traits', 
				$fieldName = array('studentNumber', 'sectionCode', 'traitsCode'), 
				$where = array($studentNumber, $sectionCode, $traitsCol), $traits1);

		}
		
		$this->db->trans_complete();
		
		

/*
grades3
letterEquivalet3
grades4
letterEquivalent4
gradesFinal
letterEquivalentFinal
actionTaken
weight*/

		$resultsGrades = $this->_getRecordsData($dataSelect2 = array('*'), 
			$tables = array('triune_wip_grades_class_card'), $fieldName = array('studentNumber', 'sectionCode', 'userNumber'), 
			$where = array($studentNumber, $sectionCode, $userName),
			$join = null, $joinType = null,  $sortBy = null, $sortOrder = null, 
			$limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
		$data['resultsGrades'] = $resultsGrades;

		$resultsTraits = $this->_getRecordsData($dataSelect2 = array('*'), 
			$tables = array('triune_wip_grades_class_card_traits'), $fieldName = array('studentNumber', 'sectionCode', 'userNumber'), 
			$where = array($studentNumber, $sectionCode, $userName),
			$join = null, $joinType = null,  $sortBy = array('traitsCode'), $sortOrder = array('asc'), 
			$limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		
		$data['resultsTraits'] = $resultsTraits;

		
		$this->load->library('Pdf');		
        $this->load->view('EGIS/class-card-report', $data);

    }	
	
	
	public function allowGradesRequestEGIS() {
        $this->load->view('EGIS/allow-request');
	}
	
	public function unpostGradesEGIS() {
        $this->load->view('EGIS/unpost-grades');
	}
	
	public function rankingEGIS() {
        $this->load->view('EGIS/ranking-setup');
	}


    public function showRankingBySectionEGIS() {
		$sectionCode = $_POST["sectionCode"];
		$sectionCodeNS = $_POST["sectionCodeNS"];

		$data['sectionCode'] = $sectionCode;
		$data['sectionCodeNS'] = $sectionCodeNS;
		$userName = $this->_getUserName(1);
		$gradingPeriod = $_SESSION['gP'];
		$results = null;

		//$sectionCode = '1005ABM 1-ABM1';
		//$sectionCodeNS = '1005ABM1-ABM1';
		//$data['sectionCode'] = $sectionCode;
		//$data['sectionCodeNS'] = $sectionCodeNS;

		//CONDITION AND ACTION FOR DELETION
		$where = array($sectionCode, $userName);
		$fieldName = array('sectionCode', 'userNumber');
		$this->_deleteRecords('triune_wip_grades_ranking', $fieldName, $where);

		
		$selectFields = "triune_subject_elementary.subjectCode, triune_subject_elementary.subjectDescription, triune_subject_elementary.weight";
		$results = $this->_getRecordsData($dataSelect1 = array($selectFields), 
			$tables = array('triune_section_elementary', 'triune_subject_elementary'), $fieldName = array('triune_section_elementary.sectionCode'), $where = array($sectionCode), 
			$join = array('triune_section_elementary.subjectCode = triune_subject_elementary.subjectCode'), $joinType = array('inner'), 
			$sortBy = array('displaySequence'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
			
		if(empty($results)) {
			$selectFields = "triune_subject_junior_high.subjectCode, triune_subject_junior_high.subjectDescription, triune_subject_junior_high.weight";
			$results = $this->_getRecordsData($dataSelect1 = array($selectFields), 
				$tables = array('triune_section_junior_high', 'triune_subject_junior_high'), $fieldName = array('triune_section_junior_high.sectionCode'), $where = array($sectionCode), 
				$join = array('triune_section_junior_high.subjectCode = triune_subject_junior_high.subjectCode'), $joinType = array('inner'), 
				$sortBy = array('displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
				
				if(empty($results)) {
					$selectFields = "triune_subject_senior_high.subjectCode, triune_subject_senior_high.subjectDescription, triune_subject_senior_high.weight";
					$results = $this->_getRecordsData($dataSelect1 = array($selectFields), 
						$tables = array('triune_section_senior_high', 'triune_subject_senior_high'), 
						$fieldName = array('triune_subject_senior_high.sem', 'triune_section_senior_high.sectionCode'), $where = array($_SESSION['sem'], $sectionCode, ), 
						$join = array('triune_section_senior_high.subjectCode = triune_subject_senior_high.subjectCode'), $joinType = array('inner'), 
						$sortBy = array('displaySequence'), $sortOrder = array('asc'), $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );
				}
				
				
		}

		$weight = array();
		$this->db->trans_start();
		$subjCtr = 1;
		$weightCtr = 0;
		$totalWeight = 0;
		foreach($results as $rowHeader) {
			$subjField = 'subj' . $subjCtr;
		
			if($subjCtr == 1) {
				$insertData1 = null;
				$insertData1 = array(
					'studentNumber' => 'HEADER',
					'lastName' => 'SUBJECT',
					'sectionCode' => $sectionCode,
					$subjField => $rowHeader->subjectCode,
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),
				);				 

				$insertedRecord1 =$this->_insertRecords($tableName = 'triune_wip_grades_ranking', $insertData1);        			 
			} else {

				$recordUpdate = array(
					$subjField => $rowHeader->subjectCode,
				);
			
				$this->_updateRecords($tableName = 'triune_wip_grades_ranking', 
				$fieldName = array('studentNumber'), 
				$where = array('HEADER'), $recordUpdate);
				
			}	
			$weight[$weightCtr] = $rowHeader->weight;
			$totalWeight = $totalWeight + $rowHeader->weight;
			$weightCtr++;
			$subjCtr++;
		}

		$data['subjCtr'] = $subjCtr;
		$data['weightCtr'] = $weightCtr; 		
		$data['weight'] = $weight;
		$data['totalWeight'] = $totalWeight;
		
		$scoreCtr = 1; 
		$switch = 1;
		$totalScore = [];
		$totalWeightedAverage = [];
		$studentNo = [];
		$recordCount = null;
		
		
		if($gradingPeriod == '1') {
			$recordCount = $this->_getRecordsData($dataSelect1 = array('studentNumber'), 
					$tables = array('triune_grades_score_sheet_1_summary'), 
					$fieldName = array('triune_grades_score_sheet_1_summary.sy', 'triune_grades_score_sheet_1_summary.sectionCode'), 
					$where = array($_SESSION['sy'], $sectionCode),$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
					$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
		} elseif($gradingPeriod == '2') {
			$recordCount = $this->_getRecordsData($dataSelect1 = array('studentNumber'), 
					$tables = array('triune_grades_score_sheet_2_summary'), 
					$fieldName = array('triune_grades_score_sheet_2_summary.sy', 'triune_grades_score_sheet_2_summary.sectionCode'), 
					$where = array($_SESSION['sy'], $sectionCode),$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
					$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
		}
		$z = 0;
		foreach($recordCount as $r) {
			$totalScore[$z] = 0;
			$z++;
		}	
		foreach($results as $row) {
			$details = null;
			if($gradingPeriod == '1') {
				$selectDetail = "triune_students_k12.studentNumber, triune_students_k12.lastName, triune_students_k12.firstName, ";
				$selectDetail = $selectDetail . "triune_students_k12.middleName, triune_grades_score_sheet_1_summary.transmutedGrade, triune_grades_score_sheet_1_summary.subjectCode";
				$details = $this->_getRecordsData($dataSelect1 = array($selectDetail), 
					$tables = array('triune_grades_score_sheet_1_summary', 'triune_students_k12'), 
					$fieldName = array('triune_grades_score_sheet_1_summary.sectionCode', 'triune_grades_score_sheet_1_summary.subjectCode'), 
					$where = array($sectionCode, $row->subjectCode), 
					$join = array('triune_grades_score_sheet_1_summary.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
					$sortBy = array('studentNumber'), $sortOrder = array('asc'), $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($gradingPeriod == '2') {
				$selectDetail = "triune_students_k12.studentNumber, triune_students_k12.lastName, triune_students_k12.firstName, ";
				$selectDetail = $selectDetail . "triune_students_k12.middleName, triune_grades_score_sheet_2_summary.transmutedGrade, triune_grades_score_sheet_2_summary.subjectCode";
				$details = $this->_getRecordsData($dataSelect1 = array($selectDetail), 
					$tables = array('triune_grades_score_sheet_2_summary', 'triune_students_k12'), 
					$fieldName = array('triune_grades_score_sheet_2_summary.sectionCode', 'triune_grades_score_sheet_2_summary.subjectCode'), 
					$where = array($sectionCode, $row->subjectCode), 
					$join = array('triune_grades_score_sheet_2_summary.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
					$sortBy = array('studentNumber'), $sortOrder = array('asc'), $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			}
			
			$scoreField = 'subj' . $scoreCtr;
			$recCtr = 0;
			if(!empty($details)) {
				
				foreach($details as $det) {
					if($scoreCtr == 1 || $switch == 1) {
						$insertData1 = null;
						$insertData1 = array(
							'studentNumber' => $det->studentNumber,
							'lastName' => $det->lastName,
							'firstName' => $det->firstName,
							'middleName' => $det->middleName,
							'sectionCode' => $sectionCode,
							$scoreField => $det->transmutedGrade,
							'userNumber' => $userName,
							'timeStamp' => $this->_getTimeStamp(),
						);				 

						$insertedRecord1 =$this->_insertRecords($tableName = 'triune_wip_grades_ranking', $insertData1);        
						
					} else {
						
						$recordUpdate = array(
							$scoreField => $det->transmutedGrade,
						);
					
						$this->_updateRecords($tableName = 'triune_wip_grades_ranking', 
						$fieldName = array('studentNumber'), 
						$where = array($det->studentNumber), $recordUpdate);
						
					}
					//echo $row->weight . " " . $scoreCtr . " " . $row->subjectCode . " " . $det->lastName . " " . $det->studentNumber . " " . $scoreField . " " . $det->transmutedGrade . "<br>";
					
					$totalScore[$recCtr] = $totalScore[$recCtr] + ($det->transmutedGrade * $row->weight);
					//echo $totalScore[$recCtr] . "<br>";
					//echo $recCtr . ") " . $det->studentNumber . " >> " .  " = " .$totalScore[$recCtr] . " / " .  $totalWeight .  " -->" . "<br>"; 
					//echo " -------------------------------------------<br>";
					$studentNo[$recCtr] =  $det->studentNumber;
					$recCtr++;
				}
				$switch = 0;
				
			} else {
				//echo "-------------------------------------";
				//echo $scoreCtr . " " . $row->subjectCode . "<br>";
			}
			$scoreCtr++;
		}
		
		$totalItems = count($totalScore);
		//$data['t'] = $totalItems;
		for($i = 0; $i < $totalItems; $i++) {
			$totalWeightedAverage[$i] = ($totalScore[$i] / $totalWeight); 
			
			echo $studentNo[$i] . " " . $totalScore[$i] . " ---> " . $totalWeight . " >>>" . $totalWeightedAverage[$i] . "<br>";
			$recordUpdate = array(
				'weightedAverage' => $totalWeightedAverage[$i],
			);
		
			$this->_updateRecords($tableName = 'triune_wip_grades_ranking', 
			$fieldName = array('studentNumber'), 
			$where = array($studentNo[$i]), $recordUpdate);
		}
		
		
		$this->db->trans_complete();		
		

		$grades = $this->_getRecordsData($dataSelect2 = array('*'), 
				$tables = array('triune_wip_grades_ranking'), 
				$fieldName = array('sectionCode', 'userNumber'), $where = array($sectionCode, $userName), 
				$join = null, $joinType = null,  $sortBy = array('weightedAverage'), $sortOrder = array('desc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );


				
		$data['grades'] = (array) $grades;
		
		$data['t'] = count($data['grades']) - 1;
		
		$this->load->library('Pdf');		
        $this->load->view('EGIS/ranking-by-section-report', $data);

    }	
	



    public function showRankingByYearLevelEGIS() {
		$yearLevel = $_POST["yearLevel"];
		//$yearLevel = 1;

		$data['yearLevel'] = $yearLevel;
		$userName = $this->_getUserName(1);

		$results = null;

		$gradingPeriod = $_SESSION['gP'];
		$yearLevelSH = 11;
		$courseCodeSH = '';
		//CONDITION AND ACTION FOR DELETION
		$where = array($yearLevel, $userName);
		$fieldName = array('yearLevel', 'userNumber');
		$this->_deleteRecords('triune_wip_grades_ranking', $fieldName, $where);

		
		$selectHead = "triune_subject_elementary.subjectCode, triune_subject_elementary.subjectDescription, triune_subject_elementary.weight";
		$resultsHead = $this->_getRecordsData($dataSelect1 = array($selectHead), 
			$tables = array('triune_section_elementary', 'triune_subject_elementary'), $fieldName = array('triune_section_elementary.yearLevel'), 
			$where = array($yearLevel), $join = array('triune_section_elementary.subjectCode = triune_subject_elementary.subjectCode'), 
			$joinType = array('inner'), $sortBy = array('displaySequence'), $sortOrder = array('asc'), $limit = null, 
			$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
		if(empty($resultsHead)) {
			$selectHead = "triune_subject_junior_high.subjectCode, triune_subject_junior_high.subjectDescription, triune_subject_junior_high.weight";
			$resultsHead = $this->_getRecordsData($dataSelect1 = array($selectHead), 
				$tables = array('triune_section_junior_high', 'triune_subject_junior_high'), $fieldName = array('triune_section_junior_high.yearLevel'), 
				$where = array($yearLevel), $join = array('triune_section_junior_high.subjectCode = triune_subject_junior_high.subjectCode'), 
				$joinType = array('inner'), $sortBy = array('displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

				if(empty($resultsHead)) {
					
					if($yearLevel == 11) {
						$yearLevelSH = 1;
						$courseCodeSH = '1005ABM';
					} elseif($yearLevel == 12) {
						$yearLevelSH = 2;
						$courseCodeSH = '1005ABM2';
					} elseif($yearLevel == 21) {
						$yearLevelSH = 1;
						$courseCodeSH = '1005HUM';
					} elseif($yearLevel == 22) {
						$yearLevelSH = 2;
						$courseCodeSH = '1005HUM2';
					} elseif($yearLevel == 31) {
						$yearLevelSH = 1;
						$courseCodeSH = '1005STE';
					} elseif($yearLevel == 32) {
						$yearLevelSH = 2;
						$courseCodeSH = '1005STE2';
					}
					
					$selectHead = "triune_subject_senior_high.subjectCode, triune_subject_senior_high.subjectDescription, triune_subject_senior_high.weight";
					$resultsHead = $this->_getRecordsData($dataSelect1 = array($selectHead), 
						$tables = array('triune_section_senior_high', 'triune_subject_senior_high'), 
						$fieldName = array('triune_subject_senior_high.sem', 'triune_subject_senior_high.courseCode', 'triune_section_senior_high.yearLevel'), 
						$where = array($_SESSION['sem'], $courseCodeSH, $yearLevelSH), $join = array('triune_section_senior_high.subjectCode = triune_subject_senior_high.subjectCode'), 
						$joinType = array('inner'), $sortBy = array('displaySequence'), $sortOrder = array('asc'), $limit = null, 
						$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				}
		}
		
		
		
		$selectFields = "triune_subject_elementary.subjectCode, triune_subject_elementary.subjectDescription, triune_subject_elementary.weight, ";
		$selectFields = $selectFields . "triune_section_elementary.sectionCode";
		$results = $this->_getRecordsData($dataSelect1 = array($selectFields), 
			$tables = array('triune_section_elementary', 'triune_subject_elementary'), $fieldName = array('triune_section_elementary.yearLevel'), 
			$where = array($yearLevel), $join = array('triune_section_elementary.subjectCode = triune_subject_elementary.subjectCode'), 
			$joinType = array('inner'), $sortBy = array('triune_section_elementary.sectionCode', 'displaySequence'), $sortOrder = array('asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
		if(empty($results)) {
			$selectFields = "triune_subject_junior_high.subjectCode, triune_subject_junior_high.subjectDescription, triune_subject_junior_high.weight, ";
		    $selectFields = $selectFields . "triune_section_junior_high.sectionCode";
			$results = $this->_getRecordsData($dataSelect1 = array($selectFields), 
				$tables = array('triune_section_junior_high', 'triune_subject_junior_high'), $fieldName = array('triune_section_junior_high.yearLevel'), 
				$where = array($yearLevel), $join = array('triune_section_junior_high.subjectCode = triune_subject_junior_high.subjectCode'), 
				$joinType = array('inner'), $sortBy = array('triune_section_junior_high.sectionCode', 'displaySequence'), $sortOrder = array('asc', 'asc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

				if(empty($results)) {
					
					if($yearLevel == 11) {
						$yearLevelSH = 1;
						$courseCodeSH = '1005ABM';
						//$data['yearLevel'] = '1005ABM';
					} elseif($yearLevel == 12) {
						$yearLevelSH = 2;
						$courseCodeSH = '1005ABM2';
						//$data['yearLevel'] = '1005ABM2';
					} elseif($yearLevel == 21) {
						$yearLevelSH = 1;
						$courseCodeSH = '1005HUM';
						//$data['yearLevel'] = '1005HUM';
					} elseif($yearLevel == 22) {
						$yearLevelSH = 2;
						$courseCodeSH = '1005HUM2';
						//$data['yearLevel'] = '1005HUM2';
					} elseif($yearLevel == 31) {
						$yearLevelSH = 1;
						$courseCodeSH = '1005STE';
						//$data['yearLevel'] = '1005STE';
					} elseif($yearLevel == 32) {
						$yearLevelSH = 2;
						$courseCodeSH = '1005STE2';
						//$data['yearLevel'] = '1005STE2';
					}
					
					$selectFields = "triune_subject_senior_high.subjectCode, triune_subject_senior_high.subjectDescription, triune_subject_senior_high.weight, ";
					$selectFields = $selectFields . "triune_section_senior_high.sectionCode";
					$results = $this->_getRecordsData($dataSelect1 = array($selectFields), 
						$tables = array('triune_section_senior_high', 'triune_subject_senior_high'), 
						$fieldName = array('triune_subject_senior_high.sem', 'triune_subject_senior_high.courseCode', 'triune_section_senior_high.yearLevel'), 
						$where = array($_SESSION['sem'], $courseCodeSH, $yearLevelSH), $join = array('triune_section_senior_high.subjectCode = triune_subject_senior_high.subjectCode'), 
						$joinType = array('inner'), $sortBy = array('triune_section_senior_high.sectionCode', 'displaySequence'), $sortOrder = array('asc', 'asc'), $limit = null, 
						$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				}
				
				
		}

		$weight = array();
		$this->db->trans_start();
		$subjCtr = 1;
		$weightCtr = 0;
		$totalWeight = 0;
		foreach($resultsHead as $rowHeader) {
			$subjField = 'subj' . $subjCtr;
		//echo $rowHeader->subjectCode . "<br>";
			if($subjCtr == 1) {
				$insertData1 = null;
				$insertData1 = array(
					'studentNumber' => 'HEADER',
					'lastName' => 'SUBJECT',
					'yearLevel' => $yearLevel,
					$subjField => $rowHeader->subjectCode,
					'userNumber' => $userName,
					'timeStamp' => $this->_getTimeStamp(),
				);				 

				$insertedRecord1 =$this->_insertRecords($tableName = 'triune_wip_grades_ranking', $insertData1);        			 
			} else {

				$recordUpdate = array(
					$subjField => $rowHeader->subjectCode,
				);
			
				$this->_updateRecords($tableName = 'triune_wip_grades_ranking', 
				$fieldName = array('studentNumber'), 
				$where = array('HEADER'), $recordUpdate);
				
			}	
			$weight[$weightCtr] = $rowHeader->weight;
			$totalWeight = $totalWeight + $rowHeader->weight;
			$weightCtr++;
			$subjCtr++;
		}

		$data['subjCtr'] = $subjCtr;
		
		//echo $subjCtr;
		$data['weightCtr'] = $weightCtr; 		
		$data['weight'] = $weight;
		$data['totalWeight'] = $totalWeight;
		//echo $weightCtr;	
		$scoreCtr = 1; 
		$switch = 1;
		$totalScore = [];
		$totalWeightedAverage = [];
		$studentNo = [];

		$recordCount = null;
		
		if($gradingPeriod == '1') {
			$recordCount = $this->_getRecordsData($dataSelect1 = array('triune_grades_score_sheet_1.studentNumber'), 
					$tables = array('triune_section_elementary', 'triune_grades_score_sheet_1'), $fieldName = array('triune_section_elementary.yearLevel'), 
					$where = array($yearLevel), $join = array('triune_section_elementary.sectionCode = triune_grades_score_sheet_1.sectionCode'), 
					$joinType = array('inner'), $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, 
					$groupBy = null );
		} elseif($gradingPeriod == '2') {
			$recordCount = $this->_getRecordsData($dataSelect1 = array('triune_grades_score_sheet_2.studentNumber'), 
					$tables = array('triune_section_elementary', 'triune_grades_score_sheet_2'), $fieldName = array('triune_section_elementary.yearLevel'), 
					$where = array($yearLevel), $join = array('triune_section_elementary.sectionCode = triune_grades_score_sheet_2.sectionCode'), 
					$joinType = array('inner'), $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, 
					$groupBy = null );
			
		}

		if(empty($recordCount)) {

			if($gradingPeriod == '1') {
				$recordCount = $this->_getRecordsData($dataSelect1 = array('triune_grades_score_sheet_1.studentNumber'), 
						$tables = array('triune_section_junior_high', 'triune_grades_score_sheet_1'), $fieldName = array('triune_section_junior_high.yearLevel'), 
						$where = array($yearLevel), $join = array('triune_section_junior_high.sectionCode = triune_grades_score_sheet_1.sectionCode'), 
						$joinType = array('inner'), $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, 
						$groupBy = null );
			} elseif($gradingPeriod == '2') {
				$recordCount = $this->_getRecordsData($dataSelect1 = array('triune_grades_score_sheet_2.studentNumber'), 
						$tables = array('triune_section_junior_high', 'triune_grades_score_sheet_2'), $fieldName = array('triune_section_junior_high.yearLevel'), 
						$where = array($yearLevel), $join = array('triune_section_junior_high.sectionCode = triune_grades_score_sheet_2.sectionCode'), 
						$joinType = array('inner'), $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, 
						$groupBy = null );
			}

					
			if(empty($recordCount)) {

				if($gradingPeriod == '1') {
					$recordCount = $this->_getRecordsData($dataSelect1 = array('triune_grades_score_sheet_1.studentNumber'), 
						$tables = array('triune_section_senior_high', 'triune_grades_score_sheet_1'), 
						$fieldName = array('triune_grades_score_sheet_1.sy', 'triune_section_senior_high.yearLevel'), 
						$where = array($_SESSION['sy'], $yearLevelSH), $join = array('triune_section_senior_high.sectionCode = triune_grades_score_sheet_1.sectionCode'), 
						$joinType = array('inner'), $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, 
						$groupBy = null );
				} elseif($gradingPeriod == '2') {
					$recordCount = $this->_getRecordsData($dataSelect1 = array('triune_grades_score_sheet_2.studentNumber'), 
						$tables = array('triune_section_senior_high', 'triune_grades_score_sheet_2'), 
						$fieldName = array('triune_grades_score_sheet_1.sy', 'triune_section_senior_high.yearLevel'), 
						$where = array($_SESSION['sy'], $yearLevelSH), $join = array('triune_section_senior_high.sectionCode = triune_grades_score_sheet_2.sectionCode'), 
						$joinType = array('inner'), $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, 
						$groupBy = null );
				}
			}
		}		
				
		$z = 0;
		foreach($recordCount as $r) {
			$totalScore[$z] = 0;
			$z++;
		}	
		$sectionCodeNext = null;
		
		foreach($results as $row) {
			//echo "---------<br>";
			//echo $row->subjectCode . "<br>";
			
			$details = null;
			
			if($gradingPeriod == '1') {
				$selectDetail = "triune_students_k12.studentNumber, triune_students_k12.lastName, triune_students_k12.firstName, triune_grades_score_sheet_1_summary.sectionCode, ";
				$selectDetail = $selectDetail . "triune_students_k12.middleName, triune_grades_score_sheet_1_summary.transmutedGrade, triune_grades_score_sheet_1_summary.subjectCode";
				$details = $this->_getRecordsData($dataSelect1 = array($selectDetail), 
					$tables = array('triune_grades_score_sheet_1_summary', 'triune_students_k12'), 
					$fieldName = array('triune_grades_score_sheet_1_summary.sectionCode', 'triune_grades_score_sheet_1_summary.subjectCode'), 
					$where = array($row->sectionCode, $row->subjectCode), 
					$join = array('triune_grades_score_sheet_1_summary.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
					$sortBy = array('studentNumber'), $sortOrder = array('asc'), $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			} elseif($gradingPeriod == '2') {
				$selectDetail = "triune_students_k12.studentNumber, triune_students_k12.lastName, triune_students_k12.firstName, triune_grades_score_sheet_2_summary.sectionCode, ";
				$selectDetail = $selectDetail . "triune_students_k12.middleName, triune_grades_score_sheet_2_summary.transmutedGrade, triune_grades_score_sheet_2_summary.subjectCode";
				$details = $this->_getRecordsData($dataSelect1 = array($selectDetail), 
					$tables = array('triune_grades_score_sheet_2_summary', 'triune_students_k12'), 
					$fieldName = array('triune_grades_score_sheet_2_summary.sectionCode', 'triune_grades_score_sheet_2_summary.subjectCode'), 
					$where = array($row->sectionCode, $row->subjectCode), 
					$join = array('triune_grades_score_sheet_2_summary.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
					$sortBy = array('studentNumber'), $sortOrder = array('asc'), $limit = null, 
					$fieldNameLike = null, $like = null, 
					$whereSpecial = null, $groupBy = null );
			}
			$scoreField = 'subj' . $scoreCtr;
			$recCtr = 0;
			echo $row->sectionCode . " " . $row->subjectCode . " " . $recCtr ."<br>";
			
			
			if(!empty($details)) {
				
				foreach($details as $det) {
					if($scoreCtr == 1 || $switch == 1) {
						$insertData1 = null;
						$insertData1 = array(
							'studentNumber' => $det->studentNumber,
							'lastName' => $det->lastName,
							'firstName' => $det->firstName,
							'middleName' => $det->middleName,
							'sectionCode' => $det->sectionCode,
							'yearLevel' => $yearLevel,
							$scoreField => $det->transmutedGrade,
							'userNumber' => $userName,
							'timeStamp' => $this->_getTimeStamp(),
						);				 

						$insertedRecord1 =$this->_insertRecords($tableName = 'triune_wip_grades_ranking', $insertData1);        
						
					} else {
						
						$recordUpdate = array(
							$scoreField => $det->transmutedGrade,
						);
					
						$this->_updateRecords($tableName = 'triune_wip_grades_ranking', 
						$fieldName = array('studentNumber'), 
						$where = array($det->studentNumber), $recordUpdate);
						
					}
					//echo $row->weight . " " . $scoreCtr . " " . $row->subjectCode . " " . $det->lastName . " " . $det->studentNumber . " " . $scoreField . " " . $det->transmutedGrade . "<br>";
					
					$totalScore[$recCtr] = $totalScore[$recCtr] + ($det->transmutedGrade * $row->weight);
					//echo $totalScore[$recCtr] . "<br>";
					echo $recCtr . ") " . $scoreField . " -- " . $det->studentNumber . " >> " . $det->sectionCode . " = " .$totalScore[$recCtr] . " / " .  $totalWeight .  " -->" . "<br>"; 
					//echo " -------------------------------------------<br>";
					$studentNo[$recCtr] =  $det->studentNumber;
					$recCtr++;

					
				}
				$switch = 0;
			} else {
				//echo "-------------------------------------";
				//echo $scoreCtr . " " . $row->subjectCode . "<br>";
			}

			$peek =	next($results);					
			
			if(isset($peek->sectionCode)) {
			  $sectionCodeNext =  $peek->sectionCode;
			}
			
			//echo $row->sectionCode . " === " . $sectionCodeNext . " " . $scoreCtr . "<br>";
			if( ($sectionCodeNext != null) && (trim($sectionCodeNext) != trim($row->sectionCode))) {
					//echo "OHAYOOO<br>";
					$scoreCtr = 0;
					$switch = 1;
					for($i = 0; $i < (count($studentNo)); $i++) {
						$totalWeightedAverage[$i] = ($totalScore[$i] / $totalWeight); 
						
						echo $studentNo[$i] . " " . $totalScore[$i] . " ---> " . $totalWeight . " >>>" . $totalWeightedAverage[$i] . "<br>";
						$recordUpdate = array(
							'weightedAverage' => $totalWeightedAverage[$i],
						);
					
						$this->_updateRecords($tableName = 'triune_wip_grades_ranking', 
						$fieldName = array('studentNumber'), 
						$where = array($studentNo[$i]), $recordUpdate);
					}
					$studentNo = null;
					$totalScore = null;
					$totalWeightedAverage = null;
			}

			
			$scoreCtr++;
					

		}
		//echo "v " . $z . "--vvvvvvvvv--";
		//$data['t'] = ($z - 1);
		for($i = 0; $i < (count($studentNo)); $i++) {
			$totalWeightedAverage[$i] = ($totalScore[$i] / $totalWeight); 
			
			echo $studentNo[$i] . " " . $totalScore[$i] . " ---> " . $totalWeight . " >>>" . $totalWeightedAverage[$i] . "<br>";
			$recordUpdate = array(
				'weightedAverage' => $totalWeightedAverage[$i],
			);
		
			$this->_updateRecords($tableName = 'triune_wip_grades_ranking', 
			$fieldName = array('studentNumber'), 
			$where = array($studentNo[$i]), $recordUpdate);
		}
		
		
		$this->db->trans_complete();		
		

		$grades = $this->_getRecordsData($dataSelect2 = array('*'), 
				$tables = array('triune_wip_grades_ranking'), 
				$fieldName = array('yearLevel', 'userNumber'), $where = array($yearLevel, $userName), 
				$join = null, $joinType = null,  $sortBy = array('weightedAverage'), $sortOrder = array('desc'), $limit = null, 
				$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
	//var_dump($grades);
		$data['grades'] = (array) $grades;
		$data['t'] = count($data['grades']) - 1;
		
		$data['yearLevelLabel'] = null;
		if($yearLevel == 11) {
			$data['yearLevelLabel'] = '1005ABM';
		} elseif($yearLevel == 12) {
			$data['yearLevelLabel'] = '1005ABM2';
		} elseif($yearLevel == 21) {
			$data['yearLevelLabel'] = '1005HUM';
		} elseif($yearLevel == 22) {
			$data['yearLevelLabel'] = '1005HUM2';
		} elseif($yearLevel == 31) {
			$data['yearLevelLabel'] = '1005STE';
		} elseif($yearLevel == 32) {
			$data['yearLevelLabel'] = '1005STE2';
		} else {
			$data['yearLevelLabel'] = $yearLevel;
		}
		
		
		
		$this->load->library('Pdf');		
        $this->load->view('EGIS/ranking-by-yearlevel-report', $data);

    }	
	
	
	
	
	
}