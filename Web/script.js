$(document).ready(function(){
    $(".search-data").fadeIn(500);
    $(".custom-select").fadeIn(1000);
    $(".search-data").css("display", "flex");
    $(".search-data .line").addClass("active");
    $(".custom-select .line2").addClass("active");
    setTimeout(function(){
      $(".search-data label").fadeIn(300);
      $(".search-data span").fadeIn(300);

    }, 500);
  });

function toggleForm() {
    var container = document.querySelector('.container');
    container.classList.toggle('active');
}

var signup = document.getElementById('link-signup');
var signin = document.getElementById('link-signin');

if(signup) {
    signup.addEventListener('click', function() {
        toggleForm();
    });
}

if(signin) {
    signin.addEventListener('click', function() {
        toggleForm();
    });
}

$( function() {
    $( "#tabs" ).tabs();
  } );

$("#btn-index").click(function() {
    window.location.href = "login.php";
});