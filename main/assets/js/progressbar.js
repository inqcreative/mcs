// When the user scrolls the page
/*window.onscroll = function () {
    mcsprogressbar()
};

function mcsprogressbar() {
    var winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    var height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    var scrolled = (winScroll / height) * 100;
    document.getElementById("mcsprogress").style.width = scrolled + "%";
}*/


var h = document.documentElement,
  b = document.body,
  st = 'scrollTop',
  sh = 'scrollHeight',
  progress = document.querySelector('#mcsprogress'),
  scroll;

document.addEventListener('scroll', function() {
  scroll = (h[st]||b[st]) / ((h[sh]||b[sh]) - h.clientHeight) * 100;
  progress.style.setProperty('--scroll', scroll + '%');
});