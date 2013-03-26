<section class="manage-event">
    <form class="form-style border border-radius" method="POST">
        <?php echo Helper::print_error($message); ?>
        <?php echo Helper::print_success($message); ?>
        <?php if(UserControl::getIs_signup_facebook()==0): ?>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">
                    Current Password
                </label>
                <div class="controls pull-left">
                    <input type="password" class="input-medium" name="oldpwd" value=""/>
                </div>
            </div>
        <?php endif; ?>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">
                New Password
            </label>
            <div class="controls pull-left">
                <input type="password" class="input-medium" name="pwd1" value=""/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">
                Confirm Password
            </label>
            <div class="controls pull-left">
                <input type="password" class="input-medium" name="pwd2" value=""/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">
                &nbsp;
            </label>
            <div class="controls pull-left">
                <input type="submit" class="btn" value="SAVE"/>
            </div>
        </div>
    </form>
</section>