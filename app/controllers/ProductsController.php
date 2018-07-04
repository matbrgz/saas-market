<?php

/**
 * The products controller
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Matheus Rocha Vieira <matheusrv@email.com>
 */

class ProductsController extends Controller{

    public function beforeAction(){

        parent::beforeAction();

        $action = $this->request->param('action');
        $actions = ['getAll', 'create', 'getUpdateForm', 'update', 'getById', 'delete'];
        $this->Security->requireAjax($actions);
        $this->Security->requirePost($actions);

        switch($action){
            case "getAll":
                $this->Security->config("form", [ 'fields' => ['supplier_id', 'page', 'products_created']]);
                break;
            case "create":
                $this->Security->config("form", [ 'fields' => ['supplier_id', 'title', 'description', 'price_range', 'delivery_days']]);
                break;
            case "getUpdateForm":
                $this->Security->config("form", [ 'fields' => ['product_id']]);
                break;
            case "update":
                $this->Security->config("form", [ 'fields' => ['product_id', 'title','description', 'price_range', 'delivery_days']]);
                break;
            case "getById":
            case "delete":
                $this->Security->config("form", [ 'fields' => ['product_id']]);
                break;
        }
    }

    /**
     * get all products
     *
     */
    public function getAll(){

        $supplierId = Encryption::decryptId($this->request->data("supplier_id"));

        $pageNum         = $this->request->data("page");
        $productsCreated = (int)$this->request->data("products_created");

        $productsData = $this->product->getAll($supplierId, $pageNum, $productsCreated);

        $productsHTML   = $this->view->render(Config::get('VIEWS_PATH') . 'suppliers/products.php', array("products" => $productsData["products"]));
        $paginationHTML = $this->view->render(Config::get('VIEWS_PATH') . 'pagination/products.php', array("pagination" => $productsData["pagination"]));

        $this->view->renderJson(array("data" => ["products" => $productsHTML, "pagination" => $paginationHTML]));
    }

    public function create(){

        $supplierId = Encryption::decryptId($this->request->data("supplier_id"));
        $title  = $this->request->data("title");
        $description  = $this->request->data("description");
        $priceRange  = $this->request->data("price_range");
        $deliveryDays  = $this->request->data("delivery_days");
        $product = $this->product->create(Session::getUserId(), $supplierId, $title, $description, $priceRange, $deliveryDays);

        if(!$product){
            $this->view->renderErrors($this->product->errors());
        }else{

            $html = $this->view->render(Config::get('VIEWS_PATH') . 'suppliers/products.php', array("products" => $product));
            $this->view->renderJson(array("data" => $html));
        }
    }

    /**
     * whenever the user hits 'edit' button,
     * a request will be sent to get the update form of that product,
     * so that the user can 'update' or even 'cancel' the edit request.
     *
     */
    public function getUpdateForm(){

        $productId = Encryption::decryptIdWithDash($this->request->data("product_id"));

        if(!$this->product->exists($productId)){
            return $this->error(404);
        }

        $product = $this->product->getById($productId);

        $productsHTML = $this->view->render(Config::get('VIEWS_PATH') . 'suppliers/productUpdateForm.php', array("product" => $product[0]));
        $this->view->renderJson(array("data" => $productsHTML));
    }

    /**
     * update product
     *
     */
    public function update(){

        $productId = Encryption::decryptIdWithDash($this->request->data("product_id"));
        $title  = $this->request->data("title");
        $description  = $this->request->data("description");
        $priceRange  = $this->request->data("price_range");
        $deliveryDays  = $this->request->data("delivery_days");

        if(!$this->product->exists($productId)){
            return $this->error(404);
        }

        $product = $this->product->update($productId, $title, $description, $priceRange, $deliveryDays);

        if(!$product){
            $this->view->renderErrors($this->product->errors());
        }else{

            $html = $this->view->render(Config::get('VIEWS_PATH') . 'suppliers/products.php', array("products" => $product));
            $this->view->renderJson(array("data" => $html));
        }
    }

    /**
     * get product by Id
     *
     */
    public function getById(){

        $productId = Encryption::decryptIdWithDash($this->request->data("product_id"));

        if(!$this->product->exists($productId)){
            return $this->error(404);
        }

        $product = $this->product->getById($productId);

        $productsHTML = $this->view->render(Config::get('VIEWS_PATH') . 'suppliers/products.php', array("products" => $product));
        $this->view->renderJson(array("data" => $productsHTML));
    }

    public function delete(){

        $productId = Encryption::decryptIdWithDash($this->request->data("product_id"));

        if(!$this->product->exists($productId)){
            return $this->error(404);
        }

        $this->product->deleteById($productId);

        $this->view->renderJson(array("success" => true));
    }

    public function isAuthorized(){

        $action = $this->request->param('action');
        $role = Session::getUserRole();
        $resource = "products";

        // only for admins
        Permission::allow('admin', $resource, ['*']);

        // only for normal users
        Permission::allow('user', $resource, ['getAll', 'getById', 'create']);
        Permission::allow('user', $resource, ['update', 'delete', 'getUpdateForm'], 'owner');

        $productId = $this->request->data("product_id");
        if(!empty($productId)){
            $productId = Encryption::decryptIdWithDash($productId);
        }

        $config = [
            "user_id" => Session::getUserId(),
            "table" => "products",
            "id" => $productId];

        return Permission::check($role, $resource, $action, $config);
    }
}
