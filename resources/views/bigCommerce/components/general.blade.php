<div class="accordion__item active js-accordion-item">
    <div class="accordion__item-head js-accordion-item-head">
        <span class="accordion__item-head-toggle"></span>
        <h2 class="accordion__item-head-title">General</h2>
    </div>
    <div class="accordion__item-content js-accordion-item-content init">
        <div class="accordion__item-content-row">
            <div class="accordion__item-content-column">
                <div class="form-group">
                    @include('bigcommerce.components.fields.store-hash-input')
                </div>
                <div class="form-group">
                    @include('bigcommerce.components.fields.application-status-select')
                </div>
                <div class="form-group">
                    @include('bigcommerce.components.fields.connection-status-input')
                </div>
                <div class="form-group">
                    @include('bigcommerce.components.fields.bc-connection-status-input')
                </div>
            </div>
        </div>
    </div>
</div>