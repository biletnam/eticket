
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/location/">Location</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>
<legend>Add Location</legend>


<?php echo Helper::print_error($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data" id="event_form">    
    <div class="tab-content">
    
            <div class="control-group">
                <label class="control-label">Title</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="title" value="<?php if (isset($_POST['title'])) echo htmlspecialchars($_POST['title']); ?>">
                </div>
            </div>
        
            <div class="control-group">
                <label class="control-label">City</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="city" value="<?php if (isset($_POST['city'])) echo htmlspecialchars($_POST['city']); ?>">
                </div>
            </div>
        
            <div class="control-group">
                <label class="control-label">Country</label>
                <div class="controls">
                    <select name="country">
                        <?php foreach ($countries as $k => $v): ?>
                            <option <?php if (isset($_POST['country']) && $_POST['country'] == $v['id']) echo 'selected'; ?> value="<?php echo $v['id']; ?>"><?php echo $v['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        
          <div class="control-group">
                <label class="control-label">Address</label>
                <div class="controls">
                    <textarea type="text" class="input-xxlarge" name="address" ><?php if (isset($_POST['address'])) echo htmlspecialchars($_POST['address']); ?></textarea>
                </div>
            </div>

            <div class="form-actions">        
                <button style="margin-left: 50px" type="submit" class="btn btn-primary">Save</button>
            </div>

    </div>
</form>

