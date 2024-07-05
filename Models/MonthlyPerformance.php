<?php
trait MonthlyPerformance
{
    function insert($courseName, $month, $costPerParticipant, $scheduledStartDate, $scheduledEndDate, $participantCountSLPA, $patcipantCountOutside, $manHours, $isTraining, $remarks, $year)
    {
        try {
            $conn = DB::getConnection();
            $query = "
            INSERT INTO Performance (Name_of_Course,Year,Month,Cost_Per_Participant,Scheduled_Start_Date,Scheduled_End_Date,`No_of_participated(SLPA)`,`No_of_participated(Outside)`,No_of_Training_Man_Hrs,Whether_Training,`Remaks/Total_Amount`) values (?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(1, $courseName);
            $stmt->bindParam(2, $year);
            $stmt->bindParam(3, $month);
            $stmt->bindParam(4, $costPerParticipant);
            $stmt->bindParam(5, $scheduledStartDate);
            $stmt->bindParam(6, $scheduledEndDate);
            $stmt->bindParam(7, $participantCountSLPA);
            $stmt->bindParam(8, $patcipantCountOutside);
            $stmt->bindParam(9, $manHours);
            $stmt->bindParam(10, $isTraining);
            $stmt->bindParam(11, $remarks);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    function update()
    {
    }

    function read($year, $month)
    {
        $conn = Db::getConnection();
    }

    function delete()
    {
    }
}
