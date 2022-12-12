<?php require_once("functions.php");?>
<?php 
    if(isset($_POST['btnlogin'])){
        $con = openConn();

        $username = sanitizeInput($con, $_POST['username']);
        $password = sanitizeInput($con, $_POST['password']);
        
        $password = md5($password);

        $strSql = "
                SELECT * FROM tbl_user
                WHERE username = '$username'
                AND password = '$password'
            ";

       /* if($rsLogin = mysqli_query($con, $strSql)){
            if(mysqli_num_rows($rsLogin) > 0){
                header("location: dashboard.php");
                mysqli_free_result($rsLogin);
            }
            else{
                echo 'Invalid Username/Password';
            }
        }*/
        $rsLogin = getRecord($con, $strSql);
        if(!empty($rsLogin)){
            header("location: dashboard.php");
            mysqli_free_result($rsLogin);
        }
        
        else {
            echo 'ERROR: Could not execute your request!';
        }
       
        closeConn($con);   
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" integrity="sha512-P5MgMn1jBN01asBgU0z60Qk4QxiXo86+wlFahKrsQf37c9cro517WzVSPPV1tDKzhku2iJ2FVgL67wG03SGnNA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/login.css">
    <title>Log In</title>
</head>
<body>
    <div class="container">
    
        <div class="card card-container">            
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="post">
                <input type="text" name="username" id="username" class="form-control" placeholder="User Name" required autofocus>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>                
                <button name="btnlogin" class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
            </form><!-- /form -->            
        </div><!-- /card-container -->
    </div><!-- /container -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js" integrity="sha512-wV7Yj1alIZDqZFCUQJy85VN+qvEIly93fIQAN7iqDFCPEucLCeNFz4r35FCo9s6WrpdDQPi80xbljXB8Bjtvcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    
</body>
</html>