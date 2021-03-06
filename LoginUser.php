<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="css/common.css"/>     
        <link rel="stylesheet" href="css/login-user.css"/>     
    </head>
    <body>
        <div id="nav">
            <div id="title">
                <h3>ĐĂNG NHẬP VÀO HỆ THỐNG</h3>
            </div>
            <div id="content">
                <form action="LoginUser.php" method="POST">

                  <?php
                  session_start();
                  if(isset($_POST["form-login"])){
                    $username = $_POST["username"];
                    $password = $_POST["password"];
  
                    if($username == ''){
                        $user_error = "Bạn chưa nhập username !";
                    }
  
                    if($password == ''){
                        $pass_error = "Bạn chưa nhập mật khẩu !";
                    }

                    $pass = md5($password);
                    $connection = mysqli_connect("localhost","root","","dbtraining");
                    $sql = "SELECT * FROM user WHERE user_name = '$username' AND password = '$pass' ";
                    $result = mysqli_query($connection,$sql);

                    if(mysqli_num_rows($result) > 0){

                       $_SESSION['username'] = $username;
                       header('Location: UserAdd.php');

                    }else{

                        $acc_error="Tài khoản không tồn tại";
                    }
  
                  }

                  ?>
                  
                    <!-- Thông báo lỗi -->
                    <div class="error" style="color: red"> 
                        <?php
                        if(isset($user_error)){
                            echo "<li>".$user_error."</li>";
                        }

                        if(isset($pass_error)){
                            echo "<li>".$pass_error."</li>";
                        }

                        if(isset($acc_error)){
                            echo "<li>".$acc_error."</li>";
                        }
                        
                        ?>
                    </div>

                    <div id="divinput">
                        <i class="fa fa-user"></i>
                        <input type="text" placeholder="Tài khoản" name="username">
                    </div>

                    <div id="divinput">
                        <i class="fa fa-user"></i>
                        <input type="password" placeholder="Mật khẩu" name="password">
                    </div>

                    <div id="divsubmit">
                        <input type="submit" value="Đăng nhập" name="form-login">
                    </div>

                </form>
                
            </div>
            
            <div id="bottom">
                <a href="">Đăng ký tài khoản/</a>
                <a href="">Quên mật khẩu?</a>
            </div>
        </div>
    </body>
</html>