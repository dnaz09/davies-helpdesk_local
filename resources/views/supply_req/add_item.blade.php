  <!-- Detail Modal Modal -->
  <div class="modal fade" id="addNewItemModal" role="dialog">
        <div class="modal-dialog modal-lg">
        <!-- Modal content-->       
        <div class="modal-content">         
          <div class="modal-header">         
            <button type="button" class="close" data-dismiss="modal">&times;</button>           
            <h4 class="modal-title">Add New Item</h4></div>         
            <div class="modal-body">    
                {!!Form::open(array('route'=>'supplies_request.addNewItem','method'=>'POST','files'=>true, 'class' => 'form-horizontal calender form_add_item'))!!} 
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Quantity</label>
                            <div class="col-sm-9">
                                    <input type="hidden" class="form-control" name="supply_request_id" id="supply_request_id"  value="{{$supp->id}}">
                                    <input type="number" class="form-control" name="qty" id="qty" min="1" value="1">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">U/M</label>
                            <div class="col-sm-9">
                                    <select class="form-control" name="item_measure" id="na_um_id">
                                            <option value="EA">EA</option>
                                            <option value="KLS">KLS</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-9">
                                    {!! Form::select('supply',$categs,'',array('class'=>'form-control','id'=>'category'))!!}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Item Description</label>
                            <div class="col-sm-9">
                                    <select class="form-control" data-placeholder="SELECT ITEM..." id='items' name="item"></select>
                            </div>
                        </div>
                
                    </div>
                <div class="modal-footer" style="margin:0;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button id="additem" type="submit" class="btn btn-primary">Add</button>
                </div>
            {!! Form::close() !!} 
            </div>
      </div>
          
        </div>
      </div> 

