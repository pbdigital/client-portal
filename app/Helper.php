<?php
namespace App;

class Helper
{
    
    public static function debug($d){
        echo "<pre>";
            print_r($d);
        echo "</pre>";
    }

    public static function prettyfy_datestamp($date){
        $sms_time_labels = array( 
            ["y"=> ["year","years"] ], 
            ["m"=> ["month","months"] ],
            ["d"=> ["day","days"] ],
            ["h"=> ["hour", "hours"] ],
            ["i"=> ["min","mins"] ]
        );


        $date1 = date_create(date("Y-m-d H:i:s"));
        $date2 = date_create( date("Y-m-d H:i:s",strtotime($date) ) );
        $diff  = date_diff($date1,$date2);

        $datetime_value  = "";

        foreach($sms_time_labels as $arr):
            foreach($arr as $field=>$val):
                
                if(empty($datetime_value)):
                    if(!empty($diff->$field )): 
                        $datetime_value = $diff->$field." ".$val[1];
                    endif;
                endif;
            endforeach;
        endforeach;

        if(empty($datetime_value)) $datetime_value  = " few moments";
        

        echo $datetime_value;
        
    }
}