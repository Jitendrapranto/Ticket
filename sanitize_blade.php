<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views/admin');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
foreach($files as $file) {
    if (strpos($file[0], 'dashboard.blade.php') !== false) continue;
    
    $content = file_get_contents($file[0]);

    if (strpos($content, "@extends('admin.dashboard')") !== false) {
        // Look for the specific corruption:
        // <div x-data="{...}">
        // [REMNANT]
        // [Closing tag]
        
        // Let's find the first <div x-data="{...}"> and everything immediately after that looks like duplicate code.
        // The most reliable way is to find two occurrences of "}"> within the first 1000 characters.
        
        $lines = explode("\n", $content);
        $foundFirstClose = -1;
        $foundSecondClose = -1;
        
        for ($i = 0; $i < count($lines); $i++) {
             if ($i > 20) break; // It's always at the top
             if (strpos($lines[$i], '}">') !== false || strpos($lines[$i], '}"') !== false) {
                 if ($foundFirstClose === -1) {
                     $foundFirstClose = $i;
                 } else {
                     $foundSecondClose = $i;
                     break;
                 }
             }
        }
        
        if ($foundFirstClose !== -1 && $foundSecondClose !== -1) {
            // We have a duplicate block between foundFirstClose and foundSecondClose
            // But wait, we want to keep the FIRST one and remove what's between them.
            // Actually, the corruption is usually the FIRST block being okay and the SECOND being a partial mess.
            
            $newLines = [];
            for ($i = 0; $i < count($lines); $i++) {
                if ($i > $foundFirstClose && $i <= $foundSecondClose) {
                    continue; // Skip the remnant
                }
                $newLines[] = $lines[$i];
            }
            
            file_put_contents($file[0], implode("\n", $newLines));
            echo "Sanitized: " . $file[0] . "\n";
            $count++;
        }
    }
}
echo "Total sanitized: $count files.\n";
