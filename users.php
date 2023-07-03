<?php // ГЛАВНАЯ
session_start();

include_once("../v1/config.php");
include_once("../v1/err_handler.php");
include_once("../v1/db_connect.php");
include_once("../v1/functions.php");

if (isset($_SESSION['auth']))
{
	if($_SESSION['auth'] == true)
	{
		$user_id = $_SESSION['user_id'];
        $role_id = $_SESSION['role_id'];
        if($role_id == 1){  //editor 
            $query = "SELECT * FROM `crm_users`";
        }
        else if($role_id == 2){  //reader 
            $query = "SELECT * FROM `crm_users`";
        }
	}
	else{
		header("Location: auth.php"); exit();
	}
}
else{
	header("Location: auth.php"); exit();
}

	$res_query = mysqli_query($connection, $query);

	$users = array();
	$rows = mysqli_num_rows($res_query);

	for ($i=0; $i < $rows; $i++) { 
		$row = mysqli_fetch_assoc($res_query);
		array_push($users, $row);
	}

//var_dump($arr_list);
//var_dump($popular_products);
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

		<title>Проекты</title>

		<!-- Google font -->
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

		<!-- Bootstrap -->
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>

		<!-- Slick -->
		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>

		<!-- nouislider -->
		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>

		<!-- Font Awesome Icon -->
		<link rel="stylesheet" href="css/font-awesome.min.css">

		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="css/style.css"/>

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>

    </head>
	<body>

		<!-- HEADER -->
		<header>

			<!-- MAIN HEADER -->
			<div id="header">
				<!-- container -->
				<div class="container">
					<!-- row -->
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="index.php" class="logo">
									<img src="./img/lg.png" alt="">
								</a>
							</div>
						</div>
						<!-- /LOGO -->

							</div>
						</div>
						<!-- /ACCOUNT -->
					</div>
					<!-- row -->
				</div>
				<!-- container -->
			</div>
			<!-- /MAIN HEADER -->
		</header>
		<!-- /HEADER -->

		<!-- NAVIGATION -->
		<nav id="navigation">
			<!-- container -->
			<div class="container">
				<!-- responsive-nav -->
				<div id="responsive-nav">
					<!-- NAV -->
					<ul class="main-nav nav navbar-nav">
						<li><a href="projects.php">Проекты</a></li>
                        <li class="active"><a href="users.php">Пользователи</a></li>
					</ul>
					<!-- /NAV -->
				</div>
				<!-- /responsive-nav -->
			</div>
			<!-- /container -->
		</nav>
		<!-- /NAVIGATION -->

		

		<!-- SECTION -->
		<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row">

					<!-- section title -->
					<div class="col-md-12">
						<div class="section-title">
							<h3 class="title">Пользователи</h3>
                            <? if ($role_id==1) echo '<h5 class="title" style="margin-left: 45em;"><a href="create_user.php">Создать пользователя +</a></h5>'?> 
                            
						</div>
					</div>
					<!-- /section title -->





<? foreach ($users as $key => $value): ?>

    <br><br><h3><a href="functions.php?view_user=<?=$value['id']?>"><?=$value['username']?></a></h3>

<? endforeach; ?>




					
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /SECTION -->


		

		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>

	</body>
</html>
