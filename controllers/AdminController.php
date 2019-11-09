<?php


namespace controllers;


use libs\Db;
use libs\Session;
use models\Admin;
use models\Task;

class AdminController extends DefaultController
{

    protected function checkAdmin()
    {
        $session = Session::getInstance();
        if (!$session->get('isAdmin')) {
            $this->redirect('/?action=login');
        }
    }

    public function login()
    {
        $session = Session::getInstance();
        if ($session->get('isAdmin')) {
            $this->redirect('/');
        }
        $adminModel = new Admin();

        if ($_POST) {
            $adminModel->username = $_POST['username'] ?? '';
            $adminModel->password = $_POST['password'] ?? '';
            if ($adminModel->validate()) {
                $session->set('isAdmin', true);
                $this->redirect('/');
            }
        }


        $errors = $adminModel->getErrors();

        return $this->loadView('admin/login', compact('adminModel', 'errors'));
    }

    public function logout()
    {
        $session = Session::getInstance();
        $session->remove('isAdmin');
        $this->redirect('/');
    }

    public function edit($id)
    {
        $this->checkAdmin();
        $id = intval($id);
        if ($id) {
            $db = Db::getInstance();
            $table = Task::getTableName();
            $task = $db->queryOne("SELECT * FROM $table WHERE id = ?", [$id]);
            if ($task) {
                $taskModel = new Task();
                $taskModel->message = $task->message;
                $taskModel->setId($id);

                if (!empty($_POST['message'])) {

                    $taskModel->message = $_POST['message'] ?? '';
                    $taskModel->status = 1;
                    $taskModel->filterField('message');
                    $taskModel->checkRequiredAndLength('message', 1000);
                    if (!$taskModel->getErrors()) {
                        $taskModel->updateMessage();
                        $this->redirect('/');
                    }
                }
                $errors = $taskModel->getErrors();


                return $this->loadView('admin/edit', compact('taskModel', 'errors'));
            }
        }
        header("HTTP/1.0 404 Not Found");
        die;
    }

    public function approve($id)
    {
        $this->checkAdmin();
        $id = intval($id);
        if ($id) {
            $db = Db::getInstance();
            $table = Task::getTableName();
            $task = $db->queryOne("SELECT * FROM $table WHERE id = ?", [$id]);
            if ($task) {
                $taskModel = new Task();
                $taskModel->setId($id);
                $taskModel->approve();
                $this->redirect('/');

            }
        }
        header("HTTP/1.0 404 Not Found");
        die;
    }


}