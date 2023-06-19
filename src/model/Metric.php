<?php

class Metric
{
    const TEMPERATURE = 'temperature';
    const HUMIDITY = 'humidity';
    const CO2 = 'co2';
    const MICROPARTICLES = 'microparticles';
    const BPM = 'bpm';
    const SOUND = 'sound';
    const TYPES = [self::TEMPERATURE, self::HUMIDITY, self::CO2, self::MICROPARTICLES, self::BPM, self::SOUND];

    // Attributes
    private ?int $id;
    private string $metricType;
    private float $metricValue;
    private string $metricDate;
    private string $productId;

    // Constructor
    public function __construct(string $metricType, float $metricValue, string $metricDate, string $productId)
    {
        $this->id = NULL;
        $this->metricType = $metricType;
        $this->metricValue = $metricValue;
        $this->metricDate = $metricDate;
        $this->productId = $productId;
    }

    // Getters & Setters
    #region Getters & Setters
    public function getId()
    {
        return htmlspecialchars($this->id);
    }

    public function getMetricType()
    {
        return htmlspecialchars($this->metricType);
    }

    public function getMetricValue()
    {
        return htmlspecialchars($this->metricValue);
    }

    public function getMetricDate()
    {
        return htmlspecialchars($this->metricDate);
    }

    public function getMetricDateAsDate()
    {
        return date_create($this->getMetricDate());
    }

    public function getProductId()
    {
        return htmlspecialchars($this->productId);
    }
    #endregion Getters & Setters

    // Methods
    /**
     * Fetches all the Metrics from the database.
     * @return array An array containing all the Metrics stored in the database.
     */
    public static function fetchAllMetrics(): array
    {
        $query = 'SELECT * FROM METRIC;';
        $result = Connection::getPDO()->query($query);
        $metricsArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Metric', [1, 2, 3, 4, 5]);

        return $metricsArray;
    }

    /**
     * Fetches {@see Metric}s with the specified type.
     * @param string $metricType The type of {@see Metric} to fetch.
     * @param string $productId The ID of the {@see Product} containing the {@see Metric}s.
     * @param string $scale (optional) The scale (e.g. minutes, hours etc.).
     * @return array An array containing the fetched {@see Metric}s.
     */
    public static function fetchFromType(string $metricType, string $productId, string $scale='seconds'): array
    {
        if($scale === 'seconds')
            $query = 'SELECT * FROM METRIC WHERE metricType = :metricType AND productId = :productId ORDER BY metricDate DESC LIMIT 60;';
        else
            $query = 'SELECT * FROM METRIC WHERE metricType = :metricType AND productId = :productId ORDER BY metricDate DESC;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('metricType', $metricType);
        $preparedStatement->bindParam('productId', $productId);

        try {
            $preparedStatement->execute();
            $metricArray = $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Metric', [1, 2, 3, 4, 5]);
            return array_reverse($metricArray);
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return array();
    }

    /**
     * Scales the provided {@see Metric}s with the provided scale.
     * @param array $metrics The {@see Metric}s to scale.
     * @param string $scale The scale to apply (e.g. minutes, hours, etc)
     * @return array The scaled {@see Metric}s.
     */
    public static function scale(array $metrics, string $scale): array
    {
        $scaledMetrics = array();
        if($scale === 'minutes')
        {
            while(count($metrics) > 0)
            {
                $scaledMetrics[] = self::fetchMeanOfMetricWithSameMinute($metrics[0]);
                $metrics = self::clearMetricsWithSameMinute($metrics, $metrics[0]->getMetricDateAsDate()->format('Y-m-d H:i'));
            }
            return $scaledMetrics;
        }
        else if($scale === 'hours')
        {
            while(count($metrics) > 0)
            {
                $scaledMetrics[] = self::fetchMeanOfMetricWithSameHour($metrics[0]);
                $metrics = self::clearMetricsWithSameHour($metrics, $metrics[0]->getMetricDateAsDate()->format('Y-m-d H'));
            }
            return $scaledMetrics;
        }

        return $metrics;
    }

    /**
     * Fetches the mean value of {@see Metric}s with the same minute value.
     * @param Metric $metric A {@see Metric} contained in the minute to average out.
     * @return Metric|null A new {@see Metric} containing the average value for one minute.
     */
    private static function fetchMeanOfMetricWithSameMinute(Metric $metric): ?Metric
    {

        $startDate = date_create("{$metric->getMetricDateAsDate()->format('Y')}-{$metric->getMetricDateAsDate()->format('m')}-{$metric->getMetricDateAsDate()->format('d')} {$metric->getMetricDateAsDate()->format('H')}:{$metric->getMetricDateAsDate()->format('i')}:00")->format('Y-m-d H:i:s');
        $endDate = date_create("{$metric->getMetricDateAsDate()->format('Y')}-{$metric->getMetricDateAsDate()->format('m')}-{$metric->getMetricDateAsDate()->format('d')} {$metric->getMetricDateAsDate()->format('H')}:{$metric->getMetricDateAsDate()->format('i')}:59")->format('Y-m-d H:i:s');

        error_log("Getting the average value for metrics between $startDate and $endDate.");

        $query = 'SELECT AVG(metricValue) FROM METRIC WHERE metricType = :metricType AND productId = :productId AND metricDate >= :startDate AND metricDate <= :endDate;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $metricType = $metric->getMetricType();
        $productId = $metric->getProductId();
        $preparedStatement->bindParam('metricType', $metricType);
        $preparedStatement->bindParam('productId', $productId);
        $preparedStatement->bindParam('startDate', $startDate);
        $preparedStatement->bindParam('endDate', $endDate);

        try {
            $preparedStatement->execute();
            $res = $preparedStatement->fetchAll();

            if (!empty($res))
            {
                error_log("AVG result: {$res[0][0]}");
                return new Metric($metric->getMetricType(), $res[0][0], $startDate, $metric->getProductId());
            }
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return null;
    }

    /**
     * Removes the {@see Metric}s with the same minute from the specified date.
     * @param array $metrics The {@see Metric}s array.
     * @param string $date The date to compare against.
     * @return array The updated {@see Metric}s array.
     */
    private static function clearMetricsWithSameMinute(array $metrics, string $date): array
    {
        $updatedMetrics = array();
        foreach($metrics as $metric)
        {
            if($metric->getMetricDateAsDate()->format('Y-m-d H:i') != $date)
                $updatedMetrics[] = $metric;
        }

        return $updatedMetrics;
    }

    /**
     * Fetches the mean value of {@see Metric}s with the same hour value.
     * @param Metric $metric A {@see Metric} contained in the hour to average out.
     * @return Metric|null A new {@see Metric} containing the average value for one hour.
     */
    private static function fetchMeanOfMetricWithSameHour(Metric $metric): ?Metric
    {

        $startDate = date_create("{$metric->getMetricDateAsDate()->format('Y')}-{$metric->getMetricDateAsDate()->format('m')}-{$metric->getMetricDateAsDate()->format('d')} {$metric->getMetricDateAsDate()->format('H')}:00:00")->format('Y-m-d H:i:s');
        $endDate = date_create("{$metric->getMetricDateAsDate()->format('Y')}-{$metric->getMetricDateAsDate()->format('m')}-{$metric->getMetricDateAsDate()->format('d')} {$metric->getMetricDateAsDate()->format('H')}:59:59")->format('Y-m-d H:i:s');

        error_log("Getting the average value for metrics between $startDate and $endDate.");

        $query = 'SELECT AVG(metricValue) FROM METRIC WHERE metricType = :metricType AND productId = :productId AND metricDate >= :startDate AND metricDate <= :endDate;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $metricType = $metric->getMetricType();
        $productId = $metric->getProductId();
        $preparedStatement->bindParam('metricType', $metricType);
        $preparedStatement->bindParam('productId', $productId);
        $preparedStatement->bindParam('startDate', $startDate);
        $preparedStatement->bindParam('endDate', $endDate);

        try {
            $preparedStatement->execute();
            $res = $preparedStatement->fetchAll();

            if (!empty($res))
            {
                error_log("AVG result: {$res[0][0]}");
                return new Metric($metric->getMetricType(), $res[0][0], $startDate, $metric->getProductId());
            }
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return null;
    }

    /**
     * Removes the {@see Metric}s with the same hour from the specified date.
     * @param array $metrics The {@see Metric}s array.
     * @param string $date The date to compare against.
     * @return array The updated {@see Metric}s array.
     */
    private static function clearMetricsWithSameHour(array $metrics, string $date): array
    {
        $updatedMetrics = array();
        foreach($metrics as $metric)
        {
            if($metric->getMetricDateAsDate()->format('Y-m-d H') != $date)
                $updatedMetrics[] = $metric;
        }

        return $updatedMetrics;
    }

    /**
     * Adds a new {@see Metric} to the database.
     * @param Metric $metric The {@see Metric} to add to the database.
     * @return bool True if the {@see Metric} has been added to the database, false otherwise.
     */
    public static function add(Metric $metric): bool
    {
        $metricId = Metric::getHighestId() + 1;
        $query = 'INSERT INTO METRIC(metrictype, metricvalue, metricdate, productid) VALUES(:metricType, :metricValue, :metricDate, :productId);';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $metricType = $metric->getMetricType();
        $metricValue = $metric->getMetricValue();
        $meticDate = $metric->getMetricDate();
        $productId = $metric->getProductId();
        $preparedStatement->bindParam('metricType', $metricType);
        $preparedStatement->bindParam('metricValue', $metricValue);
        $preparedStatement->bindParam('metricDate', $meticDate);
        $preparedStatement->bindParam('productId', $productId);

        try {
            $preparedStatement->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Returns the highest {@see Metric} id from the database.
     * @return int The highest {@see Metric} id from the database.
     */
    private static function getHighestId(): int
    {
        $query = 'SELECT MAX(id) FROM METRIC;';
        $result = Connection::getPDO()->query($query);
        $res = $result->fetch();

        if(!is_null($res) && !is_null($res[0]))
            return $res[0];
        return 0;
    }

    /**
     * Fetches the most recent {@see Metric} date from the specified type.
     * @param string $metricType The type of the {@see Metric} to fetch.
     * @return string The most recent {@see Metric} date found, 0000-00-00 00:00:00 otherwise
     */
    public static function fetchLatestDateFromType(string $metricType): string
    {
        $query = 'SELECT MAX(metricDate) FROM METRIC where metricType = :metricType;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('metricType', $metricType);

        try {
            $preparedStatement->execute();
            $res = $preparedStatement->fetch();
            if(!is_null($res) && !is_null($res[0]))
                return $res[0];
            return '0000-00-00 00:00:00';
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return '0000-00-00 00:00:00';
    }

    public function __toString(): string
    {
        return "[METRIC: id={$this->getId()} metricType={$this->getMetricType()} metricValue={$this->getMetricValue()} "
            . "metricDate={$this->metricDate} productId={$this->productId}]";
    }
}
