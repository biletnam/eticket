<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/header.php"); ?>
<div class="topbar">
    <div class="container_12">
        <div class="clearfix">
            <h1 class="bebasneue grid_6 page-title"><?php echo Yii::app()->params['page'] ?></h1>
            <div class="grid_6 user-bar pull-right">
                <ul class="user-bar-main clearfix">
                    <li class="user-actions">
                        <a href="javascript::void(0)">Peter</a>
                        <ul>
                            <li><a href="#">Log out</a></li> 
                        </ul>
                    </li>
                    <li><a href="<?php echo HelperUrl::baseUrl() ?>user/account/type/manage_event">My Events</a>|</li>
                    <li><a href="#">My Profile</a>|</li>
                    <li><a href="#">My Tickets</a>|</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php echo $content; ?>

<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/footer.php"); ?>
