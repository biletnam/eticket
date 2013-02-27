
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/faq/">FAQs</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>
<legend>Add a new FAQ</legend>

<?php echo Helper::print_error($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">    
    
    <div class="control-group">
        <label class="control-label">FAQ title</label>
        <div class="controls">
            <input type="text" name="title" class="span5" value="<?php if (isset($_POST['title'])) echo htmlspecialchars ($_POST['title']); ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Type</label>
        <div class="controls">
            <select name="category">
                <?php foreach($categories as $k=>$v): ?>
                <option <?php if(isset($_POST['type']) && $_POST['type'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Description</label>
        <div class="controls">
            <textarea rows="5" class="span5" name="description"><?php if(isset($_POST['description'])) echo $_POST['description']; ?></textarea>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Status</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="disabled" value="1" <?php if (isset($_POST['disabled']) && $_POST['disabled']) echo 'checked'; ?>>
                Hide
            </label>
            <label class="radio">
                <input type="radio" name="disabled" value="0" <?php if (isset($_POST['disabled']) && !$_POST['disabled']) echo 'checked'; ?> checked>
                Show
            </label>
        </div>
    </div>

    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

