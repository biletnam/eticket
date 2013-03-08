<?php

class DateTimeFormat {
    /*
     * Takes a unix timestamp and returns a relative time string such as "3 minutes ago",
     *   "2 months from now", "1 year ago", etc
     * The detailLevel parameter indicates the amount of detail. The examples above are
     * with detail level 1. With detail level 2, the output might be like "3 minutes 20
     *   seconds ago", "2 years 1 month from now", etc.
     * With detail level 3, the output might be like "5 hours 3 minutes 20 seconds ago",
     *   "2 years 1 month 2 weeks from now", etc.
     */

    public static function nicetime($timestamp, $detailLevel = 1) {

        //$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        //$lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        $periods = array("giây", "phút", "tiếng", "ngày", "tuần", "tháng", "năm", "thập kỉ");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        
        $now = time();

        // check validity of date
        if (empty($timestamp)) {
            return "Unknown time";
        }

        // is it future date or past date
        if ($now > $timestamp) {
            $difference = $now - $timestamp;
            $tense = "trước";
        } else {
            $difference = $timestamp - $now;
            $tense = "from now";
        }

        if ($difference == 0) {
            return "1 giây trước";
        }

        $remainders = array();

        for ($j = 0; $j < count($lengths); $j++) {
            $remainders[$j] = floor(fmod($difference, $lengths[$j]));
            $difference = floor($difference / $lengths[$j]);
        }

        $difference = round($difference);

        $remainders[] = $difference;

        $string = "";

        for ($i = count($remainders) - 1; $i >= 0; $i--) {
            if ($remainders[$i]) {
                $string .= $remainders[$i] . " " . $periods[$i];

                /*
                if ($remainders[$i] != 1) {
                    $string .= "s";
                }*/

                $string .= " ";

                $detailLevel--;

                if ($detailLevel <= 0) {
                    break;
                }
            }
        }

        return $string . $tense;
    }
    
    public static function remaining_time($end_time)
    {
       
        $remaining = $end_time - time();
        if($remaining < 0)
            return "Unknow time";
        $day =0;$hour=0;$minute=0;$second=0;
        
        $day = floor($remaining/86400);
        
        $remaining = $remaining%86400;
        
        $hour = floor($remaining/3600);        
        if($hour < 10)
            $hour = "0".$hour;
        $remaining = $remaining%3600;
        
        $minute = floor($remaining/60);
        if($minute < 10)
            $minute = "0".$minute;
        $remaining = $remaining%60;
        
        $second = floor($remaining);
        if($second < 10)
            $second = "0".$second;
        
        return $day." ngày ".$hour.":".$minute.":".$second;
    }

}
