
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/location/city">City</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>

<legend>Edit City: <?php echo $city['title'] ?></legend>
<?php echo Helper::print_success($message); ?>
<?php echo Helper::print_error($message); ?>


<form class="form-horizontal" method="post" enctype="multipart/form-data" id="event_form">    
    <div class="tab-content">

        <div class="control-group">
            <label class="control-label">Title</label>
            <div class="controls">
                <input type="text" class="input-xxlarge" name="title" value="<?php echo (isset($_POST['title'])) ? htmlspecialchars($_POST['title']) : (isset($city['title']) ? $city['title'] : '' ); ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">Deleted</label>
            <div class="controls">
                <label class="radio">
                    <input type="radio" name="deleted" value="0" <?php if (isset($_POST['deleted']) && !$_POST['deleted']) echo 'checked';else if (!$city['deleted']) echo 'checked'; ?>>
                    No
                </label>
                <label class="radio">
                    <input type="radio" name="deleted" value="1" <?php if (isset($_POST['deleted']) && $_POST['deleted']) echo 'checked';else if ($city['deleted']) echo 'checked'; ?>>
                    Yes
                </label>
            </div>
        </div>

        <div class="form-actions">        
            <!--<button type="button" class="btn btn-continue">Tiếp tục &raquo;</button> -->
            <button style="margin-left: 50px" type="submit" class="btn btn-primary">Update</button>

        </div>

    </div>
</form>

