<div class="level1">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />
    <script type="text/javascript">
        function doSearch(){
            $('#tt').datagrid('load',{
                ID: $('#ID').val(),
                requestStatus: $('#requestStatus').val()
            });
        }
    </script>   

<table id="tt" class="easyui-datagrid" style="width:100%;max-width:100%;padding:5px 5px;font-size: 5px;"
        url="getMyRequestListASRS" toolbar="#tb"
        title="My Request List" iconCls="icon-save"
        rownumbers="true" pagination="true" data-options="singleSelect: true,
        rowStyler: function(){
                        return 'padding:5px;';
                }         
        ">

    <thead>
        <tr >
                        <th field="ID">ID</th>
                        <th field="requestPurpose" class="datagrid-cell-c2-requestPurpose">Request Purpose</th>
                        <th field="dateCreated" align="right">Date Created</th>
                        <th field="dateNeeded" align="right">Date Needed</th>
                        <th field="requestStatusDescription">Request Status</th>
                        <th field="departmentUnit">Department/Unit</th>
                        <th field="userName">Requested By</th>
						<th field="returnedFrom">Previous Status</th>
            
        </tr>
    </thead>
</table>
<div id="tb" style="padding:2px">
    <span>ID:</span>
    <input id="ID" style="line-height:15px;border:1px solid #ccc">
    <span>Request Status:</span>
    <input id="requestStatus" style="line-height:15px;border:1px solid #ccc">
    <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>

</div>




<script type="text/javascript">
$(document).ready(function(){

    $('#tt').datagrid({

        onClickRow: function() {

            var row = $('#tt').datagrid('getSelected');
           // $('#tt').datagrid('unselectAll');
           //row.styler = function(){
	       // return 'background-color:yellow';
           // };

           // $('#tt').datagrid('enableCellEditing');
            //$('#tt').datagrid('options').onBeforeSelect = function(){return true;};
           
            jQuery.ajax({
            url: 'ASRS/showRequestDetails',
            data: 'ID='+row.ID,
            type: "POST",
            success: function(response) {
                $('div.level2').remove();
				$('div.panel.combo-p.panel-htop').remove();
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