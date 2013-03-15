
<div class="container_12">
    <div class="event-bar clearfix">
        <div class="grid_12">
            <ul class="clearfix">
                <li><a  href="<?php echo HelperUrl::baseUrl() ?>event/edit/id/<?php echo $event['id'] ?>/type/general"><i class="icon icon-edit-white"></i>Event Information</a></li>
                <li><a  href="<?php echo HelperUrl::baseUrl(); ?>event/edit/id/<?php echo $event['id'] ?>/type/ticket"><i class="icon icon-ticket"></i>Ticket</a></li>
                <li><a class="active" href="#"><i class="icon icon-ticket"></i>Gallery</a></li>
            </ul>
        </div>
    </div>
    <div class="clearfix">
        <div class="grid_12 page-create-ticket">
            <ul class="gallery clearfix">
                <?php foreach ($gallerys as $g): ?>
                <li id="gallery_<?php echo $g['id']?>">
                        <a href="<?php echo HelperApp::get_thumbnail($g['thumbnail'], 'full') ?>" class="fancybox"><img src="<?php echo HelperApp::get_thumbnail($g['thumbnail'], 'small') ?>"></a>
                        <a class="icon icon-delete btn-delete" value="<?php echo $g['id']?>" href="<?php echo HelperUrl::baseUrl()?>event/delete_gallery/id/<?php echo $g['id']?>"></a>
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
</div>