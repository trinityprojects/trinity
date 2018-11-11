<div class="level2" style="width:100%;max-width:100%;height:200px;">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/building/tbamims.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />
 
		<div id="dialogoverlay"></div>
            <div id="dialogbox">
            <div>
                <div id="dialogboxhead"></div>
                <div id="dialogboxbody"></div>
                <div id="dialogboxfoot"></div>
            </div>
        </div>

        <div class="panel-group" >                    

            <div class="panel-title" > NOTIFICATION DETAILS: </div>
            <div class="row-header">
                <div class="col-20" >
                    <label class="panel-label">Request Number: </label>
                    <div class="panel-detail">#<?php echo $requestNumber?></div>
                </div>
                <div class="col-20">
                    <label class="panel-label">Request Status: </label>
                    <div class="panel-detail">#<?php echo $requestStatusDescription?> </div>
                </div>
                <div class="col-60">
                    <label class="panel-label">Project Title: </label>
                    <div class="panel-detail"><?php echo $projectTitle?></div>
                </div>
            </div>
            <div class="row-details">
                <div class="col-50" >
                    <label class="panel-label">Location: </label>
                    <div class="panel-detail"><?php echo $locationCode . " " . $floor . " " . $roomNumber;?></div>
                </div>
                <div class="col-50">
                    <label class="panel-label">Requestor: </label>
                    <div class="panel-detail"><?php echo $fullName . " (" . $userName . ")";?></div>
                </div>

            </div>
            <div class="row-details">
                <div class="col-50" >
                    <label class="panel-label">Project Justification: </label>
                    <div class="panel-detail"><?php echo $projectJustification;?></div>
                </div>
                <div class="col-50">
                    <label class="panel-label">Scope of Works: </label>
                    <div class="panel-detail"><?php echo $scopeOfWorks;?></div>
                </div>

            </div>

            <div class="row-details">
                <div class="col-20" >
                    <label class="panel-label">Date Created: </label>
                    <div class="panel-detail"><?php echo $dateCreated;?></div>
                </div>
                <div class="col-30">
                    <label class="panel-label">Date Needed: </label>
                    <div class="panel-detail"><?php echo $dateNeeded ;?></div>
                </div>
                <div class="col-20" >
                    <label class="panel-label"> .</label>
                    <div class="panel-detail">.</div>
                </div>
                <div class="col-30">
                    <label class="panel-label">.</label>
                    <div class="panel-detail">.</div>
                </div>


            </div>



            <div class="row-details">
                <div class="col-70" >
                    <label class="panel-label">Special Instructions: </label>
					<br>
					<div class="panel-detail">
					</div>


					<?php if(!empty($specialInstructions)) {?>
						<?php foreach($specialInstructions as $row) {?>
							<div class="panel-detail" id="message">
								<span id="message-author"><?php echo "(" . $row->updatedBy .") ";?></span>
								<span id="message-detail"><?php echo $row->specialInstructions;?></span>
							</div> 
						<?php } ?>
					<?php } ?>
					
					
					
					<div id="add-instruction" onclick="displayInstructionBox();"><span id="basic-btn">Add Special Instruction</span></div>
					<div class="panel-detail message-instruction" id="message" > 
						<span id="message-author" onclick="hideInstructionBox();"><?php echo "(" .$userName . ") "; ?></span>
						<textarea  style="background-color: white;" id="specialInstructions" data-autoresize rows="1" class="autoExpand"></textarea>
							<a href="javascript:void(0)" class="link-btn" onclick="SetNotification.render('Request #<?php echo $requestNumber?> New',<?php echo $requestNumber?>,'E')" style="width:80px">Notify</a>
					</div> 
						
                </div>                
				<div class="col-30" >
                    <label class="panel-label">.</label>
                    <div class="panel-detail">.</div>

                </div>
			</div>
			
    </div>


    <script type="text/javascript">
	
    $(document).ready(function() {
		
		$('.message-instruction').hide();
	});

	function displayInstructionBox() {
		$('.message-instruction').show();
		$('#add-instruction').hide();
	}

	function hideInstructionBox() {
		$('.message-instruction').hide();
		$('#add-instruction').show();
	}	
	
    function CustomSetNotification(){
        this.render = function(dialog,requestNumber,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var specialInstructions = $('#specialInstructions').val();
			
            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Request ID: </b></div>";
            dialog = dialog + "<div><u>" + requestNumber + "</u></div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "</div>";

			var button = '';
			//alert(op + ' ' + status);
			if(specialInstructions == '') {
				button = 'Please put your instruction... </button> <button onclick="SetNotification.no()">Close</button>';				
			} else {
				button = '<button onclick="SetNotification.yes(\''+requestNumber+'\',\''+status+'\',\''+specialInstructions+'\')">Proceed</button> <button onclick="SetNotification.no()">Close</button>';				
			}

            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = button;
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(requestNumber,status, specialInstructions){
                setupNotification(requestNumber, status, specialInstructions);
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var SetNotification = new CustomSetNotification();

    function setupNotification(requestNumber, status, specialInstructions) {
			
			jQuery.ajax({
                url: "setupNotificationTBAMIMS",
                data: {
                    'requestNumber':requestNumber,
                    'requestStatus': status,
                    'specialInstructions':specialInstructions,
					'ID': <?php echo $ID; ?>
				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#tt').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }
    </script>

</div>

