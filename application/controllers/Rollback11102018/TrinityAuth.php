<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class trinityAuth extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		https://tua.edu.ph/myTriune
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://tua.edu.ph/myTriune
	 *
	 * AUTHOR: Randy D. Lagdaan
	 * DESCRIPTION: Authentication Controller. Included login, registration, reset password, create token
	 * DATE CREATED: May 25, 2018
     * DATE UPDATED: May 28, 2018
	 */

    function __construct() {
        parent::__construct();
		$this->load->library('session');
        $this->load->library('form_validation'); 
        $this->load->library('encryption');		
		$this->status = $this->config->item('status'); 
        $this->roles = $this->config->item('roles');
		$this->form_validation->set_error_delimiters('<div class="error">', '</div>');
	}//function __construct()



	public function signInView()	{
		
		//$this->session->sess_destroy();
		header("Access-Control-Allow-Origin: *");
        $data = array();


        $results = $this->_getRecordsData($data = array('*'), 
        $tables = array('triune_organizational_profile'), 
        $fieldName = null, $where = null, $join = null, $joinType = null, $sortBy = null, 
        $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, 
        $whereSpecial = null, $groupBy = null );

        foreach($results[0] as $key=>$val){
            $this->session->set_userdata($key, $val);
        }


        $data['title'] = "LOGIN";
		$this->load->view('useraccount/header', $data);
		$this->load->view('useraccount/signin', $data);
        $this->load->view('useraccount/footer', $data);

	}

	public function loginControl() 	{
		$this->form_validation->set_rules('userName', 'User Name', 'required');    
		$this->form_validation->set_rules('password', 'Password', 'required'); 
		
		if($this->form_validation->run() == FALSE) {
            header("Access-Control-Allow-Origin: *");
            $data['title'] = "LOGIN";
            $this->session->set_flashdata('msg', 'Username or password should be provided');
            $this->load->view('useraccount/header', $data);
            $this->load->view('useraccount/signin', $data);
            $this->load->view('useraccount/footer', $data);
    
		}else{

			$post = $this->input->post();  
			$clean = $this->security->xss_clean($post);
			
			$getPassword = $this->_getRecordsData($data = array('*'), $tables = array('triune_user'), $fieldName = array('userName'), $where = array($clean['userName']), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

			if(!empty($getPassword)) {
				$decryptedPassword = $this->encryption->decrypt($getPassword[0]->password);
				
				//WHEN LOGIN IS SUCCESSFULL
				if($decryptedPassword == $clean['password']) {
		
					foreach($getPassword[0] as $key=>$val){
                        $this->session->set_userdata($key, $val);
                    }
        
                    $triuneUserUpdate = array(
                        'lastLogin' => date('Y-m-d h:i:s A'),
                    );
                    $recordUpdated = $this->_updateRecords($tableName = 'triune_user', $fieldName = array('ID'), $where = array($getPassword[0]->ID), $triuneUserUpdate);


					$settingsRecord = $this->_getRecordsData($selectData = array('*'), $tables = array('triune_settings'), 
						$fieldName = null, $where = null, 
						$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
						$fieldNameLike = null, $like = null, 
						$whereSpecial = null, $groupBy = null );

						foreach($settingsRecord as $row) {
							$this->session->set_userdata($row->settingCode, $row->settingDefault);
						}
					
					//echo "login successfull";
					redirect(base_url().'main');
					
        
                } else {
					$this->session->set_flashdata('msg', 'The login was unsucessful, username and password did not match');
					redirect(base_url());
                }
			
			} else {
					$this->session->set_flashdata('msg', 'The login was unsucessful');
					redirect(base_url());
            }
						
			
		}
		
	}



	public function signUpView() 	{
		header("Access-Control-Allow-Origin: *");
        $data = array();
        $data['title'] = "REGISTRATION";
		//$this->load->view('useraccount/header', $data);
		$this->load->view('useraccount/signup', $data);
		//$this->load->view('useraccount/footer', $data);
	}


	public function checkUserName() {
		if(!empty($_POST["userName"])) {
			$userName = $_POST["userName"];
			$userRecord = $this->_getRecordsData($data = array('userName'), $tables = array('triune_user'), $fieldName = array('userName'), $where = array($userName), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			if(empty($userRecord)) {
				echo 0;
			} else {
				echo 1;
			}			
		}
	}


	public function createAccount() {
		$this->form_validation->set_rules('userName', 'User Name', 'required|alpha_numeric');
		$this->form_validation->set_rules('emailAddress', 'Email Address', 'required|valid_email');  
		$this->form_validation->set_rules('lastName', 'Last Name', 'required');    
		$this->form_validation->set_rules('firstName', 'First Name', 'required');    
		$this->form_validation->set_rules('middleName', 'Middle Name', 'required');    
		$this->form_validation->set_rules('birthDate', 'Birth Date', 'required|regex_match[/\d{4}\-\d{2}-\d{2}/]');    
		$this->form_validation->set_rules('userCategory', 'User Category', 'required');    

		$userCategory = $this->input->post('userCategory');
        $this->session->set_flashdata('userCategory', $userCategory);

        $studentNumber = null;
        //$cityAddress = null;
        //$mobileNumberS = null;
        //$guardianName = null;       
        $birthPlaceS = null;       

        $employeeNumber = null;
        //$cityStreet = null;
        //$mobileNumberE = null;
        $TIN = null;       
        
        $presentAddressG = null;
		$mobileNumberG = null;
		
		$userNumber = null;

        if($userCategory == "S") {
            $this->form_validation->set_rules('studentNumber', 'Student Number', 'required');    
            //$this->form_validation->set_rules('cityAddress', 'Present Address', 'required');    
            //$this->form_validation->set_rules('mobileNumberS', 'Mobile Number', 'required');    
            //$this->form_validation->set_rules('guardianName', 'Guardian Name', 'required');    
            $this->form_validation->set_rules('birthPlaceS', 'Birth Place', 'required');    
			
            $studentNumber = $this->input->post('studentNumber');
            //$cityAddress = $this->input->post('cityAddress');
            //$mobileNumberS = $this->input->post('mobileNumberS');
            //$guardianName = $this->input->post('guardianName');
            $birthPlaceS = $this->input->post('birthPlaceS');
			$userNumber =  $studentNumber;

            $this->session->set_flashdata('studentNumber', $studentNumber);
            //$this->session->set_flashdata('cityAddress', $cityAddress);
            //$this->session->set_flashdata('mobileNumberS', $mobileNumberS);
            //$this->session->set_flashdata('guardianName', $guardianName);
            $this->session->set_flashdata('birthPlaceS', $birthPlaceS);
            
        } elseif($userCategory == "E") {
            $this->form_validation->set_rules('employeeNumber', 'Employee Number', 'required');    
            //$this->form_validation->set_rules('cityStreet', 'City Street', 'required');    
            //$this->form_validation->set_rules('mobileNumberE', 'Mobile Number', 'required');    
            $this->form_validation->set_rules('TIN', 'TIN', 'required');    
            $employeeNumber = $this->input->post('employeeNumber');
            //$cityStreet = $this->input->post('cityStreet');
            //$mobileNumberE = $this->input->post('mobileNumberE');
            $TIN = $this->input->post('TIN');
			$userNumber =  $employeeNumber;

            $this->session->set_flashdata('employeeNumber', $employeeNumber);
            //$this->session->set_flashdata('cityStreet', $cityStreet);
            //$this->session->set_flashdata('mobileNumberE', $mobileNumberE);
            $this->session->set_flashdata('TIN', $TIN);


        } elseif($userCategory == "G") {
            $this->form_validation->set_rules('presentAddressG', 'Present Address', 'required');    
            $this->form_validation->set_rules('mobileNumberG', 'Mobile Number', 'required');    
            $presentAddressG = $this->input->post('presentAddressG');
            $mobileNumberG = $this->input->post('mobileNumberG');
            $this->session->set_flashdata('presentAddressG', $presentAddressG);
            $this->session->set_flashdata('mobileNumberG', $mobileNumberG);
        }


		$emailAddress = $this->input->post('emailAddress');
		$userName = $this->input->post('userName');
		$lastName = $this->input->post('lastName');
		$middleName = $this->input->post('middleName');
		$firstName = $this->input->post('firstName');
		$birthDate = $this->input->post('birthDate');
		$studentNumber = $this->input->post('studentNumber');

		$this->session->set_flashdata('emailAddress', $emailAddress);
		$this->session->set_flashdata('userName', $userName);
		$this->session->set_flashdata('lastName', $lastName);
		$this->session->set_flashdata('middleName', $middleName);
		$this->session->set_flashdata('firstName', $firstName);
		$this->session->set_flashdata('birthDate', $birthDate);


		if ($this->form_validation->run() == FALSE) {   

			$this->session->set_flashdata('msg', 'All fields are required to be proper. Please try again!');
			redirect(base_url().'user-acct/sign-up');
		}else{    
			

			$emailAddressExist = $userRecord = $this->_getRecordsData($data = array('emailAddress'), $tables = array('triune_user'), $fieldName = array('emailAddress'), $where = array($emailAddress), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			$userNameExist = $userRecord = $this->_getRecordsData($data = array('userName'), $tables = array('triune_user'), $fieldName = array('userName'), $where = array($userName), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );
					
				
			if(!empty($userNameExist)){
				$this->session->set_flashdata('msg', 'Username Already Exist!');
				redirect(base_url().'user-acct/sign-up');
	
			} elseif(!empty($emailAddressExist)) {
				
				$this->session->set_flashdata('msg', 'Email Address Already Exist!');
				redirect(base_url().'user-acct/sign-up');
				
			} else {
                $recordExist = null;
                if($userCategory == "S") {
                    $recordExist = $this->_getRecordsData($data = array('studentNumber'), 
                        $tables = array('triune_students_k12'), 
                        $fieldName = array('lastName', 'firstName', 'middleName', 'studentNumber', 'birthDate', 'birthPlace'), 
                        $where = array($lastName, $firstName, $middleName, $studentNumber, $birthDate, $birthPlaceS), 
                        $join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
                        $fieldNameLike = null, $like = null, 
                        $whereSpecial = null, $groupBy = null );

						if(empty($recordExist)) {
							$recordExist = $this->_getRecordsData($data = array('studentNumber'), 
							$tables = array('triune_students'), 
							$fieldName = array('lastName', 'firstName', 'middleName', 'studentNumber', 'birthDate', 'birthPlace'), 
							$where = array($lastName, $firstName, $middleName, $studentNumber, $birthDate, $birthPlaceS), 
							$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
							$fieldNameLike = null, $like = null, 
							$whereSpecial = null, $groupBy = null );
						}

						
                    //$sNumber = $recordExist[0]->studentNumber;

                    /*$recordExist = $this->_getRecordsData($data = array('studentNumber'), 
                        $tables = array('triune_guardian'), 
                        $fieldName = array('studentNumber', 'guardianName'), 
                        $where = array($sNumber, $guardianName), 	$join = null, 
                        $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
                        $fieldNameLike = null, $like = null, $whereSpecial = null, 
                        $groupBy = null );*/
						
                } elseif($userCategory == "E") { 

                    $recordExist = $this->_getRecordsData($data = array('employeeNumber'), 
                        $tables = array('triune_employee_data'), 
                        $fieldName = array('lastName', 'firstName', 'middleName', 'birthDate', 'employeeNumber', 'tin'), 
                        $where = array($lastName, $firstName, $middleName, $birthDate, $employeeNumber, $TIN), 	
                        $join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
                        $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

                } elseif($userCategory == "G") {
                    $recordExist = 1;
                }



                if(!empty($recordExist)) {
                    $clean = $this->security->xss_clean($this->input->post(NULL, TRUE));

					$triune_user = null;
					$triune_user = array(
						  'userName' => $clean['userName'],
						  'emailAddress' => $clean['emailAddress'],
						  'firstNameUser' => $clean['firstName'],
						  'lastNameUser' => $clean['lastName'],
						  'userNumber' => $userNumber,
						  'role' => $this->roles[0],
						  'status' => $this->status[0],
					); 
				    $id = $this->_insertRecords($tableName = 'triune_user', $triune_user);
					
                    if($userCategory == "G") {
                        $triune_guest_data = null;
                        $triune_guest_data = array(
                            'userName' => $userName,
                            'birthDate' => $birthDate,
                            'presentAddress' => $presentAddressG,
                            'mobileNumber' => $mobileNumberG,
                            'dateCreated' => $this->_getCurrentDate(),
                            'createdBy' => $userName,
                            'userNumber' => $userName,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_guest_data', $triune_guest_data);
                    }


					$qstring = $this->_insertToken($id);

                    $url = site_url() . 'trinityAuth/complete/token/' . $qstring;
                    $link = '<a href="' . $url . '">' . $url . '</a>'; 
                               
                    $message = '';                     
                    $message .= '<strong>You have signed up with our APP</strong><br>';
                    $message .= '<strong>Please click:</strong> ' . $link;                          
 
                    echo $message; //send this in email
					
					//$emailSent = $this->_sendMail($toEmail = $clean['emailAddress'], $subject = "Email Verification of your Trinity Portal registration", $message);
                    //if(!$emailSent) {
                        //$this->session->set_flashdata('emailSent', '1');
                        //echo "HELLO";
                    //} else {
                    //    $this->session->set_flashdata('emailSent', '1');
                    //    redirect(base_url().'user-acct/sign-up');

                    //}
				} else {
					$this->session->set_flashdata('msg', "The personal information you've typed do not matched with your current records!");
					redirect(base_url().'user-acct/sign-up');
				}

			}           
		}

	}


	public function forgotPassword() {
		$this->form_validation->set_rules('emailAddress', 'Email Address', 'required|valid_email'); 
		
		if($this->form_validation->run() == FALSE) {
            header("Access-Control-Allow-Origin: *");
            $data = array();
            $data['title'] = "FORGOT PASSWORD";
            $this->load->view('useraccount/header', $data);
            $this->load->view('useraccount/forgotpassword', $data);
            $this->load->view('useraccount/footer', $data);
		}else{
			$emailAddress = $this->input->post('emailAddress');  
			$clean = $this->security->xss_clean($emailAddress);
		
			$getUserInfo = $this->_getRecordsData($data = array('*'), $tables = array('triune_user'), $fieldName = array('emailAddress'), $where = array($clean), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
	
		
			if(empty($getUserInfo)){
				$this->session->set_flashdata('msg', "'We can't find your email address");
				redirect(base_url().'user-acct/forgot-password');
			}   

			
			if($getUserInfo[0]->status != $this->status[1]){ //if status is not approved
				$this->session->set_flashdata('msg', 'Your account is not in approved status');
				redirect(base_url().'user-acct/forgot-password');
			}
			
			//build token 
			
			$qstring = $this->_insertToken($getUserInfo[0]->ID);

			$url = site_url() . 'trinityAuth/resetPassword/token/' . $qstring;
			$link = '<a href="' . $url . '">' . $url . '</a>'; 
			
			$message = '';                     
			$message .= '<strong>A password reset has been requested for this email account</strong><br>';
			$message .= '<strong>Please click this link to reset password:</strong> ' . $link;             
			$message .= '<br><br>';
			$message .= '<strong>Your username is: <u>' . $getUserInfo[0]->userName . '</u></strong>';
			$message .= '<br><br><br><br><br><br>';
			$message .= '_________________________________________________________________________________<br>';
			$message .= 'Please do not reply directly to this email. If you have questions, you may email emailsupport@tua.edu.ph';
			
			$emailSent = $this->_sendMail($toEmail =$emailAddress, $subject = "Password Reset", $message);
			if(!$emailSent) {
				//$this->session->set_flashdata('emailSent', '1');
				//echo "HELLO";
			} else {
				$this->session->set_flashdata('emailSent', '1');
				$this->session->set_flashdata('emailAddress', $emailAddress);
				redirect(base_url().'user-acct/sign-in');

			}
			
			//echo $message; //send this through mail
			//exit;
			
		}
		
	}


	public function complete() {
		$token = $this->_base64urlDecode($this->uri->segment(4));       
		$cleanToken = $this->security->xss_clean($token);
		
		$userInfo = $this->_isTokenValid($cleanToken); //either false or array();    

		if(empty($userInfo)) {
			$this->session->set_flashdata('msg', 'Token is invalid or expired');
			redirect(base_url().'user-acct/sign-up');			
		}

		$data = array(
			'firstName'=> $userInfo[0]->firstNameUser, 
			'emailAddress'=>$userInfo[0]->emailAddress, 
			'userID'=>$userInfo[0]->ID, 
			'userName'=>$userInfo[0]->userName, 
			'token'=>$this->_base64urlEncode($token)
		);


		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('passwordConfirmation', 'Password Confirmation', 'required|matches[password]');         

		if ($this->form_validation->run() == FALSE) {   
            header("Access-Control-Allow-Origin: *");
            $data['title'] = "COMPLETION";
            $this->load->view('useraccount/header', $data);
            $this->load->view('useraccount/completionpassword', $data);
            $this->load->view('useraccount/footer', $data);
    
		} else {
			$post = $this->input->post(NULL, TRUE);
			//$key = bin2hex($this->encryption->create_key(16));
			$cleanPost = $this->security->xss_clean($post);
            $hashed = $this->encryption->encrypt($cleanPost['password']);      
            
			$cleanPost['password'] = $hashed;
			unset($cleanPost['passwordConfirmation']);

			$triuneUserUpdate = array(
				'password' => $cleanPost['password'],
				'lastLogin' => date('Y-m-d h:i:s A'),
				'status' => $this->status[1],
			);
			$recordUpdated = $this->_updateRecords($tableName = 'triune_user', $fieldName = array('ID'), $where = array($userInfo[0]->ID), $triuneUserUpdate);

			
			
			$k12Student = $this->_getRecordsData($data = array('*'), $tables = array('triune_students_k12'), $fieldName = array('studentNumber'), $where = array($userInfo[0]->userNumber), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
			$orgCode = 'TUA';
			$branchOfficeCode = 'ERODSR';
			
			if(!empty($k12Student)) {
						$categorySystemID = 'Applications';
						$groupSystemID = 'Applications';
						$sourceSystemID = 'Applications';
						$dataElementID = 'APPLICATIONS-CAT';
						$elementValueID = 'applications';
						$accessRights = '';
						$control = '';
						$userLevel = '';
						$userName = $userInfo[0]->userName;
						
                        $k12_initial_rights1 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rights1);

						$groupSystemID = 'K12';
						$sourceSystemID = 'K12';
						$dataElementID = 'K12-GRP';
						$elementValueID = 'k12';
                        $k12_initial_rights2 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rights2);

						$sourceSystemID = 'EGIS';
						$dataElementID = 'EGIS-SYS';
						$elementValueID = 'EGIS';
                        $k12_initial_rights3 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rights3);

						$dataElementID = 'CLASSSTANDING-MDL';
						$elementValueID = 'classStanding';
                        $k12_initial_rights4 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rights4);
						
						$dataElementID = 'CLASSSTANDING-gradesRequest-MNU';
						$elementValueID = 'gradesRequest';
                        $k12_initial_rights5 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rights5);
						

						$categorySystemID = 'Settings';
						$groupSystemID = 'Settings';
						$sourceSystemID = 'Settings';
						$dataElementID = 'SETTINGS-CATSET';
						$elementValueID = 'settings';
                        $k12_initial_rights6 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rights6);


						$groupSystemID = 'Term';
						$sourceSystemID = 'Term';
						$dataElementID = 'TERM-GRPSET';
						$elementValueID = 'term';
                        $k12_initial_rights7 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rights7);
			}
			



			$cGStudent = $this->_getRecordsData($data = array('*'), $tables = array('triune_students'), $fieldName = array('studentNumber'), $where = array($userInfo[0]->userNumber), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );
			
			$orgCode = 'TUA';
			$branchOfficeCode = 'ERODSR';
			
			if(!empty($cGStudent)) {
						$categorySystemID = 'Applications';
						$groupSystemID = 'Applications';
						$sourceSystemID = 'Applications';
						$dataElementID = 'APPLICATIONS-CAT';
						$elementValueID = 'applications';
						$accessRights = '';
						$control = '';
						$userLevel = '';
						$userName = $userInfo[0]->userName;
						
                        $k12_initial_rightsC1 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC1);

						$groupSystemID = 'StudentPortal';
						$sourceSystemID = 'StudentPortal';
						$dataElementID = 'StudentPortal-GRP';
						$elementValueID = 'studentPortal';
                        $k12_initial_rightsC2 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC2);

						$sourceSystemID = 'SR';
						$dataElementID = 'SR-SYS';
						$elementValueID = 'SR';
                        $k12_initial_rightsC3 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC3);

						$dataElementID = 'GRADES-MDL';
						$elementValueID = 'grades';
                        $k12_initial_rightsC4 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC4);


						$dataElementID = 'ACCOUNTS-MDL';
						$elementValueID = 'accounts';
                        $k12_initial_rightsC5 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC5);

						

						$categorySystemID = 'Settings';
						$groupSystemID = 'Settings';
						$sourceSystemID = 'Settings';
						$dataElementID = 'SETTINGS-CATSET';
						$elementValueID = 'settings';
                        $k12_initial_rightsC6 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC6);


						$groupSystemID = 'Term';
						$sourceSystemID = 'Term';
						$dataElementID = 'TERM-GRPSET';
						$elementValueID = 'term';
                        $k12_initial_rightsC7 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC7);
						
						$categorySystemID = 'Applications';
						$groupSystemID = 'HR';
						$sourceSystemID = 'HR';
						$dataElementID = 'HR-GRP';
						$elementValueID = 'hr';
                        $k12_initial_rightsC8 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC8);

						$sourceSystemID = 'THRIMS';
						$dataElementID = 'THRIMS-SYS';
						$elementValueID = 'THRIMS';
                        $k12_initial_rightsC9 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC9);

						$dataElementID = 'EVALUATION-MDL';
						$elementValueID = 'evaluation';
                        $k12_initial_rightsC10 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC10);
						
						$dataElementID = 'EVALUATION-faculty-MNU';
						$elementValueID = 'faculty';
                        $k12_initial_rightsC11 = array(
                            'orgCode' => $orgCode,
                            'branchOfficeCode' => $branchOfficeCode,
                            'categorySystemID' => $categorySystemID,
                            'groupSystemID' => $groupSystemID,
                            'sourceSystemID' => $sourceSystemID,
                            'dataElementID' => $dataElementID,
                            'elementValueID' => $elementValueID,
                            'control' => $control,
                            'accessRights' => $accessRights,
                            'userLevel' => $userLevel,
                            'userNumber' => $userName,
                            'createdBy' => $userInfo[0]->userNumber,
                            'timeStamp' => $this->_getTimeStamp(),
                        ); 
                        $rec = $this->_insertRecords($tableName = 'triune_user_privilege', $k12_initial_rightsC11);
						
						
			}



			
			
			if(!$recordUpdated){
				error_log('Unable to updateUserInfo('.$userInfo[0]->ID.')');
				return false;
			}

			$updatedUser = $this->_getRecordsData($data = array('*'), 
				$tables = array('triune_user'), 
				$fieldName = array('ID'), 
				$where = array($userInfo[0]->ID), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			
			if(!$updatedUser){
				$this->session->set_flashdata('msg', 'There was a problem updating your record');
				redirect(site_url());
			}


			unset($updatedUser[0]->password);

			foreach($updatedUser[0] as $key=>$val){
				$this->session->set_userdata($key, $val);
			}
    
            $getPassword = $this->_getRecordsData($data = array('*'), $tables = array('triune_user'), $fieldName = array('userName'), $where = array('jtsy'), 
            $join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, $fieldNameLike = null, $like = null, $whereSpecial = null, $groupBy = null );

    
            redirect(base_url().'user-acct/sign-up-success');
		}

	}

    
	public function signUpSuccess() 	{
        header("Access-Control-Allow-Origin: *");
        $data = array();

        $data['title'] = "REGISTRATION";
		$this->load->view('useraccount/header', $data);
		$this->load->view('useraccount/signupsuccess', $data);
		$this->load->view('useraccount/footer', $data);
	}

 
	public function resetPassword()
	{
		$token = $this->_base64urlDecode($this->uri->segment(4));         
		$cleanToken = $this->security->xss_clean($token);
		
		
		$userInfo = $this->_isTokenValid($cleanToken); //either false or array();    
		
		if(empty($userInfo)) {
			$this->session->set_flashdata('msg', 'Token is invalid or expired');
			redirect(base_url().'auth/register');			
		}
		
		$data = array(
			'firstName'=> $userInfo[0]->firstNameUser, 
			'emailAddress'=>$userInfo[0]->emailAddress, 
			'ID'=>$userInfo[0]->ID, 
			'userName'=>$userInfo[0]->userName, 
			'token'=>$this->_base64urlEncode($token)
		);
		
		

		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('passwordConfirmation', 'Password Confirmation', 'required|matches[password]');              
		
		if ($this->form_validation->run() == FALSE) {   
            header("Access-Control-Allow-Origin: *");
            $data['title'] = "RESET PASSWORD";
            $this->load->view('useraccount/header', $data);
            $this->load->view('useraccount/reset', $data);
            $this->load->view('useraccount/footer', $data);
		}else{

			$post = $this->input->post(NULL, TRUE);
			$cleanPost = $this->security->xss_clean($post);
			$hashed = $this->encryption->encrypt($cleanPost['password']);                
			$cleanPost['password'] = $hashed;
			$cleanPost['ID'] = $userInfo[0]->ID;
			
			unset($cleanPost['passwordConfirmation']);

			$triuneUserUpdate = array(
				'password' => $cleanPost['password'],
				'lastLogin' => date('Y-m-d h:i:s A'),
				'status' => $this->status[1],
			);
			$recordUpdated = $this->_updateRecords($tableName = 'triune_user', $fieldName = array('ID'), $where = array($userInfo[0]->ID), $triuneUserUpdate);

			if(!$recordUpdated){
				error_log('Unable to updateUserInfo('.$userInfo[0]->ID.')');
				return false;
			}

			$updatedUser = $this->_getRecordsData($data = array('*'), 
				$tables = array('triune_user'), 
				$fieldName = array('ID'), 
				$where = array($userInfo[0]->ID), 
				$join = null, $joinType = null, $sortBy = null, $sortOrder = null, $limit = null, 
				$fieldNameLike = null, $like = null, 
				$whereSpecial = null, $groupBy = null );

			
			if(!$updatedUser){
				$this->session->set_flashdata('msg', 'There was a problem updating your password');
				redirect(base_url()."auth/forgot");
			}

			$this->session->set_flashdata('msg', 'Password Updated');
            redirect(base_url());

		}
	} 
    
	public function consentFormStudent() 	{ 
		header("Access-Control-Allow-Origin: *");
        $data = array();
        $data['title'] = "Student Consent Form";
		$this->load->view('useraccount/header', $data);
		$this->load->view('useraccount/consentformstudent', $data);
		$this->load->view('useraccount/footer', $data);
	}

	
	public function consentFormEmployee() 	{ 
		header("Access-Control-Allow-Origin: *");
        $data = array();
        $data['title'] = "Student Consent Form";
		$this->load->view('useraccount/header', $data);
		$this->load->view('useraccount/consentformemployee', $data);
		$this->load->view('useraccount/footer', $data);
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('trinityAuth/signInView');
	}	
}