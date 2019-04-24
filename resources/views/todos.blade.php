<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="codepoet"/>
    <meta name="description" content="A laravel Todo App describing the basic CRUD operations in laravel"/>
    <meta name="keywords" content="PHP,HTML,CSS,JAVASCRIPT,LARAVEL"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel Todo Application</title>
    <link rel="icon" href="{{asset('/img/todo.png')}}">
    {{-- bootstrap css CDN --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    {{-- Font awesome CDN --}}
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">

    {{-- Custon style --}}
    <style type="text/css">
        .delete-link{
            color: red;
        }

        .delete-link:hover{
            color: #fff;
        }
    </style>
</head>
<body>
    
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">
                    <img src="{{asset('/img/todo.png')}}" alt="" class="img-responsive">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </nav>
        </div>
    </div>

    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success')}}
        </div>
    @endif

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3 class="text-center"> Todo Tasks</h3>
                <form action="/add-task" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="task" placeholder="Enter Task" aria-label="Todo Task" aria-describedby="addTodo">
                        <div class="input-group-append">
                            {{-- Add this to prevent XSS attacks without this you'd get an error when you try to submit the form  --}}
                            {{ csrf_field() }}
                            <button class="btn btn-primary" type="submit" id="addTodo">Add Todo</button>
                        </div>
                    </div>
                </form>
                <div class="text-center">
                    <a href="{{ route('filter-tasks',["filter"=>"all"]) }}" class="btn btn-outline-primary">ALL</a>
                    <a href="{{ route('filter-tasks',["filter"=>"active"]) }}" class="btn btn-outline-primary">ACTIVE</a>
                    <a href="{{ route('filter-tasks',["filter"=>"completed"]) }}" class="btn btn-outline-primary">COMPLETED</a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="list-group">
                    @foreach ($todos as $todo)
                        <li class="list-group-item d-flex justify-content-between align-items-center list-group-item-primary list-group-item-action">
                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <p>{{ $todo->todo}}</p>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4  col-lg-4 d-flex justify-content-between align-items-center">
                                    {{-- Using the route global function to add routes to the link
                                    it accepts the route name and an array of variables the route is expecting --}}

                                    @if (!$todo->completed)
                                        <a href="{{ route('complete-task',['id'=> $todo->id]) }}" class="delete-link">
                                            <button class="btn btn-sm btn-outline-success ml-1">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </a>
                                    @endif


                                    <a href="{{ route('delete-task',['id'=> $todo->id]) }}" class="delete-link">
                                        <button class="btn btn-sm btn-outline-danger ml-1">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>

                                    <button type="button" data-toggle="modal" data-target="#edit-task" class="btn btn-sm btn-outline-primary ml-1" onclick="addTaskTextAndTaskId('{{$todo->todo}}','{{$todo->id}}');">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Modal for updating Tasks --}}

        <!-- Modal -->
        <div class="modal fade" id="edit-task" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/update-task" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="task" placeholder="Enter Task" aria-label="Todo Task" aria-describedby="addTodo" id="task">
                        <div class="input-group-append">
                            {{-- Add this to prevent XSS attacks without this you'd get an error when you try to submit the form  --}}
                            {{ csrf_field() }}
                            <input type="hidden" name="task_id" id="task-id">
                            <button class="btn btn-primary" type="submit" id="addTodo">Edit Todo</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-md btn-outline-primary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
    {{-- bootstrap javascript CDN --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript">
    function addTaskTextAndTaskId(text,id){
        $("#task-id").val(id);
        $("#task").val(text);
    }
</script>
</body>
</html>
