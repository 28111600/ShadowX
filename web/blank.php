<?php
$page_title = "Title";
require_once '../template/main.php';
require_once '../template/head.php';
?>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-header" data-background-color="blue">
                        <h4 class="title">Title</h4>
                    </div>
                    <div class="card-content">
                        Content
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class="card">
                    <div class="card-header" data-background-color="green">
                        <h4 class="title">Title</h4>
                    </div>
                    <div class="card-content">
                        Content
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require_once '../template/footer.php'; ?>