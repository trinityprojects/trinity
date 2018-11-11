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
        url="getStudentSubjectsEGIS" toolbar="#tb"
        title="My Subjects for the term <?php echo '<b><u>' . $_SESSION['sy'] . '</u></b>'; ?>, Grading Period: <?php echo '<b><u>' . $_SESSION['gP'] . '</u></b>'; ?>" iconCls="icon-save"
        rownumbers="true" pagination="true" data-options="singleSelect: true,
        rowStyler: function(){
                        return 'padding:5px;';
                }       
        ">

    <thead>
        <tr >
            <th field="sectionCode">Section Code</th>
            <th field="subjectCode">Subject Code</th>
            <th field="subjectDescription">Subject Description</th>
            
        </tr>
    </thead>
</table>



</br>

        <div id="p" class="easyui-panel" title="GRADES REQUEST PROCESS FOR AY <?php echo $_SESSION['sy']; ?> " style="width:100%;height:250px;padding:10px;"
                data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">
			<div> <h3>Please be informed that you are using this email address: <u><?php echo $_SESSION['emailAddress']; ?></u></h3></div>
			<div> <h5><b>If this is not your email address don't proceed, report this to the system administrator to update your emaill address.</b></h5></div>
			<div> <h5>If yes, will be sending your grades for this subject to the email address indicated above, once you click the blue button </br>
			your grades information will be sent to your email. Once sent, you are now responsible for your information, <br> 
			make sure that you protect your information all the time.
			</h5></div>
			
			<div id="subjectInformation"></div>
			
		</div>

        <div id="p" class="easyui-panel" title="GRADES REQUEST PROCESS FOR AY <?php echo $_SESSION['sy']; ?> , Grading Period: <?php echo '<b><u>' . $_SESSION['gP'] . '</u></b>'; ?>" style="width:100%;height:250px;padding:10px;"
                data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">
			<div> <h3>Please be informed that you are using this email address: <u><?php echo $_SESSION['emailAddress']; ?></u></h3></div>
			<div> <h5><b>If this is not your email address don't proceed, report this to the system administrator to update your emaill address.</b></h5></div>
			<div> <h5>If yes, will be sending your grades for this subject to the email address indicated above, once you click the blue button </br>
			your grades information will be sent to your email. Once sent, you are now responsible for your information, <br> 
			make sure that you protect your information all the time.
			</h5></div>
			
			<div id="allGrades"></div>
			
		</div>
		
		
		
</div>
<script type="text/javascript">
$(document).ready(function(){

    $('#tt').datagrid({

        onClickRow: function() {

           var row = $('#tt').datagrid('getSelected');
            
			row.styler = function(){
				return 'background-color:yellow';
            };

			var button = "<a href='javascript:void(0)' class='btn btn-lg btn-primary btn-block' " +
			'onclick="RequestSubjectGradesSummary.render(' +  "'" +  row.sectionCode + "', '" + row.subjectCode + "', '" + row.subjectDescription + "'" + ')">' + 'Click to make a request for ' + row.sectionCode +  " - " + row.subjectDescription + "</a>";					
			
			$('#subjectInformation').html(button);
			


			
        }

    });
	
			var button = "<a href='javascript:void(0)' class='btn btn-lg btn-primary btn-block' " +
			'onclick="RequestAllGradesSummary.render()">' + 'Click to make a request for All Grades' + "</a>";					
			
			$('#allGrades').html(button);
	
    return false;
    
});
</script> 



    <script type="text/javascript">
   function CustomRequestSubjectGradesSummary(){
        this.render = function(sectionCode, subjectCode, subjectDescription){
			var r = confirm("Are you sure you want to make this grades request?");
			if (r == true) {
				var sectionCodeNS = sectionCode.split(' ').join('');
				var subjectCodeNS = subjectCode.split(' ').join('');

				jQuery.ajax({
					url: "processGradesRequestEGIS",
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
						//$('#dialogboxbody-long').html('<iframe style="width:100%; height:'+(winHeight-200)+'px" src="<?php echo base_url();?>assets/pdf/subjectGradesSummary'+subjectCodeNS+sectionCodeNS+'.pdf"></iframe>');
					},
					error:function (){}
				}); //jQuery.ajax({			
			
			} else {
				
				alert('no');
			}
			
	
        }
	}
    var RequestSubjectGradesSummary = new CustomRequestSubjectGradesSummary();
    </script>


    <script type="text/javascript">
   function CustomRequestAllGradesSummary(){
        this.render = function(){
			var r = confirm("Are you sure you want to make this grades request?");
			if (r == true) {

				jQuery.ajax({
					url: "processAllGradesRequestEGIS",
					success:function(data){
						console.log(data);
						//$('#dialogboxbody-long').html('<iframe style="width:100%; height:'+(winHeight-200)+'px" src="<?php echo base_url();?>assets/pdf/subjectGradesSummary'+subjectCodeNS+sectionCodeNS+'.pdf"></iframe>');
					},
					error:function (){}
				}); //jQuery.ajax({			
			
			} else {
				
				alert('no');
			}
			
	
        }
	}
    var RequestAllGradesSummary = new CustomRequestAllGradesSummary();
    </script>


</div>