<?php

class FAQ
{
    // Attributes
    private ?int $id;
    private string $question;
    private string $answer;
    private string $authorEmail;

    // Constructor
    public function __construct(string $question, string $answer, string $authorEmail)
    {
        $this->id = NULL;
        $this->question = $question;
        $this->answer = $answer;
        $this->authorEmail = $authorEmail;
    }

    // Getters & Setters
    #region Getters & Setters
    public function getId()
    {
        return htmlspecialchars($this->id);
    }

    public function getQuestion($flags=ENT_COMPAT)
    {
        return htmlspecialchars($this->question, $flags);
    }

    public function getAnswer($flags=ENT_COMPAT)
    {
        return htmlspecialchars($this->answer, $flags);
    }

    public function getAuthorEmail()
    {
        return htmlspecialchars($this->authorEmail);
    }
    #endregion Getters & Setters

    // Methods
    /**
     * Fetches all the FAQs from the database.
     * @return array An array containing all the FAQs stored in the database.
     */
    public static function fetchAllFAQs(): array
    {
        $query = 'SELECT * FROM FAQ;';
        $result = Connection::getPDO()->query($query);
        $faqsArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'FAQ', [1, 2, 3, 4]);

        return $faqsArray;
    }

    /**
     * Fetches a FAQ from the database using its id.
     * @param int $id The id of the FAQ.
     * @return ?FAQ The corresponding FAQ if it exists, null otherwise.
     */
    public static function fetchFromId(int $id): ?FAQ
    {
        $query = 'SELECT * FROM FAQ WHERE id = :id;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('id', $id);

        try {
            $preparedStatement->execute();
            $faqsArray = $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'FAQ', [1, 2, 3, 4]);

            if (!empty($faqsArray))
                return $faqsArray[0];
        } catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
        }
        return null;
    }

    /**
     * Adds a new FAQ to the database.
     * @param FAQ $faq The FAQ to add to the database.
     * @return bool True if the FAQ has been added to the database, false otherwise.
     */
    public static function add(FAQ $faq): bool
    {
        $query = 'INSERT INTO FAQ(question, answer, authorEmail) VALUES(:question, :answer, :author);';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('question', $faq->getQuestion());
        $preparedStatement->bindParam('answer', $faq->getAnswer());
        $preparedStatement->bindParam('author', $faq->getAuthorEmail());

        try {
            $preparedStatement->execute();
        }
        catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
            return false;
        }
        return true;
    }

    /**
     * Updates this FAQ with the provided fields.
     * @param string $question The new question.
     * @param string $answer The new answer.
     * @param string $authorEmail The email of the author.
     * @return bool True if the FAQ has been updated, false otherwise.
     */
    public function update(string $question, string $answer, string $authorEmail): bool
    {
        $this->question = $question;
        $this->answer = $answer;
        $this->authorEmail = $authorEmail;

        $query = 'UPDATE FAQ SET question = :question, answer = :answer, authorEmail = :author WHERE id = :id;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('question', $this->getQuestion());
        $preparedStatement->bindParam('answer', $this->getAnswer());
        $preparedStatement->bindParam('author', $this->getAuthorEmail());
        $preparedStatement->bindParam('id', $this->getId());

        try {
            $preparedStatement->execute();
        }
        catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
            return false;
        }
        return true;
    }

    /**
     * Deletes this FAQ from the database.
     * @return bool True if the FAQ has been deleted from the database, false otherwise.
     */
    public function delete(): bool
    {
        $query = 'DELETE FROM FAQ WHERE id = :id;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('id', $this->getId());
        try {
            $preparedStatement->execute();
        }
        catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
            return false;
        }
        return true;
    }

    public function __toString(): string
    {
        return "[FAQ: id={$this->getId()} question={$this->getQuestion()} answer={$this->getAnswer()} authorEmail={$this->getAuthorEmail()}]";
    }
}
