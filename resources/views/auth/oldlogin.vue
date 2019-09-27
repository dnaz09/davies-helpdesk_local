
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

<body class="gray-bg" id="logss">

    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <h2 class="font-bold" style="color: #2980b9">WELCOME TO DPPI HELPDESK</h2>                

            </div>
            <div class="col-md-6">
                <div class="ibox-content">
                    <form role="form" method="POST" action="/login">
                        <?php if (Session::get('errorMessage')):?>
                            <div class="alert alert-danger text-center alert-dismissible flash" role="alert">
                                <center><h4> {!! Session::get('errorMessage') !!}</h4></center>
                            </div>                                                                        
                        <?php endif;?>
                        <?php if (Session::get('token_error')):?>
                            <div class="alert alert-danger text-center alert-dismissible flash" role="alert">
                                <center><h4>Woops, Kindly refresh the page!</h4></center>
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
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-md-6" style="color: white">
                Copyright DAVIES PAINT PHILIPPINES INCORPORATED
            </div>
            <div class="col-md-6 text-right">
               <small style="color: white">© 2017</small>
            </div>
        </div>
    </div>

</body>
</html>
