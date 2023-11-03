<?php include('admin_part/menu.php'); ?>

<?php

    if(isset($_GET['id']))
    {

        $id = $_GET['id'];


        $sql2 = "SELECT * FROM food_db WHERE id=$id";

        $res2 = mysqli_query($conn, $sql2);


        $row2 = mysqli_fetch_assoc($res2);

        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    }
    else
    {

        header('location:'>SITEURL.'admin/manage-food.php');
    }

?>

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

                header('location:'>SITEURL.'admin/manage-category.php');
            }


        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-full">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>" >
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                            if($current_image =="")
                            {
                                echo "<div class='error'>รูปภาพไม่พร้อมใช้งาน.</div><br>";
                                
                            }
                            else
                            {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                                <?php
                                
                            }

                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Select New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                            <?php 

                                $sql = "SELECT * FROM food_db WHERE active='Yes'";

                                $res = mysqli_query($conn, $sql);

                                $count = mysqli_num_rows($res);


                                if($count>0)
                                {
                                    
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        $category_title = $row['title'];
                                        $category_id = ['id'];
                                        
                                        ?>
                                            <option <?php if($current_category==$current_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo "<option value='0'>ไม่พบข้อมูล</option>";
                                }
                            
                            ?>

                        </select>
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
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
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
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];

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

                        $ext = end(explode('.', $image_name));

                        $image_name = "Food_Name-".rand(000,9999).'.'.$ext;

                        $src_path = $_FILES['image']['tmp_name'];

                        $dest_part = "../images/food/".$image_name;

                        //อัพโหลดภาพ
                        $upload = move_uploaded_file($src_path, $dest_part);

                        //ตรวจสอบว่ารูปภาพถูกอัพโหลดหรือไม่
                        //และถ้าอัปโหลดไม่สำเร็จ ก็จะหยุดอัปโหลดและแสดงข้อความขึ้นมา

                        if($upload==false)
                        {
                            //set message
                            $_SESSION['upload'] = "<div class='error'>อัปโหลดไม่สำเร็จ.</div><br>";

                            header('location:'.SITEURL.'admin/manage-food.php');
                            //stop process
                            die();
                        }

                        //remove current image if available
                        if($current_image!="")
                        {
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);


                            //ตรวจสอบว่ารูปได้ลบแล้วหรือป่าว
                            //ถ้าลบไม่ได้ให้ขึ้นข้อความ
                            if($remove==false)
                            {

                                $_SESSION['remove-failed'] = "<div class='error'>ลบไม่สำเร็จ!.</div><br>";
                                header('location:'.SITEURL.'admin/manage-food.php');
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
                $sql3 = "UPDATE food_db SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    WHERE id=$id
                ";


                $res3 = mysqli_query($conn, $sql3);

                //redirect to manage category with message
                if($res3==true)
                {
                    //category update
                    $_SESSION['update'] = "<div class='success'>ข้อมูลอัปเดต.</div><br>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {

                    //failed to update :(
                    $_SESSION['update'] = "<div class='error'>อัปเดตข้อมูลไม่สำเร็จ.</div><br>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }             



        ?>
    </div>
</div>