<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views/admin');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
foreach($files as $file) {
    $content = file_get_contents($file[0]);

    if (strpos($content, '&#039;') !== false || strpos($content, '&gt;') !== false || strpos($content, '&amp;') !== false) {
        // Wait, htmlspecialchars_decode decodes these.
        // It might be risky if there are legit HTML entities, but inside x-data attribute value, it was HTML encoded.
        // Actually, the problem is ONLY in the x-data attribute on the first <div>!
        
        $lines = explode("\n", $content);
        $inDiv = false;
        $decodedLines = [];
        $changed = false;
        
        foreach($lines as $i => $line) {
            if (strpos($line, '&#039;') !== false || strpos($line, '&gt;') !== false || strpos($line, '&amp;') !== false) {
                 if ($i < 20) {
                     $lines[$i] = htmlspecialchars_decode($line, ENT_QUOTES);
                     $changed = true;
                 }
            }
        }
        
        if ($changed) {
            file_put_contents($file[0], implode("\n", $lines));
            $count++;
            echo "Fixed: " . $file[0] . "\n";
        }
    }
}
echo "Total fixed: $count files.\n";
