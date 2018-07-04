<?php

/**
 * Jobs controller
 *
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @author     Matheus Rocha Vieira <matheusrv@email.com>
 */

class JobsController extends Controller{

    public function beforeAction(){

        parent::beforeAction();

        Config::setJsConfig('curPage', "jobs");

        $action = $this->request->param('action');
        $actions = ['create', 'getUpdateForm', 'update', 'getById', 'delete'];
        $this->Security->requirePost($actions);

        switch($action){
            case "create":
                $this->Security->config("form", [ 'fields' => ['description']]);
                break;
            case "getUpdateForm":
                $this->Security->config("form", [ 'fields' => ['jobs_id']]);
                break;
            case "update":
                $this->Security->config("form", [ 'fields' => ['jobs_id', 'description']]);
                break;
            case "getById":
            case "delete":
                $this->Security->config("form", [ 'fields' => ['jobs_id']]);
                break;
        }
    }

    public function index(){

        $this->user->clearNotifications(Session::getUserId(), $this->jobs->table);

        $pageNum  = $this->request->query("page");

        $this->view->renderWithLayouts(Config::get('VIEWS_PATH') . "layout/default/", Config::get('VIEWS_PATH') . 'jobs/index.php', ['pageNum' => $pageNum]);
    }

    public function create(){

        $description  = $this->request->data("description");

        $jobs = $this->jobs->create(Session::getUserId(), $description);

        if(!$jobs){

            Session::set('jobs-errors', $this->jobs->errors());
            return $this->redirector->root("Jobs");

        }else{

            return $this->redirector->root("Jobs");
        }
    }

    public function getUpdateForm(){

        $jobsId = Encryption::decryptIdWithDash($this->request->data("jobs_id"));

        if(!$this->jobs->exists($jobsId)){
            return $this->error(404);
        }

        $jobs = $this->jobs->getById($jobsId);

        $html = $this->view->render(Config::get('VIEWS_PATH') . 'jobs/updateForm.php', array("jobs" => $jobs[0]));
        $this->view->renderJson(array("data" => $html));
    }

    public function update(){

        // Remember? each news job has an id that looks like this: job-51b2cfa
        $jobsId = Encryption::decryptIdWithDash($this->request->data("jobs_id"));
        $description    = $this->request->data("description");

        if(!$this->jobs->exists($jobsId)){
            return $this->error(404);
        }

        $jobs = $this->jobs->update($jobsId, $description);
        if(!$jobs){
            $this->view->renderErrors($this->jobs->errors());
        }else{

            $html = $this->view->render(Config::get('VIEWS_PATH') . 'jobs/jobs.php', array("jobs" => $jobs));
            $this->view->renderJson(array("data" => $html));
        }
    }

    public function getById(){

        $jobsId = Encryption::decryptIdWithDash($this->request->data("jobs_id"));

        if(!$this->jobs->exists($jobsId)){
            return $this->error(404);
        }

        $jobs = $this->jobs->getById($jobsId);

        $html = $this->view->render(Config::get('VIEWS_PATH') . 'jobs/jobs.php', array("jobs" => $jobs));
        $this->view->renderJson(array("data" => $html));
    }

    public function delete(){

        $jobsId = Encryption::decryptIdWithDash($this->request->data("jobs_id"));

        $this->jobs->deleteById($jobsId);
        $this->view->renderJson(array("success" => true));
    }

    public function isAuthorized(){

        $action = $this->request->param('action');
        $role = Session::getUserRole();
        $resource = "jobs";

        // only for admins
        Permission::allow('admin', $resource, ['*']);

        // only for normal users
        Permission::allow('user', $resource, ['index', 'getById', 'create']);
        Permission::allow('user', $resource, ['update', 'delete', 'getUpdateForm'], 'owner');

        $jobsId = $this->request->data("jobs_id");
        if(!empty($jobsId)){
            $jobsId = Encryption::decryptIdWithDash($jobsId);
        }

        $config = [
            "user_id" => Session::getUserId(),
            "table" => "jobs",
            "id" => $jobsId];

        return Permission::check($role, $resource, $action, $config);
    }

}
