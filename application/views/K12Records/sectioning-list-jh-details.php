<div class="level2">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />



	  <table id="dg1" class="easyui-datagrid" title="<?php echo " TERM: <u>" . $_SESSION['sy'] . "</u>"; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tb',
					url: 'getJuniorHighStudentsListK12Records',
					method: 'get',
					onClickCell: onClickCell,
					onEndEdit: onEndEdit,
                    queryParams:{yearLevel:'<?php echo $yearLevel;?>'
					}"  
				">
			<thead data-options="frozen:true">
				<tr>
	
					<th data-options="field:'ID',width:25">ID</th>
					<th data-options="field:'studentNumber',width:100" >Student Number</th>
					<th data-options="field:'fullName',width:300" >Full Name</th>
				</tr>
			</thead>
			<thead>
				<tr>
					
					<th data-options="field:'sectionCode',width:250,
							formatter:function(value,row){
								return row.sectionCode;
							},
							editor:{
								type:'combobox',
								options:{
									valueField:'sectionCode',
									textField:'sectionCode',
									method:'get',
									url:'getSectionByLevelJHK12Records',
									queryParams:{yearLevel:'<?php echo $yearLevel;?>'
									},  
									required:true
								}
							}">Section</th>
					
					
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


	<script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/datagrid-filter.js"></script>
	
	<script type="text/javascript">
	$(function(){
		var dg = $('#dg1').datagrid();
		dg.datagrid('enableFilter');
	});
	</script>
	
    <script type="text/javascript">
	
        var editIndex = undefined;
		var operations = undefined;
        function endEditing(){
            if (editIndex == undefined){return true}
            if ($('#dg1').datagrid('validateRow', editIndex)){
                $('#dg1').datagrid('endEdit', editIndex);
                editIndex = undefined;
                return true;
            } else {
                return false;
            }
        }
        function onClickCell(index, field){
            if (editIndex != index){
                if (endEditing()){
                    $('#dg1').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                    var ed = $('#dg1').datagrid('getEditor', {index:index,field:field});
                    if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndex = index;
                } else {
                    setTimeout(function(){
                        $('#dg1').datagrid('selectRow', editIndex);
                    },0);
                }
            }
        }
        function onEndEdit(index, row){
			if(operations == 'save') {
					alert('records will be updated!!!');
					var rows = $('#dg1').datagrid('getRows');
					console.log(rows);
					$.each(rows, function(i, row) {
						updateRecord(row, i);					 
					});
					alert('records updated!!!');
			}
        }
		
		
        function append(){
            if (endEditing()){
                $('#dg1').datagrid('appendRow',{status:'P'});
                editIndex = $('#dg1').datagrid('getRows').length-1;
                $('#dg1').datagrid('selectRow', editIndex)
                        .datagrid('beginEdit', editIndex);
            }
        }
        function removeit(){
            if (editIndex == undefined){return}
            $('#dg1').datagrid('cancelEdit', editIndex)
                    .datagrid('deleteRow', editIndex);
            editIndex = undefined;
        }
        function accept(){
			operations = 'save';
            if (endEditing()){
                $('#dg1').datagrid('acceptChanges');
            }
        }
        function reject(){
            $('#dg1').datagrid('rejectChanges');
            editIndex = undefined;
        }
        function getChanges(){
            var rows = $('#dg1').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
		
		function updateRecord(row, i) {
			console.log(row);
			jQuery.ajax({
				url: "updateSectioningJuniorHighK12Records",
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