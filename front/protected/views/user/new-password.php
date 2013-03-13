<div class="container_12 page-register bg-kube">
    <div class="grid_12">
        <form class="form-style form-register border" method="POST">
            <?php if (!$message['success'] && !$token): ?>
                <div class="span8 signin-form">
                    <p>Email retrieve your password has been used or has expired. Click<a href="<?php echo Yii::app()->request->baseUrl ?>/user/forgot/">here</a> to reset password again.</p>
                </div>
            <?php else: ?>
                <?php echo Helper::print_error($message); ?>
                <?php echo Helper::print_success($message); ?>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">New password:</label>
                    <div class="controls pull-left">
                        <input type="password" class="input-large" name="pwd1" value=""/>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left">Confirm password:</label>
                    <div class="controls pull-left">
                        <input type="password" class="input-large" name="pwd2" value=""/>
                    </div>
                </div>
                <div class="actions controls-group clearfix">
                    <label class="control-label pull-left">&nbsp;</label>
                    <div class="controls pull-left">
                        <input class="btn" type="submit" value="Submit"/>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
