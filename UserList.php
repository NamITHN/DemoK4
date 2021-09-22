<html>
    <head>
        <link rel="stylesheet" href="css/common.css">
        <link rel="stylesheet" href="css/user-list.css">
       <?php
       session_start();
       $user_login = $_SESSION["username"];

       $connection = mysqli_connect("localhost","root","","dbtraining");
       $sql = "SELECT * FROM user ";

       $result = mysqli_query($connection,$sql);

       if(mysqli_num_rows($result) <=0 ){
           $listUserNull = "Không có user trong danh sách";
       }
       // Phân trang
       $sql_sum_user = "SELECT COUNT(id) as total FROM user";
       $result_sum = mysqli_query($connection,$sql_sum_user);
       $row = mysqli_fetch_assoc($result_sum);
       $total_records = $row["total"];

       if(isset($_GET["page"])){
           $curent_page = $_GET["page"];
       }else{
        $curent_page = 1;
       }
       $limit = 5;

       $total_page = ceil($total_records / $limit);
       // vị trí start
       $start = ($curent_page - 1) * $limit;

       $sql_page = "SELECT * FROM User LIMIT $start, $limit";

       $result = mysqli_query($connection,$sql_page);

       ?>
    </head>
    <body>
        <div class="header">
            <div class="login-info">
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
            <div id="left">
                <h4>Quản lý người dùng</h4>
                <a href="UserList.php">Danh sách</a>
                <a href="UserADD.php">Thêm mới</a>
            </div>

            <div id="right">
                <form action="UserList.php" method="POST">
                    <div id="search">
                        <div class="titlesearch">
                            <h4>Tìm kiếm người dùng</h4>
                        </div>

                        <table>
                            <tr>
                                <td>Tài khoản</td>
                                <td><input type="text" name="username" value=""></td>
                                <td>Giới tính</td>
                                <td>
                                    <input type="radio" name="gender" value="male" >Nam
                                    <input type="radio" name="gender" value="female" >Nữ
                                </td>
                            </tr>
                            <tr>
                                <td>Tên thật</td>
                                <td><input type="text" name="realName" value=""></td>
                                <td>Ngôn ngữ lập trình</td>
                                <td>
                                    <input type="checkbox" name="lang[]" value="Php" > PHP
                                    <input type="checkbox" name="lang[]" value="java" > Java
                                    <input type="checkbox" name="lang[]" value="Javascript" > Javascript
                                    <input type="checkbox" name="lang[]" value="C" > C
                                    <input type="checkbox" name="lang[]" value="Python" > Python
                                </td>
                            </tr>

                            <tr>
                                <td>Emai</td>
                                <td><input type="text" name="email" value=""></td>
                                <td>Quốc tịch</td>
                                
                                <td>
                                    <select name="country">
                                        <option value="">--Lựa chọn quốc tịch--</option>
                                        <option value="Vietnamese" >Vietnamese</option>
                                        <option value="Japanese" >Japanese</option>
                                        <option value="Chinese" >Chinese</option>
                                        <option value="American" >American</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <div class="btn-search"> 
                            <input style= "margin-left: 100px; " type="submit" value="Reset">
                            <input style="background-color: seagreen; border: 1px solid seagreen;" type="submit" value="Tìm kiếm" name="search"> 
                        </div>
                        
                    </div>
                </form>


                <div id="list">
                    <div class="titlesearch">
                        <h4>Danh sách người dùng</h4>
                    </div>
                    <table class="table-user">
                        <tr>
                            <th>Tên tài khoản</th>
                            <th>Tên thật</th>
                            <th>Email</th>
                            <th>Giới tính</th>
                            <th>Ngôn ngữ lập trình</th>
                            <th>Quốc tịch</th>
                            <th>Action</th>
                        </tr>
                    <?php
                    while($user = mysqli_fetch_array($result)){
                        echo "<tr>";
                        echo "<td> <a href='ProfileDetail.php'>".$user["user_name"]."</a></td>";
                        echo "<td>".$user["real_name"]."</td>";
                        echo "<td>".$user["email"]."</td>";
                        echo "<td>".$user["gender"]."</td>";
                        echo "<td>".$user["programing_language"]."</td>";
                        echo "<td>".$user["national"]."</td>";
                        echo "<td class='delete' onClick =\"myDelete('".$user["user_name"]."')\"> Delete </td>";
                        echo "</tr>";
                    }
                    ?> 
                        
                    </table>

                    <div id="pagecenter">
                        <div id="pagination">
                            <a href="UserList.php?page=1">Đầu</a>
                            <a href="UserList.php?page=<?php
                            if($curent_page == 1){
                                echo 1;
                            }else{
                                echo $curent_page - 1;
                            }
                            ?>">Trước</a>

                            <?php
                            for($i =1; $i <= $total_page ; $i++){
                                if($curent_page == $i){
                                    echo '<a style = "color:red" href="UserList.php?page='.$i.'">'.$i.' | </a>';
                                }else{
                                    echo '<a href="UserList.php?page='.$i.'">'.$i.' | </a>';
                                }
                                
                            }
                            ?>

                            <a href="UserList.php?page=<?php
                            if($curent_page == $total_page){
                                echo $total_page;
                            }else{
                                echo $curent_page + 1;
                            }
                            ?>">Sau</a>
                            <a href="UserList.php?page=<?php echo $total_page; ?>">Cuối</a>
                        </div>
                    </div>
                
                </div>
            </div>

            <div class="spacer" style="clear: both;"></div>
        </div>

        <script>
            function myDelete(username) {
                var result = confirm("Bạn có muốn xóa user: " + username);
                if(result) {
                    var url = "http://localhost/ProjectK4/Delete.php?username=" + username
                    window.location = url;
                }
            }
        </script>

    </body>
</html>