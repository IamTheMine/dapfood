
<?php include('../config/constants.php'); ?>

<html>
    <head>
        <title>Login - DapFood System</title>
        <link rel="stylesheet" href="../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>

            <?php
                if(isset($_SESSION['login']))
                {

                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
                
            ?>
            <br><br>

            <!--login here -->
            <form action ="" method ="POST" class ="text-center">
            Username: <br>
            <input type ="text" name ="username" placeholder ="Enter Username"><br><br>

            Password: <br>
            <input type ="password" name ="password" placeholder ="Enter Password"><br><br>

            <input type ="submit" name ="submit" value ="Login" class ="btn-primary">
            <br><br>
            </form>
            <p>Created By - <a href="www.dapfood.com">dapfood</a></p>
        </div>

    
    </body>
</html>

<?php

    if(isset($_POST['submit']))
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);


        $sql = "SELECT * FROM admin_1 WHERE username ='$username' AND password ='$password'";


        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);

        if($count==1)
        {

            //user available and login success
            $_SESSION['login']= "<div class='success'> ล็อคอิน สำเร็จ!.</div>";
            $_SESSION['user']= $username; //เพื่อตรวจสอบว่าผู้ใช้เข้าสู่ระบบหรือไม่ และถ้าออกแล้วจะยกเลิกข้อมูล
            //เปลี่ยนหน้าไปยัง home page
            header('location:'.SITEURL.'admin/');
        }
        else
        {

            //user login fail
            $_SESSION['login']="<div class='error text-center'> ชื่อ หรือ รหัสผ่านไม่ถูกต้อง!!.</div>";

            header('location:'.SITEURL.'admin/login.php');
        }
    }

?>