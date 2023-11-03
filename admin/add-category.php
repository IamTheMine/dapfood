<?php include('admin_part/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Add Category</h1>

            <br /><br />
            <?php

                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }

            ?>

            <br><br>

            <!--add category form starts -->
            <form action="" method="POST" enctype="multipart/form-data"> 
    <!-- enctype คือคำสั่งสำหรับเข้ารหัสไฟล์ เพื่อทำให้ไฟล์สามารถส่งผ่านฟอร์มแบบ POST ได้ ใช้งานร่วมกับ input submit -->
                <table class="tbl-full">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Category Title">
                        </td>

                        <tr>
                            <td>Select Image: </td>
                            <td>
                                <input type="file" name="image">
                            </td>
                        </tr>
                        <tr>
                            <td>Featured: </td>
                            <td>
                                <input type="radio" name="featured" value="Yes"> Yes
                                <input type="radio" name="featured" value="No"> No
                            </td>
                        </tr>

                        <tr>
                            <td>Active: </td>
                            <td>
                                <input type="radio" name="active" value="Yes"> Yes
                                <input type="radio" name="active" value="No"> No
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                            </td>
                        </tr>
                    </tr>
                </table>    

            </form>
                <?php

                    if(isset($_POST['submit']))
                    {

                        $title = $_POST['title'];

                        if(isset($_POST['featured']))
                        {

                            $featured = $_POST['featured'];
                        }
                        else
                        {

                            $featured = "No";
                        }
                        
                        if(isset($_POST['active']))
                        {

                            $active = $_POST['active'];
                        }
                        else
                        {
                            $active = "No";
                        }

                        //$_FILES สำหรับรับค่าตัวแปรชนิด file
                        //print_r($_FILES['image']);
                        //แสดงข้อความและหยุดการทำงานของ script die() เป็น alias ของ exit()
                        if(isset($_FILES['image']['name']))
                        {
                            //upload the image
                            //อัปโหลดภาพ เราต้องการชื่อภาพ เส้นทางต้นทาง และเส้นทางปลายทาง
                            $image_name = $_FILES['image']['name'];
                            
                            if($image_name != "")
                            {

                                
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

                                    header('location:'.SITEURL.'admin/add-category.php');
                                    //stop process
                                    die();
                                }
                        
                            }
                        }
                        else
                        {

                            $image_name = "";
                        }

                        $sql = "INSERT INTO category_db SET
                            title = '$title',
                            image_name='$image_name',
                            featured = '$featured',
                            active = '$active'
                        ";


                            $res = mysqli_query($conn, $sql);

                       
                        if($res==true)
                        {
                        
                            $_SESSION['add'] = "<div class= 'success'>เพิ่มข้อมูลสำเร็จ!!.</div><br><br>";
        
                            header('location:'.SITEURL.'admin/manage-category.php');
                        }
                        else
                        {    //Failed to Add Category
                            $_SESSION['add'] = "<div class= 'error'>เพิ่มข้อมูลไม่สำเร็จ.</div><br><br>";
                        
                            header('location:'.SITEURL.'admin/add-category.php');
                        }
                              
                    }

                ?>


        </div>
    
    </div>


<?php include('admin_part/footer.php'); ?>