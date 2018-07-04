<?php

/**
 * Budgets controller
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Matheus Rocha Vieira <matheusrv@email.com>
 */

class BudgetsController extends Controller{

    public function beforeAction(){

        parent::beforeAction();

        Config::setJsConfig('curPage', "budgets");

        $action = $this->request->param('action');
        $actions = ['create', 'getUpdateForm', 'update', 'getById', 'delete'];
        $this->Security->requirePost($actions);

        switch($action){
            case "create":
                $this->Security->config("form", [ 'fields' => ['description']]);
                break;
            case "getUpdateForm":
                $this->Security->config("form", [ 'fields' => ['budgets_id']]);
                break;
            case "update":
                $this->Security->config("form", [ 'fields' => ['budgets_id', 'description']]);
                break;
            case "getById":
            case "delete":
                $this->Security->config("form", [ 'fields' => ['budgets_id']]);
                break;
        }
    }

    public function index(){

        $this->user->clearNotifications(Session::getUserId(), $this->budgets->table);

        $pageNum  = $this->request->query("page");

        $this->view->renderWithLayouts(Config::get('VIEWS_PATH') . "layout/default/", Config::get('VIEWS_PATH') . 'budgets/index.php', ['pageNum' => $pageNum]);
    }

    public function create(){

        $description  = $this->request->data("description");

        $budgets = $this->budgets->create(Session::getUserId(), $description);

        if(!$budgets){

            Session::set('budgets-errors', $this->budgets->errors());
            return $this->redirector->root("Budgets");

        }else{

            return $this->redirector->root("Budgets");
        }
    }

    public function getUpdateForm(){

        $budgetsId = Encryption::decryptIdWithDash($this->request->data("budgets_id"));

        if(!$this->budgets->exists($budgetsId)){
            return $this->error(404);
        }

        $budgets = $this->budgets->getById($budgetsId);

        $html = $this->view->render(Config::get('VIEWS_PATH') . 'budgets/updateForm.php', array("budgets" => $budgets[0]));
        $this->view->renderJson(array("data" => $html));
    }

    public function update(){

        // Remember? each budget has an id that looks like this: budget-51b2cfa
        $budgetsId = Encryption::decryptIdWithDash($this->request->data("budgets_id"));
        $description    = $this->request->data("description");

        if(!$this->budgets->exists($budgetsId)){
            return $this->error(404);
        }

        $budgets = $this->budgets->update($budgetsId, $description);
        if(!$budgets){
            $this->view->renderErrors($this->budgets->errors());
        }else{

            $html = $this->view->render(Config::get('VIEWS_PATH') . 'budgets/budgets.php', array("budgets" => $budgets));
            $this->view->renderJson(array("data" => $html));
        }
    }

    public function getById(){

        $budgetsId = Encryption::decryptIdWithDash($this->request->data("budgets_id"));

        if(!$this->budgets->exists($budgetsId)){
            return $this->error(404);
        }

        $budgets = $this->budgets->getById($budgetsId);

        $html = $this->view->render(Config::get('VIEWS_PATH') . 'budgets/budgets.php', array("budgets" => $budgets));
        $this->view->renderJson(array("data" => $html));
    }

    public function delete(){

        $budgetsId = Encryption::decryptIdWithDash($this->request->data("budgets_id"));

        $this->budgets->deleteById($budgetsId);
        $this->view->renderJson(array("success" => true));
    }

    public function isAuthorized(){

        $action = $this->request->param('action');
        $role = Session::getUserRole();
        $resource = "budgets";

        // only for admins
        Permission::allow('admin', $resource, ['*']);

        // only for normal users
        Permission::allow('user', $resource, ['index', 'getById', 'create']);
        Permission::allow('user', $resource, ['update', 'delete', 'getUpdateForm'], 'owner');

        $budgetsId = $this->request->data("budgets_id");
        if(!empty($budgetsId)){
            $budgetsId = Encryption::decryptIdWithDash($budgetsId);
        }

        $config = [
            "user_id" => Session::getUserId(),
            "table" => "budgets",
            "id" => $budgetsId];

        return Permission::check($role, $resource, $action, $config);
    }

}
