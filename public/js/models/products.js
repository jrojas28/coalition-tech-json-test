var Products = function () {
    $totalPriceField = $('#total-price');
    $('#product-form').on('submit', function (e) {
        e.preventDefault();
        $form = $(this);
        $productHolder = $('#product-holder');
        console.log("Submitting..");

        $.ajax({
            type: 'POST',
            url: '/api/products',
            data: $form.serialize(),
            success: function (product) {
                var product = JSON.parse(product);
                console.log("Success");
                console.log(product);
                console.log(product['name']);
                $templateCopy = $('#template').clone();
                $templateCopy.removeClass('hidden');
                $templateCopy.find('.name').first().html(product['name']);
                $templateCopy.find('.stock').first().html(product.stock);
                $templateCopy.find('.price').first().html('$' + product.price);
                $templateCopy.find('.timestamp').first().html(product.created_at);
                $templateCopy.find('.total').first().html(Math.round(product.stock * product.price));
                $productHolder.append($templateCopy);

                $totalPriceField.html('');
                total = 0;
                $('.total').each(function(index, elem) {
                    console.log(elem)
                    console.log($(elem).html());
                    var val = parseInt($(elem).html());
                    console.log(val);
                    if (!isNaN(val)) {
                        total += parseInt($(elem).html());
                    }
                });
                console.log(total);
                $totalPriceField.html(total);
            }
        });

        // $('.editable').each(function(index, elem) {
        //     editable('/api/' + $(elem).data('id'), {
        //         indicator: "Saving...",
        //         tooltip: "Click to edit...",
        //         callback: function (value, settings) {
        //             var $parent = $($(this).data('parent'));
        //             console.log(this);
        //             console.log($parent);
        //             console.log(value);
        //             console.log(settings);
        //         }
        //     });
        // });
    })
}

$(function () {
    Products();
});