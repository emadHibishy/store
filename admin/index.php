<?php
    session_start();
    if(isset($_SESSION['email']) && isset($_SESSION['permission']) && $_SESSION['permission'] === 1){
        header('Location:dashboard.php');
    }
    include_once("connection.php");
    include("includes/languages/english.php");
    $pageTitle = lang('LOGIN');
    include("includes/functions/functions.php");
    include("includes/templates/header.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email      = htmlspecialchars($_POST['email']);
        $password   = sha1($_POST['password']);
        
        $stmt = $con->prepare("SELECT email, password, id, username
                               FROM users 
                               WHERE email = ? 
                               AND password = ? 
                               AND permission = 1");
        $stmt->execute([$email,$password]);
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if($count > 0){
            $_SESSION['name']      = $row['username'];
            $_SESSION['ID']         = $row[2];
            $_SESSION['permission'] = 1;
            header('Location:dashboard.php');
            exit();
        }else{
            $_SESSION['error'] = lang('ERROR');
        }
    }
?>
        <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="container">
                <div class="user">
                <i class="fa fa-user-circle"></i>
                </div>
                <h2 class="text-center"><?php echo lang('ADMINLOGIN');?></h2>
                <div class="validate">
                    <?php
                    if(isset($_SESSION['error'])){
                        echo $_SESSION['error'];
                    ?>
                    <script>
                        $('.login .validate').fadeIn(500);
                    </script>
                    <?php
                        unset($_SESSION['error']);
                    }
                    ?>
                </div>
                <input class="form-control" type="text" name="email" placeholder="<?php echo lang('EMAIL');?>" />
                <span class="line"></span>
                <input class="form-control" type="password" name="password" placeholder="<?php echo lang('PASSWORD');?>" autocomplete="off" />
                <span class="line"></span>
                <input class="btn btn-warning btn-block" type="submit" value="<?php echo lang('LOGIN');?>" />
            </div>
        </form>

<?php
    include("includes/templates/footer.php");
?>