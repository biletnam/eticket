<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/header.php"); ?>
<div class="container" style="padding:80px 0">   
    <div class="row">
        <div class="span12">
            <div class="row-fluid">
                <div class="span7">
                    <h1>Oops, what you're looking for isn't here!</h1>
                    <h5>The page or event you are looking for was not found. <br>
                        If you feel this message is in error, please <a href="mailto:thanhle@htmlfivemedia.com">let us know.</a></h5>
                    
                    <a href="<?php echo Yii::app()->request->baseUrl ?>" class="btn btn-primary">Home page</a>
                </div>
                <div class="span5">
                    <img src="<?php echo Yii::app()->request->baseUrl ?>/img/404_man.jpg"/>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/footer.php"); ?>