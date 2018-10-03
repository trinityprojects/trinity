<div class="level2">

<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/queuesys.css"></link>
    
    <div  class="large-list-box-50">
        <b> <?php echo $ID; ?> </b>
        <b> <?php echo $customerNumber; ?> </b>
        <span><a href="javascript:void(0)" class="small-button" onclick="finishQueue('<?php echo $ID; ?>', '<?php echo $customerNumber; ?>')" >DONE</a></span>


    </div>
</div>

<script>
    function finishQueue(ID, customerNumber) {
        jQuery.ajax({
                url: "finishQueueNumberQUEUESYS",
                data: {
                    'ID': ID,
                    'customerNumber': customerNumber,
                },
                type: "POST",
                success:function(data){
                    var resultValue = $.parseJSON(data);
                    if(resultValue['success'] == 1) {
                        reloadOperator(resultValue['ID'], resultValue['customerNumber']);
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }

    function reloadOperator(ID, customerNumber) {

        jQuery.ajax({
                url: "QUEUESYS/serverOperator",
                data: {
                    'ID':ID,
                    'customerNumber': customerNumber,
                },
                type: "POST",
                success:function(data){
                    $('div.level1').remove();
                    $('div.level2').remove();

                    $('.levelonecontent').append(data);
                },
                error:function (){}
            }); //jQuery.ajax({


    }


</script>
