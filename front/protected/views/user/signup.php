<div class="row signup">
    <div class="container">
        <div class="span10 offset1">
            <h1>Become a Member</h1>
            <div class="row-fluid signup">
                <div class="span8 signup-form">
                    <?php echo Helper::print_error($message); ?>
                    <form class="form-horizontal" method="post">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="email">Email</label>
                                <div class="controls"><input type="text" class="input-xlarge" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password">Password</label>
                                <div class="controls"><input type="password" class="input-xlarge" name="pwd1" value=""></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password">Repeat password</label>
                                <div class="controls"><input type="password" class="input-xlarge" name="pwd2" value=""></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Full name</label>
                                <div class="controls"><input type="text" class="input-xlarge" name="fullname" value="<?php if (isset($_POST['fullname'])) echo $_POST['fullname']; ?>"></div>
                            </div>                            
                            <div class="controls">
                                <label class="checkbox">
                                    <input type="checkbox" name="remember" value="remember" id="remember">
                                    Remember me
                                </label>
                                <p class="help-block">By clicking "Sign up", I confirm that I agree with the eTicket <a href="<?php echo Yii::app()->request->baseUrl; ?>/info/view/page/terms-conditions">terms of service </a>.</p>
                            </div>
                            <div class="form-actions submit">
                                <button class="btn btn-primary btn-large" type="submit">Sign up</button>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="span4 signup-contact">
                    Already registered?<a href="<?php echo Yii::app()->request->baseUrl; ?>/user/signin"> Log in!</a><br/><br/>
                    Want to know more? <br>Give us a call, we'd love to chat. <span class="label label-info">012 345 6789</span>
                </div>
            </div>
        </div>                    
    </div>
</div>
</div>