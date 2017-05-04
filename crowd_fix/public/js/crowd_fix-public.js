jQuery(document).ready(function ($) {


    $('a[data-type="googleplus"]').click(
        function(e){
            e.preventDefault();
            $('.ya-share2__item_service_vkontakte').click();
        }
    );

    $('#wp-submit').click(
        function (e) {
      //      e.preventDefault();
        }
    )

    $('.wpneo_login_form_div').append('<p class="status">'+'</p>')



    // console.log( $('.woocommerce-info').text().indexOf('Please logged in first') > -1 );
    var string_login;

    string_login = ($('.woocommerce-info').text().indexOf('Please logged in first') > -1)  ? $('.woocommerce-info').html('Впервые на сайте? <a class="wpneoShowRegister" href="#">Регистрация</a>') : console.log('false') ;



    ajax_auth_object.redirecturl = location.href;

    // Perform AJAX login/register on form submit
    $('.woocommerce').prepend('<div class="woocommerce-error"></div>');
    $('.woocommerce-error').css('display','none');


    $('form.login ').on('submit', function (e) {
        if (!$(this).valid()) return false;


        // $('p.status', this).show().text(ajax_auth_object.loadingmessage);
        action = 'ajaxlogin';
        var username = $('form.login #username').val();
        var password = $('form.login #password').val();
        console.log(username);
        email = '';
        security = $('form#login #security').val();
        if ($(this).attr('id') == 'register') {
            action = 'ajaxregister';
            username = $('#username').val();
            password = $('#password').val();
            email = $('#email').val();
            security = $('#signonsecurity').val();
        }
        ctrl = $(this);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_auth_object.ajaxurl,
            data: {
                'action': action,
                'username': username,
                'password': password,
                'email': email,
                'security': security
            },

            success: function (data) {



                $('.woocommerce-error').css('display','block');
                $('.woocommerce-error').text(data.message);
                $('p.status').text(data.message);
                console.log(data);
                if (data.loggedin == true) {
                    document.location.href = ajax_auth_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });





    // Display form from link inside a popup

    $('.wpneoShowRegister').live('click', function (e) {

        formtoFadeIn = $('form#register');
        formtoFadeIn.fadeIn();
        
    }); 
    $('#pop_login, #pop_signup').live('click', function (e) {
        formToFadeOut = $('form#register');
        formtoFadeIn = $('form#login');
        if ($(this).attr('id') == 'pop_signup') {
            formToFadeOut = $('form#login');
            formtoFadeIn = $('form#register');
        }
        formToFadeOut.fadeOut(500, function () {
            formtoFadeIn.fadeIn();
        })
        return false;
    });

    // Display lost password form
    $('#pop_forgot').click(function(){
        formToFadeOut = $('form#login');
        formtoFadeIn = $('form#forgot_password');
        formToFadeOut.fadeOut(500, function () {
            formtoFadeIn.fadeIn();
        })
        return false;
    });

    // Close popup
    $(document).on('click', '.login_overlay, .close', function () {
        $('form#login, form#register, form#forgot_password').fadeOut(500, function () {
            $('.login_overlay').remove();
        });
        return false;
    });

    // Show the login/signup popup on click
    $('#show_login, #show_signup').on('click', function (e) {
        $('body').prepend('<div class="login_overlay"></div>');
        if ($(this).attr('id') == 'show_login')
            $('form#login').fadeIn(500);
        else
            $('form#register').fadeIn(500);
        e.preventDefault();
    });

    // Perform AJAX login/register on form submit
    $('form#login, form#register').on('submit', function (e) {
        if (!$(this).valid()) return false;
        $('p.status', this).show().text(ajax_auth_object.loadingmessage);
        action = 'ajaxlogin';
        username = 	$('form#login #username').val();
        password = $('form#login #password').val();
        email = '';
        security = $('form#login #security').val();
        if ($(this).attr('id') == 'register') {
            action = 'ajaxregister';
            username = $('#signonname').val();
            password = $('#signonpassword').val();
            email = $('#email').val();
            security = $('#signonsecurity').val();
        }
        ctrl = $(this);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_auth_object.ajaxurl,
            data: {
                'action': action,
                'username': username,
                'password': password,
                'email': email,
                'security': security
            },
            success: function (data) {
                $('p.status', ctrl).text(data.message);
                if (data.loggedin == true) {
                    document.location.href = ajax_auth_object.redirecturl;
                }
            }
        });
        e.preventDefault();
    });

    // Perform AJAX forget password on form submit
    $('form#forgot_password').on('submit', function(e){
        if (!$(this).valid()) return false;
        $('p.status', this).show().text(ajax_auth_object.loadingmessage);
        ctrl = $(this);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_auth_object.ajaxurl,
            data: {
                'action': 'ajaxforgotpassword',
                'user_login': $('#user_login').val(),
                'security': $('#forgotsecurity').val(),
            },
            success: function(data){
                $('p.status',ctrl).text(data.message);
            }
        });
        e.preventDefault();
        return false;
    });

    // Client side form validation
    if (jQuery("#register").length)
        jQuery("#register").validate(
            {rules:{
                password2:{ equalTo:'#signonpassword'
                }
            }}
        );
    else if (jQuery("#login").length)
        jQuery("#login").validate();
    if(jQuery('#forgot_password').length)
        jQuery('#forgot_password').validate();
});




// FormSave to LocalStorage

(function ($) {
    function formsaver(method, container) {
        function getStorageId(container) {
            return 'formdata__$url__$extra'.replace('$url', location.pathname)
                .replace('$extra', container.attr('id') || '');
        }

        var storageId = getStorageId(container),
            controller = {
                save: function () {
                    this._save(storageId, this.extractValues());
                },
                restore: function () {
                    this.fillFields(this._load(storageId));
                },
                clear: function () {
                    this._remove(storageId);
                },

                extractValues: function () {
                    var formData = container.find(":input[name]").serializeArray(),
                        preparedData = {};

                    $.each(formData, function (index, element) {
                        var name = element.name,


                            value = encodeURIComponent(element.value);

                        if (preparedData[name]) {
                            preparedData[name] = preparedData[name] instanceof Array ?
                                preparedData[name].concat(value) :
                                [preparedData[name], value];

                        } else {
                            preparedData[name] = value;
                        }
                    });



                    var full_description = tinyMCE.editors[0].getContent();
                    var short_description = tinyMCE.editors[1].getContent();
                    var reward_description = tinyMCE.editors[2].getContent();



                    preparedData['wpneo-form-description'] = full_description;
                    preparedData['wpneo-form-short-description'] = short_description;
                    preparedData['wpneo_rewards_description'] = reward_description;



                    console.log(preparedData);

                    return preparedData;

                },

                fillFields: function (formData) {
                    $.each(formData, function (name, value) {

                        if (name.indexOf('[]') === -1) {
                            var field = container.find("[name=" + name + "]"),
                                inputType = field.prop('type');
                            value = value instanceof Array ? value.map(decodeURIComponent) :
                                decodeURIComponent(value);
                            if (inputType === 'checkbox') {
                                field.prop('checked', 'checked');
                            } else if (inputType === 'radio') {
                                field.filter("[value=" + value + "]").prop('checked', true);
                            }
                            else if (inputType === 'number') {
                                field.val(value);
                            }

                            else {
                                field.val(value);

                            }
                        }

                    });


                    tinymce.init({
                        selector: 'textarea',  // change this value according to your HTML
                        init_instance_callback : function(editor) {
                            console.log("Editor: " + editor.id + " is now initialized.");

                            tinymce.editors[0].setContent(  formData["wpneo-form-description"] );
                            tinymce.editors[1].setContent( formData["wpneo-form-short-description"] );
                            tinymce.editors[2].setContent( formData["wpneo_rewards_description"]) ;
                        }
                    });



                },

                _save: function (storageId, data) {
                    localStorage[storageId] = JSON.stringify(data);
                },
                _load: function (storageId) {
                    return localStorage[storageId] ? JSON.parse(localStorage[storageId]) : {};
                },
                _remove: function (storageId) {
                    localStorage.removeItem(storageId);
                }
            },
            methodsQueue = method instanceof Array ? method : [method];

        $.each(methodsQueue, function (index, method) {
            controller[method]();
        });
    }

    $.fn.saveForm = function () {
        formsaver('save', $(this));
    };

    $.fn.restoreForm = function () {
        formsaver(['restore'], $(this));
    };

    $.fn.clearForm = function () {
        formsaver(['clear'], $(this));
    };

})(jQuery);



 jQuery(document).ready(function($){


    // wpneo-wrapper new-acc-dashboard

     var newdashboard = $('#new-acc-dashboard');


     if (newdashboard) {
         var wpneo_links = newdashboard.find('ul.wpneo-links');
         var wpneo_link = wpneo_links.find('li');
         var wpneo_content = newdashboard.find('.wpneo-content');

         wpneo_link.click(
             function (event) {
                 event.preventDefault();
                 wpneo_link.removeClass('active');
                 wpneo_content.addClass('hidden');

                 $(this).addClass('active');
                 var tab_attr = $(this).attr('data-attr');
                 var el_str = "div[data-tab="+ tab_attr +"]"

                 newdashboard.find(el_str).removeClass('hidden');
             }
         );

     }



    $('td.order-total a').click(
        function () {
            $(this).parent('td').find('.reward_description').css( 'display' , 'block' );
        },

        function () {
            $(this).parent('td').find('.reward_description').toggle();
        }
    );




    if (  $("#wpneofrontenddata").is(':visible') && location.href.indexOf('edit') == -1  ) {       // Если есть форма добавления компании на странице

        $("#wpneofrontenddata").restoreForm(); // Восстанавливаем значения формы при загрузке
        console.log('wpneofrontenddata');
        $("#wpneofrontenddata").find('input').each(
            function () {
             var name = $(this).attr('name');
                if (typeof  name != 'undefined') {
                    if ( name.indexOf('[]') != -1 ) {
                        var newname = name.replace("[]", "");
                        $(this).attr('name', newname);
                    }
                }

            }
        );

        // $('body').append(
        //     '<div class="restore-form-compaign closed">' +
        //     '<div class="close"></div>' +
        //     '<h3>Восстановить из черновика</h3>' +
        //     '<hr>' +
        //         '<div class="c-ul"></div>' +
        //     '<hr>' +
        //     '<a class="restore_this">Восстановить</a>' +
        //     '<a class="delete_this">Удалить</a>' +
        //     '</div>'
        // );

        $('.restore-form-compaign .close').click(
            function () {
                $('.restore-form-compaign').toggleClass('closed');
            }
        );

            $('.wpneo-form-action ').append('<button class="save_btn wpneo-cancel-campaign">Сохранить проект</button>');
            $('.save_btn').click(
                function () {
                    $(this).addClass('saved');
                }
            );

            $(".save_btn").click(function () {           // SAVE
                $("#wpneofrontenddata").saveForm();
                console.log('save');
                return false;
            });


            $(".restore_this").click(function () {        // RESTORE
                $("#wpneofrontenddata").restoreForm();
                console.log('restore');
                return false;
            });


            $(".delete_this").click(function () {          // DELETE
                $("#wpneofrontenddata").clearForm();
                console.log('clear');
                return false;
            });

        $("#wpneofrontenddata input").change(
            function () {
                $("#wpneofrontenddata").saveForm();
            }
        );




        // Кастомный селект FormStyler инициализация



  if ( typeof(tinymce) != "undefined") {


      // tinymce.init({
      //     selector: 'textarea',  // change this value according to your HTML
      //     init_instance_callback : function(editor) {
      //         console.log("Editor: " + editor.id + " is now initialized.");
      //
      //     }
      // });

  }


    } // if form end

});


(function($) {
    $(function() {
        console.log('select');

        $('select').styler();

    });
})(jQuery);



