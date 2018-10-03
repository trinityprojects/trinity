<div class="level1">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/queuesys.css"></link>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/dialog.css" />



    <div class="large-form-box">
    
    <?php if($ID != null) {?>
        <div >
            <a href="javascript:void(0)" class="small-button" onclick="getNewQueueNumber('<?php echo $customerNumber; ?>', '0');" >GET NEW QUEUE NUMBER</a>
        </div>
        <div class="large-label">
            <span>Please take note of your Queue Number below and wait for your turn to be posted on the screen:</span>
        </div>
        <div >
            <span class="very-large-button"><?php echo $ID; ?></span>
            <input type="hidden" id="ID" value="<?php echo $ID; ?>" />
        </div>
        <div class="large-label">
            <span>Your Current Queue Number should matched with your Student Number: <?php echo $customerNumber; ?></span>
            <input type="hidden"  id="customerNumber" value="<?php echo $customerNumber; ?>" />
            <input type="hidden"  id="reset" value="0" />
        </div>

    <?php } else { ?>
        <div class="large-label">
            <span>Are you <?php echo $customerNumber; ?>? Please click below to reset your Queue Number:</span>
        </div>
        <div >
            <a href="javascript:void(0)" class="small-button" onclick="getNewQueueNumber('<?php echo $customerNumber; ?>', '1');" >RESET YOUR QUEUE NUMBER</a>
            <input type="hidden"  id="reset" value="1" />

        </div>

    <?php } ?>


    </div>

   </br>
    <div class="large-form-box" style="padding: 10px">
        <span> <image src="<?php echo base_url();?>assets/images/IDProcessSteps.jpg" /> </span>
    </div>

</div>

<script>
    function getNewQueueNumber(customerNumber, reset) {
        //var customerNumber = $('#customerNumber').val();
        $.ajax({
            //url: 'QUEUESYS/customerQueue',
            url: 'customerQueue',
            type: "POST",
            data: {
                'reset': reset,
                'customerNumber' : customerNumber,
            },
            dataType: "html",
            success: function(response) {
                console.log('the page was loaded');
                //alert(response);
                $('.level1').html(response);
                $('#customerNumber').focus();
               // $("div.container").css("margin-left", "255px");
                //$('#sticky-sidebar-demo').
                //$('#sticky-sidebar-demo').hide();
            },

            error: function(error) {
                console.log('the page was NOT loaded', error);
                $('.level1').html(error);
            },

            complete: function(xhr, status) {
                console.log("The request is complete!");
            }
        });

    }

</script>