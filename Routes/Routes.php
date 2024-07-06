<?php

//Router::get('/h',function(){new View('views/loadingPage.html',["name"=>"pasindu"]);});

Router::get('/performance', [ViewsController::class, 'performanceForm']);

Router::get('/performance/reports', [ViewsController::class, 'performanceReport']);

Router::post('/performance', [PerformanceController::class, "createRecord"]);

Router::get('/performance/reports/data', [PerformanceController::class, "getRecord"]);

Router::get('/performance/reports/download', [PerformanceController::class, 'downloadReport']);
