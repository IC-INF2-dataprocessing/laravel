<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class DataController extends Controller {
    abstract function store(Request $request);
    abstract function show($id);
    abstract function update(Request $request, $id);
    abstract function destroy($id);
}
