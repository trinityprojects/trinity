<div class="level2">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />


<div id="tabpanel" class="easyui-tabs" style="width:100%;max-width:100%;">


	<div title="First Sem - MidTerm" style="padding:10px;">
	  <table id="dg1" class="easyui-datagrid" title="<?php echo " TERM: <u>" . $_SESSION['sy'] . "</u>"; ?>, <?php echo " Section: <u>" . $sectionCode . "</u>"; ?>, <?php echo " Subject: <u>" . $subjectDescription . "</u>"; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tb',
					url: 'getMySectionScoreSheet1EGIS',
					method: 'get',
					onClickCell: onClickCell,
					onEndEdit: onEndEdit,
                    queryParams:{sectionCode:'<?php echo $sectionCode;?>',
						subjectCode: '<?php echo $subjectCode;?>'
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
					<th data-options="field:'WW1',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 1</th>
					<th data-options="field:'WW2',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 2</th>
					<th data-options="field:'WW3',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 3</th>
					<th data-options="field:'WW4',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 4</th>
					<th data-options="field:'WW5',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 5</th>
					<th data-options="field:'WW6',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 6</th>
					<th data-options="field:'WW7',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 7</th>
					<th data-options="field:'WW8',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 8</th>
					<th data-options="field:'WW9',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 9</th>
					<th data-options="field:'WW10',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 10</th>
					<th data-options="field:'WW11',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 11</th>
					<th data-options="field:'WW12',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 12</th>
					<th data-options="field:'WW13',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 13</th>
					<th data-options="field:'WW14',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 14</th>
					<th data-options="field:'WW15',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 15</th>
					<th data-options="field:'PT1',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 1</th>
					<th data-options="field:'PT2',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 2</th>
					<th data-options="field:'PT3',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 3</th>
					<th data-options="field:'PT4',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 4</th>
					<th data-options="field:'PT5',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 5</th>
					<th data-options="field:'PT6',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 6</th>
					<th data-options="field:'PT7',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 7</th>
					<th data-options="field:'PT8',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 8</th>
					<th data-options="field:'PT9',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 9</th>
					<th data-options="field:'PT10',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 10</th>
					<th data-options="field:'QA1',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">QA 1</th>
					
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
		var dg1 = $('#dg1').datagrid();
		dg1.datagrid('enableFilter');
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
				url: "updateScoreSheetFirstGradingEGIS",
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
	
	
	
	
	
	<div title="First Sem - Finals" style="padding:10px;">
	  <table id="dg2" class="easyui-datagrid" title="<?php echo " TERM: <u>" . $_SESSION['sy'] . "</u>"; ?>, <?php echo " Section: <u>" . $sectionCode . "</u>"; ?>, <?php echo " Subject: <u>" . $subjectDescription . "</u>"; ?>" style="width:auto;height:450px"
				data-options="
					iconCls: 'icon-edit',
					singleSelect: true,
					toolbar: '#tb2',
					url: 'getMySectionScoreSheet2EGIS',
					method: 'get',
					onClickCell: onClickCell2,
					onEndEdit: onEndEdit2,
                    queryParams:{sectionCode:'<?php echo $sectionCode;?>',
						subjectCode: '<?php echo $subjectCode;?>'
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
					<th data-options="field:'WW1',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 1</th>
					<th data-options="field:'WW2',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 2</th>
					<th data-options="field:'WW3',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 3</th>
					<th data-options="field:'WW4',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 4</th>
					<th data-options="field:'WW5',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 5</th>
					<th data-options="field:'WW6',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 6</th>
					<th data-options="field:'WW7',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 7</th>
					<th data-options="field:'WW8',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 8</th>
					<th data-options="field:'WW9',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 9</th>
					<th data-options="field:'WW10',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 10</th>
					<th data-options="field:'WW11',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 11</th>
					<th data-options="field:'WW12',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 12</th>
					<th data-options="field:'WW13',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 13</th>
					<th data-options="field:'WW14',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 14</th>
					<th data-options="field:'WW15',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">WW 15</th>
					<th data-options="field:'PT1',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 1</th>
					<th data-options="field:'PT2',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 2</th>
					<th data-options="field:'PT3',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 3</th>
					<th data-options="field:'PT4',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 4</th>
					<th data-options="field:'PT5',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 5</th>
					<th data-options="field:'PT6',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 6</th>
					<th data-options="field:'PT7',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 7</th>
					<th data-options="field:'PT8',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 8</th>
					<th data-options="field:'PT9',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 9</th>
					<th data-options="field:'PT10',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">PT 10</th>
					<th data-options="field:'QA1',width:50,align:'right',editor:{type:'numberbox',options:{precision:0}}">QA 1</th>
					
				</tr>
			</thead>
		</table>
		<div id="tb2" style="height:auto">
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>-->
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>-->
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept2()">Save</a>
			<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject2()">Reset</a>
			<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
		</div>
		
	</div>	
	

</div>	
    
	
	<script type="text/javascript">
	$(function(){
		var dg2 = $('#dg2').datagrid();
		dg2.datagrid('enableFilter');
	});
	</script>
	
    <script type="text/javascript">
	
        var editIndex2 = undefined;
		var operations2 = undefined;
        function endEditing2(){
            if (editIndex2 == undefined){return true}
            if ($('#dg2').datagrid('validateRow', editIndex2)){
                $('#dg2').datagrid('endEdit', editIndex2);
                editIndex2 = undefined;
                return true;
            } else {
                return false;
            }
        }
        function onClickCell2(index, field){
            if (editIndex2 != index){
                if (endEditing2()){
                    $('#dg2').datagrid('selectRow', index)
                            .datagrid('beginEdit', index);
                    var ed = $('#dg2').datagrid('getEditor', {index:index,field:field});
                    if (ed){
                        ($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
                    }
                    editIndex2 = index;
                } else {
                    setTimeout(function(){
                        $('#dg2').datagrid('selectRow', editIndex2);
                    },0);
                }
            }
        }
        function onEndEdit2(index, row){
			if(operations2 == 'save') {
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
				//alert('hello');
					alert('records will be updated!!!');
					var rows = $('#dg2').datagrid('getRows');
					console.log(rows);
					$.each(rows, function(i, row) {
						updateRecord2(row, i);					 
					});
					alert('records updated!!!');
			}
        }
		
		
        function append2(){
            if (endEditing2()){
                editIndex2 = $('#dg2').datagrid('getRows').length-1;
                $('#dg2').datagrid('selectRow', editIndex2)
                        .datagrid('beginEdit', editIndex2);
            }
        }
        function removeit2(){
            if (editIndex2 == undefined){return}
            $('#dg2').datagrid('cancelEdit', editIndex2)
                    .datagrid('deleteRow', editIndex2);
            editIndex2 = undefined;
        }
        function accept2(){
			operations2 = 'save';
            if (endEditing2()){
                $('#dg2').datagrid('acceptChanges');
            }
        }
        function reject2(){
            $('#dg2').datagrid('rejectChanges');
            editIndex2 = undefined;
        }
        function getChanges2(){
            var rows = $('#dg2').datagrid('getChanges');
            alert(rows.length+' rows are changed!');
        }
		
		function updateRecord2(row, i) {
			console.log(row);
			jQuery.ajax({
				url: "updateScoreSheetSecondGradingEGIS",
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