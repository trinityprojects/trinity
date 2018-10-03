<div class="level1">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/building/tbamims.css" />


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Create Request" style="width:100%;max-width:100%;padding:5px 5px;"> 
                <div style="margin-bottom:10px" >
                    <b class="label">Location: </b> <input  class="textbox-confirmation" readonly name="locationCode" id="locationCode"  value="<?php echo $locationCode?>" >
            
                </div>

                <div style="margin-bottom:10px" class="two-column-30">
                <b class="label">Floor Number: </b><input  class="textbox-confirmation" readonly name="floor" id="floor"  value="<?php echo $floor?>" >
                </div>


                <div style="margin-bottom:10px" class="two-column-70">
                <b class="label">Room Number: </b><input class="textbox-confirmation" readonly name="roomNumber" id="roomNumber"  value="<?php echo $roomNumber?>" >
                </div>

            <div style="margin-bottom:10px">
            <b class="label">Project Title: </b><input  class="textbox-confirmation" readonly name="projectTitle" id="projectTitle"  value="<?php echo $projectTitle?>">

            </div>
            <div style="margin-bottom:10px" class="two-column">
            <b class="label">Scope of Works: </b><textarea class="confirmation" readonly name="scopeOfWorks" id="scopeOfWorks"><?php echo $scopeOfWorks?></textarea>
            </div>
            <div style="margin-bottom:10px" class="two-column">
            <b class="label">Project Justification: </b><textarea class="confirmation" readonly name="projectJustification" id="projectJustification"><?php echo $projectJustification?></textarea>

            </div>

            <div style="margin-bottom:10px" class="two-column">
            <b class="label">Date Needed: </b><input class="textbox-confirmation" readonly prompt="DATE NEEDED:" id="dateNeeded" value="<?php echo $dateNeeded?>">

            </div>

    </div>
</div>