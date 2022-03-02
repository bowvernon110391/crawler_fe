<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as Trail;

// home
Breadcrumbs::for('home', function(Trail $trail) {
    $trail->push('Home', route('home'), [
        'icon' => 'home'
    ]);
});

// home > browse jobs
Breadcrumbs::for('jobs.index', function(Trail $trail) {
    $trail->parent('home');
    $trail->push('Browse Jobs', route('jobs.index'), [
        'icon' => 'browse'
    ]);
});

// home > browse jobs > view job
Breadcrumbs::for('jobs.create', function(Trail $trail) {
    $trail->parent('jobs.index');
    $trail->push('Create New Job', route('jobs.create'), [
        'icon' => 'pencil'
    ]);
});

// home > browse jobs > view job
Breadcrumbs::for('jobs.show', function(Trail $trail, $params) {
    $trail->parent('jobs.index');
    $trail->push('View Job', route('jobs.show', $params), [
        'icon' => 'eye'
    ]);
});

