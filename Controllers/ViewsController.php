<?php

class ViewsController extends Controller
{

    public function performanceForm()
    {
        $this->view('performanceForm.html');
    }

    public function performanceReport()
    {
        $this->view('performanceReport.html');
    }

    
}
