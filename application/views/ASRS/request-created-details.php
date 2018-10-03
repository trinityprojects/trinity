<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />
     <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/building/tbamims.css" />
   
    <div id="p" class="easyui-panel" title="Request Created" style="width:100%;height:600px;padding:10px;">
        <p style="font-size:18" >Your request has been created, please use request number: <b style="font-size:24"><u><?php echo $ID ?></u></b> for your reference.</p>

<div class="two-column-70">
    <p>You may attach files for this request</p>
    <input multiple id="files" name="files" type="file"  > 
    <a id="ff" class="easyui-linkbutton">Upload</a>
    
	<div id="uploading"></div>
	<div id="uploaded_files"></div>


    <input type='hidden' id="ID" value="<?php echo $ID; ?>">

	

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

	</div>	

</div>





<div class="col-100" style="border: 0">
	<div class="easyui-panel" title="Add New Items" style="width:100%;max-width:100%;padding:5px 5px;"> 
	<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
		<input type="text" class="easyui-numberbox" id="quantity" data-options="prompt:'Quantity:',required:true, min:0,precision:0"   style="width:5%"> 
		
						<input class="easyui-combobox" name="unitCode" id="unitCode" prompt="UNIT:" style="width:10%" data-options="
								url:'getSupplyUnits',
								method:'get',
								valueField:'ID',
								textField:'unitCode',
								panelHeight:200,
								required:true
								">
		
						<input class="easyui-combobox" name="assetName" id="assetName" prompt="ITEM NAME:" style="width:50%" data-options="
								url:'getAssetGroup',
								method:'get',
								valueField:'assetCode',
								textField:'assetName',
								panelHeight:200,
								required:true
								">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Submit</a>						
								
	</form>
	</div>

</div>

<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
	<span > </span>

</div>




</div>

<script src="<?php echo base_url();?>assets/scripts/purchasing/asrscreatedrequest.js"></script>

