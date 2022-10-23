<?php

namespace App\Http\Controllers\Api;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PurposeResource;
use App\Http\Resources\PurposeCollection;

class ColorPurposesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Color $color
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Color $color)
    {
        $this->authorize('view', $color);

        $search = $request->get('search', '');

        $purposes = $color
            ->purposes()
            ->search($search)
            ->latest()
            ->paginate();

        return new PurposeCollection($purposes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Color $color
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Color $color)
    {
        $this->authorize('create', Purpose::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'code' => ['nullable', 'max:255'],
        ]);

        $purpose = $color->purposes()->create($validated);

        return new PurposeResource($purpose);
    }
}
