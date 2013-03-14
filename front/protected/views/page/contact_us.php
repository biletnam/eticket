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
                            <input type="text" class="input-medium" name="yourname"/>
                        </div>
                    </div>
                    <div class="controls-group clearfix">
                        <label class="control-label pull-left">Email</label>
                        <div class="controls pull-left">
                            <input type="text" class="input-medium" name="email"/>
                        </div>
                    </div>
                    <div class="controls-group clearfix">
                        <label class="control-label pull-left">Message</label>
                        <div class="controls pull-left">
                            <input type="text" class="input-medium" name="message"/>
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