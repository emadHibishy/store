<?php
    session_start();
    if(isset($_SESSION['name'])){
        include_once("connection.php");
        include("includes/languages/english.php");
        include("includes/functions/functions.php");
        $pageTitle = lang('USERS');
        include("includes/templates/header.php");
        include("includes/templates/navbar.php");
        $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        if($action=='Manage'){
        //manage users 
            $condition = '';
            if(isset($_GET['status']) && $_GET['status'] == 'pending'){
                $condition = 'AND regStatus = 0';
            }
            $stmt = $con->prepare("SELECT * FROM users WHERE permission !=1 $condition");
            $stmt->execute();
            $rows = $stmt->fetchAll();
        ?>
        <section class="manage">
            <h2 class="text-center highlight"><?php echo lang('MANAGE').lang('USERS');?></h2>
            <div class="container">
            <?php
                if(isset($_SESSION['success'])){
                    echo '<div class="alert alert-success text-center"><p>'. $_SESSION['success'].'</p></div>';
                    unset($_SESSION['success']);
                }elseif(isset($_SESSION['error'])){
                    echo '<div class="alert alert-danger text-center"><p>'. $_SESSION['error'].'</p></div>';
                    unset($_SESSION['error']);
                }
            
            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered text-center tbl">
                        <thead class="table-dark">
                            <tr>
                                <th><?php echo lang('ID')?></th>
                                <th><?php echo lang('USERNAME')?></th>
                                <th><?php echo lang('EMAIL')?></th>
                                <th><?php echo lang('FULLNAME')?></th>
                                <th><?php echo lang('RGSTRDATE')?></th>
                                <th><?php echo lang('CONTROL')?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($rows as $row){
                                echo '<tr>';
                                    echo '<th>'. $row['id'].'</th>';
                                    echo '<td>'. $row['username'].'</td>';
                                    echo '<td>'. $row['email'].'</td>';
                                    echo '<td>'. $row['full_name'].'</td>';
                                    echo '<td>'. $row['Date'].'</td>';
                                    echo '<td>';
                                    if($row['regStatus'] == 0){
                                        echo '<a href="users.php?action=Activate&userId='. $row['id'].'"class="btn btn-info mr-2"><i class="fa fa-check"></i> '.lang("ACTIVATE").'</a>';
                                    }
                                    echo '<a href="users.php?action=Edit&userId='. $row['id'].'"class="btn btn-success mr-2"><i class="fa fa-edit"></i> '.lang("EDIT").'</a>';
                                    echo '<button class="btn btn-danger remove" data-target="'.$row['id'].'"><i class="fa fa-close"></i> '.lang("DELETE").'</button>';
                                    
                                    echo '</td>';
                                echo '</tr>';
                            }
                        ?>         
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="parent">
                <div class="popup">
                    <p class="lead"><?php echo lang('DELCONFIRM').lang('USER');?></p>
                    <button class="btn btn-success cancel mr-3"><?php echo lang('CANCEL');?></button>
                    <?php echo '<a href="" class="btn btn-danger delete">'.lang("DELETE").'</a>';?>
                </div>
            </div>
        </section>
        <?php                  
        }elseif($action == 'AddUser'){
            // add user
            ?>
            <section class="add">
                <h2 class="text-center"><?php echo lang('ADDUSER');?></h2>
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                        <?php
                            if(isset($_SESSION['success'])){?>
                            <div class="alert alert-success">
                                <p class="lead text-center"><?php echo $_SESSION['success'];?></p>
                            </div>
                            <!-- <script>
                                $('.add .alert-success').fadeIn(500);
                            </script> -->
                            <?php
                            unset($_SESSION['success']);
                            }
                            ?>
                            <div class="alert alert-danger">
                                <?php 
                                if(isset($_SESSION['error'])){
                                        echo '<p class="lead">'.$_SESSION['error'].'</p>';
                                    unset($_SESSION['error']);
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                    <form class="form-horizontal" method="POST" action="?action=Insert">
                        <!-- username -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="username" class="col-sm-2 control-label"><?php echo lang('USERNAME');?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-lg" name="username" />
                                </div>  
                            </div>    
                        </div>
                        <!-- email -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="email" class="col-sm-2 control-label"><?php echo lang('EMAIL');?></label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control form-control-lg" name="email" />
                                </div>
                            </div>    
                        </div>
                        <!-- fullname -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="fullname" class="col-sm-2 control-label"><?php echo lang('FULLNAME');?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-lg" name="fullname" />
                                </div>
                            </div>    
                        </div>
                        <!-- password -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="password" class="col-sm-2 control-label"><?php echo lang('PASSWORD');?></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control form-control-lg" name="Password" />
                                    <i class="eye-pass fa fa-eye fa-2x"></i>
                                </div>
                            </div>    
                        </div>
                        <!-- password confirm -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="password-confirm" class="col-sm-2 control-label"><?php echo lang('PASSCONF');?></label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control form-control-lg" name="Password-confirm" />
                                    <i class="eye-pass fa fa-eye fa-2x"></i>
                                </div>
                            </div>    
                        </div>
                        <!-- submit -->
                        <div class="form-group">
                            <div class="row justify-content-end">
                                <div class="col-sm-10 ">
                                    <input type="submit" class="btn btn-info btn-lg col-sm-12" value="<?php echo lang('ADDUSER');?>" />
                                </div>
                            </div>    
                        </div>
                    </form>
                </div>
            </section>
        <?php
        }elseif($action == 'Insert'){
            // insert user
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $username    = htmlspecialchars($_POST['username']);
                $email       = htmlspecialchars($_POST['email']);
                $fullName    = htmlspecialchars($_POST['fullname']);
                $password    = sha1($_POST['Password']);
                $stmt   = $con->prepare("SELECT email FROM users");
                $stmt->execute();
                $rows   = $stmt->fetchAll();
                $emailExist     = checkExist('email','users',$email);
                $usernameExist  = checkExist('username','users',$username);
                if($emailExist < 1 && $usernameExist < 1){
                    $query  = $con->prepare("INSERT INTO 
                                            users(username, email, password, full_name, regstatus, Date)
                                            VALUES(:name, :email, :password, :fullName, :reg, now())");
                    $query->execute([
                        'name'      => $username,
                        'email'     => $email,
                        'password'  => $password,
                        'fullName'  => $fullName,
                        'reg'       => 1
                    ]);
                    if($query->rowCount() > 0){
                        $_SESSION['success'] = lang('INSSUCCESS');
                    }
                }else{
                    if($emailExist > 0){
                        $_SESSION['error'] = lang('EMLEXST');
                    }
                    if($usernameExist > 0){
                        $_SESSION['error'] = lang('USREXST');
                    }
                }
                redir('back');
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
             
        }elseif($action == 'Edit'){
            $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
            if(isset($_SESSION['permission']) || $userId === $_SESSION['ID']){
            
                $stmt = $con->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->execute([$userId]);
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                
                if($count > 0){
                    // echo $row[1];
                
                ?>
                <!--  Edit users page -->
                <section class="edit">
                    <h2 class="text-center"><?php echo lang('EDIT').' '.lang('USER');?></h2>
                    <div class="container">
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                            <?php
                                if(isset($_SESSION['success'])){?>
                                <div class="alert alert-success">
                                    <p class="lead text-center"><?php echo $_SESSION['success'];?></p>
                                </div>
                                <script>
                                    $('.edit .alert-success').fadeIn(500);
                                </script>
                                <?php
                                unset($_SESSION['success']);
                                }?>
                                <div class="alert alert-danger">
                                    <?php
                                    if(isset($_SESSION['error'])){
                                        echo '<p class="lead">'.$_SESSION["error"].'</p>';
                                        unset($_SESSION['error']);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <form class="form-horizontal" method="POST" action="?action=Update">
                            <input type="hidden" name="id" value="<?php echo $userId; ?>">
                            <!-- username -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="username" class="col-sm-2 control-label"><?php echo lang('USERNAME');?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-lg" value="<?php echo $row['username'];?>" name="username" />
                                    </div>  
                                </div>    
                            </div>
                            <!-- email -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="email" class="col-sm-2 control-label"><?php echo lang('EMAIL');?></label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control form-control-lg" value="<?php echo $row['email'];?>" name="email" />
                                    </div>
                                </div>    
                            </div>
                            <!-- fullname -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="fullname" class="col-sm-2 control-label"><?php echo lang('FULLNAME');?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-lg" value="<?php echo $row['full_name'];?>" name="fullname" />
                                    </div>
                                </div>    
                            </div>
                            <!-- password -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="newPassword" class="col-sm-2 control-label"><?php echo lang('PASSWORD');?></label>
                                    <div class="col-sm-10">
                                        <input type="hidden" value="<?php echo $row['password'];?>" name="oldPassword" />
                                        <input type="password" class="form-control form-control-lg" name="newPassword" />
                                        <i class="eye-pass fa fa-eye fa-2x"></i>
                                    </div>
                                </div>    
                            </div>
                            <!-- submit -->
                            <div class="form-group">
                                <div class="row justify-content-end">
                                    <div class="col-sm-10 ">
                                        <input type="submit" class="btn btn-info btn-lg col-sm-12" value="<?php echo lang('UPDATE').lang('USER');?>" />
                                    </div>
                                </div>    
                            </div>
                        </form>
                    </div>
                </section>
        <?php 
                }else{
                    $errMsg = lang('NODATA');
                    redir('users.php',3,$errMsg);
                }
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action == 'Update'){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id         = $_POST['id'];
                $username   = htmlspecialchars($_POST['username']);
                $email      = htmlspecialchars($_POST['email']);
                $fullName   = htmlspecialchars($_POST['fullname']);
                $password   = empty($_POST['newPassword']) ? $_POST['oldPassword'] : sha1($_POST['newPassword']);
                // check if email exists
               $em_query    = $con->prepare("SELECT email FROM users
                                             WHERE email = ? AND id != ?");
               $em_query->execute([$email,$id]);
               $emailExist  = $em_query->fetch();
                // check if username exists
               $name_query    = $con->prepare("SELECT username FROM users
                                             WHERE username = ? AND id != ?");
               $name_query->execute([$username,$id]);
               $usernameExist  = $name_query->fetch();
               if($usernameExist < 1 && $emailExist < 1){
                   $query = $con->prepare(  "UPDATE users 
                                            SET username = ?,
                                            email = ?,
                                            full_name = ?,
                                            password  = ?
                                            WHERE id = ?");
                    $query->execute([$username, $email, $fullName,$password, $id]);
                    if($query->rowCount() > 0){
                        $_SESSION['success'] = lang('UPDSUCCESS');
                    }
               }else{
                    if($emailExist > 0){
                        $_SESSION['error'] = lang('EMLEXST');
                    }
                    if($usernameExist > 0){
                        $_SESSION['error'] = lang('USREXST');
                    }
               }
                redir('back');
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action == 'Remove'){
            $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
            if(isset($_SESSION['permission'])){
                $check  = checkExist('id','users',$userId);
                if($check > 0){
                    $stmt   = $con->prepare('DELETE FROM users WHERE id = :userid');
                    $stmt->bindParam(':userid' , $userId);
                    $stmt->execute();
                    if($stmt->rowCount()){
                        $_SESSION['success'] = lang('USER').lang('DLTSUC');
                    }else{
                        $_SESSION['error']= lang('DLTFAIL');
                    }
                    redir('back');
                }
                $err = lang('NOUSER');
                redir('back',4,$err);
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action == 'Activate'){
            $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0;
            $exist  = checkExist('id', 'users', $userId);
            if($exist > 0){
                $stmt = $con->prepare("UPDATE users SET regStatus = :reg WHERE id = :id");
                $stmt->execute([
                    "reg"   => 1,
                    "id"    => $userId
                    ]);
                if($stmt->rowCount() > 0){
                    $_SESSION['success']    = lang('ACTIVSUC');
                }else{
                    $_SESSION['error']    = lang('ACTIVFAIL');
                }
                redir('users.php');
            }
        }
        include("includes/templates/footer.php");
    }else{
        $errMsg = lang('NOTALLOWED');
        redir('index.php',4);
    }
?>