<?php

class FAQ
{
    // Attributes
    private int $id;
    private string $question;
    private string $answer;
    private int $authorId;

    // Constructor
    public function __construct(int $id, string $question, string $answer, int $authorId)
    {
        $this->id = $id;
        $this->question = $question;
        $this->answer = $answer;
        $this->authorId = $authorId;
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

    public function getAuthorId()
    {
        return htmlspecialchars($this->authorId);
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
        $faqsArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'FAQ', [1,2,3,4]);

        return $faqsArray;
    }

    public function __toString(): string
    {
        return "[FAQ: id={$this->getId()} question={$this->getQuestion()} answer={$this->getAnswer()} authorId={$this->getAuthorId()}]";
    }
}
