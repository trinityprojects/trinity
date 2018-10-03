<div class="requestForm">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Create Request" style="width:100%;max-width:100%;padding:5px 5px;"> 
            <div style="margin-bottom:5px">
                <div style="margin-bottom:1px" >
                    <input  class="modal-textbox" readonly name="locationCode" id="locationCode"  value="<?php echo $locationCode?>" style="width:100%">
            
                </div>


                <div style="margin-bottom:1px" class="two-column-30">
                    <input  readonly name="floor" id="floor"  value="<?php echo $floor?>" style="width:100%">
                </div>


                <div style="margin-bottom:1px" class="two-column-70">
                    <input readonly name="roomNumber" id="roomNumber"  value="<?php echo $roomNumber?>" style="width:100%">
                </div>

            </div>
            <div style="margin-bottom:1px">
                <input  readonly name="projectTitle" id="projectTitle"  style="width:100%"  value="<?php echo $projectTitle?>">

            </div>
            <div style="margin-bottom:1px" class="two-column">
                <input readonly name="scopeOfWorks" id="scopeOfWorks" style="width:100%;height:100px" value="<?php echo $scopeOfWorks?>">

            </div>
            <div style="margin-bottom:1px" class="two-column">
                <input readonly name="projectJustification" id="projectJustification" style="width:100%;height:100px" value="<?php echo $projectJustification?>">

            </div>

            <div style="margin-bottom:1px" class="two-column">
                <input readonly prompt="DATE NEEDED:" id="dateNeeded" value="<?php echo $dateNeeded?>">

            </div>

    </div>
</div>