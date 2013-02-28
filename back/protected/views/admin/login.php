<div id="login-panel" class="span6 offset3">

    <?php echo Helper::print_error($message); ?>
    <form class="well" method="post" action="">
        <fieldset>
            <div>
                <label>Username</label>
                <input type="text" name="title" class="input-xlarge" value="<?php echo isset($_POST['title']) ? $_POST['title'] : "" ?>">
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" class="input-xlarge">
            </div>
            <button type="submit" class="btn btn-large btn-primary">Log in</button>
        </fieldset>
    </form>
</div>
<div class="clearfix"></div>