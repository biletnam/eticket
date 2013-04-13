
<ul class="breadcrumb">
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>">Home</a> <span class="divider">/</span> </li>
    <li><a href="<?php echo Yii::app()->request->baseUrl; ?>/email/">Emails</a> <span class="divider">/</span> </li>
    <li class="active">Edit</li>
</ul>

<legend>Edit Email</legend>
<?php echo Helper::print_success($message); ?>
<?php echo Helper::print_error($message); ?>

<div class="row-fluid">

    <form class="form-horizontal" method="post" enctype="multipart/form-data" id="event_form">    
        <fieldset>

            <div class="control-group">
                <label class="control-label">Title</label>
                <div class="controls">
                    <input type="text" class="span11" name="title" value="<?php echo isset($_POST['title']) ? htmlspecialchars(trim($_POST['title'])) : trim(htmlspecialchars($email['title'])); ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Content</label>
                <div class="controls">
                    <textarea rows="20" type="text" class="span11" name="content" ><?php echo isset($_POST['content']) ? htmlspecialchars(trim($_POST['content'])) : trim(htmlspecialchars($email['content'])); ?></textarea>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Tips</label>
                <div class="controls">
                    <div class="alert">
                        Every replacement string has follow this format : <strong>$[key]</strong>. Erase the replacement string means erase the data from that string. <br/><br/>
                        You can use any format css style here. 
                        
                    </div>
                </div>
            </div>

            <div class="form-actions">                    
                <button style="margin-left: 50px" type="submit" class="btn btn-primary">Update</button>

            </div>

        </fieldset>
    </form>
</div>
