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
    private ?string $lastVisit;
    private int $nbConnections;
    private bool $banned;

    // Constructor
    public function __construct(string $email, string $firstname, string $lastname, string $birthday, ?string $phoneNumber, string $passwordHash, ?string $profilePicturePath=null, int $permissionLevel=USER, ?string $lastVisit=null, int $nbConnections=0, bool $banned=false)
    {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
        $this->phoneNumber = $phoneNumber;
        $this->passwordHash = $passwordHash;
        $this->profilePicturePath = $profilePicturePath;
        $this->permissionLevel = $permissionLevel;
        $this->lastVisit = $lastVisit;
        $this->nbConnections = $nbConnections;
        $this->banned = $banned;
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

    public function getLastVisit(): string
    {
        return htmlspecialchars($this->lastVisit);
    }

    public function getNbConnections(): int
    {
        return htmlspecialchars($this->nbConnections);
    }

    public function isBanned(): bool
    {
        return htmlspecialchars($this->banned);
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
        $usersArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);

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
            $usersArray = $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]);

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
     * @return bool True if the user has been added to the database, false otherwise.
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

    /**
     * Deletes this user from the database.
     * @return bool True if the user has been deleted from the database, false otherwise.
     */
    public function delete(): bool
    {
        $query = 'DELETE FROM USERS WHERE email = :email;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('email', $this->getEmail());
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
     * Updates this user's permission level with the provided permission level.
     * @param $permissionLevel int The new permission level to apply.
     * @return bool True if the permission level has been updated, false otherwise.
     */
    public function updatePermissionLevel(int $permissionLevel): bool
    {
        $this->permissionLevel = $permissionLevel;

        $query = 'UPDATE USERS SET permissionLevel = :permissionLevel WHERE email = :email;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('permissionLevel', $this->getPermissionLevel());
        $preparedStatement->bindParam('email', $this->getEmail());

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
     * Updates the last visit date with the current date for this user.
     * @return void
     */
    public function updateLastVisit(): void
    {
        $this->lastVisit = date_format(date_create('now'), 'Y-m-d');

        $query = 'UPDATE USERS SET lastVisit = :lastVisit WHERE email = :email;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('lastVisit', $this->getLastVisit());
        $preparedStatement->bindParam('email', $this->getEmail());

        try {
            $preparedStatement->execute();
        }
        catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
        }
    }

    /**
     * Bans this user, preventing it from logging in.
     * <p>Please note that this method can also be used to unban this user by passing **false** as an argument.
     * @return bool True if the user has been successfully banned, false otherwise.
     */
    public function ban(bool $ban=true): bool
    {
        if(($ban && $this->isBanned()) || (!$ban && !$this->isBanned()))
            return false;

        $this->banned = $ban;

        $query = 'UPDATE USERS SET banned = :banned WHERE email = :email;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('banned', $this->isBanned());
        $preparedStatement->bindParam('email', $this->getEmail());

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
     * Unbans this user, allowing it to log in again.
     * <p> This is an alias to the {@link User::ban()} method: calling this method is the same as calling {@link User::ban()} with the **false** parameter.
     * @return bool True if the user has been successfully unbanned, false otherwise.
     */
    public function unban(): bool
    {
        return User::ban(false);
    }

    /**
     * Increases by one the total number of connections for this user.
     * @return void
     */
    public function increaseNbConnections(): void
    {
        $this->nbConnections++;

        $query = 'UPDATE USERS SET nbConnections = :nbConnections WHERE email = :email;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('nbConnections', $this->getNbConnections());
        $preparedStatement->bindParam('email', $this->getEmail());

        try {
            $preparedStatement->execute();
        }
        catch (PDOException $e) {
            echo "<strong style='color: red'> Error: " . $e->getMessage() . "<br></strong>";
        }
    }

    public function __toString(): string
    {
        return "[USER: email={$this->getEmail()} firstname={$this->getFirstname()} lastname={$this->getLastname()} "
            . "birthday={$this->getBirthday()} phoneNumber={$this->getPhoneNumber()} "
            . "passwordHash={$this->getPasswordHash()} profilePicturePath={$this->getProfilePicturePath()} "
            . "permissionLevel={$this->getPermissionLevel()} lastVisit={$this->getLastVisit()} "
            . "nbConnections={$this->getNbConnections()} banned={$this->isBanned()}]";
    }
}
