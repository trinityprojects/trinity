<html lang="en">
<head>
	<title>TRINITY - <?php echo $title;?></title>

	<meta name="description" content="overview &amp; stats" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/bootstrap.css" />
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/fontawesome-free-5.0.8/web-fonts-with-css/css/fontawesome-all.min.css" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" />
	<!-- page specific plugin styles -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/trinity.css" />

    <!-- basic scripts -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/scripts/jquery-3.3.1.min.js"></script>
	<script src="<?php echo base_url();?>assets/scripts/bootstrap.js"></script>
	<script src="<?php echo base_url();?>assets/scripts/main/main.js"></script>
    
</head>
 
<body class="no-skin">

    <nav class="navbar navbar-expand-sm navbar-custom">
        <a href="/" class="navbar-brand">
			<span style="padding: 0 2px 0 2px; font-size: 10px"> ACTIVE TERM: <?php echo $_SESSION['sy'] . "-" . $_SESSION['sem'] . "-" . $_SESSION['gP']; ?> </span>		
			<br>
			<?php echo strtoupper($_SESSION['organizationAppBrand']); ?>
		</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCustom">
            <i class="fa fa-bars fa-lg py-1 text-white">
            </i>
        </button>
        <div class="navbar-collapse collapse" id="navbarCustom">
            <ul class="navbar-nav">

            <?php foreach($category as $rowC) {?>
                <?php if($rowC->grpcount > 0) {?>
                    <li class="nav-item dropdown">   
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $rowC->elementValueDescription; ?>
                        </a>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" selectApp="<?php echo $rowC->elementValueID; ?>"><?php echo $rowC->elementValueDescription; ?></a>                   
                <?php } ?>

                <?php if($rowC->grpcount > 0) {?>
                   
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php foreach($group as $rowG) {?>
                        <?php if($rowC->categ == $rowG->categorySystemID) {?>    
                            <a class="dropdown-item" selectApp="<?php echo $rowG->sourceSystemID . "/" . $rowG->elementValueID; ?>"><?php echo $rowG->elementValueDescription; ?></a>                
                        <?php } ?>
                    <?php } ?>
                    </div>
                <?php } ?>

                </li>
            <?php } ?>
            
            </ul>

								
			
            <span class="ml-auto navbar-text">
				<ul class="navbar-nav">
				<?php foreach($categoryset as $rowC) {?>
					<?php if($rowC->grpcount > 0) {?>
						<li class="nav-item dropdown">   
							<a class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php echo $rowC->elementValueDescription; ?>
							</a>
					<?php } else { ?>
						<li class="nav-item">
							<a class="nav-link" selectSettings="<?php echo $rowC->elementValueID; ?>"><?php echo $rowC->elementValueDescription; ?></a>                   
					<?php } ?>

					<?php if($rowC->grpcount > 0) {?>
					   
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<?php foreach($groupset as $rowG) {?>
							<?php if($rowC->categ == $rowG->categorySystemID) {?>    
								<a class="dropdown-item" selectSettings="<?php echo $rowG->sourceSystemID . "/" . $rowG->elementValueID; ?>">
								<?php echo $rowG->elementValueDescription; 
									if($rowG->elementValueDescription == "Term"){
									echo " (" . $_SESSION['sy'] . "-" . $_SESSION['sem'] . ")";
									}
								?>
								
								</a>                
							<?php } ?>
						<?php } ?>
						</div>
					<?php } ?>

					</li>
				<?php } ?>
				
                    <li class="nav-item dropdown">   
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<?php echo $this->session->userName; ?>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a href="<?php echo base_url() ?>trinityAuth/logout" class="dropdown-item" selectControl1="logout">Logout</a> 
                            
							<a class="dropdown-item" selectApp="PERSONALDATA/personalData">Personal Data</a>   
							
						</div>
					</li>
				</ul>
			</span>
					

        </div>
    </nav>

<div class="row">

