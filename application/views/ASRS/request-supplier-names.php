<div class="level1">

<div > 
	<?php if(!empty($supplierNames)) { ?>

	<table border="1" style="font-size: 12px" >
		<tr style="padding: 5px; ">
			<td style="padding: 5px; "># </td>
			<td style="padding: 5px; ">Supplier Name</td>
			<td style="padding: 5px; ">Contact Person</td>
			<td style="padding: 5px; ">Contact Number</td>
			<?php if($accessType != 'readOnly') { ?>
			<td style="padding: 5px; ">REMOVE</td>
			<?php } ?>
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
			<?php if($accessType != 'readOnly') { ?>
			<td style="text-align: center; padding: 5px; " > 
				<span onclick="removeSupplier('<?php echo $ID; ?>', '<?php echo $row->ID; ?>')"  >X</span>
			<?php } ?>
		</tr>
		
	<?php 
		$ctr++;
			}
		} 
	?>
	</table>
	<?php } ?>
</div>

	
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