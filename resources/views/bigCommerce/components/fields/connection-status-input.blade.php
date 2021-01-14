<div class="tooltip form-group__label">
    <label class="label" for="connection_status">IWD CONNECTION STATUS</label>
</div>
<input type="text" class="input" style="font-weight:bold; @if($connection_status) color:green; @else color:red; @endif" name="connection_status" value="{{$connection_message}}" id="connection_status" readonly disabled>