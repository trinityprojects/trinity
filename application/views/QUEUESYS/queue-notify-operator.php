<div class="level1">
<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/infotech/queuesys.css"></link>
<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-3.3.1.min.js"></script>
    
    <div  class="large-list-box-50">
        <div style="padding: 10px; width: 100%">
              <span><a href="javascript:void(0)" class="small-button" onclick="notifyOperator()" >NOTIFY OPERATOR</a></span>
        </div>
    </div>

</div>


<script>
    function notifyOperator() {
		//alert("hello");
	   jQuery.ajax({
                url: "notifyOperatorQUEUESYS",
                type: "POST",
                success:function(data){
					console.log(data);
                    var resultValue = $.parseJSON(data);
                    if(resultValue['success'] == 1) {
                    alert('NOTIFIED!!!');
                    //     displayCurrentQueue(resultValue['ID'], resultValue['customerNumber']);
                        return true;
                    } else {
                        return false;
                    }
                },
                error:function (){}
            }); //jQuery.ajax({
    }
</script>