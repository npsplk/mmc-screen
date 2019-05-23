<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="ie=edge" http-equiv="x-ua-compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A simple jQuery slide plugin.">
    <meta name="keywords"
          content="HTML, CSS, JS, JavaScript, jQuery plugin, slide, front-end, frontend, web development">

    <meta http-equiv="refresh" content="60">
    <meta name="author" content="Fengyuan Chen">
    <title>Bus Schedule </title>
    <link href="img/favicon.ico" rel="shortcut icon"/>
    <link href="css/slider.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bay_view.css" rel="stylesheet">
    <link href="css/responsive2.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i');
    </style>
</head>

<?php
include_once("model/bay_view.php");
?>
<body onLoad="startTime()">
<div class="Screen-header bay-screen">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="slider" data-toggle="slider">
                    <div class="slider-content">
                        <!-- English -->
                        <div>
                            <div class="bay-no1">
                                <h1>B<?php echo $bay_id; ?></h1>
                            </div>
                            <div class="lines">
                                <div class="location">
                                    <div class="name">
                                        <h2><?php
                                            if (count($result_schedule['screenRows']) > 0) {
                                                $destination = "";
                                                $route = "";
                                                foreach ($result_schedule['screenRows'] as $row) {
                                                    $destination = $row['destination'][0];
                                                    $route=$row['route'];
                                                }
                                                echo $destination . " - " . $route;
                                            } else {

                                            }
                                            ?> </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="bay-no">
                                <div class="name">
                                    <h2>DEPARTURES </h2>
                                </div>
                            </div>
                            <div class="bay-time">
                                <div class="date-time">
                                    <h2 id="time_txt_en"></h2>
                                </div>
                            </div>
                            <div class="bay-time">
                                <div class="date-time">
                                    <h2> <?php echo $current_date; ?></h2>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th><span class="heading">TIME</span></th>
                                    <th><span class="heading">STATUS</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (count($result_schedule) > 0) {
                                    foreach ($result_schedule['screenRows'] as $row) {
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="time"><?php echo $row['time']; ?> </span>
                                            </td>
                                            <td><span class="available"><?php echo $row['status'][0]; ?> </span></td>
                                        </tr>

                                        <?php

                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td class="empty-info" colspan="5">No scheduled journey on this route .</td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Sinhala -->
                        <div>
                            <div class="bay-no1">
                                <h1>B<?php echo $bay_id; ?></h1>
                            </div>
                            <div class="lines">
                                <div class="location">
                                    <div class="name">
                                        <h2><?php
                                            if (count($result_schedule['screenRows']) > 0) {
                                                $destination = "";
                                                $route = "";
                                                foreach ($result_schedule['screenRows'] as $row) {
                                                    $destination = $row['destination'][1];
                                                    $route=$row['route'];
                                                }
                                                echo $destination . " - " . $route;
                                            } else {

                                            }
                                            ?> </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="bay-no">
                                <div class="name">
                                    <h2>පිටත්වීම්</h2>
                                </div>
                            </div>
                            <div class="bay-time">
                                <div class="date-time">
                                    <h2 id="time_txt_si"></h2>
                                </div>
                            </div>
                            <div class="bay-time">
                                <div id="date-time">
                                    <h2> <?php echo $current_date; ?></h2>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th><span class="heading">වේලාව</span></th>
                                    <th><span class="heading">වර්තමාන තත්වය</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                if (count($result_schedule) > 0) {
                                    foreach ($result_schedule['screenRows'] as $row) {
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="time"><?php echo $row['time']; ?> </span>
                                            </td>
                                            <td><span class="available"><?php echo $row['status'][1]; ?> </span></td>
                                        </tr>

                                    <?php }
                                } else {
                                    ?>

                                    <tr>
                                        <td class="empty-info" colspan="5">අද දින සඳහා නියමිත ගමන්වාර නොමැත.</td>

                                    </tr>

                                    <?php
                                } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- Tamil -->
                        <div>
                            <div class="bay-no1">
                                <h1>B<?php echo $bay_id; ?></h1>
                            </div>
                            <div class="lines">
                                <div class="location">
                                    <div class="name">
                                        <h2><?php
                                            if (count($result_schedule['screenRows']) > 0) {
                                                $destination = "";
                                                $route = "";
                                                foreach ($result_schedule['screenRows'] as $row) {
                                                    $destination = $row['destination'][2];
                                                    $route=$row['route'];
                                                }
                                                echo $destination . " - " . $route;
                                            } else {

                                            }
                                            ?> </h2>
                                    </div>
                                </div>
                            </div>
                            <div class="bay-no">
                                <div class="name tamiltext">
                                    <h2>புறப்பாடுகள் </h2>
                                </div>
                            </div>
                            <div class="bay-time">
                                <div class="date-time">
                                    <h2 id="time_txt_ta"></h2>
                                </div>
                            </div>
                            <div class="bay-time">
                                <div class="date-time">
                                    <h2> <?php echo $current_date; ?></h2>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th><span class="heading heading-bay">நேரம்</span></th>
                                    <th><span class="heading heading-bay">தற்போதைய நிலை</span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (count($result_schedule) > 0) {
                                    foreach ($result_schedule['screenRows'] as $row) {
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="time"><?php echo $row['time']; ?> </span>
                                            </td>
                                            <td><span class="available"><?php echo $row['status'][2]; ?> </span></td>
                                        </tr>

                                    <?php }
                                } else {
                                    ?>

                                    <tr>
                                        <td class="empty-info" colspan="5">இன்று திட்டமிடப்பட்ட விமானங்கள் இல்லை</td>

                                    </tr>

                                    <?php
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/slider2.js"></script>
    <script>
        function startTime() {
            var today = new Date();
            var h = today.getHours();
            var m = today.getMinutes();
            var s = today.getSeconds();
            m = checkTime(m);
            s = checkTime(s);
            var postfix = " AM";

            if (h == 12) {
                postfix = " PM";
            } else if (h > 12) {
                h = h % 12;
                postfix = " PM";
            }
            document.getElementById('time_txt_en').innerHTML =
                h + ":" + m + ":" + s + " " + postfix;

            document.getElementById('time_txt_si').innerHTML =
                h + ":" + m + ":" + s + " " + postfix;

            document.getElementById('time_txt_ta').innerHTML =
                h + ":" + m + ":" + s + " " + postfix;


            var t = setTimeout(startTime, 500);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i
            }
            ;  // add zero in front of numbers < 10
            return i;
        }
    </script>
</body>
</html>