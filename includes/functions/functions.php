<?php
    // get title function
    function getTitle(){
        global $pageTitle;
        if(isset($pageTitle)){
            echo $pageTitle;
        }else{
            echo 'Default';
        }
    }

    // redir url
    function redir($url = 'index.php' ,$seconds = 0 ,$errMsg=''){
        $url = $url === 'back' && isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='' ? $_SERVER['HTTP_REFERER'] : $url;
        if($errMsg != ''){
            echo '<div class="container">';
            echo '<div class="alert alert-danger text-center"><p>'.$errMsg.'</p></div>';
            echo '</div>';
        }
        
        header("REFRESH:$seconds;URL=$url");
        exit();
    }

    /*
    **check if exists
    **prarameters[field,table,needle] 
    */
    function checkExist($field,$tbl,$needle){
        global $con;
        $query = $con->prepare("SELECT $field FROM $tbl WHERE $field = ?");
        $query->execute([$needle]);
        $count = $query->rowCount();
        return $count;
    }

    // get count function
    function getCount($field , $tbl){
        global $con;
        $stmt   = $con->prepare("SELECT COUNT($field) FROM $tbl");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // get all function
    function getAllFrom($tbl, $order){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tbl WHERE approve = 1 ORDER BY $order ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // get categories function
    function getCats($parent = NULL, $order = 'id ASC'){
        global $con;
        $condition = $parent === NULL ? NULL : $parent;
        $stmt = $con->prepare("SELECT * FROM categories $condition ORDER BY $order");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // get products function
    function getProds($key , $value, $approve = NULL){
        global $con;
        $condition = $approve === NULL ? "AND approve = 1" : NULL;
        $stmt = $con->prepare("SELECT * FROM products WHERE $key = ? $condition ORDER BY id DESC");
        $stmt->execute([$value]);
        return $stmt->fetchAll();
    }

    // get by id function return row from table
    function getById($tbl,$needle){
        global $con;
        $stmt = $con->prepare("SELECT * FROM $tbl WHERE id = ? ");
        $stmt->execute([$needle]);
        return $stmt->fetch();
    }
    // is activate function return user status if activated or not
    function isActivate($user){
        global $con;
        $stmt = $con->prepare("SELECT username, regStatus FROM users WHERE username = ?");
        $stmt->execute([$user]);
        $usrstate = $stmt->fetch();
        return $usrstate['regStatus'];
    }

?>