<?php

 /**
  * Supplier Class
  *
  * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
  * @author     Matheus Rocha Vieira <matheusrv@email.com>
  */

 class Supplier extends Model{

     /**
      * get all suppliers
      *
      * @access public
      * @param  integer  $pageNum
      * @return array    Associative array of the suppliers, and Pagination Object.
      *
      */
     public function getAll($pageNum = 1){

         $pagination = Pagination::pagination("suppliers", "", [], $pageNum);
         $offset     = $pagination->getOffset();
         $limit      = $pagination->perPage;

         $database   = Database::openConnection();
         $query  = "SELECT suppliers.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, suppliers.title, suppliers.description, suppliers.date ";
         $query .= "FROM users, suppliers ";
         $query .= "WHERE users.id = suppliers.user_id ";
         $query .= "ORDER BY suppliers.date DESC ";
         $query .= "LIMIT $limit OFFSET $offset";

         $database->prepare($query);
         $database->execute();
         $suppliers = $database->fetchAllAssociative();

         $this->appendNumberOfProducts($suppliers, $database);

         return array("suppliers" => $suppliers, "pagination" => $pagination);
     }

     /**
      * append number of products to the array of suppliers for each supplier.
      *
      * @access private
      * @param  array
      *
      */
     private function appendNumberOfProducts(&$suppliers){

         $supplierId = 0;
         $database = Database::openConnection();

         $query  = "SELECT COUNT(*) AS products FROM products WHERE supplier_id = :supplier_id ";
         $database->prepare($query);
         $database->bindParam(':supplier_id', $supplierId);

         foreach($suppliers as $key => $supplier){
             $supplierId = (int)$suppliers[$key]["id"];
             $database->execute();
             $suppliers[$key]["products"] = $database->fetchAssociative()["products"];
         }
     }

     /**
      * get supplier by Id.
      *
      * @access public
      * @param  integer  $supplierId
      * @return array    Array holds the data of the supplier
      */
     public function getById($supplierId){

         $database = Database::openConnection();
         $query  = "SELECT suppliers.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, suppliers.title, suppliers.description, suppliers.email, suppliers.website, suppliers.date ";
         $query .= "FROM users, suppliers ";
         $query .= "WHERE suppliers.id = :id ";
         $query .= "AND users.id = suppliers.user_id LIMIT 1 ";

         $database->prepare($query);
         $database->bindValue(':id', $supplierId);
         $database->execute();

         $supplier = $database->fetchAssociative();
         return $supplier;
     }

     /**
      * create supplier
      *
      * @access public
      * @param  integer $userId
      * @param  string $title
      * @param  string $description
      * @param $email
      * @param $website
      * @return bool
      * @throws Exception If supplier couldn't be created
      */
     public function create($userId, $title, $description, $email, $website){

         $validation = new Validation();
         if(!$validation->validate([
             'Title'   => [$title, "required|minLen(2)|maxLen(60)"],
             'Description'   => [$description, "required|minLen(4)|maxLen(1800)"],
             'Email'   => [$email, "required|minLen(2)|maxLen(64)"],
             'Website'   => [$website, "required|minLen(2)|maxLen(48)"]])) {
             $this->errors = $validation->errors();
             return false;
         }

         $database = Database::openConnection();
         $query    = "INSERT INTO suppliers (user_id, title, description, email, website) VALUES (:user_id, :title, :description, :email, :website)";

         $database->prepare($query);
         $database->bindValue(':user_id', $userId);
         $database->bindValue(':title', $title);
         $database->bindValue(':description', $description);
         $database->bindValue(':email', $email);
         $database->bindValue(':website', $website);
         $database->execute();

         if($database->countRows() !== 1){
             throw new Exception ("Couldn't add budgets");
         }

         return true;
     }

     /**
      * update Supplier
      *
      * @access public
      * @static static method
      * @param  string $supplierId
      * @param  string $title
      * @param  string $description
      * @param $email
      * @param $website
      * @return array     Array of the updated supplier
      * @throws Exception If supplier couldn't be updated
      */
     public function update($supplierId, $title, $description, $email, $website){

         $validation = new Validation();
         if(!$validation->validate([
             'Title'   => [$title, "required|minLen(2)|maxLen(60)"],
             'Description' => [$description, "required|minLen(4)|maxLen(1800)"],
             'Email'   => [$email, "required|minLen(2)|maxLen(64)"],
             'Website'   => [$website, "required|minLen(2)|maxLen(48)"]])) {
             $this->errors = $validation->errors();
             return false;
         }

         $database = Database::openConnection();
         $query = "UPDATE suppliers SET title = :title, description = :description, email = :email, website = :website WHERE id = :id LIMIT 1";

         $database->prepare($query);
         $database->bindValue(':title', $title);
         $database->bindValue(':description', $description);
         $database->bindValue(':email', $email);
         $database->bindValue(':website', $website);
         $database->bindValue(':id', $supplierId);
         $result = $database->execute();

         if(!$result){
             throw new Exception("Couldn't update supplier of ID: " . $supplierId);
         }

         $supplier = $this->getById($supplierId);
         return $supplier;
     }

 }
