jQuery(".slider .slides").slick({
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    dots: false,
    adaptiveHeight: true,
    responsive: [
        {
            breakpoint: 768,
            settings: {
                infinite: true,
                dots: true,
                arrows: false,
            }
        },
    ]
});

jQuery(".gallery-slider").slick({
    dots: false,
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    adaptiveHeight: true,
});