
    <div class="col-12 row-space-100" ></div>

    <div class="col-2"></div>
    <div class="col-8 ">
	

	
                <div class="row border form-panel">
                    <div class="col-lg-6 col-md-12 form-panel-left" style="background-image: url('<?php echo base_url();?>assets/images/system-logo.png');" ></div>
                    <div class="col-lg-6 col-md-12 ">
                                    <div class="col-lg-12 justify-content-center align-items-center">
                                        <div class="col-lg-12">
                                            <h3>Login to <em id="capitalize"><?php echo $_SESSION['organizationalAppName'];?></em></h3>
                                            <?php $fattr = array('class' => 'form-signin');
                                                echo form_open(site_url().'trinityAuth/resetPassword/token/'.$token); ?>
                                            <div class="form-group">
												<?php echo form_password(array('name'=>'password', 'id'=> 'password', 'placeholder'=>'Password', 'class'=>'form-control', 'value' => set_value('password'))); ?>
												<?php echo form_error('password') ?>
                                            </div>
                                            <div class="form-group">
												<?php echo form_password(array('name'=>'passwordConfirmation', 'id'=> 'passwordConfirmation', 'placeholder'=>'Confirm Password', 'class'=>'form-control', 'value'=> set_value('passwordConfirmation'))); ?>
												<?php echo form_error('passconf') ?>
                                            </div>
												<?php echo form_hidden('ID', $ID);?>
												<?php echo form_submit(array('value'=>'Reset Password', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
												<?php echo form_close(); ?>
                                            <p>Click <a href="<?php echo site_url();?>user-acct/sign-up">SignUp</a> to create your account.</p>
                                            <p><a href="<?php echo site_url();?>user-acct/forgot-password">Forgot password</a></p>
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





 