<div class="level1">


    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/egis/egis.css" />
 <script src="http://handsontable.com/dist/handsontable.full.js"></script>
    <link rel="stylesheet" media="screen" href="http://handsontable.com/dist/handsontable.full.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />

        <div id="dialogoverlay"></div>
        <div id="dialogbox">
        <div>
            <div id="dialogboxhead"></div>
            <div id="dialogboxbody"></div>
            <div id="dialogboxfoot"></div>
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
		

        <div id="p" class="easyui-panel" title="UPDATE EMAILL ADDRESS FOR AY <?php echo $_SESSION['sy']; ?> , Grading Period: <?php echo '<b><u>' . $_SESSION['gP'] . '</u></b>'; ?>" style="width:100%;height:250px;padding:10px;"
                data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">

				<div><h1>VERY IMPORTANT!</h1></div>
				<div><h3>Make sure that the email address you typed here is actually yours.</h3></div>
				<div><h3>PROTECT YOUR INFORMATION AT ALL TIMES.</h3></div>
				
				
                                        <!--START ------------------------------ emailAddress TextBox  -------------------------------------------START -->
                                        <div class="input-group col-md-10 input-group-md">
                                            <div class="input-group-prepend">
                                                    <div class="input-group-text bg-transparent">
                                                    <i class="fa fa-envelope" style="color: gold"></i>
                                                    </div>
                                            </div>
                                            <input name="emailAddress" value="<?php echo $this->session->flashdata('emailAddress'); ?>" data-validation="email" id="emailAddress" placeholder='Email Address' class='form-control'  data-validation-error-msg="Please enter a valid Email Address" data-validation-error-msg-container="#messageValidationLocationEmailAddress" onBlur="" onFocus="" >
                                        </div>
                                        <span>
                                        <b class="jQueryFormValidationMessage" id="messageValidationLocationEmailAddress"></b>
                                        </span>
                                        <!--END ------------------------------ emailAddress TextBox  -------------------------------------------END -->


								<a href="javascript:void(0)" class="link-btn" onclick="UpdateEmailAdd.render()" style="width:80px">UPDATE EMAIL ADDRESS</a>
                                    
                                    <!--END ------------------------------ signUp Button  -------------------------------------------END -->
										
		</div>
</div>


<script type="text/javascript">

    function CustomUpdateEmailAdd(){
        this.render = function(){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var emailAddress = $('#emailAddress').val();         

			var validEmail = validateEmail(emailAddress);

			
			var dialog = '';
            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Email Address: </b></div>";
            dialog = dialog + "<div><u>" + emailAddress + "</u></div>";
            dialog = dialog + "<div style='color:gold; font-size:20px'><b>Are you sure that this email address is yours? </b></div>";
            dialog = dialog + "</div>";

			var button = '';
			//alert(op + ' ' + status);
			if(emailAddress == '' || validEmail == false)   {
				button = 'Please input a valid email address... </button> <button onclick="UpdateEmailAdd.no()">Close</button>';				
			} else {
				button = '<button onclick="UpdateEmailAdd.yes()">Proceed</button> <button onclick="UpdateEmailAdd.no()">Close</button>';				
			}

            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = button;
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(){
				var emailAddress = $('#emailAddress').val();         
				alert(emailAddress);

				var r = confirm("Please confirm your email address!");
				if (r == true) {

					jQuery.ajax({
						url: "updateEmailAddress",
						data: {
							'emailAddress':emailAddress,
						},
						type: "POST",
						success:function(data){
						   console.log(data);
							var resultValue = $.parseJSON(data);
							console.log(resultValue);
							//console.log(resultValue['quantt']);
							if(resultValue['success'] == 1) {
								$('div.level1').remove();
								return true;
							} else {
								return false;
							}
						},
						error:function (){}
					}); //jQuery.ajax({
				
				
				} else {
					return false;
				}

			document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var UpdateEmailAdd = new CustomUpdateEmailAdd();


	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(String(email).toLowerCase());
	}	


    /*function updateEmailAddress(emailAddress) {
            jQuery.ajax({
                url: "updateEmailAddress",
                data: {
                    'emailAddress':updateEmailAddress,
				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.level1').remove();
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }*/
</script>

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