<?php
use models\Task;

/* @var Task $taskModel*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Tasks</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <br />
    </div>

    <div class="row pull-right">
        <?php if($isAdmin):?>
            <a class="btn btn-danger" href="/?action=logout">Logout</a>
        <?php else:?>
            <a class="btn btn-primary" href="/?action=login">Login</a>
        <?php endif?>
    </div>


    <?php if($newTaskCreated):?>
        <div class="alert alert-success fade in alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Success!</strong> New Task successfully Added!
        </div>
    <?php endif?>

    <?php if($errors):?>
        <div class="alert alert-danger fade in alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <strong>Failed!</strong> the task was not created please check validation errors!
        </div>
    <?php endif?>

    <h1 class="text-center">Tasks</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th><a href="<?= Task::getSortLink('name', $page, $sort, $dir)?>">Name <i class="fa fa-fw fa-sort"></i></a></th>
            <th><a href="<?= Task::getSortLink('email', $page, $sort, $dir)?>">Email <i class="fa fa-fw fa-sort"></i></a></th>
            <th><a href="<?= Task::getSortLink('text', $page, $sort, $dir)?>">Text <i class="fa fa-fw fa-sort"></i></a></th>
            <th><a href="<?= Task::getSortLink('status', $page, $sort, $dir)?>">Status <i class="fa fa-fw fa-sort"></i></a></th>
            <?php if($isAdmin):?>
                <th>Edit</th>
            <?php endif?>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task):?>
            <tr>
                <td><?=$task->name?></td>
                <td><?=$task->email?></td>
                <td><?=$task->message?></td>
                <td><?=$task->status ? 'Edited By Admin' : 'NO'?></td>
                <?php if($isAdmin):?>
                    <td>
                        <a href="/?action=edit&id=<?=$task->id?>" class="btn btn-primary">Edit</a>
                        <?php if(!$task->status):?>
                            <a href="/?action=approve&id=<?=$task->id?>" class="btn btn-danger">Approve</a>
                        <?php endif?>
                    </td>
                <?php endif?>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>

    <nav aria-label="Page navigation" >
        <ul class="pagination" >
            <li>
                <?php if($page > 1):?>
                    <a class="page-link" href="/?page=<?=$page - 1?>&sort=<?=$sort?>&dir=<?=$dir?>">Previous</a>
                <?php else:?>
                    <a class="page-link" href="#">Previous</a>
                <?php endif?>
            </li>
            <li class="page-item"><a class="page-link" href="#"><?=$page?></a></li>
            <li class="page-item">
                <?php if($totalPages > $page):?>
                    <a class="page-link" href="/?page=<?=$page + 1?>&sort=<?=$sort?>&dir=<?=$dir?>">Next</a>
                <?php else:?>
                    <a class="page-link" href="#">Next</a>
                <?php endif?>
            </li>
        </ul>
    </nav>


    <div class="row">


        <form method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?=$taskModel->name?>">
                <p><?= $errors['name'] ?? ''?></p>
            </div>

            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?=$taskModel->email?>">
                <p><?= $errors['email'] ?? ''?></p>
            </div>

            <div class="form-group">
                <label for="message">Message</label>
                <textarea class="form-control" id="message" name="message"><?=$taskModel->message?></textarea>
                <p><?= $errors['message'] ?? ''?></p>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>