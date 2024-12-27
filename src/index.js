import './style.css';
import './slick-init.js';
import {CountUp} from "../static/countUp";
// import './countUp.js';
// import './countUp-jquery.js';

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