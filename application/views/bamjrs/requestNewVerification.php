<div class="requestFormLevel2" style="width:100%;max-width:70%;">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />

<div> 

<div id="dialogoverlay"></div>
<div id="dialogbox">
  <div>
    <div id="dialogboxhead"></div>
    <div id="dialogboxbody"></div>
    <div id="dialogboxfoot"></div>
  </div>
</div>

<form>
<div class="form-style-1">
    <div id="multi-columns">
        <div id="two-columns"><b>Request Number:</b> <b class="small"> #<?php echo $ID?> </b>
        </div>
        <div id="two-columns"><b>Request Status:</b> <b class="small"><?php echo $requestStatusDescription?></b>
        </div>
    </div>

    <div>
        <div id="one-column"><b>Project Title:</b> <b class="small"><?php echo $projectTitle?></b>
        </div>
    </div>



    <div id="multi-columns">
        <div id="three-columns"><b>Location:</b> <b class="small"> <?php echo $locationCode?> </b>
        </div>
        <div id="three-columns"><b>Floor:</b> <b class="small"><?php echo $floor?></b>
        </div>
        <div id="three-columns"><b>Room Number:</b> <b class="small"><?php echo $roomNumber?></b>
        </div>
    </div>

    <div>
        <div id="one-column"><b>Scope of Works:</b> <b class="small"> <?php echo $scopeOfWorks?> </b>
        </div>
    </div>
    <div>
        <div id="one-column"><b>Project Justification:</b> <b class="small"> <?php echo $projectJustification?> </b>
        </div>
    </div>

    <div id="multi-columns">
        <div id="three-columns"><b>Date Created:</b> 
            <b class="small"> 
                <?php echo $dateCreated?> 
                <?php
                    $from = strtotime($dateCreated);
                    $today = time();
                    $runningDays = $today - $from;
                    
                    $from = strtotime($dateCreated);
                    $deadline = strtotime($dateNeeded);
                    $totalDays = $deadline - $from;
                    
                    echo "(" . floor($runningDays / 86400) . " of " . floor($totalDays / 86400) . " days)";  // (60 * 60 * 24)
                ?>
           
            
            </b>
        </div>
        <div id="three-columns"><b>Date Needed:</b> <b class="small"><?php echo $dateNeeded?></b>
        </div>
        <div id="three-columns"><b>Requested By:</b> <b class="small"><?php echo $fullName . " (" . $userName . ")";?></b>
        </div>

    </div>

    <div id="multi-columns">
        <?php if(count($attachments)) {?>
            <div id="two-columns"><b>Attachments:</b><br />
            <?php foreach($attachments as $row) {?> 
                <b class="small"><?php echo $row->attachments;?></b><br />
            <?php } ?>
            </div>
        <?php }?>
    
        <div id="two-columns"><b>Special Instructions:</b> 
        <textarea id="specialInstructions"> </textarea>
        <input type="hidden"  id="requestID"  value="<?php echo $ID?>" />

        <a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Open request #<?php echo $ID?> for Estimation','update_request','O')" style="width:80px">Open for Approval</a>
        <a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Return request #<?php echo $ID?> for Closing','update_request','R')" style="width:80px">Return for Closing</a>
        
        </div>
        
    </div>

</div>
</form>

</div>

<script type="text/javascript">

function CustomConfirm(){
	this.render = function(dialog,op,status){
		var winW = window.innerWidth;
	    var winH = window.innerHeight;
		var dialogoverlay = document.getElementById('dialogoverlay');
	    var dialogbox = document.getElementById('dialogbox');
		dialogoverlay.style.display = "block";
	    dialogoverlay.style.height = winH+"px";
		dialogbox.style.left = (winW/2) - (550 * .5)+"px";
	    dialogbox.style.top = "100px";
	    dialogbox.style.display = "block";
		
		document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
	    document.getElementById('dialogboxbody').innerHTML = dialog;
		document.getElementById('dialogboxfoot').innerHTML = '<button onclick="Confirm.yes(\''+op+'\',\''+status+'\')">Proceed</button> <button onclick="Confirm.no()">Close</button>';
	}
	this.no = function(){
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
	this.yes = function(op,status){
		if(op == "update_request"){
			updateRequest(status);
		}
		document.getElementById('dialogbox').style.display = "none";
		document.getElementById('dialogoverlay').style.display = "none";
	}
}
var Confirm = new CustomConfirm();


    function updateRequest(requestStatus) {
            jQuery.ajax({
            url: "updateRequestBAM",
            data:'ID='+$('#requestID').val()+'&requestStatus='+requestStatus+'&specialInstructions='+$('#specialInstructions').val(),
            type: "POST",
            success:function(data){
                var resultValue = $.parseJSON(data);
                if(resultValue['success'] == 1) {
                    $('div.requestFormLevel2').remove();
                    $('#tt').datagrid('reload')
                    return true;
                } else {
                    return false;
                }
            },
            error:function (){}
        }); //jQuery.ajax({

    }
</script>

</div>

