
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Trang chủ</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/category/">Thể loại</a> <span class="divider">/</span> </li>
    <li class="active">Sửa <span class="divider">/</span> </li>
    <li class="active"><?php echo $category['title'] ?></li>
</ul>
<legend>Sửa thể loại: <?php echo $category['title'] ?></legend>

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
        <label class="control-label">Tên thể loại</label>
        <div class="controls">
            <input type="text" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($category['title']); ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Loại</label>
        <div class="controls">
            <select name="type">
                <?php foreach(Helper::category_types() as $k=>$v): ?>
                <option <?php if(isset($_POST['type']) && $_POST['type'] == $v) echo 'selected';else if($category['type'] == $k) echo 'selected'; ?> value="<?php echo $k ?>"><?php echo $v; ?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Hình ảnh</label>
        <div class="controls">
            <input type="file" name="file"/>
            <p class="help-block">Hình ảnh phải lơn hơn kích thước 300x300px và dung lượng nhỏ hơn 3MB</p>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Nội dung</label>
        <div class="controls">
            <textarea class="span5" rows="5" name="description"><?php echo isset($_POST['description']) ? $_POST['description'] : $category['description']; ?></textarea>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Feature</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="featured" value="0" <?php if(isset($_POST['featured']) && !$_POST['featured']) echo 'checked';else if(!$category['featured']) echo 'checked'; ?>>
                Không
            </label>
            <label class="radio">
                <input type="radio" name="featured" value="1" <?php if(isset($_POST['featured']) && $_POST['featured']) echo 'checked';else if($category['featured']) echo 'checked' ?>>
                Có
            </label>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Trạng thái</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="disabled" value="1" <?php if(isset($_POST['disabled']) && $_POST['disabled']) echo 'checked';else if($category['disabled']) echo 'checked'; ?>>
                Ẩn
            </label>
            <label class="radio">
                <input type="radio" name="disabled" value="0" <?php if(isset($_POST['disabled']) && !$_POST['disabled']) echo 'checked';else if(!$category['disabled']) echo 'checked' ?>>
                Hiện
            </label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Xóa</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="deleted" value="0" <?php if(isset($_POST['deleted']) && !$_POST['deleted']) echo 'checked';else if(!$category['deleted']) echo 'checked'; ?>>
                Không
            </label>
            <label class="radio">
                <input type="radio" name="deleted" value="1" <?php if(isset($_POST['deleted']) && $_POST['deleted']) echo 'checked';else if($category['deleted']) echo 'checked'; ?>>
                Có
            </label>
        </div>
    </div>

    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Sửa</button>
    </div>
</form>

