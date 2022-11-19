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
     * Compare Button Click
     * @param  {[type]} value    [description]
     * @return {[type]} value    [description]
     */

    /**
     * Compare Button Click
     * @param  {[type]} value    [description]
     * @return {[type]} value    [description]
     */

    $(function() {
        $(".hidden-btn").on("click", function(event) {
            //event.stopPropagation();
            var thisby = $(this);
            //thisby.next().next().unbind();
            $(".select-dropdown").removeClass("active");
            $("button.filter-btn").removeClass("active");
            thisby.next().toggleClass("active");
            thisby.parent().children("button.filter-btn").toggleClass("active");
        });
    });

    $(document).mouseup(function(e) {
        var container = $(".btn-filter-group");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $(".select-dropdown").removeClass("active");
            $("button.filter-btn").removeClass("active");
        }
    });

    $(function() {
        $(".compare-product").on("click", function(event) {
            event.stopPropagation();

            var thisby = $(this);

            //thisby.parent().find(".select-dropdown").removeClass("active");

            var navdropdown = $(".compare-product__sub-menu");
            navdropdown.removeClass("active");
            thisby.next("ul.compare-product__sub-menu").toggleClass("active");
            thisby.parent().find("button.filter-btn").removeClass("active");

            navdropdown.click(function(event) {
                event.stopPropagation();
            });

            $("body").click(function() {
                navdropdown.removeClass("active");
                //$("button.filter-btn").removeClass("active");
            });

        });
    });


    $(function() {
        $("#cmpr-btn").on("click", function(event) {
            event.preventDefault();

            var newURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;

            window.location.href = newURL + '/compare/';
        });
    });

})(jQuery, window, document);