<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('triuneModelMain');
        $this->load->library('encryption');		
		$this->load->helper('file');	
    }



    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE GET RECORDS--------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------
    function _getRecords($tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial) {
        $rows = $this->triuneModelMain->getRecords($tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial);
        return $rows;
    }
    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE GET RECORDS--------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------



    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE GET RECORDS--------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------
    function _getRecordsData($data, $tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial, $groupBy) {
        $rows = $this->triuneModelMain->getRecordsData($data, $tables, $fieldName, $where, $join, $joinType, $sortBy, $sortOrder, $limit, $fieldNameLike, $like, $whereSpecial, $groupBy);
        return $rows;
    }
    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE GET RECORDS--------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------



    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE UPDATE RECORDS-----------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------
    function _updateRecords($tableName, $fieldName, $where, $data) {
        $rows = $this->triuneModelMain->updateRecords($tableName, $fieldName, $where, $data);
        return $rows;
    }
    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE UPDATE RECORDS-----------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------


    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE INSERT RECORDS-----------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------
    function _insertRecords($tableName, $data) {
        $rows = $this->triuneModelMain->insertRecords($tableName, $data);
        return $rows;
    }
    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE UPDATE RECORDS-----------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------


    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE UPDATE RECORDS-----------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------
    function _deleteRecords($tableName, $fieldName, $where) {
        $rows = $this->triuneModelMain->deleteRecords($tableName, $fieldName, $where);
        return $rows;
    }
    //--------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------TRIUNE UPDATE RECORDS-----------------------------------------------------------
    //--------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET CURRENT DATE-------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    function _getCurrentDate() {
        $currentDate = date('Y-m-d');
        return $currentDate;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET CURRENT DATE-------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET TIMESTAMP-------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    function _getTimeStamp() {
        $timeStamp = date('Y-m-d h:i:s');
        return $timeStamp;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET TIMESTAMP-------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------



    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER NUMBER-------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    function _getUserName($userType) {
        $userName = null;
        if($userType == 0) {
            $userName = "SYSGEN";
        } else {
            $userName = $this->session->userdata('userName'); //should be actual user id
        }
        return $userName;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER NUMBER---------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET WORKSTATION IP ADDRESS----------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    function _getIPAddress()  {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))  {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        } //check ip from share internet
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }  //to check ip is pass from proxy
        else {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET WORKSTATION IP ADDRESS----------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET REQUEST STATUS----------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    public function _getRequestStatus($requestStatusDescription, $application) {
        $results = $this->_getRecordsData($data = array('requestStatusCode'), 
        $tables = array('triune_request_status_reference'), $fieldName = array('requestStatusDescription', 'application'), 
        $where = array($requestStatusDescription, $application), 
        $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
        $limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

        return $results[0]->requestStatusCode;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET REQUEST STATUS----------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    

    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET REQUEST STATUS DESCRIPTION------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    public function _getRequestStatusDescription($requestStatusCode, $application) {
        $results = $this->_getRecordsData($data = array('*'), 
        $tables = array('triune_request_status_reference'), 
        $fieldName = array('requestStatusCode', 'application'), 
        $where = array($requestStatusCode, $application), 
        $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
        $limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

        return $results[0]->requestStatusDescription;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET REQUEST STATUS DESCRIPTION------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------



	public function _base64urlEncode($data) { 
		return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); 
	} 


    public function _base64urlDecode($data) { 
		return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)); 
	}       




    public function _isTokenValid($token) {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       
       
       $result = $userRecord = $this->_getRecordsData($data = array('*'), 
            $tables = array('triune_token'), 
            $fieldName = array('token', 'userID'), 
            $where = array($tkn, $uid), 
            $join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
            $fieldNameLike = null, $like = null, 
            $whereSpecial = null, $groupBy = null );


        if($result) {
            $created = $result[0]->timeStamp;
            $createdTS = strtotime($created);
            $today = date('Y-m-d'); 
            $todayTS = strtotime($today);

            if($createdTS != $todayTS){
                return false;
            }

            $userInfo = $this->_getRecordsData($data = array('*'), $tables = array('triune_user'), $fieldName = array('ID'), $where = array($result[0]->userID), 
                $join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
                $fieldNameLike = null, $like = null, 
                $whereSpecial = null, $groupBy = null );
            return $userInfo;
        } else {
            return false;
        }

        
    } 


    public function _sendMail($toEmail, $subject, $message) { 
  
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.googlemail.com',
            'smtp_port' => 587,
            'smtp_user' => 'trinityemailer@gmail.com',
            'smtp_pass' => 'tr1n1ty@1963',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'starttls'  => TRUE,
            'wordwrap' => TRUE

        );
        $this->load->library('email', $config); 
        $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        $this->email->set_header('Content-type', 'text/html');
        
        $fromEmail = "trinityemailer@gmail.com"; 
  
  
        $this->email->from($fromEmail, 'Trinity Emailer'); 
        $this->email->to($toEmail);
        $this->email->subject($subject); 
        $this->email->message($message); 
		//$attachment_tmp_path = $_FILES['resume']['tmp_name'].'/'.$_FILES['resume']['name'];

		//$this->email->attach($attachment_tmp_path); 
        //Send mail 
        if($this->email->send()) {
            $this->session->set_flashdata("email_sent","Email sent successfully."); 
            return true;
        } else {
            $this->session->set_flashdata("email_sent","Error in sending Email."); 
            return false;
            //var_dump($this->email->send());
        }


   /*     $this->load->library('email');
        $this->email->from('trinityemailer@gmail.com'); //change it
        $this->email->to($toEmail); //change it
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send())
        {
           $data['success'] = 'Yes';
            var_dump($data);
        }
        else
        {
           $data['success'] = 'No';
           $data['error'] = $this->email->print_debugger(array(
              'headers'
           ));
           var_dump($data);           
        }
     */


     } 


    public function _sendMailWithAttachment($toEmail, $subject, $message, $attachmentPath) { 
  
    $base64 = $this->input->post('base64');

    $base64 = str_replace('data:application/pdf;base64,', '', $base64);
    $base64 = str_replace(' ', '+', $base64);

    $data = base64_decode($base64);
	
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.googlemail.com',
            'smtp_port' => 587,
            'smtp_user' => 'trinityemailer@gmail.com',
            'smtp_pass' => 'tr1n1ty@1963',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
			'wordwrap' => TRUE,
            'starttls'  => TRUE,
            'wordwrap' => TRUE

        );
        $this->load->library('email', $config); 
        $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
        $this->email->set_header('Content-type', 'text/html');
        
        $fromEmail = "trinityemailer@gmail.com"; 
  
  
        $this->email->from($fromEmail, 'Trinity Emailer'); 
        $this->email->to($toEmail);
        $this->email->subject($subject); 
        $this->email->message($message); 
		//$attachment_tmp_path = $_FILES['resume']['tmp_name'].'/'.$_FILES['resume']['name'];
		$this->email->attach($data, $attachmentPath, 'application/pdf');
		//$this->email->attach($attachmentPath); 
        //Send mail 
        if($this->email->send()) {
            $this->session->set_flashdata("email_sent","Email sent successfully."); 
            return true;
        } else {
            $this->session->set_flashdata("email_sent","Error in sending Email."); 
            return false;
            //var_dump($this->email->send());
        }


   /*     $this->load->library('email');
        $this->email->from('trinityemailer@gmail.com'); //change it
        $this->email->to($toEmail); //change it
        $this->email->subject($subject);
        $this->email->message($message);
        if ($this->email->send())
        {
           $data['success'] = 'Yes';
            var_dump($data);
        }
        else
        {
           $data['success'] = 'No';
           $data['error'] = $this->email->print_debugger(array(
              'headers'
           ));
           var_dump($data);           
        }
     */


     } 
	 
	 
	 
     public function _insertToken($id) {
        $token = substr(sha1(rand()), 0, 30); 
        $date = date('Y-m-d');

        
        $triune_token = null;
        $triune_token = array(
              'token' => $token,
              'userID' => $id,
              'timeStamp' => $date,
        ); 
        $this->_insertRecords($tableName = 'triune_token', $triune_token);
        $token = $token . $id;
        $qstring = $this->_base64urlEncode($token);                      
        return $qstring;
     }


     public function _sendSMS() {
        $NEXMO_API_KEY =  '72d97f08';
        $NEXMO_API_SECRET = 'd3d4ea727e3ba4ca';
        $basic  = new \Nexmo\Client\Credentials\Basic($NEXMO_API_KEY, $NEXMO_API_SECRET);
        $client = new \Nexmo\Client($basic);

        $TO_NUMBER = '639175787809';
        $message = $client->message()->send([
            'to' => $TO_NUMBER,
            'from' => 'WebApp',
            'text' => 'You are now registered'
        ]);        
     }




    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------INSERT AUDIT TRAIL------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    function _insertAuditTrail($actionName, $systemForAuditName, $moduleName, $for, $oldValue, $newValue, $userType) {

        //SET AND INSERT AUDIT TRAIL RECORD
        //SETUP AUDIT TRAIL DATA AND INSERT AUDIT TRAIL
        $action = $actionName;
        $systemForAudit = $systemForAuditName;
        $module = $moduleName;
        $auditTrailData = array(
            'userName' => $this->_getUserName($userType),
            'timeStamp' => $this->_getTimeStamp(),
            'dateCreated' => $this->_getCurrentDate(),
            'workstationID' => $this->_getIPAddress(),
            'system' => $systemForAudit,
            'module' => $module,
            'action' => $action,
            'oldValue' => serialize($oldValue),
            'newValue' => serialize($newValue),
            'for' => $for,
        );
        $this->_insertRecords('triune_audit_trail', $auditTrailData);
        //SET AND INSERT AUDIT TRAIL RECORD
        
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------INSERT AUDIT TRAIL------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------ACID TRANSACTION FAILED-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    public function _transactionFailed() {
        $error = $this->db->error();
        $this->session->set_flashdata('Error', $error["message"]);
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------ACID TRANSACTION FAILED-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------WRITE LOG FILE----------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    public function _insertTextLog($fileName, $text, $folder) {

        if ( ! write_file('./assets/logs/'.$folder.'/'.$fileName, $text.PHP_EOL, 'a+'))  {
            $this->_transactionFailed();
        } else  {
            return true;
        }
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------WRITE LOG FILE----------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET TRANSACTION DETAILS-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    public function _getTransactionDetails($ID, $from) {
        $results = $this->_getRecordsData($rec = array('*'), 
        $tables = array($from), 
        $fieldName = array('ID'), $where = array($ID), 
        $join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
        $limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, 
        $groupBy = null );

        return $results;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET TRANSACTION DETAILS-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------

    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER PRIVILEGES-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    public function _getUserPrivileges($userName, $dataElementIDType) {

        $recSQL = "triune_privilege.orgCode, triune_privilege.branchOfficeCode, triune_privilege.categorySystemID, ";
        $recSQL = $recSQL . "triune_privilege.groupSystemID, triune_privilege.sourceSystemID, triune_privilege.dataElementID, ";
        $recSQL = $recSQL . "triune_privilege.elementValueID, triune_privilege.elementValueDescription";

        $results = $this->_getRecordsData($rec = array($recSQL), 
        $tables = array('triune_user_privilege', 'triune_privilege'), 
        $fieldName = array('triune_user_privilege.userNumber'), 
        $where = array($userName), 
        $join = array('triune_user_privilege.orgCode = triune_privilege.orgCode AND triune_user_privilege.branchOfficeCode = triune_privilege.branchOfficeCode AND triune_user_privilege.categorySystemID = triune_privilege.categorySystemID AND triune_user_privilege.groupSystemID = triune_privilege.groupSystemID AND triune_user_privilege.sourceSystemID = triune_privilege.sourceSystemID AND triune_user_privilege.dataElementID = triune_privilege.dataElementID AND triune_user_privilege.elementValueID = triune_privilege.elementValueID'), 
        $joinType = array('inner'), 
        $sortBy = array('triune_privilege.sequenceOrder'), 
        $sortOrder = array('asc'), 
        $limit = null, 	$fieldNameLike = null, $like = null, 
        $whereSpecial = array("triune_user_privilege.dataElementID LIKE '%" . $dataElementIDType . "'"), 
        $groupBy = null );

        return $results;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER PRIVILEGES-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    


    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER PRIVILEGES CATEGORY--------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    public function _getUserPrivilegesCategory($userName, $dataElementIDType) {

        $recSQL = "triune_privilege.orgCode, triune_privilege.branchOfficeCode, triune_privilege.categorySystemID as categ, ";
        $recSQL = $recSQL . "triune_privilege.groupSystemID, triune_privilege.sourceSystemID, triune_privilege.dataElementID, ";
        $recSQL = $recSQL . "triune_privilege.elementValueID, triune_privilege.elementValueDescription, ";
        $recSQL = $recSQL . "triune_privilege.elementValueID, triune_privilege.elementValueDescription, ";
        $recSQL = $recSQL . "(SELECT count(triune_privilege.elementValueID) FROM triune_user_privilege ";
        $recSQL = $recSQL . "INNER JOIN triune_privilege ON triune_user_privilege.orgCode = triune_privilege.orgCode AND triune_user_privilege.branchOfficeCode = triune_privilege.branchOfficeCode AND triune_user_privilege.categorySystemID = triune_privilege.categorySystemID AND triune_user_privilege.groupSystemID = triune_privilege.groupSystemID AND triune_user_privilege.sourceSystemID = triune_privilege.sourceSystemID AND triune_user_privilege.dataElementID = triune_privilege.dataElementID AND triune_user_privilege.elementValueID = triune_privilege.elementValueID ";
        $recSQL = $recSQL . "WHERE  triune_user_privilege.userNumber = '" . $userName . "' AND ";
        $recSQL = $recSQL . "triune_user_privilege.dataElementID LIKE '%-GRP' AND ";
        $recSQL = $recSQL . "categ = triune_user_privilege.categorySystemID) as grpcount";


        $results = $this->_getRecordsData($rec = array($recSQL), 
        $tables = array('triune_user_privilege', 'triune_privilege'), 
        $fieldName = array('triune_user_privilege.userNumber'), 
        $where = array($userName), 
        $join = array('triune_user_privilege.orgCode = triune_privilege.orgCode AND triune_user_privilege.branchOfficeCode = triune_privilege.branchOfficeCode AND triune_user_privilege.categorySystemID = triune_privilege.categorySystemID AND triune_user_privilege.groupSystemID = triune_privilege.groupSystemID AND triune_user_privilege.sourceSystemID = triune_privilege.sourceSystemID AND triune_user_privilege.dataElementID = triune_privilege.dataElementID AND triune_user_privilege.elementValueID = triune_privilege.elementValueID'), 
        $joinType = array('inner'), 
        $sortBy = array('triune_privilege.sequenceOrder'), 
        $sortOrder = array('asc'), 
        $limit = null, 	$fieldNameLike = null, $like = null, 
        $whereSpecial = array("triune_user_privilege.dataElementID LIKE '%" . $dataElementIDType . "'"), 
        $groupBy = null );

        return $results;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER PRIVILEGES CATEGORY--------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------


    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER PRIVILEGES CATEGORY--------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    public function _getUserPrivilegesCategorySet($userName, $dataElementIDType) {

        $recSQL = "triune_privilege.orgCode, triune_privilege.branchOfficeCode, triune_privilege.categorySystemID as categ, ";
        $recSQL = $recSQL . "triune_privilege.groupSystemID, triune_privilege.sourceSystemID, triune_privilege.dataElementID, ";
        $recSQL = $recSQL . "triune_privilege.elementValueID, triune_privilege.elementValueDescription, ";
        $recSQL = $recSQL . "triune_privilege.elementValueID, triune_privilege.elementValueDescription, ";
        $recSQL = $recSQL . "(SELECT count(triune_privilege.elementValueID) FROM triune_user_privilege ";
        $recSQL = $recSQL . "INNER JOIN triune_privilege ON triune_user_privilege.orgCode = triune_privilege.orgCode AND triune_user_privilege.branchOfficeCode = triune_privilege.branchOfficeCode AND triune_user_privilege.categorySystemID = triune_privilege.categorySystemID AND triune_user_privilege.groupSystemID = triune_privilege.groupSystemID AND triune_user_privilege.sourceSystemID = triune_privilege.sourceSystemID AND triune_user_privilege.dataElementID = triune_privilege.dataElementID AND triune_user_privilege.elementValueID = triune_privilege.elementValueID ";
        $recSQL = $recSQL . "WHERE  triune_user_privilege.userNumber = '" . $userName . "' AND ";
        $recSQL = $recSQL . "triune_user_privilege.dataElementID LIKE '%-GRPSET' AND ";
        $recSQL = $recSQL . "categ = triune_user_privilege.categorySystemID) as grpcount";


        $results = $this->_getRecordsData($rec = array($recSQL), 
        $tables = array('triune_user_privilege', 'triune_privilege'), 
        $fieldName = array('triune_user_privilege.userNumber'), 
        $where = array($userName), 
        $join = array('triune_user_privilege.orgCode = triune_privilege.orgCode AND triune_user_privilege.branchOfficeCode = triune_privilege.branchOfficeCode AND triune_user_privilege.categorySystemID = triune_privilege.categorySystemID AND triune_user_privilege.groupSystemID = triune_privilege.groupSystemID AND triune_user_privilege.sourceSystemID = triune_privilege.sourceSystemID AND triune_user_privilege.dataElementID = triune_privilege.dataElementID AND triune_user_privilege.elementValueID = triune_privilege.elementValueID'), 
        $joinType = array('inner'), 
        $sortBy = array('triune_privilege.sequenceOrder'), 
        $sortOrder = array('asc'), 
        $limit = null, 	$fieldNameLike = null, $like = null, 
        $whereSpecial = array("triune_user_privilege.dataElementID LIKE '%" . $dataElementIDType . "'"), 
        $groupBy = null );

        return $results;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER PRIVILEGES CATEGORY--------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
	
	
	
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER PRIVILEGES-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    public function _getUserPrivilegesDetails($userName, $dataElementIDType, $groupSystemID) {

        $recSQL = "triune_privilege.orgCode, triune_privilege.branchOfficeCode, triune_privilege.categorySystemID, ";
        $recSQL = $recSQL . "triune_privilege.groupSystemID, triune_privilege.sourceSystemID, triune_privilege.dataElementID, ";
        $recSQL = $recSQL . "triune_privilege.elementValueID, triune_privilege.elementValueDescription, triune_privilege.param, triune_privilege.sequenceOrder";

        $results = $this->_getRecordsData($rec = array($recSQL), 
        $tables = array('triune_user_privilege', 'triune_privilege'), 
        $fieldName = array('triune_user_privilege.userNumber', 'triune_user_privilege.groupSystemID'), 
        $where = array($userName, $groupSystemID), 
        $join = array('triune_user_privilege.orgCode = triune_privilege.orgCode AND triune_user_privilege.branchOfficeCode = triune_privilege.branchOfficeCode AND triune_user_privilege.categorySystemID = triune_privilege.categorySystemID AND triune_user_privilege.groupSystemID = triune_privilege.groupSystemID AND triune_user_privilege.sourceSystemID = triune_privilege.sourceSystemID AND triune_user_privilege.dataElementID = triune_privilege.dataElementID AND triune_user_privilege.elementValueID = triune_privilege.elementValueID'), 
        $joinType = array('inner'), 
        $sortBy = array('triune_privilege.sequenceOrder'), 
        $sortOrder = array('asc'), 
        $limit = null, 	$fieldNameLike = null, $like = null, 
        $whereSpecial = array("triune_user_privilege.dataElementID LIKE '%" . $dataElementIDType . "'"), 
        $groupBy = null );

        return $results;
    }
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET USER PRIVILEGES-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
    

    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET WORKING DAYS______-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
	public function _getWorkingDays($startDate,$endDate){
	  $startDate = strtotime($startDate);
	  $endDate = strtotime($endDate);

	  if($startDate <= $endDate){
		$datediff = $endDate - $startDate;
		return floor($datediff / (60 * 60 * 24));
	  }
	  return false;
	}			
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET WORKING DAYS______-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
	
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET YEARD MONTHS DAYS______-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
	public function _getYearsMonthsDays($startDate){

		$date1 = new DateTime($startDate);
		$date2 = new DateTime($this->_getCurrentDate());
	  
		if($date1 <= $date2){
			$diff = $date2->diff($date1);	  
			return $diff;
		}
		return false;
	}			
    //---------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------GET YEARD MONTHS DAYS______-------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------
	
	public function _endDateAutoAssignSLA($serviceLevelAgreementPeriod, $currentDate) {
		
				$x = 1; 
				while($x <= $serviceLevelAgreementPeriod) {


					$dateExistRec = $this->_getRecordsData($data = array('noWorkDate'), 
					$tables = array('triune_holidays_no_work'), 
					$fieldName = array('noWorkDate'), 
					$where = array($currentDate), 
					$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
					$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

					if(empty($dateExistRec)) {
						$x++; 
						if($x > $serviceLevelAgreementPeriod) {
							break;
						}
					} 
					$currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));						
					
				} 	
				$dateNeeded = $currentDate;
				return $dateNeeded;
	}
	

	public function _getResponsibleResource($requestType) {
		
			$maxAgentCount = 0;
			$activeAgentID = null;
			$activeAgentSequence = null;
			$assignedTo = null;
			
			$maxAgent = $this->_getRecordsData($data = array('responsibleResource', 'sequenceQueue', 'currentPointer'), 
			$tables = array('triune_request_type_agent_queue'), 
			$fieldName = array('requestTypeCode'), 
			$where = array($requestType), 
			$join = null, $joinType = null, $sortBy = array('sequenceQueue'), $sortOrder = array('desc'), 
			$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			if(!empty($maxAgent)) {
				$maxAgentCount = $maxAgent[0]->sequenceQueue;
			}			
			//echo '$maxAgentCount' . $maxAgentCount . "<br>";
			$ctr = 1;
			$adder = 1;
			while($ctr <= $maxAgentCount) {
				$activeAgent = $this->_getRecordsData($data = array('responsibleResource', 'sequenceQueue', 'currentPointer'), 
				$tables = array('triune_request_type_agent_queue'), 
				$fieldName = array('requestTypeCode', 'currentPointer'), 
				$where = array($requestType, 1), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
				if(!empty($activeAgent)) {
					$activeAgentID = $activeAgent[0]->responsibleResource;
					$activeAgentSequence = $activeAgent[0]->sequenceQueue;
				}
				
				//echo '$activeAgentID' . $activeAgentID . "<br>";
				//echo '$activeAgentSequence' . $activeAgentSequence . "<br>";
				
				$currentDateTime = $this->_getTimeStamp();
				//echo '$currentDateTime' . $currentDateTime . "<br>";
				
				$specialCond = "startDate <= '" . $currentDateTime ."' AND endDate >= '" . $currentDateTime . "' ";
				
				$leaveApplication = $this->_getRecordsData($data = array('employeeNumber'), 
				$tables = array('triune_leave_application'), 
				$fieldName = array('employeeNumber'), 
				$where = array($activeAgentID), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, 
				$limit = null, 	$fieldNameLike = null, $like = null, $whereSpecial = array($specialCond), $groupBy = null );


				if(empty($leaveApplication)) {
					$assignedTo = $activeAgentID;
					//echo '$assignedTo' . $activeAgentID . "<br>";

					$activeAgentSequence++;
					//echo '$activeAgentSequence' . $activeAgentSequence . "<br>";
					
					if($activeAgentSequence > $maxAgentCount) {
					  $adder = $activeAgentSequence;
					  $activeAgentSequence = $activeAgentSequence - $maxAgentCount;
					}

					
					$currentPointerStatus = array(
						'currentPointer' => '',
					);					
					
					$this->_updateRecords($tableName = 'triune_request_type_agent_queue', 		
					$fieldName = array('requestTypeCode', 'sequenceQueue'), 
					$where = array($requestType, abs($activeAgentSequence - $adder)), $currentPointerStatus);	

					
					$currentPointerStatus = array(
						'currentPointer' => 1,
					);	
					
					$this->_updateRecords($tableName = 'triune_request_type_agent_queue', 		
					$fieldName = array('requestTypeCode', 'sequenceQueue'), 
					$where = array($requestType, $activeAgentSequence), $currentPointerStatus);	
					return $assignedTo;
					break;
				}

				$activeAgentSequence++;
				if($activeAgentSequence > $maxAgentCount) {
				    $adder = $activeAgentSequence;
					$activeAgentSequence = $activeAgentSequence - $maxAgentCount;
				}
				
				$currentPointerStatus = array(
					'currentPointer' => '',
				);	
				
				$this->_updateRecords($tableName = 'triune_request_type_agent_queue', 		
				$fieldName = array('requestTypeCode', 'sequenceQueue'), 
				$where = array($requestType, abs($activeAgentSequence - $adder) ), $currentPointerStatus);	
				
				$currentPointerStatus = array(
					'currentPointer' => 1,
				);					
				
				$this->_updateRecords($tableName = 'triune_request_type_agent_queue', 		
				$fieldName = array('requestTypeCode', 'sequenceQueue'), 
				$where = array($requestType, $activeAgentSequence), $currentPointerStatus);	
				$ctr++;	
				//echo '$activeAgentSequence' . $activeAgentSequence . "<br>";
				//echo '$ctr' . $ctr . "<br> ------------------------------- <br>";
			
			}
	
	}
	
}

