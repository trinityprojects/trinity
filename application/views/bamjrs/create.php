<div class="requestForm">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Create Request" style="width:100%;max-width:50%;padding:5px 5px;"> 
        <form id="ff" class="easyui-form" method="post" data-options="novalidate:true">
            <div style="margin-bottom:5px">
                <div style="margin-bottom:1px" >
                    <input class="easyui-combobox" name="locationCode" id="locationCode" style="width:100%" prompt="LOCATION:" data-options="
                            url:'getLocationCode',
                            method:'get',
                            valueField:'locationCode',
                            textField:'locationDescription',
                            onSelect: function(rec){
                                var url = 'getFloor?locationCode='+rec.locationCode;
                                console.log( $('#floor').attr('prompt'));
                                $('#roomNumber').textbox('clear');
                                $('#floor').textbox('clear');
                                $('#floor').combobox('reload', url);
                                $('#roomNumber').combobox('reload', url);
                            },
                            panelHeight:'auto',
                            required:true
                            ">
                </div>


                <div style="margin-bottom:1px" class="two-column-30">
                    <input class="easyui-combobox" name="floor" id="floor" style="width:70%;" prompt="FLOOR:" data-options="
                            valueField:'floor',
                            textField:'floor',
                            onSelect: function(rec){
                                var url = 'getRoomNumber?floor='+rec.floor+'&locationCode='+rec.locationCode;
                                $('#roomNumber').textbox('clear');
                                $('#roomNumber').combobox('reload', url);
                            },
                            
                            panelHeight:'auto',
                            required:true
                            ">
                </div>


                <div style="margin-bottom:1px" class="two-column-70">
                    <input class="easyui-combobox" name="roomNumber" id="roomNumber" style="width:100%;" data-options="
                            valueField:'roomNumber',
                            textField:'roomDescription',
                            panelHeight:'auto',
                            prompt: 'ROOM:',
                            required:true
                            ">
                </div>

            </div>
            <div style="margin-bottom:1px">
                <input class="easyui-textbox" name="projectTitle" id="projectTitle"  style="width:100%" data-options="prompt:'PROJECT TITLE:',required:true">

            </div>
            <div style="margin-bottom:1px" class="two-column">
                <input class="easyui-textbox" name="scopeOfWorks" id="scopeOfWorks" style="width:100%;height:100px" data-options="prompt:'SCOPE OF WORKS:', multiline:true ,required:true">

            </div>
            <div style="margin-bottom:1px" class="two-column">
                <input class="easyui-textbox" name="projectJustification" id="projectJustification" style="width:100%;height:100px" data-options="prompt:'PROJECT JUSTIFICATION, NOTES, AND COMMENTS:',multiline:true,required:true">

            </div>

            <div style="margin-bottom:1px" class="two-column">
                <input class="easyui-datebox" prompt="DATE NEEDED:" id="dateNeeded" data-options="formatter:myformatter,parser:myparser,required:true" style="width:100%;">

            </div>

        </form>
        <div style="text-align:center;padding:5px 0">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Submit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()" style="width:80px">Clear</a>
        </div>
    </div>

   <div id="error-messages"> </div>
   <div id="dialog"> </div>
  
   <div id="dlg" class="easyui-dialog" title="Job Request Confirmation" style="width:800px;height:300px;padding:10px"
            data-options="
                modal: true,
                closed: true,
                buttons: [{
                    text:'Confirmed',
                    iconCls:'icon-ok',
                    handler:function(){
                        var locationCode = $('input#locationCode').val();
                        var floor = $('input#floor').val();
                        var roomNumber = $('input#roomNumber').val();
                        var projectTitle = $('input#projectTitle').val();
                        var scopeOfWorks = $('input#scopeOfWorks').val();
                        var projectJustification = $('input#projectJustification').val();
                        var dateNeeded = $('input#dateNeeded').val();
                        insertDataViaAJAX(locationCode, floor, roomNumber, projectTitle, scopeOfWorks, projectJustification, dateNeeded);
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
    
	<script src="<?php echo base_url();?>assets/scripts/triunebamjrs.js"></script>


</div>