<?php
    ob_start();
    session_start();
    if(isset($_SESSION['name'])){
        include_once("connection.php");
        include("includes/languages/english.php");
    $pageTitle = lang('CATEGORIES');
        include("includes/functions/functions.php");
        include("includes/templates/header.php");
        include("includes/templates/navbar.php");
        $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        if($action === 'Manage'){
            // Manage categories
            $order = 'ASC';
            $sortType   = ['ASC','DESC'];
            if(isset($_GET['sort']) && in_array($_GET['sort'],$sortType)){
                $order = $_GET['sort'];
            }
            $query  = $con->prepare("SELECT * FROM categories ORDER BY ordering $order");
            $query->execute();
            $cats   = getCats('WHERE parent = 0',"id $order");
            ?>
            <section class="categories">
                <div class="container">
                    <h2 class="text-center"><?php echo lang('MANAGE').lang('CATEGORIES');?></h2>
                    <?php
                        if(isset($_SESSION['success'])){
                            echo '<div class="alert alert-success text-center"><p>'. $_SESSION['success'].'</p></div>';
                            unset($_SESSION['success']);
                        }elseif(isset($_SESSION['error'])){
                            echo '<div class="alert alert-danger text-center"><p>'. $_SESSION['error'].'</p></div>';
                            unset($_SESSION['error']);
                        }
                    
                    ?>
                    <div class="row justify-content-center">
                        <div class="col-10">
                            <div class="card">
                                <div class="card-header text-center">
                                <h3>
                                    <?php echo lang('MANAGE').lang('CATEGORIES'); ?>
                                    <a href="?sort=DESC"class="pull-right <?php if($order == 'DESC'){ echo 'active';}?>">
                                        <i class="fa fa-sort-amount-desc"></i>
                                    </a>
                                    <a href="?sort=ASC"class="pull-right <?php if($order == 'ASC'){ echo 'active';}?>">
                                        <i class="fa fa-sort-amount-asc"></i>
                                    </a>
                                </h3>
                                </div>
                                <div class="card-body">
                                <?php
                                    foreach($cats as $cat){
                                        $visible    = $cat['visibility'] === 1 ? lang('VISIBLE') : lang('HIDDEN');
                                        $comment    = $cat['comments'] === 1 ? lang('ALLOW') : lang('DECLINE');
                                        $advertise  = $cat['ads'] === 1 ? lang('ALLOW') : lang('DECLINE');
                                        echo '<div class="category">';
                                            echo "<h3>".$cat['name']."</h3>";
                                            echo '<div class="hidden-btns">';
                                                echo '<a class="btn btn-success"href="categories.php?action=Edit&catId='.$cat['id'].'"><i class="fa fa-edit mr-2"></i>'.lang('EDIT').'</a>';
                                                echo '<button class="btn btn-danger remove"data-target="'.$cat['id'].'"><i class="fa fa-remove mr-2"></i>'.lang('DELETE').'</button>';
                                            echo '</div>';
                                            echo '<p class="lead">'.$cat['description'].'</p>';
                                            $subCats    = getCats("WHERE parent = ".$cat['id']);
                                            if(count($subCats) > 0){
                                                echo '<h5 class="m-3">Sub Categories</h5>';
                                                echo '<ul calss="list-unstyled">';
                                                foreach($subCats as $subCat){
                                                    echo '<li class="list-group-item">';
                                                        echo '<a class="text-decoration-none lead d-inline-block subCat-name mr-5" href="categories.php?action=Edit&catId='.$subCat['id'].'">'.$subCat['name'].'</a>';
                                                        echo '<a class="text-decoration-none lead text-danger" href="categories.php?action=Remove&catId='.$subCat['id'].'">'.lang("DELETE").'</a>';
                                                    echo '</li>';
                                                }
                                                echo '</ul>';
                                            }
                                            
                                            if($cat['visibility'] == 1)
                                            {
                                                echo '<button class="btn mr-2 btn-info">'.lang('VISIBLE').'</button>'; 
                                            }else{
                                                echo '<button class="btn mr-2 btn-secondary"disabled>'.lang('HIDDEN').'</button>';
                                            }
                                            if($cat['comments'] == 1)
                                            {
                                                echo '<button class="btn mr-2 btn-info">'.lang('ALLOW').' '.lang('COMMENTS').'</button>'; 
                                            }else{
                                                echo '<button class="btn mr-2 btn-warning">'.lang('DECLINE').' '.lang('COMMENTS').'</button>';
                                            }
                                            if($cat['ads'] == 1)
                                            {
                                                echo '<button class="btn btn-info">'.lang('ALLOW').' '.lang('ADS').'</button>'; 
                                            }else{
                                                echo '<button class="btn btn-warning">'.lang('DECLINE').' '.lang('ADS').'</button>';
                                            }
                                        echo '</div>';
                                        echo '<hr>';
                                    }?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="parent">
                        <div class="popup">
                            <p class="lead"><?php echo lang('DELCONFIRM').lang('CATEGORY');?></p>
                            <button class="btn btn-success cancel mr-3"><?php echo lang('CANCEL');?></button>
                            <?php echo '<a href="" class="btn btn-danger delete">'.lang("DELETE").'</a>';?>
                        </div>
                    </div>
                </div>
            </section>
            <?php
        }elseif($action === 'Add'){
            // Add Category
            ?>
            <section class="addCategory">
                <h2 class="text-center"><?php echo lang('ADDCAT');?></h2>
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
                    <form class="form-horizontal" method="POST" action="?action=Insert">
                        <!-- category name -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="name" class="col-sm-2 control-label"><?php echo lang('CATNAME');?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-lg" name="name" />
                                </div>  
                            </div>    
                        </div>
                        <!-- category description -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="description" class="col-sm-2 control-label"><?php echo lang('DESC');?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-lg" name="description" />
                                </div>
                            </div>    
                        </div>
                        <!-- order -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label for="order" class="col-sm-2 control-label"><?php echo lang('ORDER');?></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control form-control-lg" name="order" />
                                </div>
                            </div>    
                        </div>
                        <!-- visibility -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label class="col-sm-2 control-label"><?php echo lang('VISIBILITY');?></label>
                                <div class="col-sm-10">
                                    <div>
                                        <input type="radio" name="visibility" id="visible" value="1" checked />
                                        <label for="visible"><?php echo lang('VISIBLE');?></label>
                                    </div>
                                    <div>
                                        <input type="radio" name="visibility" id="non-visible" value="0" />
                                        <label for="non-visible"><?php echo lang('NONVISIBLE');?></label>
                                    </div>
                                </div>
                            </div>    
                        </div>

                        <!-- comment -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label class="col-sm-2 control-label"><?php echo lang('COMMENTS');?></label>
                                <div class="col-sm-10">
                                    <div>
                                        <input type="radio" name="comments" id="allow" value="1" checked />
                                        <label for="allow"><?php echo lang('ALLOW');?></label>
                                    </div>
                                    <div>
                                        <input type="radio" name="comments" id="decline" value="0" />
                                        <label for="decline"><?php echo lang('DECLINE');?></label>
                                    </div>
                                </div>
                            </div>    
                        </div>

                        <!-- ads -->
                        <div class="form-group">
                            <div class="row align-items-center">
                                <label class="col-sm-2 control-label"><?php echo lang('ADS');?></label>
                                <div class="col-sm-10">
                                    <div>
                                        <input type="radio" name="ads" id="allow-ads" value="1" checked />
                                        <label for="allow-ads"><?php echo lang('ALLOW');?></label>
                                    </div>
                                    <div>
                                        <input type="radio" name="ads" id="dec-ads" value="0" />
                                        <label for="dec-ads"><?php echo lang('DECLINE');?></label>
                                    </div>
                                </div>
                            </div>    
                        </div>

                         <!-- parent -->
                         <div class="form-group">
                            <div class="row align-items-center">
                                <label class="col-sm-2 control-label" for="parent"><?php echo lang('PARENT');?></label>
                                <div class="col-sm-10">
                                    <select name="parent" id="parent" class="form-control">
                                        <option value="0">Main Category</option>
                                        <?php
                                        $mainCats   = getCats('WHERE parent = 0');
                                        foreach($mainCats as $cat){
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
                                    <input type="submit" class="btn btn-info btn-lg col-sm-12" value="<?php echo lang('ADDCAT');?>" />
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
                $ordering   = htmlspecialchars($_POST['order']);
                $visibility = $_POST['visibility'];
                $comments   = $_POST['comments'];
                $ads        = $_POST['ads'];
                $parent     = $_POST['parent'];

                $catExist     = checkExist('name','categories',$name);
                if($catExist < 1 ){
                    $query  = $con->prepare("INSERT INTO 
                                            categories(name, parent, description, ordering, visibility, comments, ads)
                                            VALUES(:name, :prnt, :desc, :ordr, :visb, :comm, :ads)");
                    $query->execute([
                        'name'  => $name,
                        'prnt'  => $parent,
                        'desc'  => $description,
                        'ordr'  => $ordering,
                        'visb'  => $visibility,
                        'comm'  => $comments,
                        'ads'   => $ads
                    ]);
                    if($query->rowCount() > 0){
                        $_SESSION['success'] = lang('CATADDED');
                    }
                }else{
                    $_SESSION['error'] = lang('CATEXST');
                }
                redir('back');
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action === 'Edit'){
            // edit categories
            $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;
            if(isset($_SESSION['permission'])){
                $stmt = $con->prepare("SELECT * FROM categories WHERE id = ?");
                $stmt->execute([$catId]);
                $row = $stmt->fetch();
                $count = $stmt->rowCount();?>

                <section class="edit-category">
                    <h2 class="text-center"><?php echo lang('EDIT').' '.lang('CATEGORIES');?></h2>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-sm-10">
                                <?php
                                    if(isset($_SESSION['success'])){
                                ?>
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
                            <?php
                            if($count < 1){
                                $errMsg  = lang('NODATA');
                                redir('categories.php',4,$errMsg);
                            }else{
                                ?>
                                <form class="form-horizontal" method="POST" action="?action=Update">
                                <input type="hidden" name="catId" value="<?php echo $catId; ?>">
                                    <!-- category name -->
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <label for="name" class="col-sm-2 control-label"><?php echo lang('CATNAME');?></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-lg" name="name" value="<?php echo $row['name'];?>"/>
                                            </div>  
                                        </div>    
                                    </div>
                                    <!-- category description -->
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <label for="description" class="col-sm-2 control-label"><?php echo lang('DESC');?></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-lg" name="description"  value="<?php echo $row['description'];?>"/>
                                            </div>
                                        </div>    
                                    </div>
                                    <!-- order -->
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <label for="order" class="col-sm-2 control-label"><?php echo lang('ORDER');?></label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control form-control-lg" name="order"  value="<?php echo $row['ordering'];?>"/>
                                            </div>
                                        </div>    
                                    </div>
                                    <!-- visibility -->
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <label class="col-sm-2 control-label"><?php echo lang('VISIBILITY');?></label>
                                            <div class="col-sm-10">
                                                <div>
                                                    <input type="radio" name="visibility" id="visible" value="1" <?php 
                                                    if($row['visibility'] == 1){echo 'checked';}
                                                    ?> />
                                                    <label for="visible"><?php echo lang('VISIBLE');?></label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="visibility" id="non-visible" value="0"  <?php 
                                                    if($row['visibility'] == 0){echo 'checked';}
                                                    ?> />
                                                    <label for="non-visible"><?php echo lang('NONVISIBLE');?></label>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>

                                    <!-- comment -->
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <label class="col-sm-2 control-label"><?php echo lang('COMMENTS');?></label>
                                            <div class="col-sm-10">
                                                <div>
                                                    <input type="radio" name="comments" id="allow" value="1"   <?php 
                                                    if($row['comments'] == 1){echo 'checked';}
                                                    ?> />
                                                    <label for="allow"><?php echo lang('ALLOW');?></label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="comments" id="decline" value="0"<?php 
                                                    if($row['comments'] == 0){echo 'checked';}
                                                    ?>  />
                                                    <label for="decline"><?php echo lang('DECLINE');?></label>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>

                                    <!-- ads -->
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <label class="col-sm-2 control-label"><?php echo lang('ADS');?></label>
                                            <div class="col-sm-10">
                                                <div>
                                                    <input type="radio" name="ads" id="allow-ads" value="1"  <?php 
                                                    if($row['ads'] == 1){echo 'checked';}
                                                    ?> />
                                                    <label for="allow-ads"><?php echo lang('ALLOW');?></label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="ads" id="dec-ads" value="0" 
                                                    <?php 
                                                    if($row['ads'] == 0){echo 'checked';}
                                                    ?>/>
                                                    <label for="dec-ads"><?php echo lang('DECLINE');?></label>
                                                </div>
                                            </div>
                                        </div>    
                                    </div>

                                     <!-- parent -->
                                    <div class="form-group">
                                        <div class="row align-items-center">
                                            <label class="col-sm-2 control-label" for="parent"><?php echo lang('PARENT');?></label>
                                            <div class="col-sm-10">
                                                <select name="parent" id="parent" class="form-control">
                                                    <option value="0">Main Category</option>
                                                    <?php
                                                    $mainCats   = getCats('WHERE parent = 0');
                                                    foreach($mainCats as $cat){
                                                        echo '<option value="'.$cat['id'].'"'; if($cat['id'] == $row['parent']){ echo 'selected';} echo'>'.$cat['name'].'</option>';
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
                                                <input type="submit" class="btn btn-info btn-lg col-sm-12" value="<?php echo lang('ADDCAT');?>" />
                                            </div>
                                        </div>    
                                    </div>
                                </form>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </section>
                <?php
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action === 'Update'){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $catId  = isset($_POST['catId']) ?  $_POST['catId'] : 0;
                $name       = htmlspecialchars($_POST['name']);
                $description= htmlspecialchars($_POST['description']);
                $ordering   = htmlspecialchars($_POST['order']);
                $visibility = $_POST['visibility'];
                $comments   = $_POST['comments'];
                $ads        = $_POST['ads'];
                $parent     = $_POST['parent'];

                if($catId != 0){
                    $stmt   = $con->prepare("UPDATE categories
                                                SET name    = :name,
                                                parent      = :prnt,
                                                description = :desc,
                                                ordering    = :ordr,
                                                visibility  = :vis,
                                                comments    = :comm,
                                                ads         = :ads
                                                WHERE id    = :id");
                    $stmt->execute([
                        "name"  => $name,
                        "prnt"  => $parent,
                        "desc"  => $description,
                        "ordr"  => $ordering,
                        "vis"   => $visibility,
                        "comm"  => $comments,
                        "ads"   => $ads,
                        "id"    => $catId
                    ]);
                    if($stmt->rowCount() > 0){
                        $_SESSION['success']    = lang('CATEGORY').' '.lang('UPDSUCCESS');
                    }else{
                        $_SESSION['error']    = lang('DLTFAIL');
                    }
                    redir('back');
                }else{
                    echo 'id error '.$catId;
                }

            }else{
                redir('categories.php');
            }
        }elseif($action === 'Remove'){
            $catId = isset($_GET['catId']) && is_numeric($_GET['catId']) ? intval($_GET['catId']) : 0;
            if(isset($_SESSION['permission'])){
                $check  = checkExist('id','categories',$catId);
                if($check > 0){
                    $stmt   = $con->prepare('DELETE FROM categories WHERE id = :catId');
                    $stmt->bindParam(':catId' , $catId);
                    $stmt->execute();
                    if($stmt->rowCount()){
                        $_SESSION['success'] = lang('CATEGORY').lang('DLTSUC');
                    }else{
                        $_SESSION['error']= lang('DLTFAIL');
                    }
                    redir('back');
                }
                $err = lang('NOCAT');
                redir('back',4,$err);
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }
        include("includes/templates/footer.php");
    }else{
        $errMsg = lang('NOTALLOWED');
        redir('index.php',4);
    }
    ob_end_flush();
?>