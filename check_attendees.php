<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = App\Models\BookingAttendee::count();
echo "Total Attendees: $count\n";

$attendees = App\Models\BookingAttendee::select('id','booking_id','ticket_number','name','is_scanned')->get();
foreach ($attendees as $a) {
    echo "ID:{$a->id} | TKT:{$a->ticket_number} | Name:{$a->name} | Scanned:" . ($a->is_scanned ? 'Y' : 'N') . "\n";
}
