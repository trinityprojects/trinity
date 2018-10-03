
<div class="formLevel">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/main/main.css" />


        <!-- The Modal -->
        <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
            <h4>SETTINGS - Default Term: <?php echo " (" . $_SESSION['sy'] . "-" . $_SESSION['sem'] . ")"; ?></h4>

            <span class="close">&times;</span>
            </div>
            <div class="modal-body">
				
				<table>
					<tr >
						<td style="padding: 10px"><span>School Year:</span></td>
						<td style="padding: 10px">
							<span>
							<select id="selectedSY">
								<?php foreach($sys as $row) {?>
									<option value='<?php echo $row->sys ?>'><?php echo $row->sys ?></option>
								<?php } ?>
							</select>
							</span> 
						</td>
					</tr>
					<tr>
						<td style="padding: 10px"><span>Semester:</span></td>
						<td style="padding: 10px">
							<span>
								<select id="selectedSem">
									<?php foreach($sems as $row) {?>
										<option value='<?php echo $row->sems ?>'><?php echo $row->sems ?></option>
									<?php } ?>
								</select>
							</span> 
						</td>
					</tr>
					
				
				</table>
				
            </div>
            <div class="modal-footer">
			<div ><span id="successMessage">UPDATE SUCCESSFULLY!!!</span></div>
            <div class="button" id="submitForm">Submit</div>
            </div>
        </div>

        </div>
		<script src="<?php echo base_url();?>assets/scripts/main/settings.js"></script>

</div>	
		
		