<?php
    ob_start();
    session_start();
    if(isset($_SESSION['user'])){
        include_once("admin/connection.php");
        include("includes/languages/english.php");
        $pageTitle = lang('ADD').lang('PRODUCT');
        include("includes/functions/functions.php");
        include("includes/templates/header.php");
        include("includes/templates/navbar.php");
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $prodName   = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
            $prodDesc   = filter_var($_POST['description'],FILTER_SANITIZE_STRING);
            $prodPrice  = filter_var($_POST['price'],FILTER_SANITIZE_NUMBER_INT);
            $prodCountry= filter_var($_POST['country'],FILTER_SANITIZE_STRING);
            $prodStatus = filter_var($_POST['status'],FILTER_SANITIZE_NUMBER_INT);
            $prodCat    = filter_var($_POST['category'],FILTER_SANITIZE_NUMBER_INT);
            $imgName    = $_FILES['img']['name'];
            $allowedExt = ['jpeg', 'jpg', 'png'];
            $imgSplit   = explode('.',$imgName);
            $imgExt     = strtolower(end($imgSplit));
            if(!empty($imgName) && !in_array($imgExt,$allowedExt)){
                $_SESSION['err']    = 'Not Supported Image Type';
                redir('addProd.php');
            }else{
                $image = date('d-m-Y', time()).'_'.rand(0,100000).'_'.$imgName;
                move_uploaded_file($_FILES['img']['tmp_name'],"uploads/$image");
                $stmt   = $con->prepare("INSERT INTO products(name, description, image, price, date,
                                            country,  status, cat_id, user_id) 
                                            VALUES(?,?,?,?,now(),?,?,?,?)");
                $stmt->execute([$prodName,$prodDesc,'uploads/'.$image,$prodPrice,$prodCountry,$prodStatus,$prodCat,$_SESSION['id']]);
                if($stmt->rowCount() > 0){
                    $_SESSION['success']    = lang('PRODADDED');
                }else{
                    $_SESSION['err']        = lang('DLTFAIL');
                }
            }

        }
        ?>
        <div class="container">
            <h2 class="text-center m-3">Add New Product</h2>
            <div class="row justify-content-center">
            <div class="col-11 block">
                <div class="card  prods">
                    <div class="card-header bg-primary text-center text-light">
                        <?php echo lang('PRODUCT'); ?>
                    </div>
                    <div class="card-body">
                    <div class="row justify-content-center ">
                        <div class="col-md-10 add-prod">
                            <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                <div class="alert alert-danger">
                                    <?php
                                    if(isset($_SESSION['err'])){
                                        echo '<p>'.$_SESSION['err'].'</p>';
                                        unset($_SESSION['err']);
                                    }
                                    ?>
                                </div>
                                <div class="alert alert-success">
                                    <?php
                                    if(isset($_SESSION['success'])){
                                        echo '<p>'.$_SESSION['success'].'</p>';
                                        unset($_SESSION['success']);
                                    }
                                    ?>
                                </div>
                                <!-- product name -->
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label for="name" class="col-lg-3 control-label"><?php echo lang('PRODNAME');?></label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control form-control-lg prod-name" name="name" />
                                        </div>  
                                    </div>    
                                </div>
                                <!-- product description -->
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label for="description" class="col-lg-3 control-label"><?php echo lang('DESC');?></label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control form-control-lg prod-desc" name="description" />
                                        </div>
                                    </div>    
                                </div>
                                  <!-- product image -->
                                  <div class="form-group">
                                    <div class="row align-items-center">
                                        <label for="img" class="col-lg-3 control-label">Image</label>
                                        <div class="col-lg-9">
                                            <input type="file" class="form-control form-control-lg prod-img" name="img" />
                                        </div>  
                                    </div>    
                                </div>
                                <!-- price -->
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label for="price" class="col-lg-3 control-label"><?php echo lang('PRICE');?></label>
                                        <div class="col-lg-9">
                                            <input 
                                                type="text"
                                                class="form-control form-control-lg prod-price"
                                                name="price" />
                                        </div>
                                    </div>    
                                </div>
                                <!-- country -->
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label for="country" class="col-lg-3 control-label"><?php echo lang('COUNTRY');?></label>
                                        <div class="col-lg-9">
                                            <input type="text" class="form-control form-control-lg" name="country" />
                                        </div>
                                    </div>    
                                </div>
                                <!-- status -->
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label for="status" class="col-lg-3 control-label"><?php echo lang('STATUS');?></label>
                                        <div class="col-lg-9">
                                            <select name="status" id="status" class="form-control">
                                                <option value="0"></option>
                                                <option value="1"><?php echo lang('NEW');?></option>
                                                <option value="2"><?php echo lang('LIKENEW');?></option>
                                                <option value="3"><?php echo lang('USED');?></option>
                                                <option value="4"><?php echo lang('OLD');?></option>
                                            </select>
                                        </div>
                                    </div>    
                                </div>

                                <!-- category -->
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label for="category" class="col-lg-3 control-label"><?php echo lang('CATEGORY');?></label>
                                        <div class="col-lg-9">
                                            <select name="category" id="category" class="form-control">
                                                <option value="0"></option>
                                                <?php
                                                    $cats   = getCats("WHERE parent != 0", 'parent ASC');
                                                    foreach($cats as $cat){
                                                        echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>    
                                </div>
                                
                                <!-- submit -->
                                <div class="form-group">
                                    <div class="row justify-content-end">
                                        <div class="col-lg-9 ">
                                            <input type="submit" class="btn btn-info btn-lg col-lg-12" value="<?php echo lang('ADD').lang('PRODUCT');?>" />
                                        </div>
                                    </div>    
                                </div>
                            </form>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        
        
        <?php
        include("includes/templates/footer.php");
    }else{
        redir('sign.php');
    }
    ob_end_flush();
?>