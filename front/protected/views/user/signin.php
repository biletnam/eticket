<div class="container_12 page-register bg-kube">
    <div class="grid_12">
        <div class="register-6">
            <form class="form-style form-login border" method="POST">
                <h6 class="bebasneue font-login">Create Your Account</h6>
                <div class="controls-group clearfix">
                    <label class="login-label pull-left">Email:</label>
                    <div class="controls pull-left">
                        <input type="text" class="input-medium" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
                    </div>
                </div>
                
                <input type="hidden" name="register" value="1">

                <div class="actions controls-group clearfix">
                    <label class="login-label pull-left">&nbsp;</label>
                    <div class="controls pull-left">
                        <input class="btn" type="submit" value="Create Your Account"/>

                    </div>
                </div>



            </form>
        </div>
        <div class="register-6">
            <form class="form-style form-login border" method="POST">
                <h6 class="bebasneue font-login">Already Registered? Login In Below</h6>
                <?php echo Helper::print_error($message); ?>
                <div class="controls-group clearfix">
                    <label class="login-label pull-left">Email:</label>
                    <div class="controls pull-left">
                        <input type="text" class="input-medium" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="login-label pull-left">Password:</label>
                    <div class="controls pull-left">
                        <input type="password" class="input-medium" name="password" id="password" value=""/>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="login-label pull-left">&nbsp;</label>
                    <div class="controls pull-left">
                        <label class="checkbox"><input type="checkbox" value="remember" id="remember" name="remember"/> Remember me</label>
<!--                        <a class="register forgot-password" href="<?php //echo HelperUrl::baseUrl() ?>user/signup">Register</a>/-->
                        <a class="forgot-password" href="<?php echo HelperUrl::baseUrl() ?>user/forgot">Forgotten password?</a>
                    </div>
                </div>
                <div class="actions controls-group clearfix">
                    <label class="login-label pull-left">&nbsp;</label>
                    <div class="controls pull-left">
                        <input class="btn" type="submit" value="Submit"/>
                        <a class="btn-signup-fb" href="<?php echo HelperUrl::baseUrl() ?>user/loginfacebook?return=<?php echo urlencode($url_return)?>">
                            <img src="<?php echo HelperUrl::baseUrl() ?>images/bt_fb.png" alt=""/>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
