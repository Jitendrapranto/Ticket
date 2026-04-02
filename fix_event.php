<?php
$file = 'c:/xampp/htdocs/Ticket/app/Http/Controllers/Admin/EventController.php';
$content = file_get_contents($file);
$repl = <<<'EOD'
$fileContent = file_get_contents($tmpFile);
        @unlink($tmpFile);
        
        while (ob_get_level() > 0) {
            ob_end_clean();
        }
        
        return response($fileContent, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ]);
EOD;
$content = preg_replace('/return response\(\)->download.*?deleteFileAfterSend\(true\);/s', $repl, $content);
file_put_contents($file, $content);
echo "Fixed EventController.php\n";
