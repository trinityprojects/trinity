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
                    url: "viewNotifyOperatorQueue",
                    type: "GET",
                    success:function(data){
                        var resultValue = $.parseJSON(data);

						console.log(resultValue['status']);
                        if(resultValue['status'] == 0) {
                            $("#my_audio").get(0).play();
                        }

                        updateQueueStatusOperator(resultValue['status']);

                    },
                    error:function (){}
                }); //jQuery.ajax({
                //alert('hello');
        }, 10000)


        function updateQueueStatusOperator(status) {
            if(status == 0) {
                jQuery.ajax({
                    url: "updateStatusViewerQueueOperator",
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

        <div class="level1" style="padding: 10px; width: 100%;">
            <audio id="my_audio" src="<?php echo base_url();?>assets/audio/Elevator-door-sound.mp3"></audio>
        </div>

    </div>

</div>



</div>
