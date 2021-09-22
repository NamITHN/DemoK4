<?php
$url = $_SERVER["REQUEST_URI"];
$user_arr = explode("?username=",$url);
if(isset($user_arr[1])){
    $username = $user_arr[1];

    $connection = mysqli_connect("localhost","root","","dbtraining");
    $sql = "DELETE FROM `user` WHERE user_name ='$username'";
    $result = mysqli_query($connection,$sql);

    header('Location: UserList.php');
}


?>