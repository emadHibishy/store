<?php
    ob_start();
    session_start();
    include_once("admin/connection.php");
    include("includes/languages/english.php");
    include("includes/functions/functions.php");
    $prodId     = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : 0;
    $prodExist  = checkExist('id','products',$prodId);
    if($prodExist > 0){
        $product    = getById('products',$prodId);
        $pageTitle  = $product['name'];
        include("includes/templates/header.php");
        include("includes/templates/navbar.php");
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $comment    = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
            $userId     = $_SESSION['id'];
            if(!empty($comment)){
                $query  = $con->prepare("INSERT INTO comments(comment, date, prod_id, user_id)
                                            VALUES(?, NOW(), ?, ?)");
                $query->execute([$comment, $prodId, $userId]);
                if($query->rowCount() > 0){
                    $_SESSION['success']    = lang('COMADDED');
                }else{
                    $_SESSION['err']    = lang('DLTFAIL');
                }
                redir('back');
            }
            
            
        }
        ?>
        <div class="container product">
            <h2 class="text-center"><?php echo $product['name']; ?></h2>
            <div class="row align-items-center">
                <div class="col-sm-3 prod-img">
                    <img src="<?php echo $product['image']; ?>" alt="" class="rounded img-fluid">
                </div>
                <div class="col-sm-9 prod-desc rounded p-2">
                    
                    <p>
                        <span class="h5">
                            <i class="fa fa-dollar fa-fw"></i>
                            <?php echo lang('PRICE'); ?>
                        </span>:
                        <?php echo $product['price']; ?>
                    </p>
                    <p>
                        <span class="h5">
                            <i class="fa fa-calendar fa-fw"></i>
                            <?php echo lang('DATE'); ?>
                        </span>:
                        <?php echo $product['date']; ?>
                    </p>
                    <p>
                        <span class="h5">
                            <i class="fa fa-info fa-fw"></i>
                            <?php echo lang('DESC'); ?>
                        </span>:
                        <?php echo $product['description']; ?>
                    </p>
                    <p>
                        <span class="h5">
                            <i class="fa fa-flag fa-fw"></i>
                            <?php echo lang('COUNTRY'); ?>
                        </span>:
                        <?php echo $product['country']; ?>
                    </p>
                    <p>
                        <span class="h5">
                            <i class="fa fa-user fa-fw"></i>
                            <?php echo lang('USER'); ?>
                        </span>:
                        <?php
                        $user   = getById('users',$product['user_id']) ;
                        echo '<a href="#" class="text-decoration-none">';
                           echo $user['username'];
                        echo '</a>';    
                        ?>
                    </p>
                    <p>
                        <span class="h5">
                            <i class="fa fa-tags fa-fw"></i>
                            <?php echo lang('CATEGORY'); ?>
                        </span>:
                        <?php
                        $cat    = getById('categories',$product['cat_id']) ;
                        echo $cat['name']; 
                        ?>
                    </p>
                </div>
            </div>
            <hr>
            <h3 class="text-center m-3"><?php echo lang('COMMENTS') ?></h3>
            <div class="row align-items-center comments">
                <!-- comments -->
                <?php
                if(isset($_SESSION['success'])){
                    echo '<div class="alert alert-success col-12 text-center">';
                        echo '<p class="lead">'.$_SESSION["success"].'</p>';
                        unset($_SESSION["success"]);
                    echo '</div>';
                }
                if(isset($_SESSION['err'])){
                    echo '<div class="alert alert-danger col-12 text-center">';
                        echo '<p class="lead">'.$_SESSION["err"].'</p>';
                        unset($_SESSION["err"]);
                    echo '</div>';
                }
                $stmt   = $con->prepare("SELECT C.*, U.username ,U.image
                                        FROM comments C INNER JOIN users U
                                        ON C.user_id = U.id
                                        WHERE C.prod_id = ? AND status = 1");
                $stmt->execute([$prodId]);
                $comments = $stmt->fetchAll();
                if($stmt->rowCount() > 0){
                    foreach($comments as $comment){
                        ?>
                        <div class="col-2">
                            <img src="<?php echo $comment['image'];?>" alt="<?php echo $comment['username'];?>" class="img-circle">
                        </div>
                        <div class="col-10 comment">
                            <span class="lead d-inline-block mr-3 text-secondary"><?php echo $comment['username'];?></span>
                            <span class="h6 text-secondary"><?php echo $comment['date'];?></span>
                            <p class="text-primary"><?php echo $comment['comment'];?></p>
                        </div>
                        <hr class="col-12">
                        <?php
                    }
                }else{
                    echo '<div class="col-12 text-center">';
                        echo '<p class="lead">No Comments For This Product</p>';
                    echo '</div>';
                }
               ?>

            </div>
            <div class="row align-items-center add-comment">
                <?php
                // add comment 
                if(isset($_SESSION['user'])){
                    ?>
                    <form action="<?php $_SERVER['PHP_SELF'].'id='.$prodId ?>"method="POST" class="col-12">
                        <div class="row align-items-center">
                            <div class="col-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="comment">
                                </div>
                            </div>
                            <div class="col-3 pr-0">
                                <div class="form-group">
                                    <input type="submit" value="Add Comment" class="btn btn-success d-block w-100">
                                </div>
                            </div>
                        </div>
                    </form>

                <?php
                }
                ?>
            </div>
        </div>
        <?php
        include("includes/templates/footer.php");
    }else{
        include("includes/templates/header.php");
        include("includes/templates/navbar.php");
        ?>
        <div class="container text-center">
            <div class="alert alert-danger">
                <p class="lead">No Such Product Found</p>
            </div>
        </div>
        
        <?php
    }
    ob_end_flush();
?>