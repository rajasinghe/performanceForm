<?php
require_once './Models/MonthlyPerformance.php';

use Dompdf\Dompdf;

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

                $this->sendResponse(["error" => "insufficent data to send the request"], 400);
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
            $this->sendResponse($e->getMessage(), 500);
        }
    }


    public function getRecord(Request $request)
    {
        try {

            $data = $request->getRequestParams();
            $year = $data['year'] ?? null;
            $month = $data['month'] ?? null;

            if ($year === null || $month === null) {
                $this->sendResponse(["error" => "insufficent data to send the request"], 400);
                return;
            }
            $records = $this->read($year, $month);
            $this->sendResponse($records);
        } catch (Exception $e) {
            $this->sendResponse($e->getMessage(), 500);
        }
    }

    public function downloadReport(Request $request, $year, $month)
    {
        try {
            $data = $request->getRequestParams();

            if ($year == null || $month == null) {
                $this->sendResponse(["error" => "insufficent data to send the request"], 400);
                return;
            }

            $records = $this->read($year, $month);

            $html = $this->generatePerformanceReportHTML($records, $year, $month);

            $pdf = $this->generatePdfFromHtml($html);
            //output the generated pdf to the browser
            $pdf->stream('performance_report.pdf', ['Attachment' => 0]);
            exit();
            //$this->view('performanceReport.php', $records);
            //
        } catch (Exception $e) {
            $this->sendResponse($e->getMessage(), 500);
        }
    }


    function generatePdfFromHtml($html): Dompdf
    {
        $dompdf = new Dompdf();
        if ($dompdf == null) {
            throw new Exception('error in pdf creation : instance is empty');
        }
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf;
    }

    function generatePerformanceReportHTML($records, $year, $month)
    {
        ob_start() ?>
        <center>
            <h1><u>PERFORMANCE OF SHEDULED COURSE</u></h1>
        </center>
        <br>
        <div style="letter-spacing: 2px;line-height: 30px;">
            STM / TM /ATM / TO: ...................................................<br>
            PERFORMANCE OF SCHEDULED COURSE FOR THE MONTH OF <?php echo $month . "  - " . $year ?>
        </div>
        <table border="1" width="100%" style="border-spacing: 0;">
            <tr>
                <th colspan="6" rowspan="2"></th>
                <th rowspan="2" colspan="2">Cost per <br>Participant </th>
                <th colspan="2">Scheduled Date</th>
                <th colspan="2">No of <br>Participated</th>
                <th rowspan="2" colspan="2">No of Training<br> Man Hrs</th>
                <th colspan="2">Whether Training</th>
                <th rowspan="2" colspan="2">Remarks Total Amounts</th>
            </tr>
            <tr>
                <th>Start</th>
                <th>End</th>
                <th>SLPA</th>
                <th>Outside</th>
                <th>Completed</th>
                <th>Ongoing</th>
            </tr>
            <?php
            foreach ($records as $record) {
            ?>
                <tr>
                    <td colspan="6"><?php echo $record['Name_of_Course'] ?></td>
                    <td colspan="2">
                        <?php
                        echo $record['Cost_Per_Participant']
                        ?>
                    </td>
                    <td>
                        <?php

                        $date = new DateTime($record['Scheduled_Start_Date']);
                        $formattedDateStart = $date->format('Y-m-d');

                        echo $formattedDateStart
                        ?>

                    </td>
                    <td>
                        <?php
                        $date = new DateTime($record['Scheduled_End_Date']);
                        $formattedDateEnd = $date->format('Y-m-d');
                        echo  $formattedDateEnd
                        ?>

                    </td>
                    <td><?php echo $record['No_of_participated(SLPA)'] ?></td>
                    <td><?php echo $record['No_of_participated(Outside)'] ?></td>
                    <td colspan="2"><?php echo $record['No_of_Training_Man_Hrs'] ?></td>
                    <?php if ($record['Whether_Training'] == "COMPLETED") { ?>
                        <td>YES</td>
                        <td>-</td>
                    <?php } else { ?>
                        <td>-</td>
                        <td>YES</td>
                    <?php }  ?>
                    <td colspan="2"><?php echo $record['Remarks'] ?></td>
                </tr>
            <?php } ?>

            ?>

        </table>


<?php

        return ob_get_clean();
    }
}
