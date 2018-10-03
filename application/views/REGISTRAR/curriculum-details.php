<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />


<div id="tabpanel" class="easyui-tabs" style="width:100%;max-width:100%;">


	  <table id="dg" class="easyui-datagrid" title="Curriculum Details for <?php echo " TERM: " . $_SESSION['sy']; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tb',
					url: 'getCurriculumDetailsREGISTRAR?courseCode=<?php echo $courseCode; ?>&sy=<?php echo $sy; ?>',
					method: 'get',
					onClickCell: onClickCell,
					onEndEdit: onEndEdit
				">
			<thead>
				<tr>
					<th data-options="field:'ID',width:50">ID</th>
					<th data-options="field:'yearLevel',width:50">Level</th>
					<th data-options="field:'subjectCode',width:150">Subject Code</th>
					<th data-options="field:'sem',width:350">Sem</th>

					<!--<th data-options="field:'departmentCode',width:200,
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
							}">Department</th>-->
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
	


	
	
</div>