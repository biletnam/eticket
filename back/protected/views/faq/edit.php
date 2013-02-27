
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Trang chủ</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/faq/">Faqs</a> <span class="divider">/</span> </li>
    <li class="active">Sửa <span class="divider">/</span></li>
    <li class="active"><?php echo $faq['title'] ?></li>
</ul>
<legend>Sửa Faq: <?php echo $faq['title'] ?></legend>

<?php echo Helper::print_success($message); ?>
<?php echo Helper::print_error($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">    
    
    <div class="control-group">
        <label class="control-label">Tiêu đề</label>
        <div class="controls">
            <input type="text" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars($_POST['title']) : htmlspecialchars($faq['title']); ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Thể loại</label>
        <div class="controls">
            <select name="category">
                <?php foreach($categories as $k=>$v): ?>
                <option <?php if(isset($_POST['category_id']) && $_POST['category_id'] == $v['id']) echo 'selected'; else if($faq['category_id'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Nội dung</label>
        <div class="controls">
            <textarea class="span5" rows="5" name="description"><?php echo isset($_POST['description']) ? trim($_POST['description']) : $faq['description'] ?></textarea>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Trạng thái</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="disabled" value="1" <?php if(isset($_POST['disabled']) && $_POST['disabled']) echo 'checked';else if($faq['disabled']) echo 'checked'; ?>>
                Ẩn
            </label>
            <label class="radio">
                <input type="radio" name="disabled" value="0" <?php if(isset($_POST['disabled']) && !$_POST['disabled']) echo 'checked';else if(!$faq['disabled']) echo 'checked' ?>>
                Hiện
            </label>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Xóa</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="deleted" value="0" <?php if(isset($_POST['deleted']) && !$_POST['deleted']) echo 'checked';else if(!$faq['deleted']) echo 'checked'; ?>>
                Không
            </label>
            <label class="radio">
                <input type="radio" name="deleted" value="1" <?php if(isset($_POST['deleted']) && $_POST['deleted']) echo 'checked';else if($faq['deleted']) echo 'checked'; ?>>
                Có
            </label>
        </div>
    </div>

    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Sửa</button>
    </div>
</form>

