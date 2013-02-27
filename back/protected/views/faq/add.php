
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Trang chủ</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/faq/">Faqs</a> <span class="divider">/</span> </li>
    <li class="active">Thêm mới</li>
</ul>
<legend>Thêm Faq</legend>

<?php echo Helper::print_error($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">    
    
    <div class="control-group">
        <label class="control-label">Tiêu đề</label>
        <div class="controls">
            <input type="text" name="title" value="<?php if (isset($_POST['title'])) echo htmlspecialchars ($_POST['title']); ?>">
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Thể loại</label>
        <div class="controls">
            <select name="category">
                <?php foreach($categories as $k=>$v): ?>
                <option <?php if(isset($_POST['type']) && $_POST['type'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id'] ?>"><?php echo $v['title']; ?></option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Nội dung</label>
        <div class="controls">
            <textarea rows="5" class="span5" name="description"><?php if(isset($_POST['description'])) echo $_POST['description']; ?></textarea>
        </div>
    </div>
    
    <div class="control-group">
        <label class="control-label">Trạng thái</label>
        <div class="controls">
            <label class="radio">
                <input type="radio" name="disabled" value="1" <?php if (isset($_POST['disabled']) && $_POST['disabled']) echo 'checked'; ?>>
                Ẩn
            </label>
            <label class="radio">
                <input type="radio" name="disabled" value="0" <?php if (isset($_POST['disabled']) && !$_POST['disabled']) echo 'checked'; ?> checked>
                Hiện
            </label>
        </div>
    </div>

    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Thêm</button>
    </div>
</form>

