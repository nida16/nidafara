<?php
$servername = "localhost";
$database = "login";
$username_db = "root";
$pass     = "";
$koneksi = mysqli_connect($servername,$username_db,$pass,$database);


$err = "";
$username = "";
$password = "";
$ingataku = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ingataku = $_POST['ingataku'];

    if($username == '' or $password == ''){
        $err .= "<li>silahkan masukkan username dan password.</li>";
    }else{
        $sql1 = "select * From tb_login  where username = '$username'";
        $q1   = mysqli_query($koneksi,$sql1);
        $r1   = mysqli_fetch_array($q1);

        if($r1['username'] == ''){
            $err  .= "<li>username <b>$username</b> tidak tersedia.</li>";
        }elseif($r1['password'] != "$password"){
            $err  .= "<li>password yang dimasukkan tidak sesuai.</li>";
        }

        if(empty($err)){
            $_SESSION['session_username'] = $username;
            $_SESSION['session_password'] = $password;

            if($ingataku == 1){
                $cookie_name = "cookie_username";
                $cookie_value = $username;
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name,$cookie_value,$cookie_time,"/");

                $cookie_name = "cookie_password";
                $cookie_value = $password;
                $cookie_time = time() + (60 * 60 * 24 * 30);
                setcookie($cookie_name,$cookie_value,$cookie_time,"/");
            }
            header("location:lanjutan.php");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet"
    id="bootstrap-css">
</head>
<body>
<div class="container my-4">
    <div id="loginbox" style="margin-top: 5opx;" class="mainbox col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Login dan masuk ke sistem</div>
            </div>
            <div style="padding-top: 30px;" class="panel-body">
                <?php if($err){ ?>
                    <div id="login-alert" class="alert alert-danger col-sm-12">
                        <ul><?php echo $err ?></ul>
                    </div>
                <?php } ?>
                <form id="loginform" class="form-horizontal" action="" method="post" role="form">
                    <div style="margin-bottom: 25px;" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon gliphicon-user"></i></span>
                        <input id="login-username" type="text" class="form-control" name="username"  value="<?php echo $username ?>" 
                        placeholder="username">
                    </div>
                    <div style="margin-bottom: 25px;" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password" 
                        placeholder="password">
                    </div>
                    <div class="input-group">
                        <div class="checkbox">
                        <label>
                            <input id="login-remember" type="checkbox" name="ingataku" value="1"
                            <?php if($ingataku == '1') echo "checked"?>> Ingat Aku
                        </label>
                        </div>
                    </div>
                    <div style="margin-top: 10px;" class="form-group">
                        <div class="col-sm-12 controls">
                            <input type="submit" name="login" class="btn btn-success"
                            value="Login"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
