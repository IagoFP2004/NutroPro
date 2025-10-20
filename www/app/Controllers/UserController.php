<?php

namespace Com\Daw2\Controllers;

use Com\Daw2\Core\BaseController;

class UserController extends BaseController
{
 public function showLoginForm():void
 {
     $this->view->show('login.view.php');
 }
}