<div class="level2" style="width:100%;max-width:100%;height:200px;">
  <!--  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


	<link rel='stylesheet' type='text/css' media="screen" href='<?php echo base_url();?>assets/scripts/datepicker/datepicker.css' />
	<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/datepicker/datepicker.js"></script>

	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/building/tbamims.css" />

    <div> 

        <div id="dialogoverlay"></div>
        <div id="dialogbox">
        <div>
            <div id="dialogboxhead"></div>
            <div id="dialogboxbody"></div>
            <div id="dialogboxfoot"></div>
        </div>
        </div>

        <div id="dialogoverlay-small"></div>
            <div id="dialogbox-small">
            <div>
                <div id="dialogboxhead-small"></div>
                <div id="dialogboxbody-small"></div>
                <div id="dialogboxfoot-small"></div>
            </div>
        </div>

        <div id="dialogoverlay-long"></div>
            <div id="dialogbox-long">
            <div>
                <div id="dialogboxhead-long"></div>
                <div id="dialogboxbody-long"></div>
                <div id="dialogboxfoot-long"></div>
            </div>
        </div>
		
		
        <form>
        <div class="panel-group" >                    

            <div class="panel-title" > REQUEST DETAILS: </div>
            <div class="row-header">
                <div class="col-20" >
                    <label class="panel-label">Request Number: </label>
                    <div class="panel-detail">#<?php echo $ID?></div>
                    <input type="hidden"  id="requestID"  value="<?php echo $ID?>" />
                    <input type="hidden"  id="requestStatus"  value="<?php echo $requestStatus?>" />
					
                </div>
                <div class="col-20">
                    <label class="panel-label">Request Status: </label>
                    <div class="panel-detail"><?php echo $requestStatusDescription?></div>
                </div>
                <div class="col-60">
                    <label class="panel-label">Project Title: </label>
                    <div class="panel-detail"><?php echo $projectTitle?></div>
                </div>
            </div>
            <div class="row-details">
                <div class="col-25" >
                    <label class="panel-label">Location Code: </label>
                    <div class="panel-detail"><?php echo $locationCode . " (" . $locationDescription . ")";?></div>
                </div>
                <div class="col-25">
                    <label class="panel-label">Floor: </label>
                    <div class="panel-detail"><?php echo $floor?></div>
                </div>
                <div class="col-25">
                    <label class="panel-label">Room Number: </label>
                    <div class="panel-detail"><?php echo $roomNumber?></div>
                </div>
                <div class="col-25">
                    <label class="panel-label">Requestor: </label>
                    <div class="panel-detail"><?php echo $fullName . " (" . $userName . ")";?></div>
                </div>

            </div>
            <div class="row-details">
                <div class="col-100" >
                    <label class="panel-label">Scope of Works: </label>
						<br>
						<div class="panel-detail" >
						</div>
						<?php if(!empty($scopeOfWorks)) {?>
							<div class="panel-detail" id="message">
								<span id="message-author"><?php echo "(". $userName . ") "; ?></span>
								<span><?php echo $scopeOfWorks?></span>
							</div>
						<?php } ?>


							<?php if(!empty($scopeDetails)) {?>
								<?php foreach($scopeDetails as $row) { ?>
									<div class="panel-detail" id="message">
										<span id="message-author"><?php echo "(" . $row->updatedBy .") ";?></span>
										<span id="message-detail"><?php echo $row->scopeDetails;?></span>
									</div> 
								<?php } ?>
							<?php } ?>	

							
							<?php if( ($owner != 1) )  {?>
								<?php if($requestStatus != 'C') {?>
									<div id="add-scope" onclick="displayScopeBox()"><span id="basic-btn">Add Scope Details</span></div>
									<div class="panel-detail message-scope" id="message" >
										<span id="message-author" onclick="hideScopeBox()">(<?php echo $userNumber; ?>)</span>
										<textarea style="background-color: white;" id="scopeDetails" data-autoresize rows="1" class="autoExpand"></textarea>
									</div> 
								<?php } ?>
							<?php } ?>

								
                </div>
            </div>
            <div class="row-details">
                <div class="col-100" >
                    <label class="panel-label">Project Justification: </label>
                    <div class="panel-detail"> <?php echo $projectJustification?></div>
                </div>
            </div>

            <div class="row-details">
                <div class="col-25" >
                    <label class="panel-label">Date Created: </label>
                    <div class="panel-detail">
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
                    
                    </div>
                </div>
                <div class="col-25">
                    <label class="panel-label">Date Needed: </label>
                    <div class="panel-detail"><?php echo $dateNeeded?></div>
                </div>
                <div class="col-50">
                    <label class="panel-label">.</label>
                    <div class="panel-detail">.</div>

                </div>
            </div>


            <div class="row-details">
                <div class="col-50" >
                    <label class="panel-label">Special Instructions: </label>
					<br>
					<div class="panel-detail">
					</div>


					<?php if(!empty($specialInstructions)) {?>
						<?php foreach($specialInstructions as $row) {?>
							<div class="panel-detail" id="message">
								<span id="message-author"><?php echo "(" . $row->updatedBy .") ";?></span>
								<span id="message-detail"><?php echo $row->specialInstructions;?></span>
							</div> 
						<?php } ?>
					<?php } ?>
					
					
					
					<?php if($owner != 1) {?>
						<?php if($requestStatus != 'C') {?>
							<div id="add-instruction" onclick="displayInstructionBox();"><span id="basic-btn">Add Special Instruction</span></div>
							<div class="panel-detail message-instruction" id="message" > 
								<span id="message-author" onclick="hideInstructionBox();"><?php echo "(" .$userNumber . ") "; ?></span>
								<textarea  style="background-color: white;" id="specialInstructions" data-autoresize rows="1" class="autoExpand"></textarea>
							</div> 
						<?php } ?>
				   <?php } ?>
						
                </div>
                <div class="col-50">
                    <label class="panel-label">Status Remarks: </label>
						<br>
						<div class="panel-detail">
						</div>




						<?php if(!empty($requestStatusRemarksDescription)) {?>
							<?php foreach($requestStatusRemarksDescription as $row) {?>
								<div class="panel-detail" id="message">
									<span id="message-author"><?php echo "(" . $row->updatedBy .") ";?></span>
									<span id="message-detail"><?php echo $row->statusDescription;?></span>
								</div> 	
							<?php }?>
						<?php } ?>
						
						<?php if($owner != 1) {?>
							<?php if($requestStatus != 'C') {?>
								<div class="panel-detail" id="message">
									<div class="input_fields_wrap_remarks"></div>
								</div>
							<?php }?>
						<?php }?>
						<?php if( ($requestStatus == 'E') ) {?>

								<a href="javascript:void(0)" class="link-btn" onclick="SetFundsStatus.render('Request #<?php echo $ID?> Estimated','update_request','E')" style="width:80px">SET FUND STATUS</a>
						

						<?php } ?>
						

                </div>
            </div>

            <div class="row-details">
                <div class="col-100" >
                    <?php if( ($requestStatus == 'N') || ($requestStatus == 'R' && $returnedFrom == 'O') ) {?>
                        <label >Estimation: 						

						<?php if($owner != 1) {?>
							<span class="add_field_button" id="basic-btn"> Set Materials</span> 
						<?php } ?>
						</label>
							<div class="input_fields_wrap"></div>  



							<div class="panel-detail">   
								<?php if(!empty($materials)) {?>

									<div>
										<div style="float: left; width: 3%">
											<span><b><u>QTY</u></b></span>
										</div> 
										<div style="float: left; width: 7%">
											<span><b><u>UNITS</u></b></span> 
										</div>
										<div style="float: left; width: 40%">
											<span>
												<b><u>PARTICULARS</u></b>
											</span>
											
										</div> 

									</div></br>
								<?php } ?>

	 
								<?php 
									$totalMaterialsAmount = 0;
									$itemCtr = 0;
									if(!empty($materials)) {
										foreach($materials as $row) {
								?>
											<div>
												<div style="float: left; width: 3%">
													<span><b><?php echo $row->quantity; ?></b></span>
												</div> 
												<div style="float: left; width: 7%">
													<span><b><?php echo trim($row->units); ?></b> </span> 
												</div>
												<div style="float: left; width: 40%">
													<span>
														<?php echo trim($row->particulars); ?> 
													</span>
												</div>    
											
											</div></br>
								
								<?php 
										$itemCtr++;
										} 
									}
								?>
								</div>


							
                    <?php } elseif( ($requestStatus == 'O') || ($requestStatus == 'A') || ($requestStatus == 'E') || ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C') || ($requestStatus == 'R')) { ?>
                        <label >Estimation/Materials Needed:</label>

                        <div class="panel-detail" style="padding: 5px"> 
						
							<div class="tab">
							  <button class="tablinksEstimates active" onclick="openTab(event, 'Estimates')">Estimates</button>
							  <?php if( ($requestStatus == 'S') ||($requestStatus == 'W') || ($requestStatus == 'C')) {?>
							  <button class="tablinksEstimates" onclick="openTab(event, 'Actual')">Actual</button>
							  <?php } ?>
							  <?php if( ($requestStatus == 'W') || ($requestStatus == 'C')) {?>
							  <button class="tablinksEstimates" onclick="openTab(event, 'JobOrder')">Job Order</button>
							  <?php } ?>
							  <?php if($requestStatus == 'C') {?>
							  <button class="tablinksEstimates" onclick="openTab(event, 'EvaluationJO')">Evaluation</button>
							  <input type="hidden" id="jobOrderNumber" value="<?php echo $jobOrderNumber;?>" />
							  <?php } ?>

							</div>
							<div id="Estimates" class="tabcontentEstimates">
						
										<div class="panel-detail">   
										<?php if(!empty($materials)) {?>


											<div>
												<div style="float: left; width: 3%">
													<span><b><u>QTY</u></b></span>
												</div> 
												<div style="float: left; width: 7%">
													<span><b><u>UNITS</u></b></span> 
												</div>
												<div style="float: left; width: 40%">
													<span>
														<b><u>PARTICULARS</u></b>
													</span>
													
												</div> 

												
												<?php if( ($requestStatus == 'A') || ($requestStatus == 'E') || ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C')) {?>
													
													<div style="float: left; width: 50%">
														<span>
															<b><u>Estimated Unit Amount</u></b>
														</span>
														
														
														
														<span style="float: right;">
															<b><u>Estimated Amount</u></b>
														</span>
														
													</div>    
												<?php } ?>

											</div></br>
										<?php } ?>
	 
	 
								<?php 
									$totalMaterialsAmount = 0;
									$itemCtr = 0;
									if(!empty($materials)) {
										foreach($materials as $row) {
								?>
											<div>
												<div style="float: left; width: 3%">
													<span><b><?php echo $row->quantity; ?></b></span>
													<input type="hidden" name="quantity[]" value="<?php echo $row->quantity; ?> "/> 

												</div> 
												<div style="float: left; width: 7%">
													<span><b><?php echo trim($row->units); ?></b> </span> 
												</div>
												<div style="float: left; width: 40%">
													<span>
														<?php echo trim($row->particulars); ?> 
													</span>
												</div>    

											
												<?php if($requestStatus == 'A') {?>
													<div style="float: left; width: 50%">
														<span>
															<input type="number" autofocus class="amount" id="numeric" name="amount[]" size="5" maxlength="5" placeholder="Amount"/> 
															<input type="hidden" name="materialsRecordID[]" value="<?php echo $row->ID; ?>"/> 
															<span id="itemTotalAmount<?php echo $itemCtr;?>" style="color: red; font-size: 15px; font-weight: bold; float: right;">
															</span>                                          
													   </span>
													</div>    
													
												<?php } ?>

												
												
												
												<?php if( ($requestStatus == 'E') || ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C')) {?>


													<div style="float: left; width: 50%">

														<span >
															<?php 
																echo number_format($row->materialsAmount, 2); 
																//$totalMaterialsAmount += $row->materialsAmount;
															?> 
													   </span>
													   
													   
														<span style="color: red; font-size: 15px; font-weight: bold; float: right;">
															<?php 
																echo number_format((floatval($row->materialsAmount) * intval($row->quantity)), 2); 
																$totalMaterialsAmount += (floatval($row->materialsAmount) * intval($row->quantity));
															?> 
													   </span>
													   
													</div>    
												<?php } ?>

											</div></br>
								
								<?php 
										$itemCtr++;
										} 
									}
								?>
								
								<?php if(!empty($materials)) { ?>
								
									<?php if( ($requestStatus == 'A') || ($requestStatus == 'E') || ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C')) { ?>
										<div>
											<div style="float: left; width: 3%">
												<span><b>_</b></span>
											</div> 
											<div style="float: left; width: 7%">
												<span><b>_</b> </span> 
											</div>
											<div style="float: left; width: 40%">
												<span style="color: red; font-size: 15px; font-weight: bold">
												   TOTAL AMOUNT:
												</span>
											</div>   

											
											
											<div style="float: left; width: 50%">
												<span>
												>>>
												</span>
												<span id="totalAmount" style="color: red; font-size: 15px; font-weight: bold; float: right;">
												<?php if(($requestStatus == 'A') ) {?>
													0.00
												<?php } ?>

												
												<?php if(($requestStatus == 'E') || ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C')) {
													echo number_format($totalMaterialsAmount, 2);
												} ?>
													<input type="hidden" id="totalAmountSumm" value="<?php echo $totalMaterialsAmount; ?>" />
												</span>
											</div>    
										
										</div>
										
										
										<?php if(($requestStatus == 'E') || ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C')) {?>

											<div>
												<div style="float: left; width: 3%">
													<span><b>_</b></span>
												</div> 
												<div style="float: left; width: 7%">
													<span><b>_</b> </span> 
												</div>
												<div style="float: left; width: 40%">
													<span style="color: red; font-size: 15px; font-weight: bold">
													   ACTUAL BUDGET:
													</span>
												</div>    
												
												
												<div style="float: left; width: 50%">
													<span>
													>>>
													</span>
													<span id="totalAmount" style="color: red; font-size: 15px; font-weight: bold; float: right;">

													
													<?php if(($requestStatus == 'E')) {?>
														<input style="font-size: 12px; " type="number" class="actualBudgetAmount" id="actualBudgetAmount" name="actualBudgetAmount" size="5" maxlength="5" placeholder="Actual Budget"/> 
													<?php } //if(($requestStatus == 'E')) {?>
													
													<?php if( ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C')) {
															echo number_format($actualBudgetAmount, 2);
													} ?>
													
													
													</span>
												</div>    
										
											</div>


											<div>
												<div style="float: left; width: 3%">
													<span><b>_</b></span>
												</div> 
												<div style="float: left; width: 7%">
													<span><b>_</b> </span> 
												</div>
												<div style="float: left; width: 40%">
													<span style="color: red; font-size: 15px; font-weight: bold">
													   DIFFERENCE:
													</span>
												</div>    
												
												
												<div style="float: left; width: 50%">
													<span>
													>>>
													</span>
													<span id="differenceAmount" style="color: red; font-size: 15px; font-weight: bold; float: right;">
													<?php if(($requestStatus == 'E')) {?>
														0.00
													<?php } //if(($requestStatus == 'E'))?>
													<?php if( ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C')) {
															echo number_format(($totalMaterialsAmount - $actualBudgetAmount), 2);
													} ?>

													
													</span>
												</div>    
										
											</div>


											
										
										<?php } //if(($requestStatus == 'E') || ($requestStatus == 'S'))?>
										
										
									<?php } //if( ($requestStatus == 'A') || ($requestStatus == 'E') || ($requestStatus == 'S') ) {?>
									<?php } else { //if(!empty($materials))?>
											<div>
												<span> NO MATERIALS NEEDED </span>
											</div>
									
									<?php } //if(!empty($materials))?>
								</div>
							</div> <!--<div id="Estimates" class="tabcontentEstimates"> -->
							
							<div id="Actual" class="tabcontentEstimates" style="display: none">
							<?php if( ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C')) { ?>
							
										<div class="panel-detail">   
										<?php if(!empty($materials)) {?>


											<div>
												<div style="float: left; width: 3%">
													<span><b><u>QTY</u></b></span>
												</div> 
												<div style="float: left; width: 7%">
													<span><b><u>UNITS</u></b></span> 
												</div>
												<div style="float: left; width: 40%">
													<span>
														<b><u>PARTICULARS</u></b>
													</span>
													
												</div> 

													
												<div style="float: left; width: 50%">
													<span>
														<b><u>Actual Unit Amount</u></b>
													</span>
													
													<span style="float: right;">
														<b><u>Actual Amount</u></b>
													</span>
													
												</div>    

											</div></br>
										<?php } ?>
	 
	 
								<?php 
									$totalMaterialsAmountActual = 0;
									$itemCtr = 0;
									if(!empty($materials)) {
										foreach($materials as $row) {
								?>
											<div>
												<div style="float: left; width: 3%">
													<span><b><?php echo $row->quantity; ?></b></span>
													<input type="hidden" name="quantityActual[]" value="<?php echo $row->quantity; ?> "/> 

												</div> 
												<div style="float: left; width: 7%">
													<span><b><?php echo trim($row->units); ?></b> </span> 
												</div>
												<div style="float: left; width: 40%">
													<span>
														<?php echo trim($row->particulars); ?> 
													</span>
												</div>    

												<div style="float: left; width: 50%">
													<span>
														<?php if($requestStatus == 'S') { ?>
															<input type="number" class="amountActual" id="numericActual" name="amountActual[]" size="5" maxlength="5" placeholder="Amount Actual"/> 
															<input type="hidden" name="materialsRecordIDActual[]" value="<?php echo $row->ID; ?>"/> 
															<span id="itemTotalAmountActual<?php echo $itemCtr;?>" style="color: red; font-size: 15px; font-weight: bold; float: right;">
															</span>                        
														<?php } elseif( ($requestStatus == 'W') || ($requestStatus == 'C')) { 
																echo $row->actualAmount;
														
														 } ?>

													</span>
													
													<?php if ( ($requestStatus == 'W') || ($requestStatus == 'C')) { ?>
														<span style="color: red; font-size: 15px; font-weight: bold; float: right;">
																<?php 
																	echo number_format((floatval($row->actualAmount) * intval($row->quantity)), 2); 
																	$totalMaterialsAmountActual += (floatval($row->actualAmount) * intval($row->quantity));
																?> 
														 </span>
													<?php } ?>
													
													
												</div>    
													
											</div></br>
								
								<?php 
										$itemCtr++;
										} 
									}
								?>
								
								<?php if(!empty($materials)) { ?>
								
										<div>
											<div style="float: left; width: 3%">
												<span><b>_</b></span>
											</div> 
											<div style="float: left; width: 7%">
												<span><b>_</b> </span> 
											</div>
											<div style="float: left; width: 40%">
												<span style="color: red; font-size: 15px; font-weight: bold">
												   TOTAL AMOUNT:
												</span>
											</div>   

											
											
											<div style="float: left; width: 50%">
												<span>
												>>>
												</span>
												<span id="totalAmountActual" style="color: red; font-size: 15px; font-weight: bold; float: right;">
													<?php 
													if( ($requestStatus == 'W') || ($requestStatus == 'C')) {
														echo number_format($totalMaterialsAmountActual, 2);
													} else {		
														echo "0.00";
													} ?>
												</span>
											</div>    
										
										</div>
										
										

											<div>
												<div style="float: left; width: 3%">
													<span><b>_</b></span>
												</div> 
												<div style="float: left; width: 7%">
													<span><b>_</b> </span> 
												</div>
												<div style="float: left; width: 40%">
													<span style="color: red; font-size: 15px; font-weight: bold">
													   ACTUAL BUDGET:
													</span>
												</div>    
												
												
												<div style="float: left; width: 50%">
													<span>
													>>>
													</span>
													<span id="totalAmountActual" style="color: red; font-size: 15px; font-weight: bold; float: right;">
													<?php if($requestStatus == 'S') {?>
															<?php echo number_format($actualBudgetAmount, 2); ?>
															<input type="hidden" id="actualBudgetAmountActual" value="<?php echo $actualBudgetAmount;?>"/>
													<?php } elseif( ($requestStatus == 'W') || ($requestStatus == 'C')) { 
															echo number_format($actualBudgetAmount, 2);
													} ?>
													</span>
												</div>    
										
											</div>


											<div>
												<div style="float: left; width: 3%">
													<span><b>_</b></span>
												</div> 
												<div style="float: left; width: 7%">
													<span><b>_</b> </span> 
												</div>
												<div style="float: left; width: 40%">
													<span style="color: red; font-size: 15px; font-weight: bold">
													   DIFFERENCE:
													</span>
												</div>    
												
												
												<div style="float: left; width: 50%">
													<span>
													>>>
													</span>
													<span id="differenceAmountActual" style="color: red; font-size: 15px; font-weight: bold; float: right;">
														<?php 
														if(  ($requestStatus == 'W') || ($requestStatus == 'C')) {
															echo number_format(($totalMaterialsAmountActual - $actualBudgetAmount), 2);
														} else {
															echo "0.00";
														} ?>
													</span>
												</div>    
										
											</div>


											
										
									<?php } else { //if(!empty($materials))?>
											<div>
												<span> NO MATERIALS NEEDED </span>
											</div>
									
									<?php } //if(!empty($materials))?>
								</div>							
							
							
							<?php } ?>
							</div><!--<div id="Actual" class="tabcontentEstimates"> -->

							<div id="JobOrder" class="tabcontentEstimates" style="display: none">
								<?php if( ($requestStatus == 'W') || ($requestStatus == 'C')) {?>
								<div class="panel-detail">   
										<span class="input_fields_wrap_worker"></span>
										<span id="job_order_exist"> </span>
								
								</div>
								<?php } ?>
							</div>

							<div id="EvaluationJO" class="tabcontentEstimates" style="display: none">
								<?php if( ($requestStatus == 'C')) {?>
								<div class="panel-detail">   
										<span class="input_fields_wrap_jo_evaluation"></span>
										<span id="evaluation_exist"> </span>
										<input type="hidden" id="owner" value="<?php echo $owner;?>" />
								</div>
								<?php } ?>
							</div>
							
                        </div>
                    <?php } //} elseif( ($requestStatus == 'O') || ($requestStatus == 'A') || ($requestStatus == 'E') || ($requestStatus == 'S')) {?>
                </div>

            </div>

            <?php if( ($requestStatus == 'N') || ($requestStatus == 'R' && $returnedFrom == 'O') ) {?>
                <div class="row-details">
                    <div class="col-50" style="height:150%; padding: 10px 10px">
						<label class="panel-label">Attachments: <span id="basic-btn" onclick="showUploadedFiles();">SHOW Attachments</span> </label>
							<br>
							<?php //if($owner == 1) { ?>
									<div class="panel-detail" id="message">
											<p>You may attach NEW files for this request</p>
											<input multiple id="files" name="files" type="file"  > 
											<a id="ff" class="easyui-linkbutton"><span id="basic-btn">Upload</span></a>		
											<div id="uploading"></div>
									</div>

									<div class="panel-detail" >
									<div id="uploaded_files"></div>
										
									</div>
									

								
							<?php //} else { ?>
								<!--<div class="panel-detail" id="message">
								</div>
								<div class="panel-detail" id="message">

									<div class="tab">
									  <button class="tablinks" onclick="openAttachment(event, 'Images')">Images</button>
									  <button class="tablinks" onclick="openAttachment(event, 'PDFs')">PDFs</button>
									  <button class="tablinks" onclick="openAttachment(event, 'Others')">Others</button>
									</div>

									<div id="Images" class="tabcontent">
										<div class="panel-detail">   
										<?php echo ""?>            
										<?php foreach($attachments as $row) {?> 
											<img src="<?php echo base_url();?>assets/uploads/tbamims/<?php echo $row->attachments;?>" style="width:50px%; height:50px" onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
										<?php } ?>
										</div>							
									</div>

									<div id="PDFs" class="tabcontent">-->
										<!--<div class="panel-detail"><embed src="<?php echo base_url();?>assets/uploads/tbamims/sample.pdf" type="application/pdf"   height="50%" width="50%">	
										</div>-->			
										<!--<?php echo ""?>            
										<?php foreach($attachmentsApp as $row) {?> 
											<a href="javascript:void(0)" style="width:10%" onclick="openModalPDF('<?php echo $row->attachments;?>');currentSlide(1)" class="hover-shadow cursor"><?php echo $row->attachments;?></a><br>
										<?php } ?>
										
									</div>

									<div id="Others" class="tabcontent">
									  <p>Others.</p>
									</div>
								</div>-->

							<?php //} ?>

                    </div>
                    <div class="col-50" style="height:150%; padding: 10px 10px; text-align: center">
						<?php if($owner != 1) {?>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Open request #<?php echo $ID?> for Approval','update_request','O')" style="width:80px">Open for Approval</a>
								<a href="javascript:void(0)" class="link-btn" onclick="Return.render('Return request #<?php echo $ID?> for Closing','return_request','R', 'N')" style="width:80px">Return for Closing</a>
						<?php } ?>
						
						
					</div>
                </div>
            <?php } elseif( ($requestStatus == 'O')|| ($requestStatus == 'A') || ($requestStatus == 'E') || ($requestStatus == 'S') || ($requestStatus == 'W') || ($requestStatus == 'C') || ($requestStatus == 'R')) {?>
                <div class="row-details" >
                    <div class="col-50" style="height:150%;">
						<label class="panel-label">Attachments: <span id="basic-btn" onclick="showUploadedFiles();">SHOW Attachments</span> </label>
							<br>
							<?php //if($owner == 1) { ?>
									<div class="panel-detail" id="message">
											<p>You may attach NEW files for this request</p>
											<input multiple id="files" name="files" type="file"  > 
											<a id="ff" class="easyui-linkbutton"><span id="basic-btn">Upload</span></a>		
											<div id="uploading"></div>
									</div>

									<div class="panel-detail" >
									<div id="uploaded_files"></div>
										
									</div>
					
					
					
									<!--<div class="panel-detail" id="message">
											<p>You may attach NEW files for this request</p>
											<input multiple id="files" name="files" type="file"  > 
											<a id="ff" class="easyui-linkbutton">Upload</a>		
											<div id="uploading"></div>
									</div>

									<div class="panel-detail" >
									<div id="uploaded_files"></div>
										
									</div>-->
								<!--<div class="panel-detail" id="message">

									<div class="tab">
									  <button class="tablinks active" onclick="openAttachment(event, 'Images')">Images</button>
									  <button class="tablinks" onclick="openAttachment(event, 'PDFs')">PDFs</button>
									  <button class="tablinks" onclick="openAttachment(event, 'Others')">Others</button>
									</div>

									<div id="Images" class="tabcontent">
										<div class="panel-detail">   
										<?php //echo ""?>            
										<?php //foreach($attachments as $row) {?> 
											<img src="<?php //echo base_url();?>assets/uploads/tbamims/<?php //echo $row->attachments;?>" style="width:50px%; height:50px" onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
										<?php //} ?>
										</div>							
									</div>

									<div id="PDFs" class="tabcontent">-->
										<!--<div class="panel-detail"><embed src="<?php //echo base_url();?>assets/uploads/tbamims/sample.pdf" type="application/pdf"   height="50%" width="50%">	
										</div>-->			
									<!--	<?php //echo ""?>            
										<?php //foreach($attachmentsApp as $row) {?> 
											<a href="javascript:void(0)" style="width:10%" onclick="openModalPDF('<?php //echo $row->attachments;?>');currentSlide(1)" class="hover-shadow cursor"><?php echo $row->attachments;?></a><br>
										<?php //} ?>
										
									</div>

									<div id="Others" class="tabcontent">
									  <p>Others.</p>
									</div>
								</div>-->

                    </div>
                    <div class="col-50" style="height:150%; padding: 10px 10px; text-align: center">
						<?php if(($requestStatus == 'O')){?>
							<?php if($owner != 1) {?>
								<?php if(empty($materials)) {?>
									<a href="javascript:void(0)" class="link-btn" onclick="ConfirmOpenToSet.render('Request #<?php echo $ID?> Set','update_request','S')" style="width:80px">Approved and Set</a>
								<?php } else {?>
									<a href="javascript:void(0)" class="link-btn" onclick="ConfirmOpen.render('Request #<?php echo $ID?> Approved','update_request','A')" style="width:80px">Approved</a>
								<?php } ?>
								<a href="javascript:void(0)" class="link-btn" onclick="Return.render('Return request #<?php echo $ID?> for additional requirements','return_request','R', '<?php echo $requestStatus; ?>')" style="width:80px">Return to NEW</a>
							<?php } ?>
						<?php } elseif($requestStatus == 'A') { ?>
							<?php if($owner != 1) {?>
								<a href="javascript:void(0)" class="link-btn" onclick="ConfirmApprove.render('Request #<?php echo $ID?> Estimated','update_request','E')" style="width:80px">Estimated</a>
								<a href="javascript:void(0)" class="link-btn" onclick="ConfirmApprove.render('Request #<?php echo $ID?> Return','update_request','R')" style="width:80px">Return</a>
							<?php } ?>
						<?php } elseif($requestStatus == 'E') { ?>
							<?php if($owner != 1) {?>
								<a href="javascript:void(0)" class="link-btn" onclick="ConfirmEstimated.render('Request #<?php echo $ID?> Set','update_request','S')" style="width:80px">Set</a>
								<a href="javascript:void(0)" class="link-btn" onclick="ConfirmEstimated.render('Request #<?php echo $ID?> Return','update_request','R')" style="width:80px">Return</a>
							<?php } ?>
						<?php } elseif($requestStatus == 'S') { ?>
							<?php if($owner != 1) {?>
								<a href="javascript:void(0)" class="link-btn" onclick="ConfirmSet.render('Request #<?php echo $ID?> WIP','update_request','W')" style="width:80px">Start Project</a>
								<a href="javascript:void(0)" class="link-btn" onclick="ConfirmSet.render('Request #<?php echo $ID?> Return','update_request','R')" style="width:80px">Return</a>
							<?php } ?>
						<?php } elseif( ($requestStatus == 'R') && ($returnedFrom == 'N') ) { ?>
							<?php if($owner == 1) {?>
								<a href="javascript:void(0)" class="link-btn" onclick="ConfirmClose.render('Close request #<?php echo $ID?>','close_request','X')" style="width:80px">Close Request</a>
							<?php } ?>
						<?php }?>

						<br><br><br>
						<div class="panel-detail">
							STATUS HISTORY
						</div>
						
						<div class="panel-detail"> 
							<div class="images_container thumbnails">
							<?php
							if(!empty($statusHistory)) {	
								$time2 = null;
								$keys = array_keys($statusHistory);
								foreach(array_keys($keys) as $index) {
							?>
								<span style="padding: 10px; display:inline-block; text-decoration:none;" >
									<div>
										<span style='width:50px; height: 50px' class='hover-shadow cursor'><?php echo $statusHistory[$keys[$index]]->requestStatusDescription;?></span>
										<span style='width:50px; height: 50px' class='hover-shadow cursor'><?php echo $statusHistory[$keys[$index]]->updatedBy;?></span>
									</div>
									<div style="height:2px"></div>
									<div><?php echo $statusHistory[$keys[$index]]->timeStamp; ?> </div>
									<?php
										$time1 = new DateTime($statusHistory[$keys[$index]]->timeStamp); // string date
										if(array_key_exists($index + 1, array_keys($statusHistory))) {
											$time2 = new DateTime($statusHistory[$keys[$index+1]]->timeStamp); // string date
										} else {
											$time2 = new DateTime();
											//$time2->setTimestamp(1327560334); // timestamps,  it can be string date too.
										}
										

										$interval =  $time2->diff($time1);
									?>
									
								</span>
								<span><--- ( <?php echo $interval->format('%R%a %H:%I:%s days hrs:mins:secs'); ?>) ---></span>

							<?php
								} //foreach(array_keys($keys) as $index) 
							}
							?>
								<span style="padding: 10px; display:inline-block; text-decoration:none;" >
									<div>
										<span style='width:50px; height: 50px' class='hover-shadow cursor'><?php echo "Current Date"?></span>
										<span style='width:50px; height: 50px' class='hover-shadow cursor'><?php echo "System";?></span>
									</div>
									<div style="height:2px"></div>
									<div><?php echo(date("Y-m-d H:i:s")); ?> </div>
								</span>
							
							
							</div>		
						</div>
						
						
					</div>
                </div>

            <?php } ?>


        </div>

        </form>
        
    </div>
	
<div id="myModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">
	<?php 
		$ctr = 1;
		$totalCount = count((array)$attachments);
		foreach($attachments as $row) {
	?> 
		<div class="mySlides">
		  <div class="numbertext"><?php echo $ctr; ?> / <?php echo $totalCount; ?></div>
		  <img src="<?php echo base_url();?>assets/uploads/tbamims/<?php echo $row->attachments;?>" style="width:100%; height: 100%">
		</div>
	<?php 
		$ctr++;
		} 
	?>
	
    
    <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
    <a class="next" onclick="plusSlides(1)">&#10095;</a>

    <div class="caption-container">
      <p id="caption"></p>
    </div>

	<?php foreach($attachments as $row) {?> 

		<div class="column" style="color: black; display: none">
		  <img class="demo cursor" onclick="currentSlide(1)" alt="<?php echo $row->attachments;?>">
		</div>
	<?php } ?>
	
	</div>
</div>	


<div id="myModalPDF" class="modal">
  <span class="close cursor" onclick="closeModalPDF()">&times;</span>
  <div class="modal-content" id="pdf-content">
			<!--<embed src="<?php echo base_url();?>assets/uploads/tbamims/sample.pdf" type="application/pdf"   height="100%" width="100%">	-->
	</div>
</div>	


<div id="myModalImage" class="modal">
	<span class="close cursor" onclick="closeModalImage()">&times;</span>
	<div class="modal-content" id="image-content">
	</div>
</div>	
	
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/JavaScript-autoComplete-master/auto-complete.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/JavaScript-autoComplete-master/auto-complete.js"></script>

    <script type="text/javascript">
$('input.amount').keyup(function() {
	var totalAmount = 0; 
	var sumAmount = 0;
	var itemTotalAmount = 0; 
	
	var stringAmount = new Array();
	var stringQuantity = new Array();
	
	
	var amountString = $('input[name="amount[]"]').map(function(){ 
			return this.value; 
	}).get();

	var quantityString = $('input[name="quantity[]"]').map(function(){ 
			return this.value; 
	}).get();

	
	//alert(quantityString);
	stringAmount = amountString.toString().split(',');	
	stringQuantity = quantityString.toString().split(',');	
	//alert(stringQuantity);
	var itemCtr = 0;
	for (a in stringAmount ) {
		if(!(isNaN(parseInt(stringAmount[a])))) {
			//alert(parseInt(stringQuantity[a], 10));
			itemTotalAmount = (parseInt(stringQuantity[a], 10) * parseFloat(stringAmount[a])).toFixed(2);
			
			
			$('#itemTotalAmount'+itemCtr).text(addCommas(itemTotalAmount));
			//alert(itemCtr);
			//alert($('#itemTotalAmount'+itemCtr).text(itemTotalAmount));
			totalAmount = totalAmount + parseInt(stringQuantity[a], 10) * parseFloat(stringAmount[a]); // Explicitly include base as per Álvaro's comment
			itemCtr++;
		}
	}	

	sumAmount = totalAmount.toFixed(2); //10000.00
	$('#totalAmount').text( addCommas(sumAmount) );
});


$('input.amountActual').keyup(function() {
	var totalAmountActual = 0; 
	var sumAmountActual = 0;
	var itemTotalAmountActual = 0; 
	
	var stringAmountActual = new Array();
	var stringQuantityActual = new Array();
	
	
	var amountStringActual = $('input[name="amountActual[]"]').map(function(){ 
			return this.value; 
	}).get();

	var quantityStringActual = $('input[name="quantity[]"]').map(function(){ 
			return this.value; 
	}).get();

	
	//alert(quantityString);
	stringAmountActual = amountStringActual.toString().split(',');	
	stringQuantityActual = quantityStringActual.toString().split(',');	
	//alert(stringQuantity);
	var itemCtr = 0;
	for (a in stringAmountActual ) {
		if(!(isNaN(parseInt(stringAmountActual[a])))) {
			//alert(parseInt(stringQuantity[a], 10));
			itemTotalAmountActual = (parseInt(stringQuantityActual[a], 10) * parseFloat(stringAmountActual[a])).toFixed(2);
			
			
			$('#itemTotalAmountActual'+itemCtr).text(addCommas(itemTotalAmountActual));
			//alert(itemCtr);
			//alert($('#itemTotalAmount'+itemCtr).text(itemTotalAmount));
			totalAmountActual = totalAmountActual + parseInt(stringQuantityActual[a], 10) * parseFloat(stringAmountActual[a]); // Explicitly include base as per Álvaro's comment
			itemCtr++;
		}
	}	
	
	var diffAmount = totalAmountActual - $('#actualBudgetAmountActual').val();
	var differenceAmount = diffAmount.toFixed(2);
	
	sumAmountActual = totalAmountActual.toFixed(2); //10000.00
	$('#totalAmountActual').text( addCommas(sumAmountActual) );
	
	$('#differenceAmountActual').text( addCommas(differenceAmount) );
	
});



$('input#actualBudgetAmount').keyup(function() { 
	var diffAmount = 0;
	var differenceAmount = 0;
	diffAmount = parseFloat($('#totalAmountSumm').val()) - parseFloat($('#actualBudgetAmount').val());
	differenceAmount = diffAmount.toFixed(2);
	$('#differenceAmount').text(addCommas(differenceAmount));
});

function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}	

$('#ff').click(function(){
    var files = $('#files')[0].files;
    var error = '';
    var form_data = new FormData();
    for(var count = 0; count<files.length; count++) {
        var name = files[count].name;
        var extension = name.split('.').pop().toLowerCase();
        if(jQuery.inArray(extension, ['gif','png','jpg','jpeg','pdf', 'jpeg']) == -1) {
            error += "Invalid " + count + "  File"
        } else  {
            //alert(extension);
            form_data.append("files[]", files[count]);
        }
        console.log(files[count]);

    }
    form_data.append('ID', $("#requestID").val());
    if(error == '') {
        $.ajax({
            url:'uploadFileTBAMIMS',
            method:"POST",
            data:form_data,
            contentType:false,
            cache:false,
            processData:false,
        
            beforeSend:function() {
                $('#uploading').html("<label class='text-success'>Uploading...</label>");
            },
            success:function(data) {
				displayUploadedFiles($("#requestID").val());
            }
        })
    } else {
        alert(error);
    }
	
	
	function displayUploadedFiles(requestID) {
					$(".level1A").remove();

		jQuery.ajax({
			url: "TBAMIMS/showUploadedFiles",
			data: { 
				'ID': requestID, 
			},
			type: "GET",
			success:function(data){
					$('#uploaded_files').html(data);
					document.getElementById('Images').style.display = "block";
					$('#uploading').html('');
					$('#files').val('');
					
			},
			error:function (){}
		}); //jQuery.ajax({	
		
	}
	
	
 });	
	
	
	

    jQuery.each(jQuery('textarea[data-autoresize]'), function() {
        var offset = this.offsetHeight - this.clientHeight;
    
        var resizeTextarea = function(el) {
            jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };
        jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
    });


    function CustomConfirm(){
        this.render = function(dialog,op,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var requestID = $('#requestID').val();           
            var specialInstructions = $('#specialInstructions').val();
            var scopeDetails = $('#scopeDetails').val();
            var requestStatusRemarksID = $('#requestStatusRemarksID').val();
			
            var qty = $('input[name="quantity[]"]').map(function(){ 
                    return this.value; 
            }).get();           

            var materialsID = $('input[name="materialsID[]"]').map(function(){ 
                    return this.value; 
            }).get();           

            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Scope Details: </b></div>";
            dialog = dialog + "<div><u>" + scopeDetails + "</u></div>";
            dialog = dialog + "<div><b>Status Remarks: </b></div>";
            dialog = dialog + "<div><u>" + requestStatusRemarksID + "</u></div>";

            dialog = dialog + "<div><b>Quantity: </b></div>";
            dialog = dialog + "<div><u>" + qty + "</u></div>";
            dialog = dialog + "<div><b>Materials ID: </b></div>";
            dialog = dialog + "<div><u>" + materialsID + "</u></div>";
            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = '<button onclick="Confirm.yes(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+scopeDetails+'\',\''+requestStatusRemarksID+'\',\''+qty+'\',\''+materialsID+'\')">Proceed</button> <button onclick="Confirm.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(op,status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID, qty, materialsID ){
            if(op == "update_request"){
                updateRequest(requestID, status, specialInstructions, scopeDetails, requestStatusRemarksID, qty, materialsID);
            }
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var Confirm = new CustomConfirm();
        

    
    function CustomConfirmOpen(){
        this.render = function(dialog,op,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var requestID = $('#requestID').val();           
            var specialInstructions = $('#specialInstructions').val();
            var scopeDetails = $('#scopeDetails').val();
            var requestStatusRemarksID = $('#requestStatusRemarksID').val();

            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Scope Details: </b></div>";
            dialog = dialog + "<div><u>" + scopeDetails + "</u></div>";
            dialog = dialog + "<div><b>Status Remarks: </b></div>";
            dialog = dialog + "<div><u>" + requestStatusRemarksID + "</u></div>";
            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = '<button onclick="ConfirmOpen.yes(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+scopeDetails+'\',\''+requestStatusRemarksID+'\')">Proceed</button> <button onclick="ConfirmOpen.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(op,status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID ){
            if(op == "update_request"){
                updateRequestOpen(requestID, status, specialInstructions, scopeDetails, requestStatusRemarksID);
            }
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var ConfirmOpen = new CustomConfirmOpen();


    function CustomConfirmApprove(){
        this.render = function(dialog,op,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var requestID = $('#requestID').val();           
            var specialInstructions = $('#specialInstructions').val();
            var scopeDetails = $('#scopeDetails').val();
            var requestStatusRemarksID = $('#requestStatusRemarksID').val();
            var amount = $('input[name="amount[]"]').map(function(){ 
                    return this.value; 
            }).get();           
            var materialsRecordID = $('input[name="materialsRecordID[]"]').map(function(){ 
                    return this.value; 
            }).get();           

            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Scope Details: </b></div>";
            dialog = dialog + "<div><u>" + scopeDetails + "</u></div>";
            dialog = dialog + "<div><b>Status Remarks: </b></div>";
            dialog = dialog + "<div><u>" + requestStatusRemarksID + "</u></div>";
            dialog = dialog + "<div><b>Amount: </b></div>";
            dialog = dialog + "<div><u>" + amount + "</u></div>";
            dialog = dialog + "<div><b>Materials ID: </b></div>";
            dialog = dialog + "<div><u>" + materialsRecordID + "</u></div>";
            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = '<button onclick="ConfirmApprove.yes(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+scopeDetails+'\',\''+requestStatusRemarksID+'\',\''+amount+'\',\''+materialsRecordID+'\')">Proceed</button> <button onclick="ConfirmApprove.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(op,status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID, amount, materialsRecordID ){
            if(op == "update_request"){
                updateRequestApprove(requestID, status, specialInstructions, scopeDetails, requestStatusRemarksID, amount, materialsRecordID);
            }
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var ConfirmApprove = new CustomConfirmApprove();


	
	
    function CustomConfirmEstimated(){
        this.render = function(dialog,op,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var requestID = $('#requestID').val();           
            var specialInstructions = $('#specialInstructions').val();
            var scopeDetails = $('#scopeDetails').val();
            var requestStatusRemarksID = $('#requestStatusRemarksID').val();
			var actualBudgetAmount = $('#actualBudgetAmount').val()
         
			dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Scope Details: </b></div>";
            dialog = dialog + "<div><u>" + scopeDetails + "</u></div>";
            dialog = dialog + "<div><b>Status Remarks: </b></div>";
            dialog = dialog + "<div><u>" + requestStatusRemarksID + "</u></div>";
            dialog = dialog + "<div><b>Actual Budget Amount: </b></div>";
            dialog = dialog + "<div><u>" + actualBudgetAmount + "</u></div>";
            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = '<button onclick="ConfirmEstimated.yes(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+scopeDetails+'\',\''+requestStatusRemarksID+'\',\''+actualBudgetAmount+'\')">Proceed</button> <button onclick="ConfirmEstimated.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(op,status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID, actualBudgetAmount){
            if(op == "update_request"){
                updateRequestEstimated(requestID, status, specialInstructions, scopeDetails, requestStatusRemarksID, actualBudgetAmount);
            }
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var ConfirmEstimated = new CustomConfirmEstimated();
	
    function CustomConfirmSet(){
        this.render = function(dialog,op,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var requestID = $('#requestID').val();           
            var specialInstructions = $('#specialInstructions').val();
            var scopeDetails = $('#scopeDetails').val();
            var requestStatusRemarksID = $('#requestStatusRemarksID').val();

            var amount = $('input[name="amountActual[]"]').map(function(){ 
                    return this.value; 
            }).get();           
            var materialsRecordID = $('input[name="materialsRecordIDActual[]"]').map(function(){ 
                    return this.value; 
            }).get();           
			
			dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Scope Details: </b></div>";
            dialog = dialog + "<div><u>" + scopeDetails + "</u></div>";
            dialog = dialog + "<div><b>Status Remarks: </b></div>";
            dialog = dialog + "<div><u>" + requestStatusRemarksID + "</u></div>";
            dialog = dialog + "<div><b>Amount: </b></div>";
            dialog = dialog + "<div><u>" + amount + "</u></div>";
            dialog = dialog + "<div><b>Materials ID: </b></div>";
            dialog = dialog + "<div><u>" + materialsRecordID + "</u></div>";
            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = '<button onclick="ConfirmSet.yes(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+scopeDetails+'\',\''+requestStatusRemarksID+'\',\''+amount+'\',\''+materialsRecordID+'\')">Proceed</button> <button onclick="ConfirmSet.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(op,status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID, amount, materialsRecordID){
            if(op == "update_request"){
                updateRequestSet(requestID, status, specialInstructions, scopeDetails, requestStatusRemarksID, amount, materialsRecordID);
            }
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var ConfirmSet = new CustomConfirmSet();
	




   function CustomConfirmJobOrder(){
        this.render = function(dialog,op,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var requestID = $('#requestID').val();           
            var workerID = $('#workerID').val();
            var workerName = $('#workerName').val();
			var start_up_date = $('#start_up_date').val();
            var completion_date = $('#completion_date').val();

			var jobCode = [];
			var jobDesc = [];
			
			var searchIDs = $('input.job_desc:checked').map(function(){
				jobCode.push($(this).val());		
				jobDesc.push($(this)[0].nextSibling.nodeValue);
			});			

			var proceed = 1;
			if (workerID == '' || start_up_date == '' || completion_date == '' || jobCode == '' || jobDesc == '') {
				proceed = 0;
			}

			
			dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Worker ID: </b></div>";
            dialog = dialog + "<div><u>" + workerID + "</u></div>";
            dialog = dialog + "<div><b>Planned Start Date: </b></div>";
            dialog = dialog + "<div><u>" + start_up_date + "</u></div>";
            dialog = dialog + "<div><b>Target Completion Date: </b></div>";
            dialog = dialog + "<div><u>" + completion_date + "</u></div>";
            dialog = dialog + "<div><b>Job Order Code: </b></div>";
            dialog = dialog + "<div><u>" + jobCode + "</u></div>";
            dialog = dialog + "<div><b>Job Order Descriptions: </b></div>";
            dialog = dialog + "<div><u>" + jobDesc + "</u></div>";

            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            if(proceed == 0) {
				document.getElementById('dialogboxfoot').innerHTML = '<button>Cannot Proceed! Please Complete Your Input</button> <button onclick="ConfirmJobOrder.no()">Close</button>';
			} else {
				document.getElementById('dialogboxfoot').innerHTML = '<button onclick="ConfirmJobOrder.yes(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+workerID+'\',\''+workerName+'\',\''+start_up_date+'\',\''+completion_date+'\',\''+jobCode+'\',\''+jobDesc+'\')">Proceed</button> <button onclick="ConfirmJobOrder.no()">Close</button>';
			}
		}
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(op,status, requestID, workerID, workerName, start_up_date, completion_date, jobCode, jobDesc){
            if(op == "crete_job_order"){
                createJobOrder(requestID, status, workerID, workerName, start_up_date, completion_date, jobCode, jobDesc);
            }
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var ConfirmJobOrder = new CustomConfirmJobOrder();


    function CustomConfirmOpenToSet(){
        this.render = function(dialog,op,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var requestID = $('#requestID').val();           
            var specialInstructions = $('#specialInstructions').val();
            var scopeDetails = $('#scopeDetails').val();
            var requestStatusRemarksID = $('#requestStatusRemarksID').val();

            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Scope Details: </b></div>";
            dialog = dialog + "<div><u>" + scopeDetails + "</u></div>";
            dialog = dialog + "<div><b>Status Remarks: </b></div>";
            dialog = dialog + "<div><u>" + requestStatusRemarksID + "</u></div>";
            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = '<button onclick="ConfirmOpenToSet.yes(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+scopeDetails+'\',\''+requestStatusRemarksID+'\')">Proceed</button> <button onclick="ConfirmOpenToSet.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(op,status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID ){
            //if(op == "update_request"){
                updateRequestOpenToSet(requestID, status, specialInstructions, scopeDetails, requestStatusRemarksID);
            //}
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var ConfirmOpenToSet = new CustomConfirmOpenToSet();

	
    function updateRequest(requestID, requestStatus, specialInstructions, scopeDetails, requestStatusRemarksID, qty, materialsID) {
            console.log(qty);
            console.log(materialsID);

            jQuery.ajax({
                url: "updateRequestTBAMIMS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'scopeDetails': scopeDetails, 
                    'requestStatusRemarksID': requestStatusRemarksID, 
                    'qty': qty,
                    'materialsID': materialsID,
                },
                type: "POST",
                success:function(data){
                    var resultValue = $.parseJSON(data);
                    console.log(data);
                    console.log("hoy");
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#O').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#W').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#C').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }


    function updateRequestOpen(requestID, requestStatus, specialInstructions, scopeDetails, requestStatusRemarksID) {

            jQuery.ajax({
                url: "updateRequestTBAMIMS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'scopeDetails': scopeDetails,  
                    'requestStatusRemarksID': requestStatusRemarksID,  

				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#O').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#W').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#C').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }


    function updateRequestApprove(requestID, requestStatus, specialInstructions, scopeDetails, requestStatusRemarksID, amount, materialsRecordID) {
            jQuery.ajax({
                url: "updateRequestTBAMIMS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'scopeDetails': scopeDetails,  
                    'requestStatusRemarksID': requestStatusRemarksID,  
                    'amount': amount,  
                    'materialsRecordID': materialsRecordID,  

				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#O').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#W').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#C').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }
	

    function updateRequestEstimated(requestID, requestStatus, specialInstructions, scopeDetails, requestStatusRemarksID, actualBudgetAmount) {

            jQuery.ajax({
                url: "updateRequestTBAMIMS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'scopeDetails': scopeDetails,  
                    'requestStatusRemarksID': requestStatusRemarksID,  
                    'actualBudgetAmount': actualBudgetAmount,  
					
				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#O').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#W').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#C').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }
	
    function updateRequestSet(requestID, requestStatus, specialInstructions, scopeDetails, requestStatusRemarksID, amount, materialsRecordID) {
            jQuery.ajax({
                url: "updateRequestTBAMIMS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'scopeDetails': scopeDetails,  
                    'requestStatusRemarksID': requestStatusRemarksID,  
                    'actualAmount': amount,  
                    'materialsRecordID': materialsRecordID,  

				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#O').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#W').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#C').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }

	
    function updateRequestOpenToSet(requestID, requestStatus, specialInstructions, scopeDetails, requestStatusRemarksID) {

            jQuery.ajax({
                url: "updateRequestMultipleStatusTBAMIMS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'scopeDetails': scopeDetails,  
                    'requestStatusRemarksID': requestStatusRemarksID,  

				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#O').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#W').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#C').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }
	
	

    function CustomConfirmClose(){
        this.render = function(dialog,op,status){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var requestID = $('#requestID').val();           

            dialog = dialog + "<div>";
            dialog = dialog + "</div>";


            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = '<button onclick="ConfirmClose.yes(\''+op+'\',\''+status+'\',\''+requestID+'\')">Proceed</button> <button onclick="ConfirmClose.no()">Close</button>';
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(op,status, requestID){
            if(op == "close_request"){
                closeRequest(requestID, status);
            }
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var ConfirmClose = new CustomConfirmClose();

    function closeRequest(requestID, requestStatus) {
            jQuery.ajax({
                url: "closeRequestTBAMIMS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,

				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#tt').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }


    function CustomReturn(){
        this.render = function(dialog,op,status, returnedFrom){
            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay');
            var dialogbox = document.getElementById('dialogbox');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1000 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var requestID = $('#requestID').val();           
            var specialInstructions = $('#specialInstructions').val();
            var scopeDetails = $('#scopeDetails').val();
            var requestStatusRemarksID = $('#requestStatusRemarksID').val();
			
            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Return From: </b></div>";
            dialog = dialog + "<div><u>" + returnedFrom + "</u></div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Scope Details: </b></div>";
            dialog = dialog + "<div><u>" + scopeDetails + "</u></div>";
            dialog = dialog + "<div><b>Status Remarks: </b></div>";
            dialog = dialog + "<div><u>" + requestStatusRemarksID + "</u></div>";
            dialog = dialog + "</div>";

			var button = '';
			
			if(specialInstructions == '') {
				button = 'Please put your instruction... </button> <button onclick="Return.no()">Close</button>';				
			} else {
				button = '<button onclick="Return.yes(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+scopeDetails+'\',\''+requestStatusRemarksID+'\',\''+returnedFrom+'\')">Proceed</button> <button onclick="Return.no()">Close</button>';				
			}

            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = button;
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yes = function(op,status, requestID, specialInstructions, scopeDetails, requestStatusRemarksID, returnedFrom){
            if(op == "return_request"){
                returnRequest(requestID, status, specialInstructions, scopeDetails, requestStatusRemarksID, returnedFrom);
            }
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
    }
    var Return = new CustomReturn();

    function returnRequest(requestID, status, specialInstructions, scopeDetails, requestStatusRemarksID, returnedFrom) {
            jQuery.ajax({
                url: "returnRequestTBAMIMS",
                data: {
                    'ID':requestID,
                    'requestStatus': status,
                    'specialInstructions':specialInstructions,
                    'scopeDetails': scopeDetails,
                    'requestStatusRemarksID':requestStatusRemarksID,
                    'returnedFrom': returnedFrom,

				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#O').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#W').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#C').datagrid('reload');
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }

	
	function createJobOrder(requestNumber, requestStatus, workerID, workerName, startDatePlanned, completionDateTarget, jobDescriptionCode, jobDescription) {
            jQuery.ajax({
                url: "insertJobOrderTBAMIMS",
                data: {
                    'requestNumber':requestNumber,
                    'requestStatus': requestStatus,
                    'workerID': workerID,  
                    'workerName': workerName,  
                    'startDatePlanned': startDatePlanned,  
                    'completionDateTarget': completionDateTarget,  
                    'jobDescriptionCode': jobDescriptionCode,  
                    'jobDescription': jobDescription,  
				},
                type: "POST",
                success:function(data){
                   console.log(data);
                    var resultValue = $.parseJSON(data);
                    console.log(resultValue);
                    //console.log(resultValue['quantt']);
                    if(resultValue['success'] == 1) {
                        $('div.job-order-form').remove();
                        //$('#N').datagrid('reload');
                        //$('#O').datagrid('reload');
                        //$('#A').datagrid('reload');
                        //$('#E').datagrid('reload');
                        //$('#S').datagrid('reload');
                        //$('#W').datagrid('reload');
                        //$('#R').datagrid('reload');
                        //$('#X').datagrid('reload');
                        //$('#C').datagrid('reload');
	var wrapperWorker = $(".input_fields_wrap_worker"); //Fields wrapper
	var userNumber = '<?php echo $userNumber; ?>';
    var requestID = $('#requestID').val();           
	jQuery.ajax({
		url: "TBAMIMS/showWorkerList",
		data: { 
			'userNumber': userNumber,
			'requestID': requestID,
            'requestStatus': requestStatus,
			'owner': <?php echo $owner; ?>, 
			'completedFlag': '<?php echo $completedFlag; ?>' 
			
		},
		type: "GET",
		success:function(data){
				$(wrapperWorker).append(data); //add input box
		},
		error:function (){}
	}); //jQuery.ajax({		
						
                        return true;
                    } else {
						$('#job_order_exist').text('Record Exist');
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
		
	}
	
    $(document).ready(function() {
		
		$('.message-instruction').hide();
		$('.message-scope').hide();
		
        var max_fields = 10; //maximum input boxes allowed
        var wrapper = $(".input_fields_wrap"); //Fields wrapper
        var add_button = $(".add_field_button"); //Add button ID

        var x = 1; //initlal text box count
        var i = 0;
        $(add_button).click(function(e) { //on add input button click
            e.preventDefault();
            console.log($('input#numeric'+(x-1)).val());
            console.log($('input#ID'+(x-1)).val());
            console.log(x);
            var qty = $('input#numeric'+(x-1)).val();
            var identification = $('input#ID'+(x-1)).val();
            
            var qtylength = 0;
            var idlength = 0;
            if((qty != undefined) && (identification != undefined)) {
                qtylength = qty.length;
                idlength = identification.length;
            }
            
            if( ( (qty == undefined) && (identification == undefined) && (x == 1) )   || ( (qtylength > 0) && (idlength > 0)  ) ) {
                //console.log('bakit');
                jQuery.ajax({
                    url: "TBAMIMS/showMaterialsList",
                    data: 'ctr='+x,
                    type: "GET",
                    success:function(data){
                        
                            $(wrapper).append(data); //add input box
                        
                    },
                    error:function (){}
                }); //jQuery.ajax({
                x++; //text box increment
                i = x;
            } else {
                return false;
            }


        });

        $(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
            e.preventDefault();
            var curr = $(this).html().slice(-1);

            if(curr == (x - 1)) {
                $(this).parent('div').remove();
                x--;
                $('div.autocomplete-suggestion.lista'+x).remove();
                $('script#dynamic'+x).remove();
            } else {
                alert("Only last record can be removed!!!");
            }
        });

		document.getElementById('Images').style.display = "block";
		document.getElementById('Estimates').style.display = "block";

		//evt.currentTarget.className += " active";		




		
    }); 


	function displayInstructionBox() {
		$('.message-instruction').show();
		$('#add-instruction').hide();
	}

	function displayScopeBox() {
		$('.message-scope').show();
		$('#add-scope').hide();
	}

	function hideInstructionBox() {
		$('.message-instruction').hide();
		$('#add-instruction').show();
	}

	function hideScopeBox() {
		$('.message-scope').hide();
		$('#add-scope').show();
	}	
	
    
	var wrapperRemarks = $(".input_fields_wrap_remarks"); //Fields wrapper
	var requestStatusCode = $("#requestStatus").val();
	var unitCode = null;
	alert(requestStatusCode);
	if(requestStatusCode == 'A') {
		unitCode = 'PSU';
	} else if(requestStatusCode == 'E') {
		unitCode = 'FU';
	} else {
		unitCode = 'BAM';
	}
	var userNumber = '<?php echo $userNumber; ?>';
	jQuery.ajax({
		url: "TBAMIMS/showRequestStatusList",
		data: { 
			'unitCode': unitCode, 
			'userNumber': userNumber
		},
		type: "GET",
		success:function(data){
				$(wrapperRemarks).append(data); //add input box
		},
		error:function (){}
	}); //jQuery.ajax({	
	


	
	var wrapperWorker = $(".input_fields_wrap_worker"); //Fields wrapper
	var userNumber = '<?php echo $userNumber; ?>';
    var requestID = $('#requestID').val();           
	jQuery.ajax({
		url: "TBAMIMS/showWorkerList",
		data: { 
			'userNumber': userNumber,
			'requestID': requestID,
			'requestStatus': requestStatusCode,
			'owner': <?php echo $owner; ?>,
			'completedFlag': '<?php echo $completedFlag; ?>' 
		},
		type: "GET",
		success:function(data){
				$(wrapperWorker).append(data); //add input box
		},
		error:function (){}
	}); //jQuery.ajax({		


	var wrapperJOEvaluation = $(".input_fields_wrap_jo_evaluation"); //Fields wrapper
	var userNumber = '<?php echo $userNumber; ?>';
    var requestID = $('#requestID').val();           
    var jobOrderNumber = $('#jobOrderNumber').val();   
    var owner = $('#owner').val();           
	
	jQuery.ajax({
		url: "TBAMIMS/showJobOrderEvaluation",
		data: { 
			'userNumber': userNumber,
			'requestID': requestID,
			'requestStatus': requestStatusCode,
			'jobOrderNumber': jobOrderNumber,
			'owner': owner

		},
		type: "GET",
		success:function(data){
				$(wrapperJOEvaluation).append(data); //add input box
		},
		error:function (){}
	}); //jQuery.ajax({		

	
	
function openModal() {
  document.getElementById('myModal').style.display = "block";
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
	
	
function openModalPDF(attachment) {
  document.getElementById('myModalPDF').style.display = "block";
  $('#pdf-content').html("<embed src='<?php echo base_url();?>assets/uploads/tbamims/" + attachment + "'" + "type='application/pdf'   height='100%' width='100%'>");
}	

function closeModalPDF() {
  document.getElementById('myModalPDF').style.display = "none";
}


		function openModalImage(attachment) {
		  document.getElementById('myModalImage').style.display = "block";
		  $('#image-content').html("<img src='<?php echo base_url();?>assets/uploads/tbamims/" + attachment + "' style='width:100%; height: 100%'>");
		}	

		function closeModalImage() {
		  document.getElementById('myModalImage').style.display = "none";
		}


function openAttachment(evt, tabName) {
    evt.preventDefault();

	var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}	


function openTab(evt, tabName) {
    evt.preventDefault();

	var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontentEstimates");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinksEstimates");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}	

function showUploadedFiles() {
			jQuery.ajax({
			url: "TBAMIMS/showUploadedFiles",
			data: { 
				'ID': $('#requestID').val(), 
			},
			type: "GET",
			success:function(data){
					$('#uploaded_files').html(data);
					document.getElementById('Images').style.display = "block";
					$('#uploading').html('');
					$('#files').val('');
			},
			error:function (){}
		}); //jQuery.ajax({
}
	
    var elms = document.getElementsByClassName("hover-shadow.cursor");
    for (var i = 0; i < elms.length; i++) {
       elms[i].onclick = function(event) {
          event.preventDefault();
          event.stopPropagation();
          var id = this.parentNode.href.substr(this.parentNode.href.lastIndexOf('/') + 2);
          var v = document.getElementById(id).getBoundingClientRect().left;
          document.getElementsByClassName("images_container")[0].scrollLeft += v;
       }
    }	
	
	
/*		$('#duration_days').click(function() { 
		
		
			var startDate = $('#start_up_date').val();
			var endDate = $('#completion_date').val();
			
			var tempStart = startDate.split("-");
			var tempEnd = endDate.split("-");
			
			var startYear = tempStart[0];
			var startMonth = tempStart[1];
			var startDay = tempStart[2];

			var endYear = tempEnd[0];
			var endMonth = tempEnd[1];
			var endDay = tempEnd[2];

			
			var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
			var firstDate = new Date(startYear,startMonth,startDay);
			var secondDate = new Date(endYear,endMonth,endDay);

			var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
			$('#duration_days_job_order').val(diffDays);
		});
	*/
	
	
    </script>

</div>



