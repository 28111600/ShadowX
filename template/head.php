<!doctype html>
<html lang="en">

<head>
    <title><?php echo $site_name; ?></title>
    <?php include "head-meta.php"; ?>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue">
            <div class="logo">
                <a href="<?php echo $site_url; ?>" class="simple-text">
                    <?php echo $site_name; ?>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li>
                        <a href="index.php">
                            <i class="fa fa-dashboard material-icons"></i>
                            <p>用户中心</p>
                        </a>
                    </li>
                    <li>
                        <a href="node.php">
                            <i class="fa fa-server material-icons"></i>
                            <p>节点列表</p>
                        </a>
                    </li>
                    <li>
                        <a href="user.php">
                            <i class="fa fa-user material-icons"></i>
                            <p>用户信息</p>
                        </a>
                    </li>
                    <li>
                        <a href="log.php">
                            <i class="fa fa-bar-chart material-icons"></i>
                            <p>流量日志</p>
                        </a>
                    </li>
                    <li>
                        <a href="invite.php">
                            <i class="fa fa-users material-icons"></i>
                            <p>邀请好友</p>
                        </a>
                    </li>
                    <?php if ($User->isAdmin()) { ?>
                    <li class="break-line"></li>
                    <li>
                        <a href="admin-node.php">
                            <i class="fa fa-server material-icons"></i> <p>节点列表</p>
                        </a>
                    </li>
                    <li>
                        <a href="admin-user.php">
                            <i class="fa fa-user material-icons"></i> <p>用户列表</p>
                        </a>
                    </li>
                    <li>
                        <a href="admin-log.php">
                            <i class="fa fa-bar-chart material-icons"></i> <p>流量日志</p>
                        </a>
                    </li>
                    <li>
                        <a href="system.php">
                            <i class="fa fa-info-circle material-icons"></i> <p>系统信息</p>
                        </a>
                    </li>
                    <?php } ?>
                    <li class="break-line"></li>
                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out material-icons"></i> <p>退出</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    <div class="main-panel">
        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <span class="navbar-brand"><?php echo $page_title; ?></span>
                </div>
            </div>
        </nav>