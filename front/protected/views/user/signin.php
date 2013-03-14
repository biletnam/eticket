<div class="container_12 page-register bg-kube">
    <div class="grid_12">
        <form class="form-style form-register border" method="POST">
            <?php echo Helper::print_error($message); ?>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Email:</label>
                <div class="controls pull-left">
                    <input type="text" class="input-large" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Password:</label>
                <div class="controls pull-left">
                    <input type="password" class="input-large" name="password" id="password" value=""/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">&nbsp;</label>
                <div class="controls pull-left">
                    <label class="checkbox"><input type="checkbox" value="remember" id="remember" name="remember"/> Remember me</label>
                    <a class="register forgot-password" href="<?php echo HelperUrl::baseUrl() ?>user/signup">Register</a>/<a class="forgot-password" href="<?php echo HelperUrl::baseUrl() ?>user/forgot">Forgotten password?</a>
                </div>
            </div>
            <div class="actions controls-group clearfix">
                <label class="control-label pull-left">&nbsp;</label>
                <div class="controls pull-left">
                    <input class="btn" type="submit" value="Submit"/>
                    <a class="btn-signup-fb" href="<?php echo HelperUrl::baseUrl()?>user/loginfacebook">
                        <img src="<?php echo HelperUrl::baseUrl() ?>images/sign_up_fb.png" alt=""/>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
