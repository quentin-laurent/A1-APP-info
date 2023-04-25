<?php
require_once('src/conf/Connection.php');
Connection::connect();

class User
{
    // Attributes
    private string $email;
    private string $firstname;
    private string $lastname;
    private string $birthday;
    private ?string $phoneNumber;
    private string $passwordHash;
    private ?string $profilePicturePath;
    private int $permissionLevel;

    // Constructor
    public function __construct(string $email, string $firstname, string $lastname, string $birthday, ?string $phoneNumber, string $passwordHash, ?string $profilePicturePath, int $permissionLevel)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
        $this->phoneNumber = $phoneNumber;
        $this->passwordHash = $passwordHash;
        $this->profilePicturePath = $profilePicturePath;
        $this->permissionLevel = $permissionLevel;
    }

    // Getters & Setters
    #region Getters & Setters
    public function getEmail(): string
    {
        return htmlspecialchars($this->email);
    }

    public function getFirstname(): string
    {
        return htmlspecialchars($this->firstname);
    }

    public function getLastname(): string
    {
        return htmlspecialchars($this->lastname);
    }

    public function getBirthday(): string
    {
        return htmlspecialchars($this->birthday);
    }

    public function getPhoneNumber(): string
    {
        return htmlspecialchars($this->phoneNumber);
    }

    public function getPasswordHash(): string
    {
        return htmlspecialchars($this->passwordHash);
    }

    public function getProfilePicturePath(): string
    {
        return htmlspecialchars($this->profilePicturePath);
    }

    public function getPermissionLevel(): int
    {
        return htmlspecialchars($this->permissionLevel);
    }
    #endregion Getters & Setters

    // Methods
    /**
     * Fetches all the Users from the database.
     * @return array An array containing all the Users stored in the database.
     */
    public static function fetchAllUsers(): array
    {
        $query = 'SELECT * FROM USERS;';
        $result = Connection::getPDO()->query($query);
        $usersArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User', [1, 2, 3, 4, 5, 6, 7, 8]);

        return $usersArray;
    }

    /**
     * Fetches a User from the database using its email address.
     * @param string $email The email address of the User.
     * @return ?User The corresponding User if it exists, null otherwise.
     */
    public static function fetchFromEmail(string $email): ?User
    {
        $query = 'SELECT * FROM USERS WHERE email = :email;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('email', $email);

        try {
            $preparedStatement->execute();
            $usersArray = $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User', [1, 2, 3, 4, 5, 6, 7, 8]);

            if (!empty($usersArray))
                return $usersArray[0];
        } catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
        }
        return null;
    }

    /**
     * Adds a new user to the database.
     * @param User $user The user to add to the database.
     * @return bool True if the user has been added to the database, false otherwise
     */
    public static function add(User $user): bool
    {
        $query = 'INSERT INTO USERS(email, firstname, lastname, birthday, phoneNumber, passwordHash) VALUES(:email, :firstname, :lastname, :birthday, :phoneNumber, :passwordHash)';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('email', $user->getEmail());
        $preparedStatement->bindParam('firstname', $user->getFirstname());
        $preparedStatement->bindParam('lastname', $user->getLastname());
        $preparedStatement->bindParam('birthday', $user->getBirthday());
        $preparedStatement->bindParam('phoneNumber', $user->getPhoneNumber());
        $preparedStatement->bindParam('passwordHash', $user->getPasswordHash());

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
        return "[USER: email={$this->getEmail()} firstname={$this->getFirstname()} lastname={$this->getLastname()} "
            . "birthday={$this->getBirthday()} phoneNumber={$this->getPhoneNumber()} "
            . "passwordHash={$this->getPasswordHash()} profilePicturePath={$this->getProfilePicturePath()} "
            . "permissionLevel={$this->getPermissionLevel()}]";
    }
}