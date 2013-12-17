<?php 
session_start();
include_once 'conn.php';
?>
<html>
<head>
	<title>Messages</title>
	<style type="text/css">
	.comment {
		margin-left: 50px;
	}
	textarea {
		width: 400px;
	}
	</style>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
</head>
<body>
<div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Coding Dojo Wall</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand">Coding Dojo Wall</a>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a><?php echo "Welcome ".$_SESSION['first_name']; ?></a></li>
            <li><a href="login.php">Logout</a></li>
        </ul>
    </div><!--/.nav-collapse -->
</div>
<div class="container">
	<h3>Post a message</h3>
	<form action="process.php" method="post">
		<input type="hidden" name="action" value="message">
		<textarea id="message" name="wall_message" placeholder="enter a message"></textarea><br>
		<input type="submit">
	</form>
	<?php 
	$query = "SELECT concat(users.first_name,' ', users.last_name) as full_name, messages.created_at, messages.message, messages.id
			 FROM messages
			 LEFT JOIN users
			 ON messages.users_id = users.id
			 ORDER BY messages.created_at DESC
			 ";

	$result = mysqli_query($conn, $query);
	while($row = mysqli_fetch_assoc($result))
	{
		echo "<h4>".$row['full_name']." - ".date("F j, Y", strtotime($row['created_at']))."</h4> ".$row['message']." <br>";
		$query2 = "SELECT concat(users.first_name,' ', users.last_name) as full_name, comments.created_at, comments.comment, comments.messages_id
			 FROM comments
			 LEFT JOIN users
			 ON comments.users_id = users.id
			 WHERE comments.messages_id =".$row['id']." ORDER BY comments.created_at DESC";
		$result2 = mysqli_query($conn, $query2);
		while($subrow = mysqli_fetch_assoc($result2))
		{
			echo "<div class='comment'><h4>".$subrow['full_name'].' - '.date("F j, Y", strtotime($subrow['created_at'])).'</h4> '.$subrow['comment'].'</div>';

		}
	echo '<br>
		<form class="comment" action="process.php" method="post">
	    <input type="hidden" name="action" value="post_comment">
	    <input type="hidden" name="message_id" value="'.$row['id'].'">
	    <textarea id="message" name="comment" placeholder="enter a comment"></textarea><br>
	    <input type="submit">
	</form>';
	}

	 ?>
</div>
</body>
</html>