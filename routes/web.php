<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [
    "uses" => "TodosController@index"
]);

/* Create Route */
Route::post('/add-task', [
    "uses" => "TodosController@save"
]);


/* Delete Route */
Route::get('/delete-task/{id}', [
    "uses" => "TodosController@delete",
    "as" => "delete-task"
]);

Route::post('/update-task', [
    "uses" => "TodosController@update",
    "as" => "update-task"
]);

Route::get('/filter/{filter}', [
    "uses" => "TodosController@filter",
    "as" => "filter-tasks"
]);

Route::get('/complete-task/{id}', [
    "uses" => "TodosController@completed",
    "as" => "complete-task"
]);