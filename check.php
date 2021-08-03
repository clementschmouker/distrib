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

		<style>
			.hidden {
				display: none;
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
		<ul class="results">
		</ul>
		<!-- NO MORE HTML -->



		<script>
			var resultsArray = [];
			document.querySelectorAll('.hidden').forEach(el => {
				resultsArray.push(parseInt(el.innerHTML));
			});

			// get percentages of occurences
			var percents = Object
							.entries(resultsArray.reduce((map, number) => (map[number] = (map[number] || 0) + 1, map), {}))
							.map(([number, count]) => [number, count * 100 / resultsArray.length]);


			const formsLetter = ["A", "B", "C", "D"];

			percents.forEach(percent => {
				var li = document.createElement('li');
				li.innerHTML = 'Le formulaire ' + formsLetter[percent[0]] + ' a été distribué à ' + percent[1] + '%';
				document.querySelector('.results').appendChild(li);
			})
			
			
		</script>
	</body>
</html>