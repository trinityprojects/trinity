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
        url="getMyElementarySectionsEGIS" toolbar="#tb"
        title="My Elementary Sections List for the term <?php echo '<b><u>' . $_SESSION['sy'] . '</u></b>'; ?>" iconCls="icon-save"
        rownumbers="true" pagination="true" data-options="singleSelect: true,
        rowStyler: function(){
                        return 'padding:5px;';
                }       
        ">

    <thead>
        <tr >
            <th field="ID" >ID</th>
            <th field="sectionCode" >Section Code</th>
            <th field="subjectCode"  >Subject Code</th>
            <th field="subjectDescription">Subject Description</th>
            <th field="departmentCode">Subject Department</th>
            
        </tr>
    </thead>
</table>
</br>

        <div id="p" class="easyui-panel" title="SUBJECT INFORMATION AND TITLE SETUP " style="width:100%;height:200px;padding:10px;"
                data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">
				
				
				<div id="subjectHeader"> </div>
				<div id="subjectInformation"></div>
		</div>

		<div id="studentList"></div>
		
		
		
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
			  url:'getMySectionScoreSheet1StatusEGISExcel',
			  data: 
			  { 
				'sectionCode' : row.sectionCode,
				'subjectCode' : row.subjectCode,
			  },		  
			  success: function (res) {
				var flag = JSON.parse(res)['status'];
				if(flag == 1) {
					displayScoresReadOnly(row);
				} else {
					displayScores(row);
				}
			  }
			});

        }

    });
    return false;
 

	function displayScores(row) {
		
		jQuery.ajax({
		  type: "GET",
		  headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		  },
		  url:'getMySectionScoreSheet1EGISExcel',
          data: { 
				'sectionCode' : row.sectionCode,
				'subjectCode' : row.subjectCode,
				'subjectDescription' : row.subjectDescription,
				
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
						url: 'getMySectionScoreSheet1TitleEGISExcel',
						data: { 
							'sectionCode' : row.sectionCode,
							'subjectCode' : row.subjectCode,
							'subjectDescription' : row.subjectDescription,
							
						},
						success: function(response) {
							var titlesDataEdit = JSON.parse(response)['titles'][0];
							var sectionCode = row.sectionCode;
							var subjectCode = row.subjectCode;
							var subjectDescription = row.subjectDescription;
												
							var button = "<a href='javascript:void(0)' class='btn btn-lg btn-primary btn-block' " +
							'onclick="ViewGradesSummary.render(' +  "'" +  sectionCode + "', '" + subjectCode + "', '" + subjectDescription + "'" + ')">' + sectionCode +  " - " + subjectDescription + "</a>";					
							
							$('#subjectInformation').html(button);
							//console.log(JSON.parse(response)['subjectDescription']);
							function titleRenderer(instance, td, row, col, prop, value, cellProperties) {
							  Handsontable.renderers.TextRenderer.apply(this, arguments);
							  td.style.fontWeight = 'regular';
							  td.style.color = 'black';
							  td.style.background = '#FFFF99';
							  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
							  td.style.fontSize = '12';

							}
							function titleRendererHeader(instance, td, row, col, prop, value, cellProperties) {
							  Handsontable.renderers.TextRenderer.apply(this, arguments);
							  td.style.fontWeight = 'bold';
							  td.style.color = 'black';
							  td.style.background = '#FFFF99';
							  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
							  td.style.fontSize = '15';

							}
							
							
							console.log(titlesDataEdit);
							var autosaveTitle = 1;
							var containerTitle = document.getElementById('subjectHeader');
							var hotTitle = new Handsontable (containerTitle, {
							  data: titlesDataEdit,
							  rowHeaders: true,
							  colHeaders: true,
							  headerTooltips: true,		

							  fixedColumnsLeft: 2,
							  contextMenu: false,
							  manualColumnFreeze: true,
							  //width: 1400,
							  height: 85,	
							  autoColumnSize : true,
							  stretchH: 'all',					  
							  afterChange: function (change, source) {
								if (source === 'loadData') {
								  return; //don't save this change
								}
								if (autosaveTitle) {
									console.log(change);
									console.log(change[0][0]);
									console.log(hotTitle.getData()[change[0][0]][0]);
									console.log(change[0][1]);
									console.log(change[0][3]);
									console.log(row.sectionCode);
									console.log(row.subjectCode);
						
									
									jQuery.ajax({
										url: 'updateScoreSheet1TitleEGISExcel',
										data: { 
											'sectionCode' : row.sectionCode,
											'subjectCode' : row.subjectCode,
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
							  colHeaders:['Section Code', 'Subject Code', 'WW1', 'WW2', 'WW3', 'WW4', 
												'WW5', 'WW6', 'WW7', 'WW8', 'WW9', 'WW10', 
												'WW11', 'WW12', 'WW13', 'WW14', 'WW15', 
												'PT1', 'PT2', 'PT3', 'PT4', 'PT5', 
												'PT6', 'PT7', 'PT8', 'PT9', 'PT10', 
												'QA1'
							 ],
							 manualColumnResize: true,
							 manualRowResize: true,		

							 cells: function (row, col) {
								var cellProperties = {};
								if (col === 0 || col === 1) {
									cellProperties.renderer = titleRendererHeader; 
								} else {						
									cellProperties.renderer = titleRenderer; 
								}
								return cellProperties;
							  },			 
							  columns: [
								 {data: 'sectionCode', readOnly: true},
								 {data: 'subjectCode', readOnly: true},
								 {data: 'titleWW1'},
								 {data: 'titleWW2'},
								 {data: 'titleWW3'},
								 {data: 'titleWW4'},
								 {data: 'titleWW5'},
								 {data: 'titleWW6'},
								 {data: 'titleWW7'},
								 {data: 'titleWW8'},
								 {data: 'titleWW9'},
								 {data: 'titleWW10'},
								 {data: 'titleWW11'},
								 {data: 'titleWW12'},
								 {data: 'titleWW13'},
								 {data: 'titleWW14'},
								 {data: 'titleWW15'},
								 {data: 'titlePT1'},
								 {data: 'titlePT2'},
								 {data: 'titlePT3'},
								 {data: 'titlePT4'},
								 {data: 'titlePT5'},
								 {data: 'titlePT6'},
								 {data: 'titlePT7'},
								 {data: 'titlePT8'},
								 {data: 'titlePT9'},
								 {data: 'titlePT10'},
								 {data: 'titleQA1'},
							 ]
							});		
							
							
							
						},
									
						error: function(error) {
							console.log('the page was NOT loaded', error);
						},
									
						complete: function(xhr, status) {
							console.log("The request is complete!");
						}
					}); //jQuery.ajax({
			
			
			
			function identifierRenderer(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'regular';
			  td.style.color = 'black';
			  td.style.background = '#FFFF99';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';

			}
			
			function rowHeaderRenderer(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Comic Sans MS", cursive, sans-serif';
  			  td.style.fontSize = '15';
			  td.style.background = 'green';
  			  td.style.color = 'white';
			  

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


			function dataRendererQA(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
			  td.style.background = '#fff7e9';
  			  td.style.color = '#a56515';
			}


			function dataRendererPTLight(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
			  td.style.background = '#fce5f9';
  			  td.style.color = '#003368';
			}

			function dataRendererPTDark(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
			  td.style.background = '#6fb1bd';
  			  td.style.color = '#fefefe';
			}
			
			//hot.loadData(JSON.parse(res));
			var detailsData = JSON.parse(res)['details'];
			var titlesData = JSON.parse(res)['titles'][0];
			
			
			//console.log(titlesData);
			//console.log(detailsData);
			//console.log(maxScoreData);
			
			//console.log('oleg');
			var autosave = 1;
			var container = document.getElementById('studentList');
			var hot = new Handsontable (container, {
			  data: detailsData,
			  rowHeaders: true,
			  colHeaders: true,
			  headerTooltips: true,		

			  fixedColumnsLeft: 2,
			  fixedRowsTop: 1,
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
					//console.log(hot.getData()[change[0][0]][0]);
					//console.log(change[0][1]);
					//console.log(change[0][3]);
					//console.log(row.sectionCode);
					//console.log(row.subjectCode);
		
					//console.log(change[0][1].substring(2));		

					var categoryIndex = 0;
					var currentIndex = change[0][1].substring(2);
					var category = change[0][1].substring(0, 2);	
					//console.log(category);
					//console.log(categoryIndex);
					//console.log(currentIndex);	
					//console.log('----');
					if(category == 'WW') {
							categoryIndex = parseInt(currentIndex) + 1;
					} else if(category == 'PT') {
							categoryIndex = parseInt(currentIndex) + 16;
					} else {
							categoryIndex = parseInt(currentIndex) + 26;
					}
					//console.log(categoryIndex);				
					//console.log(hot.getData()[0][categoryIndex]);					
					
					var maximumScore = hot.getData()[0][categoryIndex];
					if(parseInt(change[0][3]) > parseInt(maximumScore) ) {
						alert('VALUE NOT ALLOWED!!!');
						return false;
					}
					
					jQuery.ajax({
						url: 'updateScoreSheet1EGISExcel',
						data: { 
							'sectionCode' : row.sectionCode,
							'subjectCode' : row.subjectCode,
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
			 colHeaders:['Student Number', 'Full Name', titlesData['titleWW1'], titlesData['titleWW2'], titlesData['titleWW3'], titlesData['titleWW4'], 
							titlesData['titleWW5'], titlesData['titleWW6'], titlesData['titleWW7'], titlesData['titleWW8'], titlesData['titleWW9'], titlesData['titleWW10'], 
							titlesData['titleWW11'], titlesData['titleWW12'], titlesData['titleWW13'], titlesData['titleWW14'], titlesData['titleWW15'], 
							titlesData['titlePT1'], titlesData['titlePT2'], titlesData['titlePT3'], titlesData['titlePT4'], titlesData['titlePT5'], 
							titlesData['titlePT6'], titlesData['titlePT7'], titlesData['titlePT8'], titlesData['titlePT9'], titlesData['titlePT10'], 
							titlesData['titleQA1']
						],
			 manualColumnResize: true,
			 manualRowResize: true,		

			 cells: function (row, col) {
				var cellProperties = {};

				if (col === 0 || col === 1) {
				  cellProperties.renderer = identifierRenderer; 
				} else if(col > 1 && col < 17) {
					if(col > 1 && ( (col % 2) == 0)){
					  cellProperties.renderer = dataRendererDark; 
					} else {
					  cellProperties.renderer = dataRendererLight; 
					}
				
				} else if(col >= 17 && col < 27)   {
					if(col > 1 && ( (col % 2) == 0)){
					  cellProperties.renderer = dataRendererPTDark; 
					} else {
					  cellProperties.renderer = dataRendererPTLight;
					}
					
				} else {
					cellProperties.renderer = dataRendererQA; 
				}
				
				if(row === 0) {
					cellProperties.renderer = rowHeaderRenderer;
				}
				


				return cellProperties;
			  },			 
			  columns: [
				 {data: 'studentNumber', readOnly: true},
				 {data: 'fullName', readOnly: true},
				 {data: 'WW1'},
				 {data: 'WW2'},
				 {data: 'WW3'},
				 {data: 'WW4'},
				 {data: 'WW5'},
				 {data: 'WW6'},
				 {data: 'WW7'},
				 {data: 'WW8'},
				 {data: 'WW9'},
				 {data: 'WW10'},
				 {data: 'WW11'},
				 {data: 'WW12'},
				 {data: 'WW13'},
				 {data: 'WW14'},
				 {data: 'WW15'},
				 {data: 'PT1'},
				 {data: 'PT2'},
				 {data: 'PT3'},
				 {data: 'PT4'},
				 {data: 'PT5'},
				 {data: 'PT6'},
				 {data: 'PT7'},
				 {data: 'PT8'},
				 {data: 'PT9'},
				 {data: 'PT10'},
				 {data: 'QA1'},
				 
			 ]

			  
			});	




			
		  },
		  'error': function () {
			console.log("Loading error");
		  }
		  
		});	//jQuery.ajax({		
		
	} //function displayScores(row)


	function displayScoresReadOnly(row) {
		
		jQuery.ajax({
		  type: "GET",
		  headers: {
			'Accept': 'application/json',
			'Content-Type': 'application/json'
		  },
		  url:'getMySectionScoreSheet1EGISExcel',
          data: { 
				'sectionCode' : row.sectionCode,
				'subjectCode' : row.subjectCode,
				'subjectDescription' : row.subjectDescription,
				
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
						url: 'getMySectionScoreSheet1TitleEGISExcel',
						data: { 
							'sectionCode' : row.sectionCode,
							'subjectCode' : row.subjectCode,
							'subjectDescription' : row.subjectDescription,
							
						},
						success: function(response) {
							var titlesDataEdit = JSON.parse(response)['titles'][0];
							var sectionCode = row.sectionCode;
							var subjectCode = row.subjectCode;
							var subjectDescription = row.subjectDescription;
												
							var button = "<a href='javascript:void(0)' class='btn btn-lg btn-danger btn-block' " +
							'onclick="ViewGradesSummaryPosted.render(' +  "'" +  sectionCode + "', '" + subjectCode + "', '" + subjectDescription + "'" + ')">' + sectionCode +  " - " + subjectDescription + "  (POSTED) </a>";					
							
							$('#subjectInformation').html(button);
							//console.log(JSON.parse(response)['subjectDescription']);
							function titleRenderer(instance, td, row, col, prop, value, cellProperties) {
							  Handsontable.renderers.TextRenderer.apply(this, arguments);
							  td.style.fontWeight = 'regular';
							  td.style.color = 'black';
							  td.style.background = '#FFFF99';
							  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
							  td.style.fontSize = '12';

							}
							function titleRendererHeader(instance, td, row, col, prop, value, cellProperties) {
							  Handsontable.renderers.TextRenderer.apply(this, arguments);
							  td.style.fontWeight = 'bold';
							  td.style.color = 'black';
							  td.style.background = '#FFFF99';
							  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
							  td.style.fontSize = '15';

							}
							
							
							console.log(titlesDataEdit);
							var autosaveTitle = 1;
							var containerTitle = document.getElementById('subjectHeader');
							var hotTitle = new Handsontable (containerTitle, {
							  data: titlesDataEdit,
							  rowHeaders: true,
							  colHeaders: true,
							  headerTooltips: true,		

							  fixedColumnsLeft: 2,
							  contextMenu: false,
							  manualColumnFreeze: true,
							  //width: 1400,
							  height: 85,	
							  autoColumnSize : true,
							  stretchH: 'all',					  
							  afterChange: function (change, source) {
								if (source === 'loadData') {
								  return; //don't save this change
								}
								if (autosaveTitle) {
									console.log(change);
									console.log(change[0][0]);
									console.log(hotTitle.getData()[change[0][0]][0]);
									console.log(change[0][1]);
									console.log(change[0][3]);
									console.log(row.sectionCode);
									console.log(row.subjectCode);
						
									
									jQuery.ajax({
										url: 'updateScoreSheet1TitleEGISExcel',
										data: { 
											'sectionCode' : row.sectionCode,
											'subjectCode' : row.subjectCode,
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
							  colHeaders:['Section Code', 'Subject Code', 'WW1', 'WW2', 'WW3', 'WW4', 
												'WW5', 'WW6', 'WW7', 'WW8', 'WW9', 'WW10', 
												'WW11', 'WW12', 'WW13', 'WW14', 'WW15', 
												'PT1', 'PT2', 'PT3', 'PT4', 'PT5', 
												'PT6', 'PT7', 'PT8', 'PT9', 'PT10', 
												'QA1'
							 ],
							 manualColumnResize: true,
							 manualRowResize: true,		

							 cells: function (row, col) {
								var cellProperties = {};
								if (col === 0 || col === 1) {
									cellProperties.renderer = titleRendererHeader; 
								} else {						
									cellProperties.renderer = titleRenderer; 
								}
								return cellProperties;
							  },			 
							  columns: [
								 {data: 'sectionCode', readOnly: true},
								 {data: 'subjectCode', readOnly: true},
								 {data: 'titleWW1', readOnly: true},
								 {data: 'titleWW2', readOnly: true},
								 {data: 'titleWW3', readOnly: true},
								 {data: 'titleWW4', readOnly: true},
								 {data: 'titleWW5', readOnly: true},
								 {data: 'titleWW6', readOnly: true},
								 {data: 'titleWW7', readOnly: true},
								 {data: 'titleWW8', readOnly: true},
								 {data: 'titleWW9', readOnly: true},
								 {data: 'titleWW10', readOnly: true},
								 {data: 'titleWW11', readOnly: true},
								 {data: 'titleWW12', readOnly: true},
								 {data: 'titleWW13', readOnly: true},
								 {data: 'titleWW14', readOnly: true},
								 {data: 'titleWW15', readOnly: true},
								 {data: 'titlePT1', readOnly: true},
								 {data: 'titlePT2', readOnly: true},
								 {data: 'titlePT3', readOnly: true},
								 {data: 'titlePT4', readOnly: true},
								 {data: 'titlePT5', readOnly: true},
								 {data: 'titlePT6', readOnly: true},
								 {data: 'titlePT7', readOnly: true},
								 {data: 'titlePT8', readOnly: true},
								 {data: 'titlePT9', readOnly: true},
								 {data: 'titlePT10', readOnly: true},
								 {data: 'titleQA1', readOnly: true},
							 ]
							});		
							
							
							
						},
									
						error: function(error) {
							console.log('the page was NOT loaded', error);
						},
									
						complete: function(xhr, status) {
							console.log("The request is complete!");
						}
					}); //jQuery.ajax({
			
			
			
			function identifierRenderer(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'regular';
			  td.style.color = 'black';
			  td.style.background = '#FFFF99';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';

			}
			
			function rowHeaderRenderer(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Comic Sans MS", cursive, sans-serif';
  			  td.style.fontSize = '15';
			  td.style.background = 'green';
  			  td.style.color = 'white';
			  

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


			function dataRendererQA(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
			  td.style.background = '#fff7e9';
  			  td.style.color = '#a56515';
			}


			function dataRendererPTLight(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
			  td.style.background = '#fce5f9';
  			  td.style.color = '#003368';
			}

			function dataRendererPTDark(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
			  td.style.background = '#6fb1bd';
  			  td.style.color = '#fefefe';
			}
			
			//hot.loadData(JSON.parse(res));
			var detailsData = JSON.parse(res)['details'];
			var titlesData = JSON.parse(res)['titles'][0];
			
			
			//console.log(titlesData);
			//console.log(detailsData);
			//console.log(maxScoreData);
			
			//console.log('oleg');
			var autosave = 1;
			var container = document.getElementById('studentList');
			var hot = new Handsontable (container, {
			  data: detailsData,
			  rowHeaders: true,
			  colHeaders: true,
			  headerTooltips: true,		

			  fixedColumnsLeft: 2,
			  fixedRowsTop: 1,
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
					//console.log(hot.getData()[change[0][0]][0]);
					//console.log(change[0][1]);
					//console.log(change[0][3]);
					//console.log(row.sectionCode);
					//console.log(row.subjectCode);
		
					//console.log(change[0][1].substring(2));		

					var categoryIndex = 0;
					var currentIndex = change[0][1].substring(2);
					var category = change[0][1].substring(0, 2);	
					//console.log(category);
					//console.log(categoryIndex);
					//console.log(currentIndex);	
					//console.log('----');
					if(category == 'WW') {
							categoryIndex = parseInt(currentIndex) + 1;
					} else if(category == 'PT') {
							categoryIndex = parseInt(currentIndex) + 16;
					} else {
							categoryIndex = parseInt(currentIndex) + 26;
					}
					//console.log(categoryIndex);				
					//console.log(hot.getData()[0][categoryIndex]);					
					
					var maximumScore = hot.getData()[0][categoryIndex];
					if(parseInt(change[0][3]) > parseInt(maximumScore) ) {
						alert('VALUE NOT ALLOWED!!!');
						return false;
					}
					
					jQuery.ajax({
						url: 'updateScoreSheet1EGISExcel',
						data: { 
							'sectionCode' : row.sectionCode,
							'subjectCode' : row.subjectCode,
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
			 colHeaders:['Student Number', 'Full Name', titlesData['titleWW1'], titlesData['titleWW2'], titlesData['titleWW3'], titlesData['titleWW4'], 
							titlesData['titleWW5'], titlesData['titleWW6'], titlesData['titleWW7'], titlesData['titleWW8'], titlesData['titleWW9'], titlesData['titleWW10'], 
							titlesData['titleWW11'], titlesData['titleWW12'], titlesData['titleWW13'], titlesData['titleWW14'], titlesData['titleWW15'], 
							titlesData['titlePT1'], titlesData['titlePT2'], titlesData['titlePT3'], titlesData['titlePT4'], titlesData['titlePT5'], 
							titlesData['titlePT6'], titlesData['titlePT7'], titlesData['titlePT8'], titlesData['titlePT9'], titlesData['titlePT10'], 
							titlesData['titleQA1']
						],
			 manualColumnResize: true,
			 manualRowResize: true,		

			 cells: function (row, col) {
				var cellProperties = {};

				if (col === 0 || col === 1) {
				  cellProperties.renderer = identifierRenderer; 
				} else if(col > 1 && col < 17) {
					if(col > 1 && ( (col % 2) == 0)){
					  cellProperties.renderer = dataRendererDark; 
					} else {
					  cellProperties.renderer = dataRendererLight; 
					}
				
				} else if(col >= 17 && col < 27)   {
					if(col > 1 && ( (col % 2) == 0)){
					  cellProperties.renderer = dataRendererPTDark; 
					} else {
					  cellProperties.renderer = dataRendererPTLight;
					}
					
				} else {
					cellProperties.renderer = dataRendererQA; 
				}
				
				if(row === 0) {
					cellProperties.renderer = rowHeaderRenderer;
				}
				


				return cellProperties;
			  },			 
			  columns: [
				 {data: 'studentNumber', readOnly: true},
				 {data: 'fullName', readOnly: true},
				 {data: 'WW1', readOnly: true},
				 {data: 'WW2', readOnly: true},
				 {data: 'WW3', readOnly: true},
				 {data: 'WW4', readOnly: true},
				 {data: 'WW5', readOnly: true},
				 {data: 'WW6', readOnly: true},
				 {data: 'WW7', readOnly: true},
				 {data: 'WW8', readOnly: true},
				 {data: 'WW9', readOnly: true},
				 {data: 'WW10', readOnly: true},
				 {data: 'WW11', readOnly: true},
				 {data: 'WW12', readOnly: true},
				 {data: 'WW13', readOnly: true},
				 {data: 'WW14', readOnly: true},
				 {data: 'WW15', readOnly: true},
				 {data: 'PT1', readOnly: true},
				 {data: 'PT2', readOnly: true},
				 {data: 'PT3', readOnly: true},
				 {data: 'PT4', readOnly: true},
				 {data: 'PT5', readOnly: true},
				 {data: 'PT6', readOnly: true},
				 {data: 'PT7', readOnly: true},
				 {data: 'PT8', readOnly: true},
				 {data: 'PT9', readOnly: true},
				 {data: 'PT10', readOnly: true},
				 {data: 'QA1', readOnly: true},
				 
			 ]

			  
			});	




			
		  },
		  'error': function () {
			console.log("Loading error");
		  }
		  
		});	//jQuery.ajax({		
		
	} //function displayScoresReadOnly(row)	
	
 
});
</script> 


    <script type="text/javascript">
   function CustomViewGradesSummary(){
        this.render = function(sectionCode, subjectCode, subjectDescription){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay-long');
            var dialogbox = document.getElementById('dialogbox-long');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1500 * .5)+"px";
            dialogbox.style.top = "50px";
            dialogbox.style.display = "block";

			var sectionCodeNS = sectionCode.split(' ').join('');
			var subjectCodeNS = subjectCode.split(' ').join('');
					
            jQuery.ajax({
                url: "EGIS/showSubjectGradesSummaryEGIS",
                data: {
                    'sectionCode':sectionCode,
                    'subjectCode':subjectCode,
                    'subjectDescription':subjectDescription,
                    'sectionCodeNS':sectionCodeNS,
                    'subjectCodeNS':subjectCodeNS,
					
                },
                type: "POST",
                success:function(data){
                    console.log(data);
		            var winHeight = window.innerHeight;
					
					$('#dialogboxbody-long').html('<iframe style="width:100%; height:'+(winHeight-200)+'px" src="<?php echo base_url();?>assets/pdf/subjectGradesSummary'+subjectCodeNS+sectionCodeNS+'.pdf"></iframe>');
                },
                error:function (){}
            }); //jQuery.ajax({


            document.getElementById('dialogboxhead-long').innerHTML = 'View PDF... <button onclick="ViewGradesSummary.no()">Close</button><button onclick="ViewGradesSummary.post(\''+sectionCode+'\',\''+subjectCode+'\')">POST</button>';
            //document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot-long').innerHTML = '<button onclick="ViewGradesSummary.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox-long').style.display = "none";
            document.getElementById('dialogoverlay-long').style.display = "none";
        }
		
		this.post = function(sectionCode, subjectCode) {
			var r = confirm("Posting your grades for this subject will disable encoding!!! Posting will also proceed with official ranking for this subject. Are you sure you want to post?");
			if (r == true) {
				
				jQuery.ajax({
					url: "postSubjectGradesSummaryEGIS",
					data: {
						'sectionCode':sectionCode,
						'subjectCode':subjectCode,
					},
					type: "POST",
					success:function(data){
						console.log(data);
						//var winHeight = window.innerHeight;
						
						//$('#dialogboxbody-long').html('<iframe style="width:100%; height:'+(winHeight-200)+'px" src="<?php echo base_url();?>assets/pdf/subjectGradesSummary'+subjectCodeNS+sectionCodeNS+'.pdf"></iframe>');
					},
					error:function (){}
				}); //jQuery.ajax({
				//alert(sectionCode + " " + subjectCode);
				
				
				$('.level1').remove();
				document.getElementById('dialogbox-long').style.display = "none";
				document.getElementById('dialogoverlay-long').style.display = "none";
			} else {
				document.getElementById('dialogbox-long').style.display = "none";
				document.getElementById('dialogoverlay-long').style.display = "none";
			}			
			

		}
		

    }
    var ViewGradesSummary = new CustomViewGradesSummary();
    </script>

	
	
	
    <script type="text/javascript">
   function CustomViewGradesSummaryPosted(){
        this.render = function(sectionCode, subjectCode, subjectDescription){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay-long');
            var dialogbox = document.getElementById('dialogbox-long');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1500 * .5)+"px";
            dialogbox.style.top = "50px";
            dialogbox.style.display = "block";

			var sectionCodeNS = sectionCode.split(' ').join('');
			var subjectCodeNS = subjectCode.split(' ').join('');
					
            jQuery.ajax({
                url: "EGIS/showSubjectGradesSummaryEGIS",
                data: {
                    'sectionCode':sectionCode,
                    'subjectCode':subjectCode,
                    'subjectDescription':subjectDescription,
                    'sectionCodeNS':sectionCodeNS,
                    'subjectCodeNS':subjectCodeNS,
					
                },
                type: "POST",
                success:function(data){
                    console.log(data);
		            var winHeight = window.innerHeight;
					
					$('#dialogboxbody-long').html('<iframe style="width:100%; height:'+(winHeight-200)+'px" src="<?php echo base_url();?>assets/pdf/subjectGradesSummary'+subjectCodeNS+sectionCodeNS+'.pdf"></iframe>');
                },
                error:function (){}
            }); //jQuery.ajax({


            document.getElementById('dialogboxhead-long').innerHTML = 'View PDF... <button onclick="ViewGradesSummaryPosted.no()">Close</button>';
            //document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot-long').innerHTML = '<button onclick="ViewGradesSummaryPosted.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox-long').style.display = "none";
            document.getElementById('dialogoverlay-long').style.display = "none";
        }
		
		this.post = function(sectionCode, subjectCode) {
			var r = confirm("Posting your grades for this subject will disable encoding!!! Posting will also proceed with official rankingfor this subject. Are you sure you want to post?");
			if (r == true) {
				
				jQuery.ajax({
					url: "postSubjectGradesSummaryEGIS",
					data: {
						'sectionCode':sectionCode,
						'subjectCode':subjectCode,
					},
					type: "POST",
					success:function(data){
						console.log(data);
						//var winHeight = window.innerHeight;
						
						//$('#dialogboxbody-long').html('<iframe style="width:100%; height:'+(winHeight-200)+'px" src="<?php echo base_url();?>assets/pdf/subjectGradesSummary'+subjectCodeNS+sectionCodeNS+'.pdf"></iframe>');
					},
					error:function (){}
				}); //jQuery.ajax({
				//alert(sectionCode + " " + subjectCode);
				
				
				$('.level1').remove();
				document.getElementById('dialogbox-long').style.display = "none";
				document.getElementById('dialogoverlay-long').style.display = "none";
			} else {
				document.getElementById('dialogbox-long').style.display = "none";
				document.getElementById('dialogoverlay-long').style.display = "none";
			}			
			

		}
		

    }
    var ViewGradesSummaryPosted = new CustomViewGradesSummaryPosted();
    </script>
	
	

</div>