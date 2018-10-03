<div class="level1">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />
    <script type="text/javascript">
        function doSearch(){
            $('#tt').datagrid('load',{
                ID: $('#ID').val(),
                requestNumber: $('#requestNumber').val(),
                workerName: $('#workerName').val(),
                completedFlag: $('#completedFlag').val()
            });
        }
    </script>   

<table id="tt" class="easyui-datagrid" style="width:100%;max-width:100%;padding:5px 5px;font-size: 5px;"
        url="getAllJobOrderListTBAMIMS" toolbar="#tb"
        title="All Job Order List" iconCls="icon-save"
        rownumbers="true" pagination="true" data-options="singleSelect: true,
        rowStyler: function(){
                        return 'padding:5px;';
                }         
        ">

    <thead>
        <tr >
            <th field="ID" align="right" >ID</th>
            <th field="requestNumber" >Request #</th>
            <th field="workerName"  >Worker Name</th>
            <th field="jobDescription" >Job Description</th>
            <th field="startDatePlanned" >Date Planned</th>
            <th field="completionDateTarget" >Date Target</th>
            <th field="completedFlag" >Completed?</th>
            <th field="userName" >Requested By</th>
            <th field="startDateActual" >Date Started</th>
            <th field="completedDateActual" >Date Ended</th>
            <th field="receivedDate" >Date Received</th>
            
        </tr>
    </thead>
</table>
<div id="tb" style="padding:2px">
    <span>ID:</span>
    <input id="ID" style="line-height:15px;border:1px solid #ccc">
    <span>Request Number:</span>
    <input id="requestNumber" style="line-height:15px;border:1px solid #ccc">
    <span>Worker Name:</span>
    <input id="workerName" style="line-height:15px;border:1px solid #ccc">
    <span>Completed Flag:</span>
    <input id="completedFlag" style="line-height:15px;border:1px solid #ccc">
    <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>

</div>




<script type="text/javascript">
$(document).ready(function(){

	$('#tt').datagrid({
		rowStyler:function(index,row){
			if (row.completedFlag == 'Y'){
				return 'background-color:darkgreen;color:gold;font-weight:bold;';
			}
		}
	});


    $('#tt').datagrid({

        onClickRow: function() {

            var row = $('#tt').datagrid('getSelected');
           // $('#tt').datagrid('unselectAll');
           row.styler = function(){
	        return 'background-color:yellow';
            };

           // $('#tt').datagrid('enableCellEditing');
            //$('#tt').datagrid('options').onBeforeSelect = function(){return true;};
           
            jQuery.ajax({
            url: 'TBAMIMS/showJobOrderDetails',
            data: 'ID='+row.ID,
            type: "POST",
            success: function(response) {
                $('div.level2').remove();

                $('.leveltwocontent').append(response);
        
                console.log("the request is successful for content1!");
            },
                        
            error: function(error) {
                console.log('the page was NOT loaded', error);
                $('.leveltwocontent').html(error);
            },
                        
            complete: function(xhr, status) {
                console.log("The request is complete!");
            }
        }); //jQuery.ajax({

        }

    });
    return false;
	
	

    
});
</script> 

</div>