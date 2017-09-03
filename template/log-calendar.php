<?php

$node = new ShadowX\Node();
$node_id = isset($_GET['id']) ? $_GET['id'] : "";

if ($node_id !== "" && $node_id !== 'all'){
    $nodes = ShadowX\Node::getAllNodes();
    foreach($nodes as $rs){
        if ($rs['node_id'] === $node_id){
            $name = $rs['name'];
        }
    }
} else {
    $name = "All";
    $node_id = "";
}

$Log = new ShadowX\Log($uid_log);
$t = isset($_GET['t']) ? strtotime($_GET['t']."/01") : time();;
$from = strtotime(date("Y-m-d", mktime(0, 0, 0, date("m", $t), 1, date("Y", $t))));
$to = strtotime(date("Y-m-d", mktime(0, 0, 0, date("m", $t), date("t", $t), date("Y", $t))));
$logs = $Log->getLogsRange($from, $to, 'days', $node_id, $timeoffset);

$t_cur = date("Y/m", mktime(0, 0, 0, date("m", $from), 1, date("Y", $from)));
$t_pre = date("Y/m", mktime(0, 0, 0, date("m", $from - 3600), 1, date("Y", $from - 3600)));
$t_next = date("Y/m", mktime(0, 0, 0, date("m", $to + 3600 * 24), 1, date("Y", $to + 3600 * 24)));
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-lg-6">
            <div class="btn-group">
                <a class="btn btn-default" href="?t=<?php echo $t_pre; ?>&id=<?php echo $node_id;?>"><i class="fa fa-angle-left" aria-hidden="true"></i> <?php echo $t_pre; ?></a>
                <a class="btn btn-default" href="?t=<?php echo $t_next; ?>&id=<?php echo $node_id;?>"><?php echo $t_next; ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
            </div>
            <div class="dropdown btn-group">
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?php echo $name;?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="?t=<?php echo $t_cur; ?>&id=all">All</a></li>
                <?php
                $nodes = ShadowX\Node::getAllNodes();
                foreach($nodes as $rs){ ?>
                    <li><a href="?t=<?php echo $t_cur; ?>&id=<?php echo $rs['node_id'];?>"><?php echo $rs['name']; ?></a></li>
                <?php } ?>
                </ul>
            </div>
<?php
    if ($url_log) { ?>
            <div class="btn-group">
                <a class="btn btn-success" href="<?php echo $url_log; ?>">返回流量日志</a>
            </div>
<?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-lg-9">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->