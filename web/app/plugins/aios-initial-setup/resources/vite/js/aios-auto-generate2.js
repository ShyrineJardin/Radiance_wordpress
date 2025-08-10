function Open() {
  const btn = jQuery("#auto-generate-page-classic-editor"), frame = jQuery(".agp-frame"), $html = jQuery("html");
  btn.on("click", function(e) {
    e.preventDefault();
    frame.addClass("agp-frame-open");
    $html.css("padding-right", window.innerWidth - document.getElementsByTagName("html")[0].offsetWidth + "px");
    $html.css("overflow", "hidden");
  });
}
function Close() {
  const btn = jQuery(".agp-frame-close"), frame = jQuery(".agp-frame"), overlay = jQuery(".agp-frame-overlay"), $html = jQuery("html");
  btn.on("click", function(e) {
    closeContainer();
  });
  overlay.on("click", function(e) {
    closeContainer();
  });
  jQuery(document).keyup(function(e) {
    if (e.keyCode === 27) {
      closeContainer();
    }
  });
  function closeContainer() {
    frame.removeClass("agp-frame-open");
    $html.css("overflow", "visible");
    $html.css("padding-right", "0px");
  }
}
function Selector() {
  const selector = jQuery("#agp-frame-selector");
  const pageSelector = jQuery("#agp-frame-page-selector");
  selector.on("change", function(e) {
    filterByTypePage();
  });
  pageSelector.on("change", function(e) {
    filterByTypePage();
  });
  function filterByTypePage() {
    let itemSelector = "";
    const type = selector.val();
    const page = pageSelector.val();
    if (type !== "all" || page !== "all") {
      jQuery(`.agp-frame-item`).hide();
      if (type !== "all" && page !== "all") {
        itemSelector = `[data-type="${type}"][data-page="${page}"]`;
      } else if (type !== "all") {
        itemSelector = `[data-type="${type}"]`;
      } else if (page !== "all") {
        itemSelector = `[data-page="${page}"]`;
      }
      jQuery(`.agp-frame-item${itemSelector}`).show();
    } else {
      jQuery(`.agp-frame-item`).show();
    }
  }
}
function SelectTemplate() {
  const btn = jQuery(".auto-generate-page-classic-editor");
  btn.on("click", function(e) {
    e.preventDefault();
    request(jQuery(this));
  });
  function request(currentEl) {
    const id = currentEl.data("id");
    const name = currentEl.data("name");
    const type = currentEl.data("type");
    currentEl.attr("disabled", "disabled");
    Swal.fire({
      type: "warning",
      title: "Are you sure you want to override the content?",
      text: "This will generate content and form.",
      showCancelButton: true,
      confirmButtonText: "Yes!"
    }).then((result) => {
      if (result.value === true) {
        Swal.fire({
          type: "warning",
          title: "Auto Generate is in Progress",
          showConfirmButton: false
        });
        const request2 = jQuery.ajax({
          url: `${data.baseUrl}/wp-json/aios-auto-generate-page/v1/generate`,
          type: "post",
          data: {
            id,
            name,
            type
          },
          headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-WP-Nonce": data.nonce
          }
        });
        request2.done(function(data2) {
          Swal.fire({
            type: data2["status"],
            title: data2["message"],
            showConfirmButton: false,
            timer: 1500
          });
          if (data2["edit"] !== null && data2["edit"] !== void 0) {
            setTimeout(function() {
              window.location.href = "/wp-admin/post.php?post=" + data2["edit_id"] + "&action=edit&classic-editor";
            }, 1e3);
          }
        });
        request2.fail(function(xhr, textStatus, errorThrown) {
          Swal.fire(
            xhr.responseJSON.message,
            "We can't process your request.",
            "error"
          );
        });
        currentEl.removeAttr("disabled");
      } else {
        currentEl.removeAttr("disabled");
      }
    });
  }
}
function RevokeTemplate() {
  const btn = jQuery("#auto-generate-revoke-classic-editor");
  btn.on("click", function(e) {
    e.preventDefault();
    const currentEl = jQuery(this);
    const id = currentEl.data("id");
    currentEl.attr("disabled", "disabled");
    Swal.fire({
      type: "warning",
      title: "Revoke preset template?",
      text: "",
      showCancelButton: true,
      confirmButtonText: "Yes!"
    }).then((result) => {
      if (result.value === true) {
        const request = jQuery.ajax({
          url: `${data.baseUrl}/wp-json/aios-auto-generate-page/v1/revoke`,
          type: "post",
          data: {
            id
          },
          headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-WP-Nonce": data.nonce
          }
        });
        request.done(function(data2) {
          Swal.fire({
            type: "success",
            title: "Revoked",
            showConfirmButton: false,
            timer: 1500
          });
          setTimeout(function() {
            window.location.reload();
          }, 1e3);
        });
        request.fail(function(xhr, textStatus, errorThrown) {
          Swal.fire(
            "Error",
            "We can't process your request.",
            "error"
          );
        });
        currentEl.removeAttr("disabled");
      } else {
        currentEl.removeAttr("disabled");
      }
    });
  });
}
function Prerequisite() {
  const btn = jQuery(".auto-generate-page-classic-prerequisite"), btnClose = jQuery(".agp-prerequisite-frame-close");
  btn.on("click", function(e) {
    e.preventDefault();
    jQuery(this);
    jQuery(".agp-prerequisite-frame").removeClass("agp-prerequisite-frame-open");
    jQuery(".agp-prerequisite-frame").addClass("agp-prerequisite-frame-open");
  });
  btnClose.on("click", function(e) {
    e.preventDefault();
    const currentEl = jQuery(this);
    currentEl.parents(".agp-prerequisite-frame").removeClass("agp-prerequisite-frame-open");
  });
}
(function() {
  jQuery(document).ready(function() {
    Open();
    Close();
    Selector();
    SelectTemplate();
    RevokeTemplate();
    Prerequisite();
  });
})(jQuery);
