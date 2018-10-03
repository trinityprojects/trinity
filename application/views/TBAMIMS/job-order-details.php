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

            <div class="panel-title" > JOB ORDER DETAILS: </div>
            <div class="row-header">
                <div class="col-20" >
                    <label class="panel-label">Request Number: </label>
                    <div class="panel-detail">#<?php echo $requestNumber?></div>
                </div>
                <div class="col-20">
                    <label class="panel-label">Job Order Number: </label>
                    <div class="panel-detail">#<?php echo $jobOrderNumber?> </div>
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
                    <label class="panel-label">Worker Name: </label>
                    <div class="panel-detail"><?php echo $workerName;?></div>
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
                    <div class="panel-detail"><?php echo $dateNeeded . " (" . $projectDuration . " days)";?></div>
                </div>
                <div class="col-20" >
                    <label class="panel-label">Start Planned Date: </label>
                    <div class="panel-detail"><?php echo $startDatePlanned;?></div>
                </div>
                <div class="col-30">
                    <label class="panel-label">Completion Target Date: </label>
                    <div class="panel-detail"><?php echo $completionDateTarget  . " (" . $jobOrderDuration . " days)";?></div>
                </div>


            </div>


            <div class="row-details">
                <div class="col-20" >
                    <label class="panel-label"> .</label>
                    <div class="panel-detail">.</div>
                </div>
                <div class="col-30">
                    <label class="panel-label">Date Closed: </label>
                    <div class="panel-detail"><?php echo $dateClosed . " (" . $projectDurationActual . " days)";?></div>
                </div>
                <div class="col-20" >
                    <label class="panel-label">: </label>
                    <div class="panel-detail"></div>
                </div>
                <div class="col-30">
                    <label class="panel-label">Date Completed: </label>
                    <div class="panel-detail"><?php echo $dateCompleted  . " (" . $jobOrderDurationActual . " days)";?></div>
                </div>


            </div>

            <div class="row-details">
                <div class="col-70" >
                    <label class="panel-label">Job Description: </label>
                    <div class="panel-detail"><?php echo $jobDescription;?></div>
                </div>
                <div class="col-30" >
					<div class="panel-detail">
						<a href="javascript:void(0)" class="link-btn" onclick="ViewJobOrder.render('<?php echo $requestNumber?>','<?php echo $jobOrderNumber; ?>','W')" style="width:80px">View Job Order</a>
					</div>
                </div>
			</div>
			
    </div>


    <script type="text/javascript">
   function CustomViewJobOrder(){
        this.render = function(requestNumber,jobOrderNumber,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay-long');
            var dialogbox = document.getElementById('dialogbox-long');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1500 * .5)+"px";
            dialogbox.style.top = "50px";
            dialogbox.style.display = "block";

            jQuery.ajax({
                url: "TBAMIMS/showJobOrderTBAMIMS",
                data: {
                    'jobOrderNumber':jobOrderNumber,
                    'requestNumber':requestNumber,
					
                },
                type: "POST",
                success:function(data){
                    console.log(data);
		            var winHeight = window.innerHeight;

					$('#dialogboxbody-long').html('<iframe style="width:100%; height:'+(winHeight-200)+'px" src="<?php echo base_url();?>assets/pdf/jobOrder'+requestNumber+'.pdf"></iframe>');
                },
                error:function (){}
            }); //jQuery.ajax({


            document.getElementById('dialogboxhead-long').innerHTML = 'View PDF... <button onclick="ViewJobOrder.no()">Close</button>';
            //document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot-long').innerHTML = '<button onclick="ViewJobOrder.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox-long').style.display = "none";
            document.getElementById('dialogoverlay-long').style.display = "none";
        }

    }
    var ViewJobOrder = new CustomViewJobOrder();
    </script>

</div>

