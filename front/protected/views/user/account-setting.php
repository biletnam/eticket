<section class="page-account-setting">
    <form class="form-style border border-radius" method="POST" enctype="multipart/form-data">
        <?php echo Helper::print_error($message); ?>
        <?php echo Helper::print_success($message); ?>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">&nbsp;</label>
            <div class="controls pull-left">
                <div class="user-avatar border">
                    <img src="<?php echo HelperApp::get_thumbnail(UserControl::getThumbnail(),'small'); ?>" alt=""/>
                </div>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">Image</label>
            <div class="controls pull-left">
                <input type="file" name="file"/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">Email</label>
            <div class="controls pull-left">
                <input type="text" class="input-medium" disabled="" value="<?php echo UserControl::getEmail(); ?>"/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">First Name</label>
            <div class="controls pull-left">
                <input type="text" class="input-medium" name="firstname" value="<?php if (isset($_POST['firstname'])) echo htmlspecialchars($_POST['firstname']);else echo UserControl::getFirstname(); ?>"/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">Last Name</label>
            <div class="controls pull-left">
                <input type="text" class="input-medium" name="lastname" value="<?php if (isset($_POST['lastname'])) echo htmlspecialchars($_POST['lastname']);else echo UserControl::getLastname(); ?>"/>
            </div>
        </div>
        <div class="controls-group clearfix">
            <label class="control-label pull-left">City</label>
            <div class="controls pull-left">
                <select name="city_id">
                    <?php foreach ($cities as $v): ?>
                        <option value="<?php echo $v['id']; ?>" <?php if (isset($_POST['city_id']) && $_POST['city_id'] == $v['id']) echo 'selected';else if (UserControl::getCityId() == $v['id']) echo 'selected'; ?>><?php echo $v['title']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="controls-group">
            <label class="control-label pull-left">Address</label>
            <div class="controls">
                <input class="input-medium" type="text" name="address" value="<?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']);else if (isset($metas['address'])) echo htmlspecialchars($metas['address']); ?>" >
            </div>
        </div>
        <div class="controls-group">
            <label class="control-label pull-left">Phone</label>
            <div class="controls">
                <input class="input-medium" type="text" name="phone" value="<?php if (isset($_POST['phone'])) echo htmlspecialchars($_POST['phone']);else if (isset($metas['phone'])) echo htmlspecialchars($metas['phone']); ?>" >
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