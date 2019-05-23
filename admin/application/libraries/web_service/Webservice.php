<?php
/**
	 * @component		- Webservice Configurations
	 * @version    		- 1.0
	 * @developer		- Supun Maduranga
	 * @company			- Pooranee Inspirations (Pvt) Ltd
	 * @license			- GNU/GPL
*/


// Check to ensure this file is within the rest of the framework
defined('BASEPATH') OR exit('No direct script access allowed');

class Webservice
{

	// Common IP verification
	function getVerificationCode($emailaddress, $secretval)
	{
		//get ipaddress for user
//		$ipaddress = JWebservice::get_real_IP_address();
		$ipaddress =  $this->input->ip_address();
		//set your paddress if try to use in localhost
		 $ipaddress="123.231.12.160"; // Real server static IP
		 //$ipaddress="220.247.224.71"; // Real server static IP

		
		//get time stamp need to add 5.30 hours to globel time
		$diiferance=5*3600+30*60;
		$time = time()+$diiferance;
	
		// if email addres null need to set email address as example@ex.exp
		if(strlen($emailaddress)==0)
		{
			$emailaddress= "example@ex.exp";
		}
	
		//create basic stucture and encode value for verification code
		$variables = $ipaddress.':'.$emailaddress.':'.$time;
		$encodval = base64_encode($variables);
	
		//need to set secret value in here
		//This secrect value need to set from some globele value such as parms
		//intially secet valu use as 0;
	
		//$secretval='0';
		$verificode = Webservice::encription($encodval, $secretval).":".$encodval;
		return $verificode;
	}
	
	// Return real IP
	function get_real_IP_address()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) //check ip from share internet
		{
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) //to check ip is pass from proxy
		{
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
			$ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	function encription ($inputval, $secretval)
	{
	
		$base64val = base64_encode($inputval);
		$decodeval = base64_decode($inputval);
		$sha1encval = $base64val.$decodeval;
	
	
		$wordcount=strlen($sha1encval);
	
		// suffel the each pair of string
		$t = strlen($sha1encval)%2;
		for ($i = 0; $i < strlen($sha1encval); $i++)        {
			if($i%2==0){
				if ($t == 0){
					$shuf[$i + 1] = substr($sha1encval, $i, 1);
				}
				else if ($t == 1){
	
					if ($i + 1 <strlen($sha1encval)){
	
						$shuf[$i + 1] =  substr($sha1encval, $i,1);
					}
					if ($i + 1 == strlen($sha1encval))
					{
							
						$shuf[$i] =  substr($sha1encval, $i,1);
					}
				}
			}
			else if ($i%2==1)
			{
	
				$shuf[$i - 1] =  substr($sha1encval, $i,1);
				 
			}
		}
		 
		$returnval='';
		for($j=0; $j<count($shuf); $j++){
			$returnval=$returnval.$shuf[$j];
		}
		$returnval;
		return md5($returnval.$secretval);
	}

	// Set the web service configuratios | available service adresses
	function getWebServicesConnfig()
	{
		//$wsconfig['wsdl']="http://220.247.238.176/LiveWebService/Smms.svc/ws?wsdl";
		//$wsconfig['endpoint']="http://220.247.238.176/LiveWebService/Smms.svc/soapService";
		
		
		 $wsconfig['wsdl']="http://220.247.238.176/WebService/Smms.svc/ws?wsdl";
		 $wsconfig['endpoint']="http://220.247.238.176/WebService/Smms.svc/soapService";
		
		
		$wsconfig['signature']="0";
		return  $wsconfig;
	}
        
        
	function getWisdomWebServicesConnfig()
	{
		$wsconfig['wsdl']='http://wisdom.casrilanka.com/test/webservice/soap/server.php?wsdl=1&wstoken=9aa5f1ab5f90fffa681f15f269945848';
		return  $wsconfig;
	}
	
	// Convert STD object into an array
	function object2array($data)
	{
		if (is_array($data) || is_object($data))
		{
		  $result = array();
		  foreach ($data as $key => $value)
		  {
		  $result[$key] = Webservice::object2array($value);
		  }
		  return $result;
		}
		return $data;
	}

}