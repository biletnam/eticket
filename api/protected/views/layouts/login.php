<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/header.php"); ?>
<div class="container" style="padding-top:80px">   
    <div class="row">

        <?php echo $content; ?>

    </div>
</div>
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/footer.php"); ?>