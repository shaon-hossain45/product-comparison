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
     * Ajax Filter
     * @param  {[type]} value    [description]
     * @return {[type]} value    [description]
     */
    $("button.filter-btn").on("click", function(e) {

        // Stop Multiple form submission
        //e.preventDefault();

        var thisby = $(this);
        const selectedConncetor = $(this).parent().find("select.pa_connector").children("option:selected").val();
        const selectedPower = $(this).parent().find("select.pa_power").children("option:selected").val();
        const selectedBrandModel = $(this).parent().find("select.pa_brand-and-model").children("option:selected").val();
        //console.log(selectedConncetor + selectedPower + selectedBrandModel);

        /**
         * Compare form variable
         * @type {Boolean}
         */

        //if (selectedConncetor != "" || selectedPower != "" || selectedBrandModel != "") {
        /**
         * Data passing to the server with ajax
         * @param  {[type]}      [description]
         * @return {[type]}      [description]
         */

        var data = {
            Conncetor: selectedConncetor,
            Power: selectedPower,
            BrandModel: selectedBrandModel,
            action: pluginkpoo_obj.action,
            security: pluginkpoo_obj.security
        };

        $.ajax({
            type: "POST",
            dataType: "html",
            url: pluginkpoo_obj.ajax_url,
            data: data,
            beforeSend: function(xhr) {
                //form.find("button[type='button']").children("span.spinner-grow").removeClass("d-none");
            },
            success: function(data, status, xhr) {
                //console.log(data + status + xhr);
                if (status == "success") {
                    //alert("ok done");

                    //thisby.parent().find("ul.compare-product__sub-menu").html(data);

                    thisby.closest(".compare-product__wrapper").find("ul.compare-product__sub-menu").html(data);
                    thisby.closest(".compare-product__wrapper").find('.select-dropdown').removeClass("active");
                    thisby.closest(".compare-product__wrapper").find('.compare-product__sub-menu').addClass("active");
                    thisby.toggleClass("active");


                }
            },
            complete: function(xhr, textStatus) {
                //form.find("button[type='button']").children("span.spinner-grow").addClass("d-none");
            }
        });
        //};
        // Stop form submission
        //return false;
    });

})(jQuery, window, document);