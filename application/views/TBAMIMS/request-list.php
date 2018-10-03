<div class="level1" >

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/triune.css" />


    <script type="text/javascript">
        <?php for($x = 0; $x < count($statusR); $x++) {?>
            function doSearch<?php echo $statusD[$x];?>(){
                $('#<?php echo $statusR[$x];?>').datagrid('load',{
                    ID: $('#ID<?php echo $statusD[$x];?>').val(),
                    userName: $('#userName<?php echo $statusD[$x];?>').val(),
                    requestStatus: '<?php echo $statusR[$x];?>'
                });
            }
        <?php } ?>
    </script>   


    <div id="tabpanel" class="easyui-tabs" style="width:100%;max-width:100%;">
    <?php for($x = 0; $x < count($statusR); $x++) {?>
        <div title="<?php echo $statusD[$x];?> Requests" style="padding:10px;">
            <table id="<?php echo $statusR[$x];?>" class="easyui-datagrid" 
                style="width:100%;max-width:100%;padding:5px 5px;font-size: 5px;"
                url="getRequestListTBAMIMS" toolbar="#tb<?php echo $statusD[$x];?>"
                title="<?php echo $statusD[$x];?> Request List" iconCls="icon-save"
                rownumbers="true" pagination="true" 
                data-options="singleSelect: 'true', method:'post',
                    rowStyler: function(){
                            return 'padding:5px;';
                    },  
                    queryParams:{requestStatus:'<?php echo $statusR[$x];?>'}"
            >

                <thead>
                    <tr>
                        <th field="ID">ID</th>
                        <th field="locationCode" class="datagrid-cell-c2-locationCode">Location Code</th>
                        <th field="projectTitle">Project Title</th>
                        <th field="dateCreated" align="right">Date Created</th>
                        <th field="dateNeeded" align="right">Date Needed</th>
                        <th field="requestStatusDescription">Request Status</th>
                        <th field="userName">Requested By</th>
                        <?php if($statusR[$x] == 'R') { ?>
							<th field="returnedFrom">Previous Status</th>
						<?php } ?>
						<th field="dateCompleted"  align="right">Date Completed</th>
						<th field="dateClosed"  align="right">Date Closed</th>
						
                    </tr>
                </thead>
            </table>
        </div>
    <?php } ?>

    </div>

    <?php for($x = 0; $x < count($statusR); $x++) {?>
        <div id="tb<?php echo $statusD[$x];?>" style="padding:3px">
            <span>ID:</span>
            <input id="ID<?php echo $statusD[$x];?>" style="line-height:15px;;border:1px solid #ccc">
            <span>Requestor:</span>
            <input id="userName<?php echo $statusD[$x];?>" style="line-height:15px;;border:1px solid #ccc">
            <a href="#" class="easyui-linkbutton" plain="true" onclick="doSearch<?php echo $statusD[$x];?>()">Search</a>
        </div>
    <?php } ?>


    <input type="hidden" id="sequence" value="<?php echo ($sequence - 1);?>" />
    <script type="text/javascript">
    $(document).ready(function(){

        var index = $('#sequence').val();           
        var t = $('#tabpanel');
        var tabs = t.tabs('tabs');
        t.tabs('select', tabs[index].panel('options').title);

        $('#tabpanel').tabs({
            onSelect: function(title){
                $('div.level2').remove();
            }
        });

    <?php for($x = 0; $x < count($statusR); $x++) {?>

        $('#<?php echo $statusR[$x];?>').datagrid({
            onClickRow: function() {

                var row = $('#<?php echo $statusR[$x];?>').datagrid('getSelected');

                jQuery.ajax({
                    url: 'TBAMIMS/showNewRequestVerification',
                    data: 'ID='+row.ID,
                    type: "POST",
                    success: function(response) {
                        $('div.level2').remove();
                        $('.leveltwocontent').append(response);
                        $('div.autocomplete-suggestions').remove();
                        $('script.dynamic').remove();
                        console.log("the request is successful for content1!");
                    },
                                
                    error: function(error) {
                        console.log('the page was NOT loaded', error);
                        $('.content2').html(error);
                    },
                                
                    complete: function(xhr, status) {
                        console.log("The request is complete!");
                    }
                }); //jQuery.ajax({

            }

        });
        <?php } ?>

        return false;
    });



    
    </script> 
</div>
