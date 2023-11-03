<?php include('admin_part/menu.php'); ?>
<div class="main-content">
        <div class="wrapper">
            <h1>Manage Admin</h1>

            <br /> 

<?php
    if(isset($_SESSION['add']))
    {
        echo $_SESSION['add']; //โชว์ชื่อ admin
        unset($_SESSION['add']); //ลบชื่อออก
    }

    if(isset($_SESSION['delete']))
    {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }

    if(isset($_SESSION['update']))
    {
        echo $_SESSION['update'];
        unset($_SESSION['update']);
    }

    if(isset($_SESSION['user-not-found']))
    {
        echo $_SESSION['user-not-found'];
        unset($_SESSION['user-not-found']);
    }

    if(isset($_SESSION['pass-not-found']))
    {
        echo $_SESSION['pass-not-found'];
        unset($_SESSION['pass-not-found']);
    }

    if(isset($_SESSION['change-pass']))
    {
        echo $_SESSION['change-pass'];
        unset($_SESSION['change-pass']);
    }
?>
<br><br><br>


            <!-- ปุ่ม -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>
            
            <br /><br /><br />

            <table class="tbl-full">
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Actions pw</th> <!-- password -->
                </tr>

                <?php 

                    $sql = "SELECT * FROM admin_1";
                    $res = mysqli_query($conn, $sql);

                    if($res==TRUE)
                    {
                        //นับแถวว่ามีข้อมูลอยู่รึป่าว
                        $count = mysqli_num_rows($res);

                        $sn=1;

                        if($count>0)
                        {
    
                             //ใช้ whlie loop เพื่อรับข้อมูลทั้งหมดจากฐานข้อมูล\
                             // และในขณะที่ลูปจะทํางานตราบเท่าที่เรามีข้อมูลในฐานข้อมูล

                            while($rows=mysqli_fetch_assoc($res))
                            {
                                //รับข้อมูลส่วนบุคคล
                                $id=$rows['id'];
                                $full_name=$rows['full_name'];
                                $username=$rows['username'];

                                ?>

                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $username; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                            <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                            <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                                        </td>
                                    </tr>

                                <?php
                            }
                        }
                        else
                        {

                        }
                    }
                ?>

            </table>

        </div>
    </div>

<?php include('admin_part/footer.php'); ?>  