<?php

class MetricController
{
    // Methods

    /**
     * Fetches all the metrics from the database using the provided metric type.
     * @return void
     */
    public static function fetchMetrics(): void
    {
        $metricType = $_POST['metricType'];
        $scale = $_POST['scale'];
        $metrics = Metric::fetchFromType($_POST['metricType'], $scale);

        if($scale != 'seconds')
            $metrics = Metric::scale($metrics, $scale);

        $labels = array();
        $data = array();

        foreach($metrics as $metric)
        {
            $date = date_create($metric->getMetricDate());
            $labels[] = $date->format('d/m/Y H:i:s');
            $data[] = $metric->getMetricValue();
        }

        if(in_array($_POST['metricType'], Metric::TYPES))
        {
            $arr = array('data' => $data, 'labels' => $labels);
            echo json_encode($arr);
            exit;
        }
    }

    public static function injectMetric()
    {
        Metric::add(new Metric($_POST['metricType'], $_POST['metricValue'], $_POST['metricDate'], '007B'));
    }

    public static function updateMetrics(): void
    {
        $productId = User::fetchFromEmail($_SESSION['email'])->getProductId();
        if(is_null($productId))
            return;

        $frames = self::fetchFramesFromTeam($productId);

        foreach ($frames as $frame)
        {
            //error_log("Current frame: $frame ({$frame->getSensorTypeAsText()} {$frame->getSensorValueAsInt()} {$frame->getFormattedTimestamp()})");

            if($frame->getSensorTypeAsText() == 'bpm' && $frame->getSensorValueAsInt() > 200)
                continue;

            $latestMetricDate = Metric::fetchLatestDateFromType($frame->getSensorTypeAsText());
            if($frame->getFormattedTimestamp() > $latestMetricDate)
            {
                //error_log("Will add value {$frame->getSensorValueAsInt()} with timestamp {$frame->getFormattedTimestamp()} (compared against $latestMetricDate).");
                Metric::add(new Metric($frame->getSensorTypeAsText(), $frame->getSensorValueAsInt(), $frame->getFormattedTimestamp(), $frame->getTeamId()));
            }
            /*
            else
                error_log("Will NOT add value {$frame->getSensorValueAsInt()} with timestamp {$frame->getFormattedTimestamp()} (compared against $latestMetricDate).");
            */
        }
    }

    private static function fetchFramesFromTeam(string $teamId): array
    {
        error_log("Fetching log file from team $teamId...");

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,"http://projets-tomcat.isep.fr:8080/appService?ACTION=GETLOG&TEAM=$teamId");
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $rawData = curl_exec($curl);
        curl_close($curl);

        $data = str_split($rawData, 33);
        // Removing the \n char at the end of the array
        array_pop($data);
        $frames = array();
        foreach($data as $frame)
            $frames[] = new Frame($frame);

        error_log("Fetched log file from team $teamId !");
        return $frames;
    }
}
