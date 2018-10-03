<div class="level1">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />


	<div id="tabpanel" class="easyui-tabs" style="width:30%;max-width:30%;">


		<div title="Senior High" style="padding:10px;">
	
	
			<table id="tt" class="easyui-datagrid" style="width:100%;max-width:100%;padding:5px 5px;font-size: 5px;"
					url="getSeniorHighCourseListK12Records" toolbar="#tb"
					title="Senior High course List for the term <?php echo '<b><u>' . $_SESSION['sy'] . '</u></b>'; ?>" iconCls="icon-save"
					rownumbers="true" pagination="true" data-options="singleSelect: true,
					rowStyler: function(){
									return 'padding:5px;';
							}       
					">

				<thead>
					<tr >
						<th field="courseCode" >Strand</th>
					</tr>
				</thead>
			</table>
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
					url: 'K12Records/showStudentsListSH',
					data: { 
						'courseCode' : row.courseCode,
						
					},
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




		<div title="Junior High" style="padding:10px;">
	
	
			<table id="tt1" class="easyui-datagrid" style="width:100%;max-width:100%;padding:5px 5px;font-size: 5px;"
					url="getJuniorHighCourseListK12Records" toolbar="#tb"
					title="Junior High level List for the term <?php echo '<b><u>' . $_SESSION['sy'] . '</u></b>'; ?>" iconCls="icon-save"
					rownumbers="true" pagination="true" data-options="singleSelect: true,
					rowStyler: function(){
									return 'padding:5px;';
							}       
					">

				<thead>
					<tr >
						<th field="yearLevel" >Level</th>
					</tr>
				</thead>
			</table>
		</div>




		<script type="text/javascript">
		$(document).ready(function(){

			$('#tt1').datagrid({

				onClickRow: function() {

					var row = $('#tt1').datagrid('getSelected');
				   // $('#tt').datagrid('unselectAll');
				   row.styler = function(){
					return 'background-color:yellow';
					};

				   // $('#tt').datagrid('enableCellEditing');
					//$('#tt').datagrid('options').onBeforeSelect = function(){return true;};
				   
					jQuery.ajax({
					url: 'K12Records/showStudentsListJH',
					data: { 
						'yearLevel' : row.yearLevel,
						
					},
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

</div>