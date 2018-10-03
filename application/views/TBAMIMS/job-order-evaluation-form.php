<div class="job-order-form">
<?php if(empty($answers)) { ?>


			<div>
				<h3>EVALUATION BY THE REQUESTING UNIT </h3>
			</div>
			
			<div style="padding: 10px; width: 75%">
			<?php 
				$x = 1;
				foreach($questions as $rowQ) {
			?>
				<div style="padding: 10px; width: 75%">
					<span><b><?php echo $x . '.0 ' . $rowQ->questionCategory; ?> </b>: 
					<?php echo $rowQ->questionCategoryDescription;?>
					</span>
				</div>

					<span>
					<div>
						<?php 
						
						foreach($selections as $rowS) {
							
							if($rowQ->ID == $rowS->questionCategoryID) {
						?>
							<span style="width: 20%; float: left">
							<input type="radio" name="<?php echo $rowQ->questionCategoryCode; ?>" id="job_desc" class="job_desc" value="<?php echo $rowS->selectionCode;?>"/> <?php echo $rowS->selectionDescription;?> </span>
						<?php 
							}
						} 
						?>
					</div>
					</span>
					<span style="width: 50%"> <input type="text" name="remarks[]" id="remarks" style="width: 50%" placeholder="REMARKS"/></span> 
					</br></br>
				
			<?php 
				$x++;
				} 
			?>
			</div>

			<div>
				<?php if($owner == 1) {?>
					<a href="javascript:void(0)" class="link-btn" onclick="ConfirmJOEvaluation.render('<?php echo $ID?>','<?php echo $jobOrderNumber; ?>','X')" style="width:80px">Submit Evaluation to Close Project</a>
				<?php } ?>
			</div>
				


			</div>

			<script class="dynamic" id="dynamic">
				function CustomConfirmJOEvaluation(){
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


						var selectionCode = [];
						var selectionDesciption = [];
						var questionCategoryID = [];
						
						var ctr = 1;
						var questionCategoryIDCtr = 0;
						var selectedCtr = 0;
						$("input.job_desc:radio").each(function(){
							var name = $(this).attr("name");
							//alert(name);
							var selected = $("input:radio[name="+name+"]:checked");
							//alert(selected.val());
							if( (ctr % 3) == 0) {
								questionCategoryIDCtr++;
								if(selected.length > 0) {
									selectedCtr++;
									questionCategoryID.push(questionCategoryIDCtr);
									selectionCode.push(selected.val());
									selectionDesciption.push($("input:radio[name="+name+"]:checked")[0].nextSibling.nodeValue);
								}
							} 
						    ctr++;
						});		
		
		
						var remarks = $('input[name="remarks[]"]').map(function(){ 
								return this.value; 
						}).get();           


						var dialog = '';
				
						dialog = dialog + "<div>";
						dialog = dialog + "<div><b>Request #: " + requestID  + " for completion. With Job Order # " + jo + "</b></div>";
						dialog = dialog + "<div><b>Question Category ID: </b></div>";
						dialog = dialog + "<div><u>" + questionCategoryID + "</u></div>";
						dialog = dialog + "<div><b>Selection Code: </b></div>";
						dialog = dialog + "<div><u>" + selectionCode + "</u></div>";
						dialog = dialog + "<div><b>Selection Description: </b></div>";
						dialog = dialog + "<div><u>" + selectionDesciption + "</u></div>";
						dialog = dialog + "<div><b>Remarks: </b></div>";
						dialog = dialog + "<div><u>" + remarks + "</u></div>";
						dialog = dialog + "</div>";
						
						var buttons = '';
						if(selectedCtr == 3) {
							buttons = '<button onclick="ConfirmJOEvaluation.yes(\''+jo+'\',\''+status+'\',\''+requestID+'\',\''+selectionCode+'\',\''+remarks+'\',\''+questionCategoryID+'\',\''+selectionDesciption+'\')">Proceed</button> <button onclick="ConfirmJOEvaluation.no()">Close</button>';
						} else {
							buttons = 'Must Answer all of the items!!! <button onclick="ConfirmJOEvaluation.no()">Close</button>';
						}
						

						document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
						document.getElementById('dialogboxbody').innerHTML = dialog;
						document.getElementById('dialogboxfoot').innerHTML = buttons;
					}
					this.no = function(){
						document.getElementById('dialogbox').style.display = "none";
						document.getElementById('dialogoverlay').style.display = "none";
					}
					this.yes = function(jo, status, requestID, selectionCode, remarks, questionCategoryID, selectionDesciption){
						updateRequestJOEvaluation(jo, status, requestID, selectionCode, remarks, questionCategoryID, selectionDesciption);
						document.getElementById('dialogbox').style.display = "none";
						document.getElementById('dialogoverlay').style.display = "none";
					}
				}
				var ConfirmJOEvaluation = new CustomConfirmJOEvaluation();
				
				
				
				
				function updateRequestJOEvaluation(jo, status, requestID, selectionCode, remarks, questionCategoryID, selectionDesciption) {
						jQuery.ajax({
							url: "updateRequestTBAMIMS",
							data: {
								'ID':requestID,
								'jo':jo,
								'requestStatus': status,
								'selectionCode': selectionCode,  
								'remarks': remarks, 
								'questionCategoryID': questionCategoryID, 
								'selectionDesciption': selectionDesciption, 
								
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
			
<?php } else { ?>
<span class="input_fields_wrap_jo"></span>
<div style="padding: 10px">	
	<div style="padding: 10px">
		<h3>EVALUATION BY THE REQUESTING UNIT </h3>
	</div>
	<div style="padding: 10px">
		<span><u> </u>	<b> </b></span>
	</div>

	<!--<div style="padding: 10px">
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
		<span ><u>Planned Start Date:</u> <b> <?php echo $startDatePlanned; ?></b></span>
		<span style="padding: 10px"><u>Target End Date: </u> <b><?php echo $completionDateTarget; ?></b></span>
		<span style="padding: 10px"><u>Duration: </u> <b><?php echo $days; ?> days</b></span>

	</div>

	<div style="padding: 10px">
		<?php if($requestStatus == 'W') { ?>
			<a href="javascript:void(0)" class="link-btn" onclick="CompletedJobOrder.render('<?php echo $ID?>','<?php echo $jobOrderNumber; ?>','C')" style="width:80px">Job Order Completed</a>
		<?php } else { ?>
			<span style="padding: 10px"> <b>JOB IS FINISHED </b> </span>
		<?php } ?>
		<a href="javascript:void(0)" class="link-btn" onclick="ViewJobOrder.render('<?php echo $ID?>','<?php echo $jobOrderNumber; ?>','W')" style="width:80px">View Job Order</a>
	</div>-->

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

					$('#dialogboxbody-long').html('<iframe style="width:100%; height:'+(winHeight-200)+'px" src="<?php echo base_url();?>assets/pdf/jobOrder.pdf"></iframe>');
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
        this.yes = function(jo, status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID ){
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
	
	
	</script>
	
	

<?php } ?>
			
</div>
