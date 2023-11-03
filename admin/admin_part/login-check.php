<?php

      //ตรวจสอบว่ามีคน login หรือป่าว
    if(!isset($_SESSION['user']))
    {
        //user is not login
        //เปลี่ยนเส้นทางไปยัง login page ด้วยข้อความ

        $_SESSION['no-login-message'] = "<div class='error text-center'>กรุณาเข้าสู่ระบบเพื่อเข้าถึงผู้ดูแลระบบ.</div>";
        //ไปยัง login page
        header('location:'.SITEURL.'admin/login.php');
    }

?>