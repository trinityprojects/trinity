<div class="level2" style="width:100%;max-width:100%;height:200px;">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/building/tbamims.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />
 
		<div id="dialogoverlay-long"></div>
            <div id="dialogbox-long">
            <div>
                <div id="dialogboxhead-long"></div>
                <div id="dialogboxbody-long"></div>
                <div id="dialogboxfoot-long"></div>
            </div>
        </div>

        <div class="panel-group" >                    

            <div class="panel-title" > USER DETAILS: </div>
            <div class="row-header">
                <div class="col-20" >
                    <label class="panel-label">User Name: </label>
                    <div class="panel-detail"><?php echo $userName?></div>
                </div>
                <div class="col-20">
                    <label class="panel-label">User Number: </label>
                    <div class="panel-detail"><?php echo $userNumber?> </div>
                </div>
                <div class="col-60">
                    <label class="panel-label">Full Name: </label>
                    <div class="panel-detail"><?php echo $fullName?></div>
                </div>
            </div>
            <div class="row-details">
                <div class="col-50" >
                    <label class="panel-label">Email Address: </label>
                    <div class="panel-detail"><?php echo $emailAddress;?></div>
                </div>
                <div class="col-50">
                    <label class="panel-label">Group: </label>
                    <div class="panel-detail"><?php echo $companyNameUser;?></div>
                </div>

            </div>

            <div class="row-details">
                <div  >
					<div class="panel-detail">
						<a href="javascript:void(0)" class="link-btn" onclick="ResetPassword.render('<?php echo $ID?>', '<?php echo $userNumber?>')" style="width:80px">RESET PASSWORD</a>
					</div>
                </div>
			</div>
			
    </div>


    <script type="text/javascript">
   function DialogResetPassword(){
        this.render = function(id, userNumber){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay-long');
            var dialogbox = document.getElementById('dialogbox-long');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1500 * .5)+"px";
            dialogbox.style.top = "50px";
            dialogbox.style.display = "block";

            var dialog = "<div>";
            dialog = dialog + "<div><b>User Number: </b></div>";
            dialog = dialog + "<div><u>" + userNumber + "</u> ..... <b> The Default Password is student number</div>";
            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead-long').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody-long').innerHTML = dialog;
            document.getElementById('dialogboxfoot-long').innerHTML = '<button onclick="ResetPassword.yes(\''+id+'\',\''+userNumber+'\')">Proceed</button> <button onclick="ResetPassword.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox-long').style.display = "none";
            document.getElementById('dialogoverlay-long').style.display = "none";
        }
        this.yes = function(id,userNumber){
                resetPassword(id,userNumber);
            document.getElementById('dialogbox-long').style.display = "none";
            document.getElementById('dialogoverlay-long').style.display = "none";
        }

    }
    var ResetPassword = new DialogResetPassword();
	
	
	
	function resetPassword(id,userNumber) {
	
		jQuery.ajax({
			url: 'resetPassword',
			data: { 
				'ID': id,
				'userNumber': userNumber
			},
			type: "POST",
			success: function(response) {
				var resultValue = $.parseJSON(response);
				$('div.level2').remove();

				$('.leveltwocontent').html(resultValue['successMessage']);
		
				console.log("the request is successful for content1!");
			},
						
			error: function(error) {
				console.log('the page was NOT loaded', error);
				$('.leveltwocontent').html(error);
			},
						
			complete: function(xhr, status) {
				console.log("The request is complete!");
			}
		}); //jQuery.ajax({		
		
	}
    </script>

</div>

