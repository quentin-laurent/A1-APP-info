<?php

class Product
{
    // Attributes
    private int $id;
    private string $name;
    private int $userEmail;

    // Constructor
    public function __construct(int $id, string $name, string $userEmail)
    {
        $this->id = $id;
        $this->name = $name;
        $this->userEmail = $userEmail;
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

    public function getUserEmail()
    {
        return htmlspecialchars($this->userEmail);
    }
    #endregion Getters & Setters

    // Methods
    /**
     * Fetches all the Products from the database.
     * @return array An array containing all the Products stored in the database.
     */
    public static function fetchAllProducts(): array
    {
        $query = 'SELECT * FROM PRODUCT;';
        $result = Connection::getPDO()->query($query);
        $productsArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product', [1, 2, 3]);

        return $productsArray;
    }

    public function __toString(): string
    {
        return "[PRODUCT: id={$this->getId()} name={$this->getName()} userEmail={$this->getUserEmail()}]";
    }
}
