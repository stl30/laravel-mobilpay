<?php

header('Content-type: application/xml');
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
if($errorCode == 0)
{
    echo "<crc>{$errorMessage}</crc>";
}
else
{
    echo "<crc error_type=\"{$errorType}\" error_code=\"{$errorCode}\">{$errorMessage}</crc>";
}
