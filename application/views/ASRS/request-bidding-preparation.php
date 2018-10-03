<div class="level1">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/purchasing/asrs.css" />

<div > 
	<?php if(!empty($supplierNames)) { ?>

	<table border="1" style="font-size: 12px" >
		<tr style="padding: 5px; ">
			<td style="padding: 5px; "># </td>
			<td style="padding: 5px; ">Supplier Name</td>
			<td style="padding: 5px; ">Contact Person</td>
			<td style="padding: 5px; ">Contact Number</td>
			<td style="padding: 5px; ">Email Address</td>
		</tr>
	<?php
		$ctr = 1;
		foreach($supplierNames as $row) {
			if($row->supplierBidStatus == 'CAN') {			
		?>
		<tr >
			<td style="text-align: right; padding: 5px"> <?php echo $ctr; ?> </td>
			<td style="padding: 5px; "><?php echo $row->supplierName; ?> </td>
			<td style="padding: 5px; "><?php echo $row->supplierContactPerson; ?> </td>
			<td style="padding: 5px; "><?php echo $row->supplierTelNumber; ?> </td>
			<td style="padding: 5px; "><?php echo $row->supplierEmailAddress; ?> </td>
		</tr>
		
	<?php 
		$ctr++;
			}
		} 
	?>
	</table>
	<?php } ?>
</div>
<br>
	<form id="pbacForm">
		<div id="pbac-member">
		<label>List PBAC Member</label>
		
		<input class="easyui-combobox" name="pbacUnit"  id="pbacUnit" prompt="Department/Unit:" style="width:40%" data-options="
				url:'getOrgUnit',
				method:'get',
				valueField:'orgUnitCode',
				textField:'orgUnitName',
				panelHeight:200,
				required:true
				">
		<a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitPBACMember();" style="width:80px">Submit</a>						
		<div id="pbacMemberList" class="col-100" style="border: 0; padding: 10px">
			
	</div>
	</form>
<br>
			<div style="padding: 10px">
				<table id="datepicker" class="dp_calendar" style="display:none;font-size:14px;" cellpadding="0" cellspacing="0"></table>
				<span style="padding: 10px">
					Bid Deadline:
					<input type="text" name="bid_deadline" id="bid_deadline" readonly>
					<a onclick="DP.open('bid_deadline','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>
<br>
				
				<span style="padding: 10px">

					Bid Opening:
					<input type="text" name="opening_date" id="opening_date" readonly>
					<a onclick="DP.open('opening_date','doc_single_icon')" id="doc_single_icon"><img src="<?php echo base_url();?>assets/scripts/datepicker/datepicker_cal.gif" /></a>
				</span>
				
				<span id='sett'>SET</span>
				
			</div>
			<div class="panel-detail message-instruction1" id="message" > 
				<textarea  placeholder='Letter Content' style="background-color: white;" id="letter-content" data-autoresize rows="1" class="autoExpand"></textarea>
			</div> 	
	
	<script>
$('#sett').click(function() {
	alert($('#bid_deadline').val()); 
	
	});	
    jQuery.each(jQuery('textarea[data-autoresize]'), function() {
        var offset = this.offsetHeight - this.clientHeight;
    
        var resizeTextarea = function(el) {
            jQuery(el).css('height', 'auto').css('height', el.scrollHeight + offset);
        };
        jQuery(this).on('keyup input', function() { resizeTextarea(this); }).removeAttr('data-autoresize');
    });

</script>
<script>
	function removeSupplier(requestID, ID) {
		jQuery.ajax({
			url: "deleteSupplierNamesASRS",
			data: { 
				'ID': ID, 
				'requestID': requestID, 
			},
			type: "POST",
			success:function(data){

                var resultValue = $.parseJSON(data);
                if(resultValue['success'] == 1) {
					
					var ID = resultValue['ID'];
					alert(ID);
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
				
			},
			error:function (){}
		}); //jQuery.ajax({	
		
	}


</script>
	

</div>