var baseHost = 'http://localhost/eticket/';
var api_token = "4d50a7f525245db890218329b518f0edc0d7f8f7";



$(document).ready(function() {
    initMenus();
    register();
});

function register() {
    $('.btn-register').click(function() {
        var email = $('.email').val();
        var pass = $('.password').val();
        var re_pass = $('.re-password').val();
        var f_name = $('.first-name').val();
        var l_name = $('.last-name').val();
        var address = $('.address').val();
        var address_2 = $('.address_2').val();
        var phone = $('.phone').val();
        var city = $('.city').val();
        var country = $('.country').val();

        var client = $('.client').attr('checked');



        var error = 0;
        var message = "";

        if (email == "") {
            error++;
            high_light_field('.email');
        }
        else {
            disable_high_light('.email');
        }
        if (pass == "") {
            error++;
            high_light_field('.password');
        }
        else {
            disable_high_light('.password');
        }
        if (re_pass == "") {
            error++;
            high_light_field('.re-password');
        }
        else {
            disable_high_light('.re-password');
        }

        if (pass == "" || (pass != re_pass)) {
            error++;
            high_light_field('.password');
            high_light_field('.re-password');
        }
        else {
            disable_high_light('.password');
            disable_high_light('.re-password');
        }
        if (f_name == "") {
            error++;
            high_light_field('.first-name');
        }
        else {
            disable_high_light('.first-name');
        }
        if (l_name == "") {
            error++;
            high_light_field('.last-name');
        }
        else {
            disable_high_light('.last-name');
        }
        if (address == "") {
            error++;
            high_light_field('.address');
        }
        else {
            disable_high_light('.address');
        }
        if (phone == "") {
            error++;
            high_light_field('.phone');
        }
        else {
            disable_high_light('.phone');
        }
        if (city == "") {
            error++;
            high_light_field('.city');
        }
        else {
            disable_high_light('.city');
        }

        if (error == 0) {

            var data = {
                email: email,
                pwd1: pass,
                pwd2: re_pass,
                firstname: f_name,
                lastname: l_name,
                address: address,
                address2: address_2,
                phone: phone,
                city: city,
                country: country,
                os_version: 'bb',
                os_name: 'bb',
                device_name: 'test'
            };
            if (typeof(client != "undefined")) {
                var data = {
                    email: email,
                    pwd1: pass,
                    pwd2: re_pass,
                    firstname: f_name,
                    lastname: l_name,
                    address: address,
                    address2: address_2,
                    phone: phone,
                    city: city,
                    country: country,
                    client: 1,
                    os_version: 'bb',
                    os_name: 'bb',
                    device_name: 'test'
                };
            }


            $.post(baseHost + 'api/users/signup?api_token=' + api_token, data, function(re) {
                if (typeof(re.data.access_token) != 'undefined') {
                    $.session("access_token", re.data.access_token);
                    console.log($.session('access_token'));
                }
                else {

                }
            }, 'json');
        }

    });
}

function sqlite_data() {
    var createStatement = "CREATE TABLE IF NOT EXISTS Contacts (id INTEGER PRIMARY KEY AUTOINCREMENT, firstName TEXT, lastName TEXT, phone TEXT)";
    var selectAllStatement = "SELECT * FROM Contacts";
    var insertStatement = "INSERT INTO Contacts (firstName, lastName, phone) VALUES (?, ?, ?)";
    var updateStatement = "UPDATE Contacts SET firstName = ?, lastName = ?, phone = ? WHERE id = ?";
    var deleteStatement = "DELETE FROM Contacts WHERE id=?";
    var dropStatement = "DROP TABLE Contacts";

}

function high_light_field(class_name) {

    $(class_name).css('border', '1px solid red');

}
function disable_high_light(class_name) {
    $(class_name).css('border', '1px solid #E0E2E2');
}

function getMonthName(m) {
    var month = new Array(12);

    month[1] = "Jan";
    month[2] = "Feb";
    month[3] = "Mar";
    month[4] = "Apr";
    month[5] = "May";
    month[6] = "Jun";
    month[7] = "Jul";
    month[8] = "Aug";
    month[9] = "Sep";
    month[10] = "Oct";
    month[11] = "Nov";
    month[12] = "Dec";

    return month[m];
}

function getURLParameters(paramName)
{
    var sURL = window.document.URL.toString();
    if (sURL.indexOf("?") > 0)
    {
        var arrParams = sURL.split("?");
        var arrURLParams = arrParams[1].split("&");
        var arrParamNames = new Array(arrURLParams.length);
        var arrParamValues = new Array(arrURLParams.length);
        var i = 0;
        for (i = 0; i < arrURLParams.length; i++)
        {
            var sParam = arrURLParams[i].split("=");
            arrParamNames[i] = sParam[0];
            if (sParam[1] != "")
                arrParamValues[i] = unescape(sParam[1]);
            else
                arrParamValues[i] = "No Value";
        }

        for (i = 0; i < arrURLParams.length; i++)
        {
            if (arrParamNames[i] == paramName) {
                //alert("Param:"+arrParamValues[i]);
                return arrParamValues[i];
            }
        }
        return "No Parameters Found";
    }

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




