<?php

use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect('/panel');
});


Route::get('/storrfage/{filename}', function ($filename) {
    $path = storage_path('app/public/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path, ['Content-Type' => mime_content_type($path)]);
});
// Route::get('storage/{path}/{filename}', function ($path,$filename) {
//     $path = storage_path('app/public/'.$path.'/' . $filename); // Correct path

//     if (!File::exists($path)) {
//         return response("File not found at: " . $path. basename($path), 404);
//     }

//     return Response::stream(function () use ($path) {
//         readfile($path);
//     }, 200, [
//         'Content-Type' => File::mimeType($path),
//         'Content-Disposition' => 'inline; filename="'.basename($path).'"'
//     ]);
// });

Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');