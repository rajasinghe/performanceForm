<?php

/*
@method GET
performance form page 
eg:-
http://localhost:3000/performance
*/
Router::get('/performance', [ViewsController::class, 'performanceForm']);

/*
@method GET
performance report page 
eg:-
http://localhost:3000/performance/reports
*/
Router::get('/performance/reports', [ViewsController::class, 'performanceReport']);

/*
@method POST
creating a performance record 
used in the performance form
eg:-
http://localhost:3000/performance
expected json payload -
    {
    "year": "2018",
    "month": "february",
    "courseName": "test data test",
    "cost": "2500",
    "startDate": "07/12/2024",
    "endDate": "08/12/2024",
    "noParticipantSLPA": "12",
    "noParticipantOutside": "22",
    "trainingManHrs": "29",
    "TrainingWhether": "onGoing",
    "totalAmount": "67"
}
*/
Router::post('/performance', [PerformanceController::class, "createRecord"]);

/*
@method GET
to get the data for the report page for showing the reports
eg:-
http://localhost:3000/performance/reports/data?year=2024&month=6
*/
Router::get('/performance/reports/data', [PerformanceController::class, "getRecord"]);

/*
@method GET
to download the pdf file in the report page
eg:-
http://localhost:3000/performance/reports/download?year=2024&month=6
*/
Router::get('/performance/reports/download', [PerformanceController::class, 'downloadReport']);
