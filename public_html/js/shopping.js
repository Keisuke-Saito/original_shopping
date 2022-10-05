$(function () {
  $('input[type=file]').change(function () {
    var file = $(this).prop('files')[0];

    // 画像以外は処理を停止
    if (!file.type.match('image.*')) {
      // クリア
      $(this).val('');
      $('.imgfile').html('');
      return;
    }

    // 画像表示
    var reader = new FileReader();
    reader.onload = function () {
      var img_src = $('<img>').attr('src', reader.result);
      $('.imgfile').html(img_src);
      $('.imgarea').removeClass('noimage');
    }
    reader.readAsDataURL(file);
  });

  $('.cart__btn').on('click', function () {
    var origin = location.origin;
    var $cartbtn = $(this);
    var $productid = $cartbtn.parent().parent().parent().parent().data('productid');
    var $quantity = $cartbtn.parent().parent().find('.quantity option:selected').data('quantity');
    var $myid = $('.prof-show').data('me');
    $.ajax({
      type: 'post',
      url: origin + '/shopping/public_html/ajax.php',
      data: {
        'product_id': $productid,
        'quantity': $quantity,
        'user_id': $myid,
      },
      success: function (data) {
        if (data == 1) {
          $($cartbtn).parent().find('.cart__text').addClass('cart__in');
          $($cartbtn).addClass('active');
        } else {
          $($cartbtn).parent().find('.cart__text').removeClass('cart__in');
          $($cartbtn).removeClass('active');
        }
      }
    });
    return false;
  });
});