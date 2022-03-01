<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCrawlingJobRequest;
use App\Http\Requests\UpdateCrawlingJobRequest;
use App\Models\CrawlingJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CrawlingJobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // url query
        $q = $request->input('q');
        $page = $request->input('page', 1);
        $number = $request->input('number', 10);

        // admin mode?
        $admin_mode = $user->hasRole('administrator');
        $scoped = $request->input('scoped') == 'true';

        // show some shiet?
        $query = CrawlingJob::with('user:id,username,nama')
                ->when($q, function ($qWild) use ($q) {
                    $qWild->byWildcard($q);
                })
                ->when(!$admin_mode || $scoped, function ($qUser) use ($user) {
                    $qUser->byUserId($user->id);
                })
                ->orderBy('updated_at', 'DESC');

        // paginator + url?
        $paginator = $query
            ->paginate($number)
            ->withQueryString();

        // append some data for auth check on frontend
        $paginator->map(function ($item) use ($user) {
            $item->can = [
                'view' => $user->can('view', $item),
                'edit' => $user->can('update', $item),
                'delete' => $user->can('delete', $item)
            ];
            return $item;
        });

        // dd($request->all());

        return Inertia::render(
            'CrawlingJobs/Index',
            [
                'title' => 'Crawling Jobs',
                'data' => $paginator,

                'filter' => [ 
                    'q' => $q 
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
        //
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
