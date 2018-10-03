<div class="level2" style="width:100%;max-width:100%;height:200px;">
  <!--  <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">-->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />


	<link rel='stylesheet' type='text/css' media="screen" href='<?php echo base_url();?>assets/scripts/datepicker/datepicker.css' />
	<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/datepicker/datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
    <!--<script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery-easyui-texteditor/jquery.texteditor.js"></script>-->

	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />
    <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />
    <!--<link rel="stylesheet" href="<?php echo base_url();?>assets/thirdparty/easyui/jquery-easyui-texteditor/texteditor.css" />-->

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
                    <label class="panel-label">Request Purpose: </label>
                    <div class="panel-detail"><?php echo $requestPurpose?></div>
                </div>
            </div>
            <div class="row-details">
                <div class="col-50" >
                    <label class="panel-label">UNIT/OFFICE: </label>
                    <div class="panel-detail"><?php echo $currentDepartment?></div>
                </div>
                <div class="col-50">
                    <label class="panel-label">Requestor: </label>
                    <div class="panel-detail"><?php echo $fullName . " (" . $userName . ")";?></div>
                </div>

            </div>
            <div class="row-details">
                <div class="col-100" >
                    <label class="panel-label">NOTES: </label>
						<br>
						<div class="panel-detail" >
						</div>
							<?php if(!empty($requestNotes)) {?>
								<?php foreach($requestNotes as $row) { ?>
									<div class="panel-detail" id="message">
										<span id="message-author"><?php echo "(" . $row->updatedBy .") ";?></span>
										<span id="message-detail"><?php echo $row->requestNotes;?></span>
									</div> 
								<?php } ?>
							<?php } ?>	

							<div id="add-request-notes" onclick="displayRequestNotesBox()"><span>Add Request Notes</span></div>
							<div class="panel-detail message-request-notes" id="message" >
								<span id="message-author" onclick="hideRequestNotesBox()">(<?php echo $userNumber; ?>)</span>
								<textarea style="background-color: white;" id="requestNotes" data-autoresize rows="1" class="autoExpand"></textarea>
							</div> 

                </div>
            </div>
            <div class="row-details">
                <div class="col-100" >
                    <label class="panel-label">Request Remarks: </label>
                    <div class="panel-detail"> <?php echo $requestRemarks?></div>
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
				<?php if( (!empty($departmentUnit)) && (!empty($unitReviewer)) && ($returnedFrom == 'U')  ) {?>
                <div class="col-50" style="background-color: darkgreen; color: gold; font-size: 15px">
					<label class="panel-label">REVIEWED</label>
                    <div class="panel-detail">BY <?php echo $unitReviewer; ?></div>
                </div>
				<?php } else { ?>
                <div class="col-50">
					<label class="panel-label">.</label>
                    <div class="panel-detail">.</div>
                </div>
				<?php } ?>
            </div>


            <div class="row-details">
                <div class="col-50" >
                    <label class="panel-label">
						<?php if(($requestStatus == 'U')) {?>
							Recommendations:
						<?php } else { ?>
							Special Instructions:
						<?php } ?>
						
					</label>
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
					
					
					
					<div id="add-instruction" onclick="displayInstructionBox();">
					<span>
						<?php if(($requestStatus == 'U')) {?>
							Add Recommendations
						<?php } else { ?>
							Add Special Instruction
						<?php } ?>
					
					</span>
					</div>
					<div class="panel-detail message-instruction" id="message" > 
						<span id="message-author" onclick="hideInstructionBox();"><?php echo "(" .$userNumber . ") "; ?></span>
						<textarea  style="background-color: white;" id="specialInstructions" data-autoresize rows="1" class="autoExpand"></textarea>
					</div> 
						
                </div>
                <div class="col-50">
                    <label class="panel-label">Request Category: </label>
						
						<div class="panel-detail">
							<br>
						</div>

						<?php if( ($requestStatus == 'I') ) { ?>

							<div class="panel-detail">
								<?php 
								if(!empty($requestCategory)) {
									foreach($requestCategory as $row) {
								?>
									<div class="panel-detail" id="message">
										<span id="message-author"><?php echo "(" . $row->updatedBy .") ";?></span>
										<span id="message-detail"><?php echo $row->requestCategoryText;?></span>
									</div>
								<?php
									}
								}
								?>
							</div>
						<?php }?>

						<div class="panel-detail">
						<?php if( ($requestStatus == 'A') || ($requestStatus == 'S') || ($requestStatus == 'E')  || ($requestStatus == 'I') ) { ?>
							<?php if(($requestStatus == 'S')  ) { ?>
								<?php if(!empty($supplierName)) {?>
									<?php foreach($supplierName as $row) {
											if($row->supplierBidStatus == 'CUR') {
									?>
										<div class="panel-detail" id="message">
											<span id="message-author"><?php echo "(" . $row->updatedBy .") ";?></span>
											<?php if($row->supplierBidStatus == 'CUR') { ?>
												<span id="message-detail"><b>CURRENT SUPPLIER:</b> </span>
											<?php } else { ?>
												<span id="message-detail"><b>CANDIDATE SUPPLIER:</b> </span>
											
											<?php } ?>
											<span id="message-detail"><?php echo $row->supplierName;?></span>
										</div>
									<?php 
											}
										} 
									?>
								<?php } ?>
							<?php } ?>
							
							<?php if(($requestStatus == 'E')  || ($requestStatus == 'I') ) { ?>
								<?php if(!empty($supplierName)) {?>
									<?php foreach($supplierName as $row) {
									?>
										<div class="panel-detail" id="message">
											<span id="message-author"><?php echo "(" . $row->updatedBy .") ";?></span>
											<?php if($row->supplierBidStatus == 'CUR') { ?>
												<span id="message-detail"><b>CURRENT SUPPLIER:</b> </span>
											<?php } else { ?>
												<span id="message-detail"><b>CANDIDATE SUPPLIER:</b> </span>
											
											<?php } ?>
											<span id="message-detail"><?php echo $row->supplierName;?></span>
										</div>
									<?php 
										} 
									?>
								<?php } ?>
							<?php } ?>
							
							<br>
							
							<?php if( ($requestStatus == 'A') || ($requestStatus == 'S') || ($requestStatus == 'I')  ) { ?>
							
								<input type='radio' class="request-category" name="requestCategory" checked value='G'/>Regular
								<input type='radio' class="request-category" name="requestCategory" value='R'/>Renewal
								<input type='radio' class="request-category" name="requestCategory" value='B'/>Bidding
								
								<form id="supplierForm">
								<div id="supplier-code">
								<input class="easyui-combobox" name="supplierName"  id="supplierName" prompt="CURRENT SUPPLIER:" style="width:60%" data-options="
										url:'getSuppliers',
										method:'get',
										valueField:'ID',
										textField:'supplierName',
										panelHeight:200,
										required:true
										">
										
								<?php if(  ($requestStatus == 'S') || ($requestStatus == 'I')  ) { ?>
									<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitSupplier();" style="width:80px">Submit</a>						
									<div id="suppliersList" class="col-100" style="border: 0; padding: 10px"></div>
								<?php } ?>
								

								<div class="panel-detail" > 
									<textarea  placeholder='Bid Specifications' style="background-color: white;" id="bid-requirements" data-autoresize rows="1" class="autoExpand"></textarea>
								</div> 	

								</div>
								</form>
							<?php } ?>
						<?php } ?>
			
						
						


                </div>
            </div>

			
			
            <div class="row-details">
                <div class="col-100" >
				<?php if( ($requestStatus == 'N') ) {?>
					<div class="easyui-panel" title="Add New Items" style="width:100%;max-width:100%;padding:5px 5px;"> 
					<form id="itemForm" class="easyui-form" method="post" data-options="novalidate:true">
						<input type="text" class="easyui-numberbox" id="quantity" data-options="prompt:'Quantity:',required:true, min:0,precision:0"   style="width:5%"> 
						
						<input class="easyui-combobox" name="unitCode" id="unitCode" prompt="UNIT:" style="width:10%" data-options="
								url:'getSupplyUnits',
								method:'get',
								valueField:'ID',
								textField:'unitCode',
								panelHeight:200,
								required:true
								">

						<input class="easyui-combobox" name="assetName" id="assetName" prompt="ITEM NAME:" style="width:50%" data-options="
								url:'getAssetGroup',
								method:'get',
								valueField:'assetCode',
								textField:'assetName',
								panelHeight:200,
								required:true
								">
						<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm();" style="width:80px">Submit</a>						
					</div>

					<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
					</div>
				<?php } elseif(($requestStatus == 'A') || ($requestStatus == 'U')) { ?>
                    <label >Items Needed:</label>
					<div id="itemsList" class="col-100" style="border: 0; padding: 10px">
					</div>
				<?php } elseif( ($requestStatus == 'S') || ($requestStatus == 'E') || ($requestStatus == 'I')) { ?>
                        <label >Estimation/Items Needed:</label>

                        <div class="panel-detail" style="padding: 5px"> 
						
							<div class="tab">
							  <button class="tablinksEstimates active" onclick="openTab(event, 'Estimates')">Estimates</button>
							  <?php if( ($requestStatus == 'I')) {?>
								<?php if($requestCategoryType == 'Bidding') {?>
									<button class="tablinksEstimates" onclick="openTab(event, 'Bidding')">Bidding Information</button>
								<?php } ?>
							  <button class="tablinksEstimates" onclick="openTab(event, 'Actual')">Actual</button>
							  <button class="tablinksEstimates" onclick="openTab(event, 'Asset')">Asset Assignment</button>
							  <?php } ?>
							</div>



							<div id="Estimates" class="tabcontentEstimates">
						
										<div class="panel-detail">   
										<?php if(!empty($itemsList)) {?>


											<div>
												<div style="float: left; width: 3%">
													<span><b><u>QTY</u></b></span>
												</div> 
												<div style="float: left; width: 7%">
													<span><b><u>UNITS</u></b></span> 
												</div>
												<div style="float: left; width: 40%">
													<span>
														<b><u>ITEMS</u></b>
													</span>
													
												</div> 
												
												<div style="float: left; width: 50%">
													<span>
														<b><u>Estimated Unit Amount</u></b>
													</span>
													
													
													
													<span style="float: right;">
														<b><u>Estimated Amount</u></b>
													</span>
													
												</div>    

											</div></br>
										<?php } ?>
	 
	 
								<?php 
									$totalItemsAmount = 0;
									$itemCtr = 0;
									if(!empty($itemsList)) {
										foreach($itemsList as $row) {
								?>
											<div>
												<div style="float: left; width: 3%">
													<span><b><?php echo $row->quantity; ?></b></span>
													<input type="hidden" name="quantity[]" value="<?php echo $row->quantity; ?> "/> 

												</div> 
												<div style="float: left; width: 7%">
													<span><b><?php echo trim($row->unitID); ?></b> </span> 
												</div>
												<div style="float: left; width: 40%">
													<span>
														<?php echo trim($row->assetName); ?> 
													</span>
												</div>    

											
												<?php if($requestStatus == 'S') {?>
													<div style="float: left; width: 50%">
														<span>
															<input type="number" autofocus class="amount" id="numeric" name="amount[]" size="5" maxlength="5" placeholder="Amount"/> 
															<input type="hidden" name="itemsRecordID[]" value="<?php echo $row->ID; ?>"/> 
															<span id="itemTotalAmount<?php echo $itemCtr;?>" style="color: red; font-size: 15px; font-weight: bold; float: right;">
															</span>                                          
													   </span>
													</div>    
													
												<?php } ?>

												
												
												
												<?php if( ($requestStatus == 'E')  || ($requestStatus == 'I')) {?>


													<div style="float: left; width: 50%">

														<span >
															<?php 
																echo number_format($row->itemAmount, 2); 
																//$totalMaterialsAmount += $row->materialsAmount;
															?> 
													   </span>
													   
													   
														<span style="color: red; font-size: 15px; font-weight: bold; float: right;">
															<?php 
																echo number_format((floatval($row->itemAmount) * intval($row->quantity)), 2); 
																$totalItemsAmount += (floatval($row->itemAmount) * intval($row->quantity));
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
								
								<?php if(!empty($itemsList)) { ?>
								
									<?php if( ($requestStatus == 'S') || ($requestStatus == 'E')  || ($requestStatus == 'I')) { ?>
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
												<?php if(($requestStatus == 'S') ) {?>
													0.00
												<?php } ?>

												
												<?php if(($requestStatus == 'E') || ($requestStatus == 'I')) {
													echo number_format($totalItemsAmount, 2);
												} ?>
													<input type="hidden" id="totalAmountSumm" value="<?php echo $totalItemsAmount; ?>" />
												</span>
											</div>    
										
										</div>
										
										
										<?php if(($requestStatus == 'E') || ($requestStatus == 'I')) {?>

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

													
													<?php if(($requestStatus == 'E') ) {?>
														<input style="font-size: 12px; " type="number" class="actualBudgetAmount" id="actualBudgetAmount" name="actualBudgetAmount" size="5" maxlength="5" placeholder="Actual Budget"/> 
													<?php } //if(($requestStatus == 'E')) {?>
													
													<?php if( ($requestStatus == 'I')) {
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
													<?php if( ($requestStatus == 'I')) {
															echo number_format(($totalItemsAmount - $actualBudgetAmount), 2);
													} ?>

													
													</span>
												</div>    
										
											</div>


											
										
										<?php } //if(($requestStatus == 'E') || ($requestStatus == 'S'))?>
										
										
									<?php } //if( ($requestStatus == 'A') || ($requestStatus == 'E') || ($requestStatus == 'S') ) {?>
									<?php } else { //if(!empty($itemsList))?>
											<div>
												<span> NO ITEMS NEEDED </span>
											</div>
									
									<?php } //if(!empty($itemsList))?>
								</div>
							</div> <!--<div id="Estimates" class="tabcontentEstimates"> -->

							<?php if($requestCategoryType == 'Bidding') {?>
								<div id="Bidding" class="tabcontentEstimates">
									<label class="panel-label">Bidding Preparation: </label>
									<br>
									<div class="panel-detail">   
										<div id="biddingPreparation" class="col-100" style="border: 0; padding: 10px"></div>									
									</div>
									

									
								</div>
							<?php } ?>
							
							
							<div id="Actual" class="tabcontentEstimates">
							<?php if( ($requestStatus == 'I')) { ?>
							
										<div class="panel-detail">   
										<?php if(!empty($itemsList)) {?>


											<div>
												<div style="float: left; width: 3%">
													<span><b><u>QTY</u></b></span>
												</div> 
												<div style="float: left; width: 7%">
													<span><b><u>UNITS</u></b></span> 
												</div>
												<div style="float: left; width: 40%">
													<span>
														<b><u>ITEMS</u></b>
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
									$totalItemsAmountActual = 0;
									$itemCtr = 0;
									if(!empty($itemsList)) {
										foreach($itemsList as $row) {
								?>
											<div>
												<div style="float: left; width: 3%">
													<span><b><?php echo $row->quantity; ?></b></span>
													<input type="hidden" name="quantityActual[]" value="<?php echo $row->quantity; ?> "/> 

												</div> 
												<div style="float: left; width: 7%">
													<span><b><?php echo trim($row->unitCode); ?></b> </span> 
												</div>
												<div style="float: left; width: 40%">
													<span>
														<?php echo trim($row->assetName); ?> 
													</span>
												</div>    

												<div style="float: left; width: 50%">
													<span>
														<?php if($requestStatus == 'I') { ?>
															<input type="number" class="amountActual" id="numericActual" name="amountActual[]" size="5" maxlength="5" placeholder="Amount Actual"/> 
															<input type="hidden" name="itemsRecordIDActual[]" value="<?php echo $row->ID; ?>"/> 
															<span id="itemTotalAmountActual<?php echo $itemCtr;?>" style="color: red; font-size: 15px; font-weight: bold; float: right;">
															</span>                        
														<?php } elseif( ($requestStatus == 'I') && ($requestStatus == 'C')) { 
																echo $row->actualAmount;
														
														 } ?>

													</span>
													
													<?php if ( ($requestStatus == 'I') && ($requestStatus == 'C')) { ?>
														<span style="color: red; font-size: 15px; font-weight: bold; float: right;">
																<?php 
																	echo number_format((floatval($row->actualAmount) * intval($row->quantity)), 2); 
																	$totalItemsAmountActual += (floatval($row->actualAmount) * intval($row->quantity));
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
								
								<?php if(!empty($itemsList)) { ?>
								
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
													if( ($requestStatus == 'I') && ($requestStatus == 'C')) {
														echo number_format($totalItemsAmountActual, 2);
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
													<?php if( ($requestStatus == 'I') ) { 
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
														if(  ($requestStatus == 'I') && ($requestStatus == 'C')) {
															echo number_format(($totalItemsAmountActual - $actualBudgetAmount), 2);
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
							</div>
							<div id="Asset" class="tabcontentEstimates">
								<div class="panel-detail">   
								</div>
							</div>
				
				
				<?php } ?>
                </div>
            </div>

            <?php if( ($requestStatus == 'N') || ($requestStatus == 'A') || ($requestStatus == 'S') || ($requestStatus == 'U') || ($requestStatus == 'E') || ($requestStatus == 'I')) {?>
                <div class="row-details">
                    <div class="col-50" style="height:150%; padding: 10px 10px">
						<label class="panel-label">Attachments: <span onclick="showUploadedFiles();">SHOW Attachments</span> </label>
							<br>
							<?php //if($owner == 1) { ?>
									<div class="panel-detail" id="message">
											<p>You may attach NEW files for this request</p>
											<input multiple id="files" name="files" type="file"  > 
											<a id="ff" class="easyui-linkbutton">Upload</a>		
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
											<img src="<?php echo base_url();?>assets/uploads/asrs/<?php echo $row->attachments;?>" style="width:50px%; height:50px" onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
										<?php } ?>
										</div>							
									</div>

									<div id="PDFs" class="tabcontent">
										<!--<div class="panel-detail"><embed src="<?php echo base_url();?>assets/uploads/tbamims/sample.pdf" type="application/pdf"   height="50%" width="50%">	
										</div>-->			
									<!--	<?php echo ""?>            
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
						<?php if(($requestStatus == 'N')) {?>		
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('For request #<?php echo $ID?> for Unit Approval','for_approval_request','A')" style="width:80px">Submit for Unit Approval</a>
						<?php } ?>

						<?php if(($requestStatus == 'A') || ($requestStatus == 'S') || ($requestStatus == 'U') || ($requestStatus == 'E')) {?>		
							<?php if(($requestStatus == 'A')) {?>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> for Submission','submit_request','S')" style="width:80px">For Submission to PSU</a>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> Return','return_request','R')" style="width:80px">Return</a>
							<?php }?>
							<?php if($requestStatus == 'S') {?>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> for Budget Approval','for_budget_approval','E')" style="width:80px">For Budget Approval</a>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> for Item Review','for_item_review','U')" style="width:80px">For Item Review</a>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> Return','return_request','R')" style="width:80px">Return</a>
								<div class="panel-detail">
									<input class="easyui-combobox" name="departmentUnit"  id="departmentUnit" prompt="Department/Unit:" style="width:60%" data-options="
											url:'getOrgUnit',
											method:'get',
											valueField:'orgUnitCode',
											textField:'orgUnitName',
											panelHeight:200,
											required:true
											">

								</div>
							<?php }?>
							<?php if(($requestStatus == 'U')) {?>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> Reviewed','reviewed_request','S')" style="width:80px">Backto PSU</a>
							<?php }?>
							<?php if(($requestStatus == 'E')) {?>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> with Budget','with_budget','I')" style="width:80px">Approved with Budget</a>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> Return','return_request','R')" style="width:80px">Return (with instruction)</a>
							<?php }?>
							
							
								<br>
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

						<?php } ?>

						
					</div>
                </div>
            <?php } else {?>
                <div class="row-details" >
                    <div class="col-50" style="height:100%;">
								<label >Attachments:</label>
								
								<div class="panel-detail" id="message">
								</div>
							
								<div class="panel-detail" id="message">

									<div class="tab">
									  <button class="tablinks active" onclick="openAttachment(event, 'Images')">Images</button>
									  <button class="tablinks" onclick="openAttachment(event, 'PDFs')">PDFs</button>
									  <button class="tablinks" onclick="openAttachment(event, 'Others')">Others</button>
									</div>

									<div id="Images" class="tabcontent">
										<div class="panel-detail">   
										<?php echo ""?>            
										<?php foreach($attachments as $row) {?> 
											<img src="<?php echo base_url();?>assets/uploads/asrs/<?php echo $row->attachments;?>" style="width:50px%; height:50px" onclick="openModal();currentSlide(1)" class="hover-shadow cursor">
										<?php } ?>
										</div>							
									</div>

									<div id="PDFs" class="tabcontent">
										<!--<div class="panel-detail"><embed src="<?php echo base_url();?>assets/uploads/tbamims/sample.pdf" type="application/pdf"   height="50%" width="50%">	
										</div>-->			
										<?php echo ""?>            
										<?php foreach($attachmentsApp as $row) {?> 
											<a href="javascript:void(0)" style="width:10%" onclick="openModalPDF('<?php echo $row->attachments;?>');currentSlide(1)" class="hover-shadow cursor"><?php echo $row->attachments;?></a><br>
										<?php } ?>
										
									</div>

									<div id="Others" class="tabcontent">
									  <p>Others.</p>
									</div>
								</div>

                    </div>
                    <div class="col-50" style="height:100%; padding: 10px 10px; text-align: center">
						<?php if($requestStatus == 'A') { ?>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> for Submission','submit_request','S')" style="width:80px">For Submission to PSU</a>
								<a href="javascript:void(0)" class="link-btn" onclick="Confirm.render('Request #<?php echo $ID?> Return','return_request','R')" style="width:80px">Return</a>
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
		  <img src="<?php echo base_url();?>assets/uploads/asrs/<?php echo $row->attachments;?>" style="width:100%; height: 100%">
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
            url:'uploadFile',
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
		//alert(requestID);
		jQuery.ajax({
			url: "ASRS/showUploadedFiles",
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
			
			var requestCategory;
			var requestCategoryText;
			var currentSupplier;
			var currentSupplierText;
			var blankSupplier = 1;
			var amount;
			var itemsRecordID;
			var orgUnitCode;
			var actualBudgetAmount;
			
            var requestID = $('#requestID').val();           
            var specialInstructions = $('#specialInstructions').val();
            var requestNotes = $('#requestNotes').val();

			if( (status == 'S') || (status == 'E')) {
				if($("input:radio[name=requestCategory]:checked").length > 0) {
					requestCategory = $("input:radio[name=requestCategory]:checked").val();
					requestCategoryText = $("input:radio[name=requestCategory]:checked")[0].nextSibling.nodeValue;
					requestCategoryText = requestCategoryText.trim();
					
					if( (requestCategory == 'B') || (requestCategory == 'R') ) {
						currentSupplier = $('#supplierName').val();
						currentSupplierText = $('#supplierName').combobox('getText');
									
						if(currentSupplierText.length == 0) {
								blankSupplier = 0;
						}

					}					
				}
			}

			if(status == 'E'){
				amount = $('input[name="amount[]"]').map(function(){ 
						return this.value; 
				}).get();           
				itemsRecordID = $('input[name="itemsRecordID[]"]').map(function(){ 
						return this.value; 
				}).get();           
			}
			
			
            dialog = dialog + "<div>";
            dialog = dialog + "<div><b>Special Instructions: </b></div>";
            dialog = dialog + "<div><u>" + specialInstructions + "</u></div>";
            dialog = dialog + "<div><b>Request Notes: </b></div>";
            dialog = dialog + "<div><u>" + requestNotes + "</u></div>";

			if(requestCategory != undefined) {
				dialog = dialog + "<div><b>Request Category: </b></div>";
				dialog = dialog + "<div><u>" + requestCategoryText + "</u></div>";
				
			}


			if(status != 'A'){
				if((blankSupplier != 0) && (requestCategory != 'G')) {
					dialog = dialog + "<div><b>Supplier Name: </b></div>";
					dialog = dialog + "<div><u>" + currentSupplierText + "</u></div>";
                     					
				}
			}

			var amountCount = 0;	

			if(  (status == 'E') ) {
				
				var arrayLength = amount.length;
				for (var i = 0; i < arrayLength; i++) {
					if(amount[i].length > 0) {
						amountCount++;
					}
				}
				
				dialog = dialog + "<div><b>Item ID: </b></div>";
				dialog = dialog + "<div><u>" + itemsRecordID + "</u></div>";
				dialog = dialog + "<div><b>Item Amount: </b></div>";
				dialog = dialog + "<div><u>" + amount + "</u></div>";

			}			

			if(status == 'U') {
				orgUnitCode = $('#departmentUnit').val();
				dialog = dialog + "<div><b>Department/Unit: </b></div>";
				dialog = dialog + "<div><u>" + orgUnitCode + "</u></div>";
			}

			if(status == 'I') {
				actualBudgetAmount = $('#actualBudgetAmount').val();
				dialog = dialog + "<div><b>Actual Budget: </b></div>";
				dialog = dialog + "<div><u>" + actualBudgetAmount + "</u></div>";
			}
			
            dialog = dialog + "</div>";

			
alert(status);
			var button;
			
			if(status == 'S') {
				if(blankSupplier == 0) {
					button = 'Make sure Supplier is not blanked!!!! </button> <button onclick="Confirm.no()">Close</button>';
				} else {
					button = '<button onclick="Confirm.yesS(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+requestNotes+'\',\''+requestCategory+'\',\''+requestCategoryText+'\',\''+currentSupplier+'\',\''+currentSupplierText+'\')">Proceed</button> <button onclick="Confirm.no()">Close</button>';
				}
			} else if(status == 'E') {
				if(amountCount == itemsRecordID.length) {
					if(blankSupplier == 0) {
						button = 'Make sure Supplier is not blanked!!!! </button> <button onclick="Confirm.no()">Close</button>';
					} else {
						button = '<button onclick="Confirm.yesE(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+requestNotes+'\',\''+requestCategory+'\',\''+requestCategoryText+'\',\''+itemsRecordID+'\',\''+amount+'\')">Proceed</button> <button onclick="Confirm.no()">Close</button>';
					}
				} else {
					button = 'Make sure amount is all filled out!!!! </button> <button onclick="Confirm.no()">Close</button>';
				}
			} else if(status == 'U') {
				if(orgUnitCode.length == 0) {
					button = 'Make sure Department/Unit is not blanked!!!! </button> <button onclick="Confirm.no()">Close</button>';
				} else {
					button = '<button onclick="Confirm.yesU(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+requestNotes+'\',\''+orgUnitCode+'\')">Proceed</button> <button onclick="Confirm.no()">Close</button>';
				}
			} else if(status == 'I') {
				if(actualBudgetAmount.length == 0) { 
					button = 'Make sure Actual Amount is not blanked!!!! </button> <button onclick="Confirm.no()">Close</button>';
				} else {
					button = '<button onclick="Confirm.yesI(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+requestNotes+'\',\''+actualBudgetAmount+'\')">Proceed</button> <button onclick="Confirm.no()">Close</button>';
				}
				
			} else {
				button = '<button onclick="Confirm.yesA(\''+op+'\',\''+status+'\',\''+requestID+'\',\''+specialInstructions+'\',\''+requestNotes+'\')">Proceed</button> <button onclick="Confirm.no()">Close</button>';
			}
			
            document.getElementById('dialogboxhead').innerHTML = "Please Confirm...";
            document.getElementById('dialogboxbody').innerHTML = dialog;
            document.getElementById('dialogboxfoot').innerHTML = button;
        }
        this.no = function(){
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yesA = function(op,status, requestID, specialInstructions, requestNotes){
            if(op == "for_approval_request"){
                updateRequest(requestID, status, specialInstructions, requestNotes);
            } 
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
		
        this.yesS = function(op, status, requestID, specialInstructions, requestNotes, requestCategory, requestCategoryText, currentSupplier, currentSupplierText){
			if(op == 'submit_request') {
                updateRequestSubmit(requestID, status, specialInstructions, requestNotes, requestCategory, requestCategoryText, currentSupplier, currentSupplierText);
			} else if(op == 'reviewed_request') {
                updateRequestReviewed(requestID, status, specialInstructions, requestNotes, returnedFrom = 'U');
				
			}
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }

        this.yesE = function(op, status, requestID, specialInstructions, requestNotes, requestCategory, requestCategoryText, itemsRecordID, amount){
			if(op == 'for_budget_approval') {
                //alert('hello123');
				updateRequestEstimate(requestID, status, specialInstructions, requestNotes, requestCategory, requestCategoryText, itemsRecordID, amount);
			}
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
		
        this.yesU = function(op, status, requestID, specialInstructions, requestNotes, orgUnitCode){
			if(op == 'for_item_review') {
                //alert('hello123');
				updateRequestUnitReview(requestID, status, specialInstructions, requestNotes, orgUnitCode);
			}
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
        this.yesI = function(op, status, requestID, specialInstructions, requestNotes, actualBudgetAmount){
			if(op == 'with_budget') {
                //alert('hello123');
				updateRequestInProgress(requestID, status, specialInstructions, requestNotes, actualBudgetAmount);
			}
            document.getElementById('dialogbox').style.display = "none";
            document.getElementById('dialogoverlay').style.display = "none";
        }
		
    }
    var Confirm = new CustomConfirm();
        
    function updateRequest(requestID, requestStatus, specialInstructions, requestNotes) {
            //alert(requestID + requestStatus + specialInstructions + requestNotes);
			jQuery.ajax({
                url: "updateRequestASRS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'requestNotes': requestNotes, 
                },
                type: "POST",
                success:function(data){

                    var resultValue = $.parseJSON(data);
                    console.log(data);
                    //console.log("hoy");
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#I').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#U').datagrid('reload');
                        $('#C').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#tt').datagrid('reload');
						
                        return true;
                    } else {
						console.log(data);
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }

  
    function updateRequestSubmit(requestID, requestStatus, specialInstructions, requestNotes, requestCategory ,requestCategoryText, currentSupplier, currentSupplierText) {
            alert(requestID + requestStatus + specialInstructions + requestNotes);
			jQuery.ajax({
                url: "updateRequestASRS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'requestNotes': requestNotes, 
                    'requestCategory': requestCategory, 
                    'requestCategoryText': requestCategoryText, 
                    'currentSupplier': currentSupplier, 
                    'currentSupplierText': currentSupplierText, 
					
                },
                type: "POST",
                success:function(data){
				alert(requestID + requestStatus + specialInstructions + requestNotes);

                    var resultValue = $.parseJSON(data);
                    console.log(data);
                    //console.log("hoy");
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#I').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#U').datagrid('reload');
                        $('#C').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#tt').datagrid('reload');
						
                        return true;
                    } else {
						console.log(data);
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }


    function updateRequestEstimate(requestID, requestStatus, specialInstructions, requestNotes, requestCategory, requestCategoryText, itemsRecordID, amount) {
            alert(requestID + requestStatus + specialInstructions + requestNotes);
			jQuery.ajax({
                url: "updateRequestASRS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'requestNotes': requestNotes, 
                    'requestCategory': requestCategory, 
                    'requestCategoryText': requestCategoryText, 
                    'itemAmount': amount, 
                    'itemID': itemsRecordID, 
					
                },
                type: "POST",
                success:function(data){
				alert(requestID + requestStatus + specialInstructions + requestNotes);

                    var resultValue = $.parseJSON(data);
                    console.log(data);
                    //console.log("hoy");
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#I').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#U').datagrid('reload');
                        $('#C').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#tt').datagrid('reload');
						
                        return true;
                    } else {
						console.log(data);
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }


    function updateRequestUnitReview(requestID, requestStatus, specialInstructions, requestNotes, orgUnitCode) {
            alert(requestID + requestStatus + specialInstructions + requestNotes + orgUnitCode);
			jQuery.ajax({
                url: "updateRequestASRS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'requestNotes': requestNotes, 
                    'orgUnitCode': orgUnitCode, 
					
                },
                type: "POST",
                success:function(data){

                    var resultValue = $.parseJSON(data);
                    console.log(data);
                    //console.log("hoy");
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#I').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#U').datagrid('reload');
                        $('#C').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#tt').datagrid('reload');
						
                        return true;
                    } else {
						console.log(data);
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }


    function updateRequestReviewed(requestID, requestStatus, specialInstructions, requestNotes, returnedFrom) {
            //alert(requestID + requestStatus + specialInstructions + requestNotes);
			jQuery.ajax({
                url: "updateRequestASRS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'requestNotes': requestNotes, 
                    'returnedFrom': returnedFrom, 
					
                },
                type: "POST",
                success:function(data){
alert(data);
                    var resultValue = $.parseJSON(data);
                    console.log(data);
                    //console.log("hoy");
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#I').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#U').datagrid('reload');
                        $('#C').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#tt').datagrid('reload');
						
                        return true;
                    } else {
						console.log(data);
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }


    function updateRequestInProgress(requestID, requestStatus, specialInstructions, requestNotes, actualBudgetAmount) {
            //alert(requestID + requestStatus + specialInstructions + requestNotes);
			jQuery.ajax({
                url: "updateRequestASRS",
                data: {
                    'ID':requestID,
                    'requestStatus': requestStatus,
                    'specialInstructions': specialInstructions,  
                    'requestNotes': requestNotes, 
                    'actualBudgetAmount': actualBudgetAmount, 
                },
                type: "POST",
                success:function(data){

                    var resultValue = $.parseJSON(data);
                    console.log(data);
                    //console.log("hoy");
                    if(resultValue['success'] == 1) {
                        $('div.level2').remove();
                        $('#N').datagrid('reload');
                        $('#A').datagrid('reload');
                        $('#S').datagrid('reload');
                        $('#E').datagrid('reload');
                        $('#I').datagrid('reload');
                        $('#R').datagrid('reload');
                        $('#U').datagrid('reload');
                        $('#C').datagrid('reload');
                        $('#X').datagrid('reload');
                        $('#tt').datagrid('reload');
						
                        return true;
                    } else {
						console.log(data);
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }

	
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

	
	
    $(document).ready(function() {
		<?php if(($requestStatus == 'A') || ($requestStatus == 'U')) {?>
					jQuery.ajax({
						url: "ASRS/showRequestItemsASRS",
						data: {
							'ID':$('#requestID').val(),
							'accessType': 'readOnly'
						},
						type: "POST",
						success:function(data){
							//$('.level1').remove();
							$('#itemsList').html(data);
						},
						error:function (){}
					}); //jQuery.ajax({
		<?php } elseif($requestStatus == 'N') { ?>
					jQuery.ajax({
						url: "ASRS/showRequestItemsASRS",
						data: {
							'ID':$('#requestID').val(),
							'accessType': 'readWrite'
						},
						type: "POST",
						success:function(data){
							//$('.level1').remove();
							$('#itemsList').html(data);
						},
						error:function (){}
					}); //jQuery.ajax({
		<?php } ?>
					
		$('.message-instruction').hide();
		$('.message-request-notes').hide();
		$('#supplier-code').hide();
		
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
		document.getElementById('Estimates').style.display = "block";
		document.getElementById('Images').style.display = "block";

		//evt.currentTarget.className += " active";		
		
    }); 


	function displayInstructionBox() {
		$('.message-instruction').show();
		$('#add-instruction').hide();
	}

	function displayRequestNotesBox() {
		$('.message-request-notes').show();
		$('#add-request-notes').hide();
	}

	function hideInstructionBox() {
		$('.message-instruction').hide();
		$('#add-instruction').show();
	}

	function hideRequestNotesBox() {
		$('.message-request-notes').hide();
		$('#add-request-notes').show();
	}	
	
    
	var wrapperRemarks = $(".input_fields_wrap_remarks"); //Fields wrapper
	var requestStatusCode = $("#requestStatus").val();
	var unitCode = null;
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
			'requestStatus': requestStatusCode

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
  $('#pdf-content').html("<embed src='<?php echo base_url();?>assets/uploads/asrs/" + attachment + "'" + "type='application/pdf'   height='100%' width='100%'>");
}	

function closeModalPDF() {
  document.getElementById('myModalPDF').style.display = "none";
}


		function openModalImage(attachment) {
		  document.getElementById('myModalImage').style.display = "block";
		  $('#image-content').html("<img src='<?php echo base_url();?>assets/uploads/asrs/" + attachment + "' style='width:100%; height: 100%'>");
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
	if(tabName == 'Bidding') {
		showBiddingPreparation();
		showPBACMember();
	}
}	

function showUploadedFiles() {
			jQuery.ajax({
			url: "ASRS/showUploadedFiles",
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


 function submitForm(){

    $('#itemForm').form('submit',{
        onSubmit:function(){
            var validForm =  $(this).form('enableValidation').form('validate');
				//alert('hello');
           
		   if(!validForm) {
                return validForm;
            } else {
				var quantity = $('#quantity').val();
				var unitCode = $('#unitCode').val();
				var assetName = $('#assetName').val();
				checkDataItemsViaAJAX(quantity, unitCode, assetName)
            }

        }
    });
}




function checkDataItemsViaAJAX(quantity, unitCode, assetName) {
	
    jQuery.ajax({
        url: "validateRequestItemsASRS",
        data:'quantity='+quantity+'&unitCode='+unitCode+'&assetName='+assetName,
        type: "POST",
        success:function(data){
            console.log(data);
            var resultValue = $.parseJSON(data);
            if(resultValue['success'] == 1) {
                clearErrorMessages();

				addItem();


            } else {
                var obj = $.parseJSON(data);
                var quantity = obj['quantity'];
                var unitCode = obj['unitCode'];
                var assetName = obj['assetName'];

                $notExistMessage = '';
                /*if(quantityNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + quantityNotExist + "<br>";
                }
                if(unitCodeNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + unitCodeNotExist + "<br>";
                } 
                if(assetNameNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + assetNameNotExist + "<br>";
                } */
                $('div#error-messages').html($notExistMessage);
                return false;
            }
        },
        error:function (){}
    }); //jQuery.ajax({
} //function checkDataViaAJAX



 
 
 	function addItem() {

		var ID = $('#requestID').val();
		var quantity = $('#quantity').val();
		var unitCode = $('#unitCode').val();
		var assetName = $('#assetName').val();
		var unitCodeText = $('#unitCode').combobox('getText');
		var assetNameText = $('#assetName').combobox('getText');
		jQuery.ajax({
			url: "insertRequestItemsASRS",
			data: { 
				'ID': ID, 
				'quantity': quantity, 
				'unitCode': unitCode, 
				'assetName': assetName, 
				'unitCodeText': unitCodeText, 
				'assetNameText': assetNameText, 
			},
			type: "POST",
			success:function(data){

                var resultValue = $.parseJSON(data);
                if(resultValue['success'] == 1) {
					var ID = resultValue['ID'];
					showItemList();
				
				}
				
			},
			error:function (){}
		}); //jQuery.ajax({	


		
	}	



function clearErrorMessages() {
    $('div#error-messages').html('');
}


function showItemList() {
		var ID = $('#requestID').val();
					jQuery.ajax({
						url: "ASRS/showRequestItemsASRS",
						data: {
							'ID':ID,
							'accessType': 'readWrite'
						},
						type: "POST",
						success:function(data){
							//$('.level1').remove();
							$('#itemsList').html(data);
						},
						error:function (){}
					}); //jQuery.ajax({

}	


							$('.request-category').change(function() { 
								var selected = $(".request-category:checked");
									if( (selected.val() == 'B') || (selected.val() == 'R') ) {
										$('#supplier-code').show();
										showSupplierList();
									} else {
										$('#supplier-code').hide();

									}									

							});
							
							
							
							
function submitSupplier(){
    $('#supplierForm').form('submit',{
        onSubmit:function(){
            var validForm =  $(this).form('enableValidation').form('validate');
				//alert('hello');
           
		   if(!validForm) {
                return validForm;
            } else {
				var supplierName = $('#supplierName').val();
				var	supplierNameText = $('#supplierName').combobox('getText');
				checkSupplierNameViaAJAX(supplierName, supplierNameText);
            }

        }
    })
}
		
							
function checkSupplierNameViaAJAX(supplierName, supplierNameText) {
	
    jQuery.ajax({
        url: "validateSupplierNameASRS",
        data:'supplierName='+supplierName+'&supplierNameText='+supplierNameText,
        type: "POST",
        success:function(data){
            console.log(data);
            var resultValue = $.parseJSON(data);
            if(resultValue['success'] == 1) {
                clearErrorMessages();
				addSupplier();
            } else {
                var obj = $.parseJSON(data);
                var supplierName = obj['supplierName'];
                var supplierNameText = obj['supplierNameText'];

                $notExistMessage = '';
                /*if(quantityNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + quantityNotExist + "<br>";
                }
                if(unitCodeNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + unitCodeNotExist + "<br>";
                } 
                if(assetNameNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + assetNameNotExist + "<br>";
                } */
                $('div#error-messages').html($notExistMessage);
                return false;
            }
        },
        error:function (){}
    }); //jQuery.ajax({
} //function checkDataViaAJAX

							
 	function addSupplier() {

		var ID = $('#requestID').val();
		var supplierName = $('#supplierName').val();
		var supplierNameText = $('#supplierName').combobox('getText');
		var requestStatus = $("#requestStatus").val();
		
		
		jQuery.ajax({
			url: "insertSupplierNameASRS",
			data: { 
				'ID': ID, 
				'supplierID': supplierName, 
				'supplierName': supplierNameText, 
				'requestStatus': requestStatus, 
				
			},
			type: "POST",
			success:function(data){

                var resultValue = $.parseJSON(data);
                if(resultValue['success'] == 1) {
					var ID = resultValue['ID'];
					showSupplierList();
				
				}
				
			},
			error:function (){}
		}); //jQuery.ajax({	


		
	}	
	
function showSupplierList() {
		var ID = $('#requestID').val();
					jQuery.ajax({
						url: "ASRS/showSupplierNames",
						data: {
							'ID':ID,
							'accessType': 'readWrite'
						},
						type: "POST",
						success:function(data){
							//$('.level1').remove();
							$('#suppliersList').html(data);
						},
						error:function (){}
					}); //jQuery.ajax({

}				

function showBiddingPreparation() {
		var ID = $('#requestID').val();
					jQuery.ajax({
						url: "ASRS/showBiddingPreparation",
						data: {
							'ID':ID,
							'accessType': 'readWrite'
						},
						type: "POST",
						success:function(data){
							//$('.level1').remove();
							$('#biddingPreparation').html(data);
						},
						error:function (){}
					}); //jQuery.ajax({

}								

function submitPBACMember(){
    $('#pbacForm').form('submit',{
        onSubmit:function(){
            var validForm =  $(this).form('enableValidation').form('validate');
				//alert('hello');
           
		   if(!validForm) {
                return validForm;
            } else {
				var pbacUnit = $('#pbacUnit').val();
				var	pbacUnitText = $('#pbacUnit').combobox('getText');
				alert(pbacUnit);
				checkPBACMemberViaAJAX(pbacUnit, pbacUnitText);
            }

        }
    })
}


function checkPBACMemberViaAJAX(pbacUnit, pbacUnitText) {
	
    jQuery.ajax({
        url: "validatePBACMemberASRS",
        data:'pbacUnit='+pbacUnit+'&pbacUnitText='+pbacUnitText,
        type: "POST",
        success:function(data){
            console.log(data);
            var resultValue = $.parseJSON(data);
            if(resultValue['success'] == 1) {
                clearErrorMessages();
				addPBACMember();
            } else {
                var obj = $.parseJSON(data);
                var pbacUnit = obj['pbacUnit'];
                var pbacUnitText = obj['pbacUnitText'];

                $notExistMessage = '';
                $('div#error-messages').html($notExistMessage);
                return false;
            }
        },
        error:function (){}
    }); //jQuery.ajax({
} //function checkDataViaAJAX


 	function addPBACMember() {

		var ID = $('#requestID').val();
		var pbacUnit = $('#pbacUnit').val();
		var pbacUnitText = $('#pbacUnit').combobox('getText');
		var requestStatus = $("#requestStatus").val();
		
		
		jQuery.ajax({
			url: "insertPBACMemberASRS",
			data: { 
				'ID': ID, 
				'pbacUnit': pbacUnit, 
				'requestStatus': requestStatus, 
				
			},
			type: "POST",
			success:function(data){

                var resultValue = $.parseJSON(data);
                if(resultValue['success'] == 1) {
					var ID = resultValue['ID'];
					showPBACMember();
				
				}
				
			},
			error:function (){}
		}); //jQuery.ajax({	

	}	

function showPBACMember() {
	alert($('#requestID').val());
		var ID = $('#requestID').val();
					jQuery.ajax({
						url: "ASRS/showPBACMember",
						data: {
							'ID':ID,
							'accessType': 'readWrite'
						},
						type: "POST",
						success:function(data){
							console.log(data);
							//$('.level1').remove();
							$('#pbacMemberList').html(data);
						},
						error:function (){}
					}); //jQuery.ajax({

}								

function submitBidRequirements(){
    $('#pbacForm').form('submit',{
        onSubmit:function(){
            var validForm =  $(this).form('enableValidation').form('validate');
				//alert('hello');
           
		   if(!validForm) {
                return validForm;
            } else {
				var pbacUnit = $('#pbacUnit').val();
				var	pbacUnitText = $('#pbacUnit').combobox('getText');
				alert(pbacUnit);
				checkPBACMemberViaAJAX(pbacUnit, pbacUnitText);
            }

        }
    })
}
	
    </script>

</div>



