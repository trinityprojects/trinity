<div class="job-order-form">
<?php if(empty($jobOrderExist)) { ?>


			<div>
				<h3>JOB ORDER </h3>
			</div>
			<div>
				<span>TO: (Name of Worker)
					<div class="request-status" id="autocomple-input" style="height: 38px">
						<input id="workerName"  type="text" name="workerName" placeholder="Worker Name"  size="50">
						<input id="workerID"  readonly class="workerID" type="hidden" name="workerID" size="5">
					</div>
				</span>
			</div>

			<div>
				<?php 
				$i = 1;
				foreach($jobDesc as $row) {
				?>
					<span style="width: 20%; float: left"> <input type="checkbox" id="job_desc<?php echo $i;?>" class="job_desc" value="<?php echo $row->jobDescCode;?>"/> <?php echo $row->jobDescDescription;?> </span>
					<?php if( ($i != 1) && ($i % 3 == 0)) {?>
						</br>
					<?php } ?>
				<?php 
				$i++;
				} 
				?>
			</div>
			<br>
			<div style="padding: 10px">
				<table id="datepicker" class="dp_calendar" style="display:none;font-size:14px;" cellpadding="0" cellspacing="0"></table>
				<span style="padding: 10px">
					Planned Start-Up Date:
					<input type="text" name="start_up_date" id="start_up_date" readonly>
					<a onclick="DP.open('start_up_date','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>
				
				<span style="padding: 10px">

					Target Completion Date:
					<input type="text" name="completion_date" id="completion_date" readonly>
					<a onclick="DP.open('completion_date','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>
				
				<span style="padding: 10px" id="duration_days">
					Duration: <input type='text' readonly id="duration_days_job_order" size='2' /> Days
				
				</span>
				
			</div>

			<div>
				<?php if($owner != 1) {?>
					<a href="javascript:void(0)" class="link-btn" onclick="ConfirmJobOrder.render('Create Job Order for Request #<?php echo $ID?>','crete_job_order','W')" style="width:80px">Create Job Order</a>
				<?php }?>
			</div>
				


			</div>

			<script class="dynamic" id="dynamic">
					var workerAutocomplete = new autoComplete({
						selector: '#workerName',

						minChars: 0,
						source: function(term, suggest){
							term = term.toLowerCase();
							var items = <?php echo $items; ?>;
							console.log(items);
							var choices = items;
							var suggestions = [];
							for (i=0;i<choices.length;i++)
								if (~(choices[i][0]).toLowerCase().indexOf(term)) suggestions.push(choices[i]);
									suggest(suggestions);
						},
						renderItem: function (item, search){
							search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&amp;');
							var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
							return '<div class="autocomplete-suggestion worker" worker-request-status="'+item[0]+'" worker-ID="'+item[1]+'">'+item[0].replace(re, "<b>$1</b>")+'</div>';

						},
						onSelect: function(e, term, item){
							console.log('Item "'+item.getAttribute('worker-request-status')+' ('+item.getAttribute('worker-units')+')" selected by '+(e.type == 'keydown' ? 'pressing enter' : 'mouse click')+'.');
							document.getElementById('workerName').value = item.getAttribute('worker-request-status');
							document.getElementById('workerID').value = item.getAttribute('worker-ID');

						}
					});

					$('#duration_days').click(function() { 
					
					
						var startDate = $('#start_up_date').val();
						var endDate = $('#completion_date').val();
						
						var tempStart = startDate.split("-");
						var tempEnd = endDate.split("-");
						
						var startYear = tempStart[0];
						var startMonth = tempStart[1];
						var startDay = tempStart[2];

						var endYear = tempEnd[0];
						var endMonth = tempEnd[1];
						var endDay = tempEnd[2];

						
						var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
						var firstDate = new Date(startYear,startMonth,startDay);
						var secondDate = new Date(endYear,endMonth,endDay);

						var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
						$('#duration_days_job_order').val(diffDays);
					});

			</script>
			
<?php } else { ?>
<span class="input_fields_wrap_jo"></span>
<div style="padding: 10px">	
	<div style="padding: 10px">
		<h3>JOB ORDER: #<?php echo $jobOrderNumber; ?> </h3>
	</div>
	<div style="padding: 10px">
		<span><u>TO: (Name of Worker): </u>	<b><?php echo $workerName; ?> </b></span>
	</div>

	<div style="padding: 10px">
		<span><u>Job Description: </br></u> 
		<b>
		<ul>
		<?php 
			$jd = explode(",",$jobDescription);
			$jdCount = count($jd);
			for($i = 0; $i < $jdCount; $i++) {
				echo "<li>" . $jd[$i] . "</li>";
			}
		?>
		</b>
		</ul>
		</span>
	</div>

	<div style="padding: 10px">
		<span ><u>Planned Start Date:</u> <b> <?php echo $startDatePlanned; ?> </b></span>
		<span style="padding: 10px"><u>Target End Date: </u> <b><?php echo $completionDateTarget; ?></b></span>
		<span style="padding: 10px"><u>Duration: </u> <b><?php echo $days; ?> days</b></span>
		
	</div>
	<div style="padding: 10px">
		<span ><u>Received Date:</u> <b> <?php echo $receivedDate; ?> </b></span>
		<span style="padding: 10px"><u>Start Date (Actual): </u> <b><?php echo $startDateActual; ?></b></span>
		<span style="padding: 10px"><u>End Date (Actual): </u> <b><?php echo $completedDateActual; ?> </b></span>
		<span style="padding: 10px"><u>Days (Actual): </u> <b><?php echo $daysActual; ?> days </b></span>
	</div>
	
	<?php if( ($requestStatus == 'W') && ($completedFlag == 'N') ) { ?>
			<br>
			<div style="padding: 10px">
				<table id="datepicker" class="dp_calendar" style="display:none;font-size:14px;" cellpadding="0" cellspacing="0"></table>
				<span style="padding: 10px">
					Received Date:
					<input type="text" name="received_date" id="received_date" readonly>
					<a onclick="DP.open('received_date','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>
				
				<span style="padding: 10px">

					Start Date (Actual):
					<input type="text" name="start_date_actual" id="start_date_actual" readonly>
					<a onclick="DP.open('start_date_actual','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>
			</div>
			<br>
			<div>
				<span style="padding: 10px" id="duration_days">
					<b>End Date (Actual) or Completion Date is triggered by the Job Completed button.</b>
				</span>
			</div>
	<?php } ?>
			
	<div style="padding: 10px">
		<?php if($owner != 1) {?>
			<?php if($requestStatus == 'W') { ?>
						<?php if($completedFlag == 'S') {?>
							<a href="javascript:void(0)" class="link-btn" onclick="CompletedJobOrder.render('<?php echo $ID?>','<?php echo $jobOrderNumber; ?>','C')" style="width:80px">Job Order Completed</a>
						<?php } ?>
			<?php } else { ?>
				<span style="padding: 10px"> <b>JOB IS FINISHED </b> </span>
			<?php } ?>
		<?php } ?>
		<a href="javascript:void(0)" class="link-btn" onclick="ViewJobOrder.render('<?php echo $ID?>','<?php echo $jobOrderNumber; ?>','W')" style="width:80px">View Job Order</a>

		<?php if($owner != 1) {?>
			<?php if( ($requestStatus == 'W') && ($completedFlag == 'N') ) { ?>
						<a href="javascript:void(0)" class="link-btn" onclick="StartJobOrder.render('<?php echo $ID?>','<?php echo $jobOrderNumber; ?>','W')" style="width:80px">Start Job Order</a>
			<?php } ?>
		<?php } ?>

		
	</div>

</div>	
	
	<script>
	
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



    function CustomCompletedJobOrder(){
        this.render = function(requestID,jo,status){
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
            var scopeDetails = $('#scopeDetails').val();
            var requestStatusRemarksID = $('#requestStatusRemarksID').val();
            var dialog = '';
	
            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Request #: " + requestID  + " for completion. With Job Order # " + jo + "</b></div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Scope Details: </b></div>";
            dialog = dialog + "<div><u>" + scopeDetails + "</u></div>";
            dialog = dialog + "<div><b>Status Remarks: </b></div>";
            dialog = dialog + "<div><u>" + requestStatusRemarksID + "</u></div>";

            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = '<button onclick="CompletedJobOrder.yes(\''+jo+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+scopeDetails+'\',\''+requestStatusRemarksID+'\')">Proceed</button> <button onclick="CompletedJobOrder.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(jo, status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID){
            updateRequestComplete(jo, status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID);
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var CompletedJobOrder = new CustomCompletedJobOrder();
	
	
	
	
    function updateRequestComplete(jo, status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID) {
            jQuery.ajax({
                url: "updateRequestTBAMIMS",
                data: {
                    'ID':requestID,
                    'jo':jo,
                    'requestStatus': status,
                    'specialInstructions': specialInstructions,  
                    'scopeDetails': scopeDetails, 
                    'requestStatusRemarksID': requestStatusRemarksID, 
                },
                type: "POST",
                success:function(data){
                    var resultValue = $.parseJSON(data);
                    console.log(data);
                    //console.log("hoy");
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#O').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#W').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#C').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }
	


    function CustomStartJobOrder(){
        this.render = function(requestID,jo, status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

			
			var startDateActual = $('#start_date_actual').val();
			var receivedDate = $('#received_date').val();
			
            var specialInstructions = $('#specialInstructions').val();
            var scopeDetails = $('#scopeDetails').val();
            var requestStatusRemarksID = $('#requestStatusRemarksID').val();
            var dialog = '';
	
            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Request #: " + requestID  + " for completion. With Job Order # " + jo + "</b></div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Scope Details: </b></div>";
            dialog = dialog + "<div><u>" + scopeDetails + "</u></div>";
            dialog = dialog + "<div><b>Status Remarks: </b></div>";
            dialog = dialog + "<div><u>" + requestStatusRemarksID + "</u></div>";

            dialog = dialog + "<div><b>Start Date (Actual): </b></div>";
            dialog = dialog + "<div><u>" + startDateActual + "</u></div>";

            dialog = dialog + "<div><b>Received Date: </b></div>";
            dialog = dialog + "<div><u>" + receivedDate + "</u></div>";

			
            dialog = dialog + "</div>";

			var proceed = 1;
			if (startDateActual == '' || receivedDate == '') {
				proceed = 0;
			}
			
			
            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
			
			if(proceed == 0) {
				document.getElementById('dialogboxfoot').innerHTML = '<button>Fill out Received Date and Start Date Actual please...</button> <button onclick="StartJobOrder.no()">Close</button>';
			} else {
				document.getElementById('dialogboxfoot').innerHTML = '<button onclick="StartJobOrder.yes(\''+jo+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+scopeDetails+'\',\''+requestStatusRemarksID+'\',\''+startDateActual+'\',\''+receivedDate+'\')">Proceed</button> <button onclick="StartJobOrder.no()">Close</button>';
			}
		}
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(jo, status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID, startDateActual, receivedDate ){
            updateRequestStart(jo, status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID, startDateActual, receivedDate);
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var StartJobOrder = new CustomStartJobOrder();


    function updateRequestStart(jo, status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID, startDateActual, receivedDate) {
            alert(status);
			jQuery.ajax({
                url: "updateJobOrderTBAMIMS",
                data: {
                    'ID':requestID,
                    'jo':jo,
                    'requestStatus': status,
                    'specialInstructions': specialInstructions,  
                    'scopeDetails': scopeDetails, 
                    'requestStatusRemarksID': requestStatusRemarksID, 
                    'startDateActual': startDateActual, 
                    'receivedDate': receivedDate, 
                },
                type: "POST",
                success:function(data){
                    var resultValue = $.parseJSON(data);
                    console.log(data);
                    //console.log("hoy");
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#O').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#W').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#C').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }
	
	
	
	</script>
	
	

<?php } ?>
			
</div>
