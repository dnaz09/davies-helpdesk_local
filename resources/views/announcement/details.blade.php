@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> HR ANNOUNCEMENT / MEMO</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content  animated fadeInRight article">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="ibox">
                <div class="ibox-content">                    
                    <div class="text-center article-title">
                    <span class="text-muted"><i class="fa fa-clock-o"></i> {!! date('m/d/y',strtotime($memo->created_at)) !!}</span>
                        <h1>
                            {!! $memo->subject !!}
                        </h1>
                    </div>
                    <p>
                        {!! $memo->message !!}
                    </p>                    
                    <hr>
                    @if(count($memo->files) > 0)
                    <div class="row">
                        {!! Form::label('files','Attached File/s') !!}                                                
                    </div>
                    <div class="row">
                        @foreach($memo->files as $filer)
                            <div style="margin-top: 2%;">

                                {!! Form::open(array('route'=>'memo.download_files','method'=>'POST', 'target' =>"_blank")) !!}
                                    {!! Form::hidden('encname',$filer->encryptname) !!}
                                    {!! Form::submit($filer->filename, array('type' => 'submit', 'class' => 'btn btn-primary btn-xs')) !!}                                          
                                {!! Form::close() !!}
                            </div>         
                        @endforeach

                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('page-script')

    $('#message_filer_inputs').filer({

        showThumbs:true,
        addMore:true
    });   
@endsection