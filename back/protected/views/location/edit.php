
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/location/">Location</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>

<legend>Edit Location: <?php echo $location['title'] ?></legend>
<?php echo Helper::print_success($message); ?>
<?php echo Helper::print_error($message); ?>


<form class="form-horizontal" method="post" enctype="multipart/form-data" id="event_form">    
    <div class="tab-content">
    
            <div class="control-group">
                <label class="control-label">Title</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="title" value="<?php echo (isset($_POST['title'])) ? htmlspecialchars($_POST['title']) : (isset($location['title']) ? $location['title'] : '' ); ?>">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">City</label>
                <div class="controls">
                    <select name="country">
                        <?php foreach ($countries as $k => $v): ?>
                            <option <?php echo (isset($_POST['country']) && $_POST['country'] == $v['id']) ?  'selected' : ((isset($location['country_id']) && $location['country_id'] == $v['id']) ? 'selected' :''); ?> value="<?php echo $v['id']; ?>"><?php echo $v['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        
          <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    <textarea type="text" class="input-xxlarge" name="address" ><?php echo (isset($_POST['address'])) ? htmlspecialchars($_POST['address']) : (isset($location['address']) ? $location['address'] : '' ); ?></textarea>
                </div>
            </div>

            <div class="form-actions">        

                <button style="margin-left: 50px" type="submit" class="btn btn-primary">Update</button>
               
            </div>

    </div>
</form>

