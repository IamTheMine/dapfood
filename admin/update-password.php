<?php include('admin_part/menu.php'); ?>
<div class="main-content">
    <div class-"wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }


        ?>


         <form action=" method="POST">
            <table class= "tbl-full">
                <tr>
                    <td>Current Password: </td>
                     <td>
                        <input type="password" name="current_password" placeholder-"Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password:</td>
                     <td>
                        <input type="password" name="new_password" placeholder-"New Password">
                     </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                                                 I
                    <td>
                        <input type="password" name="confirm_password" placeholder="confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password">
                    </td>
                </tr>

            </table>
         </form>
    </div>
</div>

<?php

        if(isset($_POST['submit']))
        {

            $id=$_POST['id'];
            $current_password = md5($_POST['current_password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);


            $sql = "SELECT * FROM admin_1 WHERE id=$id AND password='$current_password'";


            $res = mysqli_query($conn, $sql);

            if($res==true)
            {

                $count=mysqli_num_rows($res);

                if($count==1)
                {
                    //echo "User Found";

                    if($new_password==$confirm_password)
                    {
                        $sql2 = "UPDATE admin_1 SET
                            password='$new_password'
                            WHERE id=$id
                            ";

                            $res2 = mysqli_query($conn, $sql2);

                            if($res2==true)
                            {
                                
                                //display success massage

                                $_SESSION['change-pass'] = "<div class='success'>Password Changed Successfully. </div>";

                                header('location:'.SITEURL.'admin/manage-admin.php');
                            }
                            else
                            {
                                $_SESSION['change-pass'] = "<div class='success'>Failed to Changed Successfully. </div>";

                                header('location:'.SITEURL.'admin/manage-admin.php');
                            }
                    }
                    else
                    {

                        $_SESSION['pass-not-match'] = "<div class='error'>Password Did not Patch.</div>";

                        header('location:'.SITEURL.'admin/manage-admin.php');
                    }
                }
                else
                {

                    $_SESSION['user-not-found'] = "<div class='error'>User Not Found. </div>";

                    header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

        }

?>



<?php include('admin_part/footer.php'); ?>
