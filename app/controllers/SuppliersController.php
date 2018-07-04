<?php

/**
 * Suppliers controller
 *
 * @property object Security
 * @property object user
 * @property object supplier
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Matheus Rocha Vieira <matheusrv@email.com>
 */

class SuppliersController extends Controller{


    public function beforeAction(){

        parent::beforeAction();

        Config::setJsConfig('curPage', "suppliers");

        $action  = $this->request->param('action');
        $actions = ['create', 'update'];
        $this->Security->requirePost($actions);

        switch($action){
            case "create":
                $this->Security->config("form", [ 'fields' => ['title', 'description', 'email', 'website']]);
                break;
            case "update":
                $this->Security->config("form", [ 'fields' => ['supplier_id', 'title', 'description', 'email', 'website']]);
                break;
            case "delete":
                $this->Security->config("validateCsrfToken", true);
                $this->Security->config("form", [ 'fields' => ['supplier_id']]);
                break;
        }
    }

    /**
     * show suppliers page
     *
     */
    public function index(){

        // clear all notifications
        $this->user->clearNotifications(Session::getUserId(), $this->supplier->table);

        $pageNum  = $this->request->query("page");

        $this->view->renderWithLayouts(Config::get('VIEWS_PATH') . "layout/default/", Config::get('VIEWS_PATH') . 'suppliers/index.php', ['pageNum' => $pageNum]);
    }

    /**
     * view a supplier
     *
     * @param integer|string $supplierId
     * @return Response
     * @throws Exception
     */
    public function view($supplierId = 0){

        $supplierId = Encryption::decryptId($supplierId);

        if(!$this->supplier->exists($supplierId)){
            return $this->error(404);
        }

        Config::setJsConfig('curPage', ["suppliers", "products"]);
        Config::setJsConfig('supplierId', Encryption::encryptId($supplierId));

        $action  = $this->request->query('action');
        $this->view->renderWithLayouts(Config::get('VIEWS_PATH') . "layout/default/", Config::get('VIEWS_PATH') . 'suppliers/viewSupplier.php', ["action"=> $action, "supplierId" => $supplierId]);
    }

    /**
     * show new supplier form
     */
    public function newSupplier(){
        $this->view->renderWithLayouts(Config::get('VIEWS_PATH') . "layout/default/", Config::get('VIEWS_PATH') . 'suppliers/newSupplier.php');
    }

    /**
     * creates a new supplier
     *
     */
    public function create(){

        $title    = $this->request->data("title");
        $description  = $this->request->data("description");
        $email = $this->request->data("email");
        $website = $this->request->data("website");

        $result = $this->supplier->create(Session::getUserId(), $title, $description, $email, $website);

        if(!$result){
            Session::set('suppliers-errors', $this->supplier->errors());
        }else{
            Session::set('suppliers-success', "Supplier has been created");
        }

        return $this->redirector->root("Suppliers/newSupplier");
    }

    /**
     * update a supplier
     *
     */
    public function update(){

        $supplierId  = $this->request->data("supplier_id");
        $title   = $this->request->data("title");
        $description = $this->request->data("description");
        $email = $this->request->data("email");
        $website = $this->request->data("website");

        $supplierId = Encryption::decryptId($supplierId);

        if(!$this->supplier->exists($supplierId)){
            return $this->error(404);
        }

        $supplier = $this->supplier->update($supplierId, $title, $description, $email, $website);

        if(!$supplier){

            Session::set('suppliers-errors', $this->supplier->errors());
            return $this->redirector->root("Suppliers/View/" . urlencode(Encryption::encryptId($supplierId)) . "?action=update");

        }else{
            return $this->redirector->root("Suppliers/View/" . urlencode(Encryption::encryptId($supplierId)));
        }
    }

    public function delete($supplierId = 0){

        $supplierId = Encryption::decryptId($supplierId);

        if(!$this->supplier->exists($supplierId)){
            return $this->error(404);
        }

        $this->supplier->deleteById($supplierId);

        return $this->redirector->root("Suppliers");
    }

    public function isAuthorized(){

        $action = $this->request->param('action');
        $role = Session::getUserRole();
        $resource = "suppliers";

        // only for admins
        Permission::allow('admin', $resource, ['*']);

        // only for normal users
        Permission::allow('user', $resource, ['index', 'view', 'newSupplier', 'create']);
        Permission::allow('user', $resource, ['update', 'delete'], 'owner');

        $supplierId  = ($action === "delete")? $this->request->param("args")[0]: $this->request->data("supplier_id");
        if(!empty($supplierId)){
            $supplierId = Encryption::decryptId($supplierId);
        } 

        $config = [
            "user_id" => Session::getUserId(),
            "table" => "suppliers",
            "id" => $supplierId
        ];

        return Permission::check($role, $resource, $action, $config);
    }
}
