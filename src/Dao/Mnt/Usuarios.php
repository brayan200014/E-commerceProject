<?php
namespace Dao\Mnt;
use Dao\Table;

class Usuarios extends Table
{
    public static function getUsuarios()
    {
        $sqlStr="SELECT * FROM usuario;";
        return self::obtenerRegistros($sqlStr, array());
    }

    public static function getOneUsuario($user)
    {
        $sqlstr="SELECT 
            rol.roledcod 
            FROM roles_usuarios as user_rol 
            right outer join roles as rol 
            on rol.rolescod = user_rol.roledcod and user_rol.user=:user
            where user_rol.user is null;";
        $resultados = self::obtenerRegistros(
            $sqlstr, 
            array(
                'user' => $user
            )
        );
        return $resultados;
    }

    /*
    public static function createUsuario($useremail, $username, $userpswd, $userrole, $userest,)
    {
        $sqlStr = "INSERT INTO usuarios (user,useremail,username,userpswd,userrole, userest) VALUES (:useremail,:username,:userpswd,:userrole,:userest);";
        $parametros = array('useremail' => $useremail, 'username' => $username, 'userpswd' => $userpswd, 'userrole' => $userrole, 'userest' => $userest);
        return self::executeNonQuery($sqlStr, $parametros);
    }
    */
    static private function _saltPassword($password)
    {
        return hash_hmac(
            "sha256",
            $password,
            \Utilities\Context::getContextByKey("PWD_HASH")
        );
    }

    static private function _hashPassword($password)
    {
        return password_hash(self::_saltPassword($password), PASSWORD_ALGORITHM);
    }

    public static function editUsuario(
        $user,
        $useremail,
        $username,
        $userpswd,
        $userrole,
        $userest
    ) {
        $sqlStr = 'UPDATE usuario
            SET useremail = :useremail,
            username = :username,
            userpswd = :userpswd,
            userrole = :userrole
            WHERE usercod = :user;';
        $parametros = array(
            'user' => $user,
            'useremail' => $useremail,
            'username' => $username,
            'userrole' => $userrole,
            'userest' => $userest,
            'userpswd' => self::_hashPassword($userpswd)
        );

        return self::executeNonQuery($sqlStr, $parametros);
    }

    public static function editUsuarioNoPswd(
        $user,
        $useremail,
        $username,
        $userrole,
        $userest
    ) {
        $sqlStr = 'UPDATE usuario
            SET useremail = :useremail,
            username = :username,
            userrole = :userrole
            WHERE usercod = :user;';
        $parametros = array(
            'user' => $user,
            'useremail' => $useremail,
            'username' => $username,
            'userrole' => $userrole,
            'userest' => $userest,
        );

        return self::executeNonQuery($sqlStr, $parametros);
    }
    /*
    public static function editUserRoles($user, $roles)
    {
        $roleuserest = 'ACT';
        $roleuserfch = date('Y-m-d H:i:s');
        $roleuserexp = date('Y-m-d H:i:s', strtotime('+10 years'));
        foreach ($roles as $role) {
            $sqlStr = "UPDATE SET usuarios userrole = :userrole WHERE user = :user";
            $parametros = array(
                'user' => $user,
                'userrole' => $role
            );
            self::executeNonQuery($sqlStr, $parametros);
        }
        return true;
    }
    */
    public static function deleteUsuario($user)
    {
        $sqlStr = "DELETE FROM usuario WHERE usercod = :user;";
        $parametros = array(
            'user' => $user,
        );
        return self::executeNonQuery($sqlStr, $parametros);
    }
}
?>