<div class="level1">
<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/queuesys.css"></link>
    
    <div  class="large-list-box-50">
        <!--<div style="width: 100%">
            <b style="width: 150px; border: 1px solid">Queue Number</b>
            <b style="width: 150px ; border: 1px solid">Customer Number</b>
        </div>-->
    <?php 
        $i = 0;
        foreach($queueNumbers as $row) {
    ?>
        <div style="padding: 10px; width: 100%">
            <b style="padding: 5px;border: 1px solid"><?php echo $row->ID; ?></b>
            <b style="padding: 5px; border: 1px solid"><?php echo $row->customerNumber; ?></b>
            <?php if($i == 0) { ?>
            
                <span><a href="javascript:void(0)" class="small-button" onclick="callCustomer('<?php echo $row->ID; ?>', '<?php echo $row->customerNumber; ?>')" >CALL</a></span>
            
            <?php } ?>
        </div>
    <?php 
        $i++;
        } 
    ?>
    </div>

</div>


<script>
    function callCustomer(ID, customerNumber) {
        alert("CALLING: " + customerNumber);
        jQuery.ajax({
                url: "callCustomerNumberQUEUESYS",
                data: {
                    'ID':ID,
                    'customerNumber': customerNumber,
                },
                type: "POST",
                success:function(data){
                    var resultValue = $.parseJSON(data);
                    if(resultValue['success'] == 1) {
                    //alert('hello');
                         displayCurrentQueue(resultValue['ID'], resultValue['customerNumber']);
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }

    function displayCurrentQueue(ID, customerNumber) {
        $.ajax({
            url: "QUEUESYS/displayCurrentQueue",
            data: {
                    'ID':ID,
                    'customerNumber': customerNumber,
                },
            type: "POST",
            dataType: "html",
            success: function(response) {
                console.log('the page was loaded');
                $('div.level2').remove();
                $('.levelonecontent').append(response);
            },

            error: function(error) {
                console.log('the page was NOT loaded', error);
                $('.levelonecontent').html(error);
            },

            complete: function(xhr, status) {
                console.log("The request is complete!");
            }
        });
    }

</script>