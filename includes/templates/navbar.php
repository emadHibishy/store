<body>
        <nav class="navbar navbar-expand-lg bg-dark ">
            <div class="container">
                <a href="/store/" class="navbar-brand">Brand</a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#collapsenav">
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="collapsenav">
                    <ul class="navbar-nav">
                        <?php
                        foreach(getCats('WHERE parent = 0') as $cat){
                            if($cat['visibility'] == 0){
                                continue;
                            }
                            echo '<li class="nav-item"><a href="categories.php?page='.$cat['id'].'&name='.str_replace(' ','-',$cat['name']).'" class="nav-link">'.$cat['name'].'</a></li>';
                        }
                        echo '<span class="column"></span>';
                        if(!isset($_SESSION['user'])){
                            echo '<li class="nav-item"><a href="sign.php"class="nav-link">'.lang('SIGN').'</a></li>';
                        }else{    
                        ?>
                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbardrop" aria-expanded="false"><?php echo $_SESSION['user'];?></a>
                                <span class="caret"></span>
                                <ul class="dropdown-menu bg-dark" role="menu">
                                    <li class="dropdown-item"><a href="profile.php" class="nav-link"><?php echo lang('PROFILE');?></a></li>
                                    <li class="dropdown-item"><a href="#" class="nav-link"><?php echo lang('SETTING');?></a></li>
                                    <li role="separator" class="divider"></li>
                                    <li class="dropdown-item"><a href="logout.php" class="nav-link"><?php echo lang('LOGOUT');?></a></li>
                                </ul>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
