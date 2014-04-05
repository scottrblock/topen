$(document).ready(function(){

  //custom js here
  var base_url = location.protocol + "//" + location.hostname +
        (location.port && ":" + location.port);

  $('a').not('a[href^="' + base_url + '"]')
        .not('a[href^="/"]')
        .not('a[href^="#"]')
        .not('a[href^="mailto"]').on('click', function(e){
      
      e.preventDefault();
      var link = $(this).attr('href');
      window.open(link, '_blank');
  });
  
});