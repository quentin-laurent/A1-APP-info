<?php

class Ticket
{
    // Attributes
    private int $id;
    private string $title;
    private string $description;
    private bool $isOpen;
    private string $authorEmail;
    private string $assigneeEmail;

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
    public function getId()
    {
        return htmlspecialchars($this->id);
    }

    public function getTitle()
    {
        return htmlspecialchars($this->title);
    }

    public function getDescription()
    {
        return htmlspecialchars($this->description);
    }

    public function getIsOpen()
    {
        return htmlspecialchars($this->isOpen);
    }

    public function getAuthorEmail()
    {
        return htmlspecialchars($this->authorEmail);
    }

    public function getAssigneeEmail()
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

    public function __toString(): string
    {
        return "[TICKET: id={$this->getId()} title={$this->getTitle()} description={$this->getDescription()} "
            . "isOpen={$this->getIsOpen()} authorEmail={$this->getAuthorEmail()} assigneeEmail={$this->getAssigneeEmail()}]";
    }
}