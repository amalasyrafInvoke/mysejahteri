<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>

  <?php
  include('./db.sql.php');
  // Start the session
  session_start();
  ?>


  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Mysejahteri</title>
  <meta name="robots" content="follow, index" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
  <meta name="format-detection" content="telephone=no" />


  <link rel="stylesheet" href="dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" type="text/css" href="dist/css/style.css?v=1.0.5" />



</head>

<body class="app__card">

  <?php
  $getdb = mysqli_select_db($mysqli, $db_db);

  $custEmail = $_SESSION['globalCustEmail'];
  $custName = $_SESSION['globalCustName'];
  $custID =  $_SESSION['globalCustID'];

  $locationSelected = $_POST['location-list'];
  $checkinInfo = null;
  $dateCreated = null;
  $date = null;
  $time = null;

  // fetch Check In Info
  function fetchCheckInInfo() {

    global $custEmail;
    global $mysqli;
    global $checkinInfo;
    global $dateCreated;
    global $date;
    global $time;

    $sql = "SELECT * FROM Checkin INNER JOIN Customers ON Customers.customer_id = Checkin.customer_id INNER JOIN Location ON Checkin.location_id = Location.location_id INNER JOIN Company ON Location.company_id = Company.company_id WHERE Customers.customer_email = '$custEmail' ORDER BY Checkin.checkin_date_created DESC";

    if ($result = $mysqli -> query($sql)) {
      $row = $result -> fetch_all(MYSQLI_ASSOC);
      $checkinInfo = $row[0];
      $dateCreated = $row[0]['checkin_date_created'];
      //to split and format datetime into date & time
      $datetime = new DateTime($dateCreated);
      $date = $datetime->format('j F Y');
      $time = $datetime->format('g:i a');

      // print_r($checkinInfo);
    }
  }

  $insertCheckInSql = "INSERT INTO Checkin (location_id, customer_id) VALUES ($locationSelected, $custID)";

  echo $insertCheckInSql;

  if ($mysqli->query($insertCheckInSql) === TRUE) {
    echo "<h4>New record created successfully</h4>";
    fetchCheckInInfo();
  } else {
    echo "Error: " . $insertCheckInSql . "<br>" . $mysqli->error;
  }

  ?>

  <div class="app__container">
    <div class="app__cards_wrapper scanner_active">
      <div class="app__cards_container">
        <div class="card_title title_checkin">Check-In Information</div>

        <div class="horizontal_card card_scanner">
          <div class="card_scanner_container">
            <div class="card_scanner_front">
              <div class="voucher_container">
                <a href="#" class="cancel_btn cancel_scanner"><img src="dist/images/cancel_blue.png" alt="" /></a>
                <div class="thankyou_container">
                  <div class="thankyou_title text-white mt-3">Thank You</div>
                  <div class="thankyou_company_branch">
                    <div class="thankyou_company"><?php echo $checkinInfo['company_name'] . " - " . $checkinInfo['company_branch'] ?></div>
                    <div class="thankyou_branch"><?php echo $checkinInfo['state'] ?></div>
                  </div>
                  <div class="thankyou_datetime_checkin">
                    <div class="thankyou_desc">You checked in at the location at</div>
                    <div class="thankyou_datetime"><span class="thankyou_time"><?php echo $time ?> </span>, <span class="thankyou_date"><?php echo $date ?></span></div>
                  </div>
                  <form action="scanner.php" method="POST" class="thankyou_title text-white mt-3">
                    <input style="background-color: inherit; color:white;" type="submit" value="Back">
                  </form>
                </div>

              </div>
            </div>
          </div>
        </div>


      </div>
      <!-- <div class="navbar_btm_container">
        <div class="navbar_menu navbar_info">
          <div class="navbar_icon icon_info"></div>
          <div class="navbar_caption">Info</div>
        </div>
        <div class="navbar_menu navbar_profile">
          <div class="navbar_icon icon_profile"></div>
          <div class="navbar_caption">Profile</div>
        </div>
        <div class="navbar_menu navbar_scanner">
          <div class="navbar_icon icon_scanner"></div>
        </div>
        <div class="navbar_menu navbar_voucher">
          <div class="navbar_icon icon_voucher"></div>
          <div class="navbar_caption">Voucher</div>
        </div>
        <div class="navbar_menu navbar_activity">
          <div class="navbar_icon icon_activity"></div>
          <div class="navbar_caption">Activity</div>
        </div>
      </div> -->
    </div>
  </div>

  <script src="dist/js/jquery-3.2.1.slim.min.js"></script>
  <script src="dist/js/popper.min.js"></script>
  <script src="dist/js/bootstrap.min.js"></script>
  <script src="dist/js/bootstrap-datepicker.min.js"></script>
  <script src="dist/js/app.js"></script>


  <script>
    var green_dates = ["1/5/2020", "4/5/2020", "5/5/2020", "8/5/2020", "3/5/2020", "19/5/2020", "20/5/2020", "22/5/2020", "27/5/2020", "1/6/2020"];
    var yellow_dates = ["2/5/2020", "12/5/2020", "13/5/2020", "14/5/2020", "15/5/2020", "18/5/2020", "23/5/2020", "23/5/2020"];
    var orange_dates = ["6/5/2020", "7/5/2020", "11/5/2020", "17/5/2020", "21/5/2020", "25/5/2020", "26/5/2020", "29/5/2020"];
    var red_dates = ["3/5/2020", "9/5/2020", "10/5/2020", "16/5/2020", "24/5/2020", "28/5/2020", "30/5/2020", "31/5/2020"];
    $('#datepicker_container').datepicker({
      maxViewMode: 0,
      format: "dd/mm/yyyy",
      beforeShowDay: function(date) {
        var d = date;
        var curr_date = d.getDate();
        var curr_month = d.getMonth() + 1; //Months are zero based
        var curr_year = d.getFullYear();
        var formattedDate = curr_date + "/" + curr_month + "/" + curr_year

        if ($.inArray(formattedDate, green_dates) != -1) {
          return {
            classes: 'green_dates'
          };
        }
        if ($.inArray(formattedDate, yellow_dates) != -1) {
          return {
            classes: 'yellow_dates'
          };
        }
        if ($.inArray(formattedDate, orange_dates) != -1) {
          return {
            classes: 'orange_dates'
          };
        }
        if ($.inArray(formattedDate, red_dates) != -1) {
          return {
            classes: 'red_dates'
          };
        }
        return;
      }
    });
  </script>


  <script>
    $(".edit_profile_link").click(function() {
      $(this).parents(".card_profile_container").toggleClass("flipper");
    });
    $(".cancel_profile").click(function() {
      $(this).parents(".card_profile_container").toggleClass("flipper");
    });
    $(".submit_profile").click(function() {
      $(this).parents(".card_profile_container").toggleClass("flipper");
    });



    $(".scanner_icon").click(function() {
      $(this).parents(".card_scanner_container").toggleClass("flipper");
    });
    $(".cancel_scanner").click(function() {
      $(this).parents(".card_scanner_container").toggleClass("flipper");
    });

    $(".datepicker tbody td").click(function() {
      $(this).parents(".card_activity_container").toggleClass("flipper");
    });
    $(".cancel_activity").click(function() {
      $(this).parents(".card_activity_container").toggleClass("flipper");
    });



    $('.navbar_info').click(function() {
      $('.app__cards_wrapper').removeClass('info_active');
      $('.app__cards_wrapper').removeClass('profile_active');
      $('.app__cards_wrapper').removeClass('scanner_active');
      $('.app__cards_wrapper').removeClass('voucher_active');
      $('.app__cards_wrapper').removeClass('activity_active');
      $('.app__cards_wrapper').addClass('info_active');
    });
    $('.navbar_profile').click(function() {
      $('.app__cards_wrapper').removeClass('info_active');
      $('.app__cards_wrapper').removeClass('profile_active');
      $('.app__cards_wrapper').removeClass('scanner_active');
      $('.app__cards_wrapper').removeClass('voucher_active');
      $('.app__cards_wrapper').removeClass('activity_active');
      $('.app__cards_wrapper').addClass('profile_active');
    });
    $('.navbar_scanner').click(function() {
      $('.app__cards_wrapper').removeClass('info_active');
      $('.app__cards_wrapper').removeClass('profile_active');
      $('.app__cards_wrapper').removeClass('scanner_active');
      $('.app__cards_wrapper').removeClass('voucher_active');
      $('.app__cards_wrapper').removeClass('activity_active');
      $('.app__cards_wrapper').addClass('scanner_active');
    });
    $('.navbar_voucher').click(function() {
      $('.app__cards_wrapper').removeClass('info_active');
      $('.app__cards_wrapper').removeClass('profile_active');
      $('.app__cards_wrapper').removeClass('scanner_active');
      $('.app__cards_wrapper').removeClass('voucher_active');
      $('.app__cards_wrapper').removeClass('activity_active');
      $('.app__cards_wrapper').addClass('voucher_active');
    });
    $('.navbar_activity').click(function() {
      $('.app__cards_wrapper').removeClass('info_active');
      $('.app__cards_wrapper').removeClass('profile_active');
      $('.app__cards_wrapper').removeClass('scanner_active');
      $('.app__cards_wrapper').removeClass('voucher_active');
      $('.app__cards_wrapper').removeClass('activity_active');
      $('.app__cards_wrapper').addClass('activity_active');
    });
    $('.btn_view_activity').click(function() {
      $('.app__cards_wrapper').removeClass('info_active');
      $('.app__cards_wrapper').removeClass('profile_active');
      $('.app__cards_wrapper').removeClass('scanner_active');
      $('.app__cards_wrapper').removeClass('voucher_active');
      $('.app__cards_wrapper').removeClass('activity_active');
      $('.app__cards_wrapper').addClass('activity_active');
    });


    $('.card_info .btn_dismiss ').click(function() {
      $('.app__cards_wrapper').removeClass('info_active');
      $('.app__cards_wrapper').removeClass('profile_active');
      $('.app__cards_wrapper').removeClass('scanner_active');
      $('.app__cards_wrapper').removeClass('voucher_active');
      $('.app__cards_wrapper').removeClass('activity_active');
      $('.app__cards_wrapper').addClass('scanner_active');
    });
    $('.card_profile .btn_dismiss ').click(function() {
      $('.app__cards_wrapper').removeClass('info_active');
      $('.app__cards_wrapper').removeClass('profile_active');
      $('.app__cards_wrapper').removeClass('scanner_active');
      $('.app__cards_wrapper').removeClass('voucher_active');
      $('.app__cards_wrapper').removeClass('activity_active');
      $('.app__cards_wrapper').addClass('scanner_active');
    });
  </script>


</body>

</html>