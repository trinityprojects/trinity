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

            <div class="panel-title"> MY ACCOUNT: </div>
            <div class="row-header">
                <div class="col-20">
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

			
    </div>


    <script type="text/javascript">
   function DialogResetUserName(){
        this.render = function(id){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay-long');
            var dialogbox = document.getElementById('dialogbox-long');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1500 * .5)+"px";
            dialogbox.style.top = "50px";
            dialogbox.style.display = "block";

			var userName = $('#updatedUserName').val();
			
            var dialog = "<div>";
            dialog = dialog + "<div><b>New User Number: </b></div>";
            dialog = dialog + "<div><u>" + userName + "</u> ..... <b> The Default Password is student number</div>";
            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead-long').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody-long').innerHTML = dialog;
            document.getElementById('dialogboxfoot-long').innerHTML = '<button onclick="ResetUserName.yes(\''+id+'\',\''+userName+'\')">Proceed</button> <button onclick="ResetUserName.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox-long').style.display = "none";
            document.getElementById('dialogoverlay-long').style.display = "none";
        }
        this.yes = function(id,userNumber){
                resetUserName(id,userName);
            document.getElementById('dialogbox-long').style.display = "none";
            document.getElementById('dialogoverlay-long').style.display = "none";
        }

    }
    var ResetUserName = new DialogResetUserName();
	
	
	
	function resetUserName(id,userName) {
	
		jQuery.ajax({
			url: 'resetPassword',
			data: { 
				'ID': id,
				'userName': userName
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
	
	
	function displayUpdateBox() {
		$('.message-update').show();
		$('#add-update').hide();
	}


	function hideUpdateBox() {
		$('.message-update').hide();
		$('#add-update').show();
	}
	
    </script>

</div>

