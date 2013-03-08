<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/header.php"); ?>

<section class="content">
    <?php echo $content; ?>
</section>

<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/footer.php"); ?>