<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />
     <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/ictjrs.css" />
 	<link rel='stylesheet' type='text/css' media="screen" href='<?php echo base_url();?>assets/scripts/datepicker/datepicker.css' />
	<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/datepicker/datepicker.js"></script>

 	<link rel='stylesheet' type='text/css' media="screen" href='<?php echo base_url();?>assets/scripts/timepicker/jquery.timepicker.css' />
	<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/timepicker/jquery.timepicker.js"></script>

	
    <div id="p" class="easyui-panel" title="Request Created" style="width:100%;height:600px;padding:10px;">
        <p style="font-size:18" >Your request has been created, please use request number: <b style="font-size:24"><u><?php echo $ID ?></u></b> for your reference.</p>
		<input type="hidden" id="requestNumber" value="<?php echo $ID ?>" />
		<input type="hidden" id="requestType" value="<?php echo $requestType ?>" />
		
<div class="two-column-70">
    <p>You may attach files for this request</p>
    <input multiple id="files" name="files" type="file"  > 
    <a id="ff" class="easyui-linkbutton">Upload</a>
    
	<div id="uploading"></div>
	<div id="uploaded_files"></div>




<div id="myModalImage" class="modal">
	<span class="close cursor" onclick="closeModalImage()">&times;</span>
	<div class="modal-content" id="image-content">
	</div>
</div>	


<div id="myModalPDF" class="modal">
	<span class="close cursor" onclick="closeModalPDF()">&times;</span>
	<div class="modal-content" id="pdf-content">
	</div>
</div>	
	
	
</div>



<div class="two-column-30">
    <a href="javascript:void(0)" onclick="myRequestList()" > Proceed to MyRequest list instead..</a>
</div>

<div class="col-100" style="border: 0" >
	<div>
		</br>

	</div>	

</div>

<div class="col-100" style="border: 0; background-color: darkgreen" >
	<div>
		</br>

	</div>	

</div>

<div class="col-100" style="border: 0;" >
	<div>
		</br>
	<h5>Request Summary: <u><?php echo $requestSummary; ?></u></h5>
	<div>Your request is now assigned to: <u><?php echo $assignedTo; ?></u></div>
	<div>This request must be finished on or before: <u><?php echo $deliveryDate; ?></u></div>
	<input type="hidden" id="deliveryDate" value="<?php echo $deliveryDate ?>" />
		
<?php if($requestType == "CCTA") {?>
	
	<div class="col-100" style="border: 0">
		<div class="easyui-panel" title="Select CCTV Equipment for inspection" style="width:100%;max-width:100%;padding:5px 5px;"> 
		<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
			
							<input class="easyui-combobox" name="location" id="location" prompt="LOCATION:" style="width:25%" data-options="
									url:'getCCTVInventoryICTJRS',
									method:'get',
									valueField:'ID',
									textField:'location',
									panelHeight:200,
									required:true
									">
							<input type="text" class="easyui-textbox" id="itemDetails" data-options="prompt:'Item Details:',required:true" style="width:40%"> 
			
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Select</a>						
									
		</form>
		</div>

	</div>

	<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
		<span > </span>

	</div>
<?php } elseif ($requestType == "GSAS") { ?>

	<div class="col-100" style="border: 0">
		<div class="easyui-panel" title="Select GSuite Request" style="width:100%;max-width:100%;padding:5px 5px;"> 
		<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
			
							<input class="easyui-combobox" name="requestCategory" id="requestCategory" prompt="Request Category:" style="width:25%" data-options="
									url:'getRequestReferenceGSuiteICTJRS',
									method:'get',
									valueField:'ID',
									textField:'requestCategory',
									panelHeight:200,
									required:true
									">
							<input type="text" class="easyui-textbox" id="itemDetails" data-options="prompt:'Item Details:',required:true" style="width:40%"> 
			
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Select</a>						
									
		</form>
		</div>

	</div>

	<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
		<span > </span>

	</div>
<?php } elseif ($requestType == "HWRS") { ?>
	<div class="col-100" style="border: 0">
		<div class="easyui-panel" title="Select Hardware Components" style="width:100%;max-width:100%;padding:5px 5px;"> 
		<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
			
							<input class="easyui-combobox" name="requestCategory" id="requestCategory" prompt="Request Category:" style="width:25%" data-options="
									url:'getRequestHardwareICTJRS',
									method:'get',
									valueField:'ID',
									textField:'requestCategory',
									panelHeight:200,
									required:true
									">
							<input type="text" class="easyui-textbox" id="itemDetails" data-options="prompt:'Item Details:',required:true" style="width:40%"> 
			
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Select</a>						
									
		</form>
		</div>

	</div>

	<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
		<span > </span>

	</div>
	
<?php } elseif ($requestType == "ICWA") { ?>
	<div class="col-100" style="border: 0">
		<div class="easyui-panel" title="Internet Activation" style="width:100%;max-width:100%;padding:5px 5px;"> 
		<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
			
							<input class="easyui-combobox" name="connectionType" id="connectionType" prompt="Connection Type:" style="width:15%" data-options="
									url:'getConnectionType',
									method:'get',
									valueField:'connectionType',
									textField:'connectionType',
									panelHeight:100,
									required:true
									">
									
							<input class="easyui-combobox" name="roomNumber" id="roomNumber" prompt="Room Number:" style="width:25%" data-options="
									url:'getRoomsTBAMIMS',
									method:'get',
									valueField:'roomNumber',
									textField:'roomNumber',
									panelHeight:200,
									required:true
									">
									
							<input type="text" class="easyui-textbox" id="itemDetails" data-options="prompt:'Item Details:',required:true" style="width:40%"> 
			
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Select</a>						
									
		</form>
		</div>

	</div>

	<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
		<span > </span>

	</div>
	
<?php } elseif ($requestType == "ICSA") { ?>
	<div class="col-100" style="border: 0">
		<div class="easyui-panel" title="Set Site Access" style="width:100%;max-width:100%;padding:5px 5px;"> 
		<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
			
				<input type="text" class="easyui-textbox" id="contentSite" data-options="prompt:'Content/Site:',required:true" style="width:40%"> 
									
				<input type="text" class="easyui-textbox" id="reason" data-options="prompt:'Reason:',required:true" style="width:40%"> 
				</br></br>	

				<input class="easyui-combobox" name="durationType" id="durationType" prompt="Duration Type:" style="width:15%" data-options="
						url:'getDurationType',
						method:'get',
						valueField:'durationType',
						textField:'durationType',
						panelHeight:100,
						required:true
						">

				
				<table id="datepicker" class="dp_calendar" style="display:none;font-size:14px;" cellpadding="0" cellspacing="0"></table>
				<span style="padding: 10px">
					Start Date:
					<input type="text" name="start_date" id="start_date" readonly>
					<a onclick="DP.open('start_date','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>
				
				<span style="padding: 10px">

					End Date:
					<input type="text" name="end_date" id="end_date" readonly>
					<a onclick="DP.open('end_date','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>
				
			
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Set</a>						
									
		</form>
		</div>

	</div>

	<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
		<span > </span>

	</div>
<?php } elseif($requestType == "LPI") {?>
	
	<div class="col-100" style="border: 0">
		<div class="easyui-panel" title="Select LCD Equipment for inspection" style="width:100%;max-width:100%;padding:5px 5px;"> 
		<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
			
							<input class="easyui-combobox" name="projectorDetail" id="projectorDetail" prompt="PROJECTOR:" style="width:25%" data-options="
									url:'getDetailedLCDInventoryICTJRS',
									method:'get',
									valueField:'ID',
									textField:'projectorDetail',
									panelHeight:200,
									required:true
									">
							<input type="text" class="easyui-textbox" id="itemDetails" data-options="prompt:'Item Details:',required:true" style="width:40%"> 
			
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Select</a>						
									
		</form>
		</div>

	</div>

	<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
		<span > </span>

	</div>
<?php } elseif($requestType == "PTRS") {?>
	
	<div class="col-100" style="border: 0">
		<div class="easyui-panel" title="Select Telephone Equipment for inspection" style="width:100%;max-width:100%;padding:5px 5px;"> 
		<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
			
							<input class="easyui-combobox" name="phoneDetail" id="phoneDetail" prompt="PHONE DETAIL:" style="width:25%" data-options="
									url:'getDetailedTelephoneInventoryICTJRS',
									method:'get',
									valueField:'ID',
									textField:'phoneDetail',
									panelHeight:200,
									required:true
									">
							<input type="text" class="easyui-textbox" id="itemDetails" data-options="prompt:'Item Details:',required:true" style="width:40%"> 
			
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Select</a>						
									
		</form>
		</div>

	</div>

	<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
		<span > </span>

	</div>
<?php } elseif($requestType == "SWTI") {?>
	
	<div class="col-100" style="border: 0">
		<div class="easyui-panel" title="Select Software" style="width:100%;max-width:100%;padding:5px 5px;"> 
		<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
			
							<input class="easyui-combobox" name="softwareName" id="softwareName" prompt="SOFTWARE:" style="width:25%" data-options="
									url:'getSoftwareInventoryICTJRS',
									method:'get',
									valueField:'ID',
									textField:'softwareName',
									panelHeight:200,
									required:true
									">
							<input type="text" class="easyui-textbox" id="itemDetails" data-options="prompt:'Item Details:',required:true" style="width:40%"> 
			
							<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Select</a>						
									
		</form>
		</div>

	</div>

	<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
		<span > </span>

	</div>

<?php } elseif ($requestType == "CLA") { ?>
	<div class="col-100" style="border: 0">
		<div class="easyui-panel" title="Lab Reservation" style="width:100%;max-width:100%;padding:5px 5px;"> 
		<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
			

				<input class="easyui-combobox" name="comlabName" id="comlabName" prompt="Comlab Name:" style="width:15%" data-options="
						url:'getLaboratoryList',
						method:'get',
						valueField:'comlabName',
						textField:'comlabName',
						panelHeight:100,
						required:true
						">

				
				<table id="datepicker" class="dp_calendar" style="display:none;font-size:14px;" cellpadding="0" cellspacing="0"></table>
				<span style="padding: 10px">
					Start Date:
					<input type="text" name="start_date" id="start_date" readonly>
					<a onclick="DP.open('start_date','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>

				<span style="padding: 10px">
					Start Time:
					<input id="startTime" type="text" class="time" />
				</span>

				
				<span style="padding: 10px">

					End Date:
					<input type="text" name="end_date" id="end_date" readonly>
					<a onclick="DP.open('end_date','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>

				<span style="padding: 10px">
					End Time:
					<input id="endTime" type="text" class="time" />
				</span>
				
				</br></br>	
	
				<input type="text" class="easyui-textbox" id="reservationDetails" data-options="prompt:'Reservation Details:',required:true" style="width:40%"> 

				<script>
					$(function() {
						$('#startTime').timepicker();
						$('#endTime').timepicker();
					});
				</script>
									
				<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Set</a>						
									
		</form>
		</div>

	</div>

	
<?php } ?>	</div>	

</div>







</div>

	<script src="<?php echo base_url();?>assets/scripts/infotech/ictjrscreatedrequest.js"></script>

