<?php
    require_once('../config/db_connection.php');

    if(isset($_GET['id'])){

        $id = $_GET['id'];

        $sql = "SELECT * FROM feedback WHERE feedback_id = $id";

        $result = $con->query($sql);

        if($result->num_rows > 0){
            $updateSql = "DELETE FROM feedback WHERE feedback_id ='$id';";
            
            if($con->query($updateSql)){
                header("Location: ../admin_dashboard.php");
                exit();
            } else {
                die("Error delete feedback" . $con->error);
            }
        }else {
            die("feedback not found");
        }
    } else{
        die("Invalid request.");
    }
?>