<?php $arr_countries = Helper::countries(); ?>
<input type="hidden" id="register_done" value="<?php echo $register ?>">
<input type="hidden" id="link" value="<?php echo $link ?>">
<div class="container_12 page-register bg-kube ">
    <div class="grid_12">
        <form class="form-style form-register border" method="POST">
            <?php echo Helper::print_error($message); ?>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Email <span class="required">*</span></label>
                <div class="controls pull-left">
                    <input type="text" class="input-large" name="email" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : $email; ?>"/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Password <span class="required">*</span></label>
                <div class="controls pull-left">
                    <input type="password" class="input-large" name="pwd1"/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Confirm password <span class="required">*</span></label>
                <div class="controls pull-left">
                    <input type="password" class="input-large" name="pwd2"/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">First name <span class="required">*</span></label>
                <div class="controls pull-left">
                    <input type="text" style="width: 133px" class="input-mini" name="firstname" value="<?php if (isset($_POST['firstname'])) echo $_POST['firstname']; ?>"/>

                    <label class="sub-label"><strong>Last name <span class="required">*</span></strong></label>
                    <input class="input-mini" style="width: 133px" type="text" name="lastname" value="<?php if (isset($_POST['lastname'])) echo $_POST['lastname']; ?>"/>

                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Address <span class="required">*</span></label>
                <div class="controls pull-left">
                    <input type="text" class="input-large" name="address"/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Address 2</label>
                <div class="controls pull-left">
                    <input type="text" class="input-large" name="address2"/>
                </div>
            </div>

            <div class="controls-group clearfix hide">
                <label class="control-label pull-left">Phone (Home or Mobile): <span class="required">*</span></label>
                <div class="controls pull-left">
                    <input type="text" class="input-large" name="phone"/>
                </div>
            </div>

            <div class="controls-group clearfix">
                <label class="control-label pull-left">City <span class="required">*</span></label>
                <div class="controls pull-left">
                    <input type="text" class="input-large" name="city"/>
                </div>
            </div>
            <div class="controls-group clearfix">
                <label class="control-label pull-left">Country:</label>
                <div class="controls pull-left">
                    <select class="input-mini" name="country">
                        <?php foreach ($arr_countries as $c): ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo $c['title'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>



            <div class="controls-group clearfix">
                <label class="control-label pull-left">&nbsp;</label>
                <div class="controls pull-left" style="width: 415px">
                    <div class="rowElem">
                        <div class="jq-plugin clearfix">
                            <label class="checkbox label-signup"><input type="checkbox" name="client" value="client" id="client" <?php echo (isset($_POST['client']) && $_POST['client'] == "client") ? "checked" : ""; ?>/>  CHECK HERE TO REGISTER AS AN EVENT ORGANIZER.</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="controls-group clearfix client-input">
                <label class="control-label pull-left">Company <span class="required">*</span></label>
                <div class="controls pull-left">
                    <input type="text" class="input-large" name="company"/><br/><br/>
                    <p class="help-block">Enter name if you register as an event organizer</p>
                </div>
            </div>

            <div class="actions controls-group clearfix">
                <label class="control-label pull-left">&nbsp;</label>
                <div class="controls pull-left">
                    <input class="btn" type="submit" value="Submit"/>
                    <a class="btn-signup-fb" href="<?php echo HelperUrl::baseUrl() ?>user/loginfacebook">
                        <img src="<?php echo HelperUrl::baseUrl() ?>images/sign_up_fb.png" alt=""/>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<a style="display:none"  href="#invite" class="share-email btn-invite"></a>
<div id="invite" style="display: none">
    <h4>Congratulations! Your registration was successful.</h4>
    <p>Congratulations! Your registration was successful. You may now browse and purchase tickets from any event you wish to attend.</p>

    <p>If you registered as an ‘Event Organizer’ this section of your account will firstly need to be approved. This usually takes 24-48 hrs. Once you are approved we will send you an email confirming this</p>

</div>
