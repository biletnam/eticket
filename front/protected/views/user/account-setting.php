<section class="page-account-setting">
    <form class="form-style border border-radius">
        <div class="controls-group clearfix">
            <label class="control-label pull-left">&nbsp;</label>
            <div class="controls pull-left">
                <div class="user-avatar border">
                    <img src="<?php echo HelperUrl::baseUrl() ?>img/default.png"/>
                </div>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">Image</label>
            <div class="controls pull-left">
                <input type="file"/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">Email</label>
            <div class="controls pull-left">
                <input type="text" class="input-medium" disabled="" value="test@test.com"/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">First Name</label>
            <div class="controls pull-left">
                <input type="text" class="input-medium"/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">Last Name</label>
            <div class="controls pull-left">
                <input type="text" class="input-medium"/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">City</label>
            <div class="controls pull-left">
                <select class="input-mini">
                    <option>1</option>
                </select>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">&nbsp;</label>
            <div class="controls pull-left">
                <input type="submit" class="btn" value="Update"/>
            </div>
        </div>
    </form>
</section>