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
    private int $id;
    private string $metricType;
    private float $metricValue;
    private string $metricDate;
    private int $productId;

    // Constructor
    public function __construct(int $id, string $metricType, float $metricValue, string $metricDate, int $productId)
    {
        $this->id = $id;
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
     * @return array An array containing the fetched {@see Metric}s.
     */
    public static function fetchFromType(string $metricType): array
    {
        $query = 'SELECT * FROM METRIC WHERE metricType = :metricType;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('metricType', $metricType);

        try {
            $preparedStatement->execute();
            $metricArray = $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Metric', [1, 2, 3, 4, 5]);
            return $metricArray;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return array();
    }

    public function __toString(): string
    {
        return "[METRIC: id={$this->getId()} metricType={$this->getMetricType()} metricValue={$this->getMetricValue()} "
            . "metricDate={$this->metricDate} productId={$this->productId}]";
    }
}
