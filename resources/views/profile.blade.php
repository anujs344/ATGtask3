
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Csrf Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous"><link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    {{-- Ajax setup --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script   src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script   src="https://code.jquery.com/jquery-migrate-1.2.1.min.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


    <title>ATG</title>
</head>
<body>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>


  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"> {{ Auth::guard('register')->user()->name}}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " aria-current="page" href="/logout/profile">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <br><br>
  <h1> Hello {{ Auth::guard('register')->user()->name}}!!</h1>

  <table class="table table-dark">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Task</th>
        <th scope="col">Staus</th>
        <th scope="col">Update To</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($tasks as $key=>$task)
        
      
      <tr>
        <th scope="row">{{$key+1}}</th>
        <td>{{$task['task']}}</td>
        <td>{{$task['status']}}</td>
        <td>@if ($task['status']=='pending')
          <form id="form{{$key+1}}" >@csrf<input type="hidden" id="task_id{{$key+1}}" name="task_id" value="{{$task['id']}}"><input type="hidden" id="status{{$key+1}}" name="status" value="done"><button type="submit" class="btn btn-dark" >Done</button></form>
          @else
          <form id="form{{$key+1}}" >@csrf<input type="hidden" id="task_id{{$key+1}}" name="task_id" value="{{$task['id']}}"><input type="hidden" id="status{{$key+1}}" name="status" value="pending"><button type="submit" class="btn btn-dark" >Pending</button></form>
        @endif</td>
      </tr>
      @endforeach
           
    </tbody>
  </table>
  <form id="form">
    @csrf
    <div class="form-group" >
      <label for="formGroupExampleInput">Todo</label>
      <input type="text" class="form-control" id="todo" name="task" placeholder="I have todo this work today" required>
      <input type="hidden" id="user_id" name="user_id" value="{{Auth::guard('register')->user()->id}}">
    </div>
    <button type="submit" class="btn btn-dark" >ADD</button>
  </form>
  <script>
    
    var todo = document.getElementById('todo');
    var _token =$("input[name=_token]").val();
    var user_id = document.getElementById('user_id');
    
    var totaltask = "{{$totaltask}}";
     $('#form').submit(function (e){
                e.preventDefault();
                
                $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                            });
                $.ajax({
                    type: "post",
                    url: "{{url('/posts')}}",
                    data:{
                    task:todo.value,
                    user_id:user_id.value,
                    _token:_token
                    },
                    success: function(store) {
                      location.reload();

                    },
                    error: function() {
                      alert("false");
                    }
                });
                todo.value = "";
      });
      for (let index = 1; index <= totaltask; index++) {
        
        $('#form'+index).submit(function (e){
          
                e.preventDefault();
                let task_id = document.getElementById('task_id'+index);
                let status = document.getElementById('status'+index);
                $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                            });
                $.ajax({
                    type: "post",
                    url: "{{url('/posts2')}}",
                    data:{
                    task_id:task_id.value,
                    status:status.value,
                    _token:_token
                    },
                    success: function(store) {
                      location.refresh();

                    },
                    error: function() {
                      alert("false");
                    }
                });
      });
      }
      
  </script>
</body>
</html>