<?php
    
    include('../config/constants.php');
    //echo "Delete Page";
    
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
       
        if($image_name != "")
        {
           
            $path = "../images/food/".$image_name;
            //REmove the Image
            $remove = unlink($path);


            if($remove==false)
            {
                
                $_SESSION['upload'] = "<div class='error'>ลบไม่สำเร็จ.</div><br>";

                header('location:'.SITEURL.'admin/manage-food.php');

                die();
            }
        }
        

        $sql = "DELETE FROM food_db WHERE id=$id";


        $res = mysqli_query($conn, $sql);


        if($res==true)
        {

            $_SESSION['delete'] = "<div class='success'>ลบเรียบร้อย.</div><br>";

            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {

            $_SESSION['delete'] = "<div class='error'>ลบไม่สำเร็จ.</div><br>";

            header('location:'.SITEURL.'admin/manage-food.php');
        }
    
    
    }       
    else
    {
        //redirect to Manage food Page
        $_SESSION['unsuccess'] = "div class='error'>ไม่สำเร็จ.</div>";
        header('location:'.SITEURL. 'admin/manage-food.php');
    }