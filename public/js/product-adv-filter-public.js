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


    $('.compare-product__wrapper select').change(function(e) {

        // Stop Multiple form submission
        //e.preventDefault();

        var thisby = $(this);

        const selectVal = thisby.find(":selected").text();
        const columnData = thisby.attr("class");


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
            value: selectVal,
            columndata: columnData,
            action: pluginkuyt_obj.action,
            security: pluginkuyt_obj.security
        };

        $.ajax({
            type: "POST",
            dataType: "json",
            url: pluginkuyt_obj.ajax_url,
            data: data,
            beforeSend: function(xhr) {
                //form.find("button[type='button']").children("span.spinner-grow").removeClass("d-none");
            },
            success: function(data, status, xhr) {
                //console.log(response + status + xhr);
                if (status == "success") {
                    //alert("ok done");

                    // console.log(data["data"]["exists"]);

                    var arr = data["data"]["exists"];

                    var $spans = thisby.parent().parent().find('option').not(':first');
                    $spans.each(function(index) {


                        //console.log(index + $(this).text());

                        if ((jQuery.inArray($(this).text(), arr)) != -1) {

                            var match = $(this).prop('disabled', false);

                        } else {
                            //console.log($(this));

                            if ($(this).val() != "") {
                                $(this).prop('disabled', true);
                            }

                            if ($(this).parent().attr("class") == data["data"]["column"]) {
                                $(this).prop('disabled', false);
                            }

                        }
                    });

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