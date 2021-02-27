<?php
    session_start();
    include_once("admin/connection.php");
    if(isset($_SESSION['name']) || isset($_SESSION['ID'])){
        $_SESSION['user']   = $_SESSION['name'];
        $_SESSION['id']     = $_SESSION['ID'];
    }
    if(isset($_SESSION['user']) && !isset($_SESSION['id'])){
        $query  = $con->prepare("SELECT id FROM users WHERE username = ? ");
        $query->execute([$_SESSION['user']]);
        $id     = $query->fetch();
        $_SESSION['id'] = $id['id'];
    }
    include("includes/languages/english.php");
    $pageTitle = lang('HOME');
    include("includes/functions/functions.php");
    include("includes/templates/header.php");
    include("includes/templates/navbar.php");
?>
<div class="container home-page">
    <h2 class="text-center m-3">All Products</h2>
    <div class="row"><!-- align-items-center-->
        <?php
        $stmt = $con->prepare("SELECT * FROM products WHERE approve = 1 ORDER BY id DESC");
        $stmt->execute();
        $products   = $stmt->fetchAll();
        foreach($products as $product){
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card text-center">
                    <div class="card-header p-0">
                    <span class="price"><?php echo $product['price']; ?></span>
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="card-body">
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="text-decoration-none">
                            <h5><?php echo $product['name'];?></h5>
                        </a>
                        <p class="text-truncate">
                            <?php echo $product['description']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<?php
    include("includes/templates/footer.php");
?>