<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityCombogrid extends MY_Controller {

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

	public function cgetComboGridData() {
		$fieldCol = $_GET['fieldCol'];
		$fieldVal = $_GET['fieldVal'];
		$whereSpecialCol = $_GET['whereSpecialCol'];
		$whereSpecialData = $_GET['whereSpecialData'];
		$tableName = $_GET['tableName'];
		$sorting = $_GET['sorting'];
		$dataSelect = $_GET['dataSelect'];

		$q = isset($_POST['q']) ? $_POST['q'] : '';

		//$whereSpecialCond = "(pBNNo like '%" . $q . "%' OR vendorID like '%" . $q . "%' OR vendorName like '%" . $q . "%' OR cropYear like '%" . $q . "%'  OR pBNDate like '%" . $q . "%') AND postedFlag = '" . $postedFlag . "'";

		$fieldColArr = explode("::", $fieldCol);
		$fieldValArr = explode("::", $fieldVal);
		$sort = explode("::", $sorting);
		
		$whereSpecialColArr = explode("::", $whereSpecialCol);
		$whereSpecialDataArr = explode("::", $whereSpecialData);
		$dataSelectArr = explode("::", $dataSelect);

		$whereSpecialCount = count($whereSpecialColArr);
		$fieldColCount = count($fieldColArr);
		$dataSelectCount = count($dataSelectArr);



		
		$whereSpecialCond = "(";
		for($i = 0; $i < $whereSpecialCount; $i++) {
			$whereSpecialCond = $whereSpecialCond . $whereSpecialColArr[$i] . " like '%" . $q . "%' OR ";
		}
		$whereSpecialCond = rtrim($whereSpecialCond, 'OR ');
		$whereSpecialCond = $whereSpecialCond . ")";
		
		$fieldColCond = "";
		for($i = 0; $i < $fieldColCount; $i++) {
			$fieldColCond = $fieldColCond . $fieldColArr[$i] . ",";
		}
		$fieldColCond = rtrim($fieldColCond, ',');

		$fieldValCond = "";
		for($i = 0; $i < $fieldColCount; $i++) {
			$fieldValCond = $fieldValCond . $fieldValArr[$i] . ",";
		}
		$fieldValCond = rtrim($fieldValCond, ',');

		$dataSelectCond = "";
		for($i = 0; $i < $dataSelectCount; $i++) {
			$dataSelectCond = $dataSelectCond .  $dataSelectArr[$i] . ",";
		}
		$dataSelectCond = rtrim($dataSelectCond, ',');


		
		$results = $this->_getRecordsData($data = array($dataSelectCond),
			$tables = array($tableName),
			$fieldName = array($fieldColCond), $where = array($fieldValCond), $join = null, $joinType = null,
			$sortBy = array($sort[0]), $sortOrder = array($sort[1]), $limit = null,
			$fieldNameLike = null, $like = null,
			$whereSpecial = array($whereSpecialCond), $groupBy = null );

			echo json_encode($results);
	}
	
	
}