<?php
    ob_start();
    session_start();
    if(isset($_SESSION['name'])){
        include_once("connection.php");
        include("includes/languages/english.php");
    $pageTitle = lang('COMMENTS');
        include("includes/functions/functions.php");
        include("includes/templates/header.php");
        include("includes/templates/navbar.php");
        $action = isset($_GET['action']) ? $_GET['action'] : 'Manage';
        if($action === 'Manage'){
            //manage products 
            $stmt       = $con->prepare("SELECT C.*,P.name AS Pname, U.username AS Uname
                                         FROM
                                            comments C INNER JOIN products P 
                                         ON
                                            C.prod_id = P.id
                                         INNER JOIN 
                                            users U
                                         ON
                                            C.user_id = U.id");
            $stmt->execute();
            $comments   = $stmt->fetchAll();
        ?>
        <section class="manage-comments">
            <h2 class="text-center highlight"><?php echo lang('MANAGE').lang('COMMENTS');?></h2>
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
                                <th><?php echo lang('COMMENT')?></th>
                                <th><?php echo lang('USER')?></th>
                                <th><?php echo lang('PRODUCT')?></th>
                                <th><?php echo lang('DATE')?></th>
                                <th><?php echo lang('CONTROL')?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($comments as $comment){
                                echo '<tr>';
                                    echo '<th>'. $comment['id'].'</th>';
                                    echo '<td>'. $comment['comment'].'</td>';
                                    echo '<td>'. $comment['Uname'].'</td>';
                                    echo '<td>'. $comment['Pname'].'</td>';
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
        }elseif($action == 'Edit'){
            $commId = isset($_GET['commId']) && is_numeric($_GET['commId']) ? intval($_GET['commId']) : 0;
            $stmt = $con->prepare("SELECT * FROM comments WHERE id = ?");
            $stmt->execute([$commId]);
            $comment = $stmt->fetch();
            $count = $stmt->rowCount();
            if(isset($_SESSION['permission']) || $comment['user_id'] == $_SESSION['ID']){
                
                if($count > 0){
                    // echo $row[1];
                
                ?>
                <!--  Edit users page -->
                <section class="edit-comment">
                    <h2 class="text-center"><?php echo lang('EDIT').' '.lang('COMMENT');?></h2>
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
                            <input type="hidden" name="id" value="<?php echo $commId; ?>">
                            <!-- comment -->
                            <div class="form-group">
                                <div class="row align-items-center">
                                    <label for="comment" class="col-sm-2 control-label"><?php echo lang('COMMENT');?></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control form-control-lg" name="comment"><?php echo $comment['comment'];?></textarea>
                                    </div>  
                                </div>    
                            </div>
                            <!-- submit -->
                            <div class="form-group">
                                <div class="row justify-content-end">
                                    <div class="col-sm-10 ">
                                        <input type="submit" class="btn btn-info btn-lg col-sm-12" value="<?php echo lang('UPDATE').lang('COMMENT');?>" />
                                    </div>
                                </div>    
                            </div>
                        </form>
                    </div>
                </section>
        <?php 
                }else{
                    $errMsg = lang('NODATA');
                    redir('comments.php',3,$errMsg);
                }
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action == 'Update'){
            
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
               $id          = $_POST['id'];
               $comment     = htmlspecialchars($_POST['comment']);
               $query = $con->prepare(  "UPDATE comments 
                                        SET comment = ?
                                        WHERE id = ?");
               $query->execute([$comment, $id]);
                if($query->rowCount() > 0){
                    $_SESSION['success'] = lang('UPDSUCCESS');
                    redir('back');
                }else{
                    $errMsg = lang('DLTFAIL');
                    redir('comments.php',3,$errMsg);
                }
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action == 'Remove'){
            $commId = isset($_GET['commId']) && is_numeric($_GET['commId']) ? intval($_GET['commId']) : 0;
            if(isset($_SESSION['permission']) || $commId['user_id'] == $_SESSION['ID']){
                $check  = checkExist('id','comments',$commId);
                if($check > 0){
                    $stmt   = $con->prepare('DELETE FROM comments WHERE id = :commid');
                    $stmt->bindParam(':commid' , $commId);
                    $stmt->execute();
                    if($stmt->rowCount()){
                        $_SESSION['success'] = lang('DLTSUC');
                        redir('back');
                    }else{
                        $errMsg = lang('DLTFAIL');
                        redir('comments.php',3,$errMsg);
                    }
                }
                $err = lang('NODATA');
                redir('back',4,$err);
            }else{
                $errMsg = lang('NOTALLOWED');
                redir('',4,$errMsg);
            }
        }elseif($action === 'Approve'){
            $commId = isset($_GET['commId']) && is_numeric($_GET['commId']) ? intval($_GET['commId']) : 0;
            $exist  = checkExist('id', 'comments', $commId);
            if($exist > 0){
                $stmt = $con->prepare("UPDATE comments SET status = :aprv WHERE id = :id");
                $stmt->execute([
                    "aprv"  => 1,
                    "id"    => $commId
                    ]);
                if($stmt->rowCount() > 0){
                    $_SESSION['success']    = lang('APPROVED');
                    redir('back');
                }else{
                    $errMsg = lang('DLTFAIL');
                    redir('comments.php',3,$errMsg);
                }
            }
        }
        include("includes/templates/footer.php");
    }else{
        $errMsg = lang('NOTALLOWED');
        redir('index.php',4);
    }
    ob_end_flush();
?>