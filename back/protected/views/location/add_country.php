
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/location/city">City</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>
<legend>Add city</legend>


<?php echo Helper::print_error($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data" id="event_form">    
    <div class="tab-content">
    
            <div class="control-group">
                <label class="control-label">Title</label>
                <div class="controls">
                    <input type="text" class="input-xxlarge" name="title" value="<?php if (isset($_POST['title'])) echo htmlspecialchars($_POST['title']); ?>">
                </div>
            </div>


            <div class="form-actions">        
                <!--<button type="button" class="btn btn-continue">Tiếp tục &raquo;</button> -->
                <button style="margin-left: 50px" type="submit" class="btn btn-primary">Save</button>
            </div>

    </div>
</form>

