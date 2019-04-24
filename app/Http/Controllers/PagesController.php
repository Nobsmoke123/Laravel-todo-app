<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function new()
    {
        return view("new");
    }
}