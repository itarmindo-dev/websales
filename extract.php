<?php
$logPath = 'C:\\Users\\aplap\\.gemini\\antigravity-ide\\brain\\b2984082-f28e-472e-ac4d-77d86579f60f\\.system_generated\\logs\\transcript_full.jsonl';
$lines = file($logPath);
$found = "";
foreach($lines as $line) {
    if(strpos($line, '"File Path: `file:///c:/xampp/htdocs/LaravelProject/Sales/WebSales/resources/views/index.blade.php`') !== false) {
        $json = json_decode($line, true);
        if(isset($json['content']) && strpos($json['content'], "@extends('layouts.base')") !== false) {
            $found = $json['content'];
            break;
        }
    }
}
if($found) {
    file_put_contents('old_index.txt', $found);
    echo "Found and saved to old_index.txt\n";
} else {
    echo "Not found\n";
}
