<?php
        //include constants.php for SITURL
        include('../config/constants.php');
        // ใช้ในการยกเลิกข้อมูลทั้งหมดที่อยู่ใน session
        session_destroy(); //unset $_SESSION['user']


        header('location:'.SITEURL.'admin/login.php');

?>