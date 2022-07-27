<?php
namespace Dao\Security;

if (version_compare(phpversion(), '7.4.0', '<')) {
        define('PASSWORD_ALGORITHM', 1);  //BCRYPT
} else {
    define('PASSWORD_ALGORITHM', '2y');  //BCRYPT
}
 
/*
usercod     bigint(10) AI PK
useremail   varchar(80)
username    varchar(80)
userpswd    varchar(128)
userfching  datetime
userpswdest char(3)
userpswdexp datetime
userest     char(3)
useractcod  varchar(128)
userpswdchg varchar(128)
usertipo    char(3)
*/

use Exception;

class Security extends \Dao\Table
{    /*
    static public function getUsuarios($filter = "", $page = -1, $items = 0)
    {
        $sqlstr = "";
        if ($filter == "" && $page == -1 && $items == 0) {
            $sqlstr = "SELECT * FROM usuario;";
        } else {
            //TODO: Terminar consultas FACET
            if ($page = -1 and $items = 0) {
                $sqlstr = sprintf("SELECT * FROM usuarios %s;", $filter);
            } else {
                $offset = ($page -1 * $items);
                $sqlstr = sprintf(
                    "SELECT * FROM usuarios %s limit %d, %d;",
                    $filter,
                    $offset,
                    $items
                );
            }
        }
        return self::obtenerRegistros($sqlstr, array());
    }*/

    public static function getAll()
    {
        return self::obtenerRegistros("SELECT * FROM usuario ORDER BY usertipo;",array());
    }

    static public function insertUsuarioFromCliente($useremail, $userpswd, $username)
    {
        if (!\Utilities\Validators::IsValidEmail($useremail)) {
            throw new Exception("Correo no es válido");
        }
        if (!\Utilities\Validators::IsValidPassword($userpswd)) {
            throw new Exception("Contraseña debe ser almenos 8 caracteres, 1 número, 1 mayúscula, 1 símbolo especial");
        }

        $newUser = self::_usuarioStruct();
        //Tratamiento de la Contraseña
        $hashedPassword = self::_hashPassword($userpswd);

        unset($newUser["usercod"]);
        unset($newUser["userfching"]);
        unset($newUser["userpswdchg"]);

        $newUser["useremail"] = $useremail;
        $newUser["username"] = $username;
        $newUser["userpswd"] = $hashedPassword;
        $newUser["userpswdest"] = Estados::ACTIVO;
        $newUser["userpswdexp"] = date('Y-m-d', time() + 7776000);  //(3*30*24*60*60) (m d h mi s)
        $newUser["userest"] = Estados::ACTIVO;
        $newUser["useractcod"] = hash("sha256", $useremail.time());
        $newUser["usertipo"] = usertipo::PUBLICO;

        $sqlIns = "INSERT INTO `usuario` (`useremail`, `username`, `userpswd`,
            `userfching`, `userpswdest`, `userpswdexp`, `userest`, `useractcod`,
            `userpswdchg`, `usertipo`)
            VALUES
            ( :useremail, :username, :userpswd,
            now(), :userpswdest, :userpswdexp, :userest, :useractcod,
            now(), :usertipo);";

        return self::executeNonQuery($sqlIns, $newUser);
    }

    static public function insertUsuarioFromAdmin($useremail, $userpswd, $username, $usertipo)
    {
        if (!\Utilities\Validators::IsValidEmail($useremail)) {
            throw new Exception("Correo no es válido");
        }
        if (!\Utilities\Validators::IsValidPassword($userpswd)) {
            throw new Exception("Contraseña debe ser almenos 8 caracteres, 1 número, 1 mayúscula, 1 símbolo especial");
        }

        $newUser = self::_usuarioStruct();
        //Tratamiento de la Contraseña
        $hashedPassword = self::_hashPassword($userpswd);

        unset($newUser["usercod"]);
        unset($newUser["userfching"]);
        unset($newUser["userpswdchg"]);

        $newUser["useremail"] = $useremail;
        $newUser["username"] = $username;
        $newUser["userpswd"] = $hashedPassword;
        $newUser["userpswdest"] = Estados::ACTIVO;
        $newUser["userpswdexp"] = date('Y-m-d', time() + 7776000);  //(3*30*24*60*60) (m d h mi s)
        $newUser["userest"] = Estados::ACTIVO;
        $newUser["useractcod"] = hash("sha256", $useremail.time());
        $newUser["usertipo"] = $usertipo;

        $sqlIns = "INSERT INTO `usuario` (`useremail`, `username`, `userpswd`,
            `userfching`, `userpswdest`, `userpswdexp`, `userest`, `useractcod`,
            `userpswdchg`, `usertipo`)
            VALUES
            ( :useremail, :username, :userpswd,
            now(), :userpswdest, :userpswdexp, :userest, :useractcod,
            now(), :usertipo);";

        return self::executeNonQuery($sqlIns, $newUser);
    }

    static public function updateUsuarioAdmin($usercod,$useremail,$username,$userest,$usertipo)
    {
        if (!\Utilities\Validators::IsValidEmail($useremail)) 
        {
            throw new Exception("Correo no es válido");
        }

        $usuario = self::_usuarioStruct();
        unset($usuario["userpswd"]);
        unset($usuario["userfching"]);   
        unset($usuario["useropswdest"]);  
        unset($usuario["userpswdexp"]);  
        unset($usuario["userest"]);     
        unset($usuario["useractcod"]);   
        unset($usuario["userpswdchg"]); 

        $usuario["usercod"] = $usercod;
        $usuario["useremail"] = $useremail;
        $usuario["username"] = $username;
        $usuario["userest"] = $userest;
        $usuario["useractcod"] = hash("sha256", $useremail.time());
        $usuario["usertipo"] = $usertipo;

        $sqlIns = "UPDATE `usuario` SET useremail=:useremail, username=:username, 
        userest=:userest, useractcod=:useractcod, usertipo=:usertipo WHERE usercod=:usercod";

        return self::executeNonQuery($sqlIns, $usuario);
    }

    static public function updateUsuarioWithPswdAdmin($usercod, $useremail, $username, $userpswd, $userest, $usertipo)
    {
        if (!\Utilities\Validators::IsValidEmail($useremail)) 
        {
            throw new Exception("Correo no es válido");
        }
        
        if (!\Utilities\Validators::IsValidPassword($userpswd)) 
        {
            throw new Exception("Contraseña debe ser almenos 8 caracteres, 1 número, 1 mayúscula, 1 símbolo especial");
        }      
        
        $usuario = self::_usuarioStruct();
        //Tratamiento de la Contraseña
        $hashedPassword = self::_hashPassword($userpswd);

        unset($usuario["userfching"]);
        unset($usuario["userpswdchg"]);

        $usuario["usercod"] = $usercod;
        $usuario["useremail"] = $useremail;
        $usuario["username"] = $username;
        $usuario["userpswd"] = $hashedPassword;
        $usuario["userpswdEst"] = Estados::ACTIVO;
        $usuario["userpswdExp"] = date('Y-m-d', time() + 7776000);  //(3*30*24*60*60) (m d h mi s)
        $usuario["userest"] = $userest;
        $usuario["useractcod"] = hash("sha256", $useremail.time());
        $usuario["usertipo"] = $usertipo;

        $sqlIns = "UPDATE `usuario` SET `useremail`=:useremail, `username`=:username, 
        `userpswd`=:userpswd, `userpswdEst`=:userpswdEst, `userpswdExp`=:userpswdExp, 
        `userest`=:userest, `useractcod`=:useractcod, `userpswdchg`=now(), `usertipo`=:usertipo
        WHERE usercod=:usercod;";
        return self::executeNonQuery($sqlIns, $usuario);
    }

    public static function deleteUsuarioAdmin($usercod)
    {
        $delsql = "DELETE FROM usuario WHERE usercod=:usercod;";
        return self::executeNonQuery
        (
            $delsql,
            array("usercod" => $usercod)
        );
    }

    public static function getUsuariobyId($usercod)
    {
        $sqlstr = "SELECT * FROM usuarios WHERE usercod = :usercod LIMIT 1;";
        return self::obtenerUnRegistro($sqlstr, array("usercod"=>$usercod));
    }

    static public function getUsuarioByEmail($useremail)
    {
        $sqlstr = "SELECT * from `usuario` where `useremail` = :useremail ;";
        $params = array("useremail"=>$useremail);

        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function getUsuarioDifferbyEmail($usercod, $useremail)
    {
        $sqlstr = "SELECT * FROM usuario WHERE usercod!=:usercod AND useremail=:useremail";
        return self::obtenerRegistros($sqlstr, array("usercod"=>$usercod, "useremail"=>$useremail));
    }

    static private function _saltPassword($userpswd)
    {
        return hash_hmac(
            "sha256",
            $userpswd,
            \Utilities\Context::getContextByKey("PWD_HASH")
        );
    }

    static private function _hashPassword($password)
    {
        return password_hash(self::_saltPassword($password), PASSWORD_ALGORITHM);
    }

    static public function verifyPassword($raw_password, $hash_password)
    {
        return password_verify(
            self::_saltPassword($raw_password),
            $hash_password
        );
    }


    static private function _usuarioStruct()
    {
        return array(
            "usercod"      => "",
            "useremail"    => "",
            "username"     => "",
            "userpswd"     => "",
            "userfching"   => "",
            "userpswdest"  => "",
            "userpswdexp"  => "",
            "userest"      => "",
            "useractcod"   => "",
            "userpswdchg"  => "",
            "usertipo"     => "",
        );
    }

    static public function getFeature($fncod)
    {
        $sqlstr = "SELECT * from funciones where fncod=:fncod;";
        $featuresList = self::obtenerRegistros($sqlstr, array("fncod"=>$fncod));
        return count($featuresList) > 0;
    }

    static public function addNewFeature($fncod, $fndsc, $fnest, $fntyp )
    {
        $sqlins = "INSERT INTO `funciones` (`fncod`, `fndsc`, `fnest`, `fntyp`)
            VALUES (:fncod , :fndsc , :fnest , :fntyp );";

        return self::executeNonQuery(
            $sqlins,
            array(
                "fncod" => $fncod,
                "fndsc" => $fndsc,
                "fnest" => $fnest,
                "fntyp" => $fntyp
            )
        );
    }

    static public function getFeatureByUsuario($userCod, $fncod)
    {
        $sqlstr = "select * from
        funciones_roles a inner join roles_usuarios b on a.rolescod = b.rolescod
        where a.fnrrolesest= 'ACT' and b.rolesest='ACT' and b.usercod=:usercod
        and a.fncod=:fncod limit 1;";
        $resultados = self::obtenerRegistros(
            $sqlstr,
            array(
                "usercod"=> $userCod,
                "fncod" => $fncod
            )
        );
        return count($resultados) > 0;
    }

    static public function getRol($rolescod)
    {
        $sqlstr = "SELECT * from roles where rolescod=:rolescod;";
        $featuresList = self::obtenerRegistros($sqlstr, array("rolescod" => $rolescod));
        return count($featuresList) > 0;
    }

    static public function addNewRol($rolescod, $rolesdsc, $rolesest)
    {
        $sqlins = "INSERT INTO `roles` (`rolescod`, `rolesdsc`, `rolesest`)
        VALUES (:rolescod, :rolesdsc, :rolesest);";

        return self::executeNonQuery(
            $sqlins,
            array(
                "rolescod" => $rolescod,
                "rolesdsc" => $rolesdsc,
                "rolesest" => $rolesest
            )
        );
    }

    static public function getRolesByUsuario($usercod, $rolescod)
    {
        $sqlstr = "SELECT * FROM roles a INNER JOIN roles_usuarios b ON a.rolescod = b.rolescod WHERE a.rolesest = 'ACT'
        AND b.usercod=:usercod AND a.rolescod=:rolescod LIMIT 1;";
        $resultados = self::obtenerRegistros(
            $sqlstr, 
            array(
                "usercod"=>$usercod,
                "rolescod"=>$rolescod
            )
        );
        return count($resultados)>0;
    }

    static public function isUsuarioInRol($userCod, $rolescod)
    {
        $sqlstr = "select * from roles a inner join
        roles_usuarios b on a.rolescod = b.rolescod where a.rolesest = 'ACT'
        and b.usercod=:usercod and a.rolescod=:rolescod limit 1;";
        $resultados = self::obtenerRegistros(
            $sqlstr,
            array(
                "usercod" => $userCod,
                "rolescod" => $rolescod
            )
        );
        return count($resultados) > 0;
    }

    static public function getFuncionesByRolesUsuario($usertipo, $rolescod)
    {
        $sqlstr = "SELECT * FROM roles a INNER JOIN 
        roles_usuarios b ON a.rolescod = b.rolescod WHERE a.rolesest = 'ACT'
        AND b.usertipo=:usertipo AND a.rolescod=:rolescod LIMIT 1;";
        $resultados = self::obtenerRegistros(
            $sqlstr,
            array(
                "usertipo" => $usertipo,
                "rolescod" => $rolescod
            )
        );
        return count($resultados) > 0;
    }

    static public function searchUsuarios($UsuarioBusqueda)
    {
        $sqlstr = "SELECT * FROM usuario WHERE useremail LIKE :UsuarioBusqueda
        OR username LIKE :UsuarioBusqueda OR userfching LIKE :UsuarioBusqueda 
        OR userpswdest LIKE :UsuarioBusqueda OR userpswdexp LIKE :UsuarioBusqueda 
        OR userest LIKE :UsuarioBusqueda OR usertipo LIKE :UsuarioBusqueda ORDER BY usertipo;";
        
        return self::obtenerRegistros($sqlstr, array("UsuarioBusqueda"=>"%".$UsuarioBusqueda."%"));
    }

    static public function removeRolFromUser($userCod, $rolescod)
    {
        $sqldel = "UPDATE roles_usuarios set roleuserest='INA' 
        where rolescod=:rolescod and usercod=:usercod;";
        return self::executeNonQuery(
            $sqldel,
            array("rolescod"=>$rolescod, "usercod"=>$userCod)
        );
    }

    static public function removeFeatureFromRol($fncod, $rolescod)
    {
        $sqldel = "UPDATE funciones_roles set roleuserest='INA'
        where fncod=:fncod and rolescod=:rolescod;";
        return self::executeNonQuery(
            $sqldel,
            array("fncod" => $fncod, "rolescod" => $rolescod)
        );
    }
    static public function getUnAssignedFeatures($rolescod)
    {
        
    }
    static public function getUnAssignedRoles($userCod)
    {

    }
    private function __construct()
    {
    }
    private function __clone()
    {
    }
}


?>