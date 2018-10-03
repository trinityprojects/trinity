<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/hris/hris.css" />


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Employee Records Reports List" style="width:100%;max-width:100%;padding:5px 5px;"> 
        <form id="ff" class="easyui-form" method="post" data-options="novalidate:true">
            <div style="margin-bottom:5px">


                <div style="margin-bottom:1px" class="three-column-30">
                    <input class="easyui-combobox" name="reportsName" id="reportsName" style="width:100%;" prompt="REPORTS NAME:" data-options="
                            url:'getReportsListEmployeeTHRIMS',
                            method:'get',
                            valueField:'reportFileName',
                            textField:'reportsName',
                            onSelect: function(rec){
                                var url = 'getEmployeeListTHRIMS';
                                $('#fullName').textbox('clear');
                                $('#fullName').combobox('reload', url);
                            },
                            panelHeight:'200px',
                            required:true
                            ">
                </div>


                <div style="margin-bottom:1px" class="three-column-50">
                    <input class="easyui-combobox" name="fullName" id="fullName" style="width:100%;" data-options="
							valueField:'employeeNumber',
                            textField:'fullName',
                            panelHeight:'auto',
                            prompt: 'Employee Name:',
                            panelHeight:'200px',
                            ">
                </div>

				<div style="text-align:center;padding:5px 0" class="three-column-20">
					<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Search</a>
				</div>

				
            </div>

        </form>
    </div>

   <div id="error-messages"> </div>
  
    
	<script src="<?php echo base_url();?>assets/scripts/thrims/thrimsreports.js"></script>


</div>