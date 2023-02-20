<?php

    // Transform string of Y-m-d H:i:s to integer timestamp
    function date_to_timestamp($date) {
        $timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $date);
        $timestamp = $timestamp->getTimestamp()*1000;
        return $timestamp;
    }

    // Transform integer timestamp to string of Y-m-d H:i:s
    function timestamp_to_date($timestamp){
        $timestamp = $timestamp / 1000;
        $date = date( "Y-m-d H:i:s", $timestamp);
        return $date;
    }

?>