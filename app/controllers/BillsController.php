<?php

/**
 * Bills controller
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Matheus Rocha Vieira <matheusrv@email.com>
 */

class BillsController extends Controller{

    public function beforeAction(){

        parent::beforeAction();

        Config::setJsConfig('curPage', "bills");

        $action = $this->request->param('action');
        $actions = ['create', 'getUpdateForm', 'update', 'getById', 'delete'];
        $this->Security->requirePost($actions);

        switch($action){
            case "create":
                $this->Security->config("form", [ 'fields' => ['description']]);
                break;
            case "getUpdateForm":
                $this->Security->config("form", [ 'fields' => ['bills_id']]);
                break;
            case "update":
                $this->Security->config("form", [ 'fields' => ['bills_id', 'description']]);
                break;
            case "getById":
            case "delete":
                $this->Security->config("form", [ 'fields' => ['bills_id']]);
                break;
        }
    }

    public function index(){

        $this->user->clearNotifications(Session::getUserId(), $this->bills->table);

        $pageNum  = $this->request->query("page");

        $this->view->renderWithLayouts(Config::get('VIEWS_PATH') . "layout/default/", Config::get('VIEWS_PATH') . 'bills/index.php', ['pageNum' => $pageNum]);
    }

    public function create(){

        $description  = $this->request->data("description");

        $bills = $this->bills->create(Session::getUserId(), $description);

        if(!$bills){

            Session::set('bills-errors', $this->bills->errors());
            return $this->redirector->root("Bills");

        }else{

            return $this->redirector->root("Bills");
        }
    }

    public function getUpdateForm(){

        $billsId = Encryption::decryptIdWithDash($this->request->data("bills_id"));

        if(!$this->bills->exists($billsId)){
            return $this->error(404);
        }

        $bills = $this->bills->getById($billsId);

        $html = $this->view->render(Config::get('VIEWS_PATH') . 'bills/updateForm.php', array("bills" => $bills[0]));
        $this->view->renderJson(array("data" => $html));
    }

    public function update(){

        // Remember? each news bill has an id that looks like this: bill-51b2cfa
        $billsId = Encryption::decryptIdWithDash($this->request->data("bills_id"));
        $description    = $this->request->data("description");

        if(!$this->bills->exists($billsId)){
            return $this->error(404);
        }

        $bills = $this->bills->update($billsId, $description);
        if(!$bills){
            $this->view->renderErrors($this->bills->errors());
        }else{

            $html = $this->view->render(Config::get('VIEWS_PATH') . 'bills/bills.php', array("bills" => $bills));
            $this->view->renderJson(array("data" => $html));
        }
    }

    public function getById(){

        $billsId = Encryption::decryptIdWithDash($this->request->data("bills_id"));

        if(!$this->bills->exists($billsId)){
            return $this->error(404);
        }

        $bills = $this->bills->getById($billsId);

        $html = $this->view->render(Config::get('VIEWS_PATH') . 'bills/bills.php', array("bills" => $bills));
        $this->view->renderJson(array("data" => $html));
    }

    public function delete(){

        $billsId = Encryption::decryptIdWithDash($this->request->data("bills_id"));

        $this->bills->deleteById($billsId);
        $this->view->renderJson(array("success" => true));
    }

    public function isAuthorized(){

        $action = $this->request->param('action');
        $role = Session::getUserRole();
        $resource = "bills";

        // only for admins
        Permission::allow('admin', $resource, ['*']);

        // only for normal users
        Permission::allow('user', $resource, ['index', 'getById', 'create']);
        Permission::allow('user', $resource, ['update', 'delete', 'getUpdateForm'], 'owner');

        $billsId = $this->request->data("bills_id");
        if(!empty($billsId)){
            $billsId = Encryption::decryptIdWithDash($billsId);
        }

        $config = [
            "user_id" => Session::getUserId(),
            "table" => "bills",
            "id" => $billsId];

        return Permission::check($role, $resource, $action, $config);
    }

}
