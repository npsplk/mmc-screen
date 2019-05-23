<?php
include_once("./class/config.php");

date_default_timezone_set('Asia/Colombo');


    $db_conn=mysqli_connect($host,$dbuser, $dbpass, $database);
	 mysqli_set_charset($db_conn,"utf8");
		if (mysqli_connect_errno())
	  {
	  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	  }


// get configuration 
	 $sql="SELECT C.*, L.location_name FROM mmc_master_config AS C
	 LEFT JOIN mmc_location AS L ON C.location_id=L.location_id
	  WHERE C.status =1";
	 $result_config=mysqli_query($db_conn,$sql);
   
	  while($row = $result_config->fetch_array())
		{			
			 $location_id		=  $row['location_id']; 
			 $visibility_bus_number		=  $row['visibility_bus_number']; 
			 $visibility_departure_location		=  $row['visibility_departure_location']; 
			 $number_of_bay		=  $row['number_of_bay']; 
			 $number_of_raws_bay		=  $row['number_of_raws_bay']; 
			 $location_name		=  $row['location_name']; 
			 $number_of_raws		=  $row['number_of_raws']; 
		}
	 
	 $date = new DateTime();
     $timestamp= $date->getTimestamp();
	 $integer_date = idate('w', $timestamp);
	 $current_date = date("Y-m-d");
	 
	 
	  
	  
	 
     	 $current_time= date("H:i");
	 

	 
	  $sql="SELECT S.*, R.route, T.status_name,	T.status_name_si,	T.status_name_ta, R.to_location, R.to_location_si, R.to_location_ta FROM mmc_bus_shedule AS S
	  LEFT JOIN mmc_master_route AS R ON S.route_id=R.route_id
	  LEFT JOIN  mmc_bus_status AS T ON S.status_id=T.status_id
	  WHERE week_day_id=$integer_date AND departure_time>= '$current_time' 
	  AND S.route_id IN (11,12,13,14)  AND S.status=1 AND R.status = 1 
	  ORDER BY departure_time ASC LIMIT 0, $number_of_raws";
	  $result_shedule=mysqli_query($db_conn,$sql);
	  
	 

	 
	
	 
	 