var baseHost = 'http://localhost/eticket/';
var api_token = "4d50a7f525245db890218329b518f0edc0d7f8f7";



$(document).ready(function() {

    initMenus();
});

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




