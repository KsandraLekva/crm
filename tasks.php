<?php // задачи
session_start();

include_once("../v1/config.php");
include_once("../v1/err_handler.php");
include_once("../v1/db_connect.php");
include_once("../v1/functions.php");


$project_id = $_SESSION['project_id'];

if (isset($_SESSION['auth']))
{
	if($_SESSION['auth'] == true)
	{
		$user_id = $_SESSION['user_id'];
        $role_id = $_SESSION['role_id'];
        if($role_id == 1){  //editor
            if (isset($_SESSION['sort_value'])){
                if($_SESSION['sort_value'] == 1){
                    $query = "SELECT * FROM `crm_tasks` WHERE `project_id`= '$project_id' ORDER BY `priority` DESC";
                }
                else if($_SESSION['sort_value'] == 2){
                    $query = "SELECT * FROM `crm_tasks` WHERE `project_id`= '$project_id' ORDER BY `deadline` ASC";
                }
                else if($_SESSION['sort_value'] == 3){
                    $query = "SELECT * FROM `crm_tasks` WHERE `project_id`= '$project_id' ORDER BY `status` ASC";
                }
                else $query = "SELECT * FROM `crm_tasks` WHERE `project_id`= '$project_id'";
            }
            else $query = "SELECT * FROM `crm_tasks` WHERE `project_id`= '$project_id'";
            
        }
        else if($role_id == 2){  //reader 
            $query = "SELECT * FROM `crm_tasks` WHERE `project_id`= '$project_id' AND `assigned_to`= '$user_id'";
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

$tasks = array();
$rows = mysqli_num_rows($res_query);

for ($i=0; $i < $rows; $i++) { 
	$row = mysqli_fetch_assoc($res_query);
	array_push($tasks, $row);
}

        $project_id = $_SESSION['project_id'];
		$query = "SELECT * FROM `crm_projects` WHERE `id` = '$project_id'";
		$res_query = mysqli_query($connection, $query);
		$result = mysqli_fetch_assoc($res_query);
		$project_name = $result["project_name"];


        $query = "SELECT COUNT(*) AS total_tasks FROM `crm_tasks` WHERE `project_id` = '$project_id'";
        $res_query = mysqli_query($connection, $query);
        $result = mysqli_fetch_assoc($res_query);
        $total_tasks = $result["total_tasks"];

        $query = "SELECT COUNT(*) AS completed_tasks FROM `crm_tasks` WHERE `project_id` = '$project_id' AND `status` = 1";
        $res_query = mysqli_query($connection, $query);
        $result = mysqli_fetch_assoc($res_query);
        $completed_tasks = $result["completed_tasks"];

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

		<title>Задачи</title>

        <style>
      th, td {
        padding: 10px;
        border: 50px solid white;
        color: black;
        text-align: center;
        vertical-align: middle;
      }
    </style>
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
							<h4 class="title">Задачи <?=$project_name?></h4>
                            <? if ($role_id==1) echo '<h5 class="title" style="margin-left: 50em;"><a href="create_task.php">Создать задачу +</a></h5>'?> 
                            <h5 class="title">Выполнено: <?=$completed_tasks?>/<?=$total_tasks?></h5>
                        </div>
					</div>
					<!-- /section title -->


                    <p><select id="sort" onchange="Sort()" style="width:255px;" class="input" name="sort">
					<option value="0">Сортировка по умолчанию</option>
                    <option value="1">Сортировка по приоритету</option>
					<option value="2">Сортировка по сроку сдачи</option>
                    <option value="3">Сортировка по статусу</option>
					</select></p>

                    <script>
                    var selectElement = document.getElementById("sort");
                    selectElement.value = "<?php echo isset($_SESSION['sort_value']) ? $_SESSION['sort_value'] : '0'; ?>";
                    function Sort() {
                    // Получаем выбранное значение параметра select
                    var sort_value = document.getElementById("sort").value;

                    // Создаем объект XMLHttpRequest
                    var xhr = new XMLHttpRequest();

                    // Отправляем AJAX-запрос на сервер
                    xhr.open("POST", "functions.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.send("sort_value=" + sort_value);

                    // Перезагружаем страницу после завершения запроса
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                        location.reload();
                        }
                    };
                    }
                    </script>
<table>

<tr>
  <th>Статус</th>
  <th>Название</th>
  <th>Приоритет</th>
  <th>Срок сдачи</th>
  <th> </th>
  <? if ($role_id==1) echo '<th> </th>'?> 

</tr>

<? foreach ($tasks as $key => $value): ?>
<?
$createDate = new DateTime($value['deadline']);
$date = $createDate->format('d-m-Y'); ?>
<tr>
  <td><input type="checkbox" class="custom-checkbox" <?php if ($value['status'] == 'completed') echo "checked='checked'"; ?>  onclick="location.href= 'functions.php?complete_task=<?=$value['id']?>'" ></td>
  <td><a href="functions.php?view_task=<?=$value['id']?>"><?=$value['task_name']?></a></td>
  <td><?=$value['priority']?></td>
  <td><?=$date?></td>
  <td><a href="functions.php?update_task=<?=$value['id']?>">Изменить</a></td>
  <? if ($role_id==1) echo '<td><a href="functions.php?del_task=' . $value['id'] . '">Удалить</a></td>'?> 

</tr>
<? endforeach; ?>
</table>




					
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
