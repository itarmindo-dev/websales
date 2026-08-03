<?php
$logPath = 'C:\\Users\\aplap\\.gemini\\antigravity-ide\\brain\\b2984082-f28e-472e-ac4d-77d86579f60f\\.system_generated\\logs\\transcript_full.jsonl';
$lines = file($logPath);
foreach($lines as $line) {
    if(strpos($line, '"AbsolutePath":"\"c:\\\\\\\\xampp\\\\\\\\htdocs\\\\\\\\LaravelProject\\\\\\\\Sales\\\\\\\\WebSales\\\\\\\\resources\\\\\\\\views\\\\\\\\index.blade.php\""') !== false) {
        $json = json_decode($line, true);
        echo "Found tool call for index.blade.php\n";
    }
    if (strpos($line, 'file:///c:/xampp/htdocs/LaravelProject/Sales/WebSales/resources/views/index.blade.php') !== false) {
        $json = json_decode($line, true);
        if(isset($json['content'])) {
            $c = $json['content'];
            if(strlen($c) > 1000) {
                file_put_contents('old_index_part.txt', $c, FILE_APPEND);
            }
        }
    }
}
