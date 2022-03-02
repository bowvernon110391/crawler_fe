<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCrawlingJobRequest;
use App\Http\Requests\UpdateCrawlingJobRequest;
use App\Models\CrawlingJob;
use App\Services\CrawlingJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CrawlingJobController extends Controller
{
    protected $crawlingJobService;

    public function __construct(CrawlingJobService $svc)
    {    
        $this->crawlingJobService = $svc;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // grab auth
        $user = $request->user();

        // url query
        $q = $request->input('q');
        $page = $request->input('page', 1);
        $number = $request->input('number', 10);
        $from = $request->input('from');
        $to = $request->input('to');

        // admin mode?
        $admin_mode = $user->hasRole('administrator');
        $scoped = $request->input('scoped') == 'true' || !$admin_mode;

        $result = $this->crawlingJobService->queryJobs($q, $from, $to, $user, $scoped, $number);

        // dd($request->all());

        return Inertia::render(
            'CrawlingJobs/Index',
            [
                'title' => 'Crawling Jobs',
                'data' => $result,

                'filter' => [ 
                    'q' => $q,
                    'from' => $from,
                    'to' => $to,
                    'scoped' => $scoped
                ],

                'adminMode' => $admin_mode
            ]
        );
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
     * @param  \App\Http\Requests\StoreCrawlingJobRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCrawlingJobRequest $request)
    {
        // use validated data only
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function show(CrawlingJob $crawlingJob)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function edit(CrawlingJob $crawlingJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCrawlingJobRequest  $request
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCrawlingJobRequest $request, CrawlingJob $crawlingJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(CrawlingJob $crawlingJob)
    {
        //
    }
}
