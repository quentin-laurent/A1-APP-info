<?php

class Product
{
    // Attributes
    private string $id;
    private string $name;

    // Constructor
    public function __construct(string $id, string $name)
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
     * Fetches all the Products from the database.
     * @return array An array containing all the Products stored in the database.
     */
    public static function fetchAllProducts(): array
    {
        $query = 'SELECT * FROM PRODUCT;';
        $result = Connection::getPDO()->query($query);
        $productsArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product', [1, 2]);

        return $productsArray;
    }

    /**
     * Fetches a {@see Product} using its id.
     * @param ?string $id The id of the {@see Product}.
     * @return ?Product The corresponding {@see Product} if it exists, null otherwise.
     */
    public static function fetchFromId(?string $id): ?Product
    {
        $query = 'SELECT * FROM PRODUCT WHERE id = :id;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('id', $id);

        try {
            $preparedStatement->execute();
            $productsArray = $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Product', [1, 2]);
            if(!empty($productsArray))
                return $productsArray[0];
            return null;
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
        }
        return null;
    }

    public function __toString(): string
    {
        return "[PRODUCT: id={$this->getId()} name={$this->getName()} userEmail={$this->getUserEmail()}]";
    }
}
