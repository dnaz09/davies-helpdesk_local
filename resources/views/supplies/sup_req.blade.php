@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-plus"></i> SUPPLIES REQUEST FORM</h2> 
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-7 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Request was submitted!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-7 animated flash">
            @if( count($errors) > 0 )
                <div class="alert alert-danger alert-dismissible flash" role="alert">            
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
                    <center><h4>Oh snap! You got an error!</h4></center>   
                </div>
            @endif
        </div>    
        <div class="col-lg-7">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> Supplies Request Form <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">                            
                            <div class="form-group">
                                {!! Form::label('category','Category') !!}
                                {!!Form::select('category',$category,null,['class'=>'form-control','placeholder'=>'Select Category','required'=>'required','id'=>'category_id'])!!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('supply','Supply') !!}
                                {!!Form::select('supply',[],null,['class'=>'form-control','required'=>'required','id'=>'supply_id'])!!}
                            </div>                                                                          							
                            <div class="form-group">
                                {!! Form::label('qty','Qty') !!}
                                <input type="number" class="form-control" name="quantity" id="qty_id" min="1" value="1">
                            </div>
                            <div class="form-group pull-right">
                                <button class="btn btn-info" id="add_id" onclick="getSupplyFunction()"><i class="fa fa-plus"></i> Add</button>
                            </div>                        
                        </div>                        
                    </div>
                </div>                   
            </div>             	                        
        </div>              
        <div class="col-lg-5">
            <div class="ibox float-e-margins">
                <div class="ibox-title" style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-plus"></i> Supplies List <small></small></h5>          
                </div> 
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label('items','Items') !!}                                
                                <ul id=lstid>                                 

                                </ul>
                            </div>                            
                        </div>
                        <div class="col-sm-12">                            
                            {!!Form::open(array('route'=>'supplies_request.store','method'=>'POST','files'=>true))!!}                                                                                      
                                <div class="form-group">
                                    {!!Form::label('remarks','Remarks')!!}                        
                                    {!!Form::textarea('remarks','',['class'=>'form-control','placeholder'=>'Enter Remarks','required'=>'required'])!!}                                               
                                    @if ($errors->has('remarks')) <p class="help-block" style="color:red;">{{ $errors->first('details') }}</p> @endif
                                </div>                       
                                {!! Form::hidden('det','',['id'=>'supDet']) !!}                                                                                  
                                <div class="form-group pull-right">                                 
                                    <button class="btn btn-primary" value="Submit" this.form.submit();>Submit</button>
                                </div>                  
                            {!! Form::close() !!}
                        </div>                        
                    </div>
                </div>                   
            </div>                                      
        </div>              
    </div>    
</div>    
@stop
<script type="text/javascript">
    var ar = [];
    function getSupplyFunction(){

        var cat = $('#category_id').val();
        var item = $('#supply_id').val();
        var qty = $('#qty_id').val();
        var mer = cat + '-' + item + '-' + qty;

        var ul = document.getElementById("lstid");
        var li = document.createElement("li");
        // var button = document.createElement("button");
        // button.innerHTML = "remove";        
        // button.setAttribute("class", "btn btn-danger btn-xs");
        // button.setAttribute("type", "button");
        // button.setAttribute("onclick", "remFunction(this)");
        // button.setAttribute("id", mer); // added line
        // button.setAttribute("value", mer); // added line
        
        li.appendChild(document.createTextNode(mer));
        // li.appendChild(button);  
        li.setAttribute("id", cat+item+qty); // added line
        ul.appendChild(li);

        document.getElementById('qty_id').value = 1;

        ar.push(mer);

        $('#supDet').val(ar);
        
        // var exist = document.getElementById('lstid').innerHTML;
        // document.getElementById('lstid').innerHTML = exist + mer;
    }
</script>
@section('page-script')

    $('#filer_inputs_u_access').filer({

        showThumbs:true,
        addMore:true
    });   

     $('#category_id').on("change", function(){

        var x = $('#category_id').val();        

        $.ajax({
            type:"POST",
            data: {cat: x},
            url: "/get_supply",
            success: function(data){
                $('select#supply_id').empty();
                $.each(data, function(i, text) {
                    $('<option />',{value: i, text: text}).appendTo($('select#supply_id'));
                });
            }
        });

    }); 
@stop