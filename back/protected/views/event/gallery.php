
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
    <li class="<?php if ($type == "gallery") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/gallery/id/<?php echo $event['id'] ?>/">Gallery</a>
    </li>
    <li class="<?php if ($type == "seo") echo 'active' ?>">
        <a href="<?php echo Yii::app()->request->baseUrl; ?>/event/seo/id/<?php echo $event['id'] ?>/">SEO</a>
    </li>
    
</ul>

<div class="clearfix">
        <div class="grid_12 page-create-ticket">
            <ul class="gallery clearfix">
                <?php foreach ($gallerys as $g): ?>
                <li id="gallery_<?php echo $g['id']?>">
                        <a href="<?php echo HelperApp::get_thumbnail($g['thumbnail'], 'full') ?>" class="fancybox"><img src="<?php echo HelperApp::get_thumbnail($g['thumbnail'], 'small') ?>"></a>
                        <a class="icon icon-delete btn-delete " value="<?php echo $g['id']?>" href="<?php echo HelperUrl::baseUrl()?>event/delete_gallery/id/<?php echo $g['id']?>"><i class="icon-remove"></i></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <form class="form-style border border-radius" method="post" enctype="multipart/form-data">
                <div class="controls-group clearfix">
                    <label class="control-label pull-left"></label>
                    <div class="controls pull-left">
                        <input type="file" class="input-medium" name="file_1"/>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left"></label>
                    <div class="controls pull-left">
                        <input type="file" class="input-medium" name="file_2"/>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left"></label>
                    <div class="controls pull-left">
                        <input type="file" class="input-medium" name="file_3"/>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left"></label>
                    <div class="controls pull-left">
                        <input type="file" class="input-medium" name="file_4"/>
                    </div>
                </div>
                <div class="controls-group clearfix">
                    <label class="control-label pull-left"></label>
                    <div class="controls pull-left">
                        <input type="file" class="input-medium" name="file_5"/>
                    </div>
                </div>


                <div class="controls-group clearfix">
                    <label class="control-label pull-left">&nbsp;</label>
                    <div class="controls pull-left">
                        <input type="submit" class="btn" value="Upload"/>
                    </div>
                </div>
            </form>
        </div>
    </div>