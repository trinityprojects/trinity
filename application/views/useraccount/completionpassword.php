
    <div class="col-12 row-space-100" ></div>

    <div class="col-2"></div>
    <div class="col-8 ">
                <div class="row border form-panel">
                    <div class="col-lg-6 col-md-12 form-panel-left" style="background-image: url('<?php echo base_url();?>assets/images/system-logo.png');" ></div>
                    <div class="col-lg-6 col-md-12 ">
                        <div class="col-lg-12">
                            <h2>Almost Complete!</h2>
                            <h5>Hello <span><?php echo $firstName; ?></span>. Your username is <span><?php echo $userName;?></span></h5>
                            <small>Please enter a password to begin using the App.</small>
                        <?php 
                            $fattr = array('class' => 'form-signin');
                            echo form_open(site_url().'trinityAuth/complete/token/'.$token, $fattr); 
                        ?>


                            <!--START ------------------------------ password TextBox  -------------------------------------------START -->
                            <div class="input-group col-md-10 input-group-md">
                                <div class="input-group-prepend">
                                        <div class="input-group-text bg-transparent">
                                        <i class="fa fa-key" style="color: darkgreen"></i>
                                        </div>
                                </div>
                                <input name="password" type="password"  data-validation="strength" data-validation-strength="2" placeholder='Password' class='form-control'  data-validation-error-msg="Please enter a valid Password" data-validation-error-msg-container="#messageValidationLocationPassword"  >
                            </div>
                            <span>
                            <b class="jQueryFormValidationMessage" id="messageValidationLocationPassword"></b>
                            </span>
                            <!--END ------------------------------ password TextBox  -------------------------------------------END -->

                            <!--START ------------------------------ passwordConfirmation TextBox  -------------------------------------------START -->
                            <div class="input-group col-md-10 input-group-md">
                                <div class="input-group-prepend">
                                        <div class="input-group-text bg-transparent">
                                        <i class="fa fa-redo" style="color: darkgreen"></i>
                                        </div>
                                </div>
                                <input name="passwordConfirmation" type="password"  data-validation="confirmation" data-validation-confirm="password" placeholder='Confirm Password' class='form-control'  data-validation-error-msg="Please enter a matching  Password" data-validation-error-msg-container="#messageValidationLocationConfirmPassword"  >
                            </div>
                            <span>
                            <b class="jQueryFormValidationMessage" id="messageValidationLocationConfirmPassword"></b>
                            </span>
                            <!--END ------------------------------ passwordConfirmation TextBox  -------------------------------------------END -->



                            <?php echo form_submit(array('value'=>'Complete', 'class'=>'btn btn-lg btn-primary btn-block')); ?>
                            <?php echo form_close(); ?>
    
                        </div>
                    </div><!--<div class="col-lg-6 col-md-12 ">-->
                </div><!--<div class="row border form-panel">-->
    </div> <!--<div class="col-8 ">-->
    <div class="col-2" > </div>

    <div class="col-12 row-space-100"></div>

<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-3.3.1.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
                                    
<script>
$.validate({
  modules : 'security',
  onModulesLoaded : function() {
    var optionalConfig = {
      fontSize: '12pt',
      padding: '10px',
      bad : 'Very bad',
      weak : 'Weak',
      good : 'Good',
      strong : 'Strong'
    };

    $('input[name="password"]').displayPasswordStrength(optionalConfig);
  }
});
</script>