<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

  <?php include('./db.sql.php') ?>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Mysejahteri</title>
    <meta name="robots" content="follow, index" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="format-detection" content="telephone=no" />

    <link rel="stylesheet" href="dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/style.css?v=1.0.2" />



</head>

<body>

    <?php

      $getdb = mysqli_select_db($mysqli, $db_db);

      $details= $_POST['submit-info'];
      $detailsArr = explode(' ', $details);
      // echo $detailsArr;

      for ($i = 0; $i < count($detailsArr); $i++) {
        echo $detailsArr[$i];
        echo "<br>";
      }

      $sql = "SELECT * FROM Customers WHERE customer_email = '$detailsArr[1]'";

      if ($result = $mysqli -> query($sql)) {
        $row = $result -> fetch_all(MYSQLI_ASSOC);
        $custID = $row[0]['customer_id'];
        $rand_tac = random_int(100000, 999999);
        if ($result->num_rows === 0) {
          echo "New user! Will create new record";
          // Perform insert query to create new customer record
          $sql2 = 
          "INSERT INTO Customers (customer_email, customer_name, customer_phoneNum, customer_status) 
          VALUES ('$detailsArr[1]', '$detailsArr[0]', {$_POST['phone']}, 0)
          ";
          if ($mysqli->query($sql2) === TRUE) {
            echo "<h4>New record created successfully</h4>";
          } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
          }

          $getID = "SELECT customer_id FROM Customers WHERE customer_email = '$detailsArr[1]'";
          if ($result = $mysqli -> query($sql)) {
            $row2 = $result -> fetch_all(MYSQLI_ASSOC);
            $custID2 = $row2[0]['customer_id'];
          }

          // Perform insert query to TAC table to create new record
          $sql3 = "INSERT INTO TAC (tacNum, customer_id) VALUES ($rand_tac, $custID2)";
          if ($mysqli->query($sql3) === TRUE) {
            echo "<h6>New TAC record created successfully</h6>";
          } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
          }

        } else {
          echo "User found! No new record created";

          // Perform UPDATE query to TAC table to update TAC number record for the existing user
          $sql4 = "UPDATE TAC SET tacNum = $rand_tac WHERE customer_id = $custID";
          if ($mysqli->query($sql4) === TRUE) {
            echo "<h6>Record updated successfully</h6>";
          } else {
            echo "Error: " . $sql . "<br>" . $mysqli->error;
          }
        }
      } 
    ?>

    <div class="app__container">
        <div class="app__wrapper">
            <div class="app__logo"><img src="dist/images/svg/cvd_logo.svg" alt="" /></div>
            <div class="app__headline">Enter your <span class="app__name_newln">6-digit TAC</span></div>
            <div class="app__headline"><?php echo $rand_tac ?></div>
            <div class="app__desc app__desc_tacno">
                <p class="app__desc_1">Once your number is verified, it cannot be further amended.</p>
            </div>
            <form action="scanner.php" method="POST">
                <div class="pin-wrapper">
                    <input type="text" data-role="pin" maxlength="1" class="pin-input">
                    <input type="text" data-role="pin" maxlength="1" class="pin-input">
                    <input type="text" data-role="pin" maxlength="1" class="pin-input">
                    <input type="text" data-role="pin" maxlength="1" class="pin-input">
                    <input type="text" data-role="pin" maxlength="1" class="pin-input">
                    <input type="text" data-role="pin" maxlength="1" class="pin-input">
                </div>
                <div class="form_app_submit_container">
                    <button type="submit" name="submitProfile" value="<?php echo $details ?>" class="form_app_submit btn_orange" onclick="location.href='scanner.php';">Complete <span class="next_arrow_icon"><img src="dist/images/svg/arrow_right_white.svg" alt=""></span></button>
                </div>
            </form>
        </div>
        <div class="app__artwork_name"><img src="dist/images/svg/cvd_artwork_tac.svg" alt=""></div>
    </div>

    <script src="dist/js/jquery-3.2.1.slim.min.js"></script>
    <script src="dist/js/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <script src="dist/js/pin.js"></script>
    <script src="dist/js/pin.js"></script>
    <script src="dist/js/app.js"></script>


</body>

</html>
