<div class="container_12 page-register bg-kube">
    <div class="grid_12">
        <form class="form-style form-register border" method="POST">
            <?php echo Helper::print_error($message); ?>
            <?php echo Helper::print_success($message); ?>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Email:</label>
                <div class="controls pull-left">
                    <input type="text" class="input-large" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
                </div>
            </div>
            <div class="actions controls-group clearfix">
                <label class="control-label pull-left">&nbsp;</label>
                <div class="controls pull-left">
                    <button style="padding:0" type="submit"><img alt="Send" src="<?php echo HelperUrl::baseUrl() ?>images/bt_send.png"/></button>
                </div>
            </div>
        </form>
    </div>
</div>
