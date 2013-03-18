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
                        <?php if (UserControl::getRole() && UserControl::getRole() == 'client'): ?>
                            <li><a href="<?php echo HelperUrl::baseUrl() ?>user/account/type/manage_event">My Events</a>|</li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>user/signup">Register</a></li>
                        <li><a href="<?php echo HelperUrl::baseUrl() ?>user/signin">Log in</a>|</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="container_12 page-user">
    <div class="clearfix">
        <div class="grid_4">
            <ul class="user-menu">
                <li <?php if (Yii::app()->params['is_tab'] == 'setting'): ?>class="active"<?php endif; ?>><a class="btn-style" href="<?php echo HelperUrl::baseUrl() ?>user/account/type/setting"><i class="icon icon-user"></i>Account Setting</a></li>
                <li <?php if (Yii::app()->params['is_tab'] == 'change_password'): ?>class="active"<?php endif; ?>><a class="btn-style" href="<?php echo HelperUrl::baseUrl() ?>user/account/type/change_password"><i class="icon icon-setting"></i>Change Password</a></li>
                 <?php if (UserControl::getRole() && UserControl::getRole() == 'client'): ?>
                <li <?php if (Yii::app()->params['is_tab'] == 'manage_event'): ?>class="active"<?php endif; ?>><a class="btn-style" href="<?php echo HelperUrl::baseUrl() ?>user/account/type/manage_event"><i class="icon icon-event"></i>Management Event</a></li>
                <?php endif;?>
                <li <?php if (Yii::app()->params['is_tab'] == "paid_event"): ?>class="active"<?php endif; ?>><a class="btn-style" href="<?php echo HelperUrl::baseUrl() ?>user/account/type/paid_event"><i class="icon icon-refresh"></i>Paid Event's Ticket</a></li>
                <li><a class="btn-style" href="<?php echo HelperUrl::baseUrl() ?>user/signout"><i class="icon icon-logout"></i>Log Out</a></li>
            </ul>
        </div>
        <div class="grid_8">
            <?php echo $content; ?>
        </div>
    </div>
</div>
<?php $this->renderFile(Yii::app()->basePath . "/views/_shared/footer.php"); ?>
