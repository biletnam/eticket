<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/header.php"); ?>
<div class="container" style="padding-top:80px">   
    <div class="row-fluid">
        <div class="span12 well">
            <h1>Bạn không có quyền truy cập vào đường dẫn này.</h1>
            <br/>

            <h4>Nhấn vào <a href="<?php echo Yii::app()->request->baseUrl; ?>">đây</a> để về trang chủ.</h4>
        </div>

    </div>
</div>
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/footer.php"); ?>