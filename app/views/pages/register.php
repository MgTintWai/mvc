<?php require_once APPROOT . '/views/inc/header.php'; ?>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?php echo URLROOT; ?>/images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form"  name="contactForm" method="POST" action="<?php echo URLROOT; ?>/auth/register">

					<?php require APPROOT . '/views/components/auth_message.php'; ?>
					<span class="login100-form-title">
						Cash Flow Register Form
					</span>

					<p class="text-danger ml-4">
						<?php
							if(isset($data['name-err']))
							echo $data['name-err'];
						?>
					</p>

					<div class="wrap-input100 validate-input"  data-validate = "Valid Name is required:">
						<input class="input100" type="text" id="name" onfocus="this.value=''" name="name" placeholder="Username">
						<span class="focus-input100"></span>
						<!-- <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span> -->
					</div>

					<p class="text-danger ml-4">
						<?php
							if(isset($data['email-err']))
							echo $data['email-err'];
						?>
					</p>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="email" id="email" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<!-- <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span> -->
					</div>
					
					<p class="text-danger ml-4">
						<?php
							if(isset($data['password-err']))
							echo $data['password-err'];
						?>
					</p>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password"  name="password" placeholder="Password" id="myInput">
						
						<span class="focus-input100"></span>
						<!-- <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span> -->
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						
						<input type="checkbox" onclick="myFunction()">Show Password
						<span class="focus-input100"></span>
						
					</div>
					
					
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Register
						</button>
					</div>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
						<a class="txt2" href="<?php echo URLROOT; ?>/pages/login">
							Have a account? Login Now!
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
<?php require_once APPROOT . '/views/inc/footer.php'; ?>

<script>

	function myFunction() {
		var x = document.getElementById("myInput");
		if (x.type === "password") {
			x.type = "text";
		} else {
			x.type = "password";
		}
	}

    $(function () {
		
		var str=$('name').val();
		if(/^[a-zA-Z- ]*$/.test(str) == false) {
				alert('Your search string contains illegal characters.');
			}
        $("form[name='contactForm']").validate({
            // Define validation rules
            rules: {
                name: "required",
                email: "required",
                password: "required",
                
                name: {
                    required: true,
					minlength: 6,
                    maxlength: 20,

                },
                email: {
                    required: true,
					minlength: 6,
                    maxlength: 50,
                    email: true
                },
                password: {
					minlength: 8,
					maxlength: 30,
					required: true,
					//pwcheck: true,
					// checklower: true,
					// checkupper: true,
					// checkdigit: true
                },
                
            },
            // Specify validation error messages
            messages: {
				required: "Please enter your name",
				minlength: "Name must be min 6 characters long",

				
                email: {
                    required: "Please enter your email",
                    minlength: "Please enter a valid email address",
                },
                password: {
                    required: "Please enter your password",
                    minlength: "Password length must be min 8 characters long",
                    maxlength: "Password length must not be more than 30 characters long"
                },
                
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    });

	// Email Validation
	$(document).ready(function() {

// form autocomplete off		
$(":input").attr('autocomplete', 'on');

// remove box shadow from all text input
$(":input").css('box-shadow', 'none');



// save button click function
// $("#savebtn").click(function() {

// 	// calling validate function
// 	var response =  validateForm();

// 	// // if form validation fails			
// 	if(response == 0) {
// 		return;
// 	}


// 	// getting all form data
// 	var name      =   $("#name").val();
	
// 	var email     =   $("#email").val();
	
// 	var password  =   $("#password").val();
// 	// alert(name);
// 	// alert(email);
// 	// alert(password);
// 	// exit();
// 	var form_url = '<?php echo URLROOT; ?>/auth/register';
// 	// sending ajax request
// 	$.ajax({

// 		url: form_url,
// 		type: 'post',
// 		data: {
// 				 'name' : name, 
// 				 'email': email,
// 				 'password' : password,
// 				//  'save' : 1
// 			},

// 		// before ajax request
// 		beforeSend: function() {
// 			$("#result").html("<p class='text-success'> Please wait.. </p>");
// 		},	

// 		// on success response
// 		success:function(response) {
// 			$("#result").html(response);

// 			// reset form fields
// 			$("#regForm")[0].reset();
// 		},

// 		// error response
// 		error:function(e) {
// 			$("#result").html("Some error encountered.");
// 		}

// 	});
// });




// ------------- form validation -----------------

// function validateForm() {

// 	// removing span text before message
// 	$("#error").remove();


// 	// validating input if empty
// 	if($("#name").val() == "") {
// 		$("#name").after("<span id='error' class='text-danger'> Enter your name </span>");
// 		return 0;
// 	}

// 	if($("#email").val() == "") {
// 		$("#email").after("<span id='error' class='text-danger'> Enter your email </span>");
// 		return 0;
// 	}

// 	if($("#password").val() == "") {
// 		$("#password").after("<span id='error' class='text-danger'> Enter your password </span>");
// 		return 0;
// 	}

	
// 	return 1;

// }

$("#name").blur(function() {

var name = $('#name').val();

// if name is empty then return
if(name == "") {
	return;
}
var form_url = '<?php echo URLROOT; ?>/auth/formRegister';

// send ajax request if name is not empty
$.ajax({
		url:form_url,
		type: 'post',
		data: {
			'name':name,
			
	},

	success:function(response) {	

		// clear span before error message
		$("#name_error").remove();

		// adding span after name textbox with error message
		$("#name").after("<span id='name_error' class='text-danger'>"+response+"</span>");
	},

	error:function(e) {
		$("#result").html("Something went wrong");
	}

});
});


// ------------------- [ Email blur function ] -----------------

$("#email").blur(function() {

	var email  =  $('#email').val();


	// if email is empty then return
	if(email == "") {
		return;
	}
	var form_url = '<?php echo URLROOT; ?>/auth/formRegister';

	// send ajax request if email is not empty
	$.ajax({
			url:form_url,
			type: 'post',
			data: {
				'email':email,
				'email_check':1,
		},

		success:function(response) {	

			// clear span before error message
			$("#email_error").remove();

			// adding span after email textbox with error message
			$("#email").after("<span id='email_error' class='text-danger'>"+response+"</span>");
		},

		error:function(e) {
			$("#result").html("Something went wrong");
		}

	});
});

$("#passsword").blur(function() {

var password = $('#password').val();


// if password is empty then return
if(password == "") {
	return;
}
var form_url = '<?php echo URLROOT; ?>/auth/formRegister';

// send ajax request if password is not empty
$.ajax({
		url:form_url,
		type: 'post',
		data: {
			'password':password,
			
	},

	success:function(response) {	

		// clear span before error message
		$("#password_error").remove();

		// adding span after password textbox with error message
		$("#password").after("<span id='password_error' class='text-danger'>"+response+"</span>");
	},

	error:function(e) {
		$("#result").html("Something went wrong");
	}

});
});


// -----------[ Clear span after clicking on inputs] -----------

$("#name").keyup(function() {
	$("#error").remove();
});


$("#email").keyup(function() {
	$("#error").remove();
	$("span").remove();
});

$("#password").keyup(function() {
	$("#error").remove();
});

$("#c_password").keyup(function() {
	$("#error").remove();
});

});
</script>