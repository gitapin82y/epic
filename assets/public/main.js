$(window).on("scroll", function () {
  $(this).scrollTop()
    ? $("nav").addClass("fixed")
    : $("nav").removeClass("fixed");
});
AOS.init();

$("#testimoni .owl-carousel").owlCarousel({
  nav: !1,
  smartSpeed: 2e3,
  loop: !0,
  autoplay: !0,
  autoplayTimeout: 3e3,
  animateOut: "fadeOut",
  margin: 50,
  responsive: {
    0: { items: 1, margin: 80 },
    768: { items: 2, margin: 100, nav: !0 },
    1200: { items: 3, nav: !0 },
  },
}),
  $(".owl-carousel").each(function () {
    $(this)
      .find(".owl-dot")
      .each(function (e) {
        $(this).attr("aria-label", e + 1);
      });
  });

new PureCounter();
