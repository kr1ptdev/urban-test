<?php

namespace App\Http\Controllers;

use App\Models\DomObject;
use Inertia\Inertia;

final class DomObjectController extends Controller
{
    public function index(): \Inertia\Response
    {
        $objects = DomObject::orderBy('dom_id', 'desc')->get();

        return Inertia::render('DomObjects/Index', [
            'objects' => $objects,
        ]);
    }
}