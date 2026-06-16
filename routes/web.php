<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/run-seed', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return 'Database seeded successfully! You can now log in.';
});
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [TestController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/test/{test}/start', [TestController::class, 'startTest'])->name('test.start');
    Route::get('/test/{attempt}/section/{section}', [TestController::class, 'showSection'])->name('test.section');
    Route::post('/test/save-answer', [TestController::class, 'saveAnswer'])->name('test.save-answer');
    Route::post('/test/save-writing', [TestController::class, 'saveWriting'])->name('test.save-writing');
    Route::post('/test/save-recording', [TestController::class, 'saveRecording'])->name('test.save-recording');
    Route::post('/test/clear-answer', [TestController::class, 'clearAnswer'])->name('test.clear-answer');
    Route::post('/test/{attempt}/section/{section}/submit', [TestController::class, 'submitSection'])->name('test.submit-section');
    Route::get('/test/{attempt}/complete', [TestController::class, 'complete'])->name('test.complete');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    Route::get('/tests', [AdminController::class, 'tests'])->name('admin.tests');
    Route::get('/tests/create', [AdminController::class, 'createTest'])->name('admin.tests.create');
    Route::post('/tests', [AdminController::class, 'storeTest'])->name('admin.tests.store');
    Route::get('/tests/{test}', [AdminController::class, 'showTest'])->name('admin.tests.show');
    Route::get('/tests/{test}/edit', [AdminController::class, 'editTest'])->name('admin.tests.edit');
    Route::put('/tests/{test}', [AdminController::class, 'updateTest'])->name('admin.tests.update');
    Route::delete('/tests/{test}', [AdminController::class, 'deleteTest'])->name('admin.tests.delete');
    Route::post('/tests/{test}/toggle', [AdminController::class, 'toggleTest'])->name('admin.tests.toggle');
    Route::get('/tests/{test}/sections/create', [AdminController::class, 'createSection'])->name('admin.sections.create');
    Route::post('/tests/{test}/sections', [AdminController::class, 'storeSection'])->name('admin.sections.store');
    Route::get('/tests/{test}/sections/{section}/edit', [AdminController::class, 'editSection'])->name('admin.sections.edit');
    Route::put('/tests/{test}/sections/{section}', [AdminController::class, 'updateSection'])->name('admin.sections.update');
    Route::delete('/tests/{test}/sections/{section}', [AdminController::class, 'deleteSection'])->name('admin.sections.delete');
    Route::get('/tests/{test}/sections/{section}/questions', [AdminController::class, 'manageQuestions'])->name('admin.questions.index');
    Route::get('/tests/{test}/sections/{section}/questions/create', [AdminController::class, 'createQuestion'])->name('admin.questions.create');
    Route::post('/tests/{test}/sections/{section}/questions', [AdminController::class, 'storeQuestion'])->name('admin.questions.store');
    Route::get('/tests/{test}/sections/{section}/questions/{question}/edit', [AdminController::class, 'editQuestion'])->name('admin.questions.edit');
    Route::put('/tests/{test}/sections/{section}/questions/{question}', [AdminController::class, 'updateQuestion'])->name('admin.questions.update');
    Route::delete('/tests/{test}/sections/{section}/questions/{question}', [AdminController::class, 'deleteQuestion'])->name('admin.questions.delete');
    Route::get('/tests/{test}/sections/{section}/questions/bulk', [AdminController::class, 'bulkImportForm'])->name('admin.questions.bulk');
    Route::post('/tests/{test}/sections/{section}/questions/bulk', [AdminController::class, 'bulkImport'])->name('admin.questions.bulk.import');
    Route::get('/results', [AdminController::class, 'results'])->name('admin.results');
    Route::get('/results/{attempt}', [AdminController::class, 'attemptDetail'])->name('admin.attempt');
    Route::post('/writing/{submission}/score', [AdminController::class, 'saveWritingScore'])->name('admin.writing.score');
    Route::post('/speaking/{recording}/score', [AdminController::class, 'saveSpeakingScore'])->name('admin.speaking.score');
});
