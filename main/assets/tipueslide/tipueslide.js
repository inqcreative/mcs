
/*
Tipue Slide 1.1
Tipue Slide Copyright (c) 2019 Tipue
Tipue Slide is released under the MIT License
http://www.tipue.com/slide
*/


(function($) {

     $.fn.tipueslide = function(options) {
     
          var set = $.extend( {
          
               'chars'                  : 3,
               'newTab'                 : false,               
               'show'                   : 6,
               'speed'                  : 300
          
          }, options);

          return this.each(function() {
               
               var out = '<div class="tipue-slide-wrap">';
               out += '<div class="tipue-slide-icon-wrap"><div class="tipue-slide-icon">&#9906;</div></div>';
               out += '<input type="text" id="tipue-slide-input" autocomplete="off">';
               out += '<div class="tipue-slide-clear-wrap"><div class="tipue-slide-clear">&#10005;</div></div>';
               out += '</div>';
               
               out += '<div class="tipue-slide-close tipue-slide-toggle">&#10005;</div><div class="tipue-clear"></div><div id="tipue-slide-content"></div>';
               
               $('#tipue-slide').html(out);
               
               $('#tipue-slide-input').keyup(function(event)
               {
                    getTipueslide($('#tipue-slide-input'));
               });
               
               function getTipueslide($obj)
               {
                    if ($obj.val().length > set.chars - 1)
                    {
                         $('.tipue-slide-clear').fadeIn(100);
                         
                         out = '';
                         var c = 0;
                         for (var i = 0; i < tipueslide.pages.length; i++)
                         {
                              var pat = new RegExp($obj.val(), 'i');
                              if ((tipueslide.pages[i].title.search(pat) != -1 || tipueslide.pages[i].text.search(pat) != -1) && c < set.show)
                              {
                                   if (tipueslide.pages[i].img)
                                   {
                                        out += '<a class="tipue-not" href="' + tipueslide.pages[i].url + '"';
                                        if (set.newTab)
                                        {
                                             out += ' target="_blank"';
                                        }
                                        out += '><div class="tipue-slide-image" style="background-image: url(\'' + tipueslide.pages[i].img + '\');"><div class="tipue-slide-image-block"><div class="tipue-slide-image-text">' + tipueslide.pages[i].title + '</div></div></div></a>';
                                   }
                                   else
                                   {
                                        out += '<a class="tipue-not" href="' + tipueslide.pages[i].url + '"';
                                        if (set.newTab)
                                        {
                                             out += ' target="_blank"';
                                        }
                                        out += '><div class="tipue-slide-text">' + tipueslide.pages[i].title + '</div></a>';
                                   }
                                   c++;
                              }
                         }
                         if (c != 0)
                         {              
                              $('#tipue-slide-content').html(out);
                              $('#tipue-slide-content').fadeIn(set.speed);
                         }
                    }
                    else
                    {
                         $('#tipue-slide-content').fadeOut(set.speed);
                         $('.tipue-slide-clear').fadeOut(100);
                    }
               }
 
               $('.tipue-slide-toggle').on('click', function(event)
               {
                    event.preventDefault();
                    var slide = $('#tipue-slide');
                    var slideWidth = $('#tipue-slide').width();   	

                    slide.toggleClass('open');

                    if (slide.hasClass('open'))
                    {
                         $('.tipue-slide-screen').show();
                         slide.animate({left: '0'}, 200);
                         $('.tipue-slide-wrap').fadeIn(700);    
                    }
                    else
                    {
                         $('.tipue-slide-screen').hide();
                         slide.animate({left: -slideWidth-1}, 200);
                    }
               });
               
               $('.tipue-slide-clear').on('click', function(event)
               {
                    $('#tipue-slide-input').val('');
                    $('#tipue-slide-content').fadeOut(set.speed, function()
                    {
                         $('#tipue-slide-content').html('');
                    })
                    $('.tipue-slide-clear').fadeOut(100);    
               });
                                   
          });
     };
     
})(jQuery);
