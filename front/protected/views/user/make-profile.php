<div class="container_12 page-make-profile padding-bottom-50px">
    <div class="clearfix">
        <div class="grid_12">
            <form method="POST" class="form-style border">
                <div class="clearfix">
                    <section class="organizer pull-left">
                        <div class="controls-group">
                            <p>Organizer name</p>
                            <input type="text" class="input-medium"/>
                        </div>
                        <div class="controls-group">
                            <div class="clearfix">
                                <p>Organizer logo</p>
                                <div class="clearfix">
                                    <img class="organizer-logo pull-left" src="<?php echo HelperUrl::baseUrl() ?>img/organizer_logo.png" alt="" class="pull-left"/>
                                    <div class="note-image">
                                        <div>Your image must be JPG, GIF, or PNG format and not exceed 1MB. It will be resized to make its width 300px.</div>
                                        <br/>
                                        <input type="file"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="organizer-description pull-left">
                        <div class="controls-group">
                            <p>About the organizer</p>
                            <textarea class="tinymce"></textarea>
                        </div>
                    </section>
                </div>
                <div class="actions">
                    <input type="submit" class="btn" value="Save"/>
                    <a class="btn" href="<?php echo HelperUrl::baseUrl() ?>user/view_profile/s/current">View profile</a>
                </div>
            </form>
        </div>
    </div>
</div>