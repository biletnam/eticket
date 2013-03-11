<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/header.php"); ?>
<div class="topbar">
    <div class="container_12">
        <div class="clearfix">
            <h1 class="bebasneue grid_6 page-title"><?php echo Yii::app()->params['page'] ?></h1>
            <div class="grid_6 user-bar pull-right">
                User bar
            </div>
        </div>
    </div>
</div>
<?php echo $content; ?>

<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/footer.php"); ?>
