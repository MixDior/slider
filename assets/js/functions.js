(function ($) {
function slider() {
   let slider= $('.js-slider');
   let slide=slider.attr('data-active-slide')?slider.attr('data-active-slide'):0;
   slider.attr('data-active-slide',slide);
}

    slider();

}(jQuery));