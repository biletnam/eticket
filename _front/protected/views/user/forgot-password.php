<div class="row signin">
    <div class="container clearfix">

        <div class="span10 offset1">
            <h1>Reset your password </h1>
            <div class="row-fluid signin">
                <div class="span8 signin-form">
                    <?php echo Helper::print_error($message); ?>
                    <?php echo Helper::print_success($message); ?>
                    <form class="form-horizontal clearfix forgot-password" method="post" action="">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="email">Email</label>
                                <div class="controls">
                                    <input type="text" class="input-xlarge" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
                                </div>
                            </div>                            
                            <input type="submit" class="hide"/>
                            <div class="controls-group">
                                <label class="control-label" >&nbsp;</label>
                                <div class="controls">
                                    <div class="row-fluid">                                    
                                        <a class="btn-style btn-login button-medium btn-submit" href="#">Reset your password </a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="span4 signin-contact">
                    Don't have an account yet? <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/signup">Sign up!</a><br/><br/>
                    Want to know more? <br>Give us a call, we'd love to chat. <span class="label label-info">012 345 6789</span>
                </div>
            </div>
        </div>
    </div>
</div>
