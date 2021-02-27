<nav class="navbar navbar-expand-lg bg-dark ">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">Brand</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#collapsenav">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="collapsenav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="dashboard.php" class="nav-link"><?php echo lang('HOME');?></a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link"><?php echo lang('CATEGORIES');?></a></li>
                    <li class="nav-item"><a href="products.php" class="nav-link"><?php echo lang('PRODUCTS');?></a></li>
                    <li class="nav-item"><a href="users.php" class="nav-link"><?php echo lang('USERS');?></a></li>
                    <li class="nav-item"><a href="comments.php" class="nav-link"><?php echo lang('COMMENTS');?></a></li>
                    <li class="nav-item"><a href="#" class="nav-link"><?php echo lang('STATISTICS');?></a></li>
                    <span class="column"></span>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbardrop" aria-expanded="false"><?php echo lang('PROFILE');?></a>
                        <span class="caret"></span>
                        <ul class="dropdown-menu bg-dark" role="menu">
                            
                            <li class="dropdown-item"><a href="users.php?action=Edit&userId=<?php echo $_SESSION['ID']; ?>" class="nav-link"><?php echo lang('PROFILE');?></a></li>
                            <li class="dropdown-item"><a href="#" class="nav-link"><?php echo lang('SETTING');?></a></li>
                            <li class="dropdown-item"><a href="../index.php" class="nav-link">Visit shop</li>
                            <li role="separator" class="divider"></li>
                            <li class="dropdown-item"><a href="logout.php" class="nav-link"><?php echo lang('LOGOUT');?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>