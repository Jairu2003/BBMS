<!DOCTYPE html>
<html>
<head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        #sidebar{position:relative;margin-top:-20px}
        #content{position:relative;margin-left:210px}
        @media screen and (max-width: 600px) {
            #content {
                position:relative;margin-left:auto;margin-right:auto;
            }
        }
        #he{
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            padding: 3px 7px;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            align:center
        }
    </style>
</head>
<body style="color:black">

<?php
include 'conn.php';
include 'session.php';

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    $limit = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    $count = $offset + 1;

    $sql = "SELECT * FROM contact_query LIMIT {$offset}, {$limit}";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo '<div class="table-responsive">
                <table class="table table-bordered" style="text-align:center">
                    <thead style="text-align:center">
                        <th style="text-align:center">S.no</th>
                        <th style="text-align:center">Name</th>
                        <th style="text-align:center">Email Id</th>
                        <th style="text-align:center">Mobile Number</th>
                        <th style="text-align:center">Message</th>
                        <th style="text-align:center">Posting Date</th>
                        <th style="text-align:center">Status</th>
                        <th style="text-align:center">Action</th>
                    </thead>
                    <tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>' . $count++ . '</td>
                    <td>' . htmlspecialchars($row['query_name']) . '</td>
                    <td>' . htmlspecialchars($row['query_mail']) . '</td>
                    <td>' . htmlspecialchars($row['query_number']) . '</td>
                    <td>' . htmlspecialchars($row['query_message']) . '</td>
                    <td>' . htmlspecialchars($row['query_date']) . '</td>';

            if ($row['query_status'] == 1) {
                echo '<td>Read<br></td>';
            } else {
                echo '<td><a href="query.php?id=' . $row['query_id'] . '" onclick="clickme(' . $row['query_id'] . ')"><b id="demo">Pending</b></a><br></td>';
            }

            echo '<td id="he" style="width:100px">
                    <a style="background-color:aqua" href="delete_query.php?id=' . $row['query_id'] . '"> Delete </a>
                  </td>
                  </tr>';
        }

        echo '</tbody>
              </table>
            </div>';
    }

    $sql1 = "SELECT COUNT(*) as total_records FROM contact_query";
    $result1 = $conn->query($sql1);
    $row = $result1->fetch_assoc();
    $total_records = $row['total_records'];
    $total_page = ceil($total_records / $limit);

    echo '<div class="table-responsive"style="text-align:center;align:center">
              <ul class="pagination admin-pagination">';

    if ($page > 1) {
        echo '<li><a href="query.php?page=' . ($page - 1) . '">Prev</a></li>';
    }

    for ($i = 1; $i <= $total_page; $i++) {
        if ($i == $page) {
            $active = "active";
        } else {
            $active = "";
        }
        echo '<li class="' . $active . '"><a href="query.php?page=' . $i . '">' . $i . '</a></li>';
    }

    if ($total_page > $page) {
        echo '<li><a href="query.php?page=' . ($page + 1) . '">Next</a></li>';
    }

    echo '</ul>
          </div>';
} else {
    echo '<div class="alert alert-danger"><b> Please Login First To Access Admin Portal.</b></div>';
    echo '<form method="post" name="" action="login.php" class="form-horizontal">
              <div class="form-group">
                <div class="col-sm-8 col-sm-offset-4" style="float:left">
                  <button class="btn btn-primary" name="submit" type="submit">Go to Login Page</button>
                </div>
              </div>
            </form>';
}

$conn->close();
?>

<script>
    function clickme(id) {
        if (confirm("Do you really Want to Read ?")) {
            document.getElementById("demo").innerHTML = "Read";
            <?php
            $que_id = $_GET['id'];
            $sql1 = "update contact_query set query_status='1' where query_id={$que_id}";$result = mysqli_query($conn, $sql1);
            ?>
        }
    }
</script>

</body>
</html>