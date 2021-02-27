
<?php
    ob_start();
    session_start();
    include_once("admin/connection.php");
    include("includes/languages/english.php");
    $pageTitle = str_replace('-',' ',$_GET['name']);
    include("includes/functions/functions.php");
    include("includes/templates/header.php");
    include("includes/templates/navbar.php");
    $catId  = $_GET['page'];

?>
<div class="container categories">
        <h1 class="text-center m-3"><?php echo $pageTitle; ?></h1>
        <?php
        $cats   = getCats("WHERE parent = $catId");
        foreach($cats as $cat){
            ?>
            <h4 class="mt-3 mb-3 bg-danger p-3 rounded sub-head"><?php echo $cat['name']; ?></h4>
            <div class="row mb-3 category">
            <?php
            $products   = getProds('cat_id',$cat['id']);
            if( count($products) < 1){
                echo '<div class="col-12 text-center alert alert-info">';
                    echo '<p>No products for this category.</p>';
                echo '</div>';
            }
            foreach($products as $prod){
                ?>
                <div class="col-sm-6 col-md-3">
                    <div class="card text-center">
                        <div class="card-header p-0">
                            <span class="price"><?php echo $prod['price']; ?></span>
                            <img src="<?php echo $prod['image']; ?>" class="card-img-top" alt="<?php echo $prod['name']; ?>">
                        </div>
                        <div class="card-body">
                            <a href="product.php?id=<?php echo $prod['id']; ?>" class="text-decoration-none">
                                <h5><?php echo $prod['name'];?></h5>
                            </a>
                            <p class="text-truncate">
                                <?php echo $prod['description']; ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>   
            </div>
            <?php
        }
        ?>
</div>