<?php
    require_once('utils.php');

    session_start();
    $_SESSION['login']= '';
    $fail = '';
// mail: admin@gmail.com
// pass: 123
    if($_POST){
        $mail = $_POST['mail'];
        $password = md5($_POST['password']);
        $sql = "SELECT * FROM login WHERE mail = ? AND password = ?";
        if ($rows = sqlGetAll($sql, 'ss', $mail, $password)){
            $row = $rows[0];
            $_SESSION['id'] = $row['id'];
            $_SESSION['login']= 'done';
            redirect('./admin.php');

        }else{
            $fail = "Email or password incorrect!";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />    
    <link rel="stylesheet" href="./login.css">
</head>
<body>
    <div class="background"></div>
    <form method = "post" action="#">
        <h2 style =" margin-top: 10px;"class="offset-md-1">Login</h2>
       
        <br>
        <div class="form-group">
            <input type="text" placeholder="Email" 
            class="offset-md-1 col-md-10" name="mail"  
            <?php if ($fail ?? ''): ?>
                style ="border-bottom: 1.5px solid red"
            <?php endif; ?>>
        
        </div>
        <br>
        <div class="form-group">
            <input type="password" class="offset-md-1 col-md-10"  
            placeholder="Password" name="password" 
            <?php if ($fail ?? ''): ?>
                style ="border-bottom: 1.5px solid red"
            <?php endif; ?>> 
        </div>
        <div>
            <h6 style="font-size: 10px;color: red; margin-left: 45px; margin-top: -10px; padding-bottom: 15px;"><?php echo $fail ?></h6>
        </div>
      
        
        <div style="padding-bottom: 25px; ">
            <button type="submit" class="btn btn-outline-primary offset-md-1">LOGIN</button>
            <a href="./index.php" style="color: #00CED1; text-decoration: none; margin-left: 200px">
                <i class="fas fa-home fa-lg"></i>
            </a>
        </div>
        <div style > 
           
        </div>
       
    
    </form>

</body>
</html>