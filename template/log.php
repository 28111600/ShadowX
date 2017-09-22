<?php

$Log = new ShadowX\Log($uid_log);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : "hours";
$node_id = isset($_GET['id']) ? $_GET['id'] : "";

if ($node_id !== "" && $node_id !== "all") {
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

if ($type == "days") {
    $typename = "Days";
    $timeformat = "Y-m-d";
} else if ($type == "months") {
    $typename = "Months";
    $timeformat = "Y-m";
} else {
    $type = "hours";
    $typename = "Hours";
    $timeformat = "Y-m-d H:00";
}

$logs       = $Log->getLogs($page-1,$type,$node_id,$timeoffset);
$pagesize   = $Log->pagesize;
$count      = $Log->count;
$pagemax    = ceil($count / $pagesize);
$page       = min(max($page,1),$pagemax);
$range      = 2;
$pagefirst  = $page - $range;
$pagelast   = $page + $range;

if ($pagelast > $pagemax) {
    $pagefirst -= $pagelast - $pagemax; 
}
if ($pagefirst < 1) {
    $pagelast += 1 - $pagefirst; 
}

$pagefirst = max($pagefirst,1);
$pagelast  = min($pagelast,$pagemax);

?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12">
                <div class="btn-group">
                    <div class="dropdown btn-group">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php echo $typename; ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="?type=hours&id=<?php echo ShadowX\Utility::ifNull($node_id,'all'); ?>">Hours</a></li>
                            <li><a href="?type=days&id=<?php echo ShadowX\Utility::ifNull($node_id,'all'); ?>">Days</a></li>
                            <li><a href="?type=months&id=<?php echo ShadowX\Utility::ifNull($node_id,'all'); ?>">Months</a></li>
                        </ul>
                    </div>
                    <div class="dropdown btn-group">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            <?php echo $name; ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="?type=<?php echo $type; ?>&id=all">All</a></li>
                        <?php
                        $nodes = ShadowX\Node::getAllNodes();
                        foreach ($nodes as $rs) { ?>
                            <li><a href="?type=<?php echo $type; ?>&id=<?php echo $rs['node_id']; ?>"><?php echo $rs['name']; ?></a></li>
                        <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary" onclick="location.reload();">刷新</button>
                </div>
    <?php
        if ($url_log_calendar) { ?>
                <div class="btn-group">
                    <a class="btn btn-success" href="<?php echo $url_log_calendar; ?>">日历视图</a>
                </div>
    <?php } ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-content table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="log-date text-center">日期</th>
                                    <th>用户</th>
                                    <th>端口</th>
                                    <th class="text-right">上行</th>
                                    <th class="text-right">下行</th>
                                </tr>
                            </thead>
                                <tbody><?php
function showRows($rows, $date) {
    $index = 0;
    foreach ($rows as $row) { ?>
                                <tr><?php
        if ($index === 0) { ?>
                                    <td rowspan="<?php echo count($rows); ?>" class="vertical-middle multiple-row log-date text-center"><?php echo $date; ?></td><?php
        } ?>
                                    <td><?php echo $row['user_name']; ?></td>
                                    <td><?php echo $row['port']; ?></td>
                                    <td class="text-right"><?php if ($row['u'] != 0) { echo ShadowX\Utility::getSize($row['u']); } else { echo '-'; } ?></td>
                                    <td class="text-right"><?php if ($row['d'] != 0) { echo ShadowX\Utility::getSize($row['d']); } else { echo '-'; } ?></td>
                                </tr><?php
        $index++;
    }
}

$rows = [];
$value = '';
$date = '';
foreach ($logs as $rs) {
    $date = date($timeformat,$rs['t']);
    if ($value != $date) {
        if (count($rows) != 0) {
            showRows($rows,$value);
        }
        $rows = [];
        $value = $date;
        $rows[] = $rs;
    } else {
        $rows[] = $rs;
    }
}
if (count($rows) != 0) {
    showRows($rows,$date);
} ?>
                            </tbody>
                        </table>
                        <div class="text-right">
                            <div>
                                <ul class="pagination">
                                <?php if ($page == 1){ ?>
                                    <li class="previous disabled">
                                        <span>Previous</span>
                                    </li>
                                <?php } else { ?>
                                    <li class="previous">
                                        <a href="?type=<?php echo $type; ?>&id=<?php echo ShadowX\Utility::ifNull($node_id,'all'); ?>&page=<?php echo $page - 1; ?>">Previous</a>
                                    </li>
                                <?php } ?>
                                
                                <?php for ($i = $pagefirst;$i < $page;$i++){ ?>
                                        <li>
                                        <a href="?type=<?php echo $type; ?>&id=<?php echo ShadowX\Utility::ifNull($node_id,'all'); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                <?php } ?>
                                
                                    <li class="active">
                                        <span><?php echo $i; ?></span>
                                    </li>
                                    
                                <?php for ($i = $page + 1;$i < $pagelast + 1;$i++){ ?>
                                        <li>
                                        <a href="?type=<?php echo $type; ?>&id=<?php echo ShadowX\Utility::ifNull($node_id,'all'); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                <?php } ?>
                                
                                <?php if ($page == $pagemax){ ?>
                                    <li class="next disabled">
                                        <span>Next</span>
                                    </li>
                                <?php } else { ?>
                                    <li class="next">
                                        <a href="?type=<?php echo $type; ?>&id=<?php echo ShadowX\Utility::ifNull($node_id,'all'); ?>&page=<?php echo $page + 1; ?>">Next</a>
                                    </li>
                                <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>