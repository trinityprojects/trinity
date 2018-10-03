	<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-3.3.1.min.js"></script>

        <!-- The Modal -->
    <div class="col-12 row-space-100" ></div>

    <div class="col-2"></div>
    <div class="col-8 ">

	    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
            <h4>Trinity Portal Emailer</h4>

            <span class="close">&times;</span>
            </div>
            <div class="modal-body">
            <p>A verification link was sent to your email address (<?php echo $this->session->flashdata('emailAddress'); ?>).</p>
            <p>Kindly login to your email and perform this step to update your password.</p>
            </div>
	            <div class="modal-footer">
            <h4>Please update in your email.</h4>
            </div>
        </div>

        </div>

                <div class="row border form-panel">
                    <div class="col-lg-6 col-md-12 form-panel-left" style="background-image: url('<?php echo base_url();?>assets/images/trinity-logo.png');" ></div>
                    <div class="col-lg-6 col-md-12 ">
											<br />
                                    <div class="col-lg-12 justify-content-center align-items-center">
                                        <div class="col-lg-12">
                                            <h3><em id="capitalize">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $_SESSION['organizationalAppName'];?></em></h3>
                                            <?php $fattr = array('class' => 'form-signin');
                                                echo form_open(site_url().'user-acct/sign-in-process/', $fattr); ?>
                                            <div class="form-group">
                                            <?php echo form_input(array(
                                                'name'=>'userName',
                                                'id'=> 'userName',
                                                'placeholder'=>'User Name',
                                                'class'=>'form-control',
                                                'value'=> set_value('userName'))); ?>
                                            <?php echo form_error('userName') ?>
                                            </div>
                                            <div class="form-group">
                                            <?php echo form_password(array(
                                                'name'=>'password',
                                                'id'=> 'password',
                                                'placeholder'=>'Password',
                                                'class'=>'form-control',
                                                'value'=> set_value('password'))); ?>
                                            <?php echo form_error('password') ?>
                                            </div>
                                            <?php echo form_submit(array('value'=>'LOGIN', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
                                            <?php echo form_close(); ?>
																						<br />
                                            <p>Don't have an account? Register <a href="<?php echo site_url();?>user-acct/sign-up">here.</a></p>
                                            <p><a href="<?php echo site_url();?>user-acct/forgot-password">Forgot your password?</a></p>
											<input type="hidden" id="email-sent" value="<?php echo $this->session->flashdata('emailSent'); ?>">
                                        </div>

                                        <div id="system-message">
                                            <?php
                                                if ($this->session->flashdata('msg')){ //change!
                                                    echo "<div class='message' style='color:red'>";
                                                    echo $this->session->flashdata('msg');
                                                    echo "</div>";
                                                }
                                            ?>
                                        </div> <!-- <div id="system-message">-->
                                    </div><!--<div class="col-lg-12 justify-content-center align-items-center">-->
                    </div><!--<div class="col-lg-6 col-md-12 ">-->
                </div><!--<div class="row border form-panel">-->
    </div> <!--<div class="col-8 ">-->
    <div class="col-2" > </div>

    <div class="col-12 row-space-100"></div>

		<!-- added footer by Laudit, Prime -->
		<div class="col-12  p-10">
				<div class="footer">
						<div class="social-media">
						Social Media Accounts:
						<br /> 	&nbsp; &nbsp;
						<a href="https://www.facebook.com" target="_blank"> <img src="../assets/images/facebook-logo.png" target="_blank"></img></a>
						<a href="https://www.twitter.com" target="_blank"> <img src="../assets/images/twitter-logo.png" target="_blank"></img></a>
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
		<!-- added footer by Laudit, Prime -->

	<script>
	  var modal = document.getElementById('myModal');
	  // Get the <span> element that closes the modal
	  var span = document.getElementsByClassName("close")[0];
	  $(document).ready(function(){

		if($("#email-sent").val() == '1') {
			// Get the modal
			modal.style.display = "block";
		}
	  });
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}
	</script>
