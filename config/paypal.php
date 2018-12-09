<?php
return array(
    /** set your paypal credential **/
    'client_id' =>'AbGdhlW-tIlILJm4hn5djW91fJoC5x1cihipD_I87Fnsj876nBWHNkNUYZ1_FSqBgVA3RkFwP9ZQA56K',
    'secret' => 'ECpbQMkEtrCXbqjbOb2r2uLc7Aoa9cbK9_5_mR4I6ALkrUWcTErRwQJNnDF40eUnN_VXTUQOOa-rIJA8',
    /**
    * SDK configuration
    */
    'settings' => array(
        /**
        * Available option 'sandbox' or 'live'
        */
        'mode' => 'sandbox',
        /**
        * Specify the max request time in seconds
        */
        'http.ConnectionTimeOut' => 1000,
        /**
        * Whether want to log to a file
        */
        'log.LogEnabled' => true,
        /**
        * Specify the file that want to write on
        */
        'log.FileName' => storage_path() . '/logs/paypal.log',
        /**
        * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
        *
        * Logging is most verbose in the 'FINE' level and decreases as you
        * proceed towards ERROR
        */
        'log.LogLevel' => 'FINE'
    ),
);
