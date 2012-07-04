 <!-- **** FOOTER **** -->
		<div id="footer">
        	<ul>
            	<li><a href="privacy_policy.php" class="ajaxtrigger">Privacy policy</a> /</li>
                <li><a href="about.php" class="ajaxtrigger">About</a> /</li>
                <li><a href="contact.php" class="ajaxtrigger">Contact</a></li>
            </ul>
            <small><a href="http://www.stuartrunyan.com">copyright <?php echo date('Y') ?> Studio1904</a></small>
        </div>
    </div><!-- close wrapper -->

    <div id="save-confirm">
    	<p>List one saved</p>
    </div>
    
    <!-- Container for AJAX content -->
    <div class=modal>
    	<a class="close btn" href="JavaScript://">X</a>
    	<div class="results"><!-- Load content here --></div>
    </div>
    
    <!-- ANYALYTICS HERE -->
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-15896911-6']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
	<!--
	Mad props to Google for throwing togther such a fantastic API 
    and to Mike at http://econym.org.uk/gmap/ for the great tutorials.
	-->
</body>
</html>