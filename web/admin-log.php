<?php
require_once '../template/main.php';
require_once '../template/head.php';

$uid_log = 0;
$log_calendar = '';
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            流量日志
            <small>Traffic Log</small>
        </h1>
    </section>
    <?php require_once '../template/log.php'; ?>
</div>
<!-- /.content-wrapper -->
<?php
require_once '../template/footer.php'; ?>