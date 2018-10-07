<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />
     <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/ictjrs.css" />
   
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

	
<?php } ?>
	</div>	

</div>







</div>

	<script src="<?php echo base_url();?>assets/scripts/infotech/ictjrscreatedrequest.js"></script>

