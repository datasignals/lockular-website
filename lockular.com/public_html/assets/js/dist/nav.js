"use strict";

$('#mobileNav').on('click', function () {
  if ($(this).hasClass('is-active')) {
    $('nav').addClass('active');
    $('body').addClass('page-static');
  } else {
    $('nav').removeClass('active');
    $('body').removeClass('page-static');
  }
});