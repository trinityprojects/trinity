<div class="level1">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />

			<script type="text/javascript">
				function doSearch(){
					$('#tt').datagrid('load',{
						lastNameUser: $('#lastNameUser').val(),
						firstNameUser: $('#firstNameUser').val(),
					});
				}
			</script> 

		<table id="tt" class="easyui-datagrid" style="width:100%;max-width:100%;padding:5px 5px;font-size: 5px;"
				url="getAllUsersList" toolbar="#tb"
				title="USERS List" iconCls="icon-save"
				rownumbers="true" pagination="true" data-options="singleSelect: true,
				rowStyler: function(){
								return 'padding:5px;';
						}         
				">

			<thead>
				<tr >
					<th data-options="field:'ID',align:'right'">ID</th>
					<th field="userName" >User Name</th>
					<th field="emailAddress"  >Email Address</th>
					<th field="firstNameUser" >First Name</th>
					<th field="lastNameUser" >Last Name</th>
					<th field="companyNameUser" >Group</th>
					<th field="userNumber" >User Number</th>
					
				</tr>
			</thead>
		</table>
		<div id="tb" style="padding:2px">
			<span>Last Name:</span>
			<input id="lastNameUser" style="line-height:15px;border:1px solid #ccc">
			<span>First Name:</span>
			<input id="firstNameUser" style="line-height:15px;border:1px solid #ccc">
			<a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch()">Search</a>

		</div>




		<script type="text/javascript">
		$(document).ready(function(){

			$('#tt').datagrid({

				onClickRow: function() {

					var row = $('#tt').datagrid('getSelected');
				   
					jQuery.ajax({
					url: 'ACCOUNT/showAccountUserDetails',
					data: 'ID='+row.ID,
					type: "POST",
					success: function(response) {
						$('div.level2').remove();

						$('.leveltwocontent').html(response);
				
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