<?php $arr_cities = Helper::cities(); ?>
<div class="container_12 page-register bg-kube ">
    <div class="grid_12">
        <form class="form-style form-register border" method="POST">
            <?php echo Helper::print_error($message); ?>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Email:</label>
                <div class="controls pull-left">
                    <input type="text" class="input-large" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Password:</label>
                <div class="controls pull-left">
                    <input type="password" class="input-large" name="pwd1"/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Confirm password:</label>
                <div class="controls pull-left">
                    <input type="password" class="input-large" name="pwd2"/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">First name:</label>
                <div class="controls pull-left">
                    <input type="text" class="input-mini" name="firstname" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>"/>

                    <label class="sub-label"><strong>Last name:</strong></label>
                    <input class="input-mini" type="text" name="lastname" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>"/>

                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">City:</label>
                <div class="controls pull-left">
                    <select class="input-mini" name="city">
                        <?php foreach($arr_cities as $c): ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo $c['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">&nbsp;</label>
                <div class="controls pull-left">
                    <label class="checkbox"><input type="checkbox" name="client" value="client" id="client"/>  Register as an Event Organizer.</label>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">&nbsp;</label>
                <div class="controls pull-left">
                    <label class="checkbox"><input type="checkbox" name="remember"/> Remember me.</label>
                </div>
            </div>
            <div class="actions controls-group clearfix">
                <label class="control-label pull-left">&nbsp;</label>
                <div class="controls pull-left">
                    <input class="btn" type="submit" value="Submit"/>
                    <a class="btn-signup-fb" href="#">
                        <img src="<?php echo HelperUrl::baseUrl() ?>images/sign_up_fb.png" alt=""/>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
