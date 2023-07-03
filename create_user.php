<?php // создание пользователя
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
	} else{
		header("Location: auth.php"); exit();
	}
} else{
	header("Location: auth.php"); exit();
}


	$query = "SELECT * FROM `crm_roles`"; 
	$res_query = mysqli_query($connection, $query);

	$roles = array();
	$rows = mysqli_num_rows($res_query);

	for ($i=0; $i < $rows; $i++) { 
		$row = mysqli_fetch_assoc($res_query);
		array_push($roles, $row);
	}

	//Если форма отправлена...
	if ( !empty($_REQUEST['username']) and !empty($_REQUEST['password']) and !empty($_REQUEST['role_id']) ) {
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];
		$role_id = $_REQUEST['role_id'];

		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO `crm_users`(`username`, `password`, `role_id`)
			VALUES ('$username', '$hashed_password', '$role_id')";
        $res_query = mysqli_query($connection, $query);
        header("Location: users.php"); exit();

/*

		
			Формируем и отсылаем SQL запрос:
			ВЫБРАТЬ ИЗ таблицы_users ГДЕ поле_логин = $login И поле_пароль = $password.
		
		//$query = 'SELECT * FROM users WHERE login="'.$login.'" AND password="'.$password.'"';
        $query = "SELECT * FROM `crm_projects` WHERE `username` = '$username' AND `password` = '$password'";
		//$result = mysqli_query($link, $query); //ответ базы запишем в переменную $result
        $res_query = mysqli_query($connection, $query);
		$user = mysqli_fetch_assoc($res_query); //преобразуем ответ из БД в нормальный массив PHP

		//Если база данных вернула не пустой ответ - значит пара логин-пароль правильная
		if (!empty($user)) {
			//Запись сессии в бд
            //echo "Успех";
			$user_id = $user['id'];
    		$token = RandomString_128(); /// надо думать
    		$ip = $_SERVER['REMOTE_ADDR'];
    		$user_agent = $_SERVER['HTTP_USER_AGENT'];
    		$query = "INSERT INTO `sessions`(`user_id`, `token`, `ip`, `user_agent`) VALUES ('$user_id', '$token', '$ip', '$user_agent');";
    		$res_query = mysqli_query($connection, $query);

			session_start(); 
			$_SESSION['auth'] = true;
			$_SESSION['id'] = $user['id']; 
			$_SESSION['username'] = $user['username'];
			$_SESSION['token'] = $token;

			header("Location: projects.php"); exit();
		} else {
			//Пользователь неверно ввел логин или пароль, выполним какой-то код.
            echo "Неправильный логин или пароль!";
		}*/
	}
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
                        <li><a href="users.php">Пользователи</a></li>
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
							<h3 class="title">Создание пользователя</h3>
						</div>
					</div>
					<!-- /section title -->


                    <form id="login-form" action='create_user.php' method='POST'>
                    <input type="text" name="username" class="input" style="width:500px;" placeholder="Логин"><br><br>
					<input type="text" name="password" class="input" style="width:500px;" placeholder="Пароль"><br><br>
					<p><select style="width:200px;" class="input" name="role_id">
					<? foreach ($roles as $key => $value): ?>
						<option value="<?=$value['id']?>"><?=$value['role_name']?></option>
					<? endforeach; ?>
					</select></p><br>
                    <input type="submit" class="primary-btn order-submit" value="Создать пользователя">
                </form>
					
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
