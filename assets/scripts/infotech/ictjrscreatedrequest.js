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
				var requestType = $('#requestType').val();
				var itemID = '';
				var otherDetails = '';
				var location = '';
				var startDate = '';
				var endDate = '';
				var item = '';
				var itemDetails = $('#itemDetails').val();
				
				if(requestType == 'CCTA') {
					itemID = $('#location').val();
				} else if(requestType == 'GSAS' || requestType == 'HWRS') {
					itemID = $('#requestCategory').val();
				} else if(requestType == 'ICWA') {
					itemID = $('#requestCategory').val();
					otherDetails = $('#connectionType').val();
					location = $('#roomNumber').val();
				} else if(requestType == 'ICSA') {
					item = $('#contentSite').val();
					itemDetails = $('#reason').val();
					otherDetails = $('#durationType').val();
					startDate = $('#start_date').val();
					endDate = $('#end_date').val();
				} else if(requestType == 'LPI') {
					itemID = $('#projectorDetail').val();
				} else if(requestType == 'PTRS') {
					itemID = $('#phoneDetail').val();
				} else if(requestType == 'SWTI') {
					itemID = $('#softwareName').val();
				}
				
			
				//alert(itemID);
				var requestNumber = $('#requestNumber').val();
				var deliveryDate = $('#deliveryDate').val();
		//alert(itemID);		
				checkDataItemsViaAJAX(itemID, requestNumber, requestType, itemDetails, deliveryDate, otherDetails, location, item, startDate, endDate)
            }

        }
    });
}



function checkDataItemsViaAJAX(itemID, requestNumber, requestType, itemDetails, deliveryDate, otherDetails, location, item, startDate, endDate) {
	jQuery.ajax({
        url: "validateRequestItemsICTJRS",
        data:'itemID='+itemID+'&requestNumber='+requestNumber+'&requestType='+requestType+'&itemDetails='+itemDetails+'&deliveryDate='+deliveryDate+'&otherDetails='+otherDetails+'&location='+location+'&item='+item+'&startDate='+startDate+'&endDate='+endDate,
        type: "POST",
        success:function(data){
            console.log(data);
            var resultValue = $.parseJSON(data);
            if(resultValue['success'] == 1) {
				clearErrorMessages();
				addItem(resultValue['itemID'], resultValue['requestNumber'], resultValue['requestType'], resultValue['itemDetails'], resultValue['deliveryDate'], resultValue['otherDetails'], resultValue['location'], resultValue['item'], resultValue['startDate'], resultValue['endDate'] );

            } else {
                var obj = $.parseJSON(data);
                var itemID = obj['itemID'];
                var requestNumber = obj['requestNumber'];
                var requestType = obj['requestType'];
                var itemDetails = obj['itemDetails'];
                var deliveryDate = obj['deliveryDate'];
                var otherDetails = obj['otherDetails'];
                var location = obj['location'];
                var item = obj['item'];
                var startDate = obj['startDate'];
                var endDate = obj['endDate'];
				
                $notExistMessage = '';
                $('div#error-messages').html($notExistMessage);
                return false;
            }
        },
        error:function (){}
    }); //jQuery.ajax({
} //function checkDataViaAJAX



 
 
 	function addItem(itemID, requestNumber, requestType, itemDetails, deliveryDate, otherDetails, location, item, startDate, endDate) {
		jQuery.ajax({
			url: "insertRequestItemsICTJRS",
			data: { 
				'itemID': itemID, 
				'requestNumber': requestNumber, 
				'requestType': requestType, 
				'itemDetails': itemDetails, 
				'deliveryDate': deliveryDate, 
				'otherDetails': otherDetails, 
				'location': location,
				'item': item,
				'startDate': startDate, 
				'endDate': endDate, 
				
			},
			type: "POST",
			success:function(data){

                var resultValue = $.parseJSON(data);
                if(resultValue['success'] == 1) {
					var itemID = resultValue['itemID'];
					var requestNumber = resultValue['requestNumber'];
					var requestType = resultValue['requestType'];
					var itemDetails = resultValue['itemDetails'];
					var deliveryDate = resultValue['deliveryDate'];
					var otherDetails = resultValue['otherDetails'];
					var location = resultValue['location'];
					var item = resultValue['item'];
					var startDate = resultValue['startDate'];
					var endDate = resultValue['endDate'];
					
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