<?php
namespace Controllers\Admin;
class Usuarios extends \Controllers\PrivateController
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

    private $usercod = 0;
    private $useremail = "";
    private $username = "";
    private $userpswd = "";
    private $userfching = "";
    private $userpswdest = "";
    private $userpswdexp = "";
    private $userest = "";
    private $useractcod = "";
    private $userpswdchg = "";
    private $usertipo = "";
    private $userest_ACT = "";
    private $userest_INA = "";
    //publico, administrador, auditor
    private $usertipo_PBL = "";
    private $usertipo_ADM = "";
    private $usertipo_AUD = "";

    private $mode = "";
    private $mode_dsc = "";
    private $mode_adsc = array(
        "INS" => "Nuevo Usuario",
        "UPD" => "Editar Código: %s Nombre: %s",
        "DEL" => "Eliminar Código: %s Nombre: %s",
        "DSP" => "Visualizar Código: %s Nombre: %s"
    );

    private $notDisplayIns = false;
    private $allInfoDisplayed = false;
    private $disabled = "";
    private $readonly = "";
    private $showaction= true;

    private $hasErrors = false;
    private $aErrors = array();

    private $updPswd = false;

    public function run() :void
    {
        $this->mode = isset($_GET["mode"])?$_GET["mode"]:"";
        $this->usercod = isset($_GET["usercod"])?$_GET["usercod"]:"";
        if(!$this->isPostBack())
        {
            if($this->mode!=="INS")
            {
                $this->_load();
            }else{
                $this->mode_dsc=$this->mode_adsc[$this->mode];
            }
        }
        else{
            $this->_loadPastData();
            if(!$this->hasErrors){
                switch($this->mode){
                    case"INS":
                        if(\Dao\Security\Security::insertUsuarioFromAdmin($this->useremail, $this->username, $this->userpswd, $this->usertipo))
                        {
                            \Utilities\Site::redirectToWithMsg(
                                "index.php?page=admin_usuarios",
                                "¡Usuario Agregado Satisfactoriamente!"
                            );
                        }
                        break;
                    case"UPD":
                        if(!$this->updPswd)
                        {
                            if (\Dao\Security\Security::updateUsuarioAdmin($this->usercod, $this->useremail, $this->username, $this->userest, $this->usertipo)) 
                            {
                                \Utilities\Site::redirectToWithMsg(
                                    "index.php?page=admin_usuarios",
                                    "¡Usuario Actualizado Satisfactoriamente!"
                                );
                            }
                        }
                        else
                        {
                            if (\Dao\Security\Security::updateUsuarioWithPswdAdmin($this->usercod, $this->useremail, $this->username, $this->userpswd, 
                            $this->userest, $this->usertipo)) 
                            {
                                \Utilities\Site::redirectToWithMsg(
                                    "index.php?page=admin_usuarios",
                                    "¡Usuario Actualizado Satisfactoriamente!"
                                );
                            }
                        }
                        
                    break;
                    case"DEL":
                        if(\Dao\Security\Security::deleteUsuarioAdmin($this->usercod)){
                            \Utilities\Site::redirectToWithMsg(
                                "index.php?page=admin_usuarios",
                                "¡Usuario Eliminado Satisfactoriamente!"
                            );
                        }
                    break;
                }
            }
        }
        $dataview = get_object_vars($this);
        \Views\Renderer::render("admin/usuario", $dataview);
    }

    private function _load()
    {
        $_data = \Dao\Security\Security::getUsuariobyId($this->usercod);
        if($_data)
        {
            $this->usercod = $_data["usercod"];
            $this->useremail = $_data["useremail"];
            $this->username = $_data["username"];
            $this->userfching = $_data["userfching"];
            $this->userpswdest = $_data["userpswdest"];
            $this->userpswdexp = $_data["userpswdexp"];
            $this->userest = $_data["userest"];
            $this->useractcod = $_data["useractcod"];
            $this->userpswdchg = $_data["userpswdchg"];
            $this->usertipo = $_data["usertipo"];
            $this->_setViewData();
        }
    }

    private function _loadPostData()
    {
        $this->usercod = isset($_POST["usercod"]) ? $_POST["usercod"] : 0 ;
        $this->useremail = isset($_POST["useremail"]) ? $_POST["useremail"] : "" ;
        $this->username = isset($_POST["username"]) ? $_POST["username"] : "";
        $this->userpswd = isset($_POST["userpswd"]) ? $_POST["userpswd"] : "";
        $this->userest = isset($_POST["userest"]) ? $_POST["userest"] : "";
        $this->usertipo = isset($_POST["usertipo"]) ? $_POST["usertipo"] : "";

        if (\Utilities\Validators::IsEmpty($this->useremail)) 
        {
            $this->aErrors[] = "El correo no puede ir vacio";
        }

        if (!\Utilities\Validators::IsValidEmail($this->useremail)) 
        {
            $this->aErrors[] = "El correo no es válido";
        }

        if(\Utilities\Validators::IsEmpty($this->username))
        {
            $this->aErrors[] = "El nombre no puede ir vacio";
        }

        if(!(\Utilities\Validators::ValidarSoloLetras($this->username)))
        {
            $this->aErrors[] = "El nombre no es válido.";
        }

        if($this->mode == "INS")
        {
            if (\Utilities\Validators::IsEmpty($this->userpswd)) 
            {
                $this->aErrors[] = "La contraseña no puede ir vacia";
            }

            if (!\Utilities\Validators::IsValidPassword($this->userpswd)) 
            {
                $this->aErrors[] = "La contraseña debe contener almenos 8 caracteres, 1 número, 1 mayúscula y 1 símbolo especial";
            }

            if(!empty(\Dao\Security\Security::getUsuarioByEmail($this->useremail)))
            {
                $this->aErrors[] = "El correo proporcionado ya se encuentra ingresado.";
            }
        }

        if($this->mode == "UPD")
        {
            if(!empty(\Dao\Security\Security::getUsuarioDifferbyEmail($this->usercod, $this->useremail)))
            {
                $this->aErrors[] = "El correo proporcionado ya se encuentra ingresado.";
            }

            if(!empty($this->userpswd))
            {
                if (!\Utilities\Validators::IsValidPassword($this->userpswd)) 
                {
                    $this->aErrors[] = "La contraseña debe contener almenos 8 caracteres, 1 número, 1 mayúscula y 1 símbolo especial";
                }

                $this->updPswd = true;
            }
        }

        $this->hasErrors = (count($this->aErrors) > 0);
        $this->_setViewData();
    }

    private function _setViewData()
    {
        $this->usuarioest_ACT = ($this->usuarioest === "ACT") ? "selected" : "";
        $this->usuarioest_INA = ($this->usuarioest === "INA") ? "selected" : "";

        $this->usuariotipo_ADM = ($this->usuariotipo === "ADM") ? "selected" : "";
        $this->usuariotipo_AUD = ($this->usuariotipo === "AUD") ? "selected" : "";
        $this->usuariotipo_PBL = ($this->usuariotipo === "PBL") ? "selected" : "";

        $this->mode_dsc = sprintf(
            $this->mode_adsc[$this->mode],
            $this->usercod,
            $this->username,
        );

        $this->notDisplayIns = ($this->mode=="INS") ? false : true;
        $this->disabled = ($this->mode == "INS" || $this->mode =="DEL" || $this->mode =="DSP") ? "disabled" : "";
        $this->readonly = ($this->mode =="DEL" || $this->mode=="DSP") ? "readonly" : "";
        $this->allInfoDisplayed = ($this->mode =="DEL" || $this->mode=="DSP") ? true : false;
        $this->showaction = !($this->mode == "DSP");
    }
}
?>