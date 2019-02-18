    $(document).ready(function() {

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

    }); 


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
                $('#uploading').html("<label class='text-success'>Uploading...</label>");
            },
            success:function(data) {
				console.log(data);
				displayUploadedFiles($("#ID").val());
            }
        })
    } else {
        alert(error);
    }
	
	
	function displayUploadedFiles(ID) {

		jQuery.ajax({
			url: "ASRS/showUploadedFiles",
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
	
	
 });


    function myRequestList() {
        $('div.requestForm').remove();
        jQuery.ajax({
            url: 'ASRS/myRequest',
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
 
 
 function submitForm(){
    $('#itemForm').form('submit',{
        onSubmit:function(){
            var validForm =  $(this).form('enableValidation').form('validate');
            if(!validForm) {
                return validForm;
            } else {
				var quantity = $('#quantity').val();
				var unitCode = $('#unitCode').val();
				var itemName = $('#itemName').val();
				checkDataItemsViaAJAX(quantity, unitCode, itemName)
            }

        }
    });
}




function checkDataItemsViaAJAX(quantity, unitCode, itemName) {
	
    jQuery.ajax({
        url: "validateRequestItemsASRS",
        data:'quantity='+quantity+'&unitCode='+unitCode+'&itemName='+itemName,
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
                var itemName = obj['itemName'];

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

		var ID = $('#ID').val();
		var quantity = $('#quantity').val();
		var unitCode = $('#unitCode').val();
		var itemName = $('#itemName').val();
		var unitCodeText = $('#unitCode').combobox('getText');
		var itemNameText = $('#itemName').combobox('getText');
		
		jQuery.ajax({
			url: "insertRequestItemsASRS",
			data: { 
				'ID': ID, 
				'quantity': quantity, 
				'unitCode': unitCode, 
				'itemName': itemName, 
				'unitCodeText': unitCodeText, 
				'itemNameText': itemNameText, 
			},
			type: "POST",
			success:function(data){

                var resultValue = $.parseJSON(data);
                if(resultValue['success'] == 1) {
					var ID = resultValue['ID'];
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

 function clearErrorMessages() {
    $('div#error-messages').html('');
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