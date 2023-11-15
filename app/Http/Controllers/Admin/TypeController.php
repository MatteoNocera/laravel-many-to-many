<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::orderByDesc('id')->paginate(10);

        return view('admin.types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Type $type)
    {


        return view('admin.types.create', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        $val_data = $request->validated();

        $val_data['slug'] = Type::generateSlug($val_data['name'], '-');

        Type::create($val_data);

        return to_route('types.index')->with('message', 'Type creation succesfully ✅');
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {

        return view('admin.types.show', ['type' => $type]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('admin.types.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $val_data = $request->validated();

        if (!Str::is($type->getOriginal('name'), $request->name)) {
            $val_data['slug'] = $type->generateSlug($request->name);
        }

        $type->update($val_data);

        return to_route('types.index', $type)->with('message', 'Update succesfully ✅');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();

        return to_route('types.index')->with('message', 'Delete succesfully ✅');
    }
}
