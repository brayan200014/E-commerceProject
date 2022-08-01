<?php
namespace Controllers\Admin;
use Dao\Admin\funciones as DaoFN; 

class Funciones extends \Controllers\PrivateController
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // $userInRole = \Utilities\Security::isInRol(
        //     \Utilities\Security::getUserId(),
        //     "ADMIN"
        // );
        parent::__construct();
    }
    /** 
     * Ejecuta el controlador
     */
    public function run() :void
    {
        $viewData= array();
        $viewData["Funciones"]= DaoFN::getAll();
        \Views\Renderer::render("admin/funciones", $viewData);
    }
}
?>
