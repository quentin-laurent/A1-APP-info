<?php

class Frame
{
    // Attributes
    private string $type;
    private string $teamId;
    private string $requestType;
    private string $sensorType;
    private string $sensorNumber;
    private string $sensorValue;
    private string $mmss;
    private string $checksum;
    private string $timestamp;

    // Constructor
    public function __construct(string $frameString)
    {
        $this->type = substr($frameString, 0, 1);
        $this->teamId = substr($frameString, 1, 4);
        $this->requestType = substr($frameString, 5, 1);
        $this->sensorType = substr($frameString, 6, 1);
        $this->sensorNumber = substr($frameString, 7, 2);
        $this->sensorValue = substr($frameString, 9, 4);
        $this->mmss = substr($frameString, 13, 4);
        $this->checksum = substr($frameString, 17, 2);
        $this->timestamp = substr($frameString, 19, 14);
    }

    // Getters & Setters
    #region Getters & Setters
    public function getType(): string
    {
        return htmlspecialchars($this->type);
    }

    public function getTeamId(): string
    {
        return htmlspecialchars($this->teamId);
    }

    public function getRequestType(): string
    {
        return htmlspecialchars($this->requestType);
    }

    public function getSensorType(): string
    {
        return htmlspecialchars($this->sensorType);
    }

    public function getSensorTypeAsText(): ?string
    {
        return match ($this->sensorType) {
            "3" => "temperature",
            "4" => 'humidity',
            "5" => "bpm",
            "6" => "co2",
            "7" => "miroparticles",
            "10" => "sound",
            default => "co2",
        };
    }

    public function getSensorNumber(): string
    {
        return htmlspecialchars($this->sensorNumber);
    }

    public function getSensorValue(): string
    {
        return htmlspecialchars($this->sensorValue);
    }

    public function getSensorValueAsInt(): int
    {
        return hexdec($this->sensorValue);
    }

    public function getMmss(): string
    {
        return htmlspecialchars($this->mmss);
    }

    public function getChecksum(): string
    {
        return htmlspecialchars($this->checksum);
    }

    public function getTimestamp(): string
    {
        return htmlspecialchars($this->timestamp);
    }

    public function getFormattedTimestamp(): string
    {
        return date_create($this->timestamp)->format('Y-m-d H:i:s');
    }
    #endregion Getters & Setters

    // Methods


    public function __toString(): string
    {
        return "$this->type$this->teamId$this->requestType$this->sensorType$this->sensorNumber$this->sensorValue$this->mmss$this->checksum$this->timestamp";
    }
}
