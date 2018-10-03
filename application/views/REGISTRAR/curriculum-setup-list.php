<div class="level1">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/registrar/registrar.css" />


    <div style="margin:5px 0;"></div>
    <div class="easyui-panel" title="Curriculum List" style="width:100%;max-width:100%;padding:5px 5px;"> 
        <form id="ff" class="easyui-form" method="post" data-options="novalidate:true">
            <div style="margin-bottom:5px">


                <div style="margin-bottom:1px" class="three-column-60">
                    <input class="easyui-combobox" name="courseCode" id="courseCode" style="width:100%;" prompt="COURSE CODE:" data-options="
                            url:'getCurriculumCoursesREGISTRAR',
                            method:'get',
                            valueField:'courseCode',
                            textField:'shortCourseDescription',
                            onSelect: function(rec){
                                var url = 'getCurriculumYearREGISTRAR?courseCode='+rec.courseCode;
                                console.log( $('#floor').attr('prompt'));
                                $('#sy').textbox('clear');
                                $('#sy').combobox('reload', url);
                            },
                            panelHeight:'250px',
                            required:true
                            ">
                </div>


                <div style="margin-bottom:1px" class="three-column-20">
                    <input class="easyui-combobox" name="sy" id="sy" style="width:70%;" data-options="
                            valueField:'sy',
                            textField:'sy',
                            panelHeight:'auto',
                            prompt: 'SY:',
                            required:true
                            ">
                </div>

				<div style="text-align:center;padding:5px 0" class="three-column-20">
					<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()" style="width:80px">Search</a>
				</div>

				
            </div>

        </form>
    </div>

   <div id="error-messages"> </div>
  
    
	<script src="<?php echo base_url();?>assets/scripts/registrar/registrarcurriculum.js"></script>


</div>