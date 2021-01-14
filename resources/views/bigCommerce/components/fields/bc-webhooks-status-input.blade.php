<div class="tooltip form-group__label">
    <label class="label required" for="webhooks_status">BIGCOMMERCE WEBHOOKS STATUS</label>
    <div class="ps-r">
        <svg class="tooltip__icon">
            <use xlink:href="#info"></use>
        </svg>
        <div class="top">
            <p>BIGCOMMERCE WEBHOOKS STATUS</p>
            <i></i>
        </div>
    </div>
</div>
<input type="text" class="input" style="font-weight:bold; @if($bc_webhooks_status == 1) color:green; @else color:red; @endif" name="bc_webhooks_status" value="{{$bc_webhooks_message}}" id="bc_webhooks_status" readonly disabled>