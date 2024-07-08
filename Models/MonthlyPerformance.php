<?php
trait MonthlyPerformance
{
    function insert($courseName, $month, $costPerParticipant, $scheduledStartDate, $scheduledEndDate, $participantCountSLPA, $patcipantCountOutside, $manHours, $isTraining, $remarks, $year)
    {
        try {
            $conn = DB::getConnection();
            $query = "
            INSERT INTO Performance (Name_of_Course,Year,Month,Cost_Per_Participant,Scheduled_Start_Date,Scheduled_End_Date,`No_of_participated(SLPA)`,`No_of_participated(Outside)`,No_of_Training_Man_Hrs,Whether_Training,`Remarks`) values (?,?,?,?,?,?,?,?,?,?,?)";
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

    /**
     * @param string $year year of the record.
     * @param string $month moth of the record.
     * @return [] result array.
     * @throws Exception if any thing goes wrong.
     */
    function read($year, $month)
    {
        $conn = Db::getConnection();
        $query = "SELECT * FROM performance WHERE Month=:month AND Year=:year";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':month', $month);
        $stmt->bindParam(':year', $year);
        if (!$stmt->execute()) {
            throw new Exception("unable to execute the query");
        }
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$results) {
            throw new Exception("invalid resultset");
        }
        return $results;
    }

    function delete()
    {
    }

    function getYear()
{
    $conn = Db::getConnection(); // Assuming this method exists in your Db class
    $query = "SELECT DISTINCT `Year` FROM performance";
    $result = $conn->query($query); // Execute the query directly

    if ($result === false) {
        throw new Exception("Error executing the query: ");
    }

    $results = $result->fetchAll(PDO::FETCH_ASSOC);

    if (!$results) {
        throw new Exception("No results found");
    }

    return $results;
}
}
