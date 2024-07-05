<?php
require_once './Models/MonthlyPerformance.php';
class PerformanceController extends Controller
{
    use MonthlyPerformance;

    public function createRecord(Request $request)
    {
        try {
            $data = $request->getRequestBody();
            $year = $data['year'] ?? null;
            $month = $data['month'] ?? null;
            $courseName = $data['courseName'] ?? null;
            $cost = $data['cost'] ?? null;
            $startDate = $data['startDate'] ?? null;
            $endDate = $data['endDate'] ?? null;
            $noParticipantSLPA = $data['noParticipantSLPA'] ?? null;
            $noParticipantOutside = $data['noParticipantOutside'] ?? null;
            $trainingManHrs = $data['trainingManHrs'] ?? null;
            $trainingWhether = $data['TrainingWhether'] ?? null;
            $totalAmount = $data['totalAmount'] ?? null;


            if ($year === null || $month === null || $courseName === null || $cost === null || $startDate === null || $endDate === null || $noParticipantSLPA === null || $noParticipantOutside === null || $trainingManHrs === null || $trainingWhether === null || $totalAmount === null) {
                http_response_code(400); // Bad Request
                $this->sendResponse(["error" => "insufficent data to send the request"]);
            }

            if ($this->insert(
                $courseName,
                $month,
                $cost,
                $startDate,
                $endDate,
                $noParticipantSLPA,
                $noParticipantOutside,
                $trainingManHrs,
                $trainingWhether,
                $totalAmount,
                $year
            )) {
                $this->sendResponse(["success" => "true"]);
            } else {
                $this->sendResponse(["success" => "false"]);
            }
        } catch (Exception $e) {
            $this->sendResponse($e->getMessage());
        }
    }
}
