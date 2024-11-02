<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->type == 'admin') {
            $packages = Package::orderBy('created_at', 'desc')->get();
            return view('packages.index', [
                'packages' => $packages
            ]);
        } else {
            $packages = Package::orderBy('created_at', 'desc')->take(2)->get();
            return view('packages.show', [
                'packages' => $packages
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255|string',
            'description' => 'min:3|max:1025|string',
            'price' => 'required|numeric',
            'count_project' => 'required|numeric',

        ], [
            'required' => 'هذا الحقل مطلوب',
            'string' => 'هذا الحقل يجب ان يحتوي على نص',
            'max' => 'هذا الحقل طويل للفاية',
            'min' => 'هذا الحقل قصير للغاية',
            'numeric' => 'هذا الحقل يجب ان يكون رقم',

        ]);
        Package::create($request->all());
        return redirect()->route('package.index')->with('success', 'تم تخزين الباقة بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function checkout(Request $request)
    {
        $package = Package::findOrFail($request->package_id);

        return view('packages.checkout', ['package' => $package]);
    }
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $package = Package::findOrFail($id);
        return view('packages.edit', [
            'package' => $package,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {

        $request->validate([
            'name' => 'required|min:3|max:255|string',
            'description' => 'min:3|max:1025|string',
            'price' => 'required|numeric',
            'count_project' => 'required|numeric',

        ], [
            'required' => 'هذا الحقل مطلوب',
            'string' => 'هذا الحقل يجب ان يحتوي على نص',
            'max' => 'هذا الحقل طويل للفاية',
            'min' => 'هذا الحقل قصير للغاية',
            'numeric' => 'هذا الحقل يجب ان يكون رقم',

        ]);
        Package::where('id', $package->id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'count_project' => $request->count_project
        ]);
        return redirect()->route('package.index')->with('success', 'تم تعديل الباقة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $package = Package::findOrFail($id);
        $package->delete();
        return redirect(route('package.index'))
            ->with('delete', "تم حذف الباقة بنجاح");
    }
}
