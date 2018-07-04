<?php

 /**
  * Bills Class
  *
  * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
  * @author     Matheus Rocha Vieira <matheusrv@email.com>
  */
class Bills extends Model{

    /**
     * get all bill.
     *
     * @access public
     * @param  integer  $pageNum
     * @return array
     *
     */
    public function getAll($pageNum = 1){

        $pagination = Pagination::pagination("bills", "", [], $pageNum);
        $offset     = $pagination->getOffset();
        $limit      = $pagination->perPage;

        $database   = Database::openConnection();
        $query  = "SELECT bills.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, bills.description, bills.date_bill ";
        $query .= "FROM users, bills ";
        $query .= "WHERE users.id = bills.user_id ";
        $query .= "BILL BY bills.date_bill DESC ";
        $query .= "LIMIT $limit OFFSET $offset";

        $database->prepare($query);
        $database->execute();
        $bills = $database->fetchAllAssociative();

        return array("bills" => $bills, "pagination" => $pagination);
     }

    /**
     * get bill by Id.
     *
     * @param  string  $billsId
     * @return array
      */
    public function getById($billsId){

        $database = Database::openConnection();
        $query  = "SELECT bills.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, bills.description, bills.date_bill ";
        $query .= "FROM users, bills ";
        $query .= "WHERE bills.id = :id ";
        $query .= "AND users.id = bills.user_id  LIMIT 1 ";

        $database->prepare($query);
        $database->bindValue(':id', (int)$billsId);
        $database->execute();

        $bill = $database->fetchAllAssociative();
        return $bill;
     }

    /**
     * create bill.
     *
     * @param  integer $userId
     * @param  string  $description
     * @return array bill created
     * @throws Exception if bill couldn't be created
     */
    public function create($userId, $description){

        $validation = new Validation();
        if(!$validation->validate(['Description'   => [$description, "required|minLen(4)|maxLen(300)"]])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query    = "INSERT INTO bills (user_id, description) VALUES (:user_id, :description)";

        $database->prepare($query);
        $database->bindValue(':user_id', $userId);
        $database->bindValue(':description', $description);
        $database->execute();

        if($database->countRows() !== 1){
            throw new Exception("Couldn't add a bill");
        }

        $billsId = $database->lastInsertedId();
        $bill = $this->getById($billsId);
        return $bill;
     }

    /**
     * update bill.
     *
     * @param  string  $billsId
     * @param  string  $description
     * @return array   bill created
     * @throws Exception if bill couldn't be updated
     */
    public function update($billsId, $description){

        $validation = new Validation();
        if(!$validation->validate(['Description'   => [$description, "required|minLen(4)|maxLen(300)"]])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query = "UPDATE bills SET description = :description WHERE id = :id LIMIT 1";

        $database->prepare($query);
        $database->bindValue(':description', $description);
        $database->bindValue(':id', $billsId);
        $result = $database->execute();

        if(!$result){
            throw new Exception("Couldn't update bills of ID: " . $billsId);
        }

        $bill = $this->getById($billsId);
        return $bill;
     }

 }