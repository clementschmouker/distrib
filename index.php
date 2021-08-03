<?php

// connection informations

$servername = 'localhost';
$username = 'root';
$password = ''; 
$db = 'randomizelinks';

$conn = new mysqli($servername, $username, $password, $db);

if ($conn->connect_error) {
	die("connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM links"; // change table name if needed
$result = $conn->query($sql);

?>

<html>
	<head>
		<title>Faits Plantes & Champignons</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200,400&display=swap" rel="stylesheet">

		<style>
			.hidden {
				display: none;
			}

			body {
				margin: 0;
				padding: 0;
				width: 100vw;
				min-height: 100vh;
				color: #222;
			}

			.content {
				display: flex;
				flex-direction: column;
				align-items: center;
				position: absolute;
				top: 50%;
				left: 50%;
				width: 100%;
				transform: translate(-50%, -50%);
			}

			button {
				border: 2px solid #222;
				background: transparent;
				padding: 1rem;
				transition: all .2s ease-in-out;
				font-family: 'Oswald', sans-serif;
			}

			button:hover {
				background: #222;
				color: #eee;
				cursor: pointer;
			}

			h1 {
				font-family: 'Oswald', sans-serif;
				font-size: 3rem;
				font-weight: 200;
			}

			a {
				margin-top: 1rem;
				background: #fefefe;
				border: 1px solid #eeeeee;
				padding: 1rem;
			}
		</style>
	</head>

	<body>

		<?php
			if ($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					echo "<div class='hidden'>" .
					$row['value'] .
					"</div>";
				}
			}

		?>




		<!-- PUT YOUR HTML HERE -->

			<div class="content">
				<h1>Faits sur les plantes et champignons</h1>

				<button>Obtenir mon lien</button>

				<a class="link" href=""></a>

			</div>
		<!-- NO MORE HTML -->



		<script>
			var resultsArray = [];
			document.querySelectorAll('.hidden').forEach(el => {
				resultsArray.push(parseInt(el.innerHTML));
			});

			var link = document.querySelector('.link');

			link.classList.add('hidden');

			var allocatedFormIndex = 0;
			var newUrl = '';
			

			var minArray = [];
			var minForms = [];

			var clickingButton = document.querySelector('button');
			clickingButton.addEventListener('click', selectForms);

			function selectForms() {
				
				var forms = ['https://forms.office.com/Pages/ResponsePage.aspx?id=1JCwei76z068fEEntNWC7MlA5_epTX1InKus3WiV6hhUMUpXUlkyVzVGSDQ5N0JYRzUwMFhFWEhVRi4u',
							'https://forms.office.com/Pages/ResponsePage.aspx?id=1JCwei76z068fEEntNWC7MlA5_epTX1InKus3WiV6hhUQjY4N0VCSzNBVk8xTjVYVENFUEdKRllMNC4u',
							'https://forms.office.com/Pages/ResponsePage.aspx?id=1JCwei76z068fEEntNWC7MlA5_epTX1InKus3WiV6hhUMElUN0lDUTBPWkQxOUhTODJDUUFCVUFIOC4u',
							'https://forms.office.com/Pages/ResponsePage.aspx?id=1JCwei76z068fEEntNWC7MlA5_epTX1InKus3WiV6hhUNTVZQ0tUUUFQTkZQV0YxQzFPOFRFTktJWC4u'];

				// get percentages of occurences
				var percents = Object
							.entries(resultsArray.reduce((map, number) => (map[number] = (map[number] || 0) + 1, map), {}))
							.map(([number, count]) => [number, count * 100 / resultsArray.length]);


				// check highest
				var min = Math.min.apply(Math, percents.map((o) => o[1]));

				var indexes = [];


				percents.forEach((percent, i) => {
					if (percent[1] === min) {
						minArray.push(percent);
						minForms.push(forms[i]);
					}
				});

				allocatedFormIndex = Math.floor(Math.random() * minForms.length);

				link.setAttribute('href', 'post.php?url=' + minForms[allocatedFormIndex] + '&id=' + minArray[allocatedFormIndex][0]);
				link.innerHTML = minForms[allocatedFormIndex];
				link.classList.remove('hidden');
				newUrl = minForms[allocatedFormIndex];

				console.log('form::', minForms[allocatedFormIndex], 'id::', minArray[allocatedFormIndex][0]);
			}

			
			link.addEventListener('click', (e) => {
				e.preventDefault();

				var httpRequest = new XMLHttpRequest();
				httpRequest.onreadystatechange = () => {
					if (httpRequest.readyState === XMLHttpRequest.DONE) {
						window.location.href = newUrl;
					}
				};

				httpRequest.open('GET', './post.php?url=' + newUrl + '&id=' + minArray[allocatedFormIndex][0], true);
				httpRequest.send();
			});
		</script>
	</body>
</html>