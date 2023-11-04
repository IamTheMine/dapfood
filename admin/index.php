<?php include('admin_part/menu.php'); ?>

    <div class="main-content">
        <div class="wrapper">
            <h1>Dashboard</h1>
            <br><br>
            <?php
                if(isset($_SESSION['login']))
                {

                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
                
            ?>
            <br><br>
            <div class="collum text-center">

            <?php
                
                $sql = "SELECT * FROM category_db";
                //ใช้เก็บผลลัพธ์ที่ได้รับจากการใช้ mysqli_query() ในการส่งคำสั่ง SQL ไปยัง MySQL
                $res = mysqli_query($conn, $sql);
                //เพื่อนับจำนวนแถว ส่งคำสั่ง SELECT ไปยัง MySQL
                $count = mysqli_num_rows($res);
            ?>
                <!-- แสดงค่า -->
                <h1><?php echo $count; ?></h1>
                <br />
                Categories
            </div>

            <div class="collum text-center">

                <?php
                    
                    $sql2 = "SELECT * FROM food_db";
                    
                    $res2 = mysqli_query($conn, $sql2);
                    
                    $count2 = mysqli_num_rows($res2);
                ?>

                <h1><?php echo $count2; ?></h1>
                <br />
                Foods
            </div>

            <div class="collum text-center">

                <?php
                        
                    $sql3 = "SELECT * FROM order_db";
                    
                    $res3 = mysqli_query($conn, $sql3);
                    
                    $count3 = mysqli_num_rows($res3);
                ?>
                <h1><?php echo $count3; ?></h1>
                <br />
                Total Order
            </div>

            <div class="collum text-center">
                
                <?php
                    //หาผลรวม (SUM) ของคอลัมน์ "total" จากตาราง "order_db ที่มีสถานะ delivered
                    $sql4 = "SELECT SUM(total) AS Total FROM order_db WHERE status='Delivered'";
                    
                    $res4 = mysqli_query($conn, $sql4);
                //ดึงข้อมูลจากผลลัพธ์
                    $row4 = mysqli_fetch_assoc($res4);
                
                    $total_revenue = $row4['Total'];

                ?>
                
                <h1>฿<?php echo $total_revenue; ?></h1>
                <br />
                Revenue Generated
            </div>

            <div class="clearfix"></div>

        </div>
    </div>

<?php include('admin_part/footer.php'); ?>