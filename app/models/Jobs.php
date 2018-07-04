<?php

 /**
  * Jobs Class
  *
  * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
  * @author     Matheus Rocha Vieira <matheusrv@email.com>
  */
class Jobs extends Model{

    /**
     * get all job.
     *
     * @access public
     * @param  integer  $pageNum
     * @return array
     *
     */
    public function getAll($pageNum = 1){

        $pagination = Pagination::pagination("jobs", "", [], $pageNum);
        $offset     = $pagination->getOffset();
        $limit      = $pagination->perPage;

        $database   = Database::openConnection();
        $query  = "SELECT jobs.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, jobs.description, jobs.date_job ";
        $query .= "FROM users, jobs ";
        $query .= "WHERE users.id = jobs.user_id ";
        $query .= "JOB BY jobs.date_job DESC ";
        $query .= "LIMIT $limit OFFSET $offset";

        $database->prepare($query);
        $database->execute();
        $jobs = $database->fetchAllAssociative();

        return array("jobs" => $jobs, "pagination" => $pagination);
     }

    /**
     * get job by Id.
     *
     * @param  string  $jobsId
     * @return array
      */
    public function getById($jobsId){

        $database = Database::openConnection();
        $query  = "SELECT jobs.id AS id, users.profile_picture, users.id AS user_id, users.name AS user_name, jobs.description, jobs.date_job ";
        $query .= "FROM users, jobs ";
        $query .= "WHERE jobs.id = :id ";
        $query .= "AND users.id = jobs.user_id  LIMIT 1 ";

        $database->prepare($query);
        $database->bindValue(':id', (int)$jobsId);
        $database->execute();

        $job = $database->fetchAllAssociative();
        return $job;
     }

    /**
     * create job.
     *
     * @param  integer $userId
     * @param  string  $description
     * @return array job created
     * @throws Exception if job couldn't be created
     */
    public function create($userId, $description){

        $validation = new Validation();
        if(!$validation->validate(['Description'   => [$description, "required|minLen(4)|maxLen(300)"]])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query    = "INSERT INTO jobs (user_id, description) VALUES (:user_id, :description)";

        $database->prepare($query);
        $database->bindValue(':user_id', $userId);
        $database->bindValue(':description', $description);
        $database->execute();

        if($database->countRows() !== 1){
            throw new Exception("Couldn't add a job");
        }

        $jobsId = $database->lastInsertedId();
        $job = $this->getById($jobsId);
        return $job;
     }

    /**
     * update job.
     *
     * @param  string  $jobsId
     * @param  string  $description
     * @return array   job created
     * @throws Exception if job couldn't be updated
     */
    public function update($jobsId, $description){

        $validation = new Validation();
        if(!$validation->validate(['Description'   => [$description, "required|minLen(4)|maxLen(300)"]])) {
            $this->errors = $validation->errors();
            return false;
        }

        $database = Database::openConnection();
        $query = "UPDATE jobs SET description = :description WHERE id = :id LIMIT 1";

        $database->prepare($query);
        $database->bindValue(':description', $description);
        $database->bindValue(':id', $jobsId);
        $result = $database->execute();

        if(!$result){
            throw new Exception("Couldn't update jobs of ID: " . $jobsId);
        }

        $job = $this->getById($jobsId);
        return $job;
     }

 }