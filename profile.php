<?php
    ob_start();
    ini_set('display_errors','On');
    error_reporting(E_ALL);

    session_start();
    if(isset($_SESSION['name']) || isset($_SESSION['ID'])){
        $_SESSION['user']   = $_SESSION['name'];
        $_SESSION['id']     = $_SESSION['ID'];
    }
    include_once("admin/connection.php");
    include("includes/languages/english.php");
    $pageTitle = lang('PROFILE');
    include("includes/functions/functions.php");
    include("includes/templates/header.php");
    include("includes/templates/navbar.php");
    $_SESSION['status'] = isActivate($_SESSION['user']);
    // update user image
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $imgName    = $_FILES['img']['name'];
        $allowedExt = ['jpeg', 'jpg', 'png'];
        $imgSplit   = explode('.',$imgName);
        $imgExt     = strtolower(end($imgSplit));
        if(!empty($imgName) && in_array($imgExt,$allowedExt)){
            $image  = date('d-m-Y',time()).'_'.rand(0,100000).$imgName;
            move_uploaded_file($_FILES['img']['tmp_name'],"uploads/$image");
            $updt   = $con->prepare("UPDATE users SET image = ?");
            $updt->execute(["uploads/$image"]);
            redir('profile.php');
        }
    }
    if(isset($_SESSION['user'])){
        $stmt   = $con->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['id']]);
        $info   = $stmt->fetch();
?>
<div class="profile">
    <div class="parent">
        <div class="popup">
            <h3 class="text-center m-2">Change photo</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="img ">Image</label>
                    <input type="file" class="form-control form-control-lg prod-img" name="img" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-lg d-block w-100" value="Confirm">
                </div>
            </form>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-11 cover">
                <div class="background">
                    <div class="insider">
                        <i class="fa fa-photo fa-2x"></i>
                    </div>
                    <img src="<?php echo $info['image']; ?>" alt="<?php echo $info['username']; ?>">
                    <h2 class="text-center"><?php echo $info['username']; ?></h2>
                </div>
            </div>
            <!-- info -->
            <div class="col-10 block">
                <div class="card info">
                    <div class="card-header bg-primary ">
                        INFORMATION
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-unstyled">
                            <li class="list-group-item">
                                <span class="h5">
                                    <i class="fa fa-unlock-alt fa-fw"></i>
                                    Name: 
                                </span>
                                <?php echo $info['username']; ?>
                            </li>
                            <li class="list-group-item">
                                <span class="h5">
                                    <i class="fa fa-envelope-o fa-fw"></i>
                                    Email: 
                                </span>
                                <?php echo $info['email']; ?>
                            </li>
                            <li class="list-group-item">
                                <span class="h5">
                                    <i class="fa fa-user fa-fw"></i>
                                    Full Name: 
                                </span>
                                <?php echo $info['full_name']; ?>
                            </li>
                            <li class="list-group-item">
                                <span class="h5">
                                    <i class="fa fa-calendar fa-fw"></i>
                                    Register Date: 
                                </span>
                                <?php echo $info['Date']; ?>
                            </li>
                            <li class="list-group-item">
                                <span class="h5">
                                    <i class="fa fa-star fa-fw"></i>
                                    Fav Category: 
                                </span>
                                
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- products -->
            <div class="col-10 block">
                <div class="card  prods">
                    <div class="card-header bg-primary">
                        <?php echo lang('PRODUCTS'); ?>
                        <a href="addProd.php" class="btn btn-secondary pull-right">
                            <i class="fa fa-plus"></i>
                            Add Product
                        </a>
                    </div>
                    <div class="card-body">
                    <div class="row align-items-center ">
                        <?php
                        foreach(getProds("user_id" , $info['id'], 0) as $prod){
                            ?>
                            <div class="col-sm-6 col-md-4 col-lg-3">
                                <div class="card text-center product">
                                    <div class="card-header p-0">
                                        <span class="price"><?php echo $prod['price']; ?></span>
                                        <img src="<?php echo $prod['image']; ?>" class="card-img-top" alt="">
                                    </div>
                                    <div class="card-body">
                                        <?php
                                        if($prod['approve'] == 0){
                                            echo '<div class="not-approved">'.lang('NOTAPPROVE').'</div>';
                                            echo "<h5>".$prod['name']."</h5>";
                                        }else{
                                            echo '<a href="product.php?id='.$prod["id"].'" class="text-decoration-none">';
                                            echo "<h5>".$prod['name']."</h5>";
                                            echo '</a>';
                                        }
                                        ?>
                                        
                                        <p>
                                            <?php echo $prod['description']; ?>
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    </div>
                </div>
            </div>

            <!-- comments -->
            <div class="col-10 block">
                <div class="card comments">
                    <div class="card-header bg-primary">
                        <?php echo lang('COMMENTS'); ?>
                    </div>
                    <div class="card-body">
                        <?php
                        $query  = $con->prepare("SELECT C.*, P.name AS prodName
                                                 FROM comments C INNER JOIN products P
                                                 WHERE C.prod_id = P.id AND C.user_id = ?");
                        $query->execute([$info['id']]);
                        $comments   = $query->fetchAll();
                        if(!empty($comments)){
                        ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-bordered text-center tbl">
                                <thead class="table-dark">
                                    <tr>
                                        <th><?php echo lang('COMMENT')?></th>
                                        <th><?php echo lang('PRODUCT')?></th>
                                        <th><?php echo lang('DATE')?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    foreach($comments as $comment){
                                        echo '<tr>';
                                            echo '<td>'. $comment['comment'].'</td>';
                                            echo '<td>'. $comment['prodName'].'</td>';
                                            echo '<td>'. $comment['date'].'</td>';
                                        echo '</tr>';
                                    }
                                ?>         
                                </tbody>
                            </table>
                        </div>
                        <?php
                        }else{
                            echo '<p class="lead text-center">No Comments For Now</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    }
    else{
        header("Location:sign.php");
        exit();
    }
    include("includes/templates/footer.php");
    ob_end_flush();
?>