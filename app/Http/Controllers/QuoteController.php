<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QuoteResource::collection(Quote::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuoteRequest $request)
    {
        return new QuoteResource(Quote::create($request->validated()));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $Quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $Quote)
    {
        return new QuoteResource($Quote);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $Quote
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuoteRequest $request, Quote $Quote)
    {
        // $Quote->update($request->validated());
        // return new QuoteResource($Quote);
        return new QuoteResource(tap($Quote)->update($request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $Quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $Quote)
    {
        $Quote->delete();
        return response()->json(null, 204);
    }
}
