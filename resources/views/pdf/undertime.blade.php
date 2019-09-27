<!DOCTYPE html>
<html><head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{!! $company !!} UNDERTIME FORM</title>
<link href="/assets/css/bootstrap.min.css" rel="stylesheet">    
<link rel="stylesheet" type="text/css" href="assets/ins/style.css">
<link href="/assets/css/animate.css" rel="stylesheet">
<style>
table, th, td {
    border: 2px solid #000000;
    border-collapse: collapse;
}
</style>  
</head><body class="white-bg"><canvas>
<div class="wrapper wrapper-content p-xl">
<div class="row">
<div class="ibox float-e-margins">
<div class="ibox-title">
<h5><i class="fa fa-pencil"></i><center>
<h2>{!! $company !!}</h2> 
<h4>UNDERTIME SLIP</h4>
</center></h5>          
</div> 
<div class="ibox-content p-xl">                                    
<p style="padding-top: 20px;">
<strong>DATE FILED:</strong> {!! date('m/d/Y h:ia',strtotime($undertime->created_at)) !!}
<p style="padding-top: 20px;">
<strong> SCHEDULE OF UNDERTIME: </strong> {!! date('m/d/Y',strtotime($undertime->date)) !!} @if($undertime->sched !== '-'){!! $undertime->sched!!}@endif
</p>                        
<p style="padding-top: 10px;"><strong>TYPE:</strong> 
    @if($undertime->type == 1)
    HALF DAY
    @elseif($undertime->type == 2)
    UNDERTIME
    @else
    @endif</p>
<p style="padding-top: 10px;"><strong>REASON:</strong></p>
<p>{!! $undertime->reason !!}</p>
<div class="row" style="padding-top: 15px;">
<div class="col-lg-12">
<p>
<strong>PREPARED BY:</strong> {!! $employee_name !!}                                
</p>
<p>
<strong>Approved by Manager: </strong> {!! strtoupper($undertime->mngrs->first_name.' '.$undertime->mngrs->last_name) !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<strong>Approved by HRD: </strong> {!! strtoupper($undertime->hrds->first_name.' '.$undertime->hrds->last_name) !!}
</p>
</div>
</div> 
</div>
</div>
</div>
</canvas>
</div>
<script src="/assets/js/bootstrap.min.js"></script>        
<script type="text/javascript">
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
</script>    
</body></html>

{{-- <!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DPPI UNDERTIME FORM</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">    
    <link rel="stylesheet" type="text/css" href="assets/ins/style.css">
    <link href="/assets/css/animate.css" rel="stylesheet">    
</head>

    <body class="white-bg"><canvas>
        <div class="wrapper wrapper-content p-xl">
            <div class="row">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><i class="fa fa-pencil"></i><center>
                            <h2>DAVIES PAINTS PHILIPPINES INC., (DPPI)</h2> 
                            <h4>UNDERTIME SLIP</h4>
                        </center></h5>          
                    </div> 
                    <div class="ibox-content p-xl">                                    
                        <p style="padding-top: 20px;">
                            <strong>DATE FILED: {!! $undertime->created_at !!}</strong>
                        <p                    
                        <p style="padding-top: 20px;">
                            <strong> SCHEDULE OF UNDERTIME: </strong> {!! $undertime->date.' '.$undertime->sched!!}                            
                        </p>                        
                        <p style="padding-top: 10px;"><strong>REASON:</strong></p>
                        
                        <p>{!! $undertime->reason !!}</p>

                                                     
                        <div class="row" style="padding-top: 15px;">
                            <div class="col-lg-12">
                                <p>
                                    <strong>PREPARED BY:</strong> {!! $employee_name !!}                                
                                </p>
                                <p>
                                    <strong>Approved by Manager: </strong> {!! strtoupper($undertime->mngrs->first_name.' '.$undertime->mngrs->last_name) !!}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <strong>Approved by HRD: </strong> {!! strtoupper($undertime->hrds->first_name.' '.$undertime->hrds->last_name) !!}
                                </p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            </canvas>
        </div>
        


        <script src="/assets/js/bootstrap.min.js"></script>        
        
        <script type="text/javascript">
              $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
              });
          </script>    
    </body>
</html>
 --}}