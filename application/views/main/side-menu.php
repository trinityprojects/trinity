<div class="side-menu">

    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/thirdparty/easyui/themes/icon.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/thirdparty/easyui/jquery.easyui.min.js"></script>
	<script src="<?php echo base_url();?>assets/scripts/main/sidemenu.js"></script>

    <div class="easyui-panel" style="padding:5px">
        <ul class="easyui-tree">

        <?php foreach($system as $rowS) {?>
            <li  data-options="iconCls:'icon-application-list'">
                <span><?php echo $rowS->elementValueDescription; ?></span>
                <ul>
                <?php foreach($module as $rowM) {?>
                    <?php if($rowS->sourceSystemID == $rowM->sourceSystemID) { ?>
                        <li data-options="state:'open', iconCls:'icon-application'">
                            <span>
                                <div select-item="<?php echo $rowM->sourceSystemID ."/" . $rowM->elementValueID ."/".$rowM->param ."/".$rowM->sequenceOrder; ?>">
                                    <?php echo $rowM->elementValueDescription; ?>
                                </div>
                            </span>
                            <ul>
                            <?php foreach($menu as $rowI) {?>
                                <?php
                                    $mod = explode("-", $rowM->dataElementID);
                                    $modules = $mod[0];
                                    $men = explode("-", $rowI->dataElementID);
                                    $menus = $men[0];
                                    if( ($modules == $menus) && ($rowM->sourceSystemID == $rowI->sourceSystemID) ) {
                                ?>
                                    <li data-options="iconCls:'icon-application-link'">
                                        <div select-item="<?php echo $rowI->sourceSystemID ."/" . $rowI->elementValueID."/".$rowI->param ."/".$rowI->sequenceOrder; ?>">
                                            <?php echo $rowI->elementValueDescription; ?>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>        
                            </ul>
                        </li>
                    <?php } ?>
                <?php } ?>
                </ul>
            </li>
        <?php } ?>
        </ul>
    </div>
	CURRENT DATE: <?php echo $currentDate; ?>
</div>

