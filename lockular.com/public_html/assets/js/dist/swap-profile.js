"use strict";

$('[data-profile]').on('click', function () {
  var id = $(this).data('profile');
  var hoverable = $('#clickableContent').find('div.team--sidebar');
  $(hoverable).each(function (idx, elem) {
    if ($(elem).hasClass('team--sidebar--active')) {
      $(elem).removeClass('team--sidebar--active');
    }
  });
  $(id).addClass('team--sidebar--active');
});