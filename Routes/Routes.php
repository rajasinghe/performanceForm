<?php

//Router::get('/h',function(){new View('views/loadingPage.html',["name"=>"pasindu"]);});

Router::get('/performance', [ViewsController::class, 'performanceForm']);

Router::post('/performance', [PerformanceController::class, "createRecord"]);
