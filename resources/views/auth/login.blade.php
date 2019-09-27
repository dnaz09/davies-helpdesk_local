
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DPPI | HELPDESK</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/styleowa.css" rel="stylesheet">

</head>

<body class="gray-bg">
    
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>                
                <h1 class="logo-name" style="font-size:120px;">DPPI</h1>
            </div>
            <center>                
                <h3>Davies Paint Philippines</h3>
                <h3>DPPI HELPDESK SYSTEM</h3>
            </center>
            <p>
            </p>            
            <form role="form" method="POST" action="/login">
                <?php if (Session::get('errorMessage')):?>
                    <div class="alert alert-danger text-center alert-dismissible flash" role="alert">
                        <center><h4> {!! Session::get('errorMessage') !!}</h4></center>
                    </div>                                                                        
                <?php endif;?>
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

                <div class="form-group">
                    <input type="username" class="form-control" placeholder="Username" required="" name="username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" name="password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>                   
            <p class="m-t"> <small>Davies Paint Philippines Incorporated &copy; 2018</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="/assets/js/jquery-2.1.1.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>

</body>
</html>
