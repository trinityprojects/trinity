<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/hris/hris.css" />


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Ranking" style="width:100%;max-width:100%;padding:5px 5px;"> 
        <form id="ff" class="easyui-form" method="post" data-options="novalidate:true">
            <div style="margin-bottom:5px">


                <div style="margin-bottom:1px" class="three-column-30">
                    <input class="easyui-combobox" name="sectionCode" id="sectionCode" style="width:100%;" prompt="Section Code:" data-options="
                            url:'getAssignedAdvisersEGIS',
                            method:'get',
                            valueField:'sectionCode',
                            textField:'sectionCode',
                            panelHeight:'200px',
                            required:true
                            ">
                </div>

				<div style="text-align:center;padding:5px 0" class="three-column-20">
					<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitFormRankingBySection()" style="width:80px">By Section</a>
				</div>

				
                <div style="margin-bottom:1px" class="three-column-30">
                    <input class="easyui-combobox" name="yearLevel" id="yearLevel" style="width:100%;" data-options="
                            url:'getYearLevelEGIS',
                            method:'get',
                            valueField:'yearLevel',
                            textField:'yearLevelDescription',
                            panelHeight:'200px',
                            required:true
                            ">
                </div>

				<div style="text-align:center;padding:5px 0" class="three-column-20">
					<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitFormRankingByYearLevel()" style="width:80px">By Level</a>
				</div>

				
            </div>

        </form>
    </div>

   <div id="error-messages"> </div>
  
    
	<script src="<?php echo base_url();?>assets/scripts/egis/egisreports.js"></script>


</div>