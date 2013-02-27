
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/category/">Category</a> <span class="divider">/</span> </li>
    <li class="active">Edit <span class="divider">/</span> </li>
    <li class="active"><?php echo $category['title'] ?></li>
</ul>
<legend>Edit a category: <?php echo $category['title'] ?></legend>

<?php echo Helper::print_error($message); ?>
<?php echo Helper::print_success($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="control-group">
        <label class="control-label"></label>
        <div class="controls">
            <img class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($category['thumbnail']); ?>" />
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Title</label>
        <div class="controls">
            <input type="text" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($category['title']); ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Type</label>
        <div class="controls">
            <select name="type">
                <?php foreach(Helper::category_types() as $k=>$v): ?>
                <option <?php if(isset($_POST['type']) && $_POST['type'] == $v) echo 'selected';else if($category['type'] == $k) echo 'selected'; ?> value="<?php echo $k ?>"><?php echo $v; ?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Image</label>
        <div class="controls">
            <input type="file" name="file"/>
            <p class="help-block">Must be JPG, GIF, or PNG smaller than 2MB and larger than 300 x 300 px.</p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Description</label>
        <div class="controls">
            <textarea class="span5" rows="5" name="description"><?php echo isset($_POST['description']) ? $_POST['description'] : $category['description']; ?></textarea>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Feature</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="featured" value="0" <?php if(isset($_POST['featured']) && !$_POST['featured']) echo 'checked';else if(!$category['featured']) echo 'checked'; ?>>
                No
            </label>
            <label class="radio">
                <input type="radio" name="featured" value="1" <?php if(isset($_POST['featured']) && $_POST['featured']) echo 'checked';else if($category['featured']) echo 'checked' ?>>
                Yes
            </label>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Status</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="disabled" value="1" <?php if(isset($_POST['disabled']) && $_POST['disabled']) echo 'checked';else if($category['disabled']) echo 'checked'; ?>>
                Disabled
            </label>
            <label class="radio">
                <input type="radio" name="disabled" value="0" <?php if(isset($_POST['disabled']) && !$_POST['disabled']) echo 'checked';else if(!$category['disabled']) echo 'checked' ?>>
                Enabled
            </label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Deleted</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="deleted" value="0" <?php if(isset($_POST['deleted']) && !$_POST['deleted']) echo 'checked';else if(!$category['deleted']) echo 'checked'; ?>>
                No
            </label>
            <label class="radio">
                <input type="radio" name="deleted" value="1" <?php if(isset($_POST['deleted']) && $_POST['deleted']) echo 'checked';else if($category['deleted']) echo 'checked'; ?>>
                Yes
            </label>
        </div>
    </div>

    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

