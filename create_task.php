<?php // создание задачи
session_start();
include_once("../v1/config.php");
include_once("../v1/err_handler.php");
include_once("../v1/db_connect.php");
include_once("../v1/functions.php");

	$created_by = $_SESSION['user_id'];
	$project_id = $_SESSION['project_id'];

	//Если форма отправлена...
	if ( !empty($_REQUEST['task_name']) and !empty($_REQUEST['task_desc']) 
	and !empty($_REQUEST['priority']) and !empty($_REQUEST['assigned_to']) and !empty($_REQUEST['date']) ) {
		
		$date = $_POST['date'];
        $date = date('Y-m-d', strtotime($date));
		$task_name = $_REQUEST['task_name'];
		$desc = $_REQUEST['task_desc'];
		$assigned_to = $_REQUEST['assigned_to'];
		$priority = $_REQUEST['priority'];

        $query = "INSERT INTO `crm_tasks`(`task_name`, `desc`, `priority`, `project_id`, `assigned_to`, `created_by`, `deadline`)
			VALUES ('$task_name', '$desc', '$priority', '$project_id', '$assigned_to', '$created_by', '$date')";
        $res_query = mysqli_query($connection, $query);
        header("Location: tasks.php"); exit();

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
	else{
		
		$project_id = $_SESSION['project_id'];
		$query = "SELECT * FROM `crm_projects` WHERE `id` = '$project_id'";
		$res_query = mysqli_query($connection, $query);
		$result = mysqli_fetch_assoc($res_query);
		$project_name = $result["project_name"];

		$query = "SELECT * FROM `crm_priorities`"; 
		$res_query = mysqli_query($connection, $query);

		$priorities = array();
		$rows = mysqli_num_rows($res_query);

		for ($i=0; $i < $rows; $i++) { 
			$row = mysqli_fetch_assoc($res_query);
			array_push($priorities, $row);
		}

		$query = "SELECT * FROM `crm_users`"; 
		$res_query = mysqli_query($connection, $query);

		$assigned_to = array();
		$rows = mysqli_num_rows($res_query);

		for ($i=0; $i < $rows; $i++) { 
			$row = mysqli_fetch_assoc($res_query);
			array_push($assigned_to, $row);
		}
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
							<h3 class="title">Создание задачи для проекта <?=$project_name?></h3>
						</div>
					</div>
					<!-- /section title -->


                    <form id="login-form" action='create_task.php' method='POST'>
                    <input type="text" name="task_name" class="input" style="width:500px;" placeholder="Название задачи"><br><br>
					<textarea type="text" name="task_desc" placeholder="Описание задачи" style="width:700px; height: 150px;" cols="2" class="input" rows="3"></textarea><br><br>
					
					<p><select style="width:220px;" class="input" name="assigned_to">
					<option value="">Исполнитель</option>
					<? foreach ($assigned_to as $key => $value): ?>
						<option value="<?=$value['id']?>"><?=$value['username']?></option>
					<? endforeach; ?>
					</select></p><br>

					<p><select style="width:220px;" class="input" name="priority">
					<option value="">Приоритет задачи</option>
					<? foreach ($priorities as $key => $value): ?>
						<option value="<?=$value['id']?>"><?=$value['priority_name']?></option>
					<? endforeach; ?>
					</select></p><br>

					<input class="input" style="width:220px;" placeholder="Срок сдачи yyyy/mm/dd"
					onkeyup="
						var v = this.value;
						if (v.match(/^\d{4}$/) !== null) {
							this.value = v + '/';
						} else if (v.match(/^\d{4}\/\d{2}$/) !== null) {
							this.value = v + '/';
						}"
					maxlength="10" name="date" type="text"  size="30"><br><br>

					<input type="submit" class="primary-btn order-submit" value="Создать задачу">
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
