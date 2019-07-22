
<div class="input-group">
    <select id="filter_state" name="filter_state"  class="form-control search-txt" >   
        <option value="">Select state</option>
        <option value="1" {{ (app('request')->input('filter_state') == '1')? 'selected':'' }} >Published</option>
        <option value="0" {{ (app('request')->input('filter_state') == '0')? 'selected':'' }}>Unpublished</option>
        <!-- <option value="-2" {{ (app('request')->input('filter_state') == '-2')? 'selected':'' }}>Trashed</option> -->
    </select>    
</div>
<div class="input-group">
    <input type="text" name="search_txt" value="{{ app('request')->input('search_txt') }}" placeholder="Keywords" class="form-control search-txt">
    <span class="input-group-btn">
    <button type="submit" class="btn btn-default filter-btn"><i class="fa fa-search"></i></button>
    </span>
</div>
<div class="input-group reset">
<a id="reset_form" href="javascript:void(0)">Reset Filters</a>
</div>