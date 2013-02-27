
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/event/">Event</a> <span class="divider">/</span> </li>
    <li class="active">Edit <span class="divider">/</span> </li>
    <li class="active"><?php echo $event['title'] ?></li>
</ul>
<legend>SEO</legend>

<?php echo Helper::print_error($message); ?>
<?php echo Helper::print_success($message); ?>

<ul class="nav nav-tabs">
    <li class="<?php if ($type == "general") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/edit/id/<?php echo $event['id'] ?>/type/general">Information</a>
    </li>
    <li class="<?php if ($type == "ticket") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/edit/id/<?php echo $event['id'] ?>/type/ticket">Ticket</a>
    </li>    
    <li class="<?php if ($type == "seo") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/seo/id/<?php echo $event['id'] ?>/">SEO</a>
    </li>
</ul>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
    <div class="control-group">
        <label class="control-label">Meta Title</label>
        <div class="controls">
            <textarea name="title" class="span7"><?php echo isset($metas['title']) ? $metas['title'] : ""; ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Meta keyword</label>
        <div class="controls">
            <textarea name="keyword" class="span7"><?php echo isset($metas['keyword']) ? $metas['keyword'] : ""; ?></textarea>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">Meta Description</label>
        <div class="controls">
            <textarea name="description" rows="10" class="span7"><?php echo isset($metas['description']) ? $metas['description'] : ""; ?></textarea>
        </div>
    </div>
    
    <div class="form-actions">        
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>