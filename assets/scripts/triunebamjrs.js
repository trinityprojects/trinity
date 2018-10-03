function submitForm(){
    $('#ff').form('submit',{
        onSubmit:function(){
            var validForm =  $(this).form('enableValidation').form('validate');
            if(!validForm) {
                return validForm;
            } else {
                var locationCode = $('#locationCode').val();
                var floor = $('#floor').val();
                var roomNumber = $('#roomNumber').val();
                var projectTitle = $('#projectTitle').val();
                var scopeOfWorks = $('#scopeOfWorks').val();
                var projectJustification = $('#projectJustification').val();
                var dateNeeded = $('#dateNeeded').val();
                checkDataViaAJAX(locationCode, floor, roomNumber, projectTitle, scopeOfWorks, projectJustification, dateNeeded);
            }

        }
    });
}


function checkDataViaAJAX(locationCode, floor, roomNumber, projectTitle, scopeOfWorks, projectJustification, dateNeeded) {
    //console.log(locationCode + " - " + floor + " " + roomNumber + " " + projectTitle + " " + scopeOfWorks + " " + projectJustification + " " + dateNeeded);
    jQuery.ajax({
        url: "setRequestBAM",
        data:'locationCode='+locationCode+'&floor='+floor+'&roomNumber='+roomNumber+'&projectTitle='+projectTitle+'&scopeOfWorks='+scopeOfWorks+'&projectJustification='+projectJustification+'&dateNeeded='+dateNeeded,
        type: "POST",
        success:function(data){
            console.log(data);
            var resultValue = $.parseJSON(data);
            if(resultValue['success'] == 1) {
                clearErrorMessages();

                locationCode = resultValue['locationCode'];
                floor = resultValue['floor'];
                roomNumber = resultValue['roomNumber'];
                projectTitle = resultValue['projectTitle'];
                scopeOfWorks = resultValue['scopeOfWorks'];
                projectJustification = resultValue['projectJustification'];
                dateNeeded = resultValue['dateNeeded'];


                $.ajax({
                    url: 'bamjrs/getCreateConfirmation',
                    data: 'locationCode='+locationCode+'&floor='+floor+'&roomNumber='+roomNumber+'&projectTitle='+projectTitle+'&scopeOfWorks='+scopeOfWorks+'&projectJustification='+projectJustification+'&dateNeeded='+dateNeeded,
                    type: "POST",
                    success: function(response) {
                        $('#request-confirmation').html(response);
                        $('#dlg').dialog('open');
                        console.log("the request is successful!");
                    },
                                
                    error: function(error) {
                        console.log('the page was NOT loaded', error);
                        $('.content1').html(error);
                    },
                                
                    complete: function(xhr, status) {
                        console.log("The request is complete!");
                    }
                });


            } else {
                var obj = $.parseJSON(data);
                var dateNeeded = obj['dateNeeded'];
                var roomNumber = obj['roomNumber'];
                var floor = obj['floor'];
                var locationCode = obj['locationCode'];
                var scopeOfWorks = obj['scopeOfWorks'];
                var projectJustification = obj['projectJustification'];
                var projectTitle = obj['projectTitle'];
                var locationCodeNotExist = obj['locationCodeNotExist'];
                var floorNotExist = obj['floorNotExist'];
                var roomNumberNotExist = obj['roomNumberNotExist'];

                $notExistMessage = '';
                if(locationCodeNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + locationCodeNotExist + "<br>";
                }
                if(floorNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + floorNotExist + "<br>";
                } 
                if(roomNumberNotExist != undefined) {
                    $notExistMessage =  $notExistMessage + roomNumberNotExist + "<br>";
                } 
                if(dateNeeded != undefined) {
                    $notExistMessage =  $notExistMessage + dateNeeded + "<br>";
                } 
                if(roomNumber != undefined) {
                    $notExistMessage =  $notExistMessage + roomNumber + "<br>";
                } 
                if(floor != undefined) {
                    $notExistMessage =  $notExistMessage + floor + "<br>";
                } 
                if(locationCode != undefined) {
                    $notExistMessage =  $notExistMessage + locationCode + "<br>";
                } 
                if(scopeOfWorks != undefined) {
                    $notExistMessage =  $notExistMessage + scopeOfWorks + "<br>";
                } 
                if(projectJustification != undefined) {
                    $notExistMessage =  $notExistMessage + projectJustification + "<br>";
                } 
                if(projectTitle != undefined) {
                    $notExistMessage =  $notExistMessage + projectTitle + "<br>";
                } 
                $('div#error-messages').html($notExistMessage);
                return false;
            }
        },
        error:function (){}
    }); //jQuery.ajax({
} //function checkDataViaAJAX


function insertDataViaAJAX(locationCode, floor, roomNumber, projectTitle, scopeOfWorks, projectJustification, dateNeeded) {
    //console.log(locationCode + " - " + floor + " " + roomNumber + " " + projectTitle + " " + scopeOfWorks + " " + projectJustification + " " + dateNeeded);
    jQuery.ajax({
        url: "insertRequestBAM",
        data:'locationCode='+locationCode+'&floor='+floor+'&roomNumber='+roomNumber+'&projectTitle='+projectTitle+'&scopeOfWorks='+scopeOfWorks+'&projectJustification='+projectJustification+'&dateNeeded='+dateNeeded,
        type: "POST",
        success:function(data){
            var resultValue = $.parseJSON(data);
            if(resultValue['success'] == 1) {
                $('div.requestForm').remove();
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
        url: 'bamjrs/getCreatedRequest',
        data: 'ID='+ID,
        type: "POST",
        success: function(response) {
            $('.content1').html(response);
            console.log("the request is successful for content1!");
        },
                    
        error: function(error) {
            console.log('the page was NOT loaded', error);
            $('.content1').html(error);
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
