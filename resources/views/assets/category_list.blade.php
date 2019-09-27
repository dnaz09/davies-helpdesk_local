@extends('layouts.master')
@section('main-body')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-12">
        <h2><i class="fa fa-futbol-o"></i> ITEMS CATEGORY MAINTENANCE</h2>        
    </div>
</div>        
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 animated flash">
            <?php if (session('is_success')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Category was successfully added!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
        <div class="col-lg-12 animated flash">
            <?php if (session('is_updated')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Item was successfully Updated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
        <div class="col-lg-12 animated flash">
            <?php if (session('is_active')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Item was successfully Activated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
        <div class="col-lg-12 animated flash">
            <?php if (session('is_inactive')): ?>
                <div class="alert alert-success alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Item was successfully Deactivated!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
        <div class="col-lg-12 animated flash">
            <?php if (session('delete_error')): ?>
                <div class="alert alert-warning alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                    <center><h4>Item deletion error! You must deactivate the item first before deleting it!<i class="fa fa-check"></i></h4></center>                
                </div>
            <?php endif;?>          
        </div>
    </div>  
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title"style="background-color:#009688">
                    <h5 style="color:white"><i class="fa fa-futbol-o"></i> Item Category Maintenance Table</h5>                    
                    {!! Html::decode(link_to_Route('item_categories.create', '<i class="fa fa-plus"></i> New Item Category', [], ['class' => 'btn btn-white btn-xs pull-right'])) !!}
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categs as $categ)
                                <tr>
                                    <td>{!! $categ->id !!}</td>
                                    <td>{!! $categ->category_name !!}</td>
                                    <td>{!! Html::decode(link_to_Route('item_categories.details','<i class="fa fa-eye"></i> EDIT', $categ->id, array('class' => 'btn btn-warning btn-xs')))!!}</td>
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
@stop