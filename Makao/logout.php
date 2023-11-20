<?php
session_start();
if(session_unset()){
    header("Location:index.php");
}
?>