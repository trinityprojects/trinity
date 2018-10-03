<div class="requestForm">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />
    
    <div id="p" class="easyui-panel" title="Request Created" style="width:50%;height:300px;padding:10px;">
        <p style="font-size:18" >Your request has been created, please use request number: <b style="font-size:24"><u><?php echo $ID ?></u></b> for your reference.</p>

<div class="two-column-70">
    <p>You may attach files to your request</p>
    <input multiple id="files" name="files" type="file"  > 
    <a id="ff" class="easyui-linkbutton">Upload</a>
    <div id="uploaded_images"></div>
    <input type='hidden' id="ID" value="<?php echo $ID; ?>">
</div>

<div class="two-column-30">
    <a href="javascript:void(0)" onclick="myRequestList()" > Proceed to MyRequest list instead..</a>
</div>



</div>

<script src="<?php echo base_url();?>assets/scripts/triunebamjrscreated.js"></script>

