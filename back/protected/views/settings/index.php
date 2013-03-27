
        <ul class="breadcrumb">
            <li><a href="<?php echo HelperUrl::baseUrl(); ?>">Home</a> <span class="divider">/</span> </li>
            <li><a href="<?php echo HelperUrl::baseUrl(); ?>settings/">Settings</a> <span class="divider">/</span> </li>
        </ul>

<legend>Page Settings</legend>

<?php echo Helper::print_success($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
    <fieldset>     

       <?php foreach($settings as $k => $v): ?>
        <div class="control-group">
            <label class="control-label"><?php echo $v['option_title'] ?></label>
            <div class="controls">
                <input class="span5" type="text" name="<?php echo $v['option_key'] ?>" value="<?php echo isset($_POST[$k]) ? htmlspecialchars($_POST[$k]) : htmlspecialchars($v['option_value']); ?>">
            </div>
        </div>
        <?php endforeach; ?>

        <div class="form-actions">        
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </fieldset>
</form>