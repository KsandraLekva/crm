<?php
session_start();

    include_once("../v1/config.php");
    include_once("../v1/err_handler.php");
    include_once("../v1/db_connect.php");
    include_once("../v1/functions.php"); 
    
    if(isset($_GET['view_project_id'])) {
        $_SESSION['project_id'] =  $_GET['view_project_id'];
        header("Location: tasks.php?". $_SERVER['QUERY_STRING']); exit();
    }
    else if(isset($_GET['view_user'])) {
        $_SESSION['view_user'] =  $_GET['view_user'];
        header("Location: user_info.php?". $_SERVER['QUERY_STRING']); exit();
    }
    else if(isset($_GET['view_task'])) {
        $_SESSION['view_task'] =  $_GET['view_task'];
        header("Location: task_info.php?". $_SERVER['QUERY_STRING']); exit();
    }
    else if(isset($_GET['create_task_project_id'])) {
        $_SESSION['project_id'] =  $_GET['create_task_project_id'];
        header("Location: create_task.php?". $_SERVER['QUERY_STRING']); exit();
    }
    else if (isset($_POST['sort_value'])) {
        // Сохраняем выбранное значение в сессию
        $_SESSION['sort_value'] = $_POST['sort_value'];
      }
    else if(isset($_GET['del_task'])) {
        $task_id =  $_GET['del_task'];
        $query = "DELETE FROM `crm_tasks` WHERE `id`='$task_id'";
	    $res_query = mysqli_query($connection, $query);
        header("Location: tasks.php?". $_SERVER['QUERY_STRING']); exit();
    }

    else if(isset($_GET['del_user'])) {
        $user_id =  $_GET['del_user'];
        $query = "DELETE FROM `crm_tasks` WHERE `assigned_to`='$user_id'";
	    $res_query = mysqli_query($connection, $query);
        $query = "DELETE FROM `crm_tasks` WHERE `created_by`='$user_id'";
	    $res_query = mysqli_query($connection, $query);
        $query = "DELETE FROM `crm_users` WHERE `id`='$user_id'";
	    $res_query = mysqli_query($connection, $query);
        header("Location: users.php?". $_SERVER['QUERY_STRING']); exit();
    }

    else if(isset($_GET['complete_task'])) {
            $task_id = $_GET['complete_task'];
    
            $query = "SELECT `status` FROM `crm_tasks` WHERE `id`='$task_id'";
            $res_query = mysqli_query($connection, $query);
            while ($row = mysqli_fetch_array($res_query)){
                $status = $row['status'];
            }
    
            if ($status == 'not_completed'){
                $query = "UPDATE `crm_tasks` SET `status`= 1 WHERE `id`='$task_id' AND `status` = 2";
                $res_query = mysqli_query($connection, $query);
                header("Refresh:0; url=tasks.php"); exit();
            }
            else {

                $query = "UPDATE `crm_tasks` SET `status`= 2 WHERE `id`='$task_id' AND `status` = 1";
                $res_query = mysqli_query($connection, $query);
                header("Refresh:0; url=tasks.php"); exit();
            }
    }

