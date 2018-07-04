<?php

 /**
  * Budgets Class
  *
  * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
  * @author     Matheus Rocha Vieira <matheusrv@email.com>
  */
class Budgets extends Model{

    /**
     * get all budget.
     *
     * @access public
     * @param  integer  $pageNum
     * @return array
     *
     */
    public function getAll($pageNum = 1){

        $pagination = Pagination::pagination("budgets", "", [], $pageNum);
        $offset     = $pagination->getOffset();
        $limit      = $pagination->perPage;

        $database   = Database::openConnection();
        $query  = "SELECT budgets.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, budgets.description, budgets.date ";
        $query .= "FROM users, budgets ";
        $query .= "WHERE users.id = budgets.user_id ";
        $query .= "ORDER BY budgets.date DESC ";
        $query .= "LIMIT $limit OFFSET $offset";

        $database->prepare($query);
        $database->execute();
        $budgets = $database->fetchAllAssociative();

        return array("budgets" => $budgets, "pagination" => $pagination);
     }

    /**
     * get budget by Id.
     *
     * @param  string  $budgetsId
     * @return array
      */
    public function getById($budgetsId){

        $database = Database::openConnection();
        $query  = "SELECT budgets.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, budgets.description, budgets.date ";
        $query .= "FROM users, budgets ";
        $query .= "WHERE budgets.id = :id ";
        $query .= "AND users.id = budgets.user_id  LIMIT 1 ";

        $database->prepare($query);
        $database->bindValue(':id', (int)$budgetsId);
        $database->execute();

        $budget = $database->fetchAllAssociative();
        return $budget;
     }

    /**
     * create budget.
     *
     * @param  integer $userId
     * @param  string  $description
     * @return array budget created
     * @throws Exception if budget couldn't be created
     */
    public function create($userId, $description){

        $validation = new Validation();
        if(!$validation->validate(['Description'   => [$description, "required|minLen(4)|maxLen(300)"]])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query    = "INSERT INTO budgets (user_id, description) VALUES (:user_id, :description)";

        $database->prepare($query);
        $database->bindValue(':user_id', $userId);
        $database->bindValue(':description', $description);
        $database->execute();

        if($database->countRows() !== 1){
            throw new Exception("Couldn't add a budget");
        }

        $budgetsId = $database->lastInsertedId();
        $budget = $this->getById($budgetsId);
        return $budget;
     }

    /**
     * update budget.
     *
     * @param  string  $budgetsId
     * @param  string  $description
     * @return array   budget created
     * @throws Exception if budget couldn't be updated
     */
    public function update($budgetsId, $description){

        $validation = new Validation();
        if(!$validation->validate(['Description'   => [$description, "required|minLen(4)|maxLen(300)"]])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query = "UPDATE budgets SET description = :description WHERE id = :id LIMIT 1";

        $database->prepare($query);
        $database->bindValue(':description', $description);
        $database->bindValue(':id', $budgetsId);
        $result = $database->execute();

        if(!$result){
            throw new Exception("Couldn't update budgets of ID: " . $budgetsId);
        }

        $budget = $this->getById($budgetsId);
        return $budget;
     }

 }