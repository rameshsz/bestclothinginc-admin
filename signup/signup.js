
src="http://code.jquery.com/jquery-1.11.0.min.js"

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

$(document).ready(function checkSignup() {
  $("#signupform").submit(function (e) {
    var FormData = $("#signupform").serialize();

    $.ajax({
      type: "post",
      url: "/bestclothinginc/signup/signup.php",
      data: FormData,
      datatype: "json",
      encode: true,
      success: function (response) {
        var message = JSON.parse(response);
        $("#message").text(message)
        if(message=="Success!"){
          window.location="/bestclothinginc/featured/featured.php";
        }
      },
    });
    e.preventDefault(); //prevent default form submition
  });
});
