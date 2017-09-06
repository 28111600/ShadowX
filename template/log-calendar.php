<?php

$node_id = isset($_GET['id']) ? $_GET['id'] : "";

if ($node_id !== "" && $node_id !== 'all') {
    $nodes = ShadowX\Node::getAllNodes();
    foreach ($nodes as $rs) {
        if ($rs['node_id'] === $node_id) {
            $name = $rs['name'];
        }
    }
} else {
    $name = "All";
    $node_id = "";
}
?>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-xs-12 col-lg-6">
            <div class="dropdown btn-group">
                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <?php echo $name;?>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="?id=all">All</a></li>
                <?php
                $nodes = ShadowX\Node::getAllNodes();
                foreach ($nodes as $rs) { ?>
                    <li><a href="?id=<?php echo $rs['node_id'];?>"><?php echo $rs['name']; ?></a></li>
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