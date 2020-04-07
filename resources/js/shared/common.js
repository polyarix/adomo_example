// === burger ===
const burger_btn = $("#burger-btn");
const menu_close_btn  = $(".burger-menu-close");
const menu_tl = gsap.timeline({ paused: true, reversed: true , onReverseComplete:reverseFunction});
const menu = $(".burger-menu");
const menu_time = 0.5;

const menu_start = {
    display: 'flex',
    xPercent: -100
};
const menu_end = {
    xPercent: 0,
    display: 'flex',
    ease: Power4.easeInOut,
    onComplete:function(){
        $("body").addClass("overflow-hidden");
        menu.addClass("menuIsOpen")
    }
};
menu_tl.fromTo(menu,menu_time,menu_start,menu_end);

burger_btn.on("click",function(){
    menu_tl.reversed() ?  menu_tl.play() : menu_tl.reverse();
});
menu_close_btn.on("click",function(){
    menu_tl.reverse();
});
$(".burger-menu-mask").on("click",function(e){
    menu_tl.reverse();
});

function reverseFunction(){
    $("body").removeClass("overflow-hidden")
    menu.removeClass("menuIsOpen")
}
// === /burger ===

// === header lk dropdown ===
$(".lk-dropdown").on("click",function(){
    $(this).toggleClass("isOpen")
    $(".header-lk-list").stop().slideToggle();
});
// === /header lk dropdown ===

$(document).mouseup(function(e) {
    var container = $(".header-profile-menu");
    var parent = container.parent('.header-profile');
    var $el = $(e.target);

    // if the target of the click isn't the container nor a descendant of the container
    if (parent.hasClass('open') && !container.is(e.target) && container.has(e.target).length === 0) {
        parent.removeClass('open');
        return;
    }

    if($el.is('.header-profile-button')) {
        parent.toggleClass("open");
    }
});
