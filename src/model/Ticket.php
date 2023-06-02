<?php

class Ticket
{
    // Attributes
    private ?int $id;
    private string $title;
    private string $description;
    private bool $isOpen;
    private bool $isResolved;
    private ?string $authorEmail;
    private ?string $assigneeEmail;

    // Constructor
    public function __construct(string $title, string $description, bool $isOpen, bool $isResolved, ?string $authorEmail, ?string $assigneeEmail)
    {
        $this->id = NULL;
        $this->title = $title;
        $this->description = $description;
        $this->isOpen = $isOpen;
        $this->isResolved = $isResolved;
        $this->authorEmail = $authorEmail;
        $this->assigneeEmail = $assigneeEmail;
    }

    // Getters & Setters
    #region Getters & Setters
    public function getId(): int
    {
        return htmlspecialchars($this->id);
    }

    public function getTitle($flags=ENT_COMPAT): string
    {
        return htmlspecialchars($this->title, $flags);
    }

    public function getDescription($withBr=false): string
    {
        if($withBr)
            return nl2br(htmlspecialchars($this->description, ENT_NOQUOTES));
        return htmlspecialchars($this->description, ENT_NOQUOTES);
    }

    public function getIsOpen(): bool
    {
        return htmlspecialchars($this->isOpen);
    }

    /**
     * Convenient alias for {@see getIsOpen()}.
     * @return bool: True if this Ticket is open, false otherwise.
     */
    public function isOpen(): bool
    {
        return $this->getIsOpen();
    }

    public function getIsResolved(): bool
    {
        return htmlspecialchars($this->isResolved);
    }

    /**
     * Convenient alias for {@see getIsResolved()}.
     * @return bool: True if this Ticket has been resolved, false otherwise.
     */
    public function isResolved(): bool
    {
        return $this->getIsResolved();
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
     * Fetches a  Ticket using its id.
     * @param int $id The id of the Ticket.
     * @return ?Ticket The corresponding Ticket if it exists, null otherwise.
     */
    public static function fetchFromId(int $id): ?Ticket
    {
        $query = 'SELECT * FROM TICKET WHERE id = :id;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('id', $id);

        try {
            $preparedStatement->execute();
            $ticketsArray = $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Ticket', [1, 2, 3, 4, 5, 6]);
            if(!empty($ticketsArray))
                return $ticketsArray[0];
            return null;
        }
        catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
        }
        return null;
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

    /**
     * Adds a new Ticket to the database.
     * @param Ticket $ticket The Ticket to add to the database.
     * @return bool True if the Ticket has been added to the database, false otherwise.
     */
    public static function add(Ticket $ticket, $tagType, $tagPriority): bool
    {
        $query = 'INSERT INTO TICKET(title, description, authorEmail) VALUES(:title, :description, :authorEmail);';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('title', $ticket->getTitle());
        $preparedStatement->bindParam('description', $ticket->getDescription());
        $preparedStatement->bindParam('authorEmail', $ticket->getAuthorEmail());

        try {
            $preparedStatement->execute();
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }

        $ticketId = Ticket::getHighestId();

        $tag1 = Tag::fetchFromName($tagType);
        $tag2 = Tag::fetchFromName($tagPriority);
        if(!is_null($tag1))
        {
            $query = 'INSERT INTO TICKET_TAGS(ticketId, tagId) VALUES(:ticketId, :tagId);';
            $preparedStatement = Connection::getPDO()->prepare($query);
            $preparedStatement->bindParam('ticketId', $ticketId);
            $preparedStatement->bindParam('tagId', $tag1->getId());

            try {
                $preparedStatement->execute();
            }
            catch (PDOException $e) {
                error_log($e->getMessage());
                return false;
            }
        }
        if(!is_null($tag2))
        {
            $query = 'INSERT INTO TICKET_TAGS(ticketId, tagId) VALUES(:ticketId, :tagId);';
            $preparedStatement = Connection::getPDO()->prepare($query);
            $preparedStatement->bindParam('ticketId', $ticketId);
            $preparedStatement->bindParam('tagId', $tag2->getId());

            try {
                $preparedStatement->execute();
            }
            catch (PDOException $e) {
                error_log($e->getMessage());
                return false;
            }
        }
        return true;
    }

    /**
     * Updates this Ticket with the provided fields.
     * @param string $title The new title.
     * @param string $description The new description.
     * @param string $tagType The new tag type
     * @param string $tagPriority The new tag priority
     * @return bool True if the Ticket has been updated, false otherwise.
     */
    public function update(string $title, string $description, string $tagType, string $tagPriority): bool
    {
        $this->title = $title;
        $this->description = $description;

        $query = 'UPDATE TICKET SET title = :title, description = :description WHERE id = :id;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('title', $this->getTitle());
        $preparedStatement->bindParam('description', $this->getDescription());
        $preparedStatement->bindParam('id', $this->getId());

        try {
            $preparedStatement->execute();
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }

        // Deleting entries in TICKET_TAGS
        $tags = $this->getTags();
        foreach($tags as $tag)
        {
            $query = 'DELETE FROM TICKET_TAGS WHERE (ticketId, tagId) = (:ticketId, :tagId);';
            $preparedStatement = Connection::getPDO()->prepare($query);
            $preparedStatement->bindParam('ticketId', $this->getId());
            $preparedStatement->bindParam('tagId', $tag->getId());

            try {
                $preparedStatement->execute();
            }
            catch (PDOException $e) {
                error_log($e->getMessage());
                return false;
            }
        }

        $tag1 = Tag::fetchFromName($tagType);
        $tag2 = Tag::fetchFromName($tagPriority);
        if(!is_null($tag1))
        {
            $query = 'INSERT INTO TICKET_TAGS(ticketId, tagid) VALUES(:ticketId, :tagId);';
            $preparedStatement = Connection::getPDO()->prepare($query);
            $preparedStatement->bindParam('tagId', $tag1->getId());
            $preparedStatement->bindParam('ticketId', $this->getId());

            try {
                $preparedStatement->execute();
            }
            catch (PDOException $e) {
                error_log($e->getMessage());
                return false;
            }
        }
        if(!is_null($tag2))
        {
            $query = 'INSERT INTO TICKET_TAGS(ticketId, tagid) VALUES(:ticketId, :tagId);';
            $preparedStatement = Connection::getPDO()->prepare($query);
            $preparedStatement->bindParam('tagId', $tag2->getId());
            $preparedStatement->bindParam('ticketId', $this->getId());

            try {
                $preparedStatement->execute();
            }
            catch (PDOException $e) {
                error_log($e->getMessage());
                return false;
            }
        }
        return true;
    }

    /**
     * Returns all the Tags associated to this Ticket.
     * @return array An array containing this Ticket's tags.
     */
    public function getTags(): array
    {
        $query = 'SELECT id, name FROM TAG INNER JOIN TICKET_TAGS ON TAG.id = TICKET_TAGS.tagId WHERE ticketId = :tagId;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $tagId = $this->getId();
        $preparedStatement->bindParam('tagId', $tagId);

        try {
            $preparedStatement->execute();
            return $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Tag', [1, 2]);
        }
        catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
        }
        return array();
    }

    /**
     * Returns the highest Ticket id from the database.
     * @return int The highest Ticket id from the database.
     */
    public static function getHighestId(): int
    {
        $query = 'SELECT MAX(id) FROM TICKET;';
        $result = Connection::getPDO()->query($query);
        $res = $result->fetch();

        if(!empty($res) && !is_null($res[0]))
            return $res[0];
        return 0;
    }

    /**
     * Closes this Ticket by setting the {@see $isOpen} attribute to false.
     * @return bool True if the Ticket has been closed, false otherwise.
     */
    public function close(): bool
    {
        $this->isOpen = false;
        return $this->updateStatus();
    }

    /**
     * Marks this Ticket as resolved by setting the {@see $isResolved} attribute to true.
     * <p>This also sets the {@see $isOpen} attribute to false.
     * @return bool True if the Ticket has been resolved, false otherwise.
     */
    public function resolve(): bool
    {
        $this->isResolved = true;
        $this->isOpen = false;
        return $this->updateStatus();
    }

    /**
     * Reopens this Ticket by setting the {@see $isOpen} attribute to true.
     * <p> This also sets the {@see $isResolved} attribute to false.
     * @return bool True if the Ticket has been reopened, false otherwise.
     */
    public function reopen(): bool
    {
        $this->isOpen = true;
        $this->isResolved = false;
        return $this->updateStatus();
    }

    /**
     * Updates the {@see $isOpen} and {@see $isResolved} attributes of this Ticket in the database.
     * @return bool: True if the update succeeded, false otherwise.
     */
    private function updateStatus(): bool
    {
        $query = 'UPDATE TICKET SET isOpen = :isOpen, isResolved = :isResolved WHERE id = :id;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $isOpen = $this->getIsOpen() ? 1 : 0;
        $preparedStatement->bindParam('isOpen', $isOpen);
        $isResolved = $this->getIsResolved() ? 1 : 0;
        $preparedStatement->bindParam('isResolved', $isResolved);
        $preparedStatement->bindParam('id', $this->getId());

        try {
            $preparedStatement->execute();
        }
        catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
        return true;
    }

    public function __toString(): string
    {
        return "[TICKET: id={$this->getId()} title={$this->getTitle()} description={$this->getDescription()} "
            . "isOpen={$this->getIsOpen()} authorEmail={$this->getAuthorEmail()} assigneeEmail={$this->getAssigneeEmail()}]";
    }
}
