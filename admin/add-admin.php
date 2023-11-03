<?php include('admin_part/menu.php'); ?>

<div class="main-content">
        <div class="wrapper">
            <h1>Add admin</h1>

            <br><br>

<?php
if(isset($_SESSION['add']))
{
    echo $_SESSION['add'];
    unset($_SESSION['add']);
}
?>


            <form action="" method="POST">

                <table class="tbl-am">
                    <tr>
                        <td>Full Name: </td>
                        <td>
                            <input type ="text" name ="full_name" placeholder ="Enter Your Name">
                        </td>
                    </tr>

                    <tr>
                        <td>Username: </td>
                        <td>
                            <input type ="text" name ="username" placeholder ="Your Username">
                        </td>
                    </tr>

                    <tr>
                        <td>Password: </td>
                        <td>
                            <input type ="password" name ="password" placeholder ="Enter Your Password">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type ="submit" name ="submit" value ="Add" class ="btn-secondary">
                        </td>
                    </tr>
                </table>

            </form>


        </div>
</div>

<?php include('admin_part/footer.php'); ?>


<?php 
    //บันทึกข้อมูลลง database
    //ตรวจสอบว่ามีการกดปุ่ม "submit" หรือไม่
    
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //รหัสถูกจำกัดด้วย md5

        $sql = "INSERT INTO admin_1 SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";


        $res = mysqli_query($conn, $sql) or die (mysqli_error($conn));


        if($res==TRUE)
        {
            //echo "เข้าสู่ระบบ";
            $_SESSION['add'] = "เข้าสู่ระบบสำเร็จ";
            //เปลี่ยนเส้นทางไปยัง manage admin
            header("location:".SITEURL.'admin/manage-admin.php');

        }
        else
        {
            //echo "เข้าสู่ระบบไม่ผ่าน!!!";
            $_SESSION['add'] = "เข้าสู่ระบบไม่สำเร็จ!!";
            //เปลี่ยนเส้นทางไปยัง add admin
            header("location:".SITEURL.'admin/add-admin.php');
        }

    }
    
?>