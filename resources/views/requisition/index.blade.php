@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2> <i class="fa fa-pencil"></i> REQUISITION</h2>        
    </div>
</div>        
 <div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Requisition has been Created!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-12 animated flash">
            @if( count($errors) > 0)
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>    
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-pencil"></i> Requisition Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    {!!Form::open(array('route'=>'requisition.store','method'=>'POST','files'=>true))!!}
                    <div class="row">
                        <div class="col-sm-4">
                            {!! Form::label('date','Filing Date') !!}
                            <input class="form-control" type="text" value="{{date('m-d-Y')}}" readonly>
                        </div>
                    </div><br>     
                    <div class="row">               
                        <div class="col-sm-1">
                            <div class="form-group">
                                {!! Form::label('item_no1','Item No') !!}
                                {!! Form::text('1','1',['class'=>'form-control','placeholder'=>'Item No','required'=>'required','readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label('type_of_file','Type of Request') !!}
                                <select class="form-control" name="item1">
                                    <option value="">Select Request</option>
                                    @foreach($forms as $form)
                                    <option value="{{$form->form}}">{{$form->form}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                     
                        <!-- <div class="col-sm-2">
                            <div class="form-group">
                                {!! Form::label('desc1','Description') !!}
                                <select class="form-control" name="desc1">
                                    <option value="">Select Description</option>
                                    @foreach($descs as $desc)
                                    <option value="{{$desc->description}}">{{$desc->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  -->                       
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('qty1','Qty') !!}
                                <select class="form-control" name="qty1">
                                    <option value="">Select Quantity</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>                       
                        <div class="col-sm-3">
                            <div class="form-group">
                                {!! Form::label('purpose1','Purpose') !!}
                                <select class="form-control" name="purpose1">
                                    <option value="">Select Purpose</option>
                                    @foreach($purposes as $purpose)
                                    <option value="{{$purpose->purpose}}">{{$purpose->purpose}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                                                
                    </div>
                    <div class="row" id="item2">
                        <div class="col-sm-1">
                            <div class="form-group">                                
                                {!! Form::text('2','2',['class'=>'form-control','placeholder'=>'Item No','readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select class="form-control" name="item2">
                                    <option value="">Select Request</option>
                                    @foreach($forms as $form)
                                    <option value="{{$form->form}}">{{$form->form}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                       
                        <!-- <div class="col-sm-2">
                            <div class="form-group">                                
                                <select class="form-control" name="desc2">
                                    <option value="">Select Description</option>
                                    @foreach($descs as $desc)
                                    <option value="{{$desc->description}}">{{$desc->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>  -->                       
                        <div class="col-sm-3">
                            <div class="form-group">                                
                                <select class="form-control" name="qty2">
                                    <option value="">Select Quantity</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>                        
                        <div class="col-sm-3">
                            <div class="form-group">                                
                                <select class="form-control" name="purpose2">
                                    <option value="">Select Purpose</option>
                                    @foreach($purposes as $purpose)
                                    <option value="{{$purpose->purpose}}">{{$purpose->purpose}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <div class="row" id="item3">
                        <div class="col-sm-1">
                            <div class="form-group">                                
                                {!! Form::text('3','3',['class'=>'form-control','placeholder'=>'Item No','readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <select class="form-control" name="item3">
                                    <option value="">Select Request</option>
                                    @foreach($forms as $form)
                                    <option value="{{$form->form}}">{{$form->form}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        
                        <!-- <div class="col-sm-2">
                            <div class="form-group">                                
                                <select class="form-control" name="desc3">
                                    <option value="">Select Description</option>
                                    @foreach($descs as $desc)
                                    <option value="{{$desc->description}}">{{$desc->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> -->                        
                        <div class="col-sm-3">
                            <div class="form-group">                                
                                <select class="form-control" name="qty3">
                                    <option value="">Select Quantity</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>                      
                        <div class="col-sm-3">
                            <div class="form-group">                                
                                <select class="form-control" name="purpose3">
                                    <option value="">Select Purpose</option>
                                    @foreach($purposes as $purpose)
                                    <option value="{{$purpose->purpose}}">{{$purpose->purpose}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <!-- <div class="row" id="item4">
                        <div class="col-sm-1">
                            <div class="form-group">                                
                                {!! Form::text('4','4',['class'=>'form-control','placeholder'=>'Item No','readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="form-control" name="item4">
                                    <option value="">Select File</option>
                                    @foreach($forms as $form)
                                    <option value="{{$form->form}}">{{$form->form}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                       
                        <div class="col-sm-2">
                            <div class="form-group">                                
                                <select class="form-control" name="desc4">
                                    <option value="">Select Description</option>
                                    @foreach($descs as $desc)
                                    <option value="{{$desc->description}}">{{$desc->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        
                        <div class="col-sm-2">
                            <div class="form-group">
                                <select class="form-control" name="qty4">
                                    <option value="">Select Quantity</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>                       
                        <div class="col-sm-2">
                            <div class="form-group">                                
                                <select class="form-control" name="purpose4">
                                    <option value="">Select Purpose</option>
                                    @foreach($purposes as $purpose)
                                    <option value="{{$purpose->purpose}}">{{$purpose->purpose}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        
                    </div>
                    <div class="row" id="item5">
                        <div class="col-sm-1">
                            <div class="form-group">                                
                                {!! Form::text('5','5',['class'=>'form-control','placeholder'=>'Item No','readonly']) !!}
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="form-control" name="item5">
                                    <option value="">Select File</option>
                                    @foreach($forms as $form)
                                    <option value="{{$form->form}}">{{$form->form}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                       
                        <div class="col-sm-2">
                            <div class="form-group">                                
                                <select class="form-control" name="desc5">
                                    <option value="">Select Description</option>
                                    @foreach($descs as $desc)
                                    <option value="{{$desc->description}}">{{$desc->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        
                        <div class="col-sm-2">
                            <div class="form-group">                                
                                <select class="form-control" name="qty5">
                                    <option value="">Select Quantity</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>    
                        <div class="col-sm-2">
                            <div class="form-group">                                
                                <select class="form-control" name="purpose5">
                                    <option value="">Select Purpose</option>
                                    @foreach($purposes as $purpose)
                                    <option value="{{$purpose->purpose}}">{{$purpose->purpose}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>                        
                    </div> -->                
                    <div class="row">
                        <div class="col-sm-2">
                            {!! Form::label('date from','Date From') !!}
                            <input class="form-control" type="text" value="{{date('m/d/Y')}}" readonly>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group" id="date_1">
                                {!! Form::label('date_needed','Date To') !!}
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="{{$date}}" name="date_needed" id="input_text" required="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            {!! Form::label('Remarks','Remarks') !!}
                            {!! Form::text('remarks','',array('class'=>'form-control','required','placeholder'=>'Enter Remarks here...')) !!}
                        </div>                       
                    </div>
                    <div class="row">
                        <div class="col-sm-2">
                            {!! Form::label('requested_by','Requested By') !!}
                            {!! Form::text('requested_by',strtoupper($user->first_name.' '.$user->last_name),['class'=>'form-control','readonly'=>'readonly']) !!}
                        </div>
                        <div class="form-group pull-right">
                            {!! Html::decode(link_to_Route('requisition.index', '<i class="fa fa-arrow-left"></i> Cancel', [], ['class' => 'btn btn-default'])) !!}
                            <!-- <button class="btn btn-primary" id="requisitionsave" type="button"> Save</button> -->
                            <!-- {!! Form::button('<i class="fa fa-save"></i> Save', array('id'=>'reqsent', 'type' => 'submit', 'class' => 'btn btn-primary hidden')) !!} -->
                            {!! Form::button('<i class="fa fa-save"></i> Save', array('type' => 'submit', 'class' => 'btn btn-primary')) !!}
                        </div>    
                    </div>
                    <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                    {!! Form::close() !!}
                </div>                   
            </div>     
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> MY REQUISITIONS LISTS</h5>                                      
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>CONTROL #</th>                                
                                <th>DATE REQUESTED</th>
                                <th>DATE NEEDED</th>
                                <th>MANAGER ACTION</th> 
                                <th>HRD ACTION</th>
                                <th>ACTION</th>                              
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requisitions as $requisition)
                                <tr>
                                    <td>
                                        @if($requisition->level != 5 && $requisition->sup_action != 5 && $requisition->hrd_action != 5)    
                                        {!! Html::decode(link_to_route('requisition.details', $requisition->rno,$requisition->rno, array())) !!}
                                        @else
                                        {!! $requisition->rno !!}
                                        @endif
                                    </td>                                    
                                    <td>{!! date('m/d/y',strtotime($requisition->created_at)) !!}</td>
                                    <td>{!! date('m/d/y',strtotime($requisition->date_needed)) !!}</td>
                                    <td>
                                        @if($requisition->sup_action == 1 || $requisition->sup_action < 1)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($requisition->sup_action == 2)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($requisition->level == 5 && $requisition->sup_action == 5 && $requisition->hrd_action == 5)
                                        <span class="label label-info"> <i class="fa fa-angellist"></i>Canceled</span>
                                        @else
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @endif
                                    </td>          
                                    <td>
                                        @if($requisition->hrd_action == 1)
                                        <span class="label label-warning"> <i class="fa fa-angellist"></i>Pending</span>
                                        @elseif($requisition->hrd_action == 2)
                                        <span class="label label-primary"> <i class="fa fa-angellist"></i>Approved</span>
                                        @elseif($requisition->hrd_action == 3 || $requisition->sup_action == 3)
                                        <span class="label label-danger"> <i class="fa fa-angellist"></i>Denied</span>
                                        @else
                                        <span class="label label-info"> <i class="fa fa-minus"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($requisition->sup_action != 5 && $requisition->hrd_action != 5 && $requisition->level != 5 && $requisition->sup_action != 2 && $requisition->sup_action != 3 && $requisition->hrd_action != 3 && $requisition->hrd_action != 3)
                                        {!! Html::decode(link_to_route('requisition.cancel', 'Cancel',$requisition->rno, array('class'=>'btn btn-xs btn-danger'))) !!}
                                        @else
                                        <span class="label label-info"> <i class="fa fa-minus"></i></span>
                                        @endif
                                    </td>                                                                                           
                                </tr>
                            @empty
                            @endforelse
                        </tbody>                        
                        </table>
                    </div>
                </div>
                </div>
            </div>                                
        </div>                    
    </div>    
</div>    
@stop
@section('page-script')


$('#date_1 .input-group.date').datepicker({
    todayBtn: "linked",
    keyboardNavigation: false,
    forceParse: false,
    calendarWeeks: true,
    autoclose: true,
    dateFormat: "yy-mm-dd",
    startDate: new Date()
});
$('#input_text').keypress(function(key) {
    if(key.charCode > 47 || key.charCode < 58 || key.charCode < 48 || key.charCode > 57 || key.charCode > 95 || key.charCode > 107){
        key.preventDefault();
    }
});

@stop