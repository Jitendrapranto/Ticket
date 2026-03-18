<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views/admin');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

$count = 0;
foreach($files as $file) {
    $content = file_get_contents($file[0]);

    // Check if it was modified by our refactor script
    if (strpos($content, "@extends('admin.dashboard')") !== false) {
        $lines = explode("\n", $content);
        
        $newLines = [];
        $i = 0;
        $inBrokenDiv = false;
        $fixed = false;

        while ($i < count($lines)) {
            $line = $lines[$i];
            
            // Wait, let's just use string replacement if we can identify the exact broken pattern.
            // The broken pattern is `<div x-data="` or `<div x-data='`
            // and it ends with `}">`.
            // IMMEDIATELY followed by something that ALSO ends with `}">`.
            
            $i++;
        }
                
        // Alternative: Use regex to find duplicate text
        // The issue is: <div x-data="{A}">B}">
        // Let's find `<div x-data="([^"]*)">`
        // Wait, because there are line breaks, it's spanning multiple lines.
        
        // This regex will capture: 
        // 1. <div x-data="{ (everything up to first }">)
        // 2. The duplicate text that ends with ">\n
        if (preg_match('/(<div\s+x-data=[\'"]?\{[^>]+\}[\'"]?>)(.*?\}\s*[\'"]?>)(\s*<div\s+class="animate-fadeIn">|\s*<!--|\s*<header)/is', $content, $matches)) {
            // $matches[1] = <div x-data="{...}">
            // $matches[2] = badge_text) }}', ... }">
            // $matches[3] = \n    <div class="animate-fadeIn">
            
            // We want to remove $matches[2]
            $fixedContent = str_replace($matches[0], $matches[1] . $matches[3], $content);
            file_put_contents($file[0], $fixedContent);
            echo "Fixed broken x-data remnent in: " . $file[0] . "\n";
            $count++;
        }
    }
}
echo "Total fixed: $count files.\n";
