<div class="row signin">
    <div class="container clearfix">

        <div class="span10 offset1">
            <h1>Reset password</h1>
            <div class="row-fluid signin">
                <?php if(!$message['success'] && !$token): ?>
                <div class="span8 signin-form">
                    <h4 style="margin: 0 15px;">Email retrieve your password has been used or has expired. Click<a href="<?php echo Yii::app()->request->baseUrl ?>/user/forgot/">here</a> to reset password again.</h4>
                </div>
                <?php else:?>
                <div class="span8 signin-form">
                    <?php echo Helper::print_error($message); ?>
                    <?php echo Helper::print_success($message); ?>
                    <form class="form-horizontal clearfix" method="post" action="">                        
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="email">New Password</label>
                                <div class="controls">
                                    <input type="password" class="input-xlarge" name="pwd1" value="">
                                </div>
                            </div>           
                            <div class="control-group">
                                <label class="control-label" for="email"> Verify Password</label>
                                <div class="controls">
                                    <input type="password" class="input-xlarge" name="pwd2" value="">
                                </div>
                            </div>     
                            <input type="submit" class="hide"/>
                            <div class="controls-group">
                                <label class="control-label" >&nbsp;</label>
                                <div class="controls">
                                    <div class="row-fluid">                                    
                                        <a class="btn-style btn-login button-medium btn-submit" href="#">Reset password</a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <?php endif;?>
                <div class="span4 signin-contact">
                    Don't have an account yet? <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/signup">Sign up!</a><br/><br/>
                    Want to know more? <br>Give us a call, we'd love to chat. <span class="label label-info">012 345 6789</span>
                </div>
            </div>
        </div>
    </div>
</div>
