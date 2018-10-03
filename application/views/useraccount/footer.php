
    <div class="col-12  p-10">
	
        <div class="footer">
		
						<div class="social-media">
						Social Media Accounts:
						<br /> 	&nbsp; &nbsp;
						<a href="https://www.facebook.com" target="_blank"> <img src="<?php echo base_url();?>assets/images/facebook-logo.png" target="_blank"></img></a>
						<a href="https://www.twitter.com" target="_blank"> <img src="<?php echo base_url();?>assets/images/twitter-logo.png" target="_blank"></img></a>
						</div>
		
            Copyright Â© 
			<?php
				if(!empty($_SESSION['organizationName'])) {	
				echo $_SESSION['organizationName']; 
				}
			?>. 
            All rights reserved.
            <br />
            <p>
                <em>ADDRESS: </em>
                <?php 
				if(!empty($_SESSION['organizationAddress'])) {	
					echo $_SESSION['organizationAddress']; 
				}
				?> 
                <br />
                <em>TEL. NO.: </em>
                <?php
				if(!empty($_SESSION['organizationContactNumber'])) {	
					echo $_SESSION['organizationContactNumber'];
				}
				?>
                <em>WEBSITE: </em>
                <?php
				if(!empty($_SESSION['organizationalWebSite'])) {	
				echo $_SESSION['organizationalWebSite']; 
				}
				?>
            </p>
        </div><!-- <div class="footer">-->
    </div><!--<div class="col-12  p-10">-->
</div> <!--<div class="row">-->
</body>