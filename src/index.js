import './style.css';
import './slick-init.js';
import {CountUp} from "../static/countUp";

console.log('Разработано https://shibitov.ru');

jQuery('#nav-branches .menu-item-has-children').click(function() {
    jQuery('#nav-branches .menu-item-has-children').toggleClass('expanded');
    jQuery('#nav-branches .menu-item-has-children ul').slideToggle('fast');
});

const countUp = [];
jQuery('.countUp').each(function () {
    countUp[jQuery(this)] = new CountUp(jQuery(this).attr('id'), parseInt(jQuery(this).html()), { enableScrollSpy: true, useGrouping: false, scrollSpyOnce: true });
    countUp[jQuery(this)].start();
})

new WOW().init();

jQuery('.masonry').masonry({
    itemSelector: '.wp-block-image',
});

jQuery(document).ready(function(){
    jQuery("a[href$='.jpg'], a[href$='.JPG'], a[href$='.png'], a[href$='.PNG'], a[href$='.webp'], a[href$='.WEBP'], a[href$='.jpeg'], a[href$='.JPEG']")
        .colorbox({rel:'gallery_1', transition:"elastic", maxWidth:"90%", maxHeight: "90%"});
});

jQuery('#menuOpener, #menuCloser').click(function () {
    jQuery('#nav-main').toggleClass('expanded').toggle('fast');
    jQuery('body').toggleClass('no-overflow');
});

jQuery(document).ready( function () {
    jQuery('.content-wrapper table').wrap( "<div class='table_wrap'></div>" );
});