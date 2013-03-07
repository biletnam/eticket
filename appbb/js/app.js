var baseHost = 'http://localhost/eticket/front/';
$(document).ready(function(){
    checkLogin();
    register();
    profile();
    logout();
    initMenus();
});

function checkLogin(){
    $('#login .sm-login').click(function(){
        var email = $('#login .username').val();
        var password = $('#login .password').val();
    
        var data ={
            email: email, 
            password: password
        } ;
        $.post(baseHost+'app/login',data,function(a) {
            if(a.success == true)
                window.location = "profile.html?"+a.id;
            else{
                $('#login .login-status').text('Login Fail');
            }
            if(a.error.length>0){
                for(var i = 0;i<a.error.length;i++){
                    //console.log(a.error[i]);
                    }
            }
            
        },'json');
    });
}

function register(){
    $('#register .sm-register').click(function(){
        var error;
        var fullname = $('.fullname').val();
        var pwd1 = $('.pwd1').val();
        var pwd2 = $('.pwd2').val();
        var email = $('.email').val();
    
        var data ={
            fullname: fullname, 
            pwd1: pwd1,
            pwd2: pwd2,
            email:email
        } ;
        $.post(baseHost+'app/register',data,function(a) {
            
            if(a.error.length>0){
                for(var i = 0;i<a.error.length;i++){
                    error = error+ a.error[i]+"<br/>";
                }
            }
            if(a.success == true)
                  window.location = "profile.html?"+a.id;
            else{
                $('#register .register-status').text('Register Fail');
            }
        },'json');
    });
}

function profile(){
    if(!$('#profile'))
        return false;
    
    var url =window.location.href;
    var n = url.split('?');
    var id = n[1];

    
    $.post(baseHost+'app/profile/id/'+id,function(a) {

         $('#profile .fullname').text(a.fullname);
         $('#profile .email').text(a.email);
        },'json');
}

function logout(){
     $('.sm-logout').click(function(){
          window.location = "index.html"
     });
}

function initMenus() {
    try {
        //create MenuItem objects:
        //
        //   @param isSeparator (Boolean) - true/false whether this item is a menu separator
        //   @param ordinal (Number) - specifies sort order within the menu.  Lower ordinal values have higher position in menu.
        //   @param caption (String) - text to be displayed in menu for this menu item.
        //   @param iscallback (OnClick) - JavaScript function name to be called when user selects this menu item. 
        // 
        var mi_top = new blackberry.ui.menu.MenuItem(true, 0);
        var mi_appWorld = new blackberry.ui.menu.MenuItem(false, 1, "Open App World");
        var mi_about = new blackberry.ui.menu.MenuItem(false, 2, "About");
        var mi_reload = new blackberry.ui.menu.MenuItem(false, 3, "Refresh");
        var mi_middle = new blackberry.ui.menu.MenuItem(true, 4);
        var mi_share = new blackberry.ui.menu.MenuItem(false, 5, "Share ...");
        var mi_bottom = new blackberry.ui.menu.MenuItem(true, 6);


        //Optionally remove any default menu items:
        //
        blackberry.ui.menu.clearMenuItems();


        //Add your own custom MenuItem objects to the menu:
        //
        blackberry.ui.menu.addMenuItem(mi_top);
        blackberry.ui.menu.addMenuItem(mi_appWorld);
        blackberry.ui.menu.addMenuItem(mi_about);
        blackberry.ui.menu.addMenuItem(mi_reload);
        blackberry.ui.menu.addMenuItem(mi_middle);
        blackberry.ui.menu.addMenuItem(mi_share);


        //Optionally check to see if a menu item already exists:
        //
        if (blackberry.ui.menu.hasMenuItem(mi_bottom)) {
            blackberry.ui.menu.removeMenuItem(mi_bottom);
        }
        blackberry.ui.menu.addMenuItem(mi_bottom);

        blackberry.ui.menu.setDefaultMenuItem(mi_about);

        alert("Menu Items Added");
    }
    catch (e) {
        console.log('exception (addMenus): ' + e.name + '; ' + e.message);
    }
}




