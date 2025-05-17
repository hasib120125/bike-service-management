<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Service::with('parts')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'chassis_number' => 'required',
            'km_run' => 'required',
            'bay_number' => 'required',
            'service_charge' => 'required',
            'service_type' => 'nullable',
            'service_time' => 'nullable',
            'image' => 'nullable|max:2048',
            'parts' => 'array',
            'parts.*' => 'integer|exists:parts,id',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        $service = Service::create($validated);

        if (!empty($validated['parts'])) {
            $service->parts()->sync($validated['parts']);
        }

        return $service;
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return $service;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'chassis_number' => 'nullable',
            'km_run' => 'nullable',
            'bay_number' => 'nullable',
            'service_charge' => 'nullable',
            'service_type' => 'nullable',
            'service_time' => 'nullable',
            'parts' => 'array',
            'parts.*' => 'integer|exists:parts,id',
        ]);

        $service->update($validated);

        if (isset($validated['parts'])) {
            $service->parts()->sync($validated['parts']);
        }

        return $service;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function partsDiscount()
    {
        $parts = DB::table('parts')->get();
        $total_price = $parts->sum('retail_price');
        $total_discount = 100;

        $partsWithDiscount = $parts->map(function ($part) use ($total_price, $total_discount) {
            $discount_amount = $total_price > 0 ? round(($part->retail_price / $total_price) * $total_discount, 2) : 0;
            $final_price = $part->retail_price - $discount_amount;
            $discount_percentage = $part->retail_price > 0 ? round(($discount_amount / $part->retail_price) * 100, 2) : 0;
            return [
                'code' => $part->code,
                'retail_price' => $part->retail_price,
                'discount_amount' => $discount_amount,
                'final_price' => $final_price,
                'discount_percentage' => $discount_percentage,
            ];
        });

        return response()->json([
            'parts' => $partsWithDiscount,
            'total_price' => $total_price,
            'total_discount' => $total_discount,
        ]);
    }

    public function getParts()
    {
        $parts = DB::table('parts')->get();
        return response()->json($parts);
    }
}
