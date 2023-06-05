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
        Metric::add(new Metric($_POST['metricType'], $_POST['metricValue'], $_POST['metricDate'], 1));
    }
}
