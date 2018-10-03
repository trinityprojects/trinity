<div class="level1">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/queuesys.css"></link>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />
	<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-3.3.1.min.js"></script>

    <div id="dialogoverlay-long"></div>
    <div id="dialogbox-long">
        <div>
            <div id="dialogboxhead-long"></div>
            <div id="dialogboxbody-long"></div>
            <div id="dialogboxfoot-long"></div>
        </div>
    </div>

<div id="wrapper">
    <div class="large-form-box" style="padding: 25px">

        <div class="medium-label" >
            <span>Where did you hear about us?</span>
        </div>
        <div class="medium-input">
            <span>
                <input name="sourceOfMarketing" id="sourceOfMarketing" type="radio" value="WS">Website</input> 
                <input name="sourceOfMarketing" id="sourceOfMarketing" type="radio" value="SM">Social Media</input> 
                <input name="sourceOfMarketing" id="sourceOfMarketing" type="radio" value="NP">News Paper</input> 
                <input name="sourceOfMarketing" id="sourceOfMarketing" type="radio" value="WM">Friends/Relatives</input> 
                <input name="sourceOfMarketing" id="sourceOfMarketing" type="radio" value="SV">School Visits</input> 
                <input name="sourceOfMarketing" id="sourceOfMarketing" type="radio" value="MF">Marketing Fair</input> 
                <input name="sourceOfMarketing" id="sourceOfMarketing" type="radio" value="OT">Others</input> 

            </span>
        </div>
        </br>
        <div class="large-label">
            <span class="fullscreen_button">Please type your Student Number in the box below:</span>
        </div>
        <div >
            <span><input type="text"  required autofocus class="large-input" id="customerNumber"  name="customerNumber" onkeypress="return isNumberKey(event)" /></span>
            <input type="hidden" id="group" value="IDSys" />
        </div>
        <div >
            <span><a href="javascript:void(0)" class="large-button" onclick="Confirm.render('setCustomerNumber')" >GET QUEUE NUMBER</a></span>
        </div>


    </div>

    </br>
    <div class="large-form-box" style="padding: 10px">
        <span> <image src="<?php echo base_url();?>assets/images/IDProcessSteps.jpg" /> </span>
    </div>
</div>


</div>

<script>

    $(document).ready(function(){ 
        $('#customerNumber').focus();
        $(".fullscreen_button").on("click", function() {
                $('#customerNumber').focus();
                document.fullScreenElement && null !== document.fullScreenElement || !document.mozFullScreen && !document.webkitIsFullScreen ? document.documentElement.requestFullScreen ? document.documentElement.requestFullScreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullScreen && document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) : document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen()
     
        });	        
    });

    function CustomConfirm(){
       var radioSelected = ( $("input[name='sourceOfMarketing']:checked").val());
       //alert(radioSelected);
       this.render = function(method){
            if( ($("[name='customerNumber']").val() == '') || ($("input[name='sourceOfMarketing']:checked").val() == undefined) ){
                $('#customerNumber').focus();
                return false;
            }



            var winW = window.innerWidth;
            var winH = window.innerHeight;
            var dialogoverlay = document.getElementById('dialogoverlay-long');
            var dialogbox = document.getElementById('dialogbox-long');
            dialogoverlay.style.display = "block";
            dialogoverlay.style.height = winH+"px";
            dialogbox.style.left = (winW/2) - (1200 * .5)+"px";
            dialogbox.style.top = "100px";
            dialogbox.style.display = "block";

            var param = $('#customerNumber').val();
            var dialog = '';

            dialog = dialog + "<div>";
            dialog = dialog + "<div style='text-align:center; font-size: 5em;'>" + param + "</div>";
            dialog = dialog + "</div>";

            document.getElementById('dialogboxhead-long').innerHTML = "<div style='text-align:center; font-size: 3em;'>Are you sure of your Student Number below?</div>";
            document.getElementById('dialogboxbody-long').innerHTML = dialog;
            document.getElementById('dialogboxfoot-long').innerHTML = '<button onclick="Confirm.yes(\''+method+'\',\''+param+'\')">Proceed</button> <button onclick="Confirm.no()">Close</button>';
        
        }
        this.no = function(){
            $('#customerNumber').focus();
            document.getElementById('dialogbox-long').style.display = "none";
            document.getElementById('dialogoverlay-long').style.display = "none";
        }
        this.yes = function(method,param){
            if(method == "setCustomerNumber"){
                setCustomerNumber(param);
            }
            document.getElementById('dialogbox-long').style.display = "none";
            document.getElementById('dialogoverlay-long').style.display = "none";
        }
    }
    var Confirm = new CustomConfirm();

    function setCustomerNumber(customerNumber) {
        var group = $('#group').val();
        var source = $("input[name='sourceOfMarketing']:checked").val()
        jQuery.ajax({
                url: "setCustomerNumberQUEUESYS",
                data: {
                    'customerNumber':customerNumber,
                    'group': group,
                    'source' : source,
                },
                type: "POST",
                success:function(data){
                    var resultValue = $.parseJSON(data);
                    if(resultValue['success'] == 1) {
                        displayCreatedQueueNumber(resultValue['ID'], resultValue['customerNumber'])
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }


    function displayCreatedQueueNumber(ID, customerNumber) {
        jQuery.ajax({
            //url: 'QUEUESYS/showCreatedQueueNumber',
            url: 'showCreatedQueueNumber',
            data: {
                'ID': ID,
                'customerNumber': customerNumber,
            },
            type: "POST",
            success: function(response) {
                $('.level1').html(response);
                console.log("the request is successful for here!");
            },
                        
            error: function(error) {
                console.log('the page was NOT loaded', error);
                $('.level1').html(error);
            },
                        
            complete: function(xhr, status) {
                console.log("The request is complete!");
            }
        }); //jQuery.ajax({
    }


 
  function isNumberKey(evt)  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode != 45  && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

     return true;
  }    


$('#customerNumber').on("keydown",function(ev){
	console.log(ev.keyCode);
    if(ev.keyCode===27||ev.keyCode===122||ev.keyCode===112) {
        return false;
    }

})


</script>