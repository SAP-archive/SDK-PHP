<?php
$data = array ('foo' => 'bar', 'bar' => 'baz');
$data = http_build_query($data);

$context_options = array (
        'http' => array (
            'method' => 'POST',
            'header'=> "Content-type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: " . strlen($data) . "\r\n",
            'content' => $data
            )
        );

$context = context_create_stream($context_options);
$fp = fopen('https://url', 'r', false, $context);
?>
