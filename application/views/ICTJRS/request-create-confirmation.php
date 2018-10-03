<div class="level1">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/ictjrs.css" />


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Create Request" style="width:100%;max-width:100%;padding:5px 5px;"> 

            <div style="margin-bottom:10px">
            <b class="label">Request Summary: </b><input  class="textbox-confirmation" readonly name="requestSummary" id="requestSummary"  value="<?php echo $requestSummary?>">
            </div>
            <div style="margin-bottom:10px">
            <b class="label">Request Details: </b><input  class="textbox-confirmation" readonly name="requestDetails" id="requestDetails"  value="<?php echo $requestDetails?>">
            </div>

            <div style="margin-bottom:10px" >
            <b class="label">Request Type: </b><input class="textbox-confirmation" readonly prompt="Request Type:" id="requestType" value="<?php echo $requestType?>">

            </div>

    </div>
</div>