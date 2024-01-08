"use strict";

$('[data-click]').on('click', function () {
  var id = $(this).data('click');
  var hoverable = $('#clickableContent').find('div.home--sidebar');
  $(hoverable).each(function (idx, elem) {
    if ($(elem).hasClass('home--sidebar--active')) {
      $(elem).removeClass('home--sidebar--active');
    }
  });
  $(id).addClass('home--sidebar--active');
});