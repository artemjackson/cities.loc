(function ($, W, D) {
    var JQUERY4U = {};
    //TODO separate to different files
    JQUERY4U.UTIL =
    {
        setupFormValidation: function () {
            //form validation rules
            $("#registerForm").validate({
                rules: {
                    first_name: {
                        required: true,
                        maxlength: 32
                    },
                    last_name: {
                        required: true,
                        maxlength: 32
                    },
                    email: {
                        maxlength: 64,
                        required: true,
                        email: true
                    },
                    password: {
                        minlength: 8,
                        required: true,
                    },
                    password_confirm: {
                        equalTo: "#password",
                        required: true,
                        minlength: 8
                    }
                },

                messages: {
                    first_name: {
                        maxlength: "First name should be less then 32 symbols",
                        required: "Please enter your firstname"
                    },
                    last_name: {
                        maxlength: "First name should be less then 32 symbols",
                        required: "Please enter your lastname"
                    },
                    password: {
                        required: "Please enter a password",
                        minlength: "Your password must be at least 8 characters long"
                    },
                    email: {
                        maxlength: "Email length should be less then 64 symbols",
                        required: "Please enter a valid email address"
                    },
                    password_confirm: {
                        required: "Please enter the password confirm",
                        equalTo: "Password confirm and Password does not math each other"
                    }
                },

                submitHandler: function (form) {
                    form.submit();
                }
            });

            $("#singInForm").validate({
                rules: {
                    email: {
                        maxlength: 64,
                        required: true,
                        email: true
                    },
                    password: {
                        minlength: 8,
                        required: true,
                    }
                },

                messages: {
                    password: {
                        required: "Please enter a password",
                        minlength: "Your password must be at least 8 characters long"
                    },
                    email: {
                        maxlength: "Email length should be less then 32 symbols",
                        required: "Please enter a valid email address"
                    }
                },

                submitHandler: function (form) {
                    form.submit();
                }
            });

            $("#cityForm").validate({
                errorElement: "div",

                //place all errors in a <div id="errors"> element
                errorPlacement: function(error, element) {
                    error.appendTo("div#errors")
                },

                rules: {
                    city_name: {
                        minlength: 1,
                        maxlength: 32,
                        required: true
                    }
                },

                messages: {
                    city_name: {
                        required: "Please enter a city name",
                        minlength: " City name length must be at least 1 characters long",
                        maxlength: " City name length should be less then 32 symbols"
                    }
                },

                submitHandler: function (form) {
                    form.submit();
                }
            });


            $("#regionForm").validate({
                errorElement: "div",

                //place all errors in a <div id="errors"> element
                errorPlacement: function(error, element) {
                    error.appendTo("div#errors")
                },

                rules: {
                    region_name: {
                        minlength: 1,
                        maxlength: 32,
                        required: true
                    }
                },

                messages: {
                    region_name: {
                        required: "Please enter a region name",
                        minlength: "Region name length must be at least 1 characters long",
                        maxlength: "Region name length should be less then 64 symbols"
                    }
                },

                submitHandler: function (form) {
                    form.submit();
                }
            });
        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function ($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);