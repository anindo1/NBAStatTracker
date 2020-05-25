<!DOCTYPE html>
<head>
	<title>Basketball Stat Tracker</title>
	<link rel="icon"
      type="image/png"
      href="https://swagswami.com/wp-content/uploads/2019/12/cool-basketball-logo.jpg">
</head>
<?php
	function getPlayerData($player_name) {
		$query = str_replace("+", "%20", urlencode($player_name));
		$player_data = JSON_decode(file_get_contents("https://www.balldontlie.io/api/v1/players?search=$query"));
		return $player_stats = $player_data->data[0];
	}
	
	function getSeasonData($player_id, $season_year) {
		$season_query = str_replace("+", "%20", urlencode($season_year));
		$season_data = JSON_decode(file_get_contents("https://www.balldontlie.io/api/v1/season_averages?season=$season_query&player_ids[]=$player_id"));
		return $season_stats = $season_data->data[0];
	}
?>
<link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">

<style>
body, html {
padding: 0;
margin: 0;
width: 100%;
height: 100%;
background-image: url(https://i.imgur.com/LPv7QvE.jpg);
background-repeat: repeat;
background-size: contain;
background-position: 150px 75px;
}

h1 {
	color: white;
	margin: 0;
}

#title {
	background-color: black;
	width: 100%;
	height:auto;
	padding-top: 12.5px;
	padding-bottom: 12.5px;
	text-align: center;
	font-size: 30px;
	display: flex;
	justify-content: center;
}

#footer {
	position: absolute;
	bottom: 0;
	right: 0;
	background-color: black;
	color: white;
	width: 10%;
	font-family: 'Satisfy', cursive;
}

#title img {
	width: 40px;
	height: auto;
}

.box {
	background: radial-gradient(ellipse farthest-corner at right bottom, #FEDB37 0%, #FDB931 8%, #9f7928 30%, #8A6E2F 40%, transparent 80%),
    radial-gradient(ellipse farthest-corner at left top, #FFFFFF 0%, #FFFFAC 8%, #D1B464 25%, #5d4a1f 62.5%, #5d4a1f 100%);
	padding: 0px;
	width: 40%:
	border-radius: 10px;
	border: 1px solid black;
	color: black;
	padding: 7px;
}

.box h2 {
	margin: 0;
}

input[name="season"]
{
}

</style>

<body>
<section id="title">
	<img src="https://swagswami.com/wp-content/uploads/2019/12/cool-basketball-logo.jpg">
	<h1>Modern NBA Stat Tracker</h1>
	<img src="https://swagswami.com/wp-content/uploads/2019/12/cool-basketball-logo.jpg">
</section>
<div style="display: flex; justify-content: center; padding-top: 50px; font-size: 16px;">
	<section style="margin-right: 0px;" class="box" id="players">
		<form method="GET" action="/">
			Player Name: <input type="text" name="player"></input>
			<br>
			Season Year: <input type = "text" name="season"> </input>
			<br>
			<input type = "submit">
		</form>
		
		<div style="font-size: 16px;">
			<p>
			<?php 
			$player = $_GET['player'];
			$season = $_GET['season'];
			$player_id = getPlayerData($player)->id;
			$efg = (floatval(getSeasonData($player_id, $season)->fgm) + 0.5 * floatval(getSeasonData($player_id, $season)->fg3m)) / floatval(getSeasonData($player_id, $season)->fga);
			$TSA = floatval(getSeasonData($player_id, $season)->fga) + 0.44 * floatval(getSeasonData($player_id, $season)->fta);
			$TS = floatval(getSeasonData($player_id, $season)->pts)/(2 * $TSA);
			$efg_rounded = round($efg, 2);
			$TS_rounded = round($TS, 2);
			echo getPlayerData($player)->first_name . " " . getPlayerData($player)->last_name;
			echo "<br>";
			echo getPlayerData($player)->team->full_name;
			echo "<br>";
			echo "Position: " . getPlayerData($player)->position;
			echo "<br>";
			echo "Height: " . getPlayerData($player)->height_feet . " ft " . getPlayerData($player)->height_inches . " in ";
			echo "<br>";
			echo "Weight: " . getPlayerData($player)->weight_pounds . " lbs";
			echo "<br>";
			echo "<br>";
			echo "Season: " . $season;
			echo "<br>";
			echo "Games Played: " . getSeasonData($player_id, $season)->games_played;
			echo "<br>";
			echo "Points: " . getSeasonData($player_id, $season)->pts;
			echo "<br>";
			echo "Total Rebounds: " . getSeasonData($player_id, $season)->reb;
			echo "<br>";
			echo "Assists: " . getSeasonData($player_id, $season)->ast;
			echo "<br>";
			echo "FGM: " . getSeasonData($player_id, $season)->fgm;
			echo "<br>";
			echo "FGA: " . getSeasonData($player_id, $season)->fga;
			echo "<br>";
			echo "FG%: " . getSeasonData($player_id, $season)->fg_pct;
			echo "<br>";
			echo "3P: " . getSeasonData($player_id, $season)->fg3m;
			echo "<br>";
			echo "3PA: " . getSeasonData($player_id, $season)->fg3a;
			echo "<br>";
			echo "3P%: " . getSeasonData($player_id, $season)->fg3_pct;
			echo "<br>";
			echo "eFG%: $efg_rounded";
			echo "<br>";
			echo "TS%: $TS_rounded";
			echo "<br>";
			echo "FTM: " . getSeasonData($player_id, $season)->ftm;
			echo "<br>";
			echo "FTA: " . getSeasonData($player_id, $season)->fta;
			echo "<br>";
			echo "FT%: " . getSeasonData($player_id, $season)->ft_pct;
			echo "<br>";
			echo "Steals: " . getSeasonData($player_id, $season)->stl;
			echo "<br>";
			echo "Blocks: " . getSeasonData($player_id, $season)->blk;
			echo "<br>";
			echo "Turnovers: " . getSeasonData($player_id, $season)->turnover;
			?>
			</p>			
		</div>
	</section>
</div>
<section id="footer">
	By Anindya and Liang
</section>
</body>
