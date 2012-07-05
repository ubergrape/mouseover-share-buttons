
/**
 * AJAX Sharing Widgets
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this file,
 * You can obtain one at http://mozilla.org/MPL/2.0/.
 *
 * Code inspired by TechCrunch development team at 10up (http://www.get10up.com/)
 */
(function($){
 
    // Facebook JS Async
    (function() {
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = 'http://connect.facebook.net/en_US/all.js?ver=MU#xfbml=1';
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    })();
 
    $(document).ready(function(){
      // Share Widgets
      $('article[id^="post"]').bind("mouseenter", function(){
          // Post details
          var id = $(this).attr("id").slice(5);
          var permalink = $('.post-title a', this).attr("href");
          var title = $('.post-title a', this).text();
   
          // Remove icon images
          $('#sharing-' + id).css('background', 'none');
   
          // Facebook
          var fb_str = '<fb:like href="' + permalink + '" layout="button_count" send="false" show_faces="false"></fb:like>';
          $('#fb-newshare-' + id).removeClass('facebook').css('width', 'auto').html(fb_str);
          FB.XFBML.parse(document.getElementById('fb-newshare-' + id));
   
          // LinkedIn
          var linkedin_str = '<scr' + 'ipt id="inshare-' + id + '" type="in/share" data-url="' + permalink + '" data-counter="right"></scr' + 'ipt>';
          $('#linkedin-newshare-' + id).css('width', '110px').removeClass('linkedin').html(linkedin_str);
          if (typeof(IN) != 'object') 
              jQuery.getScript('http://platform.linkedin.com/in.js');
          else 
              IN.parse(document.getElementById('linkedin-newshare-' + id));
   
          // Twitter
          var twitter_str = '<span style="float:left;width:100px;margin-right:5px;"><iframe allowtransparency="true" frameborder="0" scrolling="no" src="http://platform.twitter.com/widgets/tweet_button.html?url=' + permalink + '&amp;text=' + title + '&amp;via=techcrunch" style="width:130px; height:50px;" allowTransparency="true" frameborder="0"></iframe></span>';
          $('#tweet-newshare-' + id).css('width', '110px').removeClass('twitter').html(twitter_str);
   
          // Google Plus
          $('#gplus-newshare-' + id).parent().removeClass('gplus');
          if (typeof(gapi) != 'object') jQuery.getScript('http://apis.google.com/js/plusone.js', function () {
              gapi.plusone.render('gplus-newshare-' + id, {
                  "href": permalink,
                  "size": 'medium'
              });
          });
          else {
              gapi.plusone.render('gplus-newshare-' + id, {
                  "href": permalink,
                  "size": 'medium'
              });
          }
   
          // Only load this process once
          $(this).unbind('mouseenter mouseleave');
      });
    });
})(jQuery);

