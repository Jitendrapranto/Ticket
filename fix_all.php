<?php
$dir = new RecursiveDirectoryIterator('c:/xampp/htdocs/Ticket/app/Http/Controllers');
$iterator = new RecursiveIteratorIterator($dir);
foreach ($iterator as $file) {
    if ($file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $newContent = str_replace("if (ob_get_length()) ob_end_clean();", "while (ob_get_level() > 0) {\n            ob_end_clean();\n        }", $content);
        if ($newContent !== $content) {
            file_put_contents($file->getPathname(), $newContent);
            echo "Fixed " . $file->getPathname() . "\n";
        }
    }
}
