<?php
    ob_start();
    session_start();
    include_once("admin/connection.php");
    include("includes/languages/english.php");
    $pageTitle = lang('SIGN');
    include("includes/functions/functions.php");
    if(isset($_SESSION['user'])){
        redir();
    }
    include("includes/templates/header.php");
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(isset($_POST['login'])){
            $email  = htmlspecialchars($_POST['email']);
            $pass   = sha1($_POST['password']);

            $stmt   = $con->prepare("SELECT id, username
                                    FROM users
                                    WHERE email = ?
                                    AND password = ?");
            $stmt->execute([$email, $pass]);
            if($stmt->rowCount() > 0){
                $usr= $stmt->fetch();
                $_SESSION['user']   = $usr['username'];
                $_SESSION['id']     = $usr['id'];
                redir();
            }else{
                $_SESSION['err']    = lang('ERROR');
                redir('sign.php');
            }
        }else{
            $username   = filter_var(($_POST['username']),FILTER_SANITIZE_STRING);
            $email      = filter_var(($_POST['email']),FILTER_SANITIZE_EMAIL);
            $pass       = sha1($_POST['password']);
            $fullName   = filter_var($_POST['full-name'],FILTER_SANITIZE_STRING);
            $checkUser  = checkExist('username','users',$username);
            $checkEmail = checkExist('email','users',$email);
            if($checkUser < 1 && $checkEmail < 1){
                $query  = $con->prepare("INSERT INTO users(username, email, full_name, Date, password)
                                            VALUES(?,?,?,now(),?)");
                $query->execute([$username, $email, $fullName, $pass]);
                if($query->rowCount() > 0){
                    $_SESSION['user']   = $username;
                    redir('index.php');
                }     
            }else{
                if($checkEmail > 0){
                    $_SESSION['err'] = lang('EMLEXST');
                }
                if($checkUser > 0){
                    $_SESSION['err'] = lang('USREXST');
                }
                redir('sign.php');
            }
        }
    }
    ob_end_flush();
?>
<div class="container sign">
    <h2 class="text-center">
        <span class="active" data-target="login"><?php echo lang('LOGIN');?></span> |
        <span data-target="signup"><?php echo lang('SIGNUP');?></span>
    </h2>
    <div class="row justify-content-center align-items-center">
        
        <div class="col-10 col-sm-8 col-md-6 login">
            
            <form action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="POST">
                <div class="alert alert-danger">
                    <?php
                        if(isset($_SESSION['err'])){
                                echo '<p>'.$_SESSION['err'].'</p>';
                                unset($_SESSION['err']);
                        }
                    ?>
                </div>
                <div class="form-group">
                    <input type="email"name="email"class="form-control"placeholder="<?php echo lang('EMAIL');?>">
                    <span>
                        <i class="fa fa-user"></i>
                    </span>
                </div>
                <div class="form-group">
                    <input type="password"name="password"class="form-control"placeholder="<?php echo lang('PASSWORD');?>">
                    <span>
                        <i class="fa fa-lock"></i>
                    </span>
                </div>
                <input type="submit" name="login" class="btn btn-danger d-block w-100" value="<?php echo lang('LOGIN'); ?>">
            </form>
        </div>
        <div class="col-10 col-sm-8 col-md-6 signup">
            <form action="<?php echo $_SERVER['PHP_SELF'] ;?>" method="POST">
                <div class="alert alert-danger">
                <?php
                        if(isset($_SESSION['err'])){
                                echo '<p>'.$_SESSION['err'].'</p>';
                                unset($_SESSION['err']);
                        }
                    ?>
                </div>
                <div class="form-group">
                    <input type="text"name="username"class="form-control"placeholder="<?php echo lang('USERNAME');?>">
                </div>
                <div class="form-group">
                    <input type="email"name="email"class="form-control"placeholder="<?php echo lang('EMAIL');?>">
                </div>
                <div class="form-group">
                    <input type="text"name="full-name"class="form-control"placeholder="<?php echo lang('FULLNAME');?>">
                </div>
                <div class="form-group">
                    <input type="password"name="password"class="form-control password"placeholder="<?php echo lang('PASSWORD');?>">
                </div>
                <div class="form-group">
                    <input type="password"name="password-confirm"class="form-control password-confirm"placeholder="<?php echo lang('PASSCONF');?>">
                </div>
                <input type="submit" name="signup" class="btn btn-danger d-block w-100" value="<?php echo lang('SIGNUP'); ?>">
            </form>
        </div>
    </div>
</div>

<?php
    include("includes/templates/footer.php");
?>