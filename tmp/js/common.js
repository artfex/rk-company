$(document).ready(function () {
   $('input[name="phone"]').inputmask({mask: '+7 999 999-99-99', showMaskOnHover: false});

   $(".pop-up_a").magnificPopup({
      type: 'inline'
   });
});