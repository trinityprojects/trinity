<div class="level2">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/hris/hris.css" />


        <div id="p" class="easyui-panel" title="Personal Data" style="width:100%;height:350px;padding:10px;"
                data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">

			<table border='1' bordercolor="grey" class="theme-table">
				<tr > 
					<td rowspan='8' class="sheet"> 
						<img src="<?php echo base_url();?>assets/photos/employees/<?php echo $rows[0]->employeeNumber; ?>.jpg" alt="<?php echo $rows[0]->lastName . ";" . $rows[0]->firstName; ?>" style="width:150px;height:150px;"> 
					</td class="sheet"> 
					<td colspan="4" class="sheet-large"> <?php echo $rowsCareer[0]->jobTitleDescription; ?> </td> 
				</tr>

				<tr > 
					<td class="sheet"> Active? </td> 
					<td class="sheet"> 
						<?php 
							if($rows[0]->active == 0) { 
								echo "Inactive"; 
							} else { 
								echo "the employee is active";
							} 
						?> 
					</td> 
					<td class="sheet"> Gender </td> 
					<td class="sheet"> <?php echo $rows[0]->gender; ?>  </td> 
				</tr>
				
				
				<tr > 
					<td class="sheet"> Record ID: </td> 
					<td class="sheet"> <?php echo $rows[0]->ID; ?> </td> 
					<td class="sheet">Status:  </td> 
					<td class="sheet"> <?php echo $rowsCareer[0]->jobStatusDescription; ?> </td> 
					<input type='hidden' value="<?php echo $rowsCareer[0]->employeeStatusID; ?>"  id="employeeStatusID" />
				</tr>
				
				<tr> 
					<td class="sheet"> Employee Number: </td> 
					<td class="sheet"> 
						<?php echo $rows[0]->employeeNumber; ?> 
						<input type='hidden' value="<?php echo $rows[0]->employeeNumber; ?>"  id="employeeNumber" />
					</td> 
					<td class="sheet"> Station: </td> 
					<td class="sheet"> <?php echo $rowsCareer[0]->departmentDescription; ?> </td> 
				</tr>

				<tr> 
					<td class="sheet"> Full Name: </td> 
					<td class="sheet"> <?php echo $rows[0]->lastName . ", " . $rows[0]->firstName . " " . $rows[0]->middleName; ?> </td> 
					<td class="sheet">Classification:  </td> 
					<td class="sheet"> <?php echo $rowsCareer[0]->positionClass; ?> </td> 
				</tr>

				<tr> 
					<td class="sheet"> Corporate Email: </td> 
					<td class="sheet"> <?php echo $rows[0]->tuaEmailAddress; ?> </td> 
					<td class="sheet"> Civil Status:</td> 
					<td class="sheet"> <?php echo $rows[0]->civilStatus; ?> </td> 
				</tr>

				<tr> 
					<td class="sheet"> Personal Email: </td> 
					<td class="sheet"> <?php echo $rows[0]->emailAddress; ?> </td> 
					<td class="sheet">  Date Hired: </td> 
					<td class="sheet"> <?php echo $rows[0]->dateHired; ?> </td> 
				</tr>


				<tr> 
					<td class="sheet"> Mobile Number: </td> 
					<td class="sheet"> <?php echo $rows[0]->mobileNumber; ?> </td> 
					<td class="sheet"> Telephone Number: </td> 
					<td class="sheet"> <?php echo $rows[0]->telephoneNumber; ?> </td> 
				</tr>
					
					
				
			</table>

			

		</div>
	



    <div id="tt" class="easyui-tabs" style="width:100%;height:100%" data-options="tabPosition:'left'">
        <div title="Personal Data" style="padding:10px">
			        <div id="p" class="easyui-panel" title="Personal Data" style="width:100%;height:40%;padding:10px;"
						data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">
						
						<table border=".5" bordercolor="gray" width="85%">
							<tr >
								<td width="25%"> Active?<br>
									<input type="radio" name="active" value="1" checked="checked" class="easyui-validatebox" required="true" > Yes 
									<input type="radio" name="active" value="1" checked="checked" class="easyui-validatebox" required="true" > No  
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="dateHired" name="dateHired"  
									value="<?php echo $rows[0]->dateHired; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Date Hired:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#dateHired').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#dateHired').attr('id'));
										 }										 
									">
									
								</td>
								<td width="25%"> Years in Service: <br> <b><u>
								<?php 
								echo $yearsInService->y . " years " . $yearsInService->m." months";
								?></u></b>
								</td>
								<td width="25%"> 
									<input class="easyui-combobox" name="gender" value='<?php echo $rows[0]->gender; ?>' id="gender" style="width:100%;" data-options="
									url:'getGenderTHRIMS',
									method:'get',
									valueField:'gender',
									textField:'gender',
									panelHeight:'50px',
									required:true,
									label: 'Gender:',
									labelPosition: 'top',
									disabled: false,
									iconWidth: 22,
									icons: [{
									   iconCls:'icon-edit',
									}],
									onChange(value) {
										validateRecord(value, $('#gender').attr('id'));
									}
									">
								</td>
								
							</tr>
						
							<tr>
								<td> 
									<input class="easyui-combobox" name="prefixName" value='<?php echo $rows[0]->prefixName; ?>' id="prefixName" style="width:100%;" data-options="
									url:'getPrefixNameTHRIMS',
									method:'get',
									valueField:'prefixName',
									textField:'prefixName',
									panelHeight:'100px',
									required:true,
									label: 'Prefix Name:',
									labelPosition: 'top',
									disabled: false,
									iconWidth: 22,
									icons: [{
									   iconCls:'icon-edit',
									}],
									onChange(value) {
										validateRecord(value, $('#prefixName').attr('id'));
									}
									">
								</td>
								<td> 
									<input class="easyui-textbox" id="lastName" name="lastName"  
									value="<?php echo $rows[0]->lastName; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Last Name:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#lastName').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#lastName').attr('id'));
										 }										 
									">
								</td>
								<td> 
									<input class="easyui-textbox" id="firstName" name="firstName"  
									value="<?php echo $rows[0]->firstName; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'First Name:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#firstName').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#firstName').attr('id'));
										 }										 
									">
								
								
								</td>
								<td> 
									<input class="easyui-textbox" id="middleName" name="middleName"  
									value="<?php echo $rows[0]->middleName; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Middle Name:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#middleName').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#middleName').attr('id'));
										 }										 
									">
								
								
								</td>
								
							</tr>


							<tr>
								<td> 
									<input class="easyui-combobox" name="civilStatus" value='<?php echo $rows[0]->civilStatus; ?>' id="civilStatus" style="width:100%;" data-options="
									url:'getCivilStatusTHRIMS',
									method:'get',
									valueField:'civilStatus',
									textField:'civilStatus',
									panelHeight:'100px',
									required:true,
									label: 'Civil Status:',
									labelPosition: 'top',
									disabled: false,
									iconWidth: 22,
									icons: [{
									   iconCls:'icon-edit',
									}],
									onChange(value) {
										validateRecord(value, $('#civilStatus').attr('id'));
									}
									">
								</td>
								<td> 
									<input class="easyui-textbox" id="maidenName" name="maidenName"  
									value="<?php echo $rows[0]->maidenName; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Maiden Name:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#maidenName').attr('id'));
											   }
										 }], required:false, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#maidenName').attr('id'));
										 }										 
									">
								</td>
								<td> 
									<input class="easyui-textbox" id="nickName" name="nickName"  
									value="<?php echo $rows[0]->nickName; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Nick Name:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#nickName').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#nickName').attr('id'));
										 }										 
									">
								
								
								</td>
								<td> 
									<input class="easyui-combobox" name="bloodType" value='<?php echo $rows[0]->bloodType; ?>' id="bloodType" style="width:100%;" data-options="
									url:'getBloodTypeTHRIMS',
									method:'get',
									valueField:'bloodType',
									textField:'bloodType',
									panelHeight:'100px',
									required:true,
									label: 'Blood Type:',
									labelPosition: 'top',
									disabled: false,
									iconWidth: 22,
									icons: [{
									   iconCls:'icon-edit',
									}],
									onChange(value) {
										validateRecord(value, $('#bloodType').attr('id'));
									}
									">
								
								
								</td>
								
							</tr>



							<tr>
								<td> 
									<input class="easyui-textbox" id="birthDate" name="birthDate"  
									value="<?php echo $rows[0]->birthDate; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Birth Date:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#birthDate').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#birthDate').attr('id'));
										 }										 
									">
									
								</td>
								<td> Age: <br> <b><u>
								<?php 
								echo $age->y . " years old";
								?></u></b>
								</td>
								<td> 
								<input class="easyui-combobox" name="birthPlace" value='<?php echo $rows[0]->birthPlace; ?>' id="birthPlace" style="width:100%;" data-options="
									url:'getBirthPlaceTHRIMS',
									method:'get',
									valueField:'birthPlace',
									textField:'birthPlace',
									panelHeight:'100px',
									required:true,
									label: 'Birth Place:',
									labelPosition: 'top',
									disabled: false,
									iconWidth: 22,
									icons: [{
									   iconCls:'icon-edit',
									}],
									onChange(value) {
										validateRecord(value, $('#birthPlace').attr('id'));
									}
									">
									
									
								</td>
								<td> 									
								<input class="easyui-combobox" name="religionID" value='<?php echo $rows[0]->religionID; ?>' id="religionID" style="width:100%;" data-options="
									url:'getReligionTHRIMS',
									method:'get',
									valueField:'religionDescription',
									textField:'religionDescription',
									panelHeight:'100px',
									required:true,
									label: 'Religion:',
									labelPosition: 'top',
									disabled: false,
									iconWidth: 22,
									icons: [{
									   iconCls:'icon-edit',
									}],
									onChange(value) {
										validateRecord(value, $('#religionID').attr('id'));
									}
									">
								
								</td>
								
							</tr>


							<tr>
								<td> 
									<input class="easyui-textbox" id="heightFeet" name="heightFeet"  
									value="<?php echo $rows[0]->heightFeet; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Height:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#heightFeet').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#heightFeet').attr('id'));
										 }										 
									">
									
								</td>

								<td> 
									<input class="easyui-textbox" id="weight" name="weight"  
									value="<?php echo $rows[0]->weight; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Weight:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#weight').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#weight').attr('id'));
										 }										 
									">
								</td>
								<td> 									
								<input class="easyui-combobox" name="citizenshipID" value='<?php echo $rows[0]->citizenshipID; ?>' id="citizenshipID" style="width:100%;" data-options="
									url:'getCitizenshipTHRIMS',
									method:'get',
									valueField:'citizenshipDescription',
									textField:'citizenshipDescription',
									panelHeight:'100px',
									required:true,
									label: 'Citizenship:',
									labelPosition: 'top',
									disabled: false,
									iconWidth: 22,
									icons: [{
									   iconCls:'icon-edit',
									}],
									onChange(value) {
										validateRecord(value, $('#citizenshipID').attr('id'));
									}
									">
								
								</td>
								<td> 
								</td>								
							</tr>

							
						</table>
						
						
						

					</div>


					
					
			        <div id="p" class="easyui-panel" title="Address and Contact Information" style="width:100%;height:40%;padding:10px;"
						data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">

						<table border=".5" bordercolor="gray" width="85%">
							<tr >
								<td colspan='4'>Permanent Address</td>
							</tr>

							
							<tr >
								<td width="25%"> 
									<input class="easyui-textbox" id="cityStreet" name="cityStreet"  
									value="<?php echo $rows[0]->cityStreet; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Street:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#cityStreet').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#cityStreet').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-combobox" name="cityBarangay" value='<?php echo $rows[0]->cityBarangay; ?>' id="cityBarangay" style="width:100%;" data-options="
										url:'getBarangayTHRIMS',
										method:'get',
										valueField:'barangayDescription',
										textField:'barangayDescription',
										panelHeight:'100px',
										required:true,
										label: 'Barangay:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#cityBarangay').attr('id'));
										}
										">
									
								</td>
								<td width="25%"> 
									
									<input class="easyui-combobox" name="cityTown" value='<?php echo $rows[0]->cityTown; ?>' id="cityTown" style="width:100%;" data-options="
										url:'getTownTHRIMS',
										method:'get',
										valueField:'townDescription',
										textField:'townDescription',
										panelHeight:'100px',
										required:true,
										label: 'Town:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#cityTown').attr('id'));
										}
										">
									
								</td>
								<td width="25%"> 
									
									<input class="easyui-combobox" name="cityCity" value='<?php echo $rows[0]->cityCity; ?>' id="cityTown" style="width:100%;" data-options="
										url:'getCityTHRIMS',
										method:'get',
										valueField:'cityDescription',
										textField:'cityDescription',
										panelHeight:'100px',
										required:true,
										label: 'City:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#cityCity').attr('id'));
										}
										">
									
									
								</td>
							</tr>

							
							<tr >
								<td width="25%"> 
									
									<input class="easyui-combobox" name="cityCountry" value='<?php echo $rows[0]->cityCountry; ?>' id="cityCountry" style="width:100%;" data-options="
										url:'getCountry',
										method:'get',
										valueField:'country',
										textField:'country',
										panelHeight:'100px',
										required:true,
										label: 'Country:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#cityCountry').attr('id'));
										}
										">
									
									
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="cityZip" name="cityZip"  
									value="<?php echo $rows[0]->cityZip; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'ZIP:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#cityZip').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#cityZip').attr('id'));
										 }										 
									">
									
								</td>
								<td width="25%"> 
								</td>
								<td width="25%"> 
								</td>
							</tr>							
							
							<tr >
								<td width="25%"> 
									<input class="easyui-textbox" id="telephoneNumber" name="telephoneNumber"  
									value="<?php echo $rows[0]->telephoneNumber; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Telephone Number:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#telephoneNumber').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#telephoneNumber').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="mobileNumber" name="mobileNumber"  
									value="<?php echo $rows[0]->mobileNumber; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Mobile Number:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#mobileNumber').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#mobileNumber').attr('id'));
										 }										 
									">
									
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="emailAddress" name="emailAddress"  
									value="<?php echo $rows[0]->emailAddress; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Email Address:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#emailAddress').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#emailAddress').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="tuaEmailAddress" name="tuaEmailAddress"  
									value="<?php echo $rows[0]->tuaEmailAddress; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Company Email Address:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#tuaEmailAddress').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#tuaEmailAddress').attr('id'));
										 }										 
									">
								</td>
							</tr>							
						</table>	
						

						<table border=".5" bordercolor="gray" width="85%">
							<tr >
								<td colspan='4' >Provincial Address</td>
							</tr>

							
							<tr >
								<td width="25%"> 
									<input class="easyui-textbox" id="provincialStreet" name="provincialStreet"  
									value="<?php echo $rows[0]->provincialStreet; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Street:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#provincialStreet').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#provincialStreet').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-combobox" name="provincialBarangay" value='<?php echo $rows[0]->provincialBarangay; ?>' id="provincialBarangay" style="width:100%;" data-options="
										url:'getProvincialBarangayTHRIMS',
										method:'get',
										valueField:'provincialBarangayDescription',
										textField:'provincialBarangayDescription',
										panelHeight:'100px',
										required:true,
										label: 'Barangay:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#provincialBarangay').attr('id'));
										}
										">
									
								</td>
								<td width="25%"> 
									
									<input class="easyui-combobox" name="provincialTown" value='<?php echo $rows[0]->provincialTown; ?>' id="provincialTown" style="width:100%;" data-options="
										url:'getProvincialTownTHRIMS',
										method:'get',
										valueField:'provincialTownDescription',
										textField:'provincialTownDescription',
										panelHeight:'100px',
										required:true,
										label: 'Town:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#provincialTown').attr('id'));
										}
										">
									
								</td>
								<td width="25%"> 
									
									<input class="easyui-combobox" name="provincialCity" value='<?php echo $rows[0]->provincialCity; ?>' id="provincialCity" style="width:100%;" data-options="
										url:'getProvincialCityTHRIMS',
										method:'get',
										valueField:'provincialCityDescription',
										textField:'provincialCityDescription',
										panelHeight:'100px',
										required:true,
										label: 'City:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#provincialCity').attr('id'));
										}
										">
									
								</td>
							</tr>

							
							<tr >
								<td width="25%"> 
									
									
									<input class="easyui-combobox" name="provincialCountry" value='<?php echo $rows[0]->provincialCountry; ?>' id="provincialCountry" style="width:100%;" data-options="
										url:'getCountry',
										method:'get',
										valueField:'country',
										textField:'country',
										panelHeight:'100px',
										required:true,
										label: 'Country:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#provincialCountry').attr('id'));
										}
										">
									
									
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="provincialZip" name="provincialZip"  
									value="<?php echo $rows[0]->provincialZip; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'ZIP:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#provincialZip').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#provincialZip').attr('id'));
										 }										 
									">
									
								</td>
								<td width="25%"> 
								</td>
								<td width="25%"> 
								</td>
							</tr>							

						</table>	
					
					</div>
		
        </div>

        <div title="Job" style="padding:10px">
			        <div id="p" class="easyui-panel" title="IDs and Licenses" style="width:100%;height:15%;padding:10px;"
						data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">

						<table border=".5" bordercolor="gray" width="85%">
							<tr >
								<td width="20%"> 
									<input class="easyui-textbox" id="tin" name="tin"  
									value="<?php echo $rows[0]->tin; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'TIN:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#tin').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#tin').attr('id'));
										 }										 
									">
								</td>
								<td width="20%"> 
									<input class="easyui-textbox" id="sss" name="sss"  
									value="<?php echo $rows[0]->sss; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'SSS:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#sss').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#sss').attr('id'));
										 }										 
									">
									
								</td>
								<td width="20%"> 
									<input class="easyui-textbox" id="pagibig" name="pagibig"  
									value="<?php echo $rows[0]->pagibig; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'PAG IBIG:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#pagibig').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#pagibig').attr('id'));
										 }										 
									">
								</td>
								<td width="20%"> 
									<input class="easyui-textbox" id="philHealth" name="philHealth"  
									value="<?php echo $rows[0]->philHealth; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'PHILHEALTH:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#philHealth').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#philHealth').attr('id'));
										 }										 
									">
								</td>

								<td width="20%"> 
									<input class="easyui-textbox" id="prc" name="prc"  
									value="<?php echo $rows[0]->prc; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'PRC:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#prc').attr('id'));
											   }
										 }], required:false, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#prc').attr('id'));
										 }										 
									">
								</td>

								
							</tr>
						</table>	
					</div>	
					
			        <div id="p" class="easyui-panel" title="Current Job Assignment" style="width:100%;height:20%;padding:10px;"
						data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">

						<table border=".5" bordercolor="gray" width="85%">

							
							<tr >
								<td width="33%"> 
									<input class="easyui-textbox" id="startDate" name="startDate"  
									value="<?php echo $rowsCareer[0]->startDate; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Start Date:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#startDate').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#startDate').attr('id'));
										 }										 
									">
								</td>
								<td width="33%"> 
									<input class="easyui-textbox" id="expiryDate" name="expiryDate"  
									value="<?php echo $rowsCareer[0]->expiryDate; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Expiry Date:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#expiryDate').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#expiryDate').attr('id'));
										 }										 
									">
									
								</td>
								<td width="34%"> 
									
									<input class="easyui-combobox" name="jobTitleDescription" value='<?php echo $rowsCareer[0]->jobTitleDescription; ?>' id="jobTitleDescription" style="width:100%;" data-options="
										url:'getJobTitleTHRIMS',
										method:'get',
										valueField:'jobTitleDescription',
										textField:'jobTitleDescription',
										panelHeight:'100px',
										required:true,
										label: 'Job Title:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#jobTitleDescription').attr('id'));
										}
										">
									
								</td>
							</tr>

							
							<tr >
								<td width="33%"> 
									
									
									<input class="easyui-combobox" name="positionClass" value='<?php echo $rowsCareer[0]->positionClass; ?>' id="positionClass" style="width:100%;" data-options="
										url:'getPositionClassTHRIMS',
										method:'get',
										valueField:'positionClass',
										textField:'positionClass',
										panelHeight:'100px',
										required:true,
										label: 'Classification:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#positionClass').attr('id'));
										}
										">
									
									
								</td>
								<td width="33%"> 
									<input class="easyui-combobox" name="jobStatusDescription" value='<?php echo $rowsCareer[0]->jobStatusDescription; ?>' id="jobStatusDescription" style="width:100%;" data-options="
										url:'getJobStatusTHRIMS',
										method:'get',
										valueField:'jobStatusDescription',
										textField:'jobStatusDescription',
										panelHeight:'100px',
										required:true,
										label: 'Job Status:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#jobStatusDescription').attr('id'));
										}
										">
									
								</td>
								<td width="34%"> 
									<input class="easyui-combobox" name="departmentDescription" value='<?php echo $rowsCareer[0]->departmentDescription; ?>' id="departmentDescription" style="width:100%;" data-options="
										url:'getEmployeeDepartmentTHRIMS',
										method:'get',
										valueField:'departmentDescription',
										textField:'departmentDescription',
										panelHeight:'100px',
										required:true,
										label: 'Job Station:',
										labelPosition: 'top',
										disabled: false,
										iconWidth: 22,
										icons: [{
										   iconCls:'icon-edit',
										}],
										onChange(value) {
											validateRecord(value, $('#departmentDescription').attr('id'));
										}
										">
								
								</td>
							</tr>							

						</table>	
					</div>
					
			        <div id="p" class="easyui-panel" title="Other Assignments" style="width:100%;height:35%;padding:10px;"
						data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">
						<table id="dg1" class="easyui-datagrid" title="Concurrent Assignments" style="width:100%;height:220px"
								data-options="
									iconCls: 'icon-edit',
									singleSelect: true,
									toolbar: '#tb1',
									url: 'getEmploymentCareerAssignmentsTHRIMS',
									method: 'get',
									onClickCell: onClickCell,
									onEndEdit: onEndEdit,
									queryParams:{employeeNumber:'<?php echo $rows[0]->employeeNumber;?>'
									}">
							<thead>
								<tr>
									<th data-options="field:'ID',width:25" >ID</th>  
									<th data-options="field:'startDate',width:100,editor:'datebox'" >Start Date</th>  
									<th data-options="field:'expiryDate',width:100,editor:'datebox'">Expiry Date</th>  
									
									<th data-options="field:'jobTitleDescription',width:250,
											formatter:function(value,row){
												return row.jobTitleDescription;
											},
											editor:{
												type:'combobox',
												options:{
													valueField:'jobTitleID',
													textField:'jobTitleDescription',
													method:'get',
													url:'getJobTitleTHRIMS',
													required:true
												}
											}">Job Title</th>

									<th data-options="field:'departmentDescription',width:300,
											formatter:function(value,row){
												return row.departmentDescription;
											},
											editor:{
												type:'combobox',
												options:{
													valueField:'departmentID',
													textField:'departmentDescription',
													method:'get',
													url:'getEmployeeDepartmentTHRIMS',
													required:true
												}
											}">Job Station</th>
									<th data-options="field:'positionClass',width:100,
											formatter:function(value,row){
												return row.positionClass;
											},
											editor:{
												type:'combobox',
												options:{
													valueField:'positionClassID',
													textField:'positionClass',
													method:'get',
													url:'getPositionClassTHRIMS',
													required:true
												}
											}">Classification</th>
								</tr>
							</thead>
						</table>
		 
					<div id="tb1" style="height:auto">
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="append()">Append</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeit()">Remove</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="accept()">Save</a>
						<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reset</a>-->
						<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
					</div>

					<script>
						$.fn.datebox.defaults.formatter = function(date) {
							var y = date.getFullYear();
							var m = date.getMonth() + 1;
							var d = date.getDate();
							return y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d);
						};

						$.fn.datebox.defaults.parser = function(s) {
							if (s) {
								var a = s.split('-');
								var d = new Number(a[2]);
								var m = new Number(a[1]);
								var y = new Number(a[0]);
								var dd = new Date(y, m-1, d);
								return dd;
							} else {
								return new Date();
							}
						};					
					</script>
	
					<script type="text/javascript">
						var editIndex = undefined;
						var operations = undefined;
						var appendFlag = 0;
						var deleteCtr = 0;
						var deleteIndex = undefined;
						


						
						function endEditing(){ 
							if (editIndex == undefined){return true}
							if ($('#dg1').datagrid('validateRow', editIndex)){
								$('#dg1').datagrid('endEdit', editIndex);
								editIndex = undefined;
								return true;
							} else {
								return false;
							}
						}

						
						function onClickCell(index, field){ 
							if (editIndex != index){
								if (endEditing()){
									$('#dg1').datagrid('selectRow', index)
											.datagrid('beginEdit', index);
									var ed = $('#dg1').datagrid('getEditor', {index:index,field:field});
									
									if (ed){
										($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
									}
									editIndex = index;
								} else {
									setTimeout(function(){
										$('#dg1').datagrid('selectRow', editIndex);
									},0);
								}
							}
						}
						
						/*function onClickCell(index, field){ 
							if (editIndex != index){
								if (endEditing()){
									editIndex = index;
								} else {
									setTimeout(function(){
										$('#dg1').datagrid('selectRow', editIndex);
									},0);
								}
							}
						}*/
						
					

					
						function onEndEdit(index, row){ 
						
							alert('go');
							var jobTitleID = row.jobTitleDescription;
							var departmentID = row.departmentDescription;
							var positionClassID = row.positionClass;
							var startDate = row.startDate;
							var expiryDate = row.expiryDate;
							
							var ed = $(this).datagrid('getEditor', {
								index: index,
								field: 'jobTitleDescription'
							});
							row.jobTitleDescription = $(ed.target).combobox('getText');
							var ed = $(this).datagrid('getEditor', {
								index: index,
								field: 'departmentDescription'
							});
							row.departmentDescription = $(ed.target).combobox('getText');
							var ed = $(this).datagrid('getEditor', {
								index: index,
								field: 'positionClass'
							});
							row.positionClass = $(ed.target).combobox('getText');
							
							if(operations == 'save' && appendFlag == 1) {
								
								addRecordECA(startDate, expiryDate, jobTitleID, departmentID, positionClassID);
								appendFlag = 0;
							}  else if(operations == 'save' && appendFlag == 0) {
								
								var ID = $('#dg1').datagrid('getRows')[editIndex].ID;
								updateRecordECA(startDate, expiryDate, jobTitleID, departmentID, positionClassID, ID);
								alert('update1');
							}
							
						}
						function append(){ 
							if (endEditing()){
								appendFlag = 1;
								$('#dg1').datagrid('appendRow',{});
								editIndex = $('#dg1').datagrid('getRows').length-1;
								$('#dg1').datagrid('selectRow', editIndex)
										.datagrid('beginEdit', editIndex);
							}
						}
						
						
						
						function removeit(){ 
							if (editIndex == undefined){return}
								var result = confirm("Proceed with delete?");
								if(result) {
									var ID = $('#dg1').datagrid('getRows')[editIndex].ID;
									$('#dg1').datagrid('cancelEdit', editIndex)
											.datagrid('deleteRow', editIndex);
											
									
									deleteRecordECA(ID);
									deleteIndex = editIndex;
									editIndex = undefined;
									deleteCtr++;
									appendFlag = 0;
								}
						}
						
						
						function accept(){ 
							operations = 'save';
							
							if (endEditing()){
								$('#dg1').datagrid('acceptChanges');
								
							}
						}
						
						function reject(){ 
							if(deleteCtr == 0 || appendFlag == 1) {
								$('#dg1').datagrid('rejectChanges');
								editIndex = undefined;
							}
						}
						function getChanges(){
							var rows = $('#dg1').datagrid('getChanges');
							alert(rows.length+' rows are changed!');
						}
						
						
						function addRecordECA(startDate, expiryDate, jobTitleID, departmentID, positionClassID) {
							jQuery.ajax({
								url: "insertEmployeeCareerAssignmentsTHRIMS",
								data: { 
									'jobTitleID': jobTitleID, 
									'departmentID': departmentID, 
									'positionClassID': positionClassID, 
									'employeeStatusID': $('#employeeStatusID').val(), 
									'employeeNumber': $('#employeeNumber').val(), 
									'startDate': startDate, 
									'expiryDate': expiryDate, 
									
								},
								type: "POST",
								success:function(data){
									console.log(data);
									var resultValue = $.parseJSON(data);
									if(resultValue['success'] == 1) {
										return true;					
									}
									
								},
								error:function (){}
							}); //jQuery.ajax({	
						}	

						function deleteRecordECA(ID) {
							//alert(employeeNumber + departmentCode + designationDescription);
							jQuery.ajax({
								url: "deleteEmployeeCareerAssignmentsTHRIMS",
								data: { 
									'ID': ID, 
								},
								type: "POST",
								success:function(data){
									console.log(data);
									var resultValue = $.parseJSON(data);
									if(resultValue['success'] == 1) {
										return true;					
									}
									
								},
								error:function (){}
							}); //jQuery.ajax({	
							
							
						}
					
						function updateRecordECA(startDate, expiryDate, jobTitleID, departmentID, positionClassID, ID) {
							//alert(startDate + expiryDate + departmentID + positionClassID + "--" + ID);
							jQuery.ajax({
								url: "updateEmployeeCareerAssignmentsTHRIMS",
								data: { 
									'ID': ID, 
									'startDate': startDate, 
									'expiryDate': expiryDate, 
									'jobTitleID': jobTitleID, 
									'departmentID': departmentID, 
									'positionClassID': positionClassID, 
									'employeeNumber': $('#employeeNumber').val(), 
								},
								type: "POST",
								success:function(data){
									console.log(data);
									var resultValue = $.parseJSON(data);
									if(resultValue['success'] == 1) {
										return true;					
									}
									
								},
								error:function (){}
							}); //jQuery.ajax({	

						}	
							
					</script>
				</div>					
		</div>
		
        <div title="Relatives" style="padding:10px">
			        <div id="p" class="easyui-panel" title="Relatives Information" style="width:100%;height:40%;padding:10px;"
						data-options="iconCls:'icon-save',collapsible:true,minimizable:false,maximizable:false,closable:false">

						<table border=".5" bordercolor="gray" width="85%">
							<tr >
								<td colspan='4' >Espouse Information</td>
							</tr>

							
							<tr >
								<td width="25%"> 
									<input class="easyui-textbox" id="spouseName" name="spouseName"  
									value="<?php echo $rows[0]->spouseName; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Spouse Name:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#spouseName').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#spouseName').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="spouseBirthDay" name="spouseBirthDay"  
									value="<?php echo $rows[0]->spouseBirthDay; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Spouse Birthday: <?php echo $spouseAge->y . " yrs old" ?>',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#spouseBirthDay').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#spouseBirthDay').attr('id'));
										 }										 
									">
									
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="spouseOccupation" name="spouseOccupation"  
									value="<?php echo $rows[0]->spouseOccupation; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Spouse Occupation:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#spouseOccupation').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#spouseOccupation').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="spouseEmployer" name="spouseEmployer"  
									value="<?php echo $rows[0]->spouseEmployer; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Spouse Employer:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#spouseEmployer').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#spouseEmployer').attr('id'));
										 }										 
									">
								</td>
							</tr>

							<tr >
								<td colspan='4' >Father Information</td>
							</tr>

							
							<tr >
								<td width="25%"> 
									<input class="easyui-textbox" id="fatherName" name="fatherName"  
									value="<?php echo $rows[0]->fatherName; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Father Name:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#fatherName').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#fatherName').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="fatherBirthDay" name="fatherBirthDay"  
									value="<?php echo $rows[0]->fatherBirthDay; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Father Birthday: <?php echo $fatherAge->y . " yrs old" ?>',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#fatherBirthDay').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#fatherBirthDay').attr('id'));
										 }										 
									">
									
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="fatherOccupation" name="fatherOccupation"  
									value="<?php echo $rows[0]->fatherOccupation; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Father Occupation:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#fatherOccupation').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#fatherOccupation').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="fatherStatus" name="fatherStatus"  
									value="<?php echo $rows[0]->fatherStatus; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Father Status:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#fatherStatus').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#fatherStatus').attr('id'));
										 }										 
									">
								</td>
							</tr>
							



							<tr >
								<td colspan='4' >Mother Information</td>
							</tr>

							
							<tr >
								<td width="25%"> 
									<input class="easyui-textbox" id="motherName" name="motherName"  
									value="<?php echo $rows[0]->motherName; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Mother Name:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#motherName').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#motherName').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="motherBirthDay" name="motherBirthDay"  
									value="<?php echo $rows[0]->fatherBirthDay; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Mother Birthday: <?php echo $motherAge->y . " yrs old" ?>',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#motherBirthDay').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#motherBirthDay').attr('id'));
										 }										 
									">
									
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="motherOccupation" name="motherOccupation"  
									value="<?php echo $rows[0]->motherOccupation; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Mother Occupation:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#motherOccupation').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#motherOccupation').attr('id'));
										 }										 
									">
								</td>
								<td width="25%"> 
									<input class="easyui-textbox" id="motherStatus" name="motherStatus"  
									value="<?php echo $rows[0]->fatherStatus; ?>" style="width:100%" 
									data-options="
										 editable: false,
										 label: 'Mother Status:',
										 iconWidth: 22,
										 icons: [{
											   iconCls:'icon-edit',
											   handler: function(e){
												   enableEdit($('#motherStatus').attr('id'));
											   }
										 }], required:true, labelPosition: 'top',
										 onChange: function(value){
											validateRecord(value, $('#motherStatus').attr('id'));
										 }										 
									">
								</td>
							</tr>

							
							
						</table>
						
						
					</div>
	
		</div>
		
        <div title="Children" style="padding:10px">
						<table id="dgChild" class="easyui-datagrid" title="Children" style="width:100%;height:220px"
								data-options="
									iconCls: 'icon-edit',
									singleSelect: true,
									toolbar: '#tbChild',
									url: 'getChildrenTHRIMS',
									method: 'get',
									onClickCell: onClickCellChild,
									onEndEdit: onEndEditChild,
									queryParams:{employeeNumber:'<?php echo $rows[0]->employeeNumber;?>'
									}">
							<thead>
								<tr>
									<th data-options="field:'ID',width:25" >ID</th>  
									<th data-options="field:'fullName',width:250,editor:'textbox'" >Full Name</th>  
									<th data-options="field:'birthDay',width:100,editor:'datebox'">Birth Date</th>  
									<th data-options="field:'civilStatus',width:100,editor:'textbox'" >Civil Status</th>  
								</tr>
							</thead>
						</table>
		 
					<div id="tbChild" style="height:auto">
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-add',plain:true" onclick="appendChildr()">Append</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-remove',plain:true" onclick="removeitChild()">Remove</a>
						<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save',plain:true" onclick="acceptChild()">Save</a>
						<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-undo',plain:true" onclick="reject()">Reset</a>-->
						<!--<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-search',plain:true" onclick="getChanges()">GetChanges</a>-->
					</div>

					<script>
						/*$.fn.datebox.defaults.formatter = function(date) {
							var y = date.getFullYear();
							var m = date.getMonth() + 1;
							var d = date.getDate();
							return y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d);
						};

						$.fn.datebox.defaults.parser = function(s) {
							if (s) {
								var a = s.split('-');
								var d = new Number(a[2]);
								var m = new Number(a[1]);
								var y = new Number(a[0]);
								var dd = new Date(y, m-1, d);
								return dd;
							} else {
								return new Date();
							}
						};		*/			
					</script>
	
					<script type="text/javascript">
						var editIndexChild = undefined;
						var operationsChild = undefined;
						var appendFlagChild = 0;
						var deleteCtrChild = 0;
						var deleteIndexChild = undefined;
						


						
						function endEditingChild(){ 
							if (editIndexChild == undefined){return true}
							if ($('#dgChild').datagrid('validateRow', editIndexChild)){
								$('#dgChild').datagrid('endEdit', editIndexChild);
								editIndexChild = undefined;
								return true;
							} else {
								return false;
							}
						}

						
						function onClickCellChild(index, field){ 
							if (editIndexChild != index){
								if (endEditingChild()){
									$('#dgChild').datagrid('selectRow', index)
											.datagrid('beginEdit', index);
									var ed = $('#dgChild').datagrid('getEditor', {index:index,field:field});
									
									if (ed){
										($(ed.target).data('textbox') ? $(ed.target).textbox('textbox') : $(ed.target)).focus();
									}
									editIndexChild = index;
								} else {
									setTimeout(function(){
										$('#dgChild').datagrid('selectRow', editIndexChild);
									},0);
								}
							}
						}
						
						/*function onClickCell(index, field){ 
							if (editIndex != index){
								if (endEditing()){
									editIndex = index;
								} else {
									setTimeout(function(){
										$('#dg1').datagrid('selectRow', editIndex);
									},0);
								}
							}
						}*/
						
					

					
						function onEndEditChild(index, row){ 
						
							alert('go');
							var fullName = row.fullName;
							var birthDay = row.birthDay;
							var civilStatus = row.civilStatus;
							
							if(operationsChild == 'save' && appendFlagChild == 1) {
								
								addRecordChild(fullName, birthDay, civilStatus);
								appendFlagChild = 0;
							}  else if(operationsChild == 'save' && appendFlagChild == 0) {
								
								var ID = $('#dgChild').datagrid('getRows')[editIndexChild].ID;
								updateRecordChild(fullName, birthDay, civilStatus, ID);
								alert('update');
							}
							
						}
						function appendChildr(){ 
							if (endEditingChild()){
								appendFlagChild = 1;
								$('#dgChild').datagrid('appendRow',{});
								editIndexChild = $('#dgChild').datagrid('getRows').length-1;
								$('#dgChild').datagrid('selectRow', editIndexChild)
										.datagrid('beginEdit', editIndexChild);
							}
						}
						
						
						
						function removeitChild(){ 
							if (editIndexChild == undefined){return}
								var result = confirm("Proceed with delete?");
								if(result) {
									var ID = $('#dgChild').datagrid('getRows')[editIndexChild].ID;
									$('#dgChild').datagrid('cancelEdit', editIndexChild)
											.datagrid('deleteRow', editIndexChild);
											
									
									deleteRecordChild(ID);
									deleteIndeChild = editIndexChild;
									editIndexChild = undefined;
									deleteCtrChild++;
									appendFlagChild = 0;
								}
						}
						
						
						function acceptChild(){ 
							operationsChild = 'save';
							
							if (endEditingChild()){
								$('#dgChild').datagrid('acceptChanges');
								
							}
						}
						
						function rejectChild(){ 
							if(deleteCtrChild == 0 || appendFlagChild == 1) {
								$('#dgChild').datagrid('rejectChanges');
								editIndexChild = undefined;
							}
						}
						function getChangesChild(){
							var rows = $('#dgChild').datagrid('getChanges');
							alert(rows.length+' rows are changed!');
						}
						
						
						function addRecordChild(fullName, birthDay, civilStatus) {
							jQuery.ajax({
								url: "insertChildrenTHRIMS",
								data: { 
									'fullName': fullName, 
									'birthDay': birthDay, 
									'civilStatus': civilStatus, 
									'employeeNumber': $('#employeeNumber').val(), 
								},
								type: "POST",
								success:function(data){
									console.log(data);
									var resultValue = $.parseJSON(data);
									if(resultValue['success'] == 1) {
										return true;					
									}
									
								},
								error:function (){}
							}); //jQuery.ajax({	
						}	

						function deleteRecordChild(ID) {
							//alert(employeeNumber + departmentCode + designationDescription);
							jQuery.ajax({
								url: "deleteChildrenTHRIMS",
								data: { 
									'ID': ID, 
								},
								type: "POST",
								success:function(data){
									console.log(data);
									var resultValue = $.parseJSON(data);
									if(resultValue['success'] == 1) {
										return true;					
									}
									
								},
								error:function (){}
							}); //jQuery.ajax({	
							
							
						}
					
						function updateRecordChild(fullName, birthDay, civilStatus, ID) {
							//alert(startDate + expiryDate + departmentID + positionClassID + "--" + ID);
							jQuery.ajax({
								url: "updateChildrenTHRIMS",
								data: { 
									'ID': ID, 
									'fullName': fullName, 
									'birthDay': birthDay, 
									'civilStatus': civilStatus, 
									'employeeNumber': $('#employeeNumber').val(), 
								},
								type: "POST",
								success:function(data){
									console.log(data);
									var resultValue = $.parseJSON(data);
									if(resultValue['success'] == 1) {
										return true;					
									}
									
								},
								error:function (){}
							}); //jQuery.ajax({	

						}	
							
					</script>
	
		</div>

        <div title="Education" style="padding:10px">
        </div>


        <div title="Dependents" style="padding:10px">
        </div>
		
        <div title="Eligibility" style="padding:10px">
        </div>

        <div title="Seminar" style="padding:10px">
        </div>
		
        <div title="Job History - External" style="padding:10px">
        </div>

        <div title="Job History - Internal" style="padding:10px">
        </div>
		
		
        <div title="Publications" style="padding:10px">
        </div>

        <div title="Research" style="padding:10px">
        </div>

        <div title="Awards" style="padding:10px">
        </div>
		
        <div title="Organizations" style="padding:10px">
        </div>
		
        <div title="Hobbies" style="padding:10px">
        </div>
		
        <div title="Contacts" style="padding:10px">
        </div>
		

        <div title="Reference" style="padding:10px">
        </div>
		
        <div title="Memorandum" style="padding:10px">
        </div>

		
	</div>
	
	<script>
	function enableEdit(id) {
		alert(id);
		$('#'+id).textbox({
			editable:true,
		})	
	}	
	//enableEditRO
	function enableEditRO(id) {
		alert(id);
		$('#'+id).textbox({
			readonly:false,
		})	
	}	
	//validateRecord
	function validateRecord(value, fieldName) {
		
		var dateFields = undefined;
		
		if( (fieldName == 'dateHired') || (fieldName == 'birthDate') ) {
			dateFields = (value.match(/^\d{4}-\d{1,2}-\d{1,2}$/));

			if(dateFields == null) {
				alert('Please type valid date!!!');
				return false;
			}
			
		}



		var c = confirm("Are you sure you want to update this field?");
		if (c == true) {
			updateRecord(value, fieldName);
			$('#'+fieldName).textbox({
				editable:false,
			})	
			
			
		} else {
			return false;
		}
	}

	//updateRecord
	function updateRecord(value, fieldName) {
		alert(value + fieldName + $('#employeeNumber').val());
            jQuery.ajax({
                url: "updateRecordTHRIMS",
                data: {
                    'fieldName':fieldName,
                    'value': value,
                    'employeeNumber': $('#employeeNumber').val(), 
				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
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