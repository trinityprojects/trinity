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
            url:'uploadFile',
            method:"POST",
            data:form_data,
            contentType:false,
            cache:false,
            processData:false,
        
            beforeSend:function() {
                $('#uploaded_images').html("<label class='text-success'>Uploading...</label>");
            },
            success:function(data) {
                console.log(files.length);
                $('#uploaded_images').html('<p>The following files have been uploaded: <br>');
                for(i = 0; i < files.length; i++) {
                    $('#uploaded_images').append(files[i].name + "<br>");
                }
                $('#files').val('');
            }
        })
    } else {
        alert(error);
    }
 });


 function myRequestList() {

    $('div.requestForm').remove();
    jQuery.ajax({
        url: 'bamjrs/getMyRequestList',
        type: "POST",
        success: function(response) {
            $('.content1').html(response);
            
        },
                    
        error: function(error) {
            console.log('the page was NOT loaded', error);
            $('.content1').html(error);
        },
                    
        complete: function(xhr, status) {
            console.log("The request is complete!");
        }
}); //jQuery.ajax({

    //return true;
 }
 