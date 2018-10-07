function submitForm(){
    $('#ff').form('submit',{
        onSubmit:function(){
            var validForm =  $(this).form('enableValidation').form('validate');
            if(!validForm) {
                return validForm;
            } else {
                var requestSummary = $('#requestSummary').val();
                var requestDetails = $('#requestDetails').val();
                var requestType = $('#requestType').val();
                checkDataViaAJAX(requestSummary, requestDetails, requestType);
            }
        }
    });
} //function submitForm()


function checkDataViaAJAX(requestSummary, requestDetails, requestType) {
    jQuery.ajax({
        url: "validateRequestICTJRS",
        data:'requestSummary='+requestSummary+'&requestDetails='+requestDetails+'&requestType='+requestType,
        type: "POST",
        success:function(data){
            console.log(data);
            var resultValue = $.parseJSON(data);
            if(resultValue['success'] == 1) {
                clearErrorMessages();

                requestSummary = resultValue['requestSummary'];
                requestDetails = resultValue['requestDetails'];
                requestType = resultValue['requestType'];

                $.ajax({
                    url: 'ICTJRS/setCreateRequestConfirmation',
                    data: 'requestSummary='+requestSummary+'&requestDetails='+requestDetails+'&requestType='+requestType,
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
                var requestSummary = obj['requestSummary'];
                var requestDetails = obj['requestDetails'];
                var requestType = obj['requestType'];
                var resultsRTNotExist = obj['resultsRTNotExist'];

                $notExistMessage = '';
                if(resultsRTNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + resultsRTNotExist + "<br>";
                }
                $('div#error-messages').html($notExistMessage);
                return false;
            }
        },
        error:function (){}
    }); //jQuery.ajax({
} //function checkDataViaAJAX(requestSummary, requestDetails, requestType)


function insertDataViaAJAX(requestSummary, requestDetails, requestType) {
    jQuery.ajax({
        url: "insertRequestICTJRS",
        data:'requestSummary='+requestSummary+'&requestDetails='+requestDetails+'&requestType='+requestType,
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
                displayRequestNumber(resultValue['ID'], resultValue['requestType'], resultValue['requestSummary']);
                return true;
            } else {
                return false;
            }
        },
        error:function (){}
    }); //jQuery.ajax({
} //function insertDataViaAJAX(requestSummary, requestDetails, requestType)


function displayRequestNumber(ID, requestType, requestSummary) {
    jQuery.ajax({
        url: 'ICTJRS/showCreatedRequest',
        data: 'ID='+ID+'&requestType='+requestType+'&requestSummary='+requestSummary,
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
} //function displayRequestNumber(ID, userName)


function clearForm(){
    console.log($('#ff').form());
    $('#ff').form('clear');
} //function clearForm()

function clearErrorMessages() {
    $('div#error-messages').html('');
}


function myformatter(date){
    var y = date.getFullYear();
    var m = date.getMonth()+1;
    var d = date.getDate();
    return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
} //function myformatter(date)

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
} //function myparser(s)
