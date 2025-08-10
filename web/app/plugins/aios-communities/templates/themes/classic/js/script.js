
; (function ($, w, d, h, b) {
  var app = {


    formBind: function () {

      const form = $("form");


      form.submit(function () {
        $(this).find(":input").filter(function () { return !this.value; }).attr("disabled", "disabled");
        return true; // ensure form still submits
      });

    },
    sort: function () {
      const sort = $('#sort');

      sort.on('change', function () {

        const sortVal = $(this).val();
        const inputVal = $('input[name="sort"]').val(sortVal);
        const searchBttn = $('.ai-classic-seach');
        searchBttn.trigger('click');

      });
    },


    init: function () {
      this.formBind();
      this.sort();

    },
  }

  $(document).ready(function () {
    /* Initialize all app functions */
    app.init();
  });


})(jQuery, window, document, 'html', 'body');