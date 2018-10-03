<div class="level1">

<div > 
	<?php if(!empty($PBACMembers)) { ?>

	<table border="1" style="font-size: 12px" >
		<tr style="padding: 5px; ">
			<td style="padding: 5px; "># </td>
			<td style="padding: 5px; ">Unit</td>
			<td style="padding: 5px; ">Name</td>
			<td style="padding: 5px; ">Title</td>
			<?php if($accessType != 'readOnly') { ?>
			<td style="padding: 5px; ">REMOVE</td>
			<?php } ?>
		</tr>
	<?php
		$ctr = 1;
		foreach($PBACMembers as $row) {
		?>
		<tr >
			<td style="text-align: right; padding: 5px"> <?php echo $ctr; ?> </td>
			<td style="padding: 5px; "><?php echo $row->orgUnitName; ?> </td>
			<td style="padding: 5px; "><?php echo $row->prefixName . " " . $row->lastName . ", " . $row->firstName . " " . $row->middleName; ?> </td>
			<td style="padding: 5px; "><?php echo $row->headTitle; ?> </td>
			<?php if($accessType != 'readOnly') { ?>
			<td style="text-align: center; padding: 5px; " > 
				<span onclick="removeMember('<?php echo $ID; ?>', '<?php echo $row->ID; ?>')"  >X</span>
			<?php } ?>
		</tr>
		
	<?php 
		$ctr++;
		} 
	?>
	</table>
	<?php } ?>
</div>

	
<script>
	function removeMember(requestID, ID) {
		jQuery.ajax({
			url: "deletePBACMemberASRS",
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
						url: "ASRS/showPBACMember",
						data: {
							'ID':ID,
							'accessType': 'readWrite'
						},
						type: "POST",
						success:function(data){
							//$('.level1').remove();
							$('#pbacMemberList').html(data);
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