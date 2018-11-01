<?php

//$pattern = "/ab(c)/";
echo dirname(__DIR__."\n");

function foobar($agr1,$arg2){
    echo __FUNCTION__." got $arg1 and $arg2";
}

foobar("one","two");