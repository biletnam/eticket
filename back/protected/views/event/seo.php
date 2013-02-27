
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Trang chủ</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/">Sự kiện</a> <span class="divider">/</span> </li>
    <li class="active">Sửa <span class="divider">/</span> </li>
    <li class="active"><?php echo $event['title'] ?></li>
</ul>
<legend>SEO</legend>

<?php echo Helper::print_error($message); ?>
<?php echo Helper::print_success($message); ?>

<ul class="nav nav-tabs">
    <li class="<?php if ($type == "general") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/edit/id/<?php echo $event['id'] ?>/type/general">Thông tin chung</a>
    </li>
    <li class="<?php if ($type == "ticket") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/edit/id/<?php echo $event['id'] ?>/type/ticket">Vé</a>
    </li>    
    <li class="<?php if ($type == "seo") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/seo/id/<?php echo $event['id'] ?>/">SEO</a>
    </li>
</ul>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="control-group">
        <label class="control-label">Tiêu đề</label>
        <div class="controls">
            <textarea name="title" class="span7"><?php echo isset($metas['title']) ? $metas['title'] : ""; ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Từ khóa</label>
        <div class="controls">
            <textarea name="keyword" class="span7"><?php echo isset($metas['keyword']) ? $metas['keyword'] : ""; ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Nội dung</label>
        <div class="controls">
            <textarea name="description" rows="10" class="span7"><?php echo isset($metas['description']) ? $metas['description'] : ""; ?></textarea>
        </div>
    </div>
    
    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </div>
</form>