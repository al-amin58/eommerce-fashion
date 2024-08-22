<?php

namespace App\Http\Controllers;

use App\Models\OrderArea;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;

class OrderAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        return inertia("Area/Index",[
            'arias' => OrderArea::query()
                ->when(Request::input('search'), function ($query, $search) {
                    $query->where('area_name', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate(Request::input('perPage') ?? 10)
                ->withQueryString()
                ->through(fn($area) => [
                    'id' => $area->id,
                    'area_name' => $area->area_name,
                    'area_code' => $area->area_code,
                    'delivery_charge' => $area->delivery_charge,
                    'charge_condition' => $area->charge_condition,
                    'charge_condition_price' => $area->charge_condition_price,
                    'created_at' => $area->created_at,
                    "edit_url" => URL::route('admin.pages.edit', $area->id)
                ]),
            'filters' => Request::only(['search','perPage', 'dateRange']),
            'main_url' => URL::route('admin.order-area.index')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = Request::validate([
            'area_name' => 'required',
            'area_code' => 'required',
            'delivery_charge' => 'required',
            'charge_condition' => 'nullable',
            'charge_condition_price' =>  'nullable'
        ]);
        OrderArea::create($data);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OrderArea  $orderArea
     * @return \Illuminate\Http\Response
     */
    public function show(OrderArea $orderArea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OrderArea  $orderArea
     * @return \Illuminate\Http\Response
     */
    public function edit(OrderArea $orderArea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OrderArea  $orderArea
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrderArea $orderArea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OrderArea  $orderArea
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(OrderArea $orderArea)
    {
        $orderArea->delete();
        return back();
    }
}
