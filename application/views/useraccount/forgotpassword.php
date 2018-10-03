
    <div class="col-12 row-space-100" ></div>

    <div class="col-2"></div>
    <div class="col-8 ">
                <div class="row border form-panel">
                    <div class="col-lg-6 col-md-12 form-panel-left" style="background-image: url('<?php echo base_url();?>assets/images/system-logo.png');" ></div>
 
                    <div class="col-lg-6">
                    <!-- PAGE CONTENT BEGINS -->

                        <div class="col-lg-12">
                            <h2>Forgot Password</h2>
                            <p>Please enter your email address and we'll send you instructions on how to reset your password</p>
                            <?php $fattr = array('class' => 'form-signin');
                                echo form_open(site_url().'user-acct/forgot-password/', $fattr); ?>
                            <div class="form-group">
                            <?php echo form_input(array(
                                'name'=>'emailAddress', 
                                'id'=> 'emailAddress', 
                                'placeholder'=>'Email Address', 
                                'class'=>'form-control', 
                                'value'=> set_value('emailAddress'))); ?>
                            <?php echo form_error('emailAddress') ?>
                            </div>
                            <?php echo form_submit(array('value'=>'Submit', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
                            <?php echo form_close(); ?>    

                            <p>Click <a href="<?php echo site_url();?>user-acct/sign-up">SignUp</a> to create your account.</p>
                            <p>Back to <a href="<?php echo site_url();?>user-acct/sign-in">Sign In</a></p>
                            
                        </div>

                        <!-- PAGE CONTENT ENDS -->
                    
                        <div >
                            <?php
                                if ($this->session->flashdata('msg')){ //change!
                                    echo "<div class='message' style='color:red'>";
                                    echo $this->session->flashdata('msg');
                                    echo "</div>";
                                }
                            ?>
                        </div>
                    
                    </div><!-- /.col -->
                </div><!--<div class="row border form-panel">-->
    </div> <!--<div class="col-8 ">-->
    <div class="col-2" > </div>

    <div class="col-12 row-space-100"></div>

                                    
