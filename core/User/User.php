<?php

namespace Core\User;

use Core\Db\Db;
use Core\User\Role\Role;

/**
 * Class User
 * @package Core\User
 */
class User
{
    /**
     * @var
     */
    protected $roles = array();

    /**
     * @var
     */
    protected $data = array();

    /**
     * @param $email
     * @return User|null
     */
    public static function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE eamil = :email";

        Db::prepare($sql);

        $result = Db::execute(array(':email' => $email));

        if (!empty($result)) {
            $user = new User();
            $user->setData($result[0]);
            $user->initRoles();
            return $user;
        } else {
            return null;
        }
    }

    //TODO it must be in UserModel

    /**
     *
     */
    public function initRoles()
    {
        $sql = "SELECT t1.role_id, t2.role_name FROM users_roles as t1
                JOIN roles as t2 ON t1.role_id = t2.role_id
                WHERE t1.user_id = :user_id";

        Db::prepare($sql);

        $result = Db::execute(array(':user_id' => $this->data['id']));

        foreach ($result as $role) {
            $this->setRole($role['role_name'], Role::getRole($role['role_id']));
        }
    }

    /**
     * @param $name
     * @param $role
     */
    public function setRole($name, $role)
    {
        $this->roles[$name] = $role;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    //TODO all queries in models

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data = array())
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasRole($name)
    {
        return isset($this->roles[$name]);
    }

    /**
     * @return mixed
     */
    public function getRoles()
    {
        return $this->roles;
    }
}