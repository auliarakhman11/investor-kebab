<!doctype html>
<html lang="en">
  <head>
  	<title>Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" type="image/png" href="{{asset('img')}}/kebabyasmin.jpeg"/>

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="{{ asset('auth') }}/css/style.css">

	</head>
	<body>
        <div class="container d-flex justify-content-center mt-5">
            <div class="d-flex flex-column justify-content-between">
                <div class="card mt-3 p-5">
                    <div class="logo mb-3"><img width="100px;" src="{{ asset('img') }}/kebabyasmin.jpeg"></div>
                    <div>
                        <p class="mb-1 text-warning">Start managing your</p>
                        <h4 class="mb-5 text-white">business!</h4>
                    </div> 
                </div>
                <div class="card two bg-white px-5 py-4 mb-3">
                    <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group"><input type="text" class="form-control" id="name" name="username" value="{{ old('username') }}" required><label class="form-control-placeholder" for="name">Username</label>
                    @error('username')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                    <div class="form-group"><input type="password" class="form-control" id="password" name="password" required><label class="form-control-placeholder" for="password">Password</label>
                        @error('password')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    </div> 
                    <button type="submit" class="btn btn-warning btn-block btn-lg mt-1 mb-2"><span>Login<i class="fas fa-long-arrow-alt-right ml-2"></i></span></button>
                    </form>
                </div>
            </div>
        </div>

	<script src="{{ asset('auth') }}/js/jquery.min.js"></script>
  {{-- <script src="{{ asset('auth') }}/js/popper.js"></script> --}}
  <script src="{{ asset('auth') }}/js/bootstrap.min.js"></script>
  {{-- <script src="{{ asset('auth') }}/js/main.js"></script> --}}

	</body>
</html>