<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />


    
    <table id="dg" class="easyui-datagrid" title="Department Head Setup for <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:100%;height:220px"
            data-options="
                iconCls: 'icon-edit',
                singleSelect: true,
                toolbar: '#tb',
                url: 'getOfficersEGIS',
                method: 'get',
                onClickCell: onClickCell,
                onEndEdit: onEndEdit
            ">
        <thead>
            <tr>
                <th data-options="field:'employeeNumber',width:150">Faculty Number</th>
                <th data-options="field:'fullName',width:450,
                        formatter:function(value,row){
                            return row.fullName;
                        },
                        editor:{
                            type:'combobox',
                            options:{
                                valueField:'employeeNumber',
                                textField:'fullName',
                                method:'get',
                                url:'getFacultyListK12',
                                required:true
                            }
                        }">Faculty Name</th>

                <th data-options="field:'designationDescription',width:150,
                        formatter:function(value,row){
                            return row.designationDescription;
                        },
                        editor:{
                            type:'combobox',
                            options:{
                                valueField:'designationDescription',
                                textField:'designationDescription',
                                method:'get',
                                url:'getEmployeeDesignation',
                                required:true
                            }
                        }">Designation</th>
                <th data-options="field:'departmentCode',width:100,
                        formatter:function(value,row){
                            return row.departmentCode;
                        },
                        editor:{
                            type:'combobox',
                            options:{
                                valueField:'departmentCode',
                                textField:'departmentCode',
                                method:'get',
                                url:'getDepartmentK12',
                                required:true
                            }
                        }">Department</th>
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
                    /*$('#dg').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                    var ed = $('#dg').datagrid('getEditor', {index:index,field:field});
					
                    if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }*/
					
                    editIndex = index;
                } else {
                    setTimeout(function(){
                        $('#dg').datagrid('selectRow', editIndex);
                    },0);
                }
            }
        }
		
	

	
        function onEndEdit(index, row){ 
		
			alert('go');
			
			if(operations == 'save' && appendFlag == 1) {
				row.employeeNumber = row.fullName;
				var ed = $(this).datagrid('getEditor', {
					index: index,
					field: 'fullName'
				});
				row.fullName = $(ed.target).combobox('getText');
				addRecord(row);
				appendFlag = 0;
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
				if(result) {
					var employeeNumber = $('#dg').datagrid('getRows')[editIndex].employeeNumber;
					var departmentCode = $('#dg').datagrid('getRows')[editIndex].departmentCode;
					var designationDescription = $('#dg').datagrid('getRows')[editIndex].designationDescription;

					$('#dg').datagrid('cancelEdit', editIndex)
							.datagrid('deleteRow', editIndex);
							
					
					deleteRecord(employeeNumber, departmentCode, designationDescription);
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
				url: "insertOfficerRecordsEGIS",
				data: { 
					'employeeNumber': row.employeeNumber, 
					'departmentCode': row.departmentCode, 
					'designationDescription': row.designationDescription, 
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

		function deleteRecord(employeeNumber, departmentCode, designationDescription) {
			//alert(employeeNumber + departmentCode + designationDescription);
			jQuery.ajax({
				url: "deleteOfficerRecordsEGIS",
				data: { 
					'employeeNumber': employeeNumber, 
					'departmentCode': departmentCode, 
					'designationDescription': designationDescription, 
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