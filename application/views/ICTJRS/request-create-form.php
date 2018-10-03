<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/ictjrs.css" />


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Create New Request" style="width:100%;max-width:100%;padding:5px 5px;"> 
        <form id="ff" class="easyui-form" method="post" data-options="novalidate:true">

            <div style="margin-bottom:1px">
                <input class="easyui-textbox" name="requestSummary" id="requestSummary"  style="width:100%" data-options="prompt:'REQUEST SUMMARY:',required:true">

            </div>
            <div style="margin-bottom:1px">
                <input class="easyui-textbox" name="requestDetails" id="requestDetails" style="width:100%;height:100px" data-options="prompt:'REQUEST DETAILS:', multiline:true ,required:true">

            </div>

            <div style="margin-bottom:1px">
				<input class="easyui-combobox" name="requestType"  id="requestType" prompt="REQUEST TYPE:" style="width:60%" data-options="
						url:'getRequestType',
						method:'get',
						valueField:'requestTypeCode',
						textField:'requestTypeDescription',
						panelHeight:200,
						required:true
						">
            </div>
			
            <div style="margin-bottom:1px" class="three-column">

            </div>
            <div style="margin-bottom:1px" class="three-column">

            </div>

        </form>
        <div style="text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Submit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()" style="width:80px">Clear</a>
        </div>
    </div>

   <div id="error-messages"> </div>
   <div id="dialog"> </div>
  
   <div id="dlg" class="easyui-dialog" title="Create New Request Confirmation" style="position:relative; top:20px; width:1000px; height:500px; padding:10px"
            data-options="
                modal: true,
                closed: true,
                buttons: [{
                    text:'Confirmed',
                    iconCls:'icon-ok',
                    handler:function(){
                        var requestSummary = $('input#requestSummary').val();
                        var requestDetails = $('input#requestDetails').val();
                        var requestType = $('input#requestType').val();
                        insertDataViaAJAX(requestSummary, requestDetails, requestType);
                        $('#dlg').dialog('close');
                    }
                },{
                    text:'Cancel',
                    handler:function(){
                        $('#dlg').dialog('close');
                    }
                }]
            ">
            <div id="request-confirmation"> </div>
    </div>    
 	<style type="text/css">
		.textbox-text{
			background: #fffec8;
			font-weight: bold;
			font-size: 20px
		}
		
	</style>   
	<script src="<?php echo base_url();?>assets/scripts/infotech/ictjrscreaterequest.js"></script>


</div>