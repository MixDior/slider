(function ($) {
function slider() {
   let slider= $('.js-slider');
   let slide=slider.attr('data-active-slide')?slider.attr('data-active-slide'):0;
   slider.attr('data-active-slide',slide);
}

    slider();
$('.js-slider-dot').on('click',function (event) {
   // let element = this.target;
    let index = $(this).attr('data-index');
    console.log(index);

});

}(jQuery));