<div>
    <hr>
        <ul class="breadcrumb">
            <li><a href="<?php echo HelperUrl::baseUrl(); ?>">Home</a> <span class="divider">/</span> </li>
            <li><a href="<?php echo HelperUrl::baseUrl(); ?>advertise/">Advertises</a> <span class="divider">/</span> </li>
            <li class="active">Edit <span class="divider">/</span> </li>
            <li class="active"><?php echo $page['title'] ?></li>
        </ul>
    <hr>
</div>
<legend>Edit page</legend>

<?php echo Helper::print_error($message); ?>
<?php echo Helper::print_success($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
    <?php //print_r($advertise);die; ?>
    <fieldset>     
        <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <img width="150px" src="<?php echo HelperApp::get_thumbnail($page['thumbnail']) ?>" />
                </div>
        </div>
        <div class="control-group">
            <label class="control-label">Image</label>
            <div class="controls">
                <input type="file" name="file"/>
                <p class="help-block">Image must larger than 940x300px and smaller than 3MB</p>
            </div>
        </div>
       
        <div class="control-group">
            <label class="control-label">Title</label>
            <div class="controls">
                <input class="span9" type="text" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($page['title']); ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
                <textarea class="span5 tinymce" rows="10" name="content"><?php echo isset($_POST['content']) ? $_POST['content'] : $page['content']; ?></textarea>
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">Active</label>
            <div class="controls">
                <label class="radio small">
                    <input type="radio" name="disabled" value="1" <?php if (isset($_POST['disabled']) && $_POST['disabled']) echo 'checked';else if ($page['disabled']) echo 'checked'; ?>>
                    No
                </label>
                <label class="radio small">
                    <input type="radio" name="disabled" value="0" <?php if (isset($_POST['disabled']) && !$_POST['disabled']) echo 'checked';else if (!$page['disabled']) echo 'checked' ?>>
                    Yes
                </label>


            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Deleted</label>
            <div class="controls">
                <label class="radio small">
                    <input type="radio" name="deleted" value="0" <?php if (isset($_POST['deleted']) && !$_POST['deleted']) echo 'checked';else if (!$page['deleted']) echo 'checked'; ?>>
                    No
                </label>    
                <label class="radio small">
                    <input type="radio" name="deleted" value="1" <?php if (isset($_POST['deleted']) && $_POST['deleted']) echo 'checked';else if ($page['deleted']) echo 'checked'; ?>>
                    Yes
                </label>

            </div>
        </div>

        <div class="form-actions">        
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </fieldset>
</form>

