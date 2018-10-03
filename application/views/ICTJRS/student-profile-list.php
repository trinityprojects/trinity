<div class="level1">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />

			<script type="text/javascript">
				function doSearch(){
					$('#tt').datagrid('load',{
						lastName: $('#lastName').val(),
						firstName: $('#firstName').val(),
					});
				}
			</script> 

		<table id="tt" class="easyui-datagrid" style="width:100%;max-width:100%;padding:5px 5px;font-size: 5px;"
				url="getAllStudentsListREGISTRAR" toolbar="#tb"
				title="Employee List" iconCls="icon-save"
				rownumbers="true" pagination="true" data-options="singleSelect: true,
				rowStyler: function(){
								return 'padding:5px;';
						}         
				">

			<thead>
				<tr >
					<th field="ID" >ID</th>
					<th field="studentNumber" >Student Number</th>
					<th field="lastName"  >Last Name</th>
					<th field="firstName" >First Name</th>
					<th field="middleName" >Middle Name</th>
					<th field="birthDate" >Birth Date</th>
					<th field="birthPlace" >Birth Place</th>
					
				</tr>
			</thead>
		</table>
		<div id="tb" style="padding:2px">
			<span>Last Name:</span>
			<input id="lastName" style="line-height:15px;border:1px solid #ccc">
			<span>First Name:</span>
			<input id="firstName" style="line-height:15px;border:1px solid #ccc">
			<input id="active" style="line-height:15px;border:1px solid #ccc">
			<a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>

		</div>




		<script type="text/javascript">
		$(document).ready(function(){

			$('#tt').datagrid({

				onClickRow: function() {

					var row = $('#tt').datagrid('getSelected');
				   // $('#tt').datagrid('unselectAll');
				   row.styler = function(){
					return 'background-color:yellow';
					};

				   // $('#tt').datagrid('enableCellEditing');
					//$('#tt').datagrid('options').onBeforeSelect = function(){return true;};
				   
					jQuery.ajax({
					url: 'THRIMS/showEmployeeProfileDetails',
					data: 'ID='+row.ID,
					type: "POST",
					success: function(response) {
						$('div.level2').remove();

						$('.leveltwocontent').append(response);
				
						console.log("the request is successful for content1!");
					},
								
					error: function(error) {
						console.log('the page was NOT loaded', error);
						$('.leveltwocontent').html(error);
					},
								
					complete: function(xhr, status) {
						console.log("The request is complete!");
					}
				}); //jQuery.ajax({

				}

			});
			return false;
			
		});
		</script> 

</div>