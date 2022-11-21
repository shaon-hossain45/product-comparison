(function($, window, document, undefined) {
    "use strict";

    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    /**
     * Compare Ajax
     * @param  {[type]} value    [description]
     * @return {[type]} value    [description]
     */
    $(".compare-product__sub-menu").on("click", 'button', function(e) {

        // Stop Multiple form submission
        //e.preventDefault();
        //alert("okk");
        var thisby = $(this);

        var productID = thisby.attr('product_id');


        var colno = thisby.closest('ul.compare-product__sub-menu').data('colno');
        //console.log(colno);
        /**
         * Compare form variable
         * @type {Boolean}
         */
        var isCompareValid = true;

        /**
         * Form validation
         * @return {[type]} [description]
         */
        comproductValid();

        function comproductValid() {
            isCompareValid = true;
            if (productID == "") {
                isCompareValid = false;
                //searchinput.addClass("itech-error");
            } else {
                isCompareValid = true;
                //alert(productID);
                //searchinput.removeClass("itech-error");
            }
        }

        if (isCompareValid == true) {
            /**
             * Data passing to the server with ajax
             * @param  {[type]}      [description]
             * @return {[type]}      [description]
             */

            var data = {
                value: productID,
                dataColumn: colno,
                action: pluginkl888l_obj.action,
                security: pluginkl888l_obj.security
            };

            //var form = thisby.closest("form");

            $.ajax({
                type: "POST",
                dataType: "json",
                url: pluginkl888l_obj.ajax_url,
                data: data,
                beforeSend: function(xhr) {
                    //form.find("button[type='button']").children("span.spinner-grow").removeClass("d-none");
                },
                success: function(response) {
                    //alert("ok done");
                    if (response["data"]["insert"] == "success") {
                        $('.compare__col.product-values.top-column-' + colno).find("ul.compare-product__sub-menu").removeClass('active');
                        //form.next(".itechscr-jk7").find(".itechscr-ivf").html(response["data"]["outputHtml"]);

                        $('.compare__col[data-colno=' + colno + ']').find(".compareImage").html(response["data"]["exists"]["product_image"]);
                        $('.compare__col[data-colno=' + colno + ']').find("h5.compareTitlecolumn").html(response["data"]["exists"]["product_title"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.comparePrice").html(response["data"]["exists"]["price"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.compareWarranty").html(response["data"]["exists"]["WARRANTY"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.compareRfid").html(response["data"]["exists"]["RFID"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.comapreBrand").html(response["data"]["exists"]["Brand"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.compareCharger").html(response["data"]["exists"]["CHARGING_SCHEDULE"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.operational_temperature").html(response["data"]["exists"]["operational_temperature"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.comparePower").html(response["data"]["exists"]["max_power"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.integratedcable").html(response["data"]["exists"]["integrated_cable"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.compareCommunication").html(response["data"]["exists"]["communication"]);
                        $('.compare__col[data-colno=' + colno + ']').find("p.ocppReady").html(response["data"]["exists"]["ocppReady"]);

                        $('.compare__col[data-colno=' + colno + ']').find(".buyNowButton").html("<a href=" + response["data"]["exists"]["product_url"] + ">Buy Now</a>");

                        $('.compare__col[data-colno=' + colno + ']').find("article.advantage").html(response["data"]["exists"]["Advantage"]);
                        $('.compare__col[data-colno=' + colno + ']').find("article.disadvantage").html(response["data"]["exists"]["DisAdvantage"]);


                    }
                },
                complete: function(xhr, textStatus) {
                    //form.find("button[type='button']").children("span.spinner-grow").addClass("d-none");
                }
            });
        };
        // Stop form submission
        //return false;
    });
})(jQuery, window, document);