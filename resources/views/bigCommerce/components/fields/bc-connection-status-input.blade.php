<div class="tooltip form-group__label">
    <label class="label" for="connection_status">BIGCOMMERCE CONNECTION STATUS</label>
</div>
<input type="text" class="input" style="font-weight:bold; @if($bc_connection_status == 1) color:green; @else color:red; @endif" name="bc_connection_status" value="{{$bc_connection_message}}" id="bc_connection_status" readonly disabled>