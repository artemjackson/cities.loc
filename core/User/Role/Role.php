<?php

namespace Core\User\Role;

use Core\Db\Db;

class Role
{
    protected $permissions = array();

    public static function getRole($role_id)
    {

        $role = new Role();

        $sql = "SELECT t2.perm_desc FROM role_perm as t1
                JOIN permissions as t2 ON t1.perm_id = t2.perm_id
                WHERE t1.role_id = :role_id";

        Db::prepare($sql);

        $result = Db::execute(array(":role_id" => $role_id));

        foreach ($result as $permission) {
            $role->setPermission($permission["perm_desc"]);
        }

        return $role;
    }

    public function setPermission($name)
    {
        $this->permissions[$name] = true;
    }

    public function hasPermission($perm)
    {
        return isset($this->permissions[$perm]);
    }
}