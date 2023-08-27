<?php
    require_once('utils.php');
    $sql =  "SELECT * FROM exchange_rates";
	$rows  = sqlGetAll($sql, );
	$i = 0;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" /> 
    <link rel="stylesheet" href="./navbar.css">  
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">     
    <!-- -------- -->
   <style>
       body{
           background-color: #53e7ec;
       }
   
       
    
   </style>
    <!-- -------- -->
</head>
<body>
 	<header class="header" >
		<div class="logo" class="container">
			<a href="./index.php">
				<img src="./logo2.png" alt="">
			</a>
		</div>
    	<h2 style="font-size: 50px; color: white; line-height: 90px; text-align:center">Metric conversions</h2>
		<div class="navigation">
			<input type="checkbox" class="toggle-menu">
			<div class="metric"></div>
			<ul class="menu" style="padding-left: 0;margin-left: 20px">
				<li>
					<a href="#" >Conversions</a>
					<i class="fas fa-exchange-alt fa-lg" style="margin-left: 130px"></i>          
					<div class="drop-down">
						<ul>
							<li><a href="./area.php">Area</a></li>
							<li><a href="./length.php">Length</a></li>
							<li><a href="./volume.php">Volume</a></li>
							<li><a href="./mass.php">Mass</a></li>
							<li><a href="./temperature.php">Temperature</a></li>
							<li><a href="./currency.php">Currency</a></li>
						</ul>
					</div>
				</li>
				<li>
                <a href="moreinfor.php" >Some informations</a>
					<i class="fas fa-info-circle fa-lg" style="margin-left: 180px"></i>
				</li>
				<li>
					<a href="./admin.php">Admin</a>
					<i class="fas fa-user fa-lg"  style="margin-left: 80px"></i>
				</li>
			</ul>
		</div>
	</header>
  <br>
	<center>
		<div class="plan tem">
			<div class="plan-inner">
				<div class="entry-title">
					<h3>Temperature</h3>
					<a href="./Temperature.php">
						<div class="price">
							<span> 
								<h2><i class="fas fa-temperature-high"></i> <h2>
							</span>
						</div>
					</a>
				</div>
				<div class="entry-content">
					<ul>
					<li><strong>1 Fahrenheit =</strong> 0.556 Celsius</li>
					<li><strong>1 Celsius =</strong> 	33.8 Fahrenheit</li>
					<li><strong>1 Celsius =</strong> 66 Delisle</li>
					<li><strong>1 Celsius =</strong> 493.47 Rankine</li>
					<li><strong>1 Celsius =</strong> 33.8 Kelvin</li>
					</ul>
				</div>
				<br>  
			</div>
		</div>
		<div class="plan basic">
			<div class="plan-inner">
				<div class="entry-title">
					<h3>Mass</h3>
					<a href="./mass.php">
						<div class="price">
							<span>
								<h3><i class="fas fa-weight-hanging"></i></h3>
							</span>
						</div>
					</a>
				</div>
				<div class="entry-content">
					<ul>
						<li><strong>1 ounce =</strong> 28.35 grams</li>
						<li><strong>1 pound =</strong> 0.45 kilogram</li>
						<li><strong>1 short ton =</strong> 0.91 mega gram </li>
						<li><strong>1 ounce =</strong> 0.06 pound</li>
						<li><strong>1 short ton =</strong> 2000 pound</li>
					</ul>
				</div>
				<br>
			</div>
		</div>
	<!-- end of price tab-->
	<!--price tab-->
		<div class="plan standard">
			<div class="plan-inner">
				<div class="entry-title">
					<h3>Length</h3>
					<a href="./length.php">
						<div class="price">
							<span>
								<h3><i class="fas fa-ruler"></i></h3>
							</span>
						</div>
					</a>
				</div>
				<div class="entry-content">
					<ul>
					<li><strong>1 inch =</strong> 25.4 milimeters</li>
					<li><strong>1 feet(foot) =</strong> 0.30 meter</li>
					<li><strong>1 yard =</strong> 0.91 meter</li>
					<li><strong>1 miles =</strong> 1.61 kilometer</li>
					<li><strong>1 feet(foot) =</strong> 3 yards</li>
					</ul>
				</div>
				<br>
			</div>
		</div>
		<br>
	<!-- end of price tab-->
	<!--price tab-->
		<div class="plan ultimite">
			<div class="plan-inner">
				<div class="entry-title">
					<h3>Volume</h3>
					<a href="./volume.php">
						<div class="price">
							<span>
								<h3><i class="fas fa-vial"></i></h3>
							</span>
						</div>
					</a>
				</div>
				<div class="entry-content">
					<ul>
						<li><strong>1 fluid ounces =</strong> 	29.57 mililiters</li>
						<li><strong>1 gallon =</strong> 3.78 liter</li>
						<li><strong>1 cubic feet =</strong> 0.028 cubic meter</li>
						<li><strong>1 cubic yard =</strong> 0.765  cubic meter</li>
						<li><strong>1 galon =</strong> 0.0045 cubic meter</li>
					</ul>
				</div>
				<br>
			</div>
		</div>
	<!-- end of price tab-->
	<!-- price tab-->

		<div class="plan basic">
			<div class="plan-inner">
				<div class="entry-title">
					<h3>Curency</h3>
					<a href="./currency.php">
						<div class="price">
							<span>
								<h3><i class="fas fa-dollar-sign"></i></h3>
							</span>
						</div>
					</a>
				</div>
				<div class="entry-content">
					<ul>
						<?php if ($rows[$i] ?? '' ): ?>
							<?php while( $rows[$i] ?? '' or $i < 5): ?>
								<li><strong>1 <?php echo $rows[$i]['currency_code'];?> =</strong> <?php echo $rows[$i]['rate'] ?> VND</li>
							<?php $i++;
							endwhile; ?>
						<?php else: ?>
							<?php while ( $i < 5): ?>
								<li style="height: 40px;"></li>
							<?php $i++; endwhile;?>
						<?php endif; ?>
					</ul>
				</div>
				<br>
			</div>
		</div>
	<!-- end of price tab-->
	<!-- price tab-->

		<div class="plan tem">
			<div class="plan-inner">
				<div class="entry-title">
					<h3>Area</h3>
					<a href="./area.php">
						<div class="price">
							<span>
								<h3><i class="fas fa-chart-area"></i></h3>
							</span>
						</div>
					</a>
				</div>
				<div class="entry-content">
					<ul>
						<li><strong>1 square inch =</strong> 304.82 square meter</li>
						<li><strong>1 square feet =</strong> 0.092 square meter</li>
						<li><strong>1 square yard =</strong> 0.836 meter</li>
						<li><strong>1 acres =</strong> 0.40 hectares</li>
						<li><strong>1 square mile =</strong> 2.59 square kilometers</li>
					</ul>
				</div>
				<br>
			</div>
		</div>
	</center>



    
</body>
</html>

<br><br>



