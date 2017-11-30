<div id="{{$type}}rows_#index#_markers" class="markers">
	<!-- Form template-->
	<div id="{{$type}}rows_#index#_markers_template">
	    <input id="{{$type}}rows_#index#_markers_#index_markers#_id" name="rows[{{$index}}][#index#][markers][#index_markers#][id]" type="hidden" />
	    <div class="form-group">
	    	<input class="form-control required" style="width:75px;" id="{{$type}}rows_#index#_markers_#index_markers#_name" name="rows[{{$index}}][#index#][markers][#index_markers#][name]" type="text" maxlength="50" placeholder="Marker" />
	    </div>
		
		<div class="form-group">
			<input class="form-control required" style="width:250px;" id="{{$type}}rows_#index#_markers_#index_markers#_text" name="rows[{{$index}}][#index#][markers][#index_markers#][text]" type="text" placeholder="Text" />
		</div>
		
		<div class="form-group">
			<a id="{{$type}}rows_#index#_markers_remove_current">
				<i class="glyphicon glyphicon-remove"></i>
			</a>
		</div>
	</div>
	<!-- /Form template-->
	 
	<!-- No forms template -->
	<div id="{{$type}}rows_#index#_markers_noforms_template">No Markers</div>
	<!-- /No forms template-->
	 
	<!-- Controls -->
	<div id="{{$type}}rows_#index#_markers_controls" class="row row-controls">
	    <div id="{{$type}}rows_#index#_markers_add">
	    	<a class="btn btn-success btn-sm">
	    		<span>
	    			<i class="glyphicon glyphicon-plus"></i>
	    			Add Marker
	    		</span>
	    	</a>
	    </div>

	    <div id="{{$type}}rows_#index#_markers_remove_last">
	    	<a class="btn btn-danger btn-sm">
	    		<span>
	    			<i class="glyphicon glyphicon-minus"></i>
	    			Remove Marker
	    		</span>
	    	</a>
	    </div>
	</div>
	<!-- /Controls -->
</div>
