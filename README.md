Magento Store by GeoIP
======================

Magento Multi Store Websites. Display store by GeoIP Country Localization.


**Installation**

**1**. Go to http://ipinfodb.com/account.php and create an account.
You will receive an email with an activation link.
You will follow that link and activate your account.
After the account will be activated, go to http://ipinfodb.com , login and go to the page Account, you will see your API Key.


**2**. Go to magento root folder.
Copy there the folder "geoip". The folder 'geoip' contains a file called: "ip2locationlite.class.php".


**3**. Go to your index.php from the Magento's root folder and make the changes just like below (just like I explained in the file index.php):

**i) Replace this code:**


/* Store or website code */
$mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : '';
 
/* Run store or run website */
$mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';
 
Mage::run($mageRunCode, $mageRunType);



**ii) With this code:**


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
}

else{
    $mageRunCode = isset($_SERVER['MAGE_RUN_CODE']) ? $_SERVER['MAGE_RUN_CODE'] : 'usa_store_view';
    $mageRunType = isset($_SERVER['MAGE_RUN_TYPE']) ? $_SERVER['MAGE_RUN_TYPE'] : 'store';
}

Mage::run($mageRunCode, $mageRunType);        

