<?php
namespace Dao\Mnt;
use Dao\Security\Estados;

class Roles extends \Dao\Table
{
    public static function getAll()
    {
        return self::obtenerRegistros("SELECT * FROM roles;", array());
    }

    public static function getOne($rolescod)
    {
        $sqlstr = "SELECT * FROM roles WHERE rolescod=:rolescod";
        return self::obtenerUnRegistro(
            $sqlstr, 
            array(
                "rolescod"=>$rolescod
            )
        );
    }

    public static function insert($rolesdsc)
    {
        $insstr = "INSERT INTO roles (rolescod, rolesdsc, rolesest) VALUES (:rolescod, :rolesdsc, :rolesest);";
        return self::executeNonQuery(
            $insstr,
            array(
                "rolescod"=>strtoupper($rolesdsc),
                "rolesdsc"=>$rolesdsc,
                "rolesest"=>Estados::ACT
            )
        );
    }

    public static function update($rolescod,$rolesdsc,$rolesest)
    {
        $updsql = "UPDATE roles SET rolesdsc=:rolesdsc, rolesest=:rolesest WHERE rolescod=:rolescod;";
        return self:: executeNonQuery(
            $updsql,
            array(
                "rolesdsc"=>$rolesdsc,
                "rolesest"=>$rolesest,
                "rolescod"=>$rolescod
            )
        );
    }

    public static function delete($rolescod)
    {
        $delsql = "DELETE FROM roles WHERE rolescod=:rolescod;";
        return self::executeNonQuery(
            $delsql,
            array(
                "rolescod"=>$rolescod
            )
        );
    }

    public static function searchRoles($UsuariosBusqueda)
    {
        $sqlstr = "SELECT * FROM roles WHERE rolescod LIKE :UsuariosBusqueda OR rolesdsc LIKE :UsuarioBusqueda
        OR rolesest LIKE :UsuarioBusqueda;";
        return self::obtenerRegistros($sqlstr, array("UsuarioBusqueda"=>"%".$UsuarioBusqueda."%"));
    }
}
?>