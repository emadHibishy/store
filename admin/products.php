<?php
    ob_start();
    session_start();
    if(isset($_SESSION['name'])){
        include_once("connection.php");
        include("includes/languages/english.php");
    $pageTitle = lang('PRODUCTS');
        include("includes/functions/functions.php");
        include("includes/templates/header.php");
        include("includes/templates/navbar.php");

        $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        
        if($action === 'Manage'){
            //manage products 
            $stmt       = $con->prepare("SELECT P.*,C.name AS Cname, U.username AS Uname
                                         FROM
                                            products P INNER JOIN categories C 
                                         ON
                                            P.cat_id = C.id
                                         INNER JOIN 
                                            users U
                                         ON
                                            P.user_id = U.id
                                         ORDER BY P.id DESC");
            $stmt->execute();
            $products   = $stmt->fetchAll();
        ?>
        <section class="manage-products">
            <h2 class="text-center highlight"><?php echo lang('MANAGE').lang('PRODUCTS');?></h2>
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
                                <th><?php echo lang('PRODNAME')?></th>
                                <th><?php echo lang('DESC')?></th>
                                <th><?php echo lang('PRICE')?></th>
                                <th><?php echo lang('DATE')?></th>
                                <th><?php echo lang('USER')?></th>
                                <th><?php echo lang('CATEGORY')?></th>
                             <?php /*  <th><?php echo lang('COUNTRY')?></th>
                                <th><?php echo lang('STATUS')?></th>
                                <th><?php echo lang('RATING')?></th>*/?>
                                <th><?php echo lang('CONTROL')?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($products as $product){
                                echo '<tr>';
                                    echo '<th>'. $product['id'].'</th>';
                                    echo '<td>'. $product['name'].'</td>';
                                    echo '<td>'. $product['description'].'</td>';
                                    echo '<td>'. $product['price'].'</td>';
                                    echo '<td>'. $product['date'].'</td>';
                                    echo '<td>'. $product['Uname'].'</td>';
                                    echo '<td>'. $product['Cname'].'</td>';
                                    /*echo '<td>'. $product['country'].'</td>';
                                    echo '<td>'. $product['status'].'</td>';
                                    echo '<td>'. $product['rate'].'</td>';*/
                                    echo '<td>';
                                    if($product['approve'] == 0){
                                        echo '<a href="products.php?action=Approve&prodId='. $product['id'].'"class="btn btn-info mr-2"><i class="fa fa-check"></i> '.lang("APPROVE").'</a>';
                                    }
                                    echo '<a href="products.php?action=Edit&prodId='. $product['id'].'"class="btn btn-success mr-2"><i class="fa fa-edit"></i> '.lang("EDIT").'</a>';
                                    echo '<button class="btn btn-danger remove" data-target="'.$product['id'].'"><i class="fa fa-close"></i> '.lang("DELETE").'</button>';
                                    
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
        }elseif($action === 'Add'){
            ?>
            <section class="add-product">
                <h2 class="text-center"><?php echo lang('ADD').lang('PRODUCT');?></h2>
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                        <?php
                            if(isset($_SESSION['success'])){?>
                            <div class="alert alert-success">
                                <p class="lead text-center"><?php echo $_SESSION['success'];?></p>
                            </div>
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
                    <form class="form-horizontal" method="POST" action="?action=Insert" enctype="multipart/form-data">
                        <!-- product name -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="name" class="col-sm-2 control-label"><?php echo lang('PRODNAME');?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-lg" name="name" />
                                </div>  
                            </div>    
                        </div>
                        <!-- product description -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="description" class="col-sm-2 control-label"><?php echo lang('DESC');?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-lg" name="description" />
                                </div>
                            </div>    
                        </div>
                        <!-- product image -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="img" class="col-sm-2 control-label"><?php echo lang('DESC');?></label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control form-control-lg" name="img" />
                                </div>
                            </div>    
                        </div>
                        <!-- price -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="price" class="col-sm-2 control-label"><?php echo lang('PRICE');?></label>
                                <div class="col-sm-10">
                                    <input 
                                        type="text"
                                        class="form-control form-control-lg"
                                        name="price" />
                                </div>
                            </div>    
                        </div>
                        <!-- country -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="country" class="col-sm-2 control-label"><?php echo lang('COUNTRY');?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-lg" name="country" />
                                </div>
                            </div>    
                        </div>
                        <!-- status -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="status" class="col-sm-2 control-label"><?php echo lang('STATUS');?></label>
                                <div class="col-sm-10">
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
                        <!-- user -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="user" class="col-sm-2 control-label"><?php echo lang('USER');?></label>
                                <div class="col-sm-10">
                                    <select name="user" id="user" class="form-control">
                                        <option value="0"></option>
                                        <?php
                                        $stmt   = $con->prepare("SELECT id, username FROM users");
                                        $stmt->execute();
                                        if($stmt->rowCount() > 0){
                                            $rows   = $stmt->fetchAll();
                                            foreach($rows as $row){
                                                echo '<option value="'.$row['id'].'">'.$row['username'].'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>    
                        </div>

                        <!-- category -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="category" class="col-sm-2 control-label"><?php echo lang('CATEGORY');?></label>
                                <div class="col-sm-10">
                                    <select name="category" id="category" class="form-control">
                                        <option value="0"></option>
                                        <?php
                                        $cats   = getCats('WHERE parent != 0', 'parent ASC');
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
                                <div class="col-sm-10 ">
                                    <input type="submit" class="btn btn-info btn-lg col-sm-12" value="<?php echo lang('ADD').lang('PRODUCT');?>" />
                                </div>
                            </div>    
                        </div>
                    </form>
                </div>
            </section>
            <?php
        }elseif($action === 'Insert'){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $name       = htmlspecialchars($_POST['name']);
                $description= htmlspecialchars($_POST['description']);
                $price      = htmlspecialchars($_POST['price']);
                $country    = htmlspecialchars($_POST['country']);
                $status     = $_POST['status'];
                $user       = $_POST['user'];
                $category   = $_POST['category'];
                $imgName    = $_FILES['img']['name'];
                $imgAllowExt= ['jpeg', 'jpg', 'png'];
                $imgSplited = explode('.',$imgName);
                $imgExt     = strtolower(end($imgSplited));
                if(!empty($imgName) && !in_array($imgExt,$imgAllowExt)){
                    $_SESSION['error']  = 'Not Supported Extension';
                }else{
                    $image  = date('d-m-Y',time())."_".rand(0,100000).$imgName;
                    move_uploaded_file($_FILES['img']['tmp_name'],"../uploads/$image");
                    $query  = $con->prepare("INSERT INTO 
                                            products(name, image, description, price, country, status, cat_id, user_id, date, approve)
                                            VALUES(:name, :img, :desc, :price, :cntry, :state, :catID, :user, now(), :app)");
                    $query->execute([
                        'name'  => $name,
                        'img'   => "uploads/$image",
                        'desc'  => $description,
                        'price' => $price,
                        'cntry' => $country,
                        'state' => $status,
                        'catID' => $category,
                        'user'  => $user,
                        'app'   => 1
                    ]);
                    if($query->rowCount() > 0){
                        $_SESSION['success'] = lang('PRODADDED');
                    }else{
                        $_SESSION['error'] = lang('DLTFAIL');
                    }
                }
                redir('back');
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action === 'Edit'){
            // edit product
            $prodId = isset($_GET['prodId']) && is_numeric($_GET['prodId']) ? intval($_GET['prodId']) : 0;
            $stmt = $con->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$prodId]);
            $product = $stmt->fetch();
            $count = $stmt->rowCount();
            if(isset($_SESSION['permission']) || $product['user_id'] === $_SESSION['ID']){
                if($count > 0){
                ?>
                <!--  Edit prods page -->
                <section class="edit">
                    <h2 class="text-center"><?php echo lang('EDIT').' '.lang('PRODUCT');?></h2>
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
                            <input type="hidden" name="id" value="<?php echo $prodId; ?>">
                             <!-- category name -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="name" class="col-sm-2 control-label"><?php echo lang('PRODNAME');?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-lg" name="name" value="<?php echo $product['name']?>"/>
                                    </div>  
                                </div>    
                            </div>
                            <!-- category description -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="description" class="col-sm-2 control-label"><?php echo lang('DESC');?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-lg" name="description"  value="<?php echo $product['description']?>"/>
                                    </div>
                                </div>    
                            </div>
                            <!-- price -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="price" class="col-sm-2 control-label"><?php echo lang('PRICE');?></label>
                                    <div class="col-sm-10">
                                        <input 
                                            type="text"
                                            class="form-control form-control-lg"
                                            name="price"
                                            value="<?php echo $product['price']?>" />
                                    </div>
                                </div>    
                            </div>
                            <!-- country -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="country" class="col-sm-2 control-label"><?php echo lang('COUNTRY');?></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control form-control-lg" name="country" value="<?php echo $product['country']?>" />
                                    </div>
                                </div>    
                            </div>
                            <!-- status -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="status" class="col-sm-2 control-label"><?php echo lang('STATUS');?></label>
                                    <div class="col-sm-10">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1"<?php if($product['status'] == 1){ echo 'selected';}?>><?php echo lang('NEW');?></option>
                                            <option value="2"<?php if($product['status'] == 2){ echo 'selected';}?>><?php echo lang('LIKENEW');?></option>
                                            <option value="3"<?php if($product['status'] == 3){ echo 'selected';}?>><?php echo lang('USED');?></option>
                                            <option value="4"<?php if($product['status'] == 4){ echo 'selected';}?>><?php echo lang('OLD');?></option>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            <!-- user -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="user" class="col-sm-2 control-label"><?php echo lang('USER');?></label>
                                    <div class="col-sm-10">
                                        <select name="user" id="user" class="form-control">
                                            <?php
                                            $stmt   = $con->prepare("SELECT id, username FROM users");
                                            $stmt->execute();
                                            if($stmt->rowCount() > 0){
                                                $rows   = $stmt->fetchAll();
                                                foreach($rows as $row){
                                                    echo '<option value="'.$row['id'].'"'; if($product['user_id'] == $row['id']){ echo 'selected';} echo'>'.$row['username'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>    
                            </div>

                            <!-- category -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="category" class="col-sm-2 control-label"><?php echo lang('CATEGORY');?></label>
                                    <div class="col-sm-10">
                                        <select name="category" id="category" class="form-control">
                                        <?php
                                        $cats   = getCats('WHERE parent != 0', 'parent ASC');
                                        foreach($cats as $cat){
                                            echo '<option value="'.$cat['id'].'"';if($product["cat_id"] == $cat["id"]){echo "selected";} echo '>'.$cat['name'].'</option>';
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>    
                            </div>
                            
                            <!-- submit -->
                            <div class="form-group">
                                <div class="row justify-content-end">
                                    <div class="col-sm-10 ">
                                        <input type="submit" class="btn btn-info btn-lg col-sm-12" value="<?php echo lang('UPDATE').lang('PRODUCT');?>" />
                                    </div>
                                </div>    
                            </div>
                        </form>

                        <?php
                        $stmt       = $con->prepare("SELECT C.*, U.username AS Uname
                                                        FROM
                                                            comments C 
                                                        INNER JOIN 
                                                            users U
                                                        ON
                                                            C.user_id = U.id
                                                        WHERE 
                                                            C.prod_id = :prodId");
                        $stmt->execute([
                            "prodId"    => $prodId
                        ]);
                        $comments   = $stmt->fetchAll();
                        $commNum    = $stmt->rowCount();
                        if($commNum > 0){
                            ?>
                            <section class="manage-comments">
                                <h2 class="text-center highlight"><?php echo lang('MANAGE').$product['name'].' '.lang('COMMENTS');?></h2>
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
                                                    <th><?php echo lang('COMMENT')?></th>
                                                    <th><?php echo lang('USER')?></th>
                                                    <th><?php echo lang('DATE')?></th>
                                                    <th><?php echo lang('CONTROL')?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                foreach($comments as $comment){
                                                    echo '<tr>';
                                                        echo '<td>'. $comment['comment'].'</td>';
                                                        echo '<td>'. $comment['Uname'].'</td>';
                                                        echo '<td>'. $comment['date'].'</td>';
                                                        echo '<td>';
                                                        if($comment['status'] == 0){
                                                            echo '<a href="comments.php?action=Approve&commId='. $comment['id'].'"class="btn btn-info mr-2"><i class="fa fa-check"></i> '.lang("APPROVE").'</a>';
                                                        }
                                                        echo '<a href="comments.php?action=Edit&commId='. $comment['id'].'"class="btn btn-success mr-2"><i class="fa fa-edit"></i> '.lang("EDIT").'</a>';
                                                        echo '<button class="btn btn-danger remove" data-target="'.$comment['id'].'"><i class="fa fa-close"></i> '.lang("DELETE").'</button>';
                                                        
                                                        echo '</td>';
                                                    echo '</tr>';
                                                }
                                            ?>         
                                            </tbody>
                                        </table>
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
                        }else{
                            echo '<div class="alert alert-info">';
                                echo '<p class="lead">No Comments For This Product</p>';
                            echo '</div>';
                        }
                            ?>
                    </div>
                </section>
        <?php 
                }else{
                    $errMsg = lang('NODATA');
                    redir('products.php',3,$errMsg);
                }
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }

        }elseif($action === 'Update'){
            // update product
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $id          = $_POST['id'];
                $name       = htmlspecialchars($_POST['name']);
                $description= htmlspecialchars($_POST['description']);
                $price      = htmlspecialchars($_POST['price']);
                $country    = htmlspecialchars($_POST['country']);
                $status     = $_POST['status'];
                $user       = $_POST['user'];
                $category   = $_POST['category'];
                
                $query = $con->prepare(  "UPDATE products 
                                         SET 
                                            name = :name,
                                            description = :desc,
                                            price = :price,
                                            country  = :cntry,
                                            status = :status,
                                            user_id = :user,
                                            cat_id  = :cat
                                         WHERE id = :id");
                $query->execute([
                    "name"  => $name,
                    "desc"  => $description,
                    "price" => $price,
                    "cntry" => $country,
                    "status"=> $status,
                    "user"  => $user,
                    "cat"   => $category,
                    "id"    => $id
                ]);
                 if($query->rowCount() > 0){
                     $_SESSION['success'] = lang('UPDSUCCESS');
                 }else{
                     $_SESSION['error']     = lang('DLTFAIL');
                 }
                 redir('back');
             }else{
                 $errMsg = lang('NOTALLOWED');
                 redir('',4,$errMsg);
             }
        }elseif($action === 'Remove'){
            $prodId = isset($_GET['prodId']) && is_numeric($_GET['prodId']) ? intval($_GET['prodId']) : 0;
            if(isset($_SESSION['permission'])){
                $check  = checkExist('id','products',$prodId);
                if($check > 0){
                    $stmt   = $con->prepare('DELETE FROM products WHERE id = :prodid');
                    $stmt->bindParam(':prodid' , $prodId);
                    $stmt->execute();
                    if($stmt->rowCount()){
                        $_SESSION['success'] = lang('PRODUCT').lang('DLTSUC');
                    }else{
                        $_SESSION['error']= lang('DLTFAIL');
                    }
                    redir('back');
                }
                $err = lang('NODATA');
                redir('back',4,$err);
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action === 'Approve'){
            $prodId = isset($_GET['prodId']) && is_numeric($_GET['prodId']) ? intval($_GET['prodId']) : 0;
            $exist  = checkExist('id', 'products', $prodId);
            if($exist > 0){
                $stmt = $con->prepare("UPDATE products SET approve = :aprv WHERE id = :id");
                $stmt->execute([
                    "aprv"  => 1,
                    "id"    => $prodId
                    ]);
                if($stmt->rowCount() > 0){
                    $_SESSION['success']    = lang('APPROVED');
                }else{
                    $_SESSION['error']    = lang('DLTFAIL');
                }
                redir('products.php');
            }
        }
        include("includes/templates/footer.php");
    }else{
        $errMsg = lang('NOTALLOWED');
        redir('index.php',4);
    }
    ob_end_flush();
?>