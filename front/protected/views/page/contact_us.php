<div class="page-contact padding-bottom-50px">
    <div class="container_12 page-register bg-kube">
        <div class="cleafix">
            <section class="grid_12">
                <form class="form-style form-register border border-radius" method="POST">
                    <?php echo Helper::print_error($message); ?>
                    <?php echo Helper::print_success($message); ?>
                    <div class="controls-group clearfix">
                        <label class="control-label pull-left">Name</label>
                        <div class="controls pull-left">
                            <input type="text" class="input-medium" name="yourname" value="<?php if(isset($_POST['yourname'])) echo $_POST['yourname'] ?>"/>
                        </div>
                    </div>
                    <div class="controls-group clearfix">
                        <label class="control-label pull-left">Email</label>
                        <div class="controls pull-left">
                            <input type="text" class="input-medium" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email'] ?>"/>
                        </div>
                    </div>
                    <div class="controls-group clearfix">
                        <label class="control-label pull-left">Message</label>
                        <div class="controls pull-left">
                            <textarea style="height: 200px" class="input-medium" name="message"><?php if(isset($_POST['message'])) echo $_POST['message'] ?></textarea>
                        </div>
                    </div>
                    <div class="controls-group clearfix">
                        <label class="control-label pull-left">&nbsp;</label>
                        <div class="controls pull-left">
                            <input type="submit" class="btn" value="Submit"/>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>