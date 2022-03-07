<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCrawlingJobRequest;
use App\Http\Requests\UpdateCrawlingJobRequest;
use App\Models\CrawlingJob;
use App\Services\CrawlingJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CrawlingJobController extends Controller
{
    protected $crawlingJobService;

    public function __construct(CrawlingJobService $svc)
    {    
        $this->crawlingJobService = $svc;
        // use policy
        $this->authorizeResource(CrawlingJob::class, 'job');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Gate::authorize('viewAny', CrawlingJob::class);
        
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
        // Gate::authorize('create', CrawlingJob::class);
        // let's create some shit?
        return Inertia::render(
            'CrawlingJobs/Create',
            [
                'title' => 'Create New Job'
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCrawlingJobRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCrawlingJobRequest $request)
    {
        // Gate::authorize('create', CrawlingJob::class);
        // use validated data only
        // dd($request->validated());
        // dd($request);
        $job = $this->crawlingJobService->store(
            $request->validated(),
            $request->user()
        );

        /* return back()->with([
            'message' => "Created Job '{$job->name}'",
            'messageType' => 'success'
        ]); */
        // redirect to list
        return Redirect::route('jobs.index')->with([
            'message' => "Created Job '{$job->name}'",
            'messageType' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function show(CrawlingJob $job)
    {
        // dd($job);
        // Gate::authorize('view', $job);

        return Inertia::render(
            'CrawlingJobs/View', [
                'title' => 'Job: ' . $job->name,
                'data' => $job
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function edit(CrawlingJob $job)
    {
        // edit job
        return Inertia::render(
            'CrawlingJobs/Edit', [
                'title' => 'Job: ' . $job->name,
                'data' => $job
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCrawlingJobRequest  $request
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCrawlingJobRequest $request, CrawlingJob $job)
    {
        // use validated data only
        // dd($request->validated());
        // dd($job);
        // $job->update($request->validated());
        $this->crawlingJobService->update(
            $job,
            $request->validated(),
            $request->user()
        );

        return Redirect::back()->with([
            'message' => 'Job Saved'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CrawlingJob  $crawlingJob
     * @return \Illuminate\Http\Response
     */
    public function destroy(CrawlingJob $job)
    {
        // delete item?
        $jobName = $job->name;
        // dd($job);
        $this->crawlingJobService->destroy($job);

        return back()->with([
            'message' => "Job [{$jobName}] was deleted",
            'messageType' => 'warning'
        ]);
    }

    public function status(CrawlingJob $job) {
        return response()->json($job->status);
    }
}
