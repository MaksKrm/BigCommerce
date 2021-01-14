<div class="tooltip form-group__label">
    <label class="label" for="application_status">APPLICATION STATUS</label>
</div>
<select name="application_status" id="application_status" class="checkout-settings-select">
    <option value="1" @if($application_status === 1) selected @endif>Enabled</option>
    <option value="0" @if($application_status === 0) selected @endif>Disabled</option>
</select>