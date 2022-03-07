<?php

namespace App\Http\Controllers;

use App\Models\CrawlingJob;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function index(CrawlingJob $crawlingJob)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function create(CrawlingJob $crawlingJob)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CrawlingJob $crawlingJob)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(CrawlingJob $crawlingJob, Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(CrawlingJob $crawlingJob, Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CrawlingJob $crawlingJob, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(CrawlingJob $crawlingJob, Item $item)
    {
        //
    }
}
