<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to git-stars</title>

	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:300,400,700);

		body {
			margin: 0;
			font-family:'Lato', sans-serif;
			text-align:center;
		}

		.welcome {
			width: 300px;
			height: 300px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -150px;
			margin-top: -150px;
		}
	</style>
</head>
<body>
	<div class="welcome">
		<h1>Hello World</h1>
		<p>Welcome to git-stars, a Github repo recommender</p>

		<form id="repo" action="/recommend" method="get">
			<label for="repo-name">Enter a repo name: </label>
			<input type="text" id="repo-name" name="repo-name" placeholder="laravel" autofocus>
		</form>

		<script>
		var form = document.querySelector('form');

		if (form) {
			form.addEventListener('submit', function(e) {
				e.preventDefault();
				window.location = 'recommend/' + e.target[0].value;
			});
		}
		</script>
	</div>
</body>
</html>
