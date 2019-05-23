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
			 $location_name		=  $row['location_name']; 
			 $number_of_raws		=  $row['number_of_raws']; 
		}
	 
	 $date = new DateTime();
     $timestamp= $date->getTimestamp();
	 $integer_date = idate('w', $timestamp);
	 $current_date = date("Y-m-d");
	 
	 
	  $bay_id=$_REQUEST["bay_id"];
	  
	  if ($bay_id>0){
	  $route_id=getRouteDetail($bay_id, $db_conn);
	  $bay_name=getBayName($bay_id, $db_conn);
	  if($route_id>0){
	  $route_data= getRouteData($route_id, $db_conn);
	  }
   
	 $current_time= date("H:i");
	 
	 
	  

	 
	 $sql="SELECT S.*, T.status_name,	T.status_name_si,	T.status_name_ta, R.route, R.to_location, R.to_location_si, R.to_location_ta 
	 	FROM mmc_bus_shedule AS S
	   LEFT JOIN mmc_master_route AS R ON S.route_id=R.route_id
	  LEFT JOIN  mmc_bus_status AS T ON S.status_id=T.status_id
	  WHERE S.route_id =$route_id AND week_day_id=$integer_date AND departure_time> '$current_time' 
	  AND R.status =1  AND S.status=1 
	  ORDER BY departure_time ASC LIMIT 0, 12";
	
	$result_shedule=mysqli_query($db_conn,$sql);
	  
	  }

	 
function getRouteDetail($bay_id, $db_conn){
		   $sql="SELECT route_id FROM mmc_bay_to_route 
	  WHERE bay_id =$bay_id";
	 $result_bay=mysqli_query($db_conn,$sql);
   
	  while($row_bay = $result_bay->fetch_array()){
	   $route_id		=  $row_bay['route_id']; 
	 }
	 
	 return $route_id;
}


function getBayName($bay_id, $db_conn){
	$sql="SELECT bay_name FROM mmc_master_bay 
	  WHERE status=1 AND bay_id =$bay_id";
	 $result_bay=mysqli_query($db_conn,$sql);
   
	  while($row_bay = $result_bay->fetch_array()){
	   $bay_name		=  $row_bay['bay_name']; 
	 }
	 
	 return $bay_name;
}


function getRouteData($route_id, $db_conn){
	$sql="SELECT * FROM mmc_master_route 
	  WHERE route_id =$route_id";
	 $result=mysqli_query($db_conn,$sql);
   
	  while($row = $result->fetch_array()){
	   $route_data['route_id']		=  $row['route_id']; 
	   $route_data['route']			=  $row['route']; 
	   $route_data['to_location']		=  $row['to_location']; 
	   $route_data['to_location_si']		=  $row['to_location_si']; 
	   $route_data['to_location_ta']		=  $row['to_location_ta']; 
	 }
	 
	 return $route_data;
}
	
	 
	 