jQuery(function ($) {
  // Dropdown menu
  $('.sidebar-dropdown > a').click(function () {
    $('.sidebar-submenu').slideUp(200);
    if ($(this).parent().hasClass('active')) {
      $('.sidebar-dropdown').removeClass('active');
      $(this).parent().removeClass('active');
    } else {
      $('.sidebar-dropdown').removeClass('active');
      $(this).next('.sidebar-submenu').slideDown(200);
      $(this).parent().addClass('active');
    }
  });

  //toggle sidebar
  $('#toggle-sidebar').click(function () {
    $('.page-wrapper').toggleClass('toggled');
  });

  // bind hover if pinned is initially enabled
  if ($('.page-wrapper').hasClass('pinned')) {
    $('#sidebar').hover(
      function () {
        console.log('mouseenter');
        $('.page-wrapper').addClass('sidebar-hovered');
      },
      function () {
        console.log('mouseout');
        $('.page-wrapper').removeClass('sidebar-hovered');
      }
    );
  }

  //Pin sidebar
  $('#pin-sidebar').click(function () {
    if ($('.page-wrapper').hasClass('pinned')) {
      // unpin sidebar when hovered
      $('.page-wrapper').removeClass('pinned');
      $('#sidebar').unbind('hover');
    } else {
      $('.page-wrapper').addClass('pinned');
      $('#sidebar').hover(
        function () {
          console.log('mouseenter');
          $('.page-wrapper').addClass('sidebar-hovered');
        },
        function () {
          console.log('mouseout');
          $('.page-wrapper').removeClass('sidebar-hovered');
        }
      );
    }
  });

  //toggle sidebar overlay
  $('#overlay').click(function () {
    $('.page-wrapper').toggleClass('toggled');
  });

  //switch between themes
  var themes =
    'default-theme legacy-theme chiller-theme ice-theme cool-theme light-theme';
  $('[data-theme]').click(function () {
    $('[data-theme]').removeClass('selected');
    $(this).addClass('selected');
    $('.page-wrapper').removeClass(themes);
    $('.page-wrapper').addClass($(this).attr('data-theme'));
  });

  // switch between background images
  var bgs = 'bg1 bg2 bg3 bg4';
  $('[data-bg]').click(function () {
    $('[data-bg]').removeClass('selected');
    $(this).addClass('selected');
    $('.page-wrapper').removeClass(bgs);
    $('.page-wrapper').addClass($(this).attr('data-bg'));
  });

  // toggle background image
  $('#toggle-bg').change(function (e) {
    e.preventDefault();
    $('.page-wrapper').toggleClass('sidebar-bg');
  });

  // toggle border radius
  $('#toggle-border-radius').change(function (e) {
    e.preventDefault();
    $('.page-wrapper').toggleClass('boder-radius-on');
  });

  //custom scroll bar is only used on desktop
  if (
    !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent
    )
  ) {
    $('.sidebar-content').mCustomScrollbar({
      axis: 'y',
      autoHideScrollbar: true,
      scrollInertia: 300,
    });
    $('.sidebar-content').addClass('desktop');
  }
});

$(document).on('click', '.adminNav', function () {
  $("#loader").fadeIn();
  var self = this;
  setTimeout(function () {
    var link = $(self).attr('link');
    switch (link) {
      case 'product-add':
        var component = 'product-inbound-add.php';
        break;
      case 'product-report':
        var component = 'product-inbound-report.php';
        break;
      case 'employee-add':
        var component = 'employee-add.php?action=adding';
        break;
      case 'employee-list':
        var component = 'employee-list.php';
        break;
      case 'expenses-add':
        var component = 'expenses-add.php';
        break;
      case 'expenses-report':
        var component = 'expenses-report.php';
        break;
      case 'defective-add':
        var component = 'defective-add.php';
        break;
      case 'defective-report':
        var component = 'defective-report.php';
        break;
      case 'delivery-report':
        var component = 'delivery-report.php';
        break;
      case 'sales-report':
        var component = 'sales-report.php';
        break;
      case 'inventory-report':
        var component = 'inventory-report.php';
        break;
      case 'customer-report':
        var component = 'customer-list.php';
        break;
      case 'dashboard':
        var component = 'dashboard.php';
        break;
      default:
        var component = false;

    }
    if (component) {
      $("#loader-img").fadeOut();
      window.location.href = component;
    } else {
      $("#loader-img").hide();
      alert(link + "not found!");
    }
  }, 1000);
  return false;
});