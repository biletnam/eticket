<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/header.php"); ?>
<div class="topbar">
    <div class="container_12">
        <div class="clearfix">
            <h1 class="bebasneue grid_5 page-title"><?php echo Yii::app()->params['page'] ?></h1>
            <div class="grid_7 user-bar pull-right">
                <ul class="user-bar-main clearfix">
                    <?php if (UserControl::LoggedIn()): ?>
                        <li class="user-actions">
                            <a href="javascript::void(0)"><?php echo UserControl::getFirstname() ?><i class="icon icon-arrow-down"></i></a>
                            <ul>
                                <li><a href="<?php echo HelperUrl::baseUrl() ?>user/account"><i class="icon icon-setting"></i> Account Setting</a></li>
                                <li><a href="<?php echo HelperUrl::baseUrl() ?>user/signout"><i class="icon icon-logout"></i> Log out</a></li> 
                            </ul>
                        </li>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>user/view_profile/s/current/u/<?php echo UserControl::getId() ?>">My Profile</a>|</li>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>user/account/type/manage_event">My Events</a>|</li>
                    <?php else: ?>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>user/signup">Register</a></li>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>user/signin">Log in</a>|</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container container_12 page-404">   
    <div class="row">
        <div class="span12">
            <div class="row-fluid clearfix padding-bottom-50px">
                <div class="grid_8">
                    <h1>Page not found</h1>
                    <h5>The page you are trying to access does not exist. Click <a href="<?php echo HelperUrl::baseUrl(); ?>">here</a> to return the home page. If you require any further assistance please contact <a href="mailto:ntnhanbk@gmail.com">sales@360islandevents.com</a></h5>
                    <a href="<?php echo HelperUrl::baseUrl(); ?>" class="btn btn-primary"><i class="icon icon-back"></i> Home page</a>
                </div>
                <div class="grid_4">
                    <img src="<?php echo HelperUrl::baseUrl(); ?>img/404_man.jpg"/>
                </div>
            </div>

        </div>
    </div>
</div>
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/footer.php"); ?>