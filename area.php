<?php
    require_once('utils.php');
    $sql =  "SELECT * FROM faqs WHERE measure = ?";
    $rows_faqs = sqlGetAll($sql, 's', 'Area' );

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Area conversion</title>
    <link rel="stylesheet" href="conversion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

  <script>
    const area_rates = {
        in2: 1550,
        mm2: 1000000,
        ft2: 1000000,
        m2: 1,
        yd2: 1.2,
        acres: 0.00027,
        ha: 0.0001,
        ml2: 0.00000386,
        km2: 0.000001
        }
        function convertArea(input, units1, units2){
            if (isNaN(input)){
                return "Invalid input"
                exit
            }
            if (input === ''){
                return ''
            } else {
                rate = area_rates[units2] / area_rates[units1]
                result = rate * input 
                if (result < 1/1000){
                    return numeral(result).format('0.000e+0')
                }else {
                    return result.toFixed(5)
                }
            }
        }
        $(document).ready(function(){
          
            $('#input.area').on('keyup', function(event){
                const units1 = $('#units1').val(), 
                    units2 = $('#units2').val()
                $('#output.area').val(convertArea(event.target.value,units1, units2))
            })

            $('#units1').on('change', function(event){
                const units2 = $('#units2').val()
                $('#output.area').val(convertArea($('#input.area').val(), event.target.value, units2))
            })
            $('#units2').on('change', function(event){
                const units1 = $('#units1').val()
                $('#output.area').val(convertArea($('#input.area').val(), units1,event.target.value))
            })
        })

  </script>
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
    <div class="h1" style="margin-top: 20px;">
        AREA 
        <big><i class="fas fa-chart-area"></i></big>
    </div>
	<div class="container" >
        <div class = "row">
            <div class="col-md-8">
                <div class="row" style = "padding-bottom: 50px;"> 
                    <div class=" col-md-6"  >         
                        <div class="input-group flex-nowrap">
                            <input type="text"  id ="input" class="form-control area" placeholder="Enter value" aria-label="enter value" aria-describedby="addon-wrapping"  min="0"  style=" width=200px">
                            <span class="input-group-text">
                                <select  id="units1" style="border: none;background-color: #e9ecef;border-radius: 0 5px 5px 0">
                                    <option value="in2">Sq inch</option>
                                    <option value="mm2">Sq mm</option>
                                    <option value="ft2">Sq ft</option>
                                    <option value="m2">Sq m</option>
                                    <option value="yd2">Sq yd</option>
                                    <option value="acres">Acres</option>
                                    <option value="ha">Ha</option>
                                    <option value="ml2">Sq ml</option>
                                    <option value="km2">Sq km</option>
                                </select>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group flex-nowrap">
                            <input type="text" class="form-control area" id="output"
                            placeholder="Result" aria-label="result" aria-describedby="addon-wrapping" min="0"
                            readonly style="background-color: white"  >
                            <span class="input-group-text">
                                <select  id="units2" style="border: none;background-color: #e9ecef;border-radius: 0 5px 5px 0">
                                    <option value="in2">Sq inch</option>
                                    <option value="mm2">Sq mm</option>
                                    <option value="ft2">Sq ft</option>
                                    <option value="m2">Sq m</option>
                                    <option value="yd2">Sq yd</option>
                                    <option value="acres">Acres</option>
                                    <option value="ha">Ha</option>
                                    <option value="ml2">Sq ml</option>
                                    <option value="km2">Sq km</option>
                                </select>
                            </span>
                        </div>
                    </div>
                </div>
               
                <?php $sql = "SELECT * FROM infor_units WHERE measure = ?";
                if ($row = sqlGetAll($sql, 's', "Area")[0] ?? ''): ?>
                    <b>&emsp;Brief of history about <?php echo $row['unit']; ?>:</b>
                    <?php echo $row['history']; ?>
                    <br>
                    <b>&emsp;Measurement:</b> 
                    <br>
                    <?php echo $row['measurement'] ?>
                <?php endif; ?>
       
		    </div>


            <div  class=" col-md-4">
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

        </div>
		
		
    </div>

    

		
</body>
</html>