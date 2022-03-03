<?php

namespace App\Services;

use App\Models\CrawlingJob;
use App\Models\SSO\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class CrawlingJobService {
    
    // query builder
    protected function buildQuery(string $q = null, string $from = null, string $to = null, User $user = null, bool $scoped = false): Builder {
        // show some shiet?
        return CrawlingJob::with('user:id,username,nama')
                ->when($q, function ($qWild) use ($q) {
                    $qWild->byWildcard($q);
                })
                ->when($scoped && $user, function ($qUser) use ($user) {
                    $qUser->byUserId($user->id);
                })
                ->when($from, function ($qFrom) use ($from) {
                    $qFrom->whereDate('created_at', '>=', $from);
                })
                ->when($to, function ($qTo) use ($to) {
                    $qTo->whereDate('created_at', '<=', $to);
                })
                ->orderBy('updated_at', 'DESC');

        /* // paginator + url?
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
        }); */
    }

    protected function paginateResult(Builder $query, int $perPage = 10) {
        $paginator = $query->paginate($perPage)->withQueryString();

        return $paginator;
    }

    protected function addAuthFields(Collection $result, User $user) {
        $result->map(function ($item) use ($user) {
            $item->can = [
                'view' => $user->can('view', $item),
                'edit' => $user->can('update', $item),
                'delete' => $user->can('delete', $item)
            ];
            return $item;
        });
    }

    public function queryJobs(string $q = null, string $from = null, string $to = null, User $user = null, bool $scoped = false, int $perPage = 10) {
        // get query
        $q = $this->buildQuery($q, $from, $to, $user, $scoped);
        // paginate
        $p = $this->paginateResult($q, $perPage);
        $this->addAuthFields($p->getCollection(), $user);

        return $p;
    }

    public function store(array $attributes, User $author): ?CrawlingJob {
        return CrawlingJob::create(
            [ 'user_id' => $author->id ] + $attributes
        );
    }

    public function update(CrawlingJob $job, array $attributes, User $author) {
        return $job->update($attributes);
    }

    public function destroy(CrawlingJob $job) {
        return $job->delete();
    }
}
