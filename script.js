var windowHeight = $(window).height();
var documentHeight = $(document).height();
if(windowHeight > documentHeight)
    $('body').css('height', windowHeight);