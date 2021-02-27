<?php
    ob_start();
    session_start();
    if(isset($_SESSION['name'])){
        include_once("connection.php");
        include("includes/languages/english.php");
        $pageTitle = lang('DASHBOARD');
        include("includes/functions/functions.php");
        include("includes/templates/header.php");
        include("includes/templates/navbar.php");
        ?>
        <!-- start dashboard -->
        <div class="container text-center dashboard">
            <h1><?php echo lang('DASHBOARD');?></h1>
            <?php
                if(isset($_SESSION['success'])){
                    echo '<div class="alert alert-success text-center"><p>'. $_SESSION['success'].'</p></div>';
                    unset($_SESSION['success']);
                }elseif(isset($_SESSION['error'])){
                    echo '<div class="alert alert-danger text-center"><p>'. $_SESSION['error'].'</p></div>';
                    unset($_SESSION['error']);
                }
            
            ?>
            <div class="row btns">
                <div class="col-sm-4">
                <a class="btn btn-info btn-lg d-block add-usr" href="users.php?action=AddUser"><i class="fa fa-plus"></i> <?php echo lang('ADD').lang('USER');?></a>
                </div>

                <div class="col-sm-4">
                <a class="btn btn-warning btn-lg d-block add-cat" href="categories.php?action=Add"><i class="fa fa-plus"></i> <?php echo lang('ADD').lang('CATEGORY');?></a>
                </div>

                <div class="col-sm-4">
                <a class="btn btn-primary btn-lg d-block add-product" href="products.php?action=Add"><i class="fa fa-plus"></i> <?php echo lang('ADD').lang('PRODUCT');?></a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="stat">
                        <h4><?php echo lang('TOTAL').lang("USERS");?></h4>
                        <span>
                            <a href="users.php">
                                <?php echo getCount('id', 'users');?>
                            </a>
                        </span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stat">
                        <h4><?php echo lang('PENDING');?></h4>
                        <a href="users.php?status=pending">
                            <span><?php echo checkExist('regStatus','users',0);?></span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stat">
                        <h4><?php echo lang('TOTAL').lang('PRODUCTS');?></h4>
                        <span>
                            <a href="products.php">
                                <?php echo getCount('id', 'products');?>
                            </a>
                        </span>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="stat">
                        <h4><?php echo lang('TOTAL').lang('COMMENTS');?></h4>
                        <span>0</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container latest">
            <div class="row">

            <!-- dashboard new users -->
                <div class="col-md-6 latest__sec">
                    <div class="card">
                        <div class="card-header">
                            <span class="pull-left">
                                <i class="fa fa-users fa-lg"></i>
                                <?php echo lang('NEWUSERS');?>
                            </span>
                            <span class="pull-right toggle-content">
                                <i class="fa fa-minus fa-lg"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-group">
                                <?php
                                    $users  = getLatest('id, username', 'users');
                                    foreach($users as $user){
                                        echo '<li class="list-group-item">'.$user['username'].'
                                            <a href="users.php?action=Edit&userId='.$user['id'].'" class="btn btn-success pull-right">
                                                <i class="fa fa-edit"></i>
                                            Edit</a href="users.php?action=Edit&userId='.$user['id'].'"></li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <!-- dashboard new products -->
                <div class="col-md-6 latest__sec">
                    <div class="card">
                        <div class="card-header">
                            <span class="pull-left">
                                <i class="fa fa-tag fa-lg"></i>
                                <?php echo lang('NEWITEMS');?>
                            </span>
                            <span class="pull-right toggle-content">
                                <i class="fa fa-minus fa-lg "></i>
                            </span>
                        </div>
                        <div class="card-body">
                        <ul class="list-unstyled list-group">
                                <?php
                                    $products  = getLatest('id, name', 'products');
                                    foreach($products as $product){
                                        echo '<li class="list-group-item">'.$product['name'].'
                                            <a href="products.php?action=Edit&prodId='.$product['id'].'" class="btn btn-success pull-right">
                                                <i class="fa fa-edit"></i>
                                            Edit</a href="products.php?action=Edit&prodId='.$product['id'].'"></li>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- dashboard new comments -->
                <div class="col-md-6 latest__sec">
                    <div class="card">
                        <div class="card-header">
                            <span class="pull-left">
                                <i class="fa fa-comments-o fa-lg"></i>
                                <?php echo lang('NEWCOMMS');?>
                            </span>
                            <span class="pull-right toggle-content">
                                <i class="fa fa-minus fa-lg "></i>
                            </span>
                        </div>
                        <div class="card-body" id="comm_cntnt">
                        <?php
                            $stmt       = $con->prepare("SELECT C.*, U.username AS Uname, P.name AS Pname, P.image AS Pimg
                                                            FROM comments C 
                                                            INNER JOIN users U
                                                            ON C.user_id = U.id
                                                            INNER JOIN products P
                                                            ON C.prod_id = P.id
                                                            ");
                            $stmt->execute();
                            $comments   = $stmt->fetchAll();
                            $commNum    = $stmt->rowCount();
                            if($commNum > 0){
                                echo '<ul class="list-unstyled">';
                                    foreach($comments as $comment){
                                        echo '<li class="list-group-item">';
                                            echo '<img class="comment_c" src="../'.$comment['Pimg'].'" alt="'.$comment['Pname'].'" />';
                                            echo '<div class="description">';
                                                echo '<a class="text-decoration-none" href=users.php?action=Edit&userId='.$comment['user_id'].'><h4 class="text-secondary">'.$comment['Uname'].'</h4></a>';
                                                echo '<p class="lead text-primary">'.$comment['comment'].'</p>';
                                            echo '</div>';
                                            if($comment['status'] == 0){
                                                echo '<a href="comments.php?action=Approve&commId='. $comment['id'].'"class="btn d-block text-center btn-info"><i class="fa fa-check"></i> '.lang("APPROVE").'</a>';
                                            }
                                        echo '</li>';
                                    }
                                echo '</ul>';
                            }else{
                                echo '<div class="alert alert-info">';
                                    echo '<p class="lead">No '.lang('NEWCOMMS').'</p>';
                                echo '</div>';
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        <?php
        include('includes/templates/footer.php');
    }else{
        header('Location:index.php');
        exit();;
    }
    ob_end_flush();
?>