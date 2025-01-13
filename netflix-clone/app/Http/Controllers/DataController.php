<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class DataController extends Controller {
    abstract function index();
    abstract function show($id);
    abstract function store();
    abstract function update(Request $request, $id);
    abstract function destroy($id);
}
