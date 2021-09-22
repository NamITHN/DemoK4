
<html>
    <head>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/user-detail.css">

        <?php
        session_start();
        $user_login = $_SESSION['username'];

        $connection = mysqli_connect("localhost","root","","dbtraining");
        $sql = "SELECT * FROM user WHERE user_name = '$user_login' ";
        $result = mysqli_query($connection,$sql);
        if(mysqli_num_rows($result) > 0){
            while($user = mysqli_fetch_array($result)){
                $username = $user['user_name'];
                $password = $user['password'];
                $realname = $user['real_name'];
                $email = $user['email'];
                $gender = $user['gender'];
                $language = $user['programing_language'];
                $national = $user['national'];
                $avatar = $user['avatar_url'];
                $avatar = "images/".$avatar;   
            }
        }else{
            $acc_error ="Tài khoản không tồn tại";
        }
        ?>
    </head>
<body>
    <div class="header">
        <div class="login-info">
            <div class="dropdown">
                <button class="dropbtn"><?php if(isset($user_login)) echo $user_login?></button>
                <div class="dropdown-content">
                    <a href="UserList.php">Danh sách</a>
                    <a href="ProfileDetail.php">Trang cá nhân</a>
                    <a href="Logout.php">Đăng Xuất</a>
                </div>
            </div>
        </div>
    </div>

    <div id="nav">
        <div id="left">
            <p><b style="margin-top: 10px;">Ảnh đại diện</b></p>
            <img src="<?php if(isset($avatar)) echo $avatar ?>">
        </div>

        <div id="right">
            <div id="title">
                <h3>Thông tin cá nhân</h3>
            </div>

            <div> 
                <p>Tên tài khoản:</p>
                <div class="error"></div>
                <input type="text" name="username" value="<?php if(isset($username)) echo $username ?>">
            </div>

            <div>
                <p>Tên thật:</p>
                <div class="error"></div>
                <input type="text" name="realName" value="<?php if(isset($realname)) echo $realname ?>">
            </div>

            <div>
                <p>Email:</p>
                <div class="error"></div>
                <input type="email" name="email" value="<?php if(isset($email)) echo $email ?>">
            </div>

            <div>
                <p>Giới tính</p>
                <div class="error"></div>
                <input type="radio" name="gender" value="male" <?php if(isset($gender) && $gender == "male") echo "checked"?> > Nam
                <input type="radio" name="gender" value="female" <?php if(isset($gender) && $gender == "female") echo "checked"?> > Nữ
            </div>

            <div>
                <p>Ngôn ngữ lập trình</p>
                <div class="error"></div>
                <input type="checkbox" name="lang[]" value="Php" <?php if(isset($language) && strstr($language,"php")) echo "checked" ?> > PHP
                <input type="checkbox" name="lang[]" value="java"<?php if(isset($language) && strstr($language,"java")) echo "checked" ?>> Java
                <input type="checkbox" name="lang[]" value="Javascript"<?php if(isset($language) && strstr($language,"javascript")) echo "checked" ?>> Javascript
                <input type="checkbox" name="lang[]" value="C"<?php if(isset($language) && strstr($language,"c")) echo "checked" ?>> C
                <input type="checkbox" name="lang[]" value="Python"<?php if(isset($language) && strstr($language,"python")) echo "checked" ?>> Python
            </div>

            <div>
                <p>Quốc tịch</p>
                <div class="error"></div>
                <select name="country">
                    <option value="">--Lựa chọn quốc tịch--</option>
                    <option value="Vietnamese"<?php if(isset($national) && $national == "VietNam") echo "selected"?> >Vietnamese </option>
                    <option value="Japanese"<?php if(isset($national) && $national == "Japanese") echo "selected"?> >Japanese</option>
                    <option value="Chinese"<?php if(isset($national) && $national == "Chinese") echo "selected"?> >Chinese</option>
                    <option value="American"<?php if(isset($national) && $national == "American") echo "selected"?> >American</option>
                </select>
            </div>

            <br/> 

            <input style="background-color: cadetblue; margin-left: 10px; border: 1px solid cadetblue;" 
            type="submit" value="Chỉnh sửa">
        </div>
        <div class="spacer" style="clear: both;"></div>
    </div>

</body>    
</html>