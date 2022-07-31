<?php 

namespace Controllers\Admin;

class Rol extends \Controllers\PrivateController
{
    public function __construct()
    {
        /*
        $userInRole = \Utilities\Security::isInRol(
            \Utilities\Security::getUserId(),
            "ADMINISTRADOR"
        );
        */
        
        parent::__construct();
    }
    
    private $rolescod = "";
    private $rolesdsc = "";
    private $rolesest = "";
    private $rolesest_ACT = "";
    private $rolesest_INA = "";

    private $mode_dsc = "";
    private $mode_adsc = array(
        "INS" => "Nuevo Rol",
        "UPD" => "Editar Código: %s Descripción: %s",
        "DEL" => "Eliminar Código: %s Descripción: %s",
        "DSP" => "Visualizar Código: %s Descripción: %s"
    );

    private $notDisplayIns = false;
    private $readonly = "";
    private $showaction= true;

    private $hasErrors = false;
    private $aErrors = array();

    public function run() :void
    {

        $this->mode = isset($_GET["mode"])?$_GET["mode"]:"";
        $this->rolescod = isset($_GET["rolescod"])?$_GET["rolescod"]:"";

        if (!$this->isPostBack()) 
        {
            if ($this->mode !== "INS") 
            {
                $this->_load();
            } 
            else 
            {
                $this->mode_dsc = $this->mode_adsc[$this->mode];
            }
        } 
        else 
        {
            $this->_loadPostData();
            if (!$this->hasErrors) 
            {
                switch ($this->mode)
                {
                    case "INS":
                        if (\Dao\Admin\Roles::insert($this->rolesdsc)) {
                            \Utilities\Site::redirectToWithMsg(
                                "index.php?page=admin_roles",
                                "¡Rol Agregado Satisfactoriamente!"
                            );
                        }
                    break;

                    case "UPD":
                        if (\Dao\Admin\Roles::update($this->rolesdsc, $this->rolesest, $this->rolescod)) {
                            \Utilities\Site::redirectToWithMsg(
                                "index.php?page=admin_roles",
                                "¡Rol Actualizado Satisfactoriamente!"
                            );
                        }
                    break;

                    case "DEL":
                        if (\Dao\Admin\Roles::delete($this->rolescod)) {
                            \Utilities\Site::redirectToWithMsg(
                                "index.php?page=admin_roles",
                                "¡Rol Eliminado Satisfactoriamente!"
                            );
                        }
                    break;
                }
            }
        }

        $dataview = get_object_vars($this);
        \Views\Renderer::render("admin/rol", $dataview);
    }

    private function _load()
    {
        $_data = \Dao\Admin\Roles::getOne($this->rolescod);
        if ($_data) 
        {
            $this->rolescod = $_data["rolescod"];
            $this->rolesdsc = $_data["rolesdsc"];
            $this->rolesest = $_data["rolesest"];
            $this->_setViewData();
        }
    }

    private function _loadPostData()
    {
        $this->rolescod = isset($_POST["rolescod"]) ? $_POST["rolescod"] : "" ;
        $this->rolesdsc = isset($_POST["rolesdsc"]) ? $_POST["rolesdsc"] : "" ;
        $this->rolesest = isset($_POST["rolesest"]) ? $_POST["rolesest"] : "" ;

        //validaciones
        //aplicar todas la reglas de negocio

        if (\Utilities\Validators::IsEmpty($this->rolesdsc)) 
        {
            $this->aErrors[] = "La descripción del rol no puede ir vacía.";
        }

        if($this->mode=="INS")
        {
            if(!empty(\Dao\Admin\Roles::getOne(strtoupper($this->rolesdsc))))
            {
                $this->aErrors[] = "El rol ya se encuentra ingresado";
            }
        }

        $this->hasErrors = (count($this->aErrors) > 0);
        $this->_setViewData();
    }

    private function _setViewData()
    {
        $this->rolesest_ACT = ($this->rolesest === "ACT") ? "selected" : "";
        $this->rolesest_INA = ($this->rolesest === "INA") ? "selected" : "";
        $this->mode_dsc = sprintf(
            $this->mode_adsc[$this->mode],
            $this->rolescod,
            $this->rolesdsc
        );

        $this->notDisplayIns = ($this->mode=="INS") ? false : true;
        $this->readonly = ($this->mode =="DEL" || $this->mode=="DSP") ? "readonly":"";
        $this->showaction = !($this->mode == "DSP");
    }
}

?>