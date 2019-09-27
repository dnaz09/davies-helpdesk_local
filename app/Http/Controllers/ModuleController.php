<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
class ModuleController extends Controller
{
    public function index()
    {
    	$modules = Module::all();
    	return view('modules.index',compact('modules'));
    }

    public function details($id)
    {
    	$module = Module::findOrFail($id);

    	return view('modules.details',compact('module'));
    }

    public function edit(Request $request)
    {
    	$module = Module::findOrFail($request->module_id);
    	$module->module = $request->module;
        $module->description = $request->description;
    	$module->department = $request->department;
    	$module->routeUri = $request->routeUri;
    	$module->default_url = $request->default_url;
    	$module->icon = $request->icon;
    	$module->update();

    	return redirect()->back()->with('is_success', 'Edited');
    }

    public function list()
    {
        $modules = Module::all();
        return view('modules.list',compact('modules'));
    }

    public function show($id)
    {
        $module = Module::findOrFail($id);

        return view('modules.detail',compact('module'));
    }

    public function update(Request $request)
    {
        $module = Module::findOrFail($request->module_id);
        $module->module = $request->module;
        $module->description = $request->description;
        $module->icon = $request->icon;
        $module->update();

        return redirect()->back()->with('is_success', 'Edited');
    }
}
