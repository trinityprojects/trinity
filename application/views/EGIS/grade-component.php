<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />

<div id="tabpanel" class="easyui-tabs" style="width:100%;max-width:100%;">

	<div title="Elementary and Junior High" style="padding:10px;">
    
		<table id="dg" class="easyui-datagrid" title="Grade Component for <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:100%;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tb',
					url: 'getGradeComponentEGIS',
					method: 'get',
					onClickCell: onClickCell,
					onEndEdit: onEndEdit
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>			
					<th data-options="field:'levelCode',width:150,
							formatter:function(value,row){
								return row.levelCode;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'levelCode',
									textField:'courseDescription',
									method:'get',
									url:'getCourseInformationLevelActiveK12',
									required:true
								}
							}">Level</th>
					<th data-options="field:'departmentCode',width:200,
							formatter:function(value,row){
								return row.departmentCode;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'departmentCode',
									textField:'departmentDescription',
									method:'get',
									url:'getDepartmentK12',
									required:true
								}
							}">Department</th>
							
					<th data-options="field:'gradingComponentCode',width:200,
							formatter:function(value,row){
								return row.gradingComponentCode;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'gradingComponentCode',
									textField:'gradingComponentDescription',
									method:'get',
									url:'getGradeComponentReferenceK12',
									required:true
								}
							}">Grade Component</th>
							
					<th data-options="field:'componentPercentage',width:100,align:'right',editor:{type:'numberbox',options:{precision:0}}">Percentage</th>   
				
				</tr>
			</thead>
		</table>
	 
		<div id="tb" style="height:auto">
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">Save</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="cancel()">Cancel Edit</a>
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
		</div>
	</div>

	
	<div title="Senior High" style="padding:10px;">
		<table id="dgSH" class="easyui-datagrid" title="Weight Component for <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:100%;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tbSH',
					url: 'getGradeComponentSHEGIS',
					method: 'get',
					onClickCell: onClickCellSH,
					onEndEdit: onEndEditSH
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>			
					<th data-options="field:'subjectComponentCode',width:200,
							formatter:function(value,row){
								return row.subjectComponentCode;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'subjectComponentCode',
									textField:'subjectComponentDescription',
									method:'get',
									url:'getSubjectComponentSH',
									required:true
								}
							}">Subject Component</th>
							
					<th data-options="field:'gradingComponentCode',width:200,
							formatter:function(value,row){
								return row.gradingComponentCode;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'gradingComponentCode',
									textField:'gradingComponentDescription',
									method:'get',
									url:'getGradeComponentReferenceK12',
									required:true
								}
							}">Grade Component</th>
							
					<th data-options="field:'componentPercentage',width:100,align:'right',editor:{type:'numberbox',options:{precision:0}}">Percentage</th>   
				
				</tr>
			</thead>
		</table>
	 
		<div id="tbSH" style="height:auto">
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="appendSH()">Append</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeitSH()">Remove</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptSH()">Save</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="cancelSH()">Cancel Edit</a>
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
		</div>		
	</div>	
 
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
				//row.levelCode = row.courseDescription;
				//row.departmentCode = row.departmentDescription;
				//row.gradingComponentCode = row.gradingComponentDescription;
				addRecord(row);
				appendFlag = 0;
				alert('add');
			} else if(operations == 'save' && appendFlag == 0) {
				//row.levelCode = row.courseDescription;
				//row.departmentCode = row.departmentDescription;
				//row.gradingComponentCode = row.gradingComponentDescription;
				
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
					//Logic to delete the item
					var ID = $('#dg').datagrid('getRows')[editIndex].ID;
					//var departmentCode = $('#dg').datagrid('getRows')[editIndex].departmentCode;
					//var gradingComponentCode = $('#dg').datagrid('getRows')[editIndex].gradingComponentCode;
					$('#dg').datagrid('cancelEdit', editIndex)
							.datagrid('deleteRow', editIndex);
							
					
					deleteRecord(ID);
					deleteIndex = editIndex;
					editIndex = undefined;
					deleteCtr++;
					appendFlag = 0;
				}
        }

		function cancel() {
            if (editIndex == undefined){return}
			$('#dg').datagrid('cancelEdit', editIndex);
			
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
			//alert(row.levelCode + row.departmentCode + row.gradingComponentCode + row.componentPercentage);
			jQuery.ajax({
				url: "insertGradeComponentEGIS",
				data: { 
					'levelCode': row.levelCode, 
					'departmentCode': row.departmentCode, 
					'gradingComponentCode': row.gradingComponentCode, 
					'componentPercentage': row.componentPercentage, 
					
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
				url: "updateGradingComponentEGIS",
				data: { 
					'ID': row.ID, 
					'levelCode': row.levelCode, 
					'departmentCode': row.departmentCode, 
					'gradingComponentCode': row.gradingComponentCode, 
					'componentPercentage': row.componentPercentage, 
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
				url: "deleteGradeComponentEGIS",
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
	
	
    <script type="text/javascript">
        var editIndexSH = undefined;
		var operationsSH = undefined;
		var appendFlagSH = 0;
        var deleteCtrSH = 0;
        var deleteIndexSH = undefined;
		
        function endEditingSH(){ 
			if (editIndexSH == undefined){return true}
            if ($('#dgSH').datagrid('validateRow', editIndexSH)){
                $('#dgSH').datagrid('endEdit', editIndexSH);
                editIndexSH = undefined;
                return true;
            } else {
                return false;
            }
        }

        function onClickCellSH(index, field){ 
            if (editIndexSH != index){
                if (endEditingSH()){
							
						
                    $('#dgSH').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
					
                    var ed = $('#dgSH').datagrid('getEditor', {index:index,field:field});

					
                    if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndexSH = index;
                } else {
                    setTimeout(function(){
                        $('#dg').datagrid('selectRow', editIndex);
                    },0);
                }
            }
        }
        function onEndEditSH(index, row){ 
			if(operationsSH == 'save' && appendFlagSH == 1) {
				console.log(row);
				//row.levelCode = row.courseDescription;
				//row.departmentCode = row.departmentDescription;
				//row.gradingComponentCode = row.gradingComponentDescription;
				addRecordSH(row);
				appendFlagSH = 0;
				alert('add');
			} else if(operationsSH == 'save' && appendFlagSH == 0) {
				//row.levelCode = row.courseDescription;
				//row.departmentCode = row.departmentDescription;
				//row.gradingComponentCode = row.gradingComponentDescription;
				
				updateRecordSH(row);
				alert('update');
			}
        }
        function appendSH(){ 
			if (endEditingSH()){
				appendFlagSH = 1;
                $('#dgSH').datagrid('appendRow',{});
                editIndexSH = $('#dgSH').datagrid('getRows').length-1;
                $('#dgSH').datagrid('selectRow', editIndexSH)
                        .datagrid('beginEdit', editIndexSH);
            }
        }
		
		
		
        function removeitSH(){ 
            if (editIndexSH == undefined){return}
				var result = confirm("Proceed with delete?");
				if (result) {
					//Logic to delete the item
					var ID = $('#dgSH').datagrid('getRows')[editIndexSH].ID;
					//var departmentCode = $('#dg').datagrid('getRows')[editIndex].departmentCode;
					//var gradingComponentCode = $('#dg').datagrid('getRows')[editIndex].gradingComponentCode;
					$('#dgSH').datagrid('cancelEdit', editIndexSH)
							.datagrid('deleteRow', editIndexSH);
							
					
					deleteRecordSH(ID);
					deleteIndexSH = editIndexSH;
					editIndexSH = undefined;
					deleteCtrSH++;
					appendFlagSH = 0;
				}
        }

		function cancelSH() {
            if (editIndexSH == undefined){return}
			$('#dgSH').datagrid('cancelEdit', editIndexSH);
			
		}
		
        function acceptSH(){ 
			operationsSH = 'save';
			
            if (endEditingSH()){
                $('#dgSH').datagrid('acceptChanges');
				
            }
        }
		
        function rejectSH(){ 
			if(deleteCtrSH == 0 || appendFlagSH == 1) {
				$('#dgSH').datagrid('rejectChanges');
				editIndexSH = undefined;
			}
        }
        function getChangesSH(){
            var rows = $('#dgSH').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
		
		
		function addRecordSH(row) {
			//alert(row.levelCode + row.subjectComponentCode + row.gradingComponentCode + row.componentPercentage);
			jQuery.ajax({
				url: "insertGradeComponentSHEGIS",
				data: { 
					'subjectComponentCode': row.subjectComponentCode, 
					'gradingComponentCode': row.gradingComponentCode, 
					'componentPercentage': row.componentPercentage, 
					
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

		
		function updateRecordSH(row) {
			jQuery.ajax({
				url: "updateGradingComponentSHEGIS",
				data: { 
					'ID': row.ID, 
					'subjectComponentCode': row.subjectComponentCode, 
					'gradingComponentCode': row.gradingComponentCode, 
					'componentPercentage': row.componentPercentage, 
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
		
		
		function deleteRecordSH(ID) {
			//alert(employeeNumber + departmentCode + designationDescription);
			jQuery.ajax({
				url: "deleteGradeComponentSHEGIS",
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