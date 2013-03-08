<div class="row signin">
    <div class="container clearfix">
        
        <div class="span10 offset1">
            <h1>Login</h1>
            <div class="row-fluid signin">
                <div class="span8 signin-form">
                    <?php echo Helper::print_error($message); ?>
                    <div class="forgot_password clearfix" >
                        <a class="pull-right" href="<?php echo Yii::app()->request->baseUrl ?>/user/forgot/">Forgot Password?</a>
                    </div>
                    <form class="form-horizontal clearfix" method="post" action="">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label" for="email">Email</label>
                                <div class="controls"><input type="text" class="input-xlarge" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>"></div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password">Password</label>
                                <div class="controls"><input type="password" class="input-xlarge" name="password" id="password" value=""></div>
                            </div>
                            <input type="submit" class="hide"/>
                            <div class="controls-group">
                                <label class="control-label" >&nbsp;</label>
                                <div class="controls">
                                    <div class="row-fluid">
                                    <label class="checkbox inline">
                                        <input type="checkbox" value="remember" id="remember" name="remember">
                                        Remember me
                                    </label>
                                    <a class="btn-style btn-login button-medium btn-submit" href="#">Log in</a>
                                    <a href="<?php echo HelperUrl::baseUrl()?>user/loginfacebook" ><img src="<?php echo HelperUrl::baseUrl()?>images/facebook-login.png"></a>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="span4 signin-contact">
                    Don't have an account yet? <a href="<?php echo Yii::app()->request->baseUrl; ?>/user/signup">Sign up!</a><br/><br/>
                    Want to know more? <br>Give us a call, we'd love to chat. <span class="label label-info">012 345 6789</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="fb-root"></div>
<script>
  window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '104204896436938', // App ID from the App Dashboard
      channelUrl : '//<?php echo HelperUrl::baseUrl()?>/channel.html', // Channel File for x-domain communication
      status     : true, // check the login status upon init?
      cookie     : true, // set sessions cookies to allow your server to access the session?
      xfbml      : true  // parse XFBML tags on this page?
    });

    // Additional initialization code such as adding Event Listeners goes here

  };

  // Load the SDK's source Asynchronously
  // Note that the debug version is being actively developed and might 
  // contain some type checks that are overly strict. 
  // Please report such bugs using the bugs tool.
  (function(d, debug){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";
     ref.parentNode.insertBefore(js, ref);
   }(document, /*debug*/ false));
</script>
