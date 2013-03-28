<?php


// go to the end of Magento's index.php

//Replace this code:


/* Store or website code */
$mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : '';
 
/* Run store or run website */
$mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';
 
Mage::run($mageRunCode, $mageRunType);



//With this code:


//########### GEOIP ############//
include('geoip/ip2locationlite.class.php');
  
  //Load the class
$ipLite = new ip2location_lite;
$ipLite->setKey('your API Key'); // <- Important - enter your API Key here!
 
//Get errors and locations
$country = $ipLite->getCountry($_SERVER['REMOTE_ADDR']);
$errors = $ipLite->getError();

if (!empty($errors) && is_array($errors)) {
  foreach ($errors as $error) {
    echo var_dump($error) . "<br /><br />\n";
  }
}

if(strtoupper($country['countryCode']) != "US"){
    $mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : 'international_store_view';
    $mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';
}else{
    $mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : 'usa_store_view';
    $mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';
}
Mage::run($mageRunCode, $mageRunType);  

?>
