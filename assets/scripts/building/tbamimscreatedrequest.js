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
    form_data.append('ID', $("#ID").val());
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
				displayUploadedFiles($("#ID").val());
            }
        })
    } else {
        alert(error);
    }
	
	
	function displayUploadedFiles(ID) {

		jQuery.ajax({
			url: "TBAMIMS/showUploadedFiles",
			data: { 
				'ID': ID, 
			},
			type: "GET",
			success:function(data){
					$('#uploaded_files').html(data);
					$('#uploading').html('');
					$('#files').val('');
					
			},
			error:function (){}
		}); //jQuery.ajax({	
		
	}
	
	
 });


    function myRequestList() {

        $('div.requestForm').remove();
        jQuery.ajax({
            url: 'TBAMIMS/myRequest',
            type: "POST",
            success: function(response) {
                $('div.level1').remove();
                $('.levelonecontent').html(response);
                
            },
                        
            error: function(error) {
                console.log('the page was NOT loaded', error);
                $('.levelonecontent').html(error);
            },
                        
            complete: function(xhr, status) {
                console.log("The request is complete!");
            }
    }); //jQuery.ajax({



 //return true;
 }
 
 

 