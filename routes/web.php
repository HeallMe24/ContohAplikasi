<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/quests', [QuestController::class, 'index'])->name('quests.index');
Route::post('/quests', [QuestController::class, 'store'])->name('quests.store');
Route::put('/quests/{quest}', [QuestController::class, 'update'])->name('quests.update');
Route::patch('/quests/{questId}/updateStatus', [QuestController::class, 'updateStatus']);
Route::delete('/quests/{quest}', [QuestController::class, 'destroy'])->name('quests.destroy');
