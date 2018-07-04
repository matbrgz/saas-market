<?php 
	
	$notifications = $this->controller->user->getNotifications(Session::getUserId());
    $orders = $budgets = $suppliers = $files = "";
	foreach($notifications as $notification){
		if($notification["count"] > 0){
            // $$notification["target"] = $notification["count"];        // DEPRECATED IN PHP 7
			${$notification["target"]} = $notification["count"];
		}
	}
	
	$info = $this->controller->user->getProfileInfo(Session::getUserId());

?>

		<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
            </div>
            <!-- /.navbar-header -->
			
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Hello,<strong> <?= $info["name"]; ?></strong> <i class="fas fa-user"></i>  <i class="fas fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= PUBLIC_ROOT . "User/Profile"; ?>"><i class="fas fa-user"></i> Profile</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= PUBLIC_ROOT . "Login/logOut"; ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
			
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
						<li id="logo" class="text-center">
                            <a href="">
								<img src="<?= PUBLIC_ROOT;?>img/icons/logo.svg" style="width: 100px;">
							</a>
                        </li>
                        <li id="dashboard">
                            <a href="<?= PUBLIC_ROOT . "User"; ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                        </li>
                        <li id="suppliers">
                            <a href="<?= PUBLIC_ROOT . "Suppliers"; ?>"><i class="fas fa-parachute-box"></i> Suppliers
								<span class="label label-danger"><?= $suppliers;?></span></a>
                        </li>
                        <li id="budget">
                            <a href="<?= PUBLIC_ROOT . "Budgets"; ?>"><i class="fas fa-gavel"></i> Budgets
                                <span class="label label-danger"><?= $budgets;?></span></a>
                        </li>
                        <li id="orders">
                            <a href="<?= PUBLIC_ROOT . "Orders"; ?>"><i class="fas fa-shopping-basket"></i> Orders
                                <span class="label label-danger"><?= $orders;?></span></a>
                        </li>
                        <li id="files">
                            <a href="<?= PUBLIC_ROOT . "Files"; ?>"><i class="fas fa-cloud-upload-alt"></i> Files
								<span class="label label-danger"><?= $files;?></span></a>
                        </li>
						<li id="bugs">
                            <a href="<?= PUBLIC_ROOT . "User/Bugs"; ?>"><i class="fas fa-bug"></i> Bugs</a>
                        </li>
						<?php if(Session::getUserRole()  === "admin") {?>
							<li id="users">
								<a href="<?= PUBLIC_ROOT . "Admin/Users"; ?>"><i class="fas fa-users"></i> Users</a>
							</li>
							<li id="backups">
								<a href="<?= PUBLIC_ROOT . "Admin/Backups"; ?>"><i class="fas fa-database"></i> Backups</a>
							</li>
						<?php } ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>