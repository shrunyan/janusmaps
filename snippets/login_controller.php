<?php
if(!empty($_SESSION['user_id'])){//if user is logged in
	
	echo '<a id="logout-btn" class="btn" href="snippets/logout_controller.php">Logout</a>';
	?>
	<script>
		homepage = 1;
	</script>
	<?php

}
else{//else if user not logged in
	echo '<a id="login-btn" class="btn ajaxtrigger" href="login.php">Login</a>';
	?>
	<script>
		homepage = 0;
	</script>
	<?php
}
?>