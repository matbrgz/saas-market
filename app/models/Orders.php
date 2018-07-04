<?php

 /**
  * Orders Class
  *
  * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
  * @author     Matheus Rocha Vieira <matheusrv@email.com>
  */
class Orders extends Model{

    /**
     * get all order.
     *
     * @access public
     * @param  integer  $pageNum
     * @return array
     *
     */
    public function getAll($pageNum = 1){

        $pagination = Pagination::pagination("orders", "", [], $pageNum);
        $offset     = $pagination->getOffset();
        $limit      = $pagination->perPage;

        $database   = Database::openConnection();
        $query  = "SELECT orders.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, orders.description, orders.date_order ";
        $query .= "FROM users, orders ";
        $query .= "WHERE users.id = orders.user_id ";
        $query .= "ORDER BY orders.date_order DESC ";
        $query .= "LIMIT $limit OFFSET $offset";

        $database->prepare($query);
        $database->execute();
        $orders = $database->fetchAllAssociative();

        return array("orders" => $orders, "pagination" => $pagination);
     }

    /**
     * get order by Id.
     *
     * @param  string  $ordersId
     * @return array
      */
    public function getById($ordersId){

        $database = Database::openConnection();
        $query  = "SELECT orders.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, orders.description, orders.date_order ";
        $query .= "FROM users, orders ";
        $query .= "WHERE orders.id = :id ";
        $query .= "AND users.id = orders.user_id  LIMIT 1 ";

        $database->prepare($query);
        $database->bindValue(':id', (int)$ordersId);
        $database->execute();

        $order = $database->fetchAllAssociative();
        return $order;
     }

    /**
     * create order.
     *
     * @param  integer $userId
     * @param  string  $description
     * @return array order created
     * @throws Exception if order couldn't be created
     */
    public function create($userId, $description){

        $validation = new Validation();
        if(!$validation->validate(['Description'   => [$description, "required|minLen(4)|maxLen(300)"]])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query    = "INSERT INTO orders (user_id, description) VALUES (:user_id, :description)";

        $database->prepare($query);
        $database->bindValue(':user_id', $userId);
        $database->bindValue(':description', $description);
        $database->execute();

        if($database->countRows() !== 1){
            throw new Exception("Couldn't add a order");
        }

        $ordersId = $database->lastInsertedId();
        $order = $this->getById($ordersId);
        return $order;
     }

    /**
     * update order.
     *
     * @param  string  $ordersId
     * @param  string  $description
     * @return array   order created
     * @throws Exception if order couldn't be updated
     */
    public function update($ordersId, $description){

        $validation = new Validation();
        if(!$validation->validate(['Description'   => [$description, "required|minLen(4)|maxLen(300)"]])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query = "UPDATE orders SET description = :description WHERE id = :id LIMIT 1";

        $database->prepare($query);
        $database->bindValue(':description', $description);
        $database->bindValue(':id', $ordersId);
        $result = $database->execute();

        if(!$result){
            throw new Exception("Couldn't update orders of ID: " . $ordersId);
        }

        $order = $this->getById($ordersId);
        return $order;
     }

 }