<?php

class Paginator {

    var $items_per_page;
    var $items_total;
    var $current_page;
    var $num_pages;
    var $mid_range;
    var $low;
    var $high;
    var $limit;
    var $return;
    var $default_ipp = 25;
    var $querystring;
    var $link_server;
    function Paginator() {
        $this->current_page = 1;
        $this->mid_range = 3;
        $this->items_per_page = $this->default_ipp;
    }

    function paginate() {
        if (isset($_GET['ipp']) && $_GET['ipp'] == 'All') {
            $this->num_pages = ceil($this->items_total / $this->default_ipp);
            $this->items_per_page = $this->default_ipp;
        } else {
            if (!is_numeric($this->items_per_page) OR $this->items_per_page <= 0)
                $this->items_per_page = $this->default_ipp;
            $this->num_pages = ceil($this->items_total / $this->items_per_page);
        }
        
        //echo $_GET['page']; die;
        //remove this comment if use method GET
        /*
        if (isset($_GET['page']) && $_GET['page']) {
            $this->current_page = intval($_GET['page']); // must be numeric > 0
        }else
            $this->current_page = 1;*/
        
        if ($this->current_page < 1 Or !is_numeric($this->current_page))
            $this->current_page = 1;
        if ($this->current_page > $this->num_pages)
            $this->current_page = $this->num_pages;
        $prev_page = $this->current_page - 1;
        $next_page = $this->current_page + 1;
        /*
        if ($_GET) {
            $args = explode("&", $_SERVER['QUERY_STRING']);
            foreach ($args as $arg) {
                $keyval = explode("=", $arg);
               // if ($keyval[0] != "page" And $keyval[0] != "ipp")
                  //  $this->querystring .= "&" . $arg;
            }
        }

        if ($_POST) {
            foreach ($_POST as $key => $val) {
                if ($key != "page" And $key != "ipp")
                    $this->querystring .= "&$key=$val";
            }
        }
        */
        
        if($_SERVER['QUERY_STRING'] != "")
            $this->querystring.= "?".$_SERVER['QUERY_STRING'];
        
        if ($this->num_pages > 1) {
            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<li><a class=\"paginate button-link gray\" href=\"$this->link_server"."$prev_page/$this->querystring\">&laquo; Previous</a></li> " : "<li class=\"disabled\"><a class=\"paginate button-link gray disabled\" href=\"#\">&laquo; Previous</a></li> ";

            $this->start_range = $this->current_page - floor($this->mid_range / 2);
            $this->end_range = $this->current_page + floor($this->mid_range / 2);

            if ($this->start_range <= 0) {
                $this->end_range += abs($this->start_range) + 1;
                $this->start_range = 1;
            }
            if ($this->end_range > $this->num_pages) {
                $this->start_range -= $this->end_range - $this->num_pages;
                $this->end_range = $this->num_pages;
            }
            $this->range = range($this->start_range, $this->end_range);

            for ($i = 1; $i <= $this->num_pages; $i++) {
                if ($this->range[0] > 2 And $i == $this->range[0])
                    //$this->return .= " ... ";
                    $this->return .= "<li class=\"disabled\"><a href=\"#\">...</a></li>";
                // loop through all pages. if first, last, or in range, display
                if ($i == 1 Or $i == $this->num_pages Or in_array($i, $this->range)) {
                    $this->return .= ($i == $this->current_page) ? "<li class=\"active\"><a title=\"Page $i of $this->num_pages\" class=\"button-link active_page\" href=\"#\">$i</a></li> " : "<li><a class=\"paginate button-link gray\" title=\"Go to page $i of $this->num_pages\" href=\"$this->link_server"."$i/$this->querystring\">$i</a> </li> ";
                }
                if ($this->range[$this->mid_range - 1] < $this->num_pages - 1 And $i == $this->range[$this->mid_range - 1])
                    //$this->return .= " ... ";
                    $this->return .= "<li class=\"disabled\"><a href=\"#\">...</a></li>";
            }
            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10)) ? "<li><a class=\"paginate button-link gray\" href=\"$this->link_server"."$next_page/$this->querystring\">Next &raquo;</a></li>\n" : "<li class=\"disabled\"><a class=\"paginate button-link gray disabled\" href=\"#\">Next &raquo;</a></li>\n";
            //$this->return .= ($_GET['page'] == 'All') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\">All</a> \n" : "<a class=\"paginate\" style=\"margin-left:10px\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a> \n";
            //$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_GET['page'] != 'All')) ? "<a class=\"paginate button-link gray\" href=\"".$this->link_server."b/comment/$next_page$this->querystring/\">Next &raquo;</a>\n" : "<li class=\"inactive button-link gray\" href=\"#\">&raquo; Next</li>\n";
        }
        else {
            for ($i = 1; $i <= $this->num_pages; $i++) {
                $this->return .= ($i == $this->current_page) ? "<li class=\"active\"><a class=\"active_page button-link\" href=\"$this->link_server"."$this->current_page/\">$i</a></li> " : "<li><a class=\"paginate button-link gray\" href=\"$this->link_server"."$i/$this->querystring\">$i</a></li> ";
            }
            //$this->return .= "<a class=\"paginate\" href=\"$_SERVER[PHP_SELF]?page=1&ipp=All$this->querystring\">All</a> \n";
        }
        $this->low = ($this->current_page - 1) * $this->items_per_page;
        @$this->high = ($_GET['ipp'] == 'All') ? $this->items_total : ($this->current_page * $this->items_per_page) - 1;
        @$this->limit = ($_GET['ipp'] == 'All') ? "" : " liMIT $this->low,$this->items_per_page";
    }

    function display_items_per_page() {
        $items = '';
        $ipp_array = array(10, 25, 50, 100, 'All');
        foreach ($ipp_array as $ipp_opt)
            $items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n" : "<option value=\"$ipp_opt\">$ipp_opt</option>\n";
        return "<li class=\"paginate\">Items per page:</li><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page=1&ipp='+this[this.selectedIndex].value+'$this->querystring';return false\">$items</select>\n";
    }

    function display_jump_menu() {
        for ($i = 1; $i <= $this->num_pages; $i++) {
            $option .= ($i == $this->current_page) ? "<option value=\"$i\" selected>$i</option>\n" : "<option value=\"$i\">$i</option>\n";
        }
        return "<li class=\"paginate\">Page:</li><select class=\"paginate\" onchange=\"window.location='$_SERVER[PHP_SELF]?page='+this[this.selectedIndex].value+'&ipp=$this->items_per_page$this->querystring';return false\">$option</select>\n";
    }

    function display_pages() {
        return $this->return;
    }

}