<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />


    
    <table id="dg" class="easyui-datagrid" title="LCD Inventory" style="width:100%;height:450px"
            data-options="
                iconCls: 'icon-edit',
                singleSelect: true,
                toolbar: '#tb',
                url: 'getLCDInventoryICTJRS',
                method: 'get',
                onClickCell: onClickCell,
                onEndEdit: onEndEdit
            ">
        <thead>
            <tr>
				<th data-options="field:'ID',width:50">ID</th>			
					<th data-options="field:'locationCode',width:100">Location</th>  
					<th data-options="field:'floor',width:50">floor</th>  
					<th data-options="field:'roomNumber',width:250,
							formatter:function(value,row){
								return row.roomNumber;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'roomNumber',
									textField:'roomNumber',
									method:'get',
									url:'getRoomsTBAMIMS',
									required:true
								}
							}">Room Number</th>
							
				<th data-options="field:'projectorBrand',width:150,editor:'textbox'">Brand</th>  
				<th data-options="field:'projectorModel',width:150,editor:'textbox'">Model</th>  
				<th data-options="field:'projectorLampLimit',width:100,editor:{type:'numberbox',options:{precision:0}}">Lamp Limit</th>  
				<th data-options="field:'projectorLampCounter',width:100,editor:{type:'numberbox',options:{precision:0}}">Lamp Counter</th>  
				<th data-options="field:'screenBrand',width:100,editor:'textbox'">Screen Brand</th>  
				<th data-options="field:'notes',width:350,editor:'textbox'">Notes</th>  
				
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
	<script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/datagrid-filter.js"></script>
	
	<script type="text/javascript">
	$(function(){
		var dg = $('#dg').datagrid();
		dg.datagrid('enableFilter');
	});
	</script>
    
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
				url: "insertLCDInventoryICTJRS",
				data: { 
					'roomNumber': row.roomNumber, 
					'projectorBrand': row.projectorBrand, 
					'projectorModel': row.projectorModel, 
					'projectorLampLimit': row.projectorLampLimit, 
					'projectorLampCounter': row.projectorLampCounter, 
					'screenBrand': row.screenBrand, 
					'notes': row.notes, 
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
				url: "updateLCDInventoryICTJRS",
				data: { 
					'ID': row.ID, 
					'roomNumber': row.roomNumber, 
					'projectorBrand': row.projectorBrand, 
					'projectorModel': row.projectorModel, 
					'projectorLampLimit': row.projectorLampLimit, 
					'projectorLampCounter': row.projectorLampCounter, 
					'screenBrand': row.screenBrand, 
					'notes': row.notes, 
					
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
				url: "deleteLCDInventoryICTJRS",
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