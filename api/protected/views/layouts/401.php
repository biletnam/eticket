<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/header.php"); ?>
<div class="container" style="padding-top:80px">   
    <div class="row-fluid">
        <div class="span12 well">
            <h1>You are not authorized to access this page.</h1>
            <br/>

            <h4>Click <a href="<?php echo HelperUrl::baseUrl(); ?>">here</a> to return home page.</h4>
        </div>

    </div>
</div>
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/footer.php"); ?>