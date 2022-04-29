src = "http://code.jquery.com/jquery-1.11.0.min.js"

function show() {
  var password = document.getElementById("password");
  var icon = document.querySelector(".fas");

  if (password.type === "password") {
    password.type = "text";
    $(".fas").attr("id", "eye-white");
  } else {
    password.type = "password";
    $(".fas").attr("id", "eye");
  }
}

$(document).ready(function loginCheck() {
  $("#loginform").submit(function (e) {
    var FormData = $("#loginform").serialize();
    $.ajax({
      type: "post",
      url: "login.php",
      data: FormData,
      datatype: "json",
      encode: true,
      success: function (response) {
        var message = JSON.parse(response);
        if (message == "Success!") {
          window.location = "/bestclothinginc/featured/featured.php";
        } else
          $("#message").text(message);
      },
    });
    e.preventDefault(); //prevent default form submition

  });
});
