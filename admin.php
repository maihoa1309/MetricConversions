<?php
    require_once('utils.php');
    session_start();
    if(!($_SESSION['login'] ?? '')){
        redirect('./login.php');
    }
    $currency_codes = array("KRW", "JPY", "USD", "AUD", "NDT");

    $tables = ['articles', 'faqs', 'exchange_rates', 'infor_units'];

    $measures = ['Length', 'Area', 'Volume', 'Currency', 'Mass', 'Temperature'];

    $error = [  'measure' => '',
                'unit' => '',
                'history' => '',
                'password' => '',
                'confirm_password' => ''];

    if(($click = $_GET['click'] ?? '') && in_array($click, $tables)){
        $sql = "SELECT * FROM $click";
        $rows = sqlGetAll($sql);
        
    } else {
        //Redirect
    }

    // edit infor
    if($id_infor = $_GET['id_infor'] ?? ''){
        $sql = "SELECT * FROM infor_units WHERE id = ?";
        $row = sqlGetAll($sql, 'd', $id_infor)[0];
        
        if ($_POST){
            $measure = $_POST['measure'];
            $unit = $_POST['unit'];
            $history = $_POST['history'];
            $measurement = $_POST['measurement'];
            if (!($unit)){
                $error['unit'] = 'Unit is required';
            }
            if (!($history)){
                $error['history'] = 'History is required';
            }


            $sql = "UPDATE infor_units
                SET measure = ?, unit = ?, measurement = ?, history = ?
                WHERE id = ?";
            if (sqlExecute($sql, 'ssssd', $measure, $unit, $measurement,  $history, $id_infor) and !empty($error)) {
            
                redirect('./admin.php?click=infor_units');
            } else {
                if(!sqlExecute($sql, 'ssssd', $measure, $unit, $measurement,  $history, $id_infor)){
                    $error['measure'] = "This unit still exits! Please select other unit."; 
                }
            }
        }
    }
    if ($delete_infor = $_GET['delete_infor'] ?? ''){
        $sql = "DELETE FROM infor_units WHERE id = ?";
        sqlExecute($sql, 'd', $delete_infor);
        redirect('./admin.php?click=infor_units');
    }

    // edit rate
    if($_GET['edit'] ?? ''){
        $sql = "SELECT * FROM exchange_rates";
        $rows = sqlGetAll($sql, '', );  
        $old_rates = [];
        foreach ($rows as $row){
            $old_rates += [$row['currency_code'] => $row['rate']];
        }
        if ($_POST){
            $rates = $_POST['rates'] ;
            $sql = "DELETE FROM exchange_rates";
            sqlExecute($sql, '',);
    
            foreach ($rates as $code => $rate){
                $sql = "INSERT INTO exchange_rates (currency_code, rate) values ( ?, ?)";
                sqlExecute($sql, 'sd', $code, $rate);
            }
            redirect('./admin.php?click=exchange_rates');
            // print_r($_POST);
            // print_r($_POST['rate']);
            // exit;
        }
    }
    

    // edit faqs
    if($id_faqs = $_GET['id_faqs'] ?? ''){
        $sql = "SELECT * FROM faqs WHERE id = ?";
        $row = sqlGetAll($sql, 'd', $id_faqs)[0];
        if ($_POST){
            $measure = $_POST['measure'];
            $ques = $_POST['ques'];
            $ans = $_POST['ans'];
            
            $sql = "UPDATE faqs
                SET measure = ?, ques = ?, ans = ?
                WHERE id = ?";
                
            sqlExecute($sql, 'sssd', $measure, $ques, $ans, $id_faqs);
            redirect('./admin.php?click=faqs');
        }
    }
    if ($delete_faqs = $_GET['delete_faqs'] ?? ''){
        $sql = "DELETE FROM faqs WHERE id = ?";
        sqlExecute($sql, 'd', $delete_faqs);
        redirect('./admin.php?click=faqs');
    }

    // edit article
    if($id_article = $_GET['id_article'] ?? ''){
        $sql = "SELECT * FROM articles WHERE id = ?";
        $row = sqlGetAll($sql, 'd', $id_article)[0];
    

        if ($_POST){
            $title = $_POST['title'];
            $overview = $_POST['overview'];
            $defining = $_POST['defining'];
            $history = $_POST['history'];
            
            $sql = "UPDATE articles
                SET title = ?, overview = ?, defining = ?, history = ?
                WHERE id = ?";
                // echo $sql;

            sqlExecute($sql, 'ssssd',$title, $overview, $defining, $history, $id_article);
            redirect('./admin.php?click=articles');
        }
    }
    if ($delete_article = $_GET['delete_article'] ?? ''){
        $sql = "DELETE FROM articles WHERE id = ?";
        sqlExecute($sql, 'd', $delete_article);
        redirect('./admin.php?click=articles');
    }

    // add 
    if(($_GET['add'] ?? '') == 'unit'){
        if($_POST){
            $measure = $_POST['measure'];
            $unit = $_POST['unit'] ?? '';
            $history = trim($_POST['history'] ??'');
            $measurement = $_POST['measurement'];

            if (!($unit)){
                $error['unit'] = 'Unit is required';
            }
            if (!($history)){
                $error['history'] = 'History is required';
            }

            
            $sql = "INSERT INTO infor_units ( measure, unit, history, measurement)
                    VALUES ( ?, ?, ?, ?)";
            if (sqlExecute($sql, 'ssss', $measure, $unit, $history, $measurement) or !empty($error)) {
                redirect('./admin.php?click=infor_units');
            } else {
                if(!sqlExecute($sql, 'ssssd', $measure, $unit, $measurement,  $history, $id_infor)){
                    $error['measure'] = "This unit still exits! Please select other unit."; 
                }
            }
        }
    }

    if(($_GET['add'] ?? '') == 'faqs'){
        if($_POST){
            $measure = $_POST['measure'];
            $ques = $_POST['ques'];
            $ans = $_POST['ans'];
        

            $sql = "INSERT INTO faqs ( measure, ques, ans)
                    VALUES ( ?, ?, ?)";
            
            sqlExecute($sql, 'sss', $measure, $ques, $ans);
            redirect('./admin.php?click=faqs');
        }
    }

    if(($_GET['add'] ?? '') == 'article'){
        if($_POST){
            $title = $_POST['title'];
            $overview = $_POST['overview'];
            $defining = $_POST['defining'];
            $history = $_POST['history'];
        

            $sql = "INSERT INTO articles ( title, overview, defining, history)
                    VALUES ( ?, ?, ?, ?)";
            
            sqlExecute($sql, 'ssss', $title, $overview, $defining, $history);
            redirect('./admin.php?click=articles');

        }
    }

    if($change = $_GET['change'] ?? ''){
        if($_POST){
            $password = md5($_POST['password']);
            $new_password = md5($_POST['new_password']);
            $confirm_password = md5($_POST['confirm_password']);
            $id = intval($_SESSION['id']);
            $sql = "SELECT * FROM login WHERE id = ?";
            $row = sqlGetAll($sql, 'd', $id)[0];
            if ( $password == $row['password'] and $confirm_password == $new_password){
                $sql = "UPDATE login SET password = ? WHERE id = ?";
                echo $sql;
                sqlExecute($sql, 'sd', $new_password, $id);
                redirect('./admin.php');
            }else{
                if(!($password == $row['password'])){
                    $error['password'] = 'Current password is incorrect!';
                }
                if (!($confirm_password == $new_password)){
                    $error['confirm_password'] = 'Confirm password and new password do not match!';
                }
            }

        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="admin.css">   
    <title>For admin</title>
</head>
<body>
    <div class="sidebar">
        <header style="text-align: center;">
            <a href="./index.php" style="color: white; text-decoration: white">
                <i class="fas fa-home"></i>
            </a>
            &nbsp;Menu
        </header>
        <ul> 
            <li><a href="./admin.php?click=infor_units" 
                <?php
                    if(($_GET['click'] ?? '')=="infor_units" or $_GET['id_infor'] ?? '' or ($_GET['add'] ?? '') == 'unit'):
                ?> class = "active"
                <?php endif;?>>Information about units</a>
            </li>
            <li><a href="./admin.php?click=exchange_rates"
                <?php
                    if(($_GET['click'] ?? '')=='exchange_rates' or ($_GET['edit'] ?? '') == 'rates'):
                ?> class = "active"
                <?php endif;?>>Exchange rate</a>
            </li>
            <li><a href="./admin.php?click=faqs"
                <?php
                    if(($_GET['click'] ?? '')=='faqs' or $_GET['id_faqs'] ?? '' or ($_GET['add'] ?? '') == 'faqs' ):
                ?> class = "active"
                <?php endif;?>>FAQs</a>
            </li>
            <li><a href="./admin.php?click=articles"
                <?php
                    if(($_GET['click'] ?? '')=='articles' or $_GET['title_articles'] ?? '' or ($_GET['add'] ?? '') == 'article'):
                ?> class = "active"
                <?php endif;?>>Articles</a>
            </li>  
            <li><a href="./admin.php?change=pass"
                <?php
                    if(($_GET['change'] ?? '')=='pass'):
                ?> class = "active"
                <?php endif;?>>Change password</a>
            </li> 
            <li>
                <a href="./login.php" class = "logout">
                    <i class="fas fa-sign-out-alt fa-rotate-180 fa-2x"></i>
                </a>
            </li>   
          
           
        </ul> 
    </div>

    <?php if(($_GET['click'] ?? '')=="infor_units" or $_GET['id_infor'] ?? '' ):?>
        <table class="table" style="margin-left: 243px;width: 80%;">
            <div>
                <h3 style="margin-left: 600px; line-height: 45px;" >Information about unit</h3>
                <?php if (($id_infor = $_GET['id_infor'] ?? '')): ?>
                    <i><h6 style="text-align: right; margin-right: 15px;color:#16b7b9 ">Now you can edit information</h6></i>
                <?php endif; ?>
            </div>
            <button class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 300px; margin-left: 300px; margin-top: -38px; border:none;">
                <a href="./admin.php?add=unit">Add new unit</a>    
            </button>
           
            <thead style="text-align: center;">
                <th>#</th>
                <th>Measure</th>
                <th style="width: 16%">Unit</th>
                <th>History</th>
                <th>Measurement</th>
            </thead>
            <?php if ($id_infor = $_GET['id_infor'] ?? ''): ?>
                <?php ?>
                <form action="" method="POST">
                    <tr>
                        <td>Edit</td>
                        <td>
                            <select name="measure"
                                <?php if ($error['measure'] ?? ''):  ?>
                                    style="border: 1px solid red; border-radius: 5px;"
                                <?php endif; ?>> 
                                <?php foreach($measures as $measure): ?>
                                    <option value="<?php echo $measure;?>" 
                                    <?php if($_POST['measure'] ?? ''){
                                        if (($_POST['measure'] ?? '') == $measure){
                                            echo 'selected';
                                        }
                                    } else if($row['measure'] == $measure){
                                        echo 'selected';
                                    }  ?>>
                                        <?php echo $measure;?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input class="form-control" style="border:none;border-bottom: 0.5px solid grey;
                            <?php if($error['unit'] ?? ''): ?> 
                                border-bottom: 1px solid red;   
                            <?php endif; ?>"
                            placeholder = "<?php if($error['unit'] ?? ''){
                                echo $error['unit'];
                            }?>"
                            type="text" value='<?php if ($unit ?? ''){
                                echo $unit;
                            } else{
                                echo $row['unit'];
                            }?>' size="6" name = 'unit' >
                        </td>
                        <td>
                            <textarea class="form-control" style="border-width: 0.5px;
                            <?php if($error['history'] ?? ''): ?> 
                                border: 1px solid red;   
                            <?php endif; ?>"
                            <?php if($error['history'] ?? ''):?>
                                placeholder = "<?php echo $error['history']; ?>"
                            <?php endif; ?> type="text"  name = 'history' cols="35" rows="10"><?php  if ($history ?? ''){
                                echo $history;
                            } else {
                                echo $row['history'];
                            } ?></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" style="border-width: 0.5px;" type="text"  name = 'measurement' cols="35" rows="10"><?php echo $row['measurement'] ?></textarea>
                        </td>
                    </tr>

                    <button type="submit" class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 400px; margin-left: 1100px">
                        Save
                    </button>
                    <button class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 400px; margin-left: 930px">
                        <a href="./admin.php?delete_infor=<?php echo $row['id']; ?>">Delete Information</a>    
                    </button>
                </form>
            <?php else: ?>
                <?php foreach ($rows as $row):?>
                    <tr>
                        <td style="text-align: center;">
                            <a href="./admin.php?id_infor=<?php echo $row['id']; ?>">Edit</a>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $row['measure']; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $row['unit'];?>
                        </td>
                        <td  style="text-align: center;">
                            <?php echo $row['history'];?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $row['measurement'];?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            
        </table>
        <div class="error" style="color: red; font-size: 70%;margin-top: 20px; margin-left: 300px;">
            <?php if($error['measure'] ?? ''){
                echo $error['measure'];
            }?>        
        </div>
       
    <?php endif; ?> 
    

    <?php if(($_GET['click'] ?? '')=='exchange_rates' or ($_GET['edit'] ?? '') == 'rates'): ?>
        <table class="table <?php if (!($edit_rates= $_GET['edit'] ?? '')): ?> table-hover <?php endif;?>" style="margin-left: 243px;width: 80%;<?php if (!($edit_rates= $_GET['edit'] ?? '')): ?> margin-top: 35px; <?php endif;?>">
            <div>
                <h3 style="margin-left: 650px; line-height: 45px;" >Exchange rates</h3>
                <?php if ($edit_rates = $_GET['edit'] ?? ''): ?>
                    <i><h6 style="text-align: right; margin-right: 15px;color:#16b7b9 ">Now you can edit exchange rate</h6></i>
                <?php endif; ?>
            </div>
            <?php if (!($edit_rates= $_GET['edit'] ?? '')): ?>
                <button class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-left: 300px; margin-top: -15px; border:none;">
                    <a href="./admin.php?edit=rates">Edit rates</a>    
                </button>
            <?php endif;?>
            <thead style="text-align: center;">
                <th>Currency Code</th>
                <th>Rate(VDN)</th>
            </thead>
            <?php if (($_GET['edit'] ?? '') == 'rates'): ?>
                <form action="" method="POST">
                    <?php foreach ($currency_codes as $code): ?>
                        <tr>
                            <td style="text-align: center;">
                                <?php echo $code?>
                            </td>
                            <td style="text-align: center;">
                                <input class="form-control"  
                                type="text" name = "rates[<?php echo $code; ?>]" 
                                value="<?php echo $old_rates[$code] ?? '' ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 400px; margin-left: 1100px">
                        Save
                    </button>
                </form>
            <?php else:?>
                <?php foreach ($rows as $row):?>
                    <tr>
                        <td style="text-align: center;">
                            <?php echo $row['currency_code'];?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $row['rate'];?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    <?php endif;?>
  

    <?php if(($_GET['click'] ?? '')=="faqs" or $_GET['id_faqs'] ?? '' ):?>
        <table class="table" style="margin-left: 243px;width: 80%;">
            <div>
                <h3 style="margin-left: 735px; line-height: 45px;" >FAQs</h3>
                <?php if (($id_faqs = $_GET['id_faqs'] ?? '')): ?>
                    <i><h6 style="text-align: right; margin-right: 15px;color:#16b7b9 ">Now you can edit FAQs</h6></i>
                <?php endif; ?>
            </div>
            <button class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 300px; margin-left: 300px; margin-top: -38px; border:none;">
                <a href="./admin.php?add=faqs">Add new FAQs</a>    
            </button>
            <thead style="text-align: center;">
                <th>#</th>
                <th>Measure</th>
                <th>Question</th>
                <th>Answer</th>
            </thead>
            <?php if ($id_faqs = $_GET['id_faqs'] ?? ''): ?>
                <form action="" method="POST">
                    <tr>
                        <td>Edit</td>
                        <td>
                            <select name="measure"> 
                                <?php foreach($measures as $measure): ?>
                                    <option value="<?php echo $measure;?>" <?php if($row['measure'] == $measure){
                                        echo 'selected';
                                        }?>>
                                        <?php echo $measure;?>
                                    </option>
                                <?php endforeach; ?>
                            </select>                        </td>
                        <td>
                            <textarea class="form-control" style="border-width: 0.5px;" type="text"  name = 'ques' cols="35" rows="10"><?php echo $row['ques'] ?></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" style="border-width: 0.5px;" type="text"  name = 'ans' cols="35" rows="10"><?php echo $row['ans'] ?></textarea>
                        </td>
                    </tr>
                    <button type="submit" class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 400px; margin-left: 1100px">
                        Save
                    </button>
                    <button class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 400px; margin-left: 950px">
                        <a href="./admin.php?delete_faqs=<?php echo $row['id']; ?>">Delete FAQs</a>    
                    </button>
                </form>
            <?php else: ?>
                <?php foreach ($rows as $row):?>
                    <tr>
                        <td style="text-align: center;">
                            <a href="./admin.php?id_faqs=<?php echo $row['id']; ?>">Edit</a>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $row['measure']; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $row['ques'];?>
                        </td>
                        <td  style="text-align: center;">
                            <?php echo $row['ans'];?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    <?php endif; ?>

    <?php if(($_GET['click'] ?? '')=="articles" or $_GET['id_article'] ?? '' ):?>
        <table class="table" style="margin-left: 242px;width: 80%;">
            <div>
                <h3 style="margin-left: 650px; line-height: 45px;" >Some articles</h3>
                <?php if (($id_infor = $_GET['id_article'] ?? '')): ?>
                    <i><h6 style="text-align: right; margin-right: 15px;color:#16b7b9 ">Now you can edit article</h6></i>
                <?php endif; ?>
            </div>
            <button class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-left: 300px; margin-top: -38px; border:none;">
                <a href="./admin.php?add=article">Add new article</a>    
            </button>
           
            <thead style="text-align: center;">
                <th>#</th>
                <th>Title</th>
                <th>Overview</th>
                <th>Defining</th>
                <th>History</th>
            </thead>
            <?php if ($title_article = $_GET['id_article'] ?? ''): ?>
                <form action="" method="POST">
                    <tr>
                        <td>
                            Edit
                        </td>
                        <td>
                            <input class="form-control" style="border:none;border-bottom: 0.5px solid grey;" type="text" type="text" value='<?php echo $row['title']; ?>' name = 'title'>
                        </td>
                        <td>
                            <textarea class="form-control" style="border-width: 0.5px;" type="text"  name = 'overview' cols="30" rows="10"><?php echo $row['overview'] ?></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" style="border-width: 0.5px;" type="text"  name = 'defining' cols="30" rows="10"><?php echo $row['defining'] ?></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" style="border-width: 0.5px;" type="text"  name = 'history' cols="30" rows="10"><?php echo $row['history'] ?></textarea>
                        </td>
                    </tr>
                    <button type="submit" class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 400px; margin-left: 1100px">
                        Save
                    </button>
                    <button class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 400px; margin-left: 950px">
                        <a href="./admin.php?delete_article=<?php echo $row['id']; ?>">Delete article</a>    
                    </button>
                </form>
            <?php else: ?>
                <?php foreach ($rows as $row):?>
                    
                    <tr>
                        <td style="text-align: center;">
                            <a href="./admin.php?id_article=<?php echo $row['id']; ?>">Edit</a>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $row['title']; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $row['overview']; ?>
                        </td>
                        <td style="text-align: center;">
                            <?php echo $row['defining'];?>
                        </td>
                        <td style="text-align: center;" >
                            <?php echo $row['history'];?>
                        </td>
               
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    <?php endif; ?> 



    <?php if(($_GET['add'] ?? '') == 'unit'  ): ?>
        <h3  style="margin-left: 550px; line-height: 85px"><i>Fill in the form to add new unit</i></h3>
        <form action="" method = "post" class="form-group" style="margin-left: 25%;" >
            <div class="row" style="width: 99%;">
                <label style="margin-left: 10px;">Measure:</label>
                <select name="measure"
                <?php if ($error['measure'] ?? ''):  ?>
                    style="border: 1px solid red; border-radius: 5px;"
                <?php endif; ?>> 
                    <?php foreach($measures as $measure): ?>
                        <option value="<?php echo $measure;?>"  
                                <?php if ($measure == ($_POST['measure'] ?? '') ){
                                echo 'selected';}?>>
                            <?php echo $measure;?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label class="offset-md-1">Unit:</label>
                <input type="text" class="form-control"  
                    style="border: none; width: 37%;border-bottom: 0.5px solid grey; margin-left: 20px;
                    <?php if($error['unit'] ?? ''): ?> 
                        border-bottom: 1px solid red;   
                    <?php endif; ?>"
                    placeholder = "<?php if($error['unit'] ?? ''){
                        echo $error['unit'];
                    }?>"
                    name="unit" value = "<?php echo $unit ?? ''; ?>"
                    >
            </div>

            <div class="row" style="width: 99%;margin-top: 25px;">
                <label style="margin-left: 10px;">History:</label>
                <textarea name="history" class="form-control"  rows="10"
                style="border: none; width: 37%; margin-left: 20px; border: 0.5px solid grey;
                <?php if($error['history'] ?? ''): ?> 
                    border: 1px solid red;   
                <?php endif; ?>"
                <?php if($error['history'] ?? ''):?>
                    placeholder = "<?php echo $error['history']; ?>"
                <?php endif; ?>
                ><?php echo $history ?? ''?></textarea>
                

                <label style="margin-left: 10px">Measurement:</label>
                <textarea name="measurement" class="form-control"  rows="10"
                style="border: none; width: 37%; margin-left: 20px; border: 0.5px solid grey;" 
                ><?php echo $measurement ?? ''?></textarea>
            </div>
            <div class="error" style="color: red; font-size: 70%;margin-top: 20px">
                <?php if($error['measure'] ?? ''){
                    echo $error['measure'];
                } ?>        
            </div>
            <button type="submit" class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 50px; margin-left: 850px;">
                ADD
            </button>
        </form>
    <?php endif; ?>

    <?php if(($_GET['add'] ?? '') == 'faqs'): ?>
        <h3  style="margin-left: 550px; line-height: 85px"><i>Fill in the form to add new FAQs</i></h3>
        <form action="" method = "post" class="form-group" style="margin-left: 25%;" >
            <div class="row" style="width: 99%;">
                <label style="margin-left: 10px;">Measure:</label>
                <input type="text" class="form-control"  
                style="border: none; width: 84%;border-bottom: 0.5px solid grey; margin-left: 20px;"
                name="measure">

                
            </div>

            <div class="row" style="width: 99%;margin-top: 25px;">
                <label style="margin-left: 10px;">Question:</label>
                <textarea name="ques" class="form-control "  rows="10"
                style="border: none; width: 37%; margin-left: 30px; border: 0.5px solid grey;" ></textarea>

                <label style="margin-left: 10px">Answer:</label>
                <textarea name="ans" class="form-control"  rows="10"
                style="border: none; width: 37%; margin-left: 20px; border: 0.5px solid grey;" ></textarea>
    
            </div>

            <button type="submit" class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 50px; margin-left: 850px;">
                ADD
            </button>
        </form>
    <?php endif; ?>

    <?php if(($_GET['add'] ?? '') == 'article'): ?>
        <h3  style="margin-left: 550px; line-height: 80px"><i>Fill in the form to add new article</i></h3>
        <form action="" method = "post" class="form-group" style="margin-left: 25%;" >
            <div class="row" style="width: 99%;">
                <label style="">Title:</label>
                <input type="text" class="form-control"  
                style="border: none; width: 84%;border-bottom: 0.5px solid grey; margin-left: 20px;"
                name="title">
            </div>

            <div class="row" style="width: 99%;margin-top: 20px;">
                <label>Overview:</label>
                <textarea name="overview" class="form-control "  rows="4"
                style="border: none; width: 82%; margin-left: 15px; border: 0.5px solid grey;" ></textarea>
            </div>

            <div class="row"  style="width: 99%;margin-top: 20px;">
                <label>Defining:</label>
                    <textarea name="defining" class="form-control"  rows="4"
                    style="border: none; width: 82%; margin-left: 20px; border: 0.5px solid grey;" ></textarea>
            </div>

            <div class="row"  style="width: 99%;margin-top: 20px;">
                <label>History:</label>
                    <textarea name="history" class="form-control"  rows="6"
                    style="border: none; width: 82%; margin-left: 30px; border: 0.5px solid grey;" ></textarea>
            </div>

            <button type="submit" class="btn btn-outline-primary offset-md-10" style=" margin-top: 20px; margin-left: 850px;">
                ADD
            </button>
        </form>
    <?php endif; ?>

    <?php if(($_GET['change'] ?? '') == 'pass'): ?>
        <h3 style="margin-left: 600px; line-height: 45px;" >Change password for admin</h3>
        <form action="" method = "post" class="form-group" style="margin-left: 25%; margin-top: 30px;">
            <div class="row" style="width: 99%">
                <label class="offset-md-3 col-md-2"> Current password:</label>
                <input type="password" name="password" class="form-control"  
                style=" width: 25%;
                <?php if ($error['password'] ?? ''): ?>
                    border: 1px solid red;
                <?php endif; ?>" 
                value="<?php echo $_POST['password'] ?? '' ?>">
                <div style = "font-size: 70%; color: red; margin-left:20px;margin-top: 10px;">
                    <?php echo $error['password'] ?? ''; ?>
                </div>
            </div>
            <div class="row" style="width: 99%;  margin-top: 20px">
                <label class="offset-md-3 col-md-2"> New password:</label>
                <input type="password" name="new_password" class="form-control"  
                style=" width: 25%;" 
                value = <?php echo $_POST['new_password'] ?? '' ?>>
            </div>
            <div class="row" style="width: 99%;  margin-top: 20px">
                <label class="offset-md-3 col-md-2"> Confirm password:</label>
                <input type="password" name="confirm_password" class="form-control"  
                style="width: 25%;
                <?php if ($error['confirm_password'] ?? ''): ?>
                    border: 1px solid red;
                <?php endif; ?>"
                value = <?php echo $_POST['confirm_password'] ?? '' ?>>
                <div style = "font-size: 70%; color: red; margin-left:20px;margin-top: 10px;">
                    <?php echo $error['confirm_password'] ?? ''; ?>
                </div>
            </div>

            <button type="submit" class="btn btn-outline-primary offset-md-10" style="position: absolute; margin-top: 50px; margin-left: 600px;">
                Change
            </button>
        </form>
    <?php endif;?>


</body>
</html>