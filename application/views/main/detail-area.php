<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/main/main.css" />

	<div class="container" >
		<div id="sticky-sidebar-demo" >
			<div class="sidebar__inner">

				<div class="sidemenu"> 
				<span onClick="hider()" id="hider" class="topright">x</span>

				</div>
            </div>
		</div>
		<div id="content" >
			

			<div class="levelonecontent" style="padding: 5px 10px 5px 10px">
			<span onClick="shower()" id="shower" class="topleft">+</span>
			</div>
			<div class="leveltwocontent" style="padding: 5px 10px 5px 10px" > </div>

		</div>	
    </div>
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/scripts/third-party/sticky-sidebar.js"></script>
	<script type="text/javascript">
$(document).ready(function(){
	$('#shower').hide();
	$('#hider').hide();
});

		var a = new StickySidebar('#sticky-sidebar-demo', {
			topSpacing: 25,
			containerSelector: '.container',
			innerWrapperSelector: '.sidebar__inner'
		});
	</script>