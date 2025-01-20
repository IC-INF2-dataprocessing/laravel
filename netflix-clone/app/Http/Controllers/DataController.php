<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class DataController extends Controller {
    abstract function index(): Response;
    abstract function store(Request $request): Response;
    abstract function show($id): Response;
    abstract function update(Request $request, $id): Response;
    abstract function destroy($id): Response;
}
