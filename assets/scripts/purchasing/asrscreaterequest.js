function submitForm(){
    $('#ff').form('submit',{
        onSubmit:function(){
            var validForm =  $(this).form('enableValidation').form('validate');
            if(!validForm) {
                return validForm;
            } else {
                var requestPurpose = $('#requestPurpose').val();
                var requestRemarks = $('#requestRemarks').val();
                var dateNeeded = $('#dateNeeded').val();
                checkDataViaAJAX(requestPurpose, requestRemarks, dateNeeded);
            }

        }
    });
}


function checkDataViaAJAX(requestPurpose, requestRemarks, dateNeeded) {
	
    jQuery.ajax({
        url: "validateRequestASRS",
        data:'requestPurpose='+requestPurpose+'&requestRemarks='+requestRemarks+'&dateNeeded='+dateNeeded,
        type: "POST",
        success:function(data){
            console.log(data);
            var resultValue = $.parseJSON(data);
            if(resultValue['success'] == 1) {
                clearErrorMessages();

                requestPurpose = resultValue['requestPurpose'];
                requestRemarks = resultValue['requestRemarks'];
                dateNeeded = resultValue['dateNeeded'];


                $.ajax({
                    url: 'ASRS/setCreateRequestConfirmation',
                    data: 'requestPurpose='+requestPurpose+'&requestRemarks='+requestRemarks+'&dateNeeded='+dateNeeded,
                    type: "POST",
                    success: function(response) {
                        $('#request-confirmation').html(response);
                        $('#dlg').dialog('open');
                        console.log("the request is successful!");
                    },
                                
                    error: function(error) {
                        console.log('the page was NOT loaded', error);
                         $('.levelonecontent').html(error);
                    },
                                
                    complete: function(xhr, status) {
                        console.log("The request is complete!");
                    }
                });


            } else {
                var obj = $.parseJSON(data);
                var dateNeeded = obj['dateNeeded'];
                var requestPurpose = obj['requestPurpose'];
                var requestRemarks = obj['requestRemarks'];

                $notExistMessage = '';
                if(requestPurposeNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + requestPurposeNotExist + "<br>";
                }
                if(requestRemarksNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + requestRemarksNotExist + "<br>";
                } 
                if(dateNeeded != undefined) {
                    $notExistMessage =  $notExistMessage + dateNeeded + "<br>";
                } 
                $('div#error-messages').html($notExistMessage);
                return false;
            }
        },
        error:function (){}
    }); //jQuery.ajax({
} //function checkDataViaAJAX


function insertDataViaAJAX(requestPurpose, requestRemarks, dateNeeded) {
    jQuery.ajax({
        url: "insertRequestASRS",
        data:'requestPurpose='+requestPurpose+'&requestRemarks='+requestRemarks+'&dateNeeded='+dateNeeded,
        type: "POST",
        success:function(data){
            var resultValue = $.parseJSON(data);
            if(resultValue['success'] == 1) {
                $('div.level1').remove();
                $('div.panel.window.panel-htop').remove();
                $('div.panel.combo-p.panel-htop').remove();
                $('div.window-mask').remove();
                $('div.window-shadow').remove();
                $('div.autocomplete-suggestions').remove();
                displayRequestNumber(resultValue['ID']);
                return true;
            } else {
                return false;
            }
        },
        error:function (){}
    }); //jQuery.ajax({
} //function insertDataViaAJAX


function displayRequestNumber(ID, userName) {
    jQuery.ajax({
        url: 'ASRS/showCreatedRequest',
        data: 'ID='+ID,
        type: "POST",
        success: function(response) {
            $('.levelonecontent').html(response);
            console.log("the request is successful for content1!");
        },
                    
        error: function(error) {
            console.log('the page was NOT loaded', error);
            $('.levelonecontent').html(error);
        },
                    
        complete: function(xhr, status) {
            console.log("The request is complete!");
        }
    }); //jQuery.ajax({
}


function clearForm(){
    console.log($('#ff').form());
    $('#ff').form('clear');
}

function clearErrorMessages() {
    $('div#error-messages').html('');
}


function myformatter(date){
    var y = date.getFullYear();
    var m = date.getMonth()+1;
    var d = date.getDate();
    return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
}
function myparser(s){
    if (!s) return new Date();
    var ss = (s.split('-'));
    var y = parseInt(ss[0],10);
    var m = parseInt(ss[1],10);
    var d = parseInt(ss[2],10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
        return new Date(y,m-1,d);
    } else {
        return new Date();
    }
}
