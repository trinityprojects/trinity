<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />


    
    <table id="dg" class="easyui-datagrid" title="Rooms List" style="width:100%;height:450px"
            data-options="
                iconCls: 'icon-edit',
                singleSelect: true,
                toolbar: '#tb',
                url: 'getRoomsTBAMIMS',
                method: 'get',
                onClickCell: onClickCell,
                onEndEdit: onEndEdit
            ">
        <thead>
            <tr>
				<th data-options="field:'ID',width:20">ID</th>			
				<th data-options="field:'roomNumber',width:150,editor:'textbox'">Room Number</th>   
				<th data-options="field:'floor',width:50,editor:{type:'numberbox',options:{precision:0}}">Floor</th>   
				<th data-options="field:'locationCode',width:100,
						formatter:function(value,row){
							return row.locationCode;
						},
						editor:{
							type:'combobox',
							options:{
								valueField:'locationCode',
								textField:'locationCode',
								method:'get',
								url:'getLocationTBAMIMS',
								required:true
							}
						}">Location Code</th>	

				<th data-options="field:'roomType',width:150,
						formatter:function(value,row){
							return row.roomType;
						},
						editor:{
							type:'combobox',
							options:{
								valueField:'roomType',
								textField:'roomType',
								method:'get',
								url:'getRoomTypeTBAMIMS',
								required:true
							}
						}">Room Type</th>	
				<th data-options="field:'occupantCount',width:75,align:'right',editor:{type:'numberbox',options:{precision:0}}">Occupant</th> 						
				<th data-options="field:'airconditionCount',width:75,align:'right',editor:{type:'numberbox',options:{precision:0}}">Aircondition</th> 						
				<th data-options="field:'roomDescription',width:300,editor:'textbox'">Room Description</th>   
				<th data-options="field:'remarks',width:300,editor:'textbox'">Remarks</th>   
						
			</tr>
        </thead>
    </table>
 
    <div id="tb" style="height:auto">
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
        <a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">Save</a>
        <!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reset</a>-->
        <!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
    </div>
    
    <script type="text/javascript">
        var editIndex = undefined;
		var operations = undefined;
		var appendFlag = 0;
        var deleteCtr = 0;
        var deleteIndex = undefined;
		
        function endEditing(){ 
			if (editIndex == undefined){return true}
            if ($('#dg').datagrid('validateRow', editIndex)){
                $('#dg').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }

        function onClickCell(index, field){ 
            if (editIndex != index){
                if (endEditing()){
                    $('#dg').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                    var ed = $('#dg').datagrid('getEditor', {index:index,field:field});
					
                    if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndex = index;
                } else {
                    setTimeout(function(){
                        $('#dg').datagrid('selectRow', editIndex);
                    },0);
                }
            }
        }
        function onEndEdit(index, row){ 
			if(operations == 'save' && appendFlag == 1) {
				console.log(row);
				addRecord(row);
				appendFlag = 0;
				alert('add');
			} else if(operations == 'save' && appendFlag == 0) {
				updateRecord(row);
				alert('update');
			}
        }
        function append(){ 
			if (endEditing()){
				appendFlag = 1;
                $('#dg').datagrid('appendRow',{});
                editIndex = $('#dg').datagrid('getRows').length-1;
                $('#dg').datagrid('selectRow', editIndex)
                        .datagrid('beginEdit', editIndex);
            }
        }
		
		
		
        function removeit(){ 
            if (editIndex == undefined){return}
				var result = confirm("Proceed with delete?");
				if (result) {
					var ID = $('#dg').datagrid('getRows')[editIndex].ID;

					$('#dg').datagrid('cancelEdit', editIndex)
							.datagrid('deleteRow', editIndex);
							
					
					deleteRecord(ID);
					deleteIndex = editIndex;
					editIndex = undefined;
					deleteCtr++;
					appendFlag = 0;
				}
        }
		
		
        function accept(){ 
			operations = 'save';
			
            if (endEditing()){
                $('#dg').datagrid('acceptChanges');
				
            }
        }
		
        function reject(){ 
			if(deleteCtr == 0 || appendFlag == 1) {
				$('#dg').datagrid('rejectChanges');
				editIndex = undefined;
			}
        }
        function getChanges(){
            var rows = $('#dg').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
		


		
		function addRecord(row) {
			jQuery.ajax({
				url: "insertRoomsTBAMIMS",
				data: { 
					'roomNumber': row.roomNumber, 
					'floor': row.floor, 
					'locationCode': row.locationCode, 
					'roomType': row.roomType, 
					'occupantCount': row.occupantCount, 
					'airconditionCount': row.airconditionCount, 
					'roomDescription': row.roomDescription, 
					'remarks': row.remarks, 
				},
				type: "POST",
				success:function(data){
					console.log(data);
					var resultValue = $.parseJSON(data);
					if(resultValue['success'] == 1) {
						return true;					
					}
					
				},
				error:function (){}
			}); //jQuery.ajax({	

		}	

		
		function updateRecord(row) {
			jQuery.ajax({
				url: "updateRoomTBAMIMS",
				data: { 
					'ID': row.ID, 
					'roomType': row.roomType, 
					'occupantCount': row.occupantCount, 
					'airconditionCount': row.airconditionCount, 
					'roomDescription': row.roomDescription, 
					'remarks': row.remarks, 
					
				},
				type: "POST",
				success:function(data){
					console.log(data);
					var resultValue = $.parseJSON(data);
					if(resultValue['success'] == 1) {
						return true;					
					}
					
				},
				error:function (){}
			}); //jQuery.ajax({	

		}	
		
		
		function deleteRecord(ID) {
			//alert(employeeNumber + departmentCode + designationDescription);
			jQuery.ajax({
				url: "deleteGradeDescriptorEGIS",
				data: { 
					'ID': ID, 
				},
				type: "POST",
				success:function(data){
					console.log(data);
					var resultValue = $.parseJSON(data);
					if(resultValue['success'] == 1) {
						return true;					
					}
					
				},
				error:function (){}
			}); //jQuery.ajax({	
			
			
		}
		
    </script>
</div>