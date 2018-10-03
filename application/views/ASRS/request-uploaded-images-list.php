
<div class="level1A" id="level1A">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />

	<div class="tab">
	  <button class="tablinks active" onclick="openAttachment(event, 'Images')">Images</button>
	  <button class="tablinks" onclick="openAttachment(event, 'PDFs')">PDFs</button>
	  <button class="tablinks" onclick="openAttachment(event, 'Others')">Others</button>
	</div>
	
	<div id="Images" class="tabcontent">
		<div class="images_container thumbnails">
		<?php
			$imagesCount = count($rowsImages);
			foreach($rowsImages as $row) {
		?>
			<span style="padding: 10px; display:inline-block; text-decoration:none;" >
				<div>
					<img src="<?php echo $baseURL;?>assets/uploads/asrs/<?php echo $row->attachments; ?>" style='width:50px; height: 50px' onclick="openModalImage('<?php echo $row->attachments; ?>')" class='hover-shadow cursor'>
					<?php if($row->userName == $userName) {?>
						<b class='hover-shadow cursor' onclick="deleteImage('<?php echo $row->attachments; ?>', '<?php echo $ID; ?>', 'I')">X</b>
					<?php } ?>
				</div>
				<div style="height:2px"></div>
				<div><?php echo $row->attachments; ?> </div>
			</span>
		<?php
			}
		?>
		</div>
	</div>

	<div id="PDFs" class="tabcontent">
		<div class="images_container thumbnails">
			<?php foreach($rowsApps as $row) {?> 
				<span style="padding: 10px; display:inline-block; text-decoration:none;" >
					<a href="javascript:void(0)" style="width:10%" onclick="openModalPDF('<?php echo $row->attachments;?>')" class="hover-shadow cursor"><?php echo $row->attachments;?></a>
					<?php if($row->userName == $userName) {?>
						<div><b class='hover-shadow cursor' onclick="deleteImage('<?php echo $row->attachments; ?>', '<?php echo $ID; ?>', 'P')">X</b></div>
					<?php } ?>
					</span>
			<?php } ?>	
		</div>
	</div>
	
	
	<div id="Others" class="tabcontent">
	  <p>Others.</p>
	</div>
		
	
</div>


<script class="dynamic" id="single">
					
		function openModalImage(attachment) {
		  document.getElementById('myModalImage').style.display = "block";
		  $('#image-content').html("<img src='<?php echo base_url();?>assets/uploads/asrs/" + attachment + "' style='width:100%; height: 100%'>");
		}	

		function closeModalImage() {
		  document.getElementById('myModalImage').style.display = "none";
		}

		function openModalPDF(attachment) {
		  document.getElementById('myModalPDF').style.display = "block";
		  $('#pdf-content').html("<embed src='<?php echo base_url();?>assets/uploads/asrs/" + attachment + "'" + "type='application/pdf'   height='100%' width='100%'>");
		}	

		function closeModalPDF() {
		  document.getElementById('myModalPDF').style.display = "none";
		}

		function deleteImage(attachment, ID, type) {
			console.log(attachment);
			console.log(ID);
			jQuery.ajax({
				url: "ASRS/deleteUploadedFiles",
				data: { 
					'attachment': attachment, 
					'type': type
				},
				type: "GET",
				success:function(data){
                    var resultValue = $.parseJSON(data);
					var type = resultValue['type'];
					console.log(data);
					console.log('deleted?');
					displayUploadedFiles(ID, type);
					console.log('deleted!');
						
				},
				error:function (){}
			}); //jQuery.ajax({	
		}


	function displayUploadedFiles(ID, type) {
		$(".level1A").remove();
		jQuery.ajax({
			url: "ASRS/showUploadedFiles",
			data: { 
				'ID': ID, 
			},
			type: "GET",
			success:function(data){
					$('#uploaded_files').html(data);
					if(type == 'I') {
						document.getElementById('Images').style.display = "block";
					} else {
						document.getElementById('PDFs').style.display = "block";
						var tablinks = document.getElementsByClassName("tablinks");
						tablinks[0].className = tablinks[0].className.replace(" active", "");
						tablinks[1].className = tablinks[1].className = 'tablinks active';
					}

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
		
</script>
