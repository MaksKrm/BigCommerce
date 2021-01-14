<div class="accordion__item active js-accordion-item">
    <div class="accordion__item-head js-accordion-item-head">
        <span class="accordion__item-head-toggle"></span>
        <h2 class="accordion__item-head-title">Connector Configuration</h2>
    </div>
    <div class="accordion__item-content js-accordion-item-content init">
        <div class="accordion__item-content-row">
            <div class="accordion__item-content-column">
                <div class="form-group">
                    @include('bigcommerce.components.fields.api-key-input')
                </div>
                <div class="form-group">
                    @include('bigcommerce.components.fields.access-token-input')
                </div>
                <div class="form-group">
                    @include('bigcommerce.components.fields.client-id-input')
                </div>
                <div class="form-group">
                    @include('bigcommerce.components.fields.client-secret-input')
                </div>
            </div>
        </div>
    </div>
</div>