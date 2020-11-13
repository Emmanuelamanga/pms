<?php

use Illuminate\Support\Facades\Route;
use App\Models\Project;
// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('project', App\Http\Controllers\ProjectController::class);
Route::resource('contact', App\Http\Controllers\ContactController::class);
Route::get('/project/assign/{id}', function ($id) {
    Project::where('id', $id)->update([
        'assigned' => Auth::user()->id
    ]);

    return true;
});
Route::get('/project/myProject/{id}', function($id){
    $myProjects =  Project::where('assigned', $id)->get();
        if (!empty($myProjects)) {
            return view('project.myProjects', ['projects'=>$myProjects]);
        }else{

            return 'alert("No Projects assigned to you")';
        }

})->name('myProject');
Route::post('/project/status/{id}', function ($id) {
    Project::where('id', $id)->update([
        'status' => \request()->status
    ]);
    return true;
});
