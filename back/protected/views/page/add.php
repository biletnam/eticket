<div>
    <hr>
<ul class="breadcrumb">
    <li><a href="<?php echo HelperUrl::baseUrl(); ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo HelperUrl::baseUrl(); ?>page/">Pages</a> <span class="divider">/</span> </li>
    <li class="active">Add</li>
</ul>
    <hr>
</div>
<legend>Add new page</legend>

<?php echo Helper::print_error($message); ?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">    
    <fieldset>
        
        <div class="control-group">
            <label class="control-label">Image</label>
            <div class="controls">
                <input type="file" name="file"/>
                <p class="help-block">Image must larger than 940x300px and smaller than 3MB</p>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Title</label>
            <div class="controls">
                <input class="span5" type="text" name="title" value="<?php if (isset($_POST['title'])) echo $_POST['title']; ?>">
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">Description</label>
            <div class="controls">
                <textarea class="span5 tinymce" rows="10" name="content"><?php if (isset($_POST['content'])) echo $_POST['content'] ?></textarea>
            </div>
        </div>

        <div class="form-actions">        
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
    </fieldset>
</form>

