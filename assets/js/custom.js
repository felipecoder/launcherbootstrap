$(document).ready(function () {
  $('.menu li').click(function () {
    var tab_id = $(this).attr('parent');

    $('.menu li').removeClass('active');
    $('.disabled').removeClass('active');

    $(this).addClass('active');
    $("#" + tab_id).addClass('active');
  })
});