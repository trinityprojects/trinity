<div class="level1">

<div > 
	<table border="1" style="font-size: 12px" >
		<tr style="padding: 5px; ">
			<td style="padding: 5px; "># </td>
			<td style="padding: 5px; ">QTY</td>
			<td style="padding: 5px; ">UNIT</td>
			<td style="padding: 5px; ">DESCRIPTION</td>
			<?php if($accessType != 'readOnly') { ?>
			<td style="padding: 5px; ">REMOVE</td>
			<?php } ?>
		</tr>
	<?php
		$ctr = 1;
		foreach($itemsList as $row) {?>
		<tr >
			<td style="text-align: right; padding: 5px"> <?php echo $ctr; ?> </td>
			<td style="text-align: right; padding: 5px; "><?php echo $row->quantity; ?> </td>
			<td style="padding: 5px; "><?php echo $row->unitCode; ?> </td>
			<td style="padding: 5px; "><?php echo $row->assetName; ?> </td>
			<?php if($accessType != 'readOnly') { ?>
			<td style="text-align: center; padding: 5px; " > <span onclick="removeItem('<?php echo $ID; ?>', '<?php echo $row->ID; ?>')"  >X</span>
			<?php } ?>
		</tr>
		
	<?php 
		$ctr++;
		} 
	?>
	</table>

</div>

	
<script>
	function removeItem(requestID, ID) {
		jQuery.ajax({
			url: "deleteRequestItemsASRS",
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
				
			},
			error:function (){}
		}); //jQuery.ajax({	
		
	}


</script>
	

</div>