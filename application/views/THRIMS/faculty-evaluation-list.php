<div class="level1">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />
	<script  src="<?php echo base_url();?>assets/thirdparty/handsontable-pro-master/dist/handsontable.full.js"></script>
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/thirdparty/handsontable-pro-master/dist/handsontable.full.css">


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Faculty Evaluation" style="width:100%;max-width:100%;height:650px;padding:15px 15px;"> 
        
		<form id="ff" class="easyui-form" method="post" data-options="novalidate:true">
			<div id="box-white">
			<table border="1" >
					<tr >
						<td style="padding: 5px; background-color: #7FFF00;" ><b>RATING</b> </td>
						<td style="padding: 5px; background-color: #7FFF00;" ><b><center>QUALITY</center></b></td>
					        <td style="padding: 5px; background-color: #7FFF00;" ><b>FREQUENCY</b></td>
						<td style="padding: 5px; background-color: #7FFF00;" ><center><b>INTERPRETATION</b></center> </td>

						<td style="padding: 10px; background-color: #7FFF00; font-family:verdana;" rowspan = "6">
							<p style="font-family:verdana;"> You need to answer all the questions for all your instructors/professors. </p>
							<p style="font-family:verdana;"> All unanswered items will remain in <b style="color:red">red </b>. </p>
							
							<p style="font-family:verdana;"> Only numbers 1 to 5 are accepted. Use <b>ENTER</b> KEY or <b>ARROW</b> keys to move. </p>

						</td>


						 <td style "padding: 5px; rowspan = "6"><img src = "<?php echo base_url();?>assets/images/presstheendkey.jpg" width ="200px" height="200px"></td>

					</tr>

					<tr>
						<td style="padding: 5px; background-color: #7FFF00;" ><b><center>5</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b><center>Outstanding</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b><center>Always</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b>The teacher implements the item all the time.</td>
					</tr>

					<tr>
						<td style="padding: 5px; background-color: #7FFF00;" ><b><center>4 </td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-family:verdana; font-size:12px"><b><center>Very Satisfactory</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-family:verdana; font-size:12px"><b><center>Very Often	</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-family:verdana; font-size:12px"><b>The teacher implements the item very often.</td>
					</tr>

					<tr>
						<td style="padding: 5px; background-color: #7FFF00;" ><b><center>3</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><center><b>Satisfactory</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><center><b>Often </td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b>The teacher implements the item often.</td>
					</tr>

					<tr>
						<td style="padding: 5px; background-color: #7FFF00;" ><b><center>2</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b><center>Poor</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b><center>Sometimes </td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b>The teacher implements the item occasionally.</td>
					</tr>

					<tr>
						<td style="padding: 5px; background-color: #7FFF00;" ><b><center>1</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b><center>Needs Improvement</td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b><center>Never </td>
						<td style="padding: 5px; background-color: #ffec8b; font-family:verdana; font-size:12px"><b>The teacher does not implement the item at all.</td>
					</tr>


				</table>
			</div>
			<br>
			<div id="box-white">
				<div id='evaluationDetails'></div>
			</div>
			
        </form>
	</div>
			
			
		<script type="text/javascript">
		$(document).ready(function(){


			jQuery.ajax({
			  type: "GET",
			  url:'checkEvaluationPosting',
			  data: { },
			  success: function (data) {
					var resultValue = $.parseJSON(data);
					if(resultValue['success'] == 0) {
						getEvaluationDetails();
					} else {
						showEvaluationPosted();
					}

			  },
			  error: function(error) {
				  console.log('Error loading Evaluation details records', error);
			  },
			  complete: function(xhr, status) {
				  console.log("rid-getPBNDetails [OK]");
			  }
			});


			function showEvaluationPosted() {
				
				$(".levelonecontent").html('<div style="padding: 250px; text-align: center">Evaluation Finished!!!</div>');
			}
		
			function getEvaluationDetails() {
				jQuery.ajax({
				  type: "GET",
				  url:'getEvaluationDetails',
				  data: { },
				  success: function (rs) {
					displayEvaluationDetails(rs);
				  },

				  error: function(error) {
					  console.log('Error loading Evaluation details records', error);
				  },

				  complete: function(xhr, status) {
					  console.log("rid-getPBNDetails [OK]");
				  }

				});
			}

		
		
			

			function displayEvaluationDetails(rs) {

				var detailsData = JSON.parse(rs);;
				
				var $container = $("#evaluationDetails");
				
				var numberValidator = /^[1-5]$/;
				var rowData = undefined;
				var employeeNumber = undefined;
				var sectionCode = undefined;
				var subjectCode = undefined;
				var fieldName = undefined;
				var value = undefined;

				
			function identifierRenderer(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.color = 'green';
			  td.style.background = '#FFFF99';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
  			  td.style.textAlign = 'left';
			}		


			function identifierRendererStripe(instance, td, row, col, prop, value, cellProperties) {
			  Handsontable.renderers.TextRenderer.apply(this, arguments);
			  td.style.fontWeight = 'bold';
			  td.style.color = '#FFFF99';
			  td.style.background = 'green';
			  td.style.fontFamily = 'Verdana, Geneva, sans-serif';
  			  td.style.fontSize = '12';
  			  td.style.textAlign = 'left';
			}		
			
			  function firstRowRenderer(instance, td, row, col, prop, value, cellProperties) {
				Handsontable.renderers.TextRenderer.apply(this, arguments);
				if(!value || value === '' || value == null ) {            
					 td.style.background = 'red';
				}    
			  }			
		$container.handsontable({
				
					data: detailsData,
					startRows: 0,
					startCols: 0,
					rowHeaders: true,
					colHeaders: true,
					contextMenu: false,
					headerTooltips: false,
					height: 400,
					stretchH: 'all',
					manualColumnResize: true,
					manualRowResize: true,
					rowHeights: 6,
					fixedColumnsLeft: 5,
					afterChange: function (change, source) {	
						rowData = this.getDataAtRow(change[0][0]);
						employeeNumber = rowData[0];
						sectionCode = rowData[2];
						subjectCode = rowData[4];
						fieldName = change[0][1];
						value = change[0][3];
						
						console.log(employeeNumber + ' ' + sectionCode + ' ' + subjectCode + ' ' + fieldName + ' ' + value);
						if(change != undefined) {
							populateEvaluationDetails(employeeNumber, sectionCode, subjectCode, fieldName, value);
						}
						
					},
					className: "htCenter",
					colHeaders: function (col) {
				  
					  switch (col) {
						case 0:
						  return 'Faculty Number';
						case 1:
							return 'Faculty Name';
						case 2:
							return 'Section';
						case 3:
							return 'Subject';
						case 4:
							return 'Subject Code';
						case 5:
							return '1. Uses variety of assessment <br> strategies that are valid and <br> appropriate to the students.';
						case 6:
							return '2. Aligns assessment tools such <br> as tests with the learning objectives, <br> instruction and expected outcomes.';

						case 7:
							return '3. Facilitates interactive learning <br>among students through <br>group research and projects.';
						case 8:
							return '4. Uses assessment tools to <br> gauge the learning of <br>students in the subject.';
						case 9:
							return "5. Uses instructional technology <br>to enhance student's learning.";
						case 10:
							return '6. Engages and holds the <br>attention of students in all <br>discussions.';
						case 11:
							return '7. Utilizes a variety of <br>teaching methods in <br> discussing topics.';
						case 12:
							return '8. Demonstrates mastery <br>of the topics included <br> in the course syllabus.';

						case 13:
							return '9. Provides learning <br>materials to students.';
						case 14:
							return '10. Enriches the lesson with the relevant <br>research  outputs applicable to real <br>and practical life  experiences.';
						case 15:
							return '11. Instills Christian values <br>in all academic and/ or<br> co-curricular activities.';
						case 16:
							return "12. Listens and pays attention <br>to student's needs and response.";
							
						case 17:
							return '13. Corrects test papers, mauals, assignment <br>projects and  practical exams and returns<br> them on time.';
						case 18:
							return '14. Answers students question with the<br> accuracy, clarity and confidence.';
						case 19:
							return '15. Aligns the lessons with <br>the mission vision of  TUA.';
						case 20:
							return '16. Documents the result <br> of students assessment.';
						case 21:
							return '17.Practices open communication<br> with the students.';
						case 22:
							return '18. Exhibits transparency in the <br>assessment of students performance  <br>and explains the bases for evaluation.';
						case 23:
							return '19. Accepts students <br> feedback constructively.';
						case 24:
							return '20. Behaves professionally.';
						case 25:
							return '21. Uses English as a medium <br>of instruction conistently.';
						case 26:
							return '22. Shows concern <br>to each student.'; 
						case 27:
							return '23. Is available and approachable <br> for consulation.';
						case 28:
							return '24. Imbibes the Trinitian core values <br>of integrity,  excellence, teamwork, innovation <br> and social responsibility.';
						case 29:
							return '25. Fosters an orderly and <br>clean classroom environment.';
						case 30:
							return '26. Establishes clear  objectives <br>for each lesson  and works to meet <br>those specific objectives during <br> each class.';
						case 31:
							return '27. Encourages students <br> to work at their best level.';
						case 32:
							return '28. Creates a stimulating  and wholesome <br>atmosphere  to enhance students <br>participation in class.';
						case 33:
							return '29. Ensures an overall  sense of <br> respect in the classroom.';
						case 34:
							return '30. Provides a clear  relevant <br> rationale for every class activity.';
						case 35:
							return '31. Recognize individual students <br> and his/her cultural <br> background.';
						case 36:
							return '32. Keeps students informed <br> on latest trend and <br> development in curriculum, <br> discipline and other issues.';
						case 37:
							return '33. Explains the course requirement,<br> grading system, resource and <br> learning outcomes clearly.';
						case 38:
							return '34. Sets a learning environment  conducive<br> to developing rapport  between <br>and among students.';
						case 39:
							return '35. Comes to class prepared.';
						case 40:
							return '36. Encourages students critical <br> thinking by giving challenging questions.';
						case 41:
							return '37. Exercise fair <br> treatment of students.';
						case 42:
							return '38. Shows respect <br> for the students.';
						case 43:
							return '39. Shows compassion  and sensivity <br>to students differences.';
						case 44:
							return '40. shows consideration  and <br> understanding according to  the <br> capabilities of the students.';
						case 45:
							return '41. Promotes positive <br> behavior in the classroom.';
						case 46:
							return '42. Respects students  diversity <br> including language, culture, race, <br> gender and special needs.';
						case 47:
							return '43. Makes every learning sessions <br> easy to understand, lively <br> and enjoyable.';
						case 48:
							return 'COMMENTS';

							
					  }
					},
					
					columns: [
					{ data: 'employeeNumber', readOnly: true },
					{ data: 'facultyFullName', readOnly: true },
					{ data: 'sectionCode', readOnly: true },
					{ data: 'subjectDescription', readOnly: true },
					{ data: 'subjectCode', readOnly: true},
					{ 
						data: 'question1',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
					},
					{ 
						data: 'question2',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question3',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question4',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question5',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question6',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question7',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question8',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question9',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question10',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question11',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question12',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question13',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question14',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question15',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question16',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question17',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question18',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question19',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question20',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question21',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question22',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question23',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question24',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question25',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question26',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question27',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question28',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question29',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question30',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question31',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question32',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question33',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question34',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question35',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question36',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question37',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question38',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question39',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question40',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question41',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question42',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'question43',
						type: 'autocomplete',
						source: ['5', '4', '3', '2', '1'],
						validator: numberValidator, allowInvalid: false
						
					},
					{ 
						data: 'comments',
						
					}

					
					],

				  hiddenColumns: {
					columns: [0, 2, 4],
					indicators: true
				  },

				 cells: function (row, col) {
					var cellProperties = {};

					if ( (col === 0 || col === 1 || col === 2 || col === 3 ) && ( (row % 2) == 0)) {
					  cellProperties.renderer = identifierRenderer; 
					} else if( (col === 0 || col === 1 || col === 2 || col === 3 ) && ( (row % 2) == 1)) {
					  cellProperties.renderer = identifierRendererStripe; 
					} else {
						cellProperties.renderer = firstRowRenderer;
					}

					return cellProperties;
				  },
			beforeKeyDown: function(event) {
				var keyEvent = event.key;
				if(keyEvent == 'End') {
					var rowInstance = $container.handsontable('getInstance');
					var size = rowInstance.getData().length;
					var data = rowInstance.getData();
					var nullFlag = 0;
					for(var i = 0; i < size; i++) {
						console.log(data[i]);
						for(var x = 5; x < 49; x++) {
							if( (data[i][x] == null) || (data[i][x] == '') ) {
								nullFlag = 1;
							}
						}
					}
					if(nullFlag == 1) {
						alert('Please complete the form to post your evaluation!!!');
					} else {
						postEvaluation();
					}
					
				}
			}



	
				});

			
				
		  }//function
	
		});
	  

		
function populateEvaluationDetails(employeeNumber, sectionCode, subjectCode, fieldName, value) {
	console.log("INDEX-: " + employeeNumber + ' ' + sectionCode + ' ' + subjectCode);
	console.log("FIELD-: " + fieldName);
	console.log("VALUE-: " + value);
	jQuery.ajax({
		url: 'populateEvaluationDetails',
		data: { 
			'employeeNumber' : employeeNumber,
			'sectionCode' : sectionCode,
			'subjectCode' : subjectCode,
			'fieldName' : fieldName,
			'value' : value,
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
}		


function postEvaluation() {

	var r = confirm("Do you really want to post your evaluation?");
	if (r == true) {
		jQuery.ajax({
			url: 'postEvaluation',
			type: "POST",
			success: function(response) {
				$(".levelonecontent").html('<div style="padding: 250px; text-align: center">Evaluation Finished!!!</div>');

			},
						
			error: function(error) {
				console.log('the page was NOT loaded', error);
				//$('.leveltwocontent').html(error);
			},
						
			complete: function(xhr, status) {
				console.log("The request is complete!");
			}
		}); //jQuery.ajax({					
	} else {
		return false;
	}
}
		
		</script> 

</div>