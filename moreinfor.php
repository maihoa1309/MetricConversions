<?php 
    require_once('utils.php');
    $sql = "SELECT * FROM articles";
    $rows_articles = sqlGetAll($sql, '', );
    $sql =  "SELECT * FROM faqs";
    $rows_faqs = sqlGetAll($sql, '', );
    if($title = $_GET['title']??''){
        $sql = "SELECT * FROM articles WHERE title = ?";
        $row = sqlGetAll($sql, 's', $title)[0];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Weight conversion</title>
    <link rel="stylesheet" href="moreinfor.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <header class="header" >
		<div class="logo" >
			<a href="index.php">
				<img src="logo2.png" alt="">
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
                        <li><a href="area.php">Area</a></li>
                            <li><a href="length.php">Length</a></li>
                            <li><a href="volume.php">Volume</a></li>
                            <li><a href="mass.php">Mass</a></li>
                            <li><a href="temperature.php">Temperature</a></li>
                            <li><a href="currency.php">Currency</a></li>
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
    <?php if ($_GET['title'] ?? ''): ?>
        <center style="margin-top: 25px">
            <h2><?php echo $row['title']; ?></h2>
        </center>
        <div class="content">
            <?php if($row['overview']): ?>
                <h4>Overview:</h4>
                <?php echo $row['overview']; ?>
            <?php endif;?>
            <?php if($row['defining']): ?>
                <h4>Defining:</h4>
                <?php echo $row['defining']; ?>
            <?php endif;?>
            <?php if($row['history']): ?>
                <h4>History:</h4>
                <?php echo $row['history']; ?>
            <?php endif;?>
        </div>
    <?php else: ?>
        <div class="row" style = "margin-top: 15px; width: 99%">
            <div class="col">
                <center><h4>FAQs</h4></center>
                <div class="accordion" >
                    <?php foreach($rows_faqs as $row): ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?php echo $row['id']  ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                            data-bs-target="#collapse<?php echo $row['id']  ?>" aria-expanded="false"
                            aria-controls="collapse<?php echo $row['id']  ?>">
                                <?php echo $row['ques'];?>
                            </button>
                        </h2>
                        <div id="collapse<?php echo $row['id']  ?>" class="accordion-collapse collapse" 
                        aria-labelledby="heading<?php echo $row['id']  ?>" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <i class="fas fa-angle-double-right"></i>
                                <?php echo $row['ans']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col">
                <center><h4>More articles</h4></center>
                <?php foreach($rows_articles as $row): ?>
                    <a href="./moreinfor.php?title=<?php echo $row['title'];?>" style="margin-left: 30px;">
                    <i class="fas fa-newspaper" style="color: black; position: relative"></i>
                    <?php echo $row['title'];?>
                    </a><br>
                <?php endforeach; ?>
            </div>

        </div>
    <?php endif; ?>
</body>
</html>