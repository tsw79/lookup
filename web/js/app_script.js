/**
 * User: tharwat
 * Date: 2/25/2019
 */
var timer;

$(document).ready(function() {

  $(".result").on("click", function() {
    var siteId = $(this).attr("data-siteId");
    var url = $(this).attr("href");
    if (!siteId) {
      alert("\"data-siteId\" attribute not found");
    }
    addSiteClicks(siteId, url);
    return false; // Prevent page from redirecting
  });

  
  /* Masonry Grid */

  var grid = $(".img-grid");

  grid.on("layoutComplete", function() {
    $(".item img").css("visibility", "visible");
  });

  grid.masonry({
    itemSelector: ".item",
    columnWidth: 200,
    gutter: 5,
    isInitLayout: false
  });

  /* Fancybox */ 

  $("[data-fancybox]").fancybox({
    caption: function(instance, item) {
      var caption = $(this).data('caption') || '';
      var siteUrl = $(this).data('siteurl') || '';
      if ( item.type === 'image' ) {
        caption = (caption.length ? caption + '<br />' : '') +
          '<a href="' + item.src + '">View image</a><br/>' +
          '<a href="' + siteUrl + '">Visit page</a>';
      }
      return caption;
    },
    afterShow: function(instance, item) {
      addImageClicks(item.src);
    }
  });
});


/**
 * Adds 1 count to the DB click attribute for a particular site
 *
 * @param linkId
 * @param url
 */
function addSiteClicks(linkId, url) {

  $.post(
    "ajax/updateSiteClicks.php", {linkId: linkId}
  )
  .done(function(result) {
    // Check for any errors/warnings
    if (result != "") {
      console.log(result);
    }
    window.location.href = url;    // Redirect page
  });
}

/**
 * Adds 1 count to the DB click attribute for a particular image
 *
 * @param linkId
 * @param url
 */
function addImageClicks(imageUrl) {

  $.post(
    "ajax/updateImageClicks.php", {imageUrl: imageUrl}
  )
  .done(function(result) {
    // Check for any errors/warnings
    if (result != "") {
      console.log(result);
    }
  });
}

function loadImage(imgUrl, className) {

  var image = $("<img>");
  image.on("load", function() {
    $("." + className + " a").append(image);
    // Clear timer
    clearTimeout(timer);
    // In 500 milliseconds, invoke masonry
    timer = setTimeout(function() {
      $(".img-grid").masonry();
    }, 500);
  });

  image.on("error", function() {
    // Remove image with broken div and error from grid
    $("." + className).remove();
    // Update the broken image in DB
    $.post(
      "ajax/updateImageBroken.php", {srcUrl: imgUrl}
    );
  });

  image.attr("src", imgUrl);
}
