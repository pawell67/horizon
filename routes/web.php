<?php

use Illuminate\Support\Facades\Route;
use Laravel\Horizon\Http\Middleware\AuthorizeActions;

Route::prefix('api')->group(function () {
    // Dashboard Routes...
    Route::get('/stats', 'DashboardStatsController@index')->name('horizon.stats.index');

    // Workload Routes...
    Route::get('/workload', 'WorkloadController@index')->name('horizon.workload.index');

    // Master Supervisor Routes...
    Route::get('/masters', 'MasterSupervisorController@index')->name('horizon.masters.index');

    // Monitoring Routes...
    Route::get('/monitoring', 'MonitoringController@index')->name('horizon.monitoring.index');
    Route::post('/monitoring', 'MonitoringController@store')->name('horizon.monitoring.store')
        ->middleware(AuthorizeActions::class);
    Route::get('/monitoring/{tag}', 'MonitoringController@paginate')->name('horizon.monitoring-tag.paginate');
    Route::delete('/monitoring/{tag}', 'MonitoringController@destroy')
        ->name('horizon.monitoring-tag.destroy')
        ->where('tag', '.*')
        ->middleware(AuthorizeActions::class);

    // Job Metric Routes...
    Route::get('/metrics/jobs', 'JobMetricsController@index')->name('horizon.jobs-metrics.index');
    Route::get('/metrics/jobs/{id}', 'JobMetricsController@show')->name('horizon.jobs-metrics.show');

    // Queue Metric Routes...
    Route::get('/metrics/queues', 'QueueMetricsController@index')->name('horizon.queues-metrics.index');
    Route::get('/metrics/queues/{id}', 'QueueMetricsController@show')->name('horizon.queues-metrics.show');

    // Queue Routes...
    Route::post('/queues/pause', 'QueuesController@pause')->name('horizon.queues.pause')
        ->middleware(AuthorizeActions::class);
    Route::post('/queues/resume', 'QueuesController@resume')->name('horizon.queues.resume')
        ->middleware(AuthorizeActions::class);

    // Unique Lock Routes...
    Route::get('/unique-locks', 'UniqueLocksController@index')->name('horizon.unique-locks.index');
    Route::delete('/unique-locks', 'UniqueLocksController@destroy')->name('horizon.unique-locks.destroy')
        ->middleware(AuthorizeActions::class);

    // Batches Routes...
    Route::get('/batches', 'BatchesController@index')->name('horizon.jobs-batches.index');
    Route::get('/batches/{id}', 'BatchesController@show')->name('horizon.jobs-batches.show');
    Route::post('/batches/retry/{id}', 'BatchesController@retry')->name('horizon.jobs-batches.retry')
        ->middleware(AuthorizeActions::class);

    // Job Routes...
    Route::get('/jobs/pending', 'PendingJobsController@index')->name('horizon.pending-jobs.index');
    Route::delete('/jobs/pending/{id}', 'PendingJobsController@destroy')->name('horizon.pending-jobs.destroy')
        ->middleware(AuthorizeActions::class);
    Route::post('/jobs/pending/{id}/run', 'PendingJobsController@run')->name('horizon.pending-jobs.run')
        ->middleware(AuthorizeActions::class);
    Route::get('/jobs/completed', 'CompletedJobsController@index')->name('horizon.completed-jobs.index');
    Route::get('/jobs/silenced', 'SilencedJobsController@index')->name('horizon.silenced-jobs.index');
    Route::get('/jobs/failed', 'FailedJobsController@index')->name('horizon.failed-jobs.index');
    Route::get('/jobs/failed/{id}', 'FailedJobsController@show')->name('horizon.failed-jobs.show');
    Route::delete('/jobs/failed', 'FailedJobsController@destroy')->name('horizon.failed-jobs.destroy')
        ->middleware(AuthorizeActions::class);
    Route::post('/jobs/retry', 'RetryController@storeMany')->name('horizon.retry-jobs.store-many')
        ->middleware(AuthorizeActions::class);
    Route::post('/jobs/retry/{id}', 'RetryController@store')->name('horizon.retry-jobs.show')
        ->middleware(AuthorizeActions::class);
    Route::get('/jobs/{id}', 'JobsController@show')->name('horizon.jobs.show');
});

// Catch-all Route...
Route::get('/{view?}', 'HomeController@index')->where('view', '(.*)')->name('horizon.index');
