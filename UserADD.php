<html>
    <head>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/add-user.css">

        <?php
        session_start();
        $user_login = $_SESSION["username"];

        if(isset($_POST["add-user"])){

            $username = $_POST["username"];
            $password = $_POST["password"];
            $repassword = $_POST["repassword"];
            $realName = $_POST["realName"];
            $email = $_POST["email"];

            // check rong
            if($username == ''){
                $username_err ="vui lòng nhập user name";
            }
            if($password == ''){
                $password_err ="vui lòng nhập pass word";
            }
            if($repassword == ''){
                $repassword_err ="vui lòng nhập repassword";
            }
            if($realName == ''){
                $realName_err ="vui lòng nhập realName";
            }
            if($email == ''){
                $email_err ="vui lòng nhập email";
            }

            if(isset($_FILES["avatar"])){
                $type_image =$_FILES["avatar"]["type"];
                $type_image = explode("/",$type_image);
                if(isset($type_image[1])){
                    if($type_image[1]== "png" | 
                    $type_image[1]== "jpg" |
                    $type_image[1]== "jpeg" ){
                        $avatar = time().$_FILES["avatar"]["name"];
                        $tmp_file =$_FILES["avatar"]["tmp_name"];
                        move_uploaded_file($tmp_file,'images/'.$avatar);
                    }else{
                        $avatar_err ="Vui lòng nhập ảnh";
                    }
                }
            }

            if(isset($_POST["gender"])){
                $gender = $_POST["gender"];
            }else{
                $gender_err ="Vui lòng chọn giới tính";
            }

            if(isset($_POST["lang"])){
                $language = "";
                foreach($_POST["lang"] as $value){
                    $language = $language.",".$value;
                }
                $language = trim($language,",");
            }else{
                $lang_err = " Vui lòng chọn ngôn ngữ lập trình";
            }

            if(isset($_POST["country"])){
                $country = $_POST["country"];
            }else{
                $country_err="Bạn vui lòng chọn quê hương";
            }

            $connection = mysqli_connect("localhost","root","","dbtraining");
            $sql = "SELECT * FROM user WHERE user_name = '$username'";
            $result = mysqli_query($connection,$sql);

            if(mysqli_num_rows($result) > 0){
                $acc_err = " Tài khoản đã tồn tại";
            }else{

                $password = md5($password);
                if(isset($avatar)){
                    $sql_insert = "INSERT INTO `user`(`user_name`, `password`, `real_name`, `email`, `avatar_url`, `gender`, `programing_language`, `national`) 
                    VALUES ('$username','$password','$realName','$email','$avatar','$gender','$language','$country')";

                mysqli_query($connection,$sql_insert);
                header('Location: UserList.php');
                }
            }


        }
        ?>
    </head>
    <body>
        <div class="header">
       
            <div class="login-info">
            <img src="https://chishiki.vn/img/Chi1.png" width="100" height="50">
                <div class="dropdown">
                    <button class="dropbtn"><?php if(isset($user_login)) echo $user_login ?></button>
                    <div class="dropdown-content">
                        <a href="ProfileDetail.php">Trang cá nhân</a>
                        <a href="Logout.php">Đăng Xuất</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="nav">

            <div class="error" style="margin-top:5px"></div>

            <form action="UserAdd.php" method="POST" enctype="multipart/form-data"> 
                <div> 
                    <p>Tên tài khoản:</p>
                    <div class="error"> <?php if(isset($acc_err)) echo $acc_err ?> </div>
                    <div class="error"> <?php if(isset($username_err)) echo $username_err ?> </div>
                    <input type="text" name="username" value="<?php if(isset($username)) echo $username ?>">
                </div>

                <div>
                    <p>Mật khẩu:</p>
                    <div class="error"><?php if(isset($password_err)) echo $password_err ?></div>
                    <input type="password" name="password" value="<?php if(isset($password)) echo $password ?>">
                </div>

                <div>
                    <p>Nhập lại mật khẩu:</p>
                    <div class="error"><?php if(isset($repassword_err)) echo $repassword_err ?></div>
                    <input type="password" name="repassword" value="<?php if(isset($repassword)) echo $repassword ?>">
                </div>

                <div>
                    <p>Tên thật:</p>
                    <div class="error"><?php if(isset($realName_err)) echo $realName_err ?></div>
                    <input type="text" name="realName"  value="<?php if(isset($realName)) echo $realName ?>">
                </div>

                <div>
                    <p>Email:</p>
                    <div class="error"><?php if(isset($email_err)) echo $email_err ?></div>
                    <input type="email" name="email" value="<?php if(isset($email)) echo $email ?>">
                </div>

                <div>
                    <p>Ảnh đại diện:</p>
                    <div class="error"><?php if(isset($avatar_err)) echo $avatar_err ?></div>
                    <input type="file" name="avatar">
                </div>

                <div>
                    <p>Giới tính</p>
                    <div class="error"><?php if(isset($gender_err)) echo $gender_err ?></div>
                    <input type="radio" name="gender" value="male"<?php if(isset($gender) && $gender == "male") echo "checked" ?>> Nam
                    <input type="radio" name="gender" value="female"<?php if(isset($gender) && $gender == "female") echo "checked" ?>> Nữ
                </div>

                <div>
                    <p>Ngôn ngữ lập trình</p>
                    <div class="error"><?php if(isset($lang_err)) echo $lang_err ?></div>
                    <input type="checkbox" name="lang[]" value="Php"<?php if(isset($language) && strstr($language,"Php")) echo "checked"?> > PHP
                    <input type="checkbox" name="lang[]" value="java" <?php if(isset($language) && strstr($language,"Java")) echo "checked"?>> Java
                    <input type="checkbox" name="lang[]" value="Javascript"<?php if(isset($language) && strstr($language,"Javascript")) echo "checked"?> > Javascript
                    <input type="checkbox" name="lang[]" value="C"<?php if(isset($language) && strstr($language,"C")) echo "checked"?> > C
                    <input type="checkbox" name="lang[]" value="Python"<?php if(isset($language) && strstr($language,"Python")) echo "checked"?> > Python
                </div>

                <div>
                    <p>Quốc tịch</p>
                    <div class="error"><?php if(isset($country_err)) echo $country_err ?></div>
                    <select name="country">
                        <option value="">--Lựa chọn quốc tịch--</option>
                        <option value="Vietnamese" <?php if(isset($country) && $country == "Vietnamese") echo "selected" ?> >Vietnamese</option>
                        <option value="Japanese" <?php if(isset($country) && $country == "Japanese") echo "selected" ?>>Japanese</option>
                        <option value="Chinese" <?php if(isset($country) && $country == "Chinese") echo "selected" ?>>Chinese</option>
                        <option value="American" <?php if(isset($country) && $country == "American") echo "selected" ?>>American</option>
                    </select>
                </div>
                <br/>

                <div> 
                    <input style="background-color: seagreen; border: 1px solid seagreen;" type="submit" value="Xác nhận thêm mới" name="add-user">
                </div>

            </form>
        </div>
    </body>
</html>