<?php
/**
 * Product Class
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Matheus Rocha Vieira <matheusrv@email.com>
 */

class Product extends Model{

    /**
     * get all products of a supplier
     *
     * @access public
     * @param  array     $supplierId
     * @param  integer   $pageNum
     * @param  integer   $productsCreated
     * @return array    Associative array of the products, and Pagination Object(View More).
     *
     */
    public function getAll($supplierId, $pageNum = 1, $productsCreated = 0){

        // Only for products, We use $productsCreated
        // What's it? Whenever we create a product, It will be added in-place to the current products in current .php page,
        // So, we need to track of those were created, and skip them in the Pagination($offset & $totalCount).

        $options    = "WHERE products.supplier_id = :supplier_id ";
        $pagination = Pagination::pagination("products", $options, [":supplier_id" => $supplierId], $pageNum, $productsCreated);
        $offset     = $pagination->getOffset() + $productsCreated;
        $limit      = $pagination->perPage;

        $database   = Database::openConnection();
        $query  = "SELECT products.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, products.title, products.description, products.date, products.product_picture, products.price_range, products.delivery_days, products.delivery_mean ";
        $query .= "FROM users, suppliers, products ";
        $query .= "WHERE products.supplier_id = :supplier_id ";
        $query .= "AND suppliers.id = products.supplier_id ";
        $query .= "AND users.id = products.user_id ";
        $query .= "ORDER BY products.date DESC ";
        $query .= "LIMIT $limit OFFSET $offset";

        $database->prepare($query);
        $database->bindValue(':supplier_id', (int)$supplierId);
        $database->execute();
        $products = $database->fetchAllAssociative();

        // you can have supplier with no products yet!
        return array("products" => $products, "pagination" => $pagination);
    }

    /**
     * get product by Id
     *
     * @access public
     * @param  string   $productId
     * @return array    Array holds the data of the product
     *
     */
    public function getById($productId){

        $database = Database::openConnection();
        $query  = "SELECT products.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, products.title, products.description, products.date, products.product_picture, products.price_range, products.delivery_days, products.delivery_mean ";
        $query .= "FROM users, suppliers, products ";
        $query .= "WHERE products.id = :id ";
        $query .= "AND suppliers.id = products.supplier_id ";
        $query .= "AND users.id = products.user_id LIMIT 1";

        $database->prepare($query);
        $database->bindValue(':id', (int)$productId);
        $database->execute();

        $product = $database->fetchAllAssociative();
        return $product;
    }

    /**
     * create Product.
     *
     * @access public
     * @param  string $userId
     * @param  string $supplierId
     * @param string $title
     * @param  string $description
     * @param int $priceRange
     * @param int $deliveryDays
     * @return array    Array holds the created product
     * @throws Exception If product couldn't be created
     */
    public function create($userId, $supplierId, $title, $description, $priceRange, $deliveryDays){

        $validation = new Validation();
        if(!$validation->validate([
            'Title' => [$description, 'required|minLen(1)|maxLen(64)'],
            'Description' => [$description, 'required|minLen(1)|maxLen(300)'],
            'Price Range' => [$priceRange, 'required|minLen(1)|maxLen(11)'],
            'Delivery Days' => [$deliveryDays, 'required|minLen(1)|maxLen(11)']])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query = "INSERT INTO products (user_id, supplier_id, title, description, price_range, delivery_days) VALUES (:user_id, :supplier_id, :title, :description, :price_range, :delivery_days)";

        $database->prepare($query);
        $database->bindValue(':user_id', $userId);
        $database->bindValue(':supplier_id', $supplierId);
        $database->bindValue(':title', $title);
        $database->bindValue(':description', $description);
        $database->bindValue(':price_range', $priceRange);
        $database->bindValue(':delivery_days', $deliveryDays);
        $database->execute();

        if($database->countRows() !== 1){
            throw new Exception ("Couldn't add product");
        }

        $productId = $database->lastInsertedId();
        $product = $this->getById($productId);
        return $product;
    }

    /**
     * update Product
     *
     * @access public
     * @param  string $productId
     * @param $title
     * @param  string $description
     * @param int $priceRange
     * @param int $deliveryDays
     * @return array    Array holds the updated product
     * @throws Exception If product couldn't be updated
     */
    public function update($productId, $title, $description, $priceRange, $deliveryDays){

        $validation = new Validation();
        if(!$validation->validate([
            'Description' => [$description, 'required|minLen(1)|maxLen(300)'],
            'Price Range' => [$priceRange, 'required|minLen(1)|maxLen(11)'],
            'Delivery Days' => [$deliveryDays, 'required|minLen(1)|maxLen(11)']])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query = "UPDATE products SET title = :title, description = :description, price_range = :price_range, delivery_days = :delivery_days WHERE id = :id LIMIT 1 ";
        $database->prepare($query);
        $database->bindValue(':title', $title);
        $database->bindValue(':description', $description);
        $database->bindValue(':price_range', $priceRange);
        $database->bindValue(':delivery_days', $deliveryDays);
        $database->bindValue(':id', $productId);
        $result = $database->execute();

        if(!$result){
            throw new Exception("Couldn't update product of ID: " . $productId);
        }

        $product = $this->getById($productId);
        return $product;
    }

     /**
      * counting the number of products of a supplier.
      *
      * @access public
      * @static static  method
      * @param  string  $supplierId
      * @return integer number of products
      *
      */
    public static function countProducts($supplierId){

        $database = Database::openConnection();
        $database->prepare("SELECT COUNT(*) AS count FROM products WHERE supplier_id = :supplier_id");
        $database->bindValue(":supplier_id", $supplierId);
        $database->execute();

        return (int)$database->fetchAssociative()["count"];
    }

}