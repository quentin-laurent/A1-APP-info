<?php

class Metric
{
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
        $metricsArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Metric', [1,2,3,4,5]);

        return $metricsArray;
    }

    public function __toString(): string
    {
        return "[METRIC: id={$this->getId()} metricType={$this->getMetricType()} metricValue={$this->getMetricValue()} "
            ."metricDate={$this->metricDate} productId={$this->productId}]";
    }
}
