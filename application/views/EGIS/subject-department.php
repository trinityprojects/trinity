<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />


<div id="tabpanel" class="easyui-tabs" style="width:100%;max-width:100%;">


	<div title="Elementary" style="padding:10px;">
	  <table id="dg" class="easyui-datagrid" title="Elementary Subject Department Assignment for <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tb',
					url: 'getSubjectElementaryEGIS',
					method: 'get',
					onClickCell: onClickCell,
					onEndEdit: onEndEdit
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>
					<th data-options="field:'subjectCode',width:150">Subject Code</th>
					<th data-options="field:'subjectDescription',width:350">Subject</th>
					<th data-options="field:'yearLevel',width:50">Level</th>

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
				</tr>
			</thead>
		</table>
		<div id="tb" style="height:auto">
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>-->
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>-->
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">Save</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reset</a>
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
		</div>
	</div>	


	
	<div title="Junior High" style="padding:10px;">
	  <table id="dgJH" class="easyui-datagrid" title="Subject Department Assignment for <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tbJH',
					url: 'getSubjectJuniorHighEGIS',
					method: 'get',
					onClickCell: onClickCellJH,
					onEndEdit: onEndEditJH
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>
					<th data-options="field:'subjectCode',width:150">Subject Code</th>
					<th data-options="field:'subjectDescription',width:350">Subject</th>
					<th data-options="field:'yearLevel',width:50">Level</th>

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
				</tr>
			</thead>
		</table>
		<div id="tbJH" style="height:auto">
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>-->
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>-->
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptJH()">Save</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="rejectJH()">Reset</a>
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
		</div>
		
	</div>	
	

	<div title="Senior High" style="padding:10px;">
	  <table id="dgSH" class="easyui-datagrid" title="Subject Department Assignment for <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tbSH',
					url: 'getSubjectSeniorHighEGIS',
					method: 'get',
					onClickCell: onClickCellSH,
					onEndEdit: onEndEditSH
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>
					<th data-options="field:'subjectCode',width:150">Subject Code</th>
					<th data-options="field:'subjectDescription',width:350">Subject</th>
					<th data-options="field:'yearLevel',width:50">Level</th>
					<th data-options="field:'sem',width:75">Semester</th>
					<th data-options="field:'courseCode',width:100">Strand</th>

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
									url:'getSubjectComponentK12',
									required:true
								}
							}">Subject Component</th>
				</tr>
			</thead>
		</table>
		<div id="tbSH" style="height:auto">
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>-->
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>-->
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptSH()">Save</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="rejectSH()">Reset</a>
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
		</div>
		
	</div>	
	
	
	
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
				$('div.tooltip.tooltip-right').remove();
				operations = '';				
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
			if(operations == 'save') {
				console.log(row);
					alert('records will be updated!!!');
					var rows = $('#dg').datagrid('getRows');
					console.log(rows);
					$.each(rows, function(i, row) {
						updateRecord(row, i);					 
					});
					alert('records updated!!!');
			}
        }
		
		
        function append(){
            if (endEditing()){
                $('#dg').datagrid('appendRow',{status:'P'});
                editIndex = $('#dg').datagrid('getRows').length-1;
                $('#dg').datagrid('selectRow', editIndex)
                        .datagrid('beginEdit', editIndex);
            }
        }
        function removeit(){
            if (editIndex == undefined){return}
            $('#dg').datagrid('cancelEdit', editIndex)
                    .datagrid('deleteRow', editIndex);
            editIndex = undefined;
        }
        function accept(){
			operations = 'save';
            if (endEditing()){
                $('#dg').datagrid('acceptChanges');
            }
        }
        function reject(){
            $('#dg').datagrid('rejectChanges');
            editIndex = undefined;
        }
        function getChanges(){
            var rows = $('#dg').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
		
		function updateRecord(row, i) {
			jQuery.ajax({
				url: "updateSubjectDepartmentEGIS",
				data: { 
					'row': row, 
					'i': i, 
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
	$(function(){
		var dgJH = $('#dgJH').datagrid();
		dgJH.datagrid('enableFilter');
	});
	</script>
	
    <script type="text/javascript">
        var editIndexJH = undefined;
		var operationsJH = undefined;
        function endEditingJH(){
            if (editIndexJH == undefined){return true}
            if ($('#dgJH').datagrid('validateRow', editIndexJH)){
                $('#dgJH').datagrid('endEdit', editIndexJH);
                editIndexJH = undefined;
                return true;
            } else {
                return false;
            }
        }
        function onClickCellJH(index, field){
            if (editIndexJH != index){
				$('div.tooltip.tooltip-right').remove();
				operations = '';				
				
                if (endEditingJH()){
                    $('#dgJH').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                    var ed = $('#dgJH').datagrid('getEditor', {index:index,field:field});
                    if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndexJH = index;
                } else {
                    setTimeout(function(){
                        $('#dgJH').datagrid('selectRow', editIndexJH);
                    },0);
                }
            }
        }
        function onEndEditJH(index, row){
			if(operations == 'save') {
				console.log(row);
					alert('records will be updated!!!');
					var rows = $('#dgJH').datagrid('getRows');
					console.log(rows);
					$.each(rows, function(i, row) {
						updateRecordJH(row, i);					 
					});
					alert('records updated!!!');
			}
			
        }
		
		
        function appendJH(){
            if (endEditingJH()){
                editIndexJH = $('#dgJH').datagrid('getRows').length-1;
                $('#dgJH').datagrid('selectRow', editIndexJH)
                        .datagrid('beginEdit', editIndexJH);
            }
        }
        function removeitJH(){
            if (editIndexJH == undefined){return}
            $('#dgJH').datagrid('cancelEdit', editIndexJH)
                    .datagrid('deleteRow', editIndexJH);
            editIndexJH = undefined;
        }
        function acceptJH(){
			operations = 'save';
            if (endEditingJH()){
                $('#dgJH').datagrid('acceptChanges');
            }
        }
        function rejectJH(){
            $('#dgJH').datagrid('rejectChanges');
            editIndexJH = undefined;
        }
        function getChangesJH(){
            var rows = $('#dgJH').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
		
		function updateRecordJH(row, i) {
			jQuery.ajax({
				url: "updateSubjectDepartmentJHEGIS",
				data: { 
					'row': row, 
					'i': i, 
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
	$(function(){
		var dgSH = $('#dgSH').datagrid();
		dgSH.datagrid('enableFilter');
	});
	</script>


    <script type="text/javascript">
        var editIndexSH = undefined;
		var operationsSH = undefined;
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
				$('div.tooltip.tooltip-right').remove();
				operations = '';				
				
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
                        $('#dgSH').datagrid('selectRow', editIndexSH);
                    },0);
                }
            }
        }
        function onEndEditSH(index, row){
			if(operations == 'save') {
				console.log(row);
					alert('records will be updated!!!');
					var rows = $('#dgSH').datagrid('getRows');
					console.log(rows);
					$.each(rows, function(i, row) {
						updateRecordSH(row, i);					 
					});
					alert('records updated!!!');
			}
        }
		
		
        function appendSH(){
            if (endEditingSH()){
                editIndexSH = $('#dgSH').datagrid('getRows').length-1;
                $('#dgSH').datagrid('selectRow', editIndexSH)
                        .datagrid('beginEdit', editIndexSH);
            }
        }
        function removeitSH(){
            if (editIndexSH == undefined){return}
            $('#dgSH').datagrid('cancelEdit', editIndexSH)
                    .datagrid('deleteRow', editIndexSH);
            editIndexSH = undefined;
        }
        function acceptSH(){
			operations = 'save';
            if (endEditingSH()){
                $('#dgSH').datagrid('acceptChanges');
            }
        }
        function rejectSH(){
            $('#dgSH').datagrid('rejectChanges');
            editIndexSH = undefined;
        }
        function getChangesSH(){
            var rows = $('#dgSH').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
		
		function updateRecordSH(row, i) {
			jQuery.ajax({
				url: "updateSubjectComponentSHEGIS",
				data: { 
					'row': row, 
					'i': i, 
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