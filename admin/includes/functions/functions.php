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

    // get latest function
    function getLatest($field, $tbl, $order = 'Date', $limit = 5){
        global $con;
        $stmt = $con->prepare("SELECT $field FROM $tbl ORDER BY $order DESC LIMIT $limit");
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

?>