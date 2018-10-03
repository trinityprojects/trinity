<div class="level1">
<link class="level1" rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/queuesys.css"></link>
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-3.3.1.min.js"></script>

    <script class="level1">
        $(document).ready(function(){
            $(".fullscreen_button").on("click", function() {
                document.fullScreenElement && null !== document.fullScreenElement || !document.mozFullScreen && !document.webkitIsFullScreen ? document.documentElement.requestFullScreen ? document.documentElement.requestFullScreen() : document.documentElement.mozRequestFullScreen ? document.documentElement.mozRequestFullScreen() : document.documentElement.webkitRequestFullScreen && document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT) : document.cancelFullScreen ? document.cancelFullScreen() : document.mozCancelFullScreen ? document.mozCancelFullScreen() : document.webkitCancelFullScreen && document.webkitCancelFullScreen()
            });	
        });        


        var counter = 0;
        setInterval(function(){
            
            jQuery.ajax({
                    url: "viewViewerQueue",
                    type: "GET",
                    success:function(data){
                        var resultValue = $.parseJSON(data);

                        $('#currentQueueID').text(resultValue['currentQueueNumber']['ID']);
                        $('#currentQueueCustomerNumber').text(resultValue['currentQueueNumber']['customerNumber']);


                        if(resultValue['status'] == 0) {
                            counter++;

                            $('#currentQueueID').animate({opacity: '0.2'}, 2000);
                            $('#currentQueueCustomerNumber').animate({opacity: '0.2'}, 2000);

                            if( (counter % 2) == 0) {
                                $('#currentQueueID').css({backgroundColor: 'gold', color: 'darkgreen' });
                                $('#currentQueueCustomerNumber').css({backgroundColor: 'gold', color: 'darkgreen' });


                            } else {
                                $('#currentQueueID').css({backgroundColor: 'darkgreen', color: 'gold'});
                                $('#currentQueueCustomerNumber').css({backgroundColor: 'darkgreen', color: 'gold'});
                            }
                            $("#my_audio").get(0).play();
                        }

                        $('#currentQueueID').animate({opacity: '1'}, 5000);
                        $('#currentQueueCustomerNumber').animate({opacity: '1'}, 5000);

                        updateQueueStatus(resultValue['status']);
                        var nextQueueLength = resultValue['nextQueueNumbers']['customerNumber'].length;
                        $('#nextQueue').html('');
                        $('#nextQueue').append('<span style="line-height: 40px">NEXT QUEUE NUMBERS</span></br>');
                        for(var i = 0; i < nextQueueLength; i++) {
                            $('#nextQueue').append('<b style="padding: 5px;border: 1px solid; line-height: 40px">' + resultValue['nextQueueNumbers']['ID'][i] + '</b>');
                            $('#nextQueue').append('<b style="padding: 5px; border: 1px solid; line-height: 40px">' + resultValue['nextQueueNumbers']['customerNumber'][i] + '</b></br>');
                        }

                    },
                    error:function (){}
                }); //jQuery.ajax({
                //alert('hello');
        }, 10000)


        function updateQueueStatus(status) {
            if(status == 0) {
                jQuery.ajax({
                    url: "updateStatusViewerQueue",
                    type: "GET",
                    success:function(data){
                        var resultValue = $.parseJSON(data);
                           
                        return true;

                    },
                    error:function (){}
                }); //jQuery.ajax({

            }
        }




    </script>

<div id="wrapper">



    <div  class="very-large-list-box-100" style="text-align:center;">
        <div class="fullscreen_button"> PROCEED TO ID ROOM: </div>

        <div class="level1" style="padding: 10px; width: 100%;">
            <b id="currentQueueID" style="padding: 5px;border: 1px solid; opacity: 1; border-radius: 10px"></b>
            <b id="currentQueueCustomerNumber" style="padding: 5px; border: 1px solid; opacity: 1; border-radius: 10px"></b>
            <audio id="my_audio" src="<?php echo base_url();?>assets/audio/Elevator-door-sound.mp3"></audio>
        </div>

    </div>
    <div  class="large-list-box-30">
        <div id="nextQueue" class="level1" style="padding: 10px">
        </div>
    </div> 


    <div  class="large-list-box-70" style="text-align:center;">
        <span> <image src="<?php echo base_url();?>assets/images/IDProcessSteps.jpg" /> </span>
    </div>

</div>



</div>
