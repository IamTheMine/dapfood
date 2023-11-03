<?php
    
    include('../config/constants.php');
    //echo "Delete Page";
    
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];
       
        if($image_name != "")
        {
           
            $path = "../images/category/".$image_name;
            //REmove the Image
            $remove = unlink($path);
            if($remove==false)
            {
                
                $_SESSION['remove'] = "<div class='error'>ลบไม่สำเร็จ.</div><br>";

                header('location:'.SITEURL.'admin/manage-category.php');

                die();
            }
        }
        

        $sql = "DELETE FROM category_db WHERE id=$id";


        $res = mysqli_query($conn, $sql);


        if($res==true)
        {

            $_SESSION['delete'] = "<div class='success'>ลบเรียบร้อย.</div><br>";

            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {

            $_SESSION['delete'] = "<div class='error'>ลบไม่สำเร็จ.</div><br>";

            header('location:'.SITEURL.'admin/manage-category.php');
        }
    
    
    
    
    
    
    }       
    else
    {
        //redirect to Manage Category Page
        header('location:'.SITEURL. 'admin/manage-category.php');
    }