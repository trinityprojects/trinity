<div class="level1">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/building/tbamims.css" />


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Create Request" style="width:100%;max-width:100%;padding:5px 5px;"> 

            <div style="margin-bottom:10px">
            <b class="label">Request Purpose: </b><input  class="textbox-confirmation" readonly name="requestPurpose" id="requestPurpose"  value="<?php echo $requestPurpose?>">
            </div>
            <div style="margin-bottom:10px">
            <b class="label">Request Remarks: </b><input  class="textbox-confirmation" readonly name="requestRemarks" id="requestRemarks"  value="<?php echo $requestRemarks?>">
            </div>

            <div style="margin-bottom:10px" >
            <b class="label">Date Needed: </b><input class="textbox-confirmation" readonly prompt="DATE NEEDED:" id="dateNeeded" value="<?php echo $dateNeeded?>">

            </div>

    </div>
</div>