<?php 

namespace Controllers\Admin;

use Views\Renderer;
use Dao\Admin\Usuarios as DaoUsuarios;

class Usuarios extends \Controllers\PrivateController {
    public function run():void{
        $viewData = array();
        $viewData["Usuarios"] = DaoUsuarios::getAll();
        Renderer::render('admin/usuarios', $viewData);
    }
}
?>