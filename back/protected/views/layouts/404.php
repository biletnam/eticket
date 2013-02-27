<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/header.php"); ?>
<div class="container" style="padding-top:80px">   
    <div class="row">
        <div class="span12">
            <div class="row-fluid">
                <div class="span7">
                    <h1>Page not found</h1>
                    <h5>The page you try to access may be not exist. Click <a href="<?php echo Yii::app()->request->baseUrl ?>">here</a> to return home page. Please contact <a href="mailto:thanhle@htmlfivemedia.com">thanhle@htmlfivemedia.com</a> if you find any inconvenient</h5>
                    
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