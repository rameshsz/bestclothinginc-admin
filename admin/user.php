<?php
require_once('singleton.php');
/**
 * A model representing a user that can be authenticated.
 */
final class User
{
    /* For caching */
    private static $idCache = array();
    private static $handleCache = array();
    private $id;
    private $handle;
    private $pwHash;
    private $pwSalt;
    private function __construct($id, $handle, $pwHash, $pwSalt)
    {
        $this->id = $id;
        $this->handle = $handle;
        $this->pwHash = $pwHash;
        $this->pwSalt = $pwSalt;
    }
    /**
     * Insert $user into the cache.
     */
    private static function cacheUser($user)
    {
        $id = $user->id();
        self::$idCache["$id"] = $user;
        /* Use indirection so we only have one reference to the
* user in use.
*/
        self::$handleCache[$user->handle()] = $id;
    }
    /**
     * Cache all users. The cache is invalidated and replaced with
     * the reloaded cache.
     */
    public static function reload()
    {
        static $stmt = null;
        /* Prepare for invalidation */
        $ret = array();
        $idCache = array();
        $handleCache = array();
        if (!$stmt) {
            $db = connect();
            $stmt = $db->prepare(
                'SELECT * FROM [User]'
            );
        }
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = new User(
                    $row['ID'],
                    $row['Handle'],
                    $row['PwHash'],
                    $row['PwSalt']
                );
                $id = $row['ID'];
                $handle = $row['Handle'];
                /* Update new cache */
                $idCache["$id"] = $user;
                $handleCache["$handle"] = $id;
                /* Add to results */
                $ret[] = $user;
            }
        }
        /* Reset cache */
        self::$idCache = $idCache;
        self::$handleCache = $handleCache;
        return $ret;
    }
    /**
     * Obtain the user identified by $id. If the user exists, a User
     * object is returned. Otherwise, null is returned.
     */
    public static function forID($id)
    {
        static $stmt = null;
        /* Prepare the statement */
        $db = connect();
        if (!$stmt) {
            $stmt = $db->prepare(
                'SELECT Handle, PwHash, PwSalt FROM [User] '
                    . ' WHERE ID=:id;'
            );
        }
        /* See if we're in the cache */
        if (array_key_exists("$id", self::$idCache)) {
            return self::$idCache["$id"];
        }
        $result = null;
        $stmt->bindParam('id', $id);
        if ($stmt->execute()) {
            /* See if the user exists */
            if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                /* Cache the result */
                $result = new User(
                    $id,
                    $row[0],
                    $row[1],
                    $row[2]
                );
                self::cacheUser($result);
            }
        }
        return $result;
    }
    /**
     * Obtain the user identified by $handle. If the user exists,
     * a user object is returned. Otherwise, null is returned.
     */
    public static function forHandle($handle)
    {
        static $stmt = null;
        /* Prepare the statement */
        $db = connect();
        if (!$stmt) {
            $stmt = $db->prepare(
                'SELECT ID, PwHash, PwSalt FROM [User] WHERE Handle=:handle;'
            );
        }
        /* See if we're in the cache */
        if (array_key_exists("$handle", self::$handleCache)) {
            $id = self::$handleCache["$handle"];
            return self::$idCache["$id"];
        }
        /* Otherwise, we must fetch the user */
        $result = null;
        $stmt->bindParam(":handle", $handle);
        if ($stmt->execute()) {
            //print_r($stmt->errorInfo());
            /* See if the user exists */
            if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                /* Cache the result */
                $result = new User(
                    $row[0],
                    $handle,
                    $row[1],
                    $row[2]
                );
                self::cacheUser($result);
            }
        }
        return $result;
    }
    /**
     * Obtain the current user (if logged in). Otherwise, return null.
     */
    public static function whoami()
    {
        /* If we're logged in, the user has a UID as part of
* the session.
*/
        if (isset($_SESSION['uid'])) {
            return self::forID($_SESSION['uid']);
        } else
            return null;
    }
    /**
     * Obtain the ID for this User.
     */
    public function id()
    {
        return $this->id;
    }
    /**
     * Obtain the handle for this User.
     */
    public function handle()
    {
        return $this->handle;
    }
    /**
     * Generate a salted password hash.
     */
    private static function pwGen($password, $salt)
    {
        return hash('sha256', $password . $salt);
    }
    /**
     * Generate a random, hexidecimal-form salt value.
     */
    private static function mkSalt()
    {
        $salt = '';
        /* Build up the random string */
        for ($i = 0; $i < 8; $i++)
            $salt .= chr(rand(0, 255));
        /* Convert to hex form for storage in the database */
        return bin2hex($salt);
    }
    /**
     * Create a salted hash and salt pair for $password.
     */
    private static function mkPassword($password)
    {
        $salt = self::mkSalt();
        $hash = self::pwGen($password, $salt);
        return array($hash, $salt);
    }
    /**
     * Create a new user. The user must not already exist in the
     * database with the same handle.
     */
    public static function create($handle, $password)
    {
        static $stmt = null;
        /* See if we wouldn't clobber a user during creation */
        if (self::forHandle($handle) !== null)
            die("A user by name $handle already exists.");
        /* Prepare the statement */
        else if (!$stmt) {
            $db = connect();
            $stmt = $db->prepare(
                'INSERT INTO [User](PwHash, PwSalt, Handle) '
                    . 'VALUES(?,?,?);'
            );
        }
        /* Create parameters */
        $pwData = self::mkPassword($password);
        $pwData[] = $handle;
        if ($stmt->execute($pwData)) {
        } else {
            throw new Exception('Internal DB error:' .
                implode(', ', $db->errorInfo()));
        }
    }
    /**
     * Determine if the supplied $password matches the password set for
     * this user.
     */
    public function challenge($password)
    {
        /* Compare the password hash codes */
        return $this->pwHash === $this->pwGen(
            $password,
            $this->pwSalt
        );
    }
    /**
     * Set the password for this user. This works regardless of whether
     * the user is logged in or has supplied the previous password.
     */
    public function setPassword($password)
    {
        static $stmt = null;
        /* Generate the new password data */
        $pwData = self::mkPassword($password);
        /* Prepare the statement */
        if (!$stmt) {
            $db = connect();
            $stmt = $db->prepare(
                'UPDATE User SET PwHash=?, PwSalt=? WHERE '
                    . 'ID=?;'
            );
        }
        /* Now generate positional parameters. This is specifically prepared
* so mkPassword()'s output can be directly used: all we have to do
is
* add the username.
*/
        $params = self::mkPassword($password);
        $params[] = $this->id;
        $ret = $stmt->execute($params);
        $stmt->closeCursor();
        return $ret;
    }
};
