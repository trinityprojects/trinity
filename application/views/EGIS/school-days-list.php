<div class="level1">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/egis/egis.css" />
 <script src="http://handsontable.com/dist/handsontable.full.js"></script>
    <link rel="stylesheet" media="screen" href="http://handsontable.com/dist/handsontable.full.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />

        <div id="p" class="easyui-panel" title="SCHOOL DAYS FOR AY <?php echo $_SESSION['sy']; ?> " style="width:100%;height:150px;padding:10px;"
                data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">
				
			<div id="schoolDays"></div>
		</div>

		
		
		
</div>
<script type="text/javascript">
$(document).ready(function(){

		jQuery.ajax({
		  type: "GET",
		  headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		  },
		  url:'getSchoolDaysEGISExcel',
		  success: function (res) {
			$('div.ht_master.handsontable').remove();
			$('div.ht_clone_top.handsontable').remove();
			$('div.ht_clone_left.handsontable').remove();
			$('div.ht_clone_top_left_corner.handsontable').remove();

			
			var schoolDaysData = JSON.parse(res);
			console.log(schoolDaysData);

			var autosave = 1;
			var container = document.getElementById('schoolDays');
			var hot = new Handsontable (container, {
			  data: schoolDaysData,
			  rowHeaders: true,
			  colHeaders: true,
			  headerTooltips: true,		

			  fixedColumnsLeft: 2,
			  fixedRowsTop: 1,
			  contextMenu: false,
			  manualColumnFreeze: true,
			  //width: 1450,
			  height: 200,		
			  stretchH: 'all',					  
			  afterChange: function (change, source) {
				if (source === 'loadData') {
				  return; //don't save this change
				}
				if (autosave) {
					//console.log(change);
					//console.log(change[0][0]);
					//console.log(hot.getData()[change[0][0]][0]);
					//console.log(change[0][1]);
					//console.log(change[0][3]);
					//console.log(row.sectionCode);
					//console.log(row.subjectCode);
		
					//console.log(change[0][1].substring(2));		

					
					jQuery.ajax({
						url: 'updateSchoolDaysEGISExcel',
						data: { 
							'fieldName' : change[0][1],
							'value' : change[0][3],
						},
						type: "POST",
						success: function(response) {
							console.log("the request is successful for content1!");
						},
									
						error: function(error) {
							console.log('the page was NOT loaded', error);
							//$('.leveltwocontent').html(error);
						},
									
						complete: function(xhr, status) {
							console.log("The request is complete!");
						}
					}); //jQuery.ajax({					
					
					
				  return;
				}
				clearTimeout(autosaveNotification);
				ajax('scripts/json/save.json', 'GET', JSON.stringify({data: change}), function (data) {
				  exampleConsole.innerText  = 'Autosaved (' + change.length + ' ' + 'cell' + (change.length > 1 ? 's' : '') + ')';
				  autosaveNotification = setTimeout(function() {
					exampleConsole.innerText ='Changes will be autosaved';
				  }, 1000);
				});
			  },
			 colHeaders:['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
			 manualColumnResize: true,
			 manualRowResize: true,		

			 cells: function (row, col) {
				var cellProperties = {};
				return cellProperties;
			  },			 
			  columns: [
				 {data: 'JAN'},
				 {data: 'FEB'},
				 {data: 'MAR'},
				 {data: 'APR'},
				 {data: 'MAY'},
				 {data: 'JUN'},
				 {data: 'JUL'},
				 {data: 'AUG'},
				 {data: 'SEP'},
				 {data: 'OCT'},
				 {data: 'NOV'},
				 {data: 'DEC'},
			 ]

			  
			});	

			
		  },
		  'error': function () {
			console.log("Loading error");
		  }
		  
		});	

    return false;
    
});
</script> 




</div>