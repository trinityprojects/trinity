<div class="level1">

<div > 
	<table border="1" style="font-size: 12px" >
		<tr style="padding: 5px; ">
			<td style="padding: 5px; "># </td>
			<td style="padding: 5px; ">Phone User</td>
			<td style="padding: 5px; ">Location</td>
			<td style="padding: 5px; ">Phone Number</td>
			<td style="padding: 5px; ">Details</td>
			
			<?php if($accessType != 'readOnly') { ?>
			<td style="padding: 5px; ">REMOVE</td>
			<?php } ?>
		</tr>
	<?php
		$ctr = 1;
		foreach($itemsList as $row) {?>
		<tr >
			<td style="text-align: right; padding: 5px"> <?php echo $ctr; ?> </td>
			<td style="text-align: left; padding: 5px; "><?php echo $row->item; ?> </td>
			<td style="text-align: left; padding: 5px; "><?php echo $row->location; ?> </td>
			<td style="text-align: left; padding: 5px; "><?php echo $row->otherDetails; ?> </td>
			<td style="text-align: left; padding: 5px; "><?php echo $row->itemDetails; ?> </td>
			
			<?php if($accessType != 'readOnly') { ?>
			<td style="text-align: center; padding: 5px; " > <span onclick="removeItem('<?php echo $row->ID; ?>', '<?php echo $requestNumber; ?>', '<?php echo $requestType; ?>')"  >X</span>
			<?php } ?>
		</tr>
		
	<?php 
		$ctr++;
		} 
	?>
	</table>

</div>

	
<script>
	function removeItem(ID, requestNumber, requestType) {
		jQuery.ajax({
			url: "deleteRequestItemsICTJRS",
			data: { 
				'ID': ID, 
				'requestNumber': requestNumber, 
				'requestType': requestType, 
			},
			type: "POST",
			success:function(data){

                var resultValue = $.parseJSON(data);
                if(resultValue['success'] == 1) {
					
					var itemID = resultValue['ID'];
					alert(ID);
					jQuery.ajax({
						url: "ICTJRS/showRequestItemsICTJRS",
						data: {
							'itemID':itemID,
							'requestNumber':requestNumber,
							'requestType':requestType,
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
				
			},
			error:function (){}
		}); //jQuery.ajax({	
		
	}


</script>
	

</div>