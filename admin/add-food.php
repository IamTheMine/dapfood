<?php include('admin_part/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>

        <br><br>

        <?php
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-full">

                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select Image: </td>
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

                                //ถ้าจำนวนมากกว่าศูนย์มีข้อมูล แต่ถ้าไม่ ก็ไม่มี
                                if($count>0)
                                {
                                    //we have
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //รับรายละเอียด
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title; ?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //we do not have category
                                    ?>
                                    <option value="0">ไม่พบข้อมูล</option>
                                    <?php
                                }


                            ?>
                            <option value="1">Food</option>
                            <option value="1">Snacks</option>
                        </select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>




            </table>

        </form>

        <?php

            if(isset($_POST['submit']))
            {


                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                
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

                if(isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];


                    if($image_name!="")
                    {

                        $src = $_FILES['image']['tmp_name'];

                        $dst = "../images/food/".$image_name;

                        $upload = move_uploaded_file($src, $dst);


                        if($upload==false)
                        {


                            $_SESSION['upload'] = "<div class='error'>อัปโหลดไม่สำเร็จ.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            die();
                        }

                    }
                }
                else
                {
                    $image_name = "";
                }



                $sql2 = "INSERT INTO food_db SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";


                $res2 = mysqli_query($conn, $sql2);



                if($res2==true)
                {

                    $_SESSION['add'] = "<div class='success'>รับข้อมูลสำเร็จ.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {

                    $_SESSION['add'] = "<div class='error'>รับข้อมูลไม่สำเร็จ.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

            }

        ?>

    </div>
</div>

<?php include('admin_part/footer.php'); ?>