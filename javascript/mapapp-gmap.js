//<![CDATA[
if (GBrowserIsCompatible()) { 	

var map;
var geo;
var polyline;

// arrays to hold copies of the markers and html used by the side_bar
// because the function closure trick doesnt work there
/*
var gmarkersLat = [];
var gmarkersLng = [];
var gpoly = [];
var htmls = [];
*/
var gResults = [];
var gmarkers = [];
var side_bar_html = [];
var reasons = [];
var i = 0;
var homepage = 0;
var scroller;
var scrollerExists = 0;
var scroller_is_on = 0;
var scrollAmount = 0;

var myIcon = new GIcon();
myIcon.image = 'images/markers/image.png';
myIcon.printImage = 'images/markers/printImage.gif';
myIcon.mozPrintImage = 'images/markers/mozPrintImage.gif';
myIcon.iconSize = new GSize(17,30);
myIcon.shadow = 'images/markers/shadow.png';
myIcon.transparent = 'images/markers/transparent.png';
myIcon.shadowSize = new GSize(32,30);
myIcon.printShadow = 'images/markers/printShadow.gif';
myIcon.iconAnchor = new GPoint(9,30);
myIcon.infoWindowAnchor = new GPoint(9,0);
myIcon.imageMap = [16,0,16,1,16,2,16,3,16,4,16,5,15,6,15,7,15,8,14,9,14,10,14,11,14,12,13,13,13,14,13,15,13,16,12,17,12,18,12,19,12,20,11,21,11,22,11,23,11,24,10,25,10,26,10,27,10,28,10,29,7,29,7,28,7,27,6,26,6,25,6,24,6,23,5,22,5,21,5,20,5,19,4,18,4,17,4,16,4,15,3,14,3,13,3,12,2,11,2,10,2,9,2,8,1,7,1,6,1,5,1,4,0,3,0,2,0,1,0,0];

// ====== Array for decoding the failure codes ======
var reasons=[];
reasons[G_GEO_SUCCESS]            = "Success";
reasons[G_GEO_MISSING_ADDRESS]    = "Missing Address: The address was either missing or had no value.";
reasons[G_GEO_UNKNOWN_ADDRESS]    = "Unknown Address:  No corresponding geographic location could be found for the specified address.";
reasons[G_GEO_UNAVAILABLE_ADDRESS]= "Unavailable Address:  The geocode for the given address cannot be returned due to legal or contractual reasons.";
reasons[G_GEO_BAD_KEY]            = "Bad Key: The API key is either invalid or does not match the domain for which it was given";
reasons[G_GEO_TOO_MANY_QUERIES]   = "Too Many Queries: The daily geocoding quota for this site has been exceeded.";
reasons[G_GEO_SERVER_ERROR]       = "Server error: The geocoding request could not be successfully processed.";

// ====== Create a Client Geocoder ======
var geo = new GClientGeocoder();
 

function initialize(){	
	// Display the map, with some controls and set the initial location 
	map = new GMap2(document.getElementById("map_canvas"));
	map.addControl(new GLargeMapControl());
	map.addControl(new GMapTypeControl());
	// ==== It is necessary to make a setCenter call of some description before adding markers ====
	// ==== At this point we dont know the real values ====
	map.setCenter(new GLatLng(0,0),2);	
	//  ======== Add a map overview ==========
	map.addControl(new GOverviewMapControl(new GSize(200,200)));	
	  
	  
	//  ======== A function to adjust the positioning of the overview ========
	function positionOverview(x,y) {
	var omap=document.getElementById("map_canvas_overview");
	omap.style.left = x+"px";
	omap.style.top = y+"px";
	
	// == restyling ==
	omap.firstChild.style.border = "1px solid gray";
	
	omap.firstChild.firstChild.style.left="4px";
	omap.firstChild.firstChild.style.top="4px";
	omap.firstChild.firstChild.style.width="190px";
	omap.firstChild.firstChild.style.height="190px";
	}
	//  ======== Cause the overview to be positioned AFTER IE sets its initial position ======== 
	//setTimeout("positionOverview(558,254)",1);
	// ===== Start with an empty GLatLngBounds object =====     
	var bounds = new GLatLngBounds();		

	/*
	// ================================================================
	// === Define the function thats going to process the JSON file ===
	process_it = function(doc) {
		// === Parse the JSON document === 
		var jsonData = eval('(' + doc + ')');
		
		// === Plot the markers ===
		for (var i=0; i<jsonData.markers.length; i++) {
			
		  var point = new GLatLng(jsonData.markers[i].lat, jsonData.markers[i].lng);
		  place(jsonData.markers[i].lat,jsonData.markers[i].lng);
		  //var marker = createMarker(point, jsonData.markers[i].label, jsonData.markers[i].html,myIcon);
		  //map.addOverlay(marker);
		  
		  // ==== Each time a point is found, extent the bounds ato include it =====
		  bounds.extend(point);
		}
		
		// put the assembled side_bar_html contents into the side_bar div
		document.getElementById("sidebar").innerHTML = side_bar_html;
		
		// ===== determine the zoom level from the bounds =====
		map.setZoom(map.getBoundsZoomLevel(bounds));
		
		// ===== determine the centre from the bounds ======
		map.setCenter(bounds.getCenter());
		
		
		// === Plot the polylines ===
		for (var i=0; i<jsonData.lines.length; i++) {
		  var pts = [];
		  for (var j=0; j<jsonData.lines[i].points.length; j++) {
			pts[j] = new GLatLng(jsonData.lines[i].points[j].lat, jsonData.lines[i].points[j].lng);
		  }
		  map.addOverlay(new GPolyline(pts, jsonData.lines[i].colour, jsonData.lines[i].width)); 
		}
	
	}          
	
	// ================================================================
	// === Fetch the JSON data file ====    
	GDownloadUrl("example.json", process_it);
	// ================================================================
	*/
	
	
	//Set map height and width
	function setMapSize() {
		var getMap = $('#map');
		var myWidth = 0, myHeight = 0;
		
		if( typeof( window.innerWidth ) == 'number' ) {
			//Non-IE
			myWidth = window.innerWidth;
			myHeight = window.innerHeight;
		} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
			//IE 6+ in 'standards compliant mode'
			myWidth = document.documentElement.clientWidth;
			myHeight = document.documentElement.clientHeight;
		} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
			//IE 4 compatible
			myWidth = document.body.clientWidth;
			myHeight = document.body.clientHeight;
		}
		
		var newWidth = myWidth - 264;
		var newHeight = myHeight - 50 - 18;
		getMap.css({
			width: newWidth,
			height: newHeight
		});	
	}
	setMapSize();
	
	
} //Close initalization funciton


	// ====== Function to Plot markers ======
	function place(result) {
		var lat = result.Placemark[0].Point.coordinates[1];
		var lng = result.Placemark[0].Point.coordinates[0];
		var address = result.Placemark[0].address;
		var point = new GLatLng(lat,lng);
		var marker = new GMarker(point,myIcon);
		
		var listTitle = $('#list-title');
		
		//Setup map and marker
		map.setCenter(point,14);
		map.addOverlay(marker);
		GEvent.addListener(marker, "click", function() {
			marker.openInfoWindowHtml(address);
		});
		
		/* HMMM DOESN'T SEEM TO WORK
		//Setup poly line
		polyline = new GPolyline([
		  new GLatLng(gResults[i].Placemark[0].Point.coordinates[1], gResults[i].Placemark[0].Point.coordinates[0]),
		  new GLatLng(lat, lng)
		], "#000000", 6,0.75);
		map.addOverlay(polyline);	
		//gpoly[i] = polyline;
		*/
		
		//Check if list has a title and set it accordingly
		var listTitleEmpty = listTitle.find('span').html();
		if(listTitleEmpty == 0)
		{
			$('#list-title span').html('Temporary List');
		}
		
		//if on homepage add this html
		if(homepage == 0){
			$('#list-instructions').hide();
			$('#homepage-list').hide();
			listTitle.show();
		} else if (homepage == 1){
			$('#list-instructions').hide();
			$('#homepage-list').hide();
			listTitle.show();
		};
		
		// add a line to the side_bar html
		side_bar_html[i] = '<li id="item'+i+'">'+
							'<span class="place"><a href="javascript:showInfoWindow(' + i + ')">' + address + '</a></span>'+
							'<span class="edit">'+
								'<a href="javascript:removeMarker(' + i + ')">X</a>'+
								'<a class="more" href="JavaScript://">>></a>'+
						   '</li>';
		
		// Clear and assemble neccessary html 
		document.getElementById("message").innerHTML = "";
		document.getElementById("places-list").innerHTML += side_bar_html[i];
		showSidebarScrolls();
		
		//This stores the uniques instances of markers
		gmarkers[i] = marker;
		//This stores all the JSON data from geocoding
		gResults[i] = result;
		i++;
		
	}// close place function

	// ====== Geocoding ======
	function showAddress() {
		var address = document.getElementById("search").value;
		var con = $('#message-container').hide();

		// ====== Perform the Geocoding ======        
		geo.getLocations(address, function (result) {
			if (result.Status.code == G_GEO_SUCCESS) {
				// ===== If there was more than one result, "ask did you mean" on them all =====
				if (result.Placemark.length > 1) {
					document.getElementById("message").innerHTML = "<h4>Did you mean:</h4>";
					
					// Loop through the results and create HTML
					for (var i=0; i<result.Placemark.length; i++) {
						document.getElementById("message").innerHTML += 
						"<li>"+(i+1)+": <a href='JavaScript:place( "+result+")'>"+result.Placemark[i].address+"</li>";
					};
					//Show message container
					con.slideDown('slow');
					con.click(function(){
						con.slideUp(400);
					});
				} else {
					// ===== If there was a single marker =====
					document.getElementById("message").innerHTML = "";
					place(result);
				}
			} else {
				// ====== Decode the error status ======
				var reason="Code "+result.Status.code;
				if (reasons[result.Status.code]) {
					reason = reasons[result.Status.code]
				}
				document.getElementById("message").innerHTML = 'Could not find "'+address+ '" <br /><br /> ' + reason;
				//Show message container
				con.slideDown('slow').delay(3000).fadeOut(400);
			}
		});
	}// close showAddress function
	

	/*
	 * This is added when the place() function creates the html
	 * It's used to recall infowindows when clicking a link from the sidebar
	 */
	function showInfoWindow(i) {
		gmarkers[i].openInfoWindowHtml(gResults[i].Placemark[0].address);
	}
	
	/*
	 * This is added when the place() function creates the html
	 * It's used to remove markers and infowindows when clicking a link from the sidebar
	 */
	function removeMarker(i){
		var curItem = document.getElementById('item'+i);
		curItem.parentNode.removeChild(curItem);

		gResults.splice(i,1,{"skip": 0});
		showSidebarScrolls();
		//FIGURE OUT HOW TO REMOVE THE SINGLE RELATED MARKER		
	};
	
	
	/*
	 * Scroller functionality for sidebar overflow
	 */
	//Scrolling Listeners
	$('#scrollup').live('mouseover', function(event){
		doScroll(event);
	});
	$('#scrollup').live('mouseout', function(event){
		stopScrolling();								  
	});
	$('#scrolldown').live('mouseover', function(event){
		doScroll(event);
	});
	$('#scrolldown').live('mouseout', function(event){
		stopScrolling();								  
	});
	
	function startScrolling(e){
		var curTarget = $(e.target).attr('id');
		var list = $('#places-list');
		var listHeight = list.height();
		var sidebarHeight = $('#sidebar').height();
		var scrollDistance = listHeight - sidebarHeight;
		
		if(curTarget === "scrollup"){
			function scrollUp(){
				if(scrollAmount >= 88){
					stopScrolling();
				} else {
					list.css('top', scrollAmount);
					scrollAmount += 5;
					scroller = setTimeout(scrollUp, 50);
				}				
			};
			scrollUp();
		} else if(curTarget === "scrolldown"){
			function scrollDown(){
				if(((scrollAmount + scrollDistance)+120) <=0 ){
					stopScrolling();
				} else {
					list.css('top', scrollAmount);
					scrollAmount -= 5;	
					scroller = setTimeout(scrollDown, 50);
				}
			};
			scrollDown()
		};		
	};
	function doScroll(e) {
		if (!scroller_is_on) {
			scroller_is_on=1;
			startScrolling(e);
		}
	}
	function stopScrolling() {
		clearTimeout(scroller);
		scroller_is_on=0;
	};
	function showSidebarScrolls() {
		var list = $('#places-list');;
		var sidebarHeight = $('#sidebar').height();
		var listHeight = list.height();
		
		if( scrollerExists == 0){
			if(listHeight > (sidebarHeight - 110)){
				list.css({overflow: "hidden"})
					.before('<div id="scrollup">Scroll Up</div>')
					.after('<div id="scrolldown">Scroll Down</div>');
				$('#scrollup').fadeIn();
				$('#scrolldown').fadeIn();
				scrollerExists = 1;
			} 
		} else {
			if ((listHeight+50) < sidebarHeight) {
				$('#scrollup').remove();
				$('#scrolldown').remove();
				list.css('top', '43px');
				scrollerExists = 0;
			};
		};		
	};
	  
//Close if statement that checks gbrowser compatability  
} else {
  alert("Sorry, the Google Maps API is not compatible with this browser");
}
//]]>