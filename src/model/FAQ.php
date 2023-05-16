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

    public function getQuestion()
    {
        return htmlspecialchars($this->question);
    }

    public function getAnswer()
    {
        return htmlspecialchars($this->answer);
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

    public function __toString(): string
    {
        return "[FAQ: id={$this->getId()} question={$this->getQuestion()} answer={$this->getAnswer()} authorEmail={$this->getAuthorEmail()}]";
    }
}
