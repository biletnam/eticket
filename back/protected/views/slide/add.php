
<ul class="breadcrumb">
    <li><a href="<?php echo HelperUrl::baseUrl(); ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo HelperUrl::baseUrl(); ?>slide/">Sliders</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>

<legend>Add new slide</legend>

<?php echo Helper::print_error($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">    
    <fieldset>
        
        <div class="control-group">
            <label class="control-label">Image</label>
            <div class="controls">
                <input type="file" name="file"/>
                <p class="help-block">Image must larger than 1500 x 350px and smaller than 2MB</p>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Title</label>
            <div class="controls">
                <input type="text" name="title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
                <textarea class="span7 tinymce" rows="10" name="content"><?php if (isset($_POST['content'])) echo $_POST['content'] ?></textarea>
            </div>
        </div>

        <div class="form-actions">        
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </fieldset>
</form>

