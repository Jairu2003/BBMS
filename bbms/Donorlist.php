<!-- blood_donor_names.php -->
<h2>Blood Donor Names</h2>

<div class="row">
    <?php
    include 'conn.php';
    $sql= "select * from donor_details join blood where donor_details.donor_blood=blood.blood_id order by rand() limit 6";
    $result=mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
    ?>
    <div class="col-lg-4 col-sm-6 portfolio-item">
        <br>
        <div class="card" style="width:300px">
            <img class="card-img-top" src="image\blood_drop_logo.jpg" alt="Card image" style="width:100%;height:300px">
            <div class="card-body">
                <h3 class="card-title"><?php echo $row['donor_name']; ?></h3>
                <p class="card-text">
                    <b>Blood Group : </b> <b><?php echo $row['blood_group']; ?></b><br>
                    <b>Mobile No. : </b> <?php echo $row['donor_number']; ?><br>
                    <b>Gender : </b><?php echo $row['donor_gender']; ?><br>
                    <b>Age : </b> <?php echo $row['donor_age']; ?><br>
                    <b>Address : </b> <?php echo $row['donor_address']; ?><br>
                </p>
            </div>
        </div>
    </div>
    <?php 
        }
    }
    ?>
</div>
