<?php

class MetricController
{
    // Methods

    public static function fetchMetrics(): void
    {
        $metricType = $_POST['metricType'];
        error_log("AJAX: fetching metrics of type: $metricType");
        $metrics = Metric::fetchFromType($_POST['metricType']);
        $labels = array();
        $data = array();

        foreach($metrics as $metric)
        {
            error_log("Fetched {$metric->getMetricDate()} {$metric->getMetricValue()}");
            $labels[] = $metric->getMetricDate();
            $data[] = $metric->getMetricValue();
        }

        if(in_array($_POST['metricType'], Metric::TYPES))
        {
            //$data = [70, 80, 90];
            //$labels = ['16:30', '16:31', '16:32'];
            $arr = array('data' => $data, 'labels' => $labels);
            echo json_encode($arr);
            exit;
        }
    }
}
