<?php

    include('../config/constants.php');


    $id = $_GET['id'];


    $sql = "DELETE FROM admin_1 WHERE id=$id";


    $res = mysqli_query($conn, $sql);


    if($res==true)
    {

        $_SESSION['delete'] = "<div class='success'>ลบสำเร็จ.</div>";
        
        header('location:'.SITEURL.'admin/manage-admin.php');
    }
    else
    {
        $_SESSION['delete'] = "<div class='error'>ลบไม่สำเร็จ. ลองใหม่อีกครั้ง.</div>";
        header('location:'.SITEURL.'admin/manage-admin.php');
    }


?>