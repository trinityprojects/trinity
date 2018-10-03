<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />


<div id="tabpanel" class="easyui-tabs" style="width:100%;max-width:100%;">


	<div title="Elementary" style="padding:10px;">
	  <table id="dg" class="easyui-datagrid" title="Elementary Faculty Assignment for <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tb',
					url: 'getSectionElementaryEGIS',
					method: 'get',
					onClickCell: onClickCell,
					onEndEdit: onEndEdit
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>
					<th data-options="field:'sectionCode',width:150">Section Code</th>
					<th data-options="field:'subjectDescription',width:350">Subject</th>

					<th data-options="field:'fullName',width:450,
							formatter:function(value,row){
								return row.fullName;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'fullName',
									textField:'fullName',
									method:'get',
									url:'getFacultyListK12',
									required:true
								}
							}">Faculty Name;Employee Number</th>
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
	  <table id="dgJH" class="easyui-datagrid" title="Junior High Faculty Assignment for <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tbJH',
					url: 'getSectionJuniorHighEGIS',
					method: 'get',
					onClickCell: onClickCellJH,
					onEndEdit: onEndEditJH
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>
					<th data-options="field:'sectionCode',width:150">Section Code</th>
					<th data-options="field:'subjectDescription',width:350">Subject</th>

					<th data-options="field:'fullName',width:450,
							formatter:function(value,row){
								return row.fullName;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'fullName',
									textField:'fullName',
									method:'get',
									url:'getFacultyListK12',
									required:true
								}
							}">Faculty Name;Employee Number</th>
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
	

	
	<div title="Senior High (Sem A)" style="padding:10px;">
	  <table id="dgSHA" class="easyui-datagrid" title="Senior High Faculty Assignment for First Semester <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tbSHA',
					url: 'getSectionSeniorHighSemAEGIS',
					method: 'get',
					onClickCell: onClickCellSHA,
					onEndEdit: onEndEditSHA
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>
					<th data-options="field:'sectionCode',width:150">Section Code</th>
					<th data-options="field:'subjectDescription',width:350">Subject</th>

					<th data-options="field:'fullName',width:450,
							formatter:function(value,row){
								return row.fullName;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'fullName',
									textField:'fullName',
									method:'get',
									url:'getFacultyListK12',
									required:true
								}
							}">Faculty Name;Employee Number</th>
				</tr>
			</thead>
		</table>
		<div id="tbSHA" style="height:auto">
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>-->
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>-->
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptSHA()">Save</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="rejectSHA()">Reset</a>
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
		</div>
		
	</div>		
	




	<div title="Senior High (Sem B)" style="padding:10px;">
	  <table id="dgSHB" class="easyui-datagrid" title="Senior High Faculty Assignment for Second Semester <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tbSHB',
					url: 'getSectionSeniorHighSemBEGIS',
					method: 'get',
					onClickCell: onClickCellSHB,
					onEndEdit: onEndEditSHB
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>
					<th data-options="field:'sectionCode',width:150">Section Code</th>
					<th data-options="field:'subjectDescription',width:350">Subject</th>

					<th data-options="field:'fullName',width:450,
							formatter:function(value,row){
								return row.fullName;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'fullName',
									textField:'fullName',
									method:'get',
									url:'getFacultyListK12',
									required:true
								}
							}">Faculty Name;Employee Number</th>
				</tr>
			</thead>
		</table>
		<div id="tbSHB" style="height:auto">
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>-->
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>-->
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptSHB()">Save</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="rejectSHB()">Reset</a>
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
				/*console.log(row);
				var ed = $(this).datagrid('getEditor', {
					index: index,
					field: 'fullName'
				});
				var employeeNumber = $(ed.target).combobox('getValue');
				//alert(employeeNumber);
				var ed = $(this).datagrid('getEditor', {
					index: index,
					field: 'fullName'
				});
				row.fullName = $(ed.target).combobox('getText');
				//alert(row.fullName);
				updateRecord(row, employeeNumber);*/
				
				alert('records will be updated!!!');
				var rows = $('#dg').datagrid('getRows');
				
				$.each(rows, function(i, row) {
					updateRecord(row, i);					 
				});
				operations = '';
				
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
				url: "updateSectionElementaryEGIS",
				data: { 
					'ID': row.ID, 
					'fullName': row.fullName, 
				},
				type: "POST",
				success:function(data){
					console.log(data);
					var resultValue = $.parseJSON(data);
					if(resultValue['success'] == 1) {
						//$('div.panel.combo-p.panel-htop').remove();
						
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
				/*console.log(row);
				var ed = $(this).datagrid('getEditor', {
					index: index,
					field: 'fullName'
				});
				var employeeNumber = $(ed.target).combobox('getValue');
				//alert(employeeNumber);
				var ed = $(this).datagrid('getEditor', {
					index: index,
					field: 'fullName'
				});
				row.fullName = $(ed.target).combobox('getText');
				//alert(row.fullName);
				updateRecordJH(row, employeeNumber);*/
				
				
				alert('records will be updated!!!');
				var rows = $('#dgJH').datagrid('getRows');
				
				$.each(rows, function(i, row) {
					updateRecordJH(row, i);					 
				});
				$('div.tooltip.tooltip-right').remove();
				operations = '';
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
				url: "updateSectionJuniorHighEGIS",
				data: { 
					'ID': row.ID, 
					'fullName': row.fullName, 
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
		var dgSHA = $('#dgSHA').datagrid();
		dgSHA.datagrid('enableFilter');
	});
	</script>


    <script type="text/javascript">
        var editIndexSHA = undefined;
		var operationsSHA = undefined;
        function endEditingSHA(){
            if (editIndexSHA == undefined){return true}
            if ($('#dgSHA').datagrid('validateRow', editIndexSHA)){
                $('#dgSHA').datagrid('endEdit', editIndexSHA);
                editIndexSHA = undefined;
                return true;
            } else {
                return false;
            }
        }
        function onClickCellSHA(index, field){
            if (editIndexSHA != index){
				$('div.tooltip.tooltip-right').remove();
				operations = '';				
                if (endEditingSHA()){
                    $('#dgSHA').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                    var ed = $('#dgSHA').datagrid('getEditor', {index:index,field:field});
                    if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndexSHA = index;
                } else {
                    setTimeout(function(){
                        $('#dgSHA').datagrid('selectRow', editIndexSHA);
                    },0);
                }
            }
        }
        function onEndEditSHA(index, row){
			if(operations == 'save') {
				/*console.log(row);
				var ed = $(this).datagrid('getEditor', {
					index: index,
					field: 'fullName'
				});
				var employeeNumber = $(ed.target).combobox('getValue');
				//alert(employeeNumber);
				var ed = $(this).datagrid('getEditor', {
					index: index,
					field: 'fullName'
				});
				row.fullName = $(ed.target).combobox('getText');
				//alert(row.fullName);
				updateRecordJH(row, employeeNumber);*/
				
				
				alert('records will be updated!!!');
				var rows = $('#dgSHA').datagrid('getRows');
				
				$.each(rows, function(i, row) {
					updateRecordSHA(row, i);					 
				});
				$('div.tooltip.tooltip-right').remove();
				operations = '';
				alert('records updated!!!');
				
				
			}
        }
		
		
        function appendSHA(){
            if (endEditingSHA()){
                editIndexSHA = $('#dgSHA').datagrid('getRows').length-1;
                $('#dgSHA').datagrid('selectRow', editIndexSHA)
                        .datagrid('beginEdit', editIndexSHA);
            }
        }
        function removeitSHA(){
            if (editIndexSHA == undefined){return}
            $('#dgSHA').datagrid('cancelEdit', editIndexSHA)
                    .datagrid('deleteRow', editIndexSHA);
            editIndexSHA = undefined;
        }
        function acceptSHA(){
			operations = 'save';
            if (endEditingSHA()){
                $('#dgSHA').datagrid('acceptChanges');
            }
        }
        function rejectSHA(){
            $('#dgSHA').datagrid('rejectChanges');
            editIndexSHA = undefined;
        }
        function getChangesSHA(){
            var rows = $('#dgSHA').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
		
		function updateRecordSHA(row, i) {
			jQuery.ajax({
				url: "updateSectionSeniorHighEGIS",
				data: { 
					'ID': row.ID, 
					'fullName': row.fullName, 
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
		var dgSHB = $('#dgSHB').datagrid();
		dgSHB.datagrid('enableFilter');
	});
	</script>
	
	
    <script type="text/javascript">
        var editIndexSHB = undefined;
		var operationsSHB = undefined;
        function endEditingSHB(){
            if (editIndexSHB == undefined){return true}
            if ($('#dgSHB').datagrid('validateRow', editIndexSHB)){
                $('#dgSHB').datagrid('endEdit', editIndexSHB);
                editIndexSHB = undefined;
                return true;
            } else {
                return false;
            }
        }
        function onClickCellSHB(index, field){
            if (editIndexSHB != index){
				$('div.tooltip.tooltip-right').remove();
				operations = '';				
                if (endEditingSHB()){
                    $('#dgSHB').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                    var ed = $('#dgSHB').datagrid('getEditor', {index:index,field:field});
                    if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndexSHB = index;
                } else {
                    setTimeout(function(){
                        $('#dgSHB').datagrid('selectRow', editIndexSHB);
                    },0);
                }
            }
        }
        function onEndEditSHB(index, row){
			if(operations == 'save') {
				/*console.log(row);
				var ed = $(this).datagrid('getEditor', {
					index: index,
					field: 'fullName'
				});
				var employeeNumber = $(ed.target).combobox('getValue');
				//alert(employeeNumber);
				var ed = $(this).datagrid('getEditor', {
					index: index,
					field: 'fullName'
				});
				row.fullName = $(ed.target).combobox('getText');
				//alert(row.fullName);
				updateRecordJH(row, employeeNumber);*/
				
				
				alert('records will be updated!!!');
				var rows = $('#dgSHB').datagrid('getRows');
				
				$.each(rows, function(i, row) {
					updateRecordSHB(row, i);					 
				});
				$('div.tooltip.tooltip-right').remove();
				operations = '';
				alert('records updated!!!');
				
				
			}
        }
		
		
        function appendSHB(){
            if (endEditingSHB()){
                editIndexSHB = $('#dgSHB').datagrid('getRows').length-1;
                $('#dgSHB').datagrid('selectRow', editIndexSHB)
                        .datagrid('beginEdit', editIndexSHB);
            }
        }
        function removeitSHB(){
            if (editIndexSHB == undefined){return}
            $('#dgSHB').datagrid('cancelEdit', editIndexSHB)
                    .datagrid('deleteRow', editIndexSHB);
            editIndexSHB = undefined;
        }
        function acceptSHB(){
			operations = 'save';
            if (endEditingSHB()){
                $('#dgSHB').datagrid('acceptChanges');
            }
        }
        function rejectSHB(){
            $('#dgSHB').datagrid('rejectChanges');
            editIndexSHB = undefined;
        }
        function getChangesSHB(){
            var rows = $('#dgSHB').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
		
		function updateRecordSHB(row, i) {
			jQuery.ajax({
				url: "updateSectionSeniorHighEGIS",
				data: { 
					'ID': row.ID, 
					'fullName': row.fullName, 
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