<?php

class Ticket
{
    // Attributes
    private int $id;
    private string $title;
    private string $description;
    private bool $isOpen;
    private ?string $authorEmail;
    private ?string $assigneeEmail;

    // Constructor
    public function __construct(int $id, string $title, string $description, bool $isOpen, string $authorEmail, string $assigneeEmail)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->isOpen = $isOpen;
        $this->authorEmail = $authorEmail;
        $this->assigneeEmail = $assigneeEmail;
    }

    // Getters & Setters
    #region Getters & Setters
    public function getId(): int
    {
        return htmlspecialchars($this->id);
    }

    public function getTitle(): string
    {
        return htmlspecialchars($this->title);
    }

    public function getDescription(): string
    {
        return htmlspecialchars($this->description);
    }

    public function getIsOpen(): bool
    {
        return htmlspecialchars($this->isOpen);
    }

    public function getAuthorEmail(): string
    {
        return htmlspecialchars($this->authorEmail);
    }

    public function getAssigneeEmail(): string
    {
        return htmlspecialchars($this->assigneeEmail);
    }
    #endregion Getters & Setters

    // Methods
    /**
     * Fetches all the Tickets from the database.
     * @return array An array containing all the Tickets stored in the database.
     */
    public static function fetchAllTickets(): array
    {
        $query = 'SELECT * FROM TICKET;';
        $result = Connection::getPDO()->query($query);
        $ticketsArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Ticket', [1, 2, 3, 4, 5, 6]);

        return $ticketsArray;
    }

    /**
     * Fetches all the Tickets from the specified author.
     * @param string $authorEmail The email of the author.
     * @return array An array containing all the Tickets created by the specified author.
     */
    public static function fetchFromAuthor(string $authorEmail): array
    {
        $query = 'SELECT * FROM TICKET WHERE authorEmail = :authorEmail;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('authorEmail', $authorEmail);

        try {
            $preparedStatement->execute();
            return $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Ticket', [1, 2, 3, 4, 5, 6]);
        }
        catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
        }
        return array();
    }

    public function __toString(): string
    {
        return "[TICKET: id={$this->getId()} title={$this->getTitle()} description={$this->getDescription()} "
            . "isOpen={$this->getIsOpen()} authorEmail={$this->getAuthorEmail()} assigneeEmail={$this->getAssigneeEmail()}]";
    }
}
