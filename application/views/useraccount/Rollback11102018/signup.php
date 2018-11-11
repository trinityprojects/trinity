<!DOCTYPE html>
<html lang="en">
<head>
	<title>TRIUNE - <?php echo $title;?></title>

	<meta name="description" content="overview &amp; stats" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/fontawesome-free-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" />
	<!-- page specific plugin styles -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/trinity.css" />
	<!-- basic scripts -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/scripts/bootstrap.js"></script>

	
	
</head>
 
<body class="no-skin">
        <!-- The Modal -->
        <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
            <h4>Trinity Portal Emailer</h4>

            <span class="close">&times;</span>
            </div>
            <div class="modal-body">
            <p>A verification link was sent to your email address (<?php echo $this->session->flashdata('emailAddress'); ?>).</p>
            <p>Kindly login to your email and perform this final step to complete your registration.</p>
            </div>
            <div class="modal-footer">
            <h4>Please confirm in your email. Look for the email in the spam folder.</h4>
            </div>
        </div>

        </div>



<!--START ------------------------------ registration FORM  -------------------------------------------START -->
<?php 
$attributes = array('method' => 'POST', 'role' => 'form', 'id' => 'createToken' );
echo form_open_multipart('user-acct/create-account', $attributes);
?>

<div class="row">
    <div class="col-12 top-header" ></div>


<div class="col-12 row-space-25" ></div>
<div class="col-2"></div>


<div class="col-8 ">
            <div class="row border form-panel">

                    <div class="col-lg-6 col-md-12 ">



                            <div class="col-lg-12 justify-content-center align-items-center">
                                    <h3><em id="capitalize"><?php echo $_SESSION['organizationalAppName'];?></em></h3>
                                    <h6>Please enter the required information below.</h6>     


                                    
                                        <!--START ------------------------------ userName TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <div class="input-group-prepend">
                                                    <div class="input-group-text bg-transparent">
                                                    <i class="fa fa-user" style="color: gold"></i>
                                                    </div>
                                            </div>
                                            <input name="userName" value="<?php echo $this->session->flashdata('userName'); ?>" data-validation="alphanumeric" id="userName" placeholder='User Name' class='form-control'  data-validation-error-msg="Username is not valid" data-validation-error-msg-container="#messageValidationLocationUserName" onBlur="checkUserAvailability()" onFocus="clearValidationMessages()" >
                                            <span class="input-group-append">
                                                <div class="input-group-text bg-transparent">
                                                    <i class="fa fa-user-plus" id="iconAvailable" style="display:none; color:green"></i>
                                                    <i class="fa fa-user-times" id="iconNotAvailable" style="display:none; color:red" ></i>
                                                </div>
                                            </span>
                                            <span class="input-group-append">
                                                <i class="textBoxMessageAvailableMd" id='messageAvailable' > Username <br> Available.</i>
                                                <i class="textBoxMessageNotAvailableMd" id='messageNotAvailable' > Username <br> Not Available.</i>
                                            </span>
                                        </div>
                                        <span>
                                        <i><img src="<?php echo base_url();?>assets/images/LoaderIcon.gif" class ="progressImageRight" id="iconLoader"  /></i>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationUserName"></b>
                                        </span>
                                        <!--END ------------------------------ userName TextBox  -------------------------------------------END -->


                                        <!--START ------------------------------ emailAddress TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <div class="input-group-prepend">
                                                    <div class="input-group-text bg-transparent">
                                                    <i class="fa fa-envelope" style="color: gold"></i>
                                                    </div>
                                            </div>
                                            <input name="emailAddress" value="<?php echo $this->session->flashdata('emailAddress'); ?>" data-validation="email" id="emailAddress" placeholder='Email Address' class='form-control'  data-validation-error-msg="Please enter a valid Email Address" data-validation-error-msg-container="#messageValidationLocationEmailAddress" onBlur="" onFocus="" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationEmailAddress"></b>
                                        </span>
                                        <!--END ------------------------------ emailAddress TextBox  -------------------------------------------END -->

                                        <!--START ------------------------------ lastName TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <input name="lastName" value="<?php echo $this->session->flashdata('lastName'); ?>" data-validation="alphanumeric" id="lastName" placeholder='Last Name' class='form-control'  data-validation-allowing=" .,-ñÑ" data-validation-error-msg="Please enter Last Name" data-validation-error-msg-container="#messageValidationLocationLastName" onBlur="" onFocus="" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationLastName"></b>
                                        </span>
                                        <!--END ------------------------------ lastName TextBox  -------------------------------------------END -->

                                        <!--START ------------------------------ firstName TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <input name="firstName" value="<?php echo $this->session->flashdata('firstName'); ?>" data-validation="alphanumeric" id="firstName" placeholder='First Name' class='form-control'  data-validation-allowing=" .,-ñÑ" data-validation-error-msg="Please enter First Name" data-validation-error-msg-container="#messageValidationLocationFirstName" onBlur="" onFocus="" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationFirstName"></b>
                                        </span>
                                        <!--END ------------------------------ firstName TextBox  -------------------------------------------END -->

                                        <!--START ------------------------------ middleName TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <input name="middleName" value="<?php echo $this->session->flashdata('middleName'); ?>" data-validation="alphanumeric" id="middleName" placeholder='Middle Name' class='form-control'  data-validation-allowing=" .,-ñÑ" data-validation-error-msg="Please enter Middle Name" data-validation-error-msg-container="#messageValidationLocationMiddleName" onBlur="" onFocus="" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationMiddleName"></b>
                                        </span>
                                        <!--END ------------------------------ middleName TextBox  -------------------------------------------END -->


                                        <!--START ------------------------------ birthDate TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <input name="birthDate" value="<?php echo $this->session->flashdata('birthDate'); ?>" type="text" class="form-control" id="birthDate" placeholder="Birth Date (yyyy-mm-dd)" data-validation="date" data-validation-error-msg="Please enter valid date (yyyy-mm-dd)" data-validation-error-msg-container="#messageValidationLocationBirthDate" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationBirthDate"></b>
                                        </span>
                                        <!--END ------------------------------ birthDate TextBox  -------------------------------------------END -->


                                       <!-- <div class="form-group row">
                                            <div class="col-sm-5">
                                            <input name="studentNumber" value="<?php echo $this->session->flashdata('studentNumber'); ?>" type="text" class="form-control" id="studentNumber" placeholder="Student Number" data-validation="number" data-validation-allowing="-" data-validation-error-msg="Please enter valid Student Number" data-validation-error-msg-container="#messageValidationLocationStudentNumber" >
                                            <span>
                                                <b class="jQueryFormValidationMessage" id="messageValidationLocationStudentNumber"></b>
                                            </span>
                                            </div>
                                            <div class="col-sm-5">
                                            <input name="birthDate" value="<?php echo $this->session->flashdata('birthDate'); ?>" type="text" class="form-control" id="birthDate" placeholder="Birth Date (yyyy-mm-dd)" data-validation="date" data-validation-error-msg="Please enter valid date (yyyy-mm-dd)" data-validation-error-msg-container="#messageValidationLocationBirthDate" >
                                            <span>
                                                <b class="jQueryFormValidationMessage" id="messageValidationLocationBirthDate"></b>
                                            </span>
                                            </div>
                                        </div>-->


                                </div><!--<div class="col-lg-12 justify-content-center align-items-center">-->
                </div><!--<div class="col-lg-6 col-md-12 ">-->
                <div class="col-lg-6 col-md-12"  >
                                    <div class="row-space-25" ></div>
                                    <div class="input-group col-md-10 input-group-md" >
                                        <input name="userCategory" value="S" type="radio" id="student" ><label id="radio-label">Student/Alumni</label>
                                        <input name="userCategory" value="E" type="radio" id="employee"><label id="radio-label">Employee</label>
                                        <input name="userCategory" value="G" type="radio" id="guest"><label id="radio-label">Guest</label>
                                        <input type="hidden" id="selected-radio" value="<?php echo $this->session->flashdata('userCategory'); ?>">
                                        <input type="hidden" id="email-sent" value="<?php echo $this->session->flashdata('emailSent'); ?>">
                                    </div>

                                    <div id="student-input">

                                        <!--START ------------------------------ studentNumber TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <input name="studentNumber" value="<?php echo $this->session->flashdata('studentNumber'); ?>" type="text" class="form-control" id="studentNumber" placeholder="Student Number" data-validation="number" data-validation-allowing="-" data-validation-error-msg="Please enter valid Student Number" data-validation-error-msg-container="#messageValidationLocationStudentNumber" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationStudentNumber"></b>
                                        </span>
                                        <!--END ------------------------------ studentNumber TextBox  -------------------------------------------END -->

                                        <!--START ------------------------------ birthPlaceS TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <input name="birthPlaceS" value="<?php echo $this->session->flashdata('birthPlaceS'); ?>" type="text" class="form-control" id="birthPlaceS" placeholder="Birth Place" data-validation="alphanumeric" data-validation-allowing=" .,-ñÑ" data-validation-error-msg="Please enter valid Birth Place" data-validation-error-msg-container="#messageValidationBirthPlaceS" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationBirthPlaceS"></b>
                                        </span>
                                        <!--START ------------------------------ birthPlaceS TextBox  -------------------------------------------START -->
										
										
										
                                        <!--START ------------------------------ studentAddress TextBox  -------------------------------------------START -->
                                        <!--<div class="input-group col-md-10 input-group-md">
                                            <textarea name="cityAddress" rows="3" cols="50" placeholder="City Address"><?php echo $this->session->flashdata('cityAddress'); ?></textarea>

                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationCityAddress"></b>
                                        </span>-->
                                        <!--END ------------------------------ studentAddress TextBox  -------------------------------------------END -->

                                        <!--START ------------------------------ mobileNumberS TextBox  -------------------------------------------START -->
                                        <!--<div class="input-group col-md-10 input-group-md">
                                            <input name="mobileNumberS" value="<?php echo $this->session->flashdata('mobileNumberS'); ?>" type="text" class="form-control" id="mobileNumberS" placeholder="Mobile Number" data-validation="alphanumeric" data-validation-allowing="- " data-validation-error-msg="Please enter valid Mobile Number" data-validation-error-msg-container="#messageValidationLocationMobileNumberS" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationMobileNumberS"></b>
                                        </span>-->
                                        <!--END ------------------------------ mobileNumberS TextBox  -------------------------------------------END -->

                                        <!--START ------------------------------ guardianName TextBox  -------------------------------------------START -->
                                        <!--<div class="input-group col-md-10 input-group-md">
                                            <input name="guardianName" value="<?php echo $this->session->flashdata('guardianName'); ?>" type="text" class="form-control" id="guardianName" placeholder="Guardian Name" data-validation="alphanumeric" data-validation-allowing=" " data-validation-error-msg="Please enter Guardian Name" data-validation-error-msg-container="#messageValidationLocationGuardianName" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationGuardianName"></b>
                                        </span>-->
                                        <!--END ------------------------------ mobileNumberS TextBox  -------------------------------------------END -->
										<a href="javascript:window.open('consentformstudent','student consent form','width=1200,height=800')">Clik this link to open Student Consent Form</a>
										
								
                                    </div>

                                    <div id="employee-input">
                                        <!--START ------------------------------ employeeNumber TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <input name="employeeNumber" value="<?php echo $this->session->flashdata('employeeNumber'); ?>" type="text" class="form-control" id="employeeNumber" placeholder="Employee Number" data-validation="number" data-validation-allowing="-" data-validation-error-msg="Please enter valid Employee Number" data-validation-error-msg-container="#messageValidationLocationEmployeeNumber" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationEmployeeNumber"></b>
                                        </span>
                                        <!--END ------------------------------ employeeNumber TextBox  -------------------------------------------END -->

                                        <!--START ------------------------------ employeeAddress TextBox  -------------------------------------------START -->
                                        <!--<div class="input-group col-md-10 input-group-md">-->
                                        <!-- <input name="presentAddress" value="<?php echo $this->session->flashdata('presentAddress'); ?>" type="text" class="form-control" id="presentAddress" placeholder="Present Address" data-validation="alphanuemric" data-validation-allowing="-.#" data-validation-error-msg="Please enter valid Address" data-validation-error-msg-container="#messageValidationLocationPresentAddress" >-->
                                           <!-- <textarea name="cityStreet" rows="3" cols="50" placeholder="City Street"><?php echo $this->session->flashdata('cityStreet'); ?></textarea>
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationCityStreet"></b>
                                        </span>
                                        <!--END ------------------------------ employeeAddress TextBox  -------------------------------------------END -->

                                        <!--START ------------------------------ mobileNumberE TextBox  -------------------------------------------START -->
                                        <!--<div class="input-group col-md-10 input-group-md">
                                            <input name="mobileNumberE" value="<?php echo $this->session->flashdata('mobileNumberE'); ?>" type="text" class="form-control" id="mobileNumberE" placeholder="Mobile Number" data-validation="alphanumeric" data-validation-allowing="- " data-validation-error-msg="Please enter valid Mobile Number" data-validation-error-msg-container="#messageValidationLocationMobileNumberE" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationMobileNumberE"></b>
                                        </span>-->
                                        <!--END ------------------------------ mobileNumberE TextBox  -------------------------------------------END -->
                                        
                                        <!--START ------------------------------ TIN TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <input name="TIN" value="<?php echo $this->session->flashdata('TIN'); ?>" type="text" class="form-control" id="TIN" placeholder="TIN" data-validation="alphanumeric" data-validation-allowing="-" data-validation-error-msg="Please enter valid TIN" data-validation-error-msg-container="#messageValidationLocationTIN" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationTIN"></b>
                                        </span>
                                        <!--END ------------------------------ TIN TextBox  -------------------------------------------END -->
										<a href="javascript:window.open('consentformemployee','employee consent form','width=1200,height=800')">Clik this link to open Employee Consent Form</a>
										
                                    </div>

                                    <div id="guest-input">

                                        <!--START ------------------------------ presentAddressG TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                        <!-- <input name="presentAddress" value="<?php echo $this->session->flashdata('presentAddress'); ?>" type="text" class="form-control" id="presentAddress" placeholder="Present Address" data-validation="alphanuemric" data-validation-allowing="-.#" data-validation-error-msg="Please enter valid Address" data-validation-error-msg-container="#messageValidationLocationPresentAddress" >-->
                                            <textarea name="presentAddressG" rows="3" cols="50" placeholder="Present Address"><?php echo $this->session->flashdata('presentAddressG'); ?></textarea>
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationPresentAddressG"></b>
                                        </span>
                                        <!--END ------------------------------ presentAddressG TextBox  -------------------------------------------END -->

                                        <!--START ------------------------------ mobileNumberG TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <input name="mobileNumberG" value="<?php echo $this->session->flashdata('mobileNumberG'); ?>" type="text" class="form-control" id="mobileNumberG" placeholder="Mobile Number" data-validation="alphanumeric" data-validation-allowing="- " data-validation-error-msg="Please enter valid Mobile Number" data-validation-error-msg-container="#messageValidationLocationMobileNumberG" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationMobileNumberG"></b>
                                        </span>
                                        <!--END ------------------------------ mobileNumberG TextBox  -------------------------------------------END -->


                                    </div>


                                    <!--START ------------------------------ signUp Button  -------------------------------------------START -->
									<input type='checkbox' onchange='handleChange(this);'>Yes, I have read and do understand the content and intention of the consent form.
                                    <div class="form-group col-lg-12 input-group-sm" >
                                        Back to <a href="<?php echo site_url();?>user-acct/sign-in">Sign In</a>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="submit" value='Sign up'  id="formButton" class='btn btn-lg btn-primary ' >
                                        
                                    </div>
                                    
                                    <!--END ------------------------------ signUp Button  -------------------------------------------END -->

                                    <!--END ------------------------------ registration FORM  -------------------------------------------END -->
                                    <?php
                                        if ($this->session->flashdata('msg')){ //change!
                                            echo "<div class='message'  >";
                                            echo "<em id='error-messages'>" . $this->session->flashdata('msg') . "</em>";
                                            echo "</div>";
                                        }
                                    ?>


                </div>
			
				
            </div><!--<div class="row border form-panel">-->
</div> <!--<div class="col-8 ">-->




<div class="col-2" ></div>
<div class="col-12 row-space-25" ></div>
                               
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-3.3.1.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script>

function handleChange(checkbox) {
    if(checkbox.checked == true){
        $("#formButton").removeAttr('disabled');
    }else{
        $("#formButton").attr('disabled', 'disabled');
   }
}

  var modal = document.getElementById('myModal');
  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];
                                        
  $.validate({
    language : 'es',
  });

  function checkUserAvailability() {
    $("#iconLoader").show();
    jQuery.ajax({
      url: "check-user",
      data:'userName='+$("#userName").val(),
      type: "POST",
      success:function(data){
      if(data == 0) {
        $("#messageNotAvailable").hide();
        console.log($("#userName").val().length);
        $("#messageAvailable").show();
        $("#iconAvailable").show();
        $("#iconLoader").hide();
        $("#iconNotAvailable").hide();
        //$("#formButton").removeAttr('disabled');
      } else {
        $("#messageAvailable").hide();
        $("#messageNotAvailable").show();
        $("#iconLoader").hide();
        $("#iconAvailable").hide();
        $("#iconNotAvailable").show();
        //$("#formButton").attr('disabled', 'disabled');
      }
    },
        error:function (){}
    });
  }


  function clearValidationMessages() {
    $("#messageNotAvailable").hide();
    $("#messageAvailable").hide();
    $("#iconAvailable").hide();
    $("#iconNotAvailable").hide();
  }

  function createToken() {
  }


  $(document).ready(function(){
	 $("#formButton").attr('disabled', 'disabled');
  
    if($("#email-sent").val() == '1') {
        // Get the modal
        modal.style.display = "block";
    }

    selectedOption = $("#selected-radio").val();
    selected = '#student';
    if(selectedOption == "E") {
        selected = '#employee';
        $("div#guest-input").hide();
        $("div#student-input").hide();
        $("div#employee-input").show();

    } else if(selectedOption == "S") {
        selected = '#student';
        $("div#employee-input").hide();
        $("div#guest-input").hide();
        $("div#student-input").show();

    } else if(selectedOption == "G") {
        selected = '#guest';
        $("div#employee-input").hide();
        $("div#student-input").hide();
        $("div#guest-input").show();
    }

    $(selected).prop('checked', true).trigger('change');

    $('input[name="userCategory"]').change(function(){

        if($('#student').prop('checked')){
            $("div#employee-input").hide();
            $("div#guest-input").hide();
            $("div#student-input").show();
        }else if($('#employee').prop('checked')){
            $("div#guest-input").hide();
            $("div#student-input").hide();
            $("div#employee-input").show();
        }else{
            $("div#employee-input").hide();
            $("div#student-input").hide();
            $("div#guest-input").show();
        }
    });
});


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

    <div class="col-12  p-10">
        <div class="footer">
			<div class="social-media">
				Social Media Accounts:
				<br /> 	&nbsp; &nbsp;
				<a href="https://www.facebook.com" target="_blank"> <img src="<?php echo base_url();?>assets/images/facebook-logo.png"></img></a>
				<a href="https://www.twitter.com" target="_blank"> <img src="<?php echo base_url();?>assets/images/twitter-logo.png"></img></a>
			</div>
		
		
            Copyright © <?php echo $_SESSION['organizationName']; ?>. 
            All rights reserved.
            <br />
            <p>
                <em>ADDRESS: </em>
                <?php echo $_SESSION['organizationAddress']; ?> 
                <br />
                <em>TEL. NO.: </em>
                <?php echo $_SESSION['organizationContactNumber']; ?>
                <em>WEBSITE: </em>
                <?php echo $_SESSION['organizationalWebSite']; ?>
            </p>
        </div><!-- <div class="footer">-->
    </div><!--<div class="col-12  p-10">-->
</div> <!--<div class="row">-->

<?php echo form_close(); ?>

</body>