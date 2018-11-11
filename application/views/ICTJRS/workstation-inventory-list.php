<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />


    
    <table id="dg" class="easyui-datagrid" title="Workstation Inventory" style="width:100%;height:450px"
            data-options="
                iconCls: 'icon-edit',
                singleSelect: true,
                toolbar: '#tb',
                url: 'getWorkstationInventoryICTJRS',
                method: 'get',
                onClickCell: onClickCell,
                onEndEdit: onEndEdit
            ">
        <thead>
            <tr>
				<th data-options="field:'ID',width:50">ID</th>			
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
					<th data-options="field:'fullName',width:350,
							formatter:function(value,row){
								return row.fullName;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'fullName',
									textField:'fullName',
									method:'get',
									url:'getEmployeeActiveListTHRIMS',
									required:true
								}
							}">Faculty Name;Employee Number</th>
				<th data-options="field:'hardwareSpecs',width:450,editor:'textbox'">Hardware Specs</th>  
				<th data-options="field:'peripheralsSpecs',width:450,editor:'textbox'">Peripherals Specs</th>  
				<th data-options="field:'printerSpecs',width:450,editor:'textbox'">Printer Specs</th>  


				<th data-options="field:'systemSoftwareSpecs',width:450,editor:'textbox'">System Software Specs</th>  
				<th data-options="field:'applicationSoftwareSpecs',width:450,editor:'textbox'">Application Software Specs</th>  
				<th data-options="field:'processorSpecs',width:400,editor:'textbox'">Processor Specs</th>  
				<th data-options="field:'hardDiskSpecs',width:400,editor:'textbox'">HardDisk Specs</th>  
				<th data-options="field:'memorySpecs',width:400,editor:'textbox'">Memory Specs</th>  
				<th data-options="field:'monitorSpecs',width:400,editor:'textbox'">Monitor Specs</th>  
				<th data-options="field:'mouseSpecs',width:400,editor:'textbox'">Mouse Specs</th>  
				<th data-options="field:'keyboardSpecs',width:400,editor:'textbox'">Keyboard Specs</th>  
				<th data-options="field:'internetAccessFlag',width:50,editor:'textbox'">Internet Access Flag</th>  
				<th data-options="field:'iPAddress',width:100,editor:'textbox'">IP Address</th>  
				<th data-options="field:'subnetMask',width:100,editor:'textbox'">Subnet Mask</th>  
				<th data-options="field:'defaultGateway',width:100,editor:'textbox'">Default Gateway</th>  
				<th data-options="field:'dNS',width:100,editor:'textbox'">DNS</th>  
				
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
				url: "insertWorkstationInventoryICTJRS",
				data: { 
					'roomNumber': row.roomNumber, 
					'assignedTo': row.fullName, 
					'hardwareSpecs': row.hardwareSpecs, 
					'peripheralsSpecs': row.peripheralsSpecs, 
					'printerSpecs': row.printerSpecs, 
					'systemSoftwareSpecs': row.systemSoftwareSpecs, 
					'applicationSoftwareSpecs': row.applicationSoftwareSpecs, 
					'processorSpecs': row.processorSpecs, 
					'hardDiskSpecs': row.hardDiskSpecs, 
					'memorySpecs': row.memorySpecs, 
					'monitorSpecs': row.monitorSpecs, 
					'mouseSpecs': row.mouseSpecs, 
					'keyboardSpecs': row.keyboardSpecs, 
					'internetAccessFlag': row.internetAccessFlag, 
					'iPAddress': row.iPAddress, 
					'subnetMask': row.subnetMask, 
					'defaultGateway': row.defaultGateway, 
					'dNS': row.dNS, 
					
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
			alert(row.fullName);
			
			jQuery.ajax({
				url: "updateWorkstationInventoryICTJRS",
				data: { 
					'ID': row.ID, 
					'roomNumber': row.roomNumber, 
					'assignedTo': row.fullName, 
					'hardwareSpecs': row.hardwareSpecs, 
					'peripheralsSpecs': row.peripheralsSpecs, 
					'printerSpecs': row.printerSpecs, 
					'systemSoftwareSpecs': row.systemSoftwareSpecs, 
					'applicationSoftwareSpecs': row.applicationSoftwareSpecs, 
					'processorSpecs': row.processorSpecs, 
					'hardDiskSpecs': row.hardDiskSpecs, 
					'memorySpecs': row.memorySpecs, 
					'monitorSpecs': row.monitorSpecs, 
					'mouseSpecs': row.mouseSpecs, 
					'keyboardSpecs': row.keyboardSpecs, 
					'internetAccessFlag': row.internetAccessFlag, 
					'iPAddress': row.iPAddress, 
					'subnetMask': row.subnetMask, 
					'defaultGateway': row.defaultGateway, 
					'dNS': row.dNS, 
					
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
				url: "deleteWorkstationInventoryICTJRS",
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