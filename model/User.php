<?php

const USER = 0;
const MANAGER = 1;
const ADMINISTRATOR = 2;

class User
{
    private int $id;
    private string $firstname;
    private string $lastname;
    private string $birthday;
    private string $email;
    private string $passwordHash;
    private string $profilePicturePath;
    private int $permissions;

    // Constructor
    public function __construct(int $id, string $firstname, string $lastname, string $birthday, string $email, string $passwordHash, string $profilePicturePath, int $permissions)
    {
        $this->id = $id;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->birthday = $birthday;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
        $this->profilePicturePath = $profilePicturePath;
        $this->permissions = $permissions;
    }

    // Getters & Setters
    #region Getters&Setters
    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getProfilePicturePath(): string
    {
        return $this->profilePicturePath;
    }

    public function getPermissions(): int
    {
        return $this->permissions;
    }
    #endregion Getters&Setters

    // Methods
    /**
     * Fetches all the Users from the database.
     * @return array An array containing all the Users of the database.
     */
    public static function fetchAllUsers(): array
    {
        $query = 'SELECT * FROM USERS;';
        $result = Connection::getPDO()->query($query);
        $usersArray = $result->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User', [1,2,3,4,5,6,7,8]);

        return $usersArray;
    }

    /**
     * Fetches a User from the database using its id.
     * @deprecated For testing purposes only. Please use {@see User::fetchFromEmail()} instead.
     * @param int $id The id of the User.
     * @return ?User The corresponding User if it exists, null otherwise.
     */
    public static function fetchFromID(int $id): ?User
    {
        $query = 'SELECT * FROM USERS WHERE id = :id;';
        $preparedStatement = Connection::getPDO()->prepare($query);
        $preparedStatement->bindParam('id', $id);

        try
        {
            $preparedStatement->execute();
            $usersArray = $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User', [1,2,3,4,5,6,7,8]);

            if(!empty($usersArray))
                return $usersArray[0];
        }
        catch(PDOException $e)
        {
            echo "<strong style='color: red'> Connection error: ".$e->getMessage()."<br></strong>";
        }
        return null;
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

        try
        {
            $preparedStatement->execute();
            $usersArray = $preparedStatement->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User', [1,2,3,4,5,6,7,8]);

            if(!empty($usersArray))
                return $usersArray[0];
        }
        catch(PDOException $e)
        {
            echo "<strong style='color: red'> Connection error: ".$e->getMessage()."<br></strong>";
        }
        return null;
    }

    public function __toString(): string
    {
        return "[USER: id=$this->id firstname=$this->firstname lastname=$this->lastname birthday=$this->birthday 
        email=$this->email passwordHash=$this->passwordHash profilePicturePath=$this->profilePicturePath 
        permissions=$this->permissions] ";
    }
}
