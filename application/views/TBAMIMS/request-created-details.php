<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />
    
    <div id="p" class="easyui-panel" title="Request Created" style="width:100%;height:400px;padding:10px;">
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



</div>

<script src="<?php echo base_url();?>assets/scripts/building/tbamimscreatedrequest.js"></script>

