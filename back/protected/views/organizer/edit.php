
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/organizer/">Organizers</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>

<legend>Edit Organizer: <?php echo $organizer['title'] ?></legend>
<?php echo Helper::print_success($message); ?>
<?php echo Helper::print_error($message); ?>


<form class="form-horizontal" method="post" enctype="multipart/form-data" id="event_form">    
    <div class="tab-content">

        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <img class="img-polaroid" src="<?php echo HelperApp::get_thumbnail($organizer['thumbnail']); ?>" />
            </div>
        </div>


        <div class="control-group">
            <label class="control-label">Title</label>
            <div class="controls">
                <input type="text" class="input-xxlarge" name="title" value="<?php echo (isset($_POST['title'])) ? htmlspecialchars($_POST['title']) : (isset($organizer['title']) ? $organizer['title'] : '' ); ?>">
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
                <textarea type="text" class="input-xxlarge tinymce" name="description" ><?php echo (isset($_POST['description'])) ? htmlspecialchars($_POST['description']) : (isset($organizer['description']) ? $organizer['description'] : '' ); ?></textarea>
            </div>
        </div>

        <div class="form-actions">        
            <!--<button type="button" class="btn btn-continue">Tiếp tục &raquo;</button> -->
            <button style="margin-left: 50px" type="submit" class="btn btn-primary">Update</button>

        </div>

    </div>
</form>

