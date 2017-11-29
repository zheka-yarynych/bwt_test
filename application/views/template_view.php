<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title><?=$data['title']?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
	<script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    
    <div class="middle_container">
    	<?php include 'application/views/'.$content_view; ?>
    </div>
</body>
</html>