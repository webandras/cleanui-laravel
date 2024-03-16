<?php

namespace App\Http\Controllers\Admin\Clean;

use App\Http\Controllers\Controller;

class FileManagerController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        return view('admin.pages.filemanager.filemanager');
    }
}
