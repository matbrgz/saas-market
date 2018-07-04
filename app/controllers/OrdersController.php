<?php

/**
 * Orders controller
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Matheus Rocha Vieira <matheusrv@email.com>
 */

class OrdersController extends Controller{

    public function beforeAction(){

        parent::beforeAction();

        Config::setJsConfig('curPage', "orders");

        $action = $this->request->param('action');
        $actions = ['create', 'getUpdateForm', 'update', 'getById', 'delete'];
        $this->Security->requirePost($actions);

        switch($action){
            case "create":
                $this->Security->config("form", [ 'fields' => ['description']]);
                break;
            case "getUpdateForm":
                $this->Security->config("form", [ 'fields' => ['orders_id']]);
                break;
            case "update":
                $this->Security->config("form", [ 'fields' => ['orders_id', 'description']]);
                break;
            case "getById":
            case "delete":
                $this->Security->config("form", [ 'fields' => ['orders_id']]);
                break;
        }
    }

    public function index(){

        $this->user->clearNotifications(Session::getUserId(), $this->orders->table);

        $pageNum  = $this->request->query("page");

        $this->view->renderWithLayouts(Config::get('VIEWS_PATH') . "layout/default/", Config::get('VIEWS_PATH') . 'orders/index.php', ['pageNum' => $pageNum]);
    }

    public function create(){

        $description  = $this->request->data("description");

        $orders = $this->orders->create(Session::getUserId(), $description);

        if(!$orders){

            Session::set('orders-errors', $this->orders->errors());
            return $this->redirector->root("Orders");

        }else{

            return $this->redirector->root("Orders");
        }
    }

    public function getUpdateForm(){

        $ordersId = Encryption::decryptIdWithDash($this->request->data("orders_id"));

        if(!$this->orders->exists($ordersId)){
            return $this->error(404);
        }

        $orders = $this->orders->getById($ordersId);

        $html = $this->view->render(Config::get('VIEWS_PATH') . 'orders/updateForm.php', array("orders" => $orders[0]));
        $this->view->renderJson(array("data" => $html));
    }

    public function update(){

        // Remember? each news order has an id that looks like this: order-51b2cfa
        $ordersId = Encryption::decryptIdWithDash($this->request->data("orders_id"));
        $description    = $this->request->data("description");

        if(!$this->orders->exists($ordersId)){
            return $this->error(404);
        }

        $orders = $this->orders->update($ordersId, $description);
        if(!$orders){
            $this->view->renderErrors($this->orders->errors());
        }else{

            $html = $this->view->render(Config::get('VIEWS_PATH') . 'orders/orders.php', array("orders" => $orders));
            $this->view->renderJson(array("data" => $html));
        }
    }

    public function getById(){

        $ordersId = Encryption::decryptIdWithDash($this->request->data("orders_id"));

        if(!$this->orders->exists($ordersId)){
            return $this->error(404);
        }

        $orders = $this->orders->getById($ordersId);

        $html = $this->view->render(Config::get('VIEWS_PATH') . 'orders/orders.php', array("orders" => $orders));
        $this->view->renderJson(array("data" => $html));
    }

    public function delete(){

        $ordersId = Encryption::decryptIdWithDash($this->request->data("orders_id"));

        $this->orders->deleteById($ordersId);
        $this->view->renderJson(array("success" => true));
    }

    public function isAuthorized(){

        $action = $this->request->param('action');
        $role = Session::getUserRole();
        $resource = "orders";

        // only for admins
        Permission::allow('admin', $resource, ['*']);

        // only for normal users
        Permission::allow('user', $resource, ['index', 'getById', 'create']);
        Permission::allow('user', $resource, ['update', 'delete', 'getUpdateForm'], 'owner');

        $ordersId = $this->request->data("orders_id");
        if(!empty($ordersId)){
            $ordersId = Encryption::decryptIdWithDash($ordersId);
        }

        $config = [
            "user_id" => Session::getUserId(),
            "table" => "orders",
            "id" => $ordersId];

        return Permission::check($role, $resource, $action, $config);
    }

}
