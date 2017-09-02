<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $site_name; ?></title>
    <link href="asset/favicon.ico" rel="shortcut icon">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="asset/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="asset/css/adminlte.min.css">
    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="asset/css/skins/skin-black.min.css">
    <!-- App -->
    <link rel="stylesheet" href="asset/css/app.css">
    <!-- Messg -->
    <link rel="stylesheet" href="asset/css/messg.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="asset/js/html5shiv.min.js"></script>
    <script src="asset/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition skin-black">
    <div class="wrapper">
        <header class="main-header">
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"></a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <!--<div class="pull-left">
                        <i class="fa fa-user user-image" aria-hidden="true"></i></div>-->
                    <div class="pull-left info">
                        <p><?php echo $User->GetUserName(); ?></p>
                        <small class="user-email"><?php echo $User->GetEmail(); ?></small>
                    </div>
                </div>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">用户</li>
                    <li>
                        <a href="index.php">
                            <i class="fa fa-dashboard"></i> <span>用户中心</span>
                        </a>
                    </li>
                    <li>
                        <a href="node.php">
                            <i class="fa fa-server"></i> <span>节点列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="my.php">
                            <i class="fa fa-user"></i> <span>用户信息</span>
                        </a>
                    </li>
                    <li>
                        <a href="log.php">
                            <i class="fa fa-bar-chart"></i> <span>流量日志</span>
                        </a>
                    </li>
                    <li>
                        <a href="invite.php">
                            <i class="fa fa-users"></i> <span>邀请好友</span>
                        </a>
                    </li>
                    <li class="header">管理</li>
                    <li>
                        <a href="admin-node.php">
                            <i class="fa fa-server"></i> <span>节点列表</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_user.php">
                            <i class="fa fa-user"></i> <span>查看用户</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin-log.php">
                            <i class="fa fa-bar-chart"></i> <span>流量日志</span>
                        </a>
                    </li>
                    <li>
                        <a href="admin_invite.php">
                            <i class="fa fa-users"></i> <span>邀请管理</span>
                        </a>
                    </li>
                    <li class="header"></li>
                    <li>
                        <a href="server.php">
                            <i class="fa fa-info-circle"></i> <span>系统信息</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="fa fa-sign-out"></i> <span>退出</span>
                        </a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>