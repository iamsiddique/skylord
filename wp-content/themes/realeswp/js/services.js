var map;
var appMap;
var geocoder;

(function($) {
    "use strict";

    var markers = new Array();
    var markerCluster = null;

    var marker_path = "M19.2,0C8.7,0,0.1,8.3,0,18.5c0,4.2,1.3,8,3.7,11.1l15,18.4l15.4-18.4c2.4-3.1,3.9-6.9,3.9-11.1C38.1,8.3,29.7,0,19.2,0z   M19,26.2c-4,0-7.2-3.2-7.2-7.2s3.2-7.2,7.2-7.2s7.2,3.2,7.2,7.2S23,26.2,19,26.2z";
    var newMarkerImage = {
        path: marker_path,
        fillColor: '#333333',
        fillOpacity: 1,
        strokeColor: '',
        strokeWeight: 0,
        scale: 0.75,
        anchor: new google.maps.Point(19,47)
    };
    var markerImage = {
        path: marker_path,
        fillColor: services_vars.marker_color,
        fillOpacity: 1,
        strokeColor: '',
        strokeWeight: 0,
        scale: 0.75,
        anchor: new google.maps.Point(19,47)
    };

    function urlParam(name) {
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if (results==null){
           return null;
        }
        else{
           return results[1] || 0;
        }
    }

    function getPathFromUrl(url) {
        return url.split("?")[0];
    }

    function userSignup() {
        var username = $('#usernameSignup').val();
        var firstname = $('#firstnameSignup').val();
        var lastname = $('#lastnameSignup').val();
        var email = $('#emailSignup').val();
        var pass_1 = $('#pass1Signup').val();
        var pass_2 = $('#pass2Signup').val();
        var register_as_agent = $('#register_as_agent').is(':checked');
        var security = $('#securitySignup').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $('#submitSignup').html(services_vars.signin_loading).addClass('disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_user_signup_form',
                'signup_user': username,
                'signup_firstname': firstname,
                'signup_lastname': lastname,
                'signup_email': email,
                'signup_pass_1': pass_1,
                'signup_pass_2': pass_2,
                'register_as_agent': register_as_agent,
                'security': security
            },
            success: function(data) {
                $('#submitSignup').html(services_vars.signup_text).removeClass('disabled');
                if(data.signedup === true) {
                    var message = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-check-circle"></span></div>' + data.message +
                                  '</div>';
                    $('#signup').modal('hide');
                    $('#signin').modal('show').on('shown.bs.modal', function(e) {
                        $('#signinMessage').empty().append(message);
                    });
                } else {
                    var message = '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-ban"></span></div>' + data.message +
                                  '</div>';
                    $('#signupMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#submitSignup').click(function() {
        userSignup();
    });

    $('#usernameSignup, #firstnameSignup, #lastnameSignup, #emailSignup, #pass1Signup, #pass2Signup').keydown(function(e) {
        if(e.keyCode === 13) {
            e.preventDefault();
            userSignup();
        }
    });

    function userSignin() {
        var username = $('#usernameSignin').val();
        var password = $('#passwordSignin').val();
        var security = $('#securitySignin').val();
        var remember = $('#rememberSignin').is(':checked');
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $('#submitSignin').html(services_vars.signin_loading).addClass('disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_user_signin_form',
                'signin_user': username,
                'signin_pass': password,
                'remember': remember,
                'security': security
            },
            success: function(data) {
                $('#submitSignin').html(services_vars.signin_text).removeClass('disabled');
                if(data.signedin === true) {
                    var message = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-check-circle"></span></div>' + data.message +
                                  '</div>';
                    $('#signinMessage').empty().append(message);
                    document.location.href = services_vars.signin_redirect;
                } else {
                    var message = '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-ban"></span></div>' + data.message +
                                  '</div>';
                    $('#signinMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#submitSignin').click(function() {
        userSignin();
    });

    $('#usernameSignin, #passwordSignin').keydown(function(e) {
        if(e.keyCode === 13) {
            e.preventDefault();
            userSignin();
        }
    });

    function forgotPassword() {
        var email = $('#emailForgot').val();
        var postID = $('#postID').val();
        var security = $('#securityForgot').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $('#submitForgot').html(services_vars.forgot_loading).addClass('disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_forgot_pass_form',
                'forgot_email': email,
                'security-login': security,
                'postid': postID
            },

            success: function(data) {
                $('#submitForgot').html(services_vars.forgot_text).removeClass('disabled');
                $('#emailForgot').val('');

                if(data.sent === true) {
                    var message = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-check-circle"></span></div>' + data.message +
                                  '</div>';
                    $('#forgotMessage').empty().append(message);
                    $('.forgotField').hide();
                } else {
                    var message = '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-ban"></span></div>' + data.message +
                                  '</div>';
                    $('#forgotMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#submitForgot').click(function() {
        forgotPassword();
    });

    $('#emailForgot').keydown(function(e) {
        if(e.keyCode === 13) {
            e.preventDefault();
            forgotPassword();
        }
    });

    if(urlParam('action') && urlParam('action') == 'rp') {
        $('#resetpass').modal('show');
    }

    function resetPassword() {
        var pass_1 = $('#resetPass_1').val();
        var pass_2 = $('#resetPass_2').val();
        var key = urlParam('key');
        var login = urlParam('login');
        var security = $('#securityResetpass').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $('#submitResetPass').html(services_vars.reset_pass_loading).addClass('disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_reset_pass_form',
                'pass_1': pass_1,
                'pass_2': pass_2,
                'key': key,
                'login': login,
                'security-reset': security
            },

            success: function(data) {
                $('#submitResetPass').html(services_vars.reset_pass_text).removeClass('disabled');
                $('#resetPass_1').val('');
                $('#resetPass_2').val('');

                if(data.reset === true) {
                    var message = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-check-circle"></span></div>' + data.message +
                                  '</div>';
                    $('#resetpass').modal('hide');
                    $('#signin').modal('show').on('shown.bs.modal', function(e) {
                        $('#signinMessage').empty().append(message);
                    });
                } else {
                    var message = '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-ban"></span></div>' + data.message +
                                  '</div>';
                    $('#resetPassMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#submitResetPass').click(function() {
        resetPassword();
    });

    $('#resetPass_1, #resetPass_2').keydown(function(e) {
        if(e.keyCode === 13) {
            e.preventDefault();
            resetPassword();
        }
    });

    $('#fbLoginBtn').click(function() {
        $('.signinFBText').html(services_vars.fb_login_loading);
        fbLogin();
    });

    function fbLogin() {
        FB.getLoginStatus(function(response) {
            if(response.status === 'connected') {
                var newUser = getUserInfo(function(user) {
                    var newUserAvatar = getUserPhoto(function(photo) {
                        wpFBLogin(user, photo);
                    });
                });
            } else if(response.status === 'not_authorized') {
                FB.login(function(response) {
                    if(response.authResponse) {
                        var newUser = getUserInfo(function(user) {
                            var newUserAvatar = getUserPhoto(function(photo) {
                                wpFBLogin(user, photo);
                            });
                        });
                    } else {
                        $('.signinFBText').html(services_vars.fb_login_text);
                        var message = '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                          '<div class="icon"><span class="fa fa-ban"></span></div>' + services_vars.fb_login_error +
                                      '</div>';
                        $('#signinMessage').empty().append(message);
                    }
                }, {
                    scope: 'public_profile, email'
                });
            } else {
                FB.login(function(response) {
                    if(response.authResponse) {
                        var newUser = getUserInfo(function(user) {
                            var newUserAvatar = getUserPhoto(function(photo) {
                                wpFBLogin(user, photo);
                            });
                        });
                    } else {
                        $('.signinFBText').html(services_vars.fb_login_text);
                        var message = '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                          '<div class="icon"><span class="fa fa-ban"></span></div>' + services_vars.fb_login_error +
                                      '</div>';
                        $('#signinMessage').empty().append(message);
                    }
                }, {
                    scope: 'public_profile, email'
                });
            }
        });
    }

    function getUserInfo(callback) {
        FB.api('/me', function(response) {
            callback(response);
        });
    }

    function getUserPhoto(callback) {
        FB.api('/me/picture?type=normal', function(response) {
            callback(response.data.url);
        });
    }

    function wpFBLogin(user, photo) {
        var userid = user.id;
        var username = user.name;
        username = username.toLowerCase().replace(' ', '') + userid;
        var firstname = user.first_name;
        var lastname = user.last_name;
        var email = user.email;
        var avatar = photo;
        var security = $('#securitySignin').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_facebook_login',
                'userid': userid,
                'signin_user': username,
                'first_name': firstname,
                'last_name': lastname,
                'email': email,
                'avatar': avatar,
                'security': security
            },
            success: function(data) {
                $('.signinFBText').html(services_vars.fb_login_text);
                if(data.signedin === true) {
                    var message = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-check-circle"></span></div>' + data.message +
                                  '</div>';
                    $('#signinMessage').empty().append(message);
                    document.location.href = services_vars.signin_redirect;
                } else {
                    var message = '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-ban"></span></div>' + data.message +
                                  '</div>';
                    $('#signinMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    $('#googleSigninBtn').click(function() {
        $('.signinGText').html(services_vars.google_signin_loading);
        var additionalParams = {
            'callback': googleSignin,
            'scope': 'profile email'
        };
        gapi.auth.signIn(additionalParams);
    });

    function googleSignin(authResult) {
        if (authResult['status']['signed_in']) {
            gapi.client.load('plus', 'v1', gapiClientLoaded);
        } else {
            $('.signinGText').html(services_vars.google_signin_text);
            var message = '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                              '<div class="icon"><span class="fa fa-ban"></span></div>' + services_vars.google_signin_error +
                          '</div>';
            $('#signinMessage').empty().append(message);
        }
    }

    function gapiClientLoaded() {
        gapi.client.plus.people.get({userId: 'me'}).execute(handleGoogleResponse);
    }

    function handleGoogleResponse(resp) {
        var userid = resp.id;
        var username = resp.displayName;
        username = username.toLowerCase().replace(' ', '') + userid;
        var firstname = resp.name.givenName;
        var lastname = resp.name.familyName;
        var email;
        for (var i=0; i < resp.emails.length; i++) {
            if (resp.emails[i].type === 'account') {
                email = resp.emails[i].value;
            }
        }
        var avatar = getPathFromUrl(resp.image.url);
        var security = $('#securitySignin').val();
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_google_signin',
                'userid': userid,
                'signin_user': username,
                'first_name': firstname,
                'last_name': lastname,
                'email': email,
                'avatar': avatar,
                'security': security
            },
            success: function(data) {
                $('.signinGText').html(services_vars.google_signin_text);
                if(data.signedin === true) {
                    var message = '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-check-circle"></span></div>' + data.message +
                                  '</div>';
                    $('#signinMessage').empty().append(message);
                    document.location.href = services_vars.signin_redirect;
                } else {
                    var message = '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                      '<div class="icon"><span class="fa fa-ban"></span></div>' + data.message +
                                  '</div>';
                    $('#signinMessage').empty().append(message);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    function handleNoGeolocation(errorFlag) {
        if (errorFlag) {
            alert('Error: The Geolocation service failed.');
        } else {
            alert('Error: Your browser doesn\'t support geolocation.');
        }
    }

    function formatPrice(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function addMarkers(props, map) {
        $.each(props, function(i, prop) {
            var latlng = new google.maps.LatLng(prop.lat,prop.lng);
            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                icon: markerImage,
                draggable: false,
                animation: google.maps.Animation.DROP,
            });

            var images = prop.gallery.split('~~~');
            var price = '';
            if(prop.currency_pos == 'before') {
                price = prop.currency + formatPrice(prop.price) + prop.price_label;
            } else {
                price = formatPrice(prop.price) + prop.currency + prop.price_label;
            }
            var propTitle = prop.data ? prop.data.post_title : prop.title;
            var infoboxContent = '<div class="infoW">' +
                                    '<div class="propImg">' +
                                        '<img src="' + images[1] + '">' +
                                        '<div class="propBg">' +
                                            '<div class="propPrice">' + price + '</div>';
            if(prop.type.length > 0) {
                infoboxContent +=           '<div class="propType">' + prop.type[0].name + '</div>';
            }
            infoboxContent +=           '</div>' +
                                    '</div>' +
                                    '<div class="paWrapper">' +
                                        '<div class="propTitle">' + propTitle + '</div>' +
                                        '<div class="propAddress">';
            if(prop.address != '') {
                infoboxContent +=           prop.address + ', ';
            }
            if(prop.city != '') {
                infoboxContent +=           prop.city;
            }
            infoboxContent +=            '</div>' +
                                    '</div>' +
                                    '<ul class="propFeat">';
            if(prop.bedrooms != '') {
                infoboxContent +=       '<li><span class="fa fa-moon-o"></span> ' + prop.bedrooms + '</li>';
            }
            if(prop.bathrooms != '') {
                infoboxContent +=       '<li><span class="icon-drop"></span> ' + prop.bathrooms + '</li>';
            }
            if(prop.area != '') {
                infoboxContent +=       '<li><span class="icon-frame"></span> ' + prop.area + ' ' + prop.unit + '</li>';
            }
            infoboxContent +=       '</ul>' +
                                    '<div class="clearfix"></div>' +
                                    '<div class="infoButtons">' +
                                        '<a class="btn btn-sm btn-round btn-gray btn-o closeInfo">' + services_vars.infobox_close_btn + '</a>' +
                                        '<a href="' + prop.link + '" class="btn btn-sm btn-round btn-green viewInfo">' + services_vars.infobox_view_btn + '</a>' +
                                    '</div>' +
                                 '</div>';

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infobox.setContent(infoboxContent);
                    infobox.open(map, marker);
                }
            })(marker, i));

            $(document).on('touchend', '.closeInfo', function(e) {
                infobox.open(null,null);
            });
            $(document).on('click', '.closeInfo', function(e) {
                infobox.open(null,null);
            });

            markers.push(marker);
        });
    }

    var options = {
        zoom : parseInt(services_vars.zoom),
        mapTypeId : 'Styled',
        panControl: false,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: true,
        overviewMapControl: false,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL,
            position: google.maps.ControlPosition.RIGHT_TOP
        },
        streetViewControlOptions: {
            position: google.maps.ControlPosition.RIGHT_TOP
        }
    };
    var homeOptions = {
        zoom : parseInt(services_vars.zoom),
        mapTypeId : 'Styled',
        panControl: false,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: true,
        overviewMapControl: false,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL,
            position: google.maps.ControlPosition.RIGHT_CENTER
        },
        streetViewControlOptions: {
            position: google.maps.ControlPosition.RIGHT_CENTER
        }
    };
    var panoramaOptions = {
        zoomControl: true,
        panControl: false,
        addressControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER
        },
        linksControl: false,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL,
            position: google.maps.ControlPosition.RIGHT_TOP
        }
    }
    var styles = [{
        stylers : [ {
            hue : "#cccccc"
        }, {
            saturation : -100
        }]
    }, {
        featureType : "road",
        elementType : "geometry",
        stylers : [ {
            lightness : 100
        }, {
            visibility : "simplified"
        }]
    }, {
        featureType : "road",
        elementType : "labels",
        stylers : [ {
            visibility : "on"
        }]
    }, {
        featureType: "poi",
        stylers: [ {
            visibility: "off"
        }]
    }];
    var cityOptions = {
        types : [ '(cities)' ]
    };
    var infobox = new InfoBox({
        disableAutoPan: false,
        maxWidth: 202,
        pixelOffset: new google.maps.Size(-101, -282),
        zIndex: null,
        boxStyle: {
            background: "url('" + services_vars.theme_url + "/images/infobox-bg.png') no-repeat",
            opacity: 1,
            width: "202px",
            height: "245px"
        },
        closeBoxMargin: "28px 26px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        pane: "floatPane",
        enableEventPropagation: false
    });
    if($('#homeMap').length > 0) {
        $('.home-header').addClass('map');
        var mapLocation = $('#homeMap').attr('data-location');

        map = new google.maps.Map(document.getElementById('homeMap'), homeOptions);
        var styledMapType = new google.maps.StyledMapType(styles, {
            name : 'Styled'
        });
        map.mapTypes.set('Styled', styledMapType);

        if (mapLocation == 'default coordinates') {
            var dLat = $('#homeMap').attr('data-lat');
            var dLng = $('#homeMap').attr('data-lng');
            var dPosition = new google.maps.LatLng(dLat, dLng);
            map.setCenter(dPosition);
            map.setZoom(parseInt(services_vars.zoom));

            geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': dPosition}, function(results, status) {
                if(status == google.maps.GeocoderStatus.OK) {
                    var city;
                    for(var i = 0; i < results.length; i++) {
                        if(results[i].types[0] == 'locality') {
                            city = results[i].address_components[0].long_name;
                        }
                    }

                    if(city != '') {
                        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';   
                        var security = $('#securityHomeMap').val();

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: ajaxURL,
                            data: {
                                'action': 'reales_get_properties_by_city',
                                'city': city,
                                'security': security
                            },
                            success: function(data) {
                                if(data.getprops === true) {
                                    addMarkers(data.props, map);

                                    markerCluster = new MarkerClusterer(map, markers, {
                                        maxZoom: 18,
                                        gridSize: 60,
                                        styles: [
                                            {
                                                url: services_vars.theme_url + '/images/clusters/cluster-1.png',
                                                width: 40,
                                                height: 40,
                                                fontFamily: "'Open Sans', sans-serif, Arial",
                                                fontWeight: "normal",
                                                textColor: "#fff"
                                            },
                                            {
                                                url: services_vars.theme_url + '/images/clusters/cluster-2.png',
                                                width: 40,
                                                height: 40,
                                                fontFamily: "'Open Sans', sans-serif, Arial",
                                                fontWeight: "normal",
                                                textColor: "#fff"
                                            },
                                            {
                                                url: services_vars.theme_url + '/images/clusters/cluster-3.png',
                                                width: 40,
                                                height: 40,
                                                fontFamily: "'Open Sans', sans-serif, Arial",
                                                fontWeight: "normal",
                                                textColor: "#fff"
                                            }
                                        ]
                                    });
                                }
                            },
                            error: function(errorThrown) {

                            }
                        });
                    }
                }
            });
        } else {

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    map.setCenter(userPosition);
                    map.setZoom(parseInt(services_vars.zoom));

                    geocoder = new google.maps.Geocoder();
                    geocoder.geocode({'latLng': userPosition}, function(results, status) {
                        if(status == google.maps.GeocoderStatus.OK) {
                            var city;
                            for(var i = 0; i < results.length; i++) {
                                if(results[i].types[0] == 'locality') {
                                    city = results[i].address_components[0].long_name;
                                }
                            }

                            if(city != '') {
                                var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
                                var security = $('#securityHomeMap').val();

                                $.ajax({
                                    type: 'POST',
                                    dataType: 'json',
                                    url: ajaxURL,
                                    data: {
                                        'action': 'reales_get_properties_by_city',
                                        'city': city,
                                        'security': security
                                    },
                                    success: function(data) {
                                        if(data.getprops === true) {
                                            addMarkers(data.props, map);

                                            markerCluster = new MarkerClusterer(map, markers, {
                                                maxZoom: 18,
                                                gridSize: 60,
                                                styles: [
                                                    {
                                                        url: services_vars.theme_url + '/images/clusters/cluster-1.png',
                                                        width: 40,
                                                        height: 40,
                                                        fontFamily: "'Open Sans', sans-serif, Arial",
                                                        fontWeight: "normal",
                                                        textColor: "#fff"
                                                    },
                                                    {
                                                        url: services_vars.theme_url + '/images/clusters/cluster-2.png',
                                                        width: 40,
                                                        height: 40,
                                                        fontFamily: "'Open Sans', sans-serif, Arial",
                                                        fontWeight: "normal",
                                                        textColor: "#fff"
                                                    },
                                                    {
                                                        url: services_vars.theme_url + '/images/clusters/cluster-3.png',
                                                        width: 40,
                                                        height: 40,
                                                        fontFamily: "'Open Sans', sans-serif, Arial",
                                                        fontWeight: "normal",
                                                        textColor: "#fff"
                                                    }
                                                ]
                                            });
                                        }
                                    },
                                    error: function(errorThrown) {

                                    }
                                });
                            }
                        }
                    });

                }, function() {
                    handleNoGeolocation(true);
                });
            } else {
                // Browser doesn't support Geolocation
                handleNoGeolocation(false);
            }
        }
    }

    if($('#mapView').length > 0) {
        var propsAjaxURL = services_vars.admin_url + 'admin-ajax.php';
        var propsSecurity = $('#securityAppMap').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: propsAjaxURL,
            data: {
                'action': 'reales_get_searched_properties',
                'country': services_vars.search_country,
                'state': services_vars.search_state,
                'city': services_vars.search_city,
                'category': services_vars.search_category,
                'type': services_vars.search_type,
                'min_price': services_vars.search_min_price,
                'max_price': services_vars.search_max_price,
                'bedrooms' : services_vars.search_bedrooms,
                'bathrooms' : services_vars.search_bathrooms,
                'neighborhood' : services_vars.search_neighborhood,
                'min_area' : services_vars.search_min_area,
                'max_area' : services_vars.search_max_area,
                'amenities': services_vars.search_amenities,
                'page': services_vars.page,
                'sort': services_vars.sort,
                'security': propsSecurity
            },
            success: function(data) {
                appMap = new google.maps.Map(document.getElementById('mapView'), options);
                var styledMapType = new google.maps.StyledMapType(styles, {
                    name : 'Styled'
                });
                appMap.mapTypes.set('Styled', styledMapType);
                appMap.getStreetView().setOptions(panoramaOptions);

                var searchedPosition = new google.maps.LatLng(services_vars.search_lat, services_vars.search_lng);
                appMap.setCenter(searchedPosition);
                appMap.setZoom(parseInt(services_vars.zoom));

                if(data.getprops === true) {
                    addMarkers(data.props, appMap);

                    appMap.fitBounds(markers.reduce(function(bounds, marker) {
                        return bounds.extend(marker.getPosition());
                    }, new google.maps.LatLngBounds()));

                    google.maps.event.trigger(appMap, 'resize');

                    markerCluster = new MarkerClusterer(appMap, markers, {
                        maxZoom: 18,
                        gridSize: 60,
                        styles: [
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-1.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            },
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-2.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            },
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-3.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            }
                        ]
                    });
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    if($('#mapIdxView').length > 0) {
        var props = [];

        if($('.dsidx-results').length > 0) {
            var idxProps = dsidx.dataSets['results'];

            $.each(idxProps, function(i, idxProp) {
                var prop = new Object();
                prop.lat = idxProp.Latitude;
                prop.lng = idxProp.Longitude;
                prop.gallery = '~~~' + idxProp.PhotoUriBase + '0-full.jpg';
                prop.type = [];
                prop.price = idxProp.Price;
                prop.currency = '';
                prop.price_label = '';
                prop.title = idxProp.Address;
                prop.address = idxProp.City;
                prop.city = '';
                prop.bedrooms = parseInt(idxProp.BedsTotal);
                prop.bathrooms = parseInt(idxProp.BathsTotal);
                prop.area = idxProp.LotSqFt;
                prop.link = services_vars.home_redirect + '/idx/' + idxProp.PrettyUriForUrl;
                prop.unit = services_vars.search_unit;

                props.push(prop);
            });
        }

        if($('.dsidx-details').length > 0) {
            var prop = new Object();

            prop.lat = dsidx.details.latitude;
            prop.lng = dsidx.details.longitude;
            prop.gallery = '~~~' + dsidx.details.photoUriBase + '0-full.jpg';
            prop.type = [];
            prop.price = $('#dsidx-price td').text();
            prop.currency = '';
            prop.price_label = '';
            var idxTitleStr = $('#idx-title').text().split(",");
            prop.title = idxTitleStr[0];
            prop.address = dsidx.details.city;
            prop.city = '';
            var idxBeds = $('#dsidx-primary-data tbody tr:nth-child(3) td').text();
            prop.bedrooms = parseInt(idxBeds);
            var idxBaths = $('#dsidx-primary-data tbody tr:nth-child(4) td').text().split(",");
            var idxBathsTotal = 0;
            $.each(idxBaths, function(index, val) {
                 idxBathsTotal += parseInt(val);
            });
            prop.bathrooms = parseInt(idxBathsTotal);
            var idxArea = $('#dsidx-primary-data tbody tr:nth-child(6) td').text();
            prop.area = idxArea;
            prop.link = window.location.href;
            prop.unit = '';

            props.push(prop);
        }

        appMap = new google.maps.Map(document.getElementById('mapIdxView'), options);
        var styledMapType = new google.maps.StyledMapType(styles, {
            name : 'Styled'
        });
        appMap.mapTypes.set('Styled', styledMapType);
        appMap.getStreetView().setOptions(panoramaOptions);

        var searchedPosition = new google.maps.LatLng(services_vars.search_lat, services_vars.search_lng);
        appMap.setCenter(searchedPosition);
        appMap.setZoom(parseInt(services_vars.zoom));

        if(props.length > 0) {
            addMarkers(props, appMap);

            appMap.fitBounds(markers.reduce(function(bounds, marker) {
                return bounds.extend(marker.getPosition());
            }, new google.maps.LatLngBounds()));

            google.maps.event.trigger(appMap, 'resize');

            markerCluster = new MarkerClusterer(appMap, markers, {
                maxZoom: 18,
                gridSize: 60,
                styles: [
                    {
                        url: services_vars.theme_url + '/images/clusters/cluster-1.png',
                        width: 40,
                        height: 40,
                        fontFamily: "'Open Sans', sans-serif, Arial",
                        fontWeight: "normal",
                        textColor: "#fff"
                    },
                    {
                        url: services_vars.theme_url + '/images/clusters/cluster-2.png',
                        width: 40,
                        height: 40,
                        fontFamily: "'Open Sans', sans-serif, Arial",
                        fontWeight: "normal",
                        textColor: "#fff"
                    },
                    {
                        url: services_vars.theme_url + '/images/clusters/cluster-3.png',
                        width: 40,
                        height: 40,
                        fontFamily: "'Open Sans', sans-serif, Arial",
                        fontWeight: "normal",
                        textColor: "#fff"
                    }
                ]
            });
        }
    }

    if($('#mapSingleView').length > 0) {
        var propsAjaxURL = services_vars.admin_url + 'admin-ajax.php';
        var propsSecurity = $('#securityAppMap').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: propsAjaxURL,
            data: {
                'action': 'reales_get_single_property',
                'single_id': $('#single_id').val(),
                'security': propsSecurity
            },
            success: function(data) {
                appMap = new google.maps.Map(document.getElementById('mapSingleView'), options);
                var styledMapType = new google.maps.StyledMapType(styles, {
                    name : 'Styled'
                });
                appMap.mapTypes.set('Styled', styledMapType);
                appMap.getStreetView().setOptions(panoramaOptions);

                if(data.getprops === true) {
                    var singlePosition = new google.maps.LatLng(data.props[0].lat, data.props[0].lng);
                    appMap.setCenter(singlePosition);
                    appMap.setZoom(parseInt(services_vars.zoom));

                    addMarkers(data.props, appMap);
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    if($('#mapMyView').length > 0) {
        var propsAjaxURL = services_vars.admin_url + 'admin-ajax.php';
        var propsSecurity = $('#securityAppMap').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: propsAjaxURL,
            data: {
                'action': 'reales_get_my_properties',
                'agent_id': $('#agent_id').val(),
                'page': services_vars.page,
                'security': propsSecurity
            },
            success: function(data) {
                appMap = new google.maps.Map(document.getElementById('mapMyView'), options);
                var styledMapType = new google.maps.StyledMapType(styles, {
                    name : 'Styled'
                });
                appMap.mapTypes.set('Styled', styledMapType);
                appMap.getStreetView().setOptions(panoramaOptions);

                if(data.getprops === true) {
                    addMarkers(data.props, appMap);

                    appMap.fitBounds(markers.reduce(function(bounds, marker) {
                        return bounds.extend(marker.getPosition());
                    }, new google.maps.LatLngBounds()));

                    markerCluster = new MarkerClusterer(appMap, markers, {
                        maxZoom: 18,
                        gridSize: 60,
                        styles: [
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-1.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            },
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-2.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            },
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-3.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            }
                        ]
                    });
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    if($('#mapFavView').length > 0) {
        var propsAjaxURL = services_vars.admin_url + 'admin-ajax.php';
        var propsSecurity = $('#securityAppMap').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: propsAjaxURL,
            data: {
                'action': 'reales_get_fav_properties',
                'user_id': $('#user_id').val(),
                'page': services_vars.page,
                'security': propsSecurity
            },
            success: function(data) {
                appMap = new google.maps.Map(document.getElementById('mapFavView'), options);
                var styledMapType = new google.maps.StyledMapType(styles, {
                    name : 'Styled'
                });
                appMap.mapTypes.set('Styled', styledMapType);
                appMap.getStreetView().setOptions(panoramaOptions);

                if(data.getprops === true) {
                    addMarkers(data.props, appMap);

                    appMap.fitBounds(markers.reduce(function(bounds, marker) {
                        return bounds.extend(marker.getPosition());
                    }, new google.maps.LatLngBounds()));

                    markerCluster = new MarkerClusterer(appMap, markers, {
                        maxZoom: 18,
                        gridSize: 60,
                        styles: [
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-1.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            },
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-2.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            },
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-3.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            }
                        ]
                    });
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    if($('#mapAgentView').length > 0) {
        var propsAjaxURL = services_vars.admin_url + 'admin-ajax.php';
        var propsSecurity = $('#securityAppMap').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: propsAjaxURL,
            data: {
                'action': 'reales_get_agent_properties',
                'agent_id': $('#agent_id').val(),
                'security': propsSecurity
            },
            success: function(data) {
                appMap = new google.maps.Map(document.getElementById('mapAgentView'), options);
                var styledMapType = new google.maps.StyledMapType(styles, {
                    name : 'Styled'
                });
                appMap.mapTypes.set('Styled', styledMapType);
                appMap.getStreetView().setOptions(panoramaOptions);

                if(data.getprops === true) {
                    addMarkers(data.props, appMap);

                    appMap.fitBounds(markers.reduce(function(bounds, marker) {
                        return bounds.extend(marker.getPosition());
                    }, new google.maps.LatLngBounds()));

                    markerCluster = new MarkerClusterer(appMap, markers, {
                        maxZoom: 18,
                        gridSize: 60,
                        styles: [
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-1.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            },
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-2.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            },
                            {
                                url: services_vars.theme_url + '/images/clusters/cluster-3.png',
                                width: 40,
                                height: 40,
                                fontFamily: "'Open Sans', sans-serif, Arial",
                                fontWeight: "normal",
                                textColor: "#fff"
                            }
                        ]
                    });
                }
            },
            error: function(errorThrown) {

            }
        });
    }

    var newMarker = null;
    if($('#mapNewView').length > 0) {
        map = new google.maps.Map(document.getElementById('mapNewView'), options);
        var styledMapType = new google.maps.StyledMapType(styles, {
            name : 'Styled'
        });
        map.mapTypes.set('Styled', styledMapType);
        map.getStreetView().setOptions(panoramaOptions);
        var mapLat, mapLng;

        if ($('#new_lat_h').val() && $('#new_lng_h').val()) {
            mapLat = $('#new_lat').val();
            mapLng = $('#new_lng').val();
            map.setCenter(new google.maps.LatLng(mapLat, mapLng));
            map.setZoom(parseInt(services_vars.zoom));

            newMarker = new google.maps.Marker({
                position: new google.maps.LatLng(mapLat, mapLng),
                map: map,
                icon: newMarkerImage,
                draggable: true,
                animation: google.maps.Animation.DROP,
            });

            google.maps.event.addListener(newMarker, "mouseup", function(event) {
                $('#new_lat').val(this.position.lat());
                $('#new_lng').val(this.position.lng());
                $('#new_lat_h').val(this.position.lat());
                $('#new_lng_h').val(this.position.lng());
            });
        } else {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    $('#new_lat').val(position.coords.latitude);
                    $('#new_lng').val(position.coords.longitude);
                    $('#new_lat_h').val(position.coords.latitude);
                    $('#new_lng_h').val(position.coords.longitude);
                    map.setCenter(userPosition);
                    map.setZoom(parseInt(services_vars.zoom));

                    newMarker = new google.maps.Marker({
                        position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude),
                        map: map,
                        icon: newMarkerImage,
                        draggable: true,
                        animation: google.maps.Animation.DROP,
                    });

                    google.maps.event.addListener(newMarker, "mouseup", function(event) {
                        $('#new_lat').val(this.position.lat());
                        $('#new_lng').val(this.position.lng());
                        $('#new_lat_h').val(this.position.lat());
                        $('#new_lng_h').val(this.position.lng());
                    });

                }, function() {
                    handleNoGeolocation(true);
                });
            } else {
                // Browser doesn't support Geolocation
                handleNoGeolocation(false);
            }
        }

        geocoder = new google.maps.Geocoder();
        $('#addressPinBtn').click(function() {
            var address = document.getElementById('new_address').value + ', ' + document.getElementById('new_city').value;
            geocoder.geocode( { 'address': address }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    newMarker.setPosition(results[0].geometry.location);
                    newMarker.setVisible(true);
                    $('#new_lat').val(newMarker.getPosition().lat());
                    $('#new_lng').val(newMarker.getPosition().lng());
                    $('#new_lat_h').val(newMarker.getPosition().lat());
                    $('#new_lng_h').val(newMarker.getPosition().lng());
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        });

        $('#new_lat').change(function() {
            var lat = $(this).val();
            var lng = $('#new_lng').val();
            var pos = new google.maps.LatLng(lat, lng);
            newMarker.setPosition(pos);
            newMarker.setVisible(true);
            map.setCenter(pos);
            $('#new_lat_h').val(lat);
        });

        $('#new_lng').change(function() {
            var lat = $('#new_lat').val();
            var lng = $(this).val();
            var pos = new google.maps.LatLng(lat, lng);
            newMarker.setPosition(pos);
            newMarker.setVisible(true);
            map.setCenter(pos);
            $('#new_lng_h').val(lng);
        });

        if($('#new_city').length > 0) {
            var city = document.getElementById('new_city');
            var cityAuto = new google.maps.places.Autocomplete(city, cityOptions);
            google.maps.event.addListener(cityAuto, 'place_changed', function() {
                var place = cityAuto.getPlace();
                $('#new_city').blur();
                setTimeout(function() { $('#new_city').val(place.name); }, 1);

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                }
                newMarker.setPosition(place.geometry.location);
                newMarker.setVisible(true);
                $('#new_lat').val(newMarker.getPosition().lat());
                $('#new_lng').val(newMarker.getPosition().lng());
                $('#new_lat_h').val(newMarker.getPosition().lat());
                $('#new_lng_h').val(newMarker.getPosition().lng());
                $('#new_lat_label').text(newMarker.getPosition().lat());
                $('#new_lng_label').text(newMarker.getPosition().lng());

                return false;
            });
        }

        if($('#new_neighborhood').length > 0) {
            var neighborhood = document.getElementById('new_neighborhood');
            var neighborhoodAuto = new google.maps.places.Autocomplete(neighborhood);
            google.maps.event.addListener(neighborhoodAuto, 'place_changed', function() {
                var place = neighborhoodAuto.getPlace();
                $('#new_neighborhood').blur();
                setTimeout(function() { $('#new_neighborhood').val(place.address_components[0].short_name); }, 1);

                return false;
            });
        }
    }

    $('.card').each(function(i) {
        $(this).on('mouseenter', function() {
            if(appMap) {
                google.maps.event.trigger(markers[i], 'click');
            }
        });
        $(this).on('mouseleave', function() {
            infobox.open(null,null);
        });
    });

    $('.card-min').each(function(i) {
        $(this).on('mouseenter', function() {
            if(appMap) {
                google.maps.event.trigger(markers[i], 'click');
            }
        });
        $(this).on('mouseleave', function() {
            infobox.open(null,null);
        });
    });

    $('.dsidx-listing').each(function(i) {
        $(this).on('mouseenter', function() {
            if(appMap) {
                google.maps.event.trigger(markers[i], 'click');
            }
        });
        $(this).on('mouseleave', function() {
            infobox.open(null,null);
        });
    });

    $('#favBtn').click(function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityFav').val();

        var fav_no = $(this).siblings('.fav_no').text();

        if($(this).hasClass('addFav')) {
            $(this).siblings('.fav_no').text(parseInt(fav_no) + 1);
            $(this).removeClass('addFav').addClass('addedFav');
            $(this).children('span').removeClass('fa-heart-o').addClass('fa-heart');

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxURL,
                data: {
                    'action': 'reales_add_to_favourites',
                    'user_id': services_vars.user_id,
                    'post_id': services_vars.post_id,
                    'security': security
                },
                success: function(data) {
                    if(data.addfav === true) {
                        // console.log(data.fav);
                    }
                },
                error: function(errorThrown) {

                }
            });
        } else if($(this).hasClass('addedFav')) {
            $(this).siblings('.fav_no').text(parseInt(fav_no) - 1);
            $(this).removeClass('addedFav').addClass('addFav');
            $(this).children('span').removeClass('fa-heart').addClass('fa-heart-o');

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajaxURL,
                data: {
                    'action': 'reales_remove_from_favourites',
                    'user_id': services_vars.user_id,
                    'post_id': services_vars.post_id,
                    'security': security
                },
                success: function(data) {
                    if(data.removefav === true) {
                        // console.log(data.fav);
                    }
                },
                error: function(errorThrown) {

                }
            });
        }
    });

    $('#sendMessageBtn').click(function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityAgentMessage').val();
        $('#ca_response').empty();
        $('#sendMessageBtn').html('<span class="fa fa-spin fa-spinner"></span> ' + services_vars.sending_message).addClass('disabled');
        var p_info_title = $('#p_info_title').length > 0 ? $('#p_info_title').val() : '';
        var p_info_link = $('#p_info_link').length > 0 ? $('#p_info_link').val() : '';

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_send_message_to_agent',
                'agent_email': $('#agent_email').val(),
                'name': $('#ca_name').val(),
                'email': $('#ca_email').val(),
                'phone': $('#ca_phone').val(),
                'subject': $('#ca_subject').val(),
                'p_info_title': p_info_title,
                'p_info_link': p_info_link,
                'message': $('#ca_message').val(),
                'security': security
            },
            success: function(data) {
                $('#sendMessageBtn').html(services_vars.send_message).removeClass('disabled');
                var message = '';
                if(data.sent === true) {
                    message =   '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-check-circle"></span></div>' +
                                    '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
                                    data.message +
                                '</div>';
                    $('#ca_name').val('');
                    $('#ca_email').val('');
                    $('#ca_phone').val('');
                    $('#ca_subject').val('');
                    $('#ca_message').val('');
                } else {
                    message =   '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-ban"></span></div>' +
                                    '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
                                    data.message +
                                '</div>';
                }

                $('#ca_response').append(message);
            },
            error: function(errorThrown) {

            }
        });
    });

    $('#contactAgent').on('hide.bs.modal', function() {
        $('#ca_response').empty();
        $('#ca_name').val('');
        $('#ca_email').val('');
        $('#ca_phone').val('');
        $('#ca_subject').val('');
        $('#ca_message').val('');
    });

    function get_tinymce_content(id) {
        if($('#isDesc').length > 0) {
            var content;
            var inputid = id;
            tinyMCE.triggerSave();
            var editor = tinyMCE.get(inputid);
            var textArea = jQuery('textarea#' + inputid);    
            if (textArea.length>0 && textArea.is(':visible')) {
                content = textArea.val();        
            } else {
                content = editor.getContent();
            }    
            return content;
        } else {
            return '';
        }
    }

    $('#submitPropertyBtn').click(function() {
        $('#propertyModal').modal({
            'backdrop': 'static',
            'keyboard': false,
            'show': true
        });

        var amenities = [];
        $('#new_amenities input[type=checkbox]:checked').each(function(index) {
            amenities.push($(this).attr('name'));
        });

        var cfields = [];
        $('.customField').each(function(index) {
            cfields.push({
                field_name: $(this).attr('name'),
                field_value: $(this).val(),
                field_mandatory: $(this).attr('data-mandatory')
            });
        });

        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securitySubmitProperty').val();
        $('#save_response').empty();
        $('#save_response').html('<div class="propSaving"><span class="fa fa-spin fa-spinner"></span> ' + services_vars.saving_property + '</div>');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_save_property',
                'new_id': $('#new_id').val(),
                'user': $('#current_user').val(),
                'title': $('#new_title').val(),
                'content': get_tinymce_content('new_content'),
                'category': $('input[name=new_category]:checked').val(),
                'type': $('input[name=new_type]:checked').val(),
                'city': $('#new_city').val(),
                'lat': $('#new_lat_h').val(),
                'lng': $('#new_lng_h').val(),
                'address': $('#new_address').val(),
                'neighborhood': $('#new_neighborhood').val(),
                'zip': $('#new_zip').val(),
                'state': $('#new_state').val(),
                'country': $('#new_country').val(),
                'price': $('#new_price').val(),
                'price_label': $('#new_price_label').val(),
                'area': $('#new_area').val(),
                'bedrooms': $('#new_bedrooms').val(),
                'bathrooms': $('#new_bathrooms').val(),
                'amenities': amenities,
                'cfields' : cfields,
                'gallery': $('#new_gallery').val(),
                'plans': $('#new_plans').val(),
                'video_source': $('input[name=new_video_source]:checked').val(),
                'video_id': $('#new_video_id').val(),
                'security': security
            },
            success: function(data) {
                var message = '';
                if(data.save === true) {
                    $('#new_id').val(data.propID);
                    $('#submitPropertyBtn').html('<span class="fa fa-save"></span> ' + services_vars.update_property);
                    if(data.propStatus == 'publish') {
                        $('#viewPropertyBtn').css('display', 'inline-block').attr('href', data.propLink);
                    }
                    $('#deletePropertyBtn').css('display', 'inline-block');

                    message =   '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-check-circle"></span></div>' +
                                    '<button type="button" class="close close-modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
                                    data.message +
                                '</div>';
                } else {
                    message =   '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-ban"></span></div>' +
                                    '<button type="button" class="close close-modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
                                    data.message +
                                '</div>';
                }

                $('#propertyModal .modal-dialog').removeClass('modal-sm');
                $('#save_response').html(message);
                $('.close-modal').click(function() {
                    $('#save_response').empty();
                    $('#propertyModal').modal('hide');
                    $('#propertyModal .modal-dialog').addClass('modal-sm');
                });
            },
            error: function(errorThrown) {

            }
        });
    });

    $('#deletePropertyBtn').click(function() {
        $('#propertyModal').modal({
            'backdrop': 'static',
            'keyboard': false,
            'show': true
        });

        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securitySubmitProperty').val();
        $('#save_response').empty();
        $('#save_response').html('<div class="propSaving"><span class="fa fa-spin fa-spinner"></span> ' + services_vars.deleting_property + '</div>');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_delete_property',
                'new_id': $('#new_id').val(),
                'security': security
            },
            success: function(data) {
                var message = '';
                if(data.delete === true) {
                    $('#submitProperty').empty();
                    message =   '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-check-circle"></span></div>' +
                                    data.message +
                                '</div>';
                    setTimeout(function() {
                        document.location.href = services_vars.home_redirect;
                    }, 2000);
                } else {
                    message =   '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-ban"></span></div>' +
                                    '<button type="button" class="close close-modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
                                    data.message +
                                '</div>';
                }

                $('#propertyModal .modal-dialog').removeClass('modal-sm');
                $('#save_response').html(message);
                $('.close-modal').click(function() {
                    $('#save_response').empty();
                    $('#propertyModal').modal('hide');
                    $('#propertyModal .modal-dialog').addClass('modal-sm');
                });
            },
            error: function(errorThrown) {

            }
        });
    });

    $('#updateProfileBtn').click(function() {
        $('#accountModal').modal({
            'backdrop': 'static',
            'keyboard': false,
            'show': true
        });

        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityUserProfile').val();
        $('#up_response').empty();
        $('#up_response').html('<div class="propSaving"><span class="fa fa-spin fa-spinner"></span> ' + services_vars.updating_profile + '</div>');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_update_user_profile',
                'user_id': $('#user_id').val(),
                'first_name': $('#up_first_name').val(),
                'last_name': $('#up_last_name').val(),
                'nickname': $('#up_nickname').val(),
                'email': $('#up_email').val(),
                'password': $('#up_password').val(),
                're_password': $('#up_re_password').val(),
                'avatar': $('#new_gallery').val(),
                'agent_id': $('#agent_id').val(),
                'agent_about': $('#agent_about').val(),
                'agent_specs': $('#agent_specs').val(),
                'agent_phone': $('#agent_phone').val(),
                'agent_mobile': $('#agent_mobile').val(),
                'agent_skype': $('#agent_skype').val(),
                'agent_facebook': $('#agent_facebook').val(),
                'agent_twitter': $('#agent_twitter').val(),
                'agent_google': $('#agent_google').val(),
                'agent_linkedin': $('#agent_linkedin').val(),
                'security': security
            },
            success: function(data) {
                var message = '';
                if(data.save === true) {
                    message =   '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-check-circle"></span></div>' +
                                    '<button type="button" class="close close-modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
                                    data.message +
                                '</div>';
                } else {
                    message =   '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-ban"></span></div>' +
                                    '<button type="button" class="close close-modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
                                    data.message +
                                '</div>';
                }

                $('#accountModal .modal-dialog').removeClass('modal-sm');
                $('#up_response').html(message);
                $('.close-modal').click(function() {
                    $('#up_response').empty();
                    $('#accountModal').modal('hide');
                    $('#accountModal .modal-dialog').addClass('modal-sm');
                });
            },
            error: function(errorThrown) {

            }
        });
    });

    $('#sendContactMessageBtn').click(function() {
        var ajaxURL = services_vars.admin_url + 'admin-ajax.php';
        var security = $('#securityContactPage').val();
        $('#cp_response').empty();
        $('#sendContactMessageBtn').html('<span class="fa fa-spin fa-spinner"></span> ' + services_vars.sending_message).addClass('disabled');

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajaxURL,
            data: {
                'action': 'reales_send_message_to_company',
                'company_email': $('#company_email').val(),
                'name': $('#cp_name').val(),
                'email': $('#cp_email').val(),
                'subject': $('#cp_subject').val(),
                'message': $('#cp_message').val(),
                'security': security
            },
            success: function(data) {
                $('#sendContactMessageBtn').html(services_vars.send_message).removeClass('disabled');
                var message = '';
                if(data.sent === true) {
                    message =   '<div class="alert alert-success alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-check-circle"></span></div>' +
                                    '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
                                    data.message +
                                '</div>';
                    $('#cp_name').val('');
                    $('#cp_email').val('');
                    $('#cp_subject').val('');
                    $('#cp_message').val('');
                } else {
                    message =   '<div class="alert alert-danger alert-dismissible fade in" role="alert">' +
                                    '<div class="icon"><span class="fa fa-ban"></span></div>' +
                                    '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>' +
                                    data.message +
                                '</div>';
                }

                $('#cp_response').append(message);
            },
            error: function(errorThrown) {

            }
        });
    });

})(jQuery);