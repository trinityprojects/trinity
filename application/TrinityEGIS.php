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
		$selectFields = "triune_grades_score_sheet_1.*, ";
		$selectFields = $selectFields . "triune_students_k12.studentNumber, concat(triune_students_k12.lastName, ', ', triune_students_k12.firstName, ' ', SUBSTR(triune_students_k12.middleName, 1, 1), '.') as fullName";
		
		$results = $this->_getRecordsData($dataSelect = array($selectFields), 
			$tables = array('triune_grades_score_sheet_1', 'triune_students_k12'), 
			$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
			$join = array('triune_grades_score_sheet_1.studentNumber = triune_students_k12.studentNumber'), $joinType = array('inner'), 
			$sortBy = array('gender', 'lastName', 'firstName'), $sortOrder = array('desc', 'asc', 'asc'), $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );

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
	
		$titlesFields = "triune_grades_score_sheet_1_title.*";

		$titlesData = $this->_getRecordsData($dataSelect = array($titlesFields), 
			$tables = array('triune_grades_score_sheet_1_title'), 
			$fieldName = array('sy', 'sectionCode', 'subjectCode' ), $where = array($_SESSION['sy'], $sectionCode, $subjectCode), 
			$join = null, $joinType = null, 
			$sortBy = null, $sortOrder = null, $limit = null, 
			$fieldNameLike = null, $like = null, 
			$whereSpecial = null, $groupBy = null );
	
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
		$selectField - null;
		$resultsGrades = null;
		if($courseCode == '1002') {
			$selectField = "triune_subject_junior_high.subjectDescription, triune_subject_junior_high.weight, ";
			$selectField = $selectField . "triune_grades_score_sheet_1_summary.initialGrade, triune_grades_score_sheet_1_summary.transmutedGrade, ";
			$selectField = $selectField . "triune_subject_junior_high.displaySequence";

			$resultsGrades = $this->_getRecordsData($dataSelect2 = array($selectField), 
				$tables = array('triune_grades_score_sheet_1_summary', 'triune_subject_junior_high'), 
				$fieldName = array('studentNumber'), $where = array($studentNumber), 
				$join = array('triune_subject_junior_high ON triune_grades_score_sheet_1_summary.subjectCode = triune_subject_junior_high.subjectCode'), 
				$joinType = array('inner'), 
				$sortBy = array('triune_subject_junior_high.displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
		} else if($courseCode == '1001') {
			$selectField = "triune_subject_elementary.subjectDescription, triune_subject_elementary.weight, ";
			$selectField = $selectField . "triune_grades_score_sheet_1_summary.initialGrade, triune_grades_score_sheet_1_summary.transmutedGrade, ";
			$selectField = $selectField . "triune_subject_elementary.displaySequence";

			$resultsGrades = $this->_getRecordsData($dataSelect2 = array($selectField), 
				$tables = array('triune_grades_score_sheet_1_summary', 'triune_subject_elementary'), 
				$fieldName = array('studentNumber'), $where = array($studentNumber), 
				$join = array('triune_subject_elementary ON triune_grades_score_sheet_1_summary.subjectCode = triune_subject_elementary.subjectCode'), 
				$joinType = array('inner'), 
				$sortBy = array('triune_subject_elementary.displaySequence'), $sortOrder = array('asc'), $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
			
		}
			
		$data['resultsGrades'] =  $resultsGrades;	

	
		
		$this->load->library('Pdf');		
        $this->load->view('EGIS/class-card-report', $data);

    }	
	
	
	public function allowGradesRequestEGIS() {
        $this->load->view('EGIS/allow-request');
	}
	
	public function unpostGradesEGIS() {
        $this->load->view('EGIS/unpost-grades');
	}
	
	
}