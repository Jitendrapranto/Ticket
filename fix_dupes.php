<?php
$dir = new RecursiveDirectoryIterator('c:/xampp/htdocs/Ticket/app/Http/Controllers');
$iterator = new RecursiveIteratorIterator($dir);
foreach ($iterator as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $fixed = preg_replace('/(\s*while\s*\(\ob_get_level\(\)\s*>\s*0\)\s*\{\s*ob_end_clean\(\);\s*\})+/s', "\n        while (ob_get_level() > 0) {\n            ob_end_clean();\n        }", $content);
        if ($fixed !== $content) {
            file_put_contents($file->getPathname(), $fixed);
            echo "Fixed " . $file->getPathname() . "\n";
        }
    }
}
