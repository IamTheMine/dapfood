<?php include('admin_part/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>

        <br><br>

        <?php

            if(isset($_GET['id']))
            {


                $id = $_GET['id'];
                
                $sql = "SELECT * FROM category_db WHERE id=$id";


                $res = mysqli_query($conn, $sql);


                $count = mysqli_num_rows($res);

                if($count==1)
                {
                    //รับ data ทั้งหมด
                    $row = mysqli_fetch_assoc($row);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                }
                else
                {

                    $_SESSION['no-category-found'] = "<div = class='error'>ไม่พบข้อมูล!!.</div><br>";

                    header('location:'.SITEURL.'admin/mange-category.php');
                }
            }
            else
            {

                header('location:'.SITEURL.'admin/manage-category.php');
            }


        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-full">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image !="")
                            {

                                ?>
                                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
                                <?php
                            }
                            else
                            {

                                echo "<div class='error'>เพิ่มรูปไม่สำเร็จ.</div><br>";
                            }

                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                        <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes

                        <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>


            </table>
        </form>

        <?php

            if(isset($_POST['submit']))
            {
                //เมื่อ "คลิก"
                //รับค่าทั้งหมดจากแบบฟอร์ม  
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // อัปเดตรูปภาพใหม่ถ้าเลือก
                if(isset($_FILES['image']['name']))
                {
                    //get image details
                    $image_name = $_FILES['image']['name'];

                    //ตรวจสอบว่ามีรูปภาพหรือไม่
                    if($image_name !="")
                    {

                        //image available
                        //upload new image

                        //$ext = explode('.', $image_name);

                        //$image_name = "Food_Category_".rand(000,999).'.'.$ext;

                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //อัพโหลดภาพ
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //ตรวจสอบว่ารูปภาพถูกอัพโหลดหรือไม่
                        //และถ้าอัปโหลดไม่สำเร็จ ก็จะหยุดอัปโหลดและแสดงข้อความขึ้นมา

                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>อัปโหลดไม่สำเร็จ.</div><br>";

                            header('location:'.SITEURL.'admin/manage-category.php');
                            //stop process
                            die();
                        }

                        //remove current image if available
                        if($current_image!="")
                        {
                            $remove_path = "../images/category/".$current_image;

                            $remove = unlink($remove_path);


                            //ตรวจสอบว่ารูปได้ลบแล้วหรือป่าว
                            //ถ้าลบไม่ได้ให้ขึ้นข้อความ
                            if($remove==false)
                            {

                                $_SESSION['failed-remove'] = "<div class='error'>ลบไม่สำเร็จ!.</div><br>";
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die(); //หยุดทำงาน
                            }

                        }
                        
                    }
                    else
                    {
                        $image_name = $current_image;
                    }
                }
                else
                {
                    $image_name = $current_image;
                }

                // Update datebase
                $sql2 = "UPDATE category_db SET
                    title = '$title',
                    image_name = '$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";


                $res2 = mysqli_query($conn, $sql2);



                //redirect to manage category with message
                if($res2==true)
                {
                    //category update
                    $_SESSION['update'] = "<div class='success'>ข้อมูลอัปเดต.</div><br>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {

                    //failed to update :(
                    $_SESSION['update'] = "<div class='error'>อัปเดตข้อมูลไม่สำเร็จ.</div><br>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }             



        ?>
    </div>
</div>