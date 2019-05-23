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
    <title>Train Schedule Summary</title>
    <link href="img/favicon.ico" rel="shortcut icon"/>
    <link href="css/slider.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">
    <link href="fonts/icofont.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i');
    </style>
</head>

<?php
include_once("model/train_summary.php");
?>
<body onLoad="startTime()">
<div class="Screen-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1 col-sm-1 col-xs-1">
                <div class="logo">
                    <img class="" src="img/logo.png" alt="">
                </div>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-7">
                <div class="slider" data-toggle="slider">
                    <div class="slider-content">
                        <div>
                            <div class="name">
                                <h2>DEPARTURES - TRAINS</h2>
                            </div>
                        </div>
                        <div>
                            <div class="name">
                                <h2>පිටත්වීම් - දුම්රිය</h2>
                            </div>
                        </div>
                        <div>
                            <div class="name">
                                <h2>புறப்பாடு - ரயில்</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-4">
                <div class="date-time">
                    <h2> <?php echo $current_date; ?></h2>
                    <h2>
                        <div id="txt"></div>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="slider fullscreen" data-toggle="slider">
    <div class="slider-content">
        <div>
            <table class="table table-hover">
                <thead>
                <tr>

                    <th><span class="heading">TIME</span></th>
                    <th><span class="heading">DESTINATION</span></th>
                    <th><span class="heading">PLATFORM</span></th>
                    <th><span class="heading">STATUS</span></th>
                </tr>
                </thead>
                <tbody>
                <?php

                if (count($result_schedule['screenRows']) > 0) {
                    foreach ($result_schedule['screenRows'] as $row) {


                        $route_type = $row['transportType'];
                        if ($route_type == 'train') {
                            $bay_name = "P01";
                            $route = "Train";
                            $class_name = "icofont-train-line";

                        } else {
                            $bay_name = "B" . $row['bay'][0];
                            $route = $row['route'];
                            $class_name = "icofont-bus-alt-1";
                        }
                        ?>
                        <tr>
                            <td>
                                <span class="time"><?php echo $row['time']; ?> </span>
                            </td>
                            <td><span class="destination"><?php echo $row['destination'][0]; ?> </span></td>
                            <td><span class="bus-no"><?php echo $bay_name; ?> </span></td>
                            <td><span class="available"><?php echo $row['status'][0]; ?> </span></td>
                        </tr>

                    <?php }
                } else {
                    ?>

                    <tr>
                        <td colspan="5">No scheduled journey on this route. </td>

                    </tr>

                    <?php
                }

                ?>

                </tbody>
            </table>
        </div>
        <div>
            <table class="table table-hover">
                <thead>
                <tr>

                    <th><span class="heading">වේලාව</span></th>
                    <th><span class="heading">ගමනාන්තය</span></th>

                    <th><span class="heading">වේදිකාව</span></th>
                    <th><span class="heading">වර්තමාන තත්වය</span></th>
                </tr>
                </thead>
                <tbody>
                <?php

                if (count($result_schedule['screenRows']) > 0) {
                    foreach ($result_schedule['screenRows'] as $row) {


                        $route_type = $row['transportType'];
                        if ($route_type == 'train') {
                            $bay_name = "P01";
                            $route = "දුම්රිය";
                            $class_name = "icofont-train-line";

                        } else {
                            $bay_name = "B" . $row['bay'][0];
                            $route = $row['route'];
                            $class_name = "icofont-bus-alt-1";
                        }
                        ?>
                        <tr>
                            <td>
                                <span class="time"><?php echo $row['time']; ?> </span>
                            </td>
                            <td><span class="destination"><?php echo $row['destination'][1]; ?> </span></td>
                            <td><span class="bus-no"><?php echo $bay_name; ?> </span></td>
                            <td><span class="available"><?php echo $row['status'][1]; ?> </span></td>
                        </tr>

                    <?php }
                } else {
                    ?>

                    <tr>
                        <td colspan="5">අද දින සඳහා නියමිත ගමන්වාර නොමැත.</td>

                    </tr>

                    <?php
                } ?>
                </tbody>
            </table>
        </div>
        <div>
            <table class="table table-hover">
                <thead>
                <tr>

                    <th><span class="heading">நேரம்</span></th>
                    <th><span class="heading">முடிவிடம்</span></th>

                    <th><span class="heading">விரிகுடா</span></th>
                    <th><span class="heading">நிலை</span></th>
                </tr>
                </thead>
                <tbody>
                <?php
                if (count($result_schedule['screenRows']) > 0) {
                    foreach ($result_schedule['screenRows'] as $row) {


                        $route_type = $row['transportType'];
                        if ($route_type == 'train') {
                            $bay_name = "P01";
                            $route = "ரயில்";
                            $class_name = "icofont-train-line";

                        } else {
                            $bay_name = "B" . $row['bay'][0];
                            $route = $row['route'];
                            $class_name = "icofont-bus-alt-1";
                        }
                        ?>
                        <tr>
                            <td>
                                <span class="time"><?php echo $row['time']; ?> </span>
                            </td>
                            <td><span class="destination"><?php echo $row['destination'][2]; ?> </span></td>
                            <td><span class="bus-no"><?php echo $bay_name; ?> </span></td>
                            <td><span class="available"><?php echo $row['status'][2]; ?> </span></td>
                        </tr>

                    <?php }
                } else {
                    ?>

                    <tr>
                        <td colspan="5">இன்று திட்டமிடப்பட்ட விமானங்கள் இல்லை</td>

                    </tr>

                    <?php
                } ?>
                </tbody>
            </table>
        </div>
        <!--  <div><img src="img/picture-2.jpg" alt="Picture 2"></div>
        <div><img src="img/picture-3.jpg" alt="Picture 3"></div> -->
    </div>
    <div class="slider-nav">
        <div class="slider-active"></div>
        <div></div>
        <div></div>
    </div>
    <div class="slider-prev slider-disabled">&lsaquo;</div>
    <div class="slider-next">&rsaquo;</div>
</div>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/slider.js"></script>
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
        document.getElementById('txt').innerHTML =
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