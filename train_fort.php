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

    <title>Train Summery</title>
    <link href="img/favicon.ico" rel="shortcut icon"/>
    <link href="css/slider.css" rel="stylesheet">

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
    <link href="css/responsive.css" rel="stylesheet">

    <style>

        @import url('https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i|Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i');

    </style>

</head>


<?php

include_once("model/train_fort.php");

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

                                <h2>DEPARTURES - DOWN </h2>

                            </div>

                        </div>

                        <div>

                            <div class="name">

                                <h2>පිටත්වීම් - පහළට</h2>

                            </div>

                        </div>

                        <div>

                            <div class="name">

                                <h2>புறப்பாடு - டவுன்</h2>

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


                    <th><span class="heading">STATUS</span></th>

                </tr>

                </thead>

                <tbody>

                <?php


                $row_cnt = $result_shedule->num_rows;

                $n = 0;

                if ($row_cnt > 0) {

                    while ($row_shedule = $result_shedule->fetch_array()) {

                        //$current_time= date("H:i:s");
                        //$diprture_time= date("H:i:s");


                        $data[$n]['departure_time'] = substr($row_shedule['departure_time'], 0, 5);

                        //	TIMEDIFF($row_shedule['departure_time'], $current_time);

                        $data[$n]['to_location_si'] = $row_shedule['to_location_si'];
                        $data[$n]['to_location_ta'] = $row_shedule['to_location_ta'];
                        $data[$n]['route'] = $row_shedule['route'];
                        $data[$n]['bay_name'] = $row_shedule['bay_name'];
                        $data[$n]['remarks'] = $row_shedule['remarks'];
                        $data[$n]['status_id'] = $row_shedule['status_id'];
                        $data[$n]['status_name'] = $row_shedule['status_name'];
                        $data[$n]['status_name_si'] = $row_shedule['status_name_si'];
                        $data[$n]['status_name_ta'] = $row_shedule['status_name_ta'];


                        if ($data[$n]['status_id'] == 2 && $n == 0) {

                            $status = "On schedule";

                        } else {

                            $status = $data[$n]['status_name'];

                        }


                        $n++;

                        ?>


                        <tr>

                            <td>
                                <span class="time"><?php echo date("h:i A", strtotime($row_shedule['departure_time'])); ?> </span>
                            </td>

                            <td><span class="destination"><?php echo $row_shedule['to_location']; ?> </span></td>


                            <td><span class="available"><?php echo $status; ?> </span></td>

                        </tr>


                    <?php }


                } else {

                    ?>


                    <tr>

                        <td colspan="5">No scheduled journey on this route.</td>


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


                    <th><span class="heading">වර්තමාන තත්වය</span></th>

                </tr>

                </thead>

                <tbody>

                <?php


                if ($row_cnt > 0) {


                    for ($i = 0; $i < $row_cnt; $i++) {


                        if ($data[$i]['status_id'] == 2 && $i == 0) {
                            $status_si = "නියමිත වේලාවට ";

                        } else {
                            $status_si = $data[$i]['status_name_si'];

                        }


                        ?>


                        <tr>

                            <td>
                                <span class="time"><?php echo date("h:i A", strtotime($data[$i]['departure_time'])); ?> </span>
                            </td>

                            <td><span class="destination"><?php echo $data[$i]['to_location_si']; ?> </span></td>


                            <td><span class="available"><?php echo $status_si; ?> </span></td>

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


                    <th><span class="heading">நிலை</span></th>

                </tr>

                </thead>

                <tbody>

                <?php

                $row_cnt = count($data);

                if ($row_cnt > 0) {


                    for ($j = 0; $j < $row_cnt; $j++) {
                        if ($data[$j]['status_id'] == 2 && $j == 0) {
                            $status_ta = "நுழைதல் ";
                        } else {
                            $status_ta = $data[$j]['status_name_ta'];

                        }

                        ?>


                        <tr>

                            <td>
                                <span class="time"><?php echo date("h:i A", strtotime($data[$j]['departure_time'])); ?> </span>
                            </td>

                            <td><span class="destination"><?php echo $data[$j]['to_location_ta']; ?> </span></td>


                            <td><span class="available"><?php echo $status_ta; ?> </span></td>

                        </tr>


                    <?php }


                } else {

                    ?>


                    <tr>

                        <td colspan="5">இன்று திட்டமிடப்பட்ட விமானங்கள் இல்லை.</td>


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