
    <div class="col-12 row-space-100" ></div>

    <div class="col-2"></div>
    <div class="col-8 ">
                <div class="row border form-panel">
                    <div class="col-lg-6 col-md-12 form-panel-left" style="background-image: url('<?php echo base_url();?>assets/images/system-logo.png');" ></div>
                    <div class="col-lg-6 col-md-12 ">
                        <div class="col-lg-12">
                            <h2>Congratulations! <?php echo $_SESSION['userName'];?></h2>
                            <br />
                            <h3>You are now successfully signed-up.</h3>
                            <br />
                            <h4>Click  <a href="<?php echo site_url();?>user-acct/sign-in">Sign In</a>  to begin using the application.</h4>
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