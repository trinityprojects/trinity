
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
					<img src="<?php echo $baseURL;?>assets/uploads/tbamims/<?php echo $row->attachments; ?>" style='width:50px; height: 50px' onclick="openModalImage('<?php echo $row->attachments; ?>')" class='hover-shadow cursor'>
					<?php if($row->userName == $userName) {?>
						<b class='hover-shadow cursor' onclick="deleteImage('<?php echo $row->attachments; ?>', '<?php echo $ID; ?>')">X-Remove</b>
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
						<div><b class='hover-shadow cursor' onclick="deleteImage('<?php echo $row->attachments; ?>', '<?php echo $ID; ?>')">X-Remove</b></div>
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


					
		function openModalImage(attachment) {
		  document.getElementById('myModalImage').style.display = "block";
		  $('#image-content').html("<img src='<?php echo base_url();?>assets/uploads/tbamims/" + attachment + "' style='width:100%; height: 100%'>");
		}	

		function closeModalImage() {
		  document.getElementById('myModalImage').style.display = "none";
		}

		function openModalPDF(attachment) {
		  document.getElementById('myModalPDF').style.display = "block";
		  $('#pdf-content').html("<embed src='<?php echo base_url();?>assets/uploads/tbamims/" + attachment + "'" + "type='application/pdf'   height='100%' width='100%'>");
		}	

		function closeModalPDF() {
		  document.getElementById('myModalPDF').style.display = "none";
		}

		function deleteImage(attachment, ID) {
			console.log(attachment);
			console.log(ID);
			jQuery.ajax({
				url: "TBAMIMS/deleteUploadedFiles",
				data: { 
					'attachment': attachment, 
				},
				type: "GET",
				success:function(data){
					console.log(data);
					console.log('deleted?');
					displayUploadedFiles(ID);
					console.log('deleted!');
						
				},
				error:function (){}
			}); //jQuery.ajax({	
		}


	function displayUploadedFiles(ID) {
					$(".level1A").remove();

		jQuery.ajax({
			url: "TBAMIMS/showUploadedFiles",
			data: { 
				'ID': ID, 
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
		
</script>
