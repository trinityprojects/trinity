<div class="level1">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/egis/egis.css" />
 <script src="http://handsontable.com/dist/handsontable.full.js"></script>
    <link rel="stylesheet" media="screen" href="http://handsontable.com/dist/handsontable.full.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />

	<div id="dialogoverlay-long"></div>
		<div id="dialogbox-long">
		<div>
			<div id="dialogboxhead-long"></div>
			<div id="dialogboxbody-long"></div>
			<div id="dialogboxfoot-long"></div>
		</div>
	</div>	
	
<div>	
<table id="tt" class="easyui-datagrid" style="width:100%;max-width:100%;padding:5px 5px;font-size: 5px;"
        url="getAttendanceSectionEGIS" toolbar="#tb"
        title="My Sections Advisee for the term <?php echo '<b><u>' . $_SESSION['sy'] . '</u></b>'; ?>" iconCls="icon-save"
        rownumbers="true" pagination="true" data-options="singleSelect: true,
        rowStyler: function(){
                        return 'padding:5px;';
                }       
        ">

    <thead>
        <tr >
            <th field="ID" >ID</th>
            <th field="sectionCode">Section Code</th>
            <th field="courseCode">Course Code</th>
            <th field="yearLevel">Year Level</th>
            
        </tr>
    </thead>
</table>



</br>

        <div id="p" class="easyui-panel" title="SCHOOL DAYS FOR AY <?php echo $_SESSION['sy']; ?> " style="width:100%;height:150px;padding:10px;"
                data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">
				
			<div id="schoolDays"></div>
			<div id="subjectInformation"></div>
			
		</div>

		<div id="attendanceList"></div>
		
		
		
</div>
<script type="text/javascript">
$(document).ready(function(){

    $('#tt').datagrid({

        onClickRow: function() {

           var row = $('#tt').datagrid('getSelected');
            
			row.styler = function(){
				return 'background-color:yellow';
            };


		
		jQuery.ajax({
		  type: "GET",
		  headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		  },
		  url:'getMyAdviseeScoreSheet1AttendanceEGISExcel',
          data: { 
				'sectionCode' : row.sectionCode,
				},		  
		  success: function (res) {
			$('div.ht_master.handsontable').remove();
			$('div.ht_clone_top.handsontable').remove();
			$('div.ht_clone_left.handsontable').remove();
			$('div.ht_clone_top_left_corner.handsontable').remove();


		jQuery.ajax({
		  type: "GET",
		  headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		  },
		  url:'getSchoolDaysEGISExcel',
		  success: function (res) {
			
			var schoolDaysData = JSON.parse(res);
			console.log(schoolDaysData);

					var button = "<a href='javascript:void(0)' class='btn btn-lg btn-primary btn-block' " +
					'>' + row.sectionCode + "</a>";					
					
					$('#subjectInformation').html(button);			
			
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
			  height: 60,		
			  stretchH: 'all',					  
			  colHeaders:['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
			  manualColumnResize: true,
			  manualRowResize: true,		
 			  cells: function (row, col) {
				var cellProperties = {};
				return cellProperties;
			  },			 
			  columns: [
				 {data: 'JAN', readOnly: true},
				 {data: 'FEB', readOnly: true},
				 {data: 'MAR', readOnly: true},
				 {data: 'APR', readOnly: true},
				 {data: 'MAY', readOnly: true},
				 {data: 'JUN', readOnly: true},
				 {data: 'JUL', readOnly: true},
				 {data: 'AUG', readOnly: true},
				 {data: 'SEP', readOnly: true},
				 {data: 'OCT', readOnly: true},
				 {data: 'NOV', readOnly: true},
				 {data: 'DEC', readOnly: true},
			 ]

			  
			});	

			
		  },
		  'error': function () {
			console.log("Loading error");
		  }
		  
		});	

				
			
			
			function identifierRenderer(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'regular';
			  td.style.color = 'black';
			  td.style.background = '#FFFF99';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';

			}
			
			function dataRendererDark(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
			  td.style.background = '#A9A9A9';
  			  td.style.color = 'white';
			}

			function dataRendererLight(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
			}


			
			//hot.loadData(JSON.parse(res));
			var attendanceData = JSON.parse(res)['attendance'];
			
			
			console.log(attendanceData);
			//console.log(detailsData);
			//console.log(maxScoreData);
			
			//console.log('oleg');
			var autosave = 1;
			var container = document.getElementById('attendanceList');
			var hot = new Handsontable (container, {
			  data: attendanceData,
			  rowHeaders: true,
			  colHeaders: true,
			  headerTooltips: true,		

			  fixedColumnsLeft: 2,
			  contextMenu: false,
			  manualColumnFreeze: true,
			  //width: 1450,
			  height: 600,		
			  stretchH: 'all',					  
			  afterChange: function (change, source) {
				if (source === 'loadData') {
				  return; //don't save this change
				}
				if (autosave) {
					//console.log(change);
					//console.log(change[0][0]);
					console.log(hot.getData()[change[0][0]][0]);
					console.log(change[0][1]);
					console.log(change[0][3]);
					//console.log(row.sectionCode);
					//console.log(row.subjectCode);
		
					//console.log(change[0][1].substring(2));		

					//console.log(category);
					//console.log(categoryIndex);
					//console.log(currentIndex);	
					//console.log('----');
					jQuery.ajax({
						url: 'updateScoreSheet1AttendanceEGISExcel',
						data: { 
							'sectionCode' : row.sectionCode,
							'studentNumber' : hot.getData()[change[0][0]][0],
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
			 colHeaders:['Student Number', 'Full Name', 'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
			 manualColumnResize: true,
			 manualRowResize: true,		

			 cells: function (row, col) {
				var cellProperties = {};

				if (col === 0 || col === 1) {
				  cellProperties.renderer = identifierRenderer; 
				} else if(col > 1 && col < 14) {
					if(col > 1 && ( (col % 2) == 0)){
					  cellProperties.renderer = dataRendererDark; 
					} else {
					  cellProperties.renderer = dataRendererLight; 
					}
		
				} 


				return cellProperties;
			  },			 
			  columns: [
				 {data: 'studentNumber', readOnly: true},
				 {data: 'fullName', readOnly: true},
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

        }

    });
    return false;
    
});
</script> 




</div>