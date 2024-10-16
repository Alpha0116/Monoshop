<?php
    session_start();
    
    if(isset($_SESSION['admin']))
    {
        $_SESSION['admin']= array();

        session_destroy();

        header("Location:../");
    }elseif(isset($_SESSION['user']))
    {
        $_SESSION['user']= array();

        session_destroy();

        header("Location:../");
    }else
    {
        header("Location:../login.php");
    }
?>