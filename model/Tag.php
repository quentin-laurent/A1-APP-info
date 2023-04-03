<?php

class Tag
{
    // Attributes
    private int $id;
    private string $name;

    // Constructor
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    // Getters & Setters
    #region Getters & Setters
    public function getId()
    {
        return htmlspecialchars($this->id);
    }

    public function getName()
    {
        return htmlspecialchars($this->name);
    }
    #endregion Getters & Setters

    // Methods
    /**
     * Fetches all the Tags from the database.
     * @return array An array containing all the Tags stored in the database.
     */
    public static function fetchAllTags(): array
    {
        $query = 'SELECT * FROM TAG;';
        $result = Connection::getPDO()->query($query);
        $tagsArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Tag', [1,2]);

        return $tagsArray;
    }

    public function __toString(): string
    {
        return "[TAG: id={$this->getId()} name={$this->getName()}]";
    }
}
