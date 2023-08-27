<?php 
    require_once('utils.php');
    $sql =  "SELECT * FROM faqs WHERE measure = 'Temperature'";
    $rows_faqs = sqlGetAll($sql, '', );
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Temperature conversion</title>
    <link rel="stylesheet" href="conversion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

   
 
    <script>
        function convertTemperature(value, type) {
            if (isNaN(value)){
                    return "Invalid input"
                }
            if (value === '') return ''
            if (type == 'c') {
                result = value * 1.8 + 32;
                if (result < 1/1000){
                    return numeral(result).format('0.000e+0')
                }else {
                    return result
                }
            } else {
                result = (value - 32) / 1.8;
                if (result < 1/1000){
                    return numeral(result).format('0.000e+0')
                }else {
                    return result
                }
            }
        }
        $(document).ready(function () {
            $('#input.temperature').on('keyup', function(event) {
                const inputUnit = $('#inputUnit').val()
                $('#output.temperature').val(convertTemperature(event.target.value, inputUnit))
            })

            $('#inputUnit').on('change', function(event) {
                $('#output.temperature').val(convertTemperature($('#input.temperature').val(), event.target.value))

            })
        })
    </script>
</head>
<body>
    <header class="header" >
        <div class="logo" class="container">
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
                    <a href="admin.php">Admin</a>
                    <i class="fas fa-user fa-lg"  style="margin-left: 80px"></i>
                </li>
            </ul>
        </div>
    </header>
    <div class="h1" style="margin-top: 20px;">
        Temperature <i class="fas fa-temperature-high"></i>
    </div>
    <div class="container" >
        <div class="row" >
            <div class ="col-md-8">
                <div class="row" style="padding-bottom: 50px" >
                    <div class="col-md-6" >         
                        <div class="input-group flex-nowrap">
                            <span class="input-group-text" style="border-radius: 5px 0 0 5px;">
                                <select name="units" style="border: none;background-color: #e9ecef;" id = "inputUnit">
                                    <option value="f">Fah to Cel</option>
                                    <option value="c">Cel to Fah</option>
                                </select>
                            </span>
                            <input type="text" class="form-control temperature" placeholder="Enter value" 
                            aria-label="enter value" aria-describedby="addon-wrapping"  min="0" id="input">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control temperature" placeholder="Result" 
                        aria-label="result" aria-describedby="addon-wrapping" min="0" id="output" readonly style="background-color: white">
                    </div>
                </div> 
                <?php $sql = "SELECT * FROM infor_units WHERE measure = ?";
                    if ($row = sqlGetAll($sql, 's', "Temperature")[0] ?? ''): ?>
                    <b>&emsp;Brief of history about <?php echo $row['unit']; ?>:</b>
                    <?php echo $row['history']; ?>
                    <br>
                    <b>&emsp;Measurement:</b> 
                    <br>
                    <?php echo $row['measurement'] ?>
                <?php endif; ?>
            </div>
              

            <div  class=" col-md-4"  >
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