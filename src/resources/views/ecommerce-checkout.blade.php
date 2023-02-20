<div class="row">
    <div class="col-md-12">
        @php \Actions::do_action('pre_mojopay_checkout_form',$gateway) @endphp
        <h5>Enter your card details</h5>
        <form id="payment-form" action="{{ url($action) }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    {!! CoralsForm::text('payment_details[number]','Mojopay::attributes.card_number',true,'4457010000000009',['maxlength'=>16,'id'=>'mojopay_number']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {!! CoralsForm::select('payment_details[expiryMonth]', 'Mojopay::attributes.expMonth', \Payments::expiryMonth(), true,now()->format('m')) !!}
                </div>
                <div class="col-md-4">
                    {!! CoralsForm::select('payment_details[expiryYear]', 'Mojopay::attributes.expYear', \Payments::expiryYear(), true,now()->format('Y')) !!}
                </div>
                <div class="col-md-4">
                    {!! CoralsForm::text('payment_details[cvv]','Mojopay::attributes.cvv', true,'349',['placeholder'=>"CCV", 'maxlength'=>4,'id'=>'mojopay_cvv']) !!}
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $('#payment-form').on('submit', function (event) {
        event.preventDefault();

        $form = $('#payment-form');
        $form.find('input[type=text]').empty();
        $form.append("<input type='hidden' name='checkoutToken' value='Mojopay'/>");
        $form.append("<input type='hidden' name='gateway' value='Mojopay'/>");
        ajax_form($form);
    });
</script>
