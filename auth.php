<?php 
include_once("../v1/config.php");
include_once("../v1/err_handler.php");
include_once("../v1/db_connect.php");
include_once("../v1/functions.php");

	//Если форма авторизации отправлена...
	if ( !empty($_REQUEST['password']) and !empty($_REQUEST['username']) ) {
		$username = $_REQUEST['username'];
		$password = $_REQUEST['password'];

        $query = "SELECT * FROM `crm_users` WHERE `username` = '$username'";
        $res_query = mysqli_query($connection, $query);
		$user = mysqli_fetch_assoc($res_query);

		if (!empty($user)) {
			if (password_verify($password, $user['password'])) {
				//Запись сессии в бд
			$user_id = $user['id'];
    		$token = RandomString_128();
    		$ip = $_SERVER['REMOTE_ADDR'];
    		$user_agent = $_SERVER['HTTP_USER_AGENT'];
    		$query = "INSERT INTO `sessions`(`user_id`, `token`, `ip`, `user_agent`)
				VALUES ('$user_id', '$token', '$ip', '$user_agent');";
    		$res_query = mysqli_query($connection, $query);

			session_start(); 
			$_SESSION['auth'] = true;
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['role_id'] = $user['role_id']; 
			$_SESSION['token'] = $token;

			header("Location: projects.php"); exit();
			} else {
				echo "Пароль неверный!";
			}
		} else {
            echo "Неправильный логин или пароль!";
		}
	}
?>

<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authorization</title>
    <link rel="stylesheet" type="text/css" href="authorization.css">
  </head>

  <body>
    <main id="main-holder">
      <h1 id="login-header">Login</h1>
      <div id="login-error-msg-holder">
        <p id="login-error-msg">Invalid username <span id="error-msg-second-line">and/or password</span></p>
      </div>
      <form id="login-form" action='auth.php' method='POST'>
        <input type="text" name="username" id="username-field" class="login-form-field" placeholder="Login">
        <input type="password" name="password" id="password-field" class="login-form-field" placeholder="Password">
        <input type="submit" value="Login" id="login-form-submit">
      </form>
    </main>
  </body>  
</html>