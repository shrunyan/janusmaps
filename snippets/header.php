<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
<meta name="description" content="Janusmaps provides you with an intuitive interface for planning and mapping out your trips." />
<meta name="keywords" content="janusmaps, maps, trips, plan, travel, itinerary, journey" />
<meta name="google-site-verification" content="v0bNnbknAxpsZi5nrdlS2rg_SGctHpEgq8bnJiYbuQo" />
<title>janusmaps</title>
<link href="style.css" type="text/css" rel="stylesheet" />
<script src="javascript/jquery-1.4.2.min.js"></script>
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAA2GGYm16_J-yCEZfZeZLePhQlVoJLEEg8FsGE9njP7hx64bGAPxQyrYd1PAC7XVJ1cVEb5XeYFDyWbQ" type="text/javascript"></script>
<script src="javascript/mapapp-gmap.js" type="text/javascript"></script>
<script src="javascript/site-behaviours.js"></script>
</head>
<body onunload="GUnload()" onLoad="initialize()">
	<div id="wrapper">
    
    	<!-- **** HEADER **** -->
		<div id="header">
            <h1 id="logo"><a href="index.php">janusmaps</a></h1>
            <?php include('login_controller.php'); ?>
            
            <div id="nav">
                <ul>
                    <li><a class="btn ajaxtrigger" id="new-btn" href="new_trip.php">New</a></li>
                    <li><a class="btn" id="save-btn" href="JavaScript://">Save</a></li>
                    <li><a class="btn ajaxtrigger" id="saved-btn" href="saved_trip.php">Saved</a></li>
                </ul>
            </div>
            
            <!-- Address search bar -->
			<form onsubmit="showAddress(); return false" action="#" id="search-form">
			  <input id="search-btn" type="submit" value="Search" class="btn" />
			  <input id="search" name="search" size="60" type="text" value="" />
              
              <!-- Shows additional addresses -->
              <div id="message-container">
              	<ul id="message"></ul>
              </div>
			</form>
			
        </div><!-- close header -->
		