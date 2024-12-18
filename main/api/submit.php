<?php

// Comment if you don't want to allow posts from other domains
header('Access-Control-Allow-Origin: *');

// Allow the following methods to access this file
header('Access-Control-Allow-Methods: POST');

// Load the FilePond class
require_once('FilePond.class.php');

// Load our configuration for this server
require_once('config.php');

// Catch server exceptions and auto jump to 500 response code if caught
FilePond\catch_server_exceptions();
FilePond\route_form_post(ENTRY_FIELD, [
    'FILE_OBJECTS' => 'handle_file_post',
    'BASE64_ENCODED_FILE_OBJECTS' => 'handle_base64_encoded_file_post',
    'TRANSFER_IDS' => 'handle_transfer_ids_post'
]);

function handle_file_post($files) {

    // This is a very basic implementation of a classic PHP upload function, please properly
    // validate all submitted files before saving to disk or database, more information here
    // http://php.net/manual/en/features.file-upload.php
    
    foreach($files as $file) {
        FilePond\move_file($file, UPLOAD_DIR);
    }
}

function handle_base64_encoded_file_post($files) {

    foreach ($files as $file) {

        // Suppress error messages, we'll assume these file objects are valid
        /* Expected format:
        {
            "id": "iuhv2cpsu",
            "name": "picture.jpg",
            "type": "image/jpeg",
            "size": 20636,
            "metadata" : {...}
            "data": "/9j/4AAQSkZJRgABAQEASABIAA..."
        }
        */
        $file = @json_decode($file);

        // Skip files that failed to decode
        if (!is_object($file)) continue;

        // write file to disk
        FilePond\write_file(
            UPLOAD_DIR, 
            base64_decode($file->data), 
            FilePond\sanitize_filename($file->name)
        );
    }

}

function handle_transfer_ids_post($ids) {

    foreach ($ids as $id) {
        
        // create transfer wrapper around upload
        $transfer = FilePond\get_transfer(TRANSFER_DIR, $id);
        
        // transfer not found
        if (!$transfer) continue;
        
        // move files
        $files = $transfer->getFiles(defined('TRANSFER_PROCESSOR') ? TRANSFER_PROCESSOR : null);
        foreach($files as $file) {
            FilePond\move_file($file, UPLOAD_DIR);
        }

        // remove transfer directory
        FilePond\remove_transfer_directory(TRANSFER_DIR, $id);
    }

}

?>

<!DOCTYPE html>
<!--
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<title>Form Submission</title>

	<link rel="shortcut icon" href="" type="image/x-icon">
	<link rel="apple-touch-icon" href="">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="">

</head>

<body>

	<h1>Thank you!</h1>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
-->

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-AU" lang="en-AU">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="Melbourne Cardiology Services, echo, echocardiography, holter monitoring, cardiac services in North Melbourne" />
    <meta name="description" content="At Melbourne Cardiology Services, we value our patients and strive to serve them well. We offer services in echocardiography, Holter monitoring, stress echocardiography, cardiac CT, as well as consultations across multiple locations. We aim to provide our patients and referring doctors with quick turnarounds and service that embodies our credo of excellence, integrity and quality." />
    <meta name="copyright" content="Melbourne Cardiology Services">
    <meta name="language" content="EN">
    <meta name="robots" content="index,follow" />
    <meta name="copyright" content="Melbourne Cardiology Services">
    <meta name="owner" content="Melbourne Cardiology Services">
    <meta name="url" content="https://melbournecardiology.services">
    <meta name="identifier-URL" content="https://melbournecardiology.services">
    <meta name="directory" content="submission">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global">
    <meta name="revisit-after" content="7 days">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="../assets/img/favicon-144.png">
    <meta name="msapplication-config" content="../assets/img/browserconfig.xml">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/icon.png">
    <link rel="icon" sizes="16x16 32x32 64x64" href="../assets/img/favicon.ico">
    <link rel="icon" type="image/png" sizes="196x196" href="../assets/img/favicon-192.png">
    <link rel="icon" type="image/png" sizes="160x160" href="../assets/img/favicon-160.png">
    <link rel="icon" type="image/png" sizes="96x96" href="../assets/img/favicon-96.png">
    <link rel="icon" type="image/png" sizes="64x64" href="../assets/img/favicon-64.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon-16.png">
    <link rel="apple-touch-icon" href="../assets/img/favicon-57.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../assets/img/favicon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../assets/img/favicon-72.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../assets/img/favicon-144.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../assets/img/favicon-60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/favicon-120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/favicon-76.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../assets/img/favicon-152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicon-180.png">
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">-->
    <!--<link rel="stylesheet" href="bootstrap-4.1.2/dist/css/bootstrap.min.css">-->
    <!--<link rel="stylesheet" href="assets/css/bootstrap.css">-->
    <link rel="stylesheet" href="../assets/bootstrap-4.5.0-dist/css/bootstrap.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <!--integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous"-->
    <!--<link rel="stylesheet" href="fonts/fontawesome-free-5.1.1-web/css/all.css">-->
    <!--<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">-->
    <!--<link rel="stylesheet" href="assets/css/scrollreveal.css">-->
    <link href="https://unpkg.com/splitting@1.0.0/dist/splitting.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/normalize.css" type="text/css">
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css' rel='stylesheet' />
    <link href="../assets/css/staticmap.css" rel="stylesheet">
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MQXNP5K');

    </script>
    <!-- End Google Tag Manager -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130193313-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-130193313-1');

    </script>
    <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.2/TweenMax.min.js"></script>
    <!--<script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>-->
    <script src="https://unpkg.com/splitting@1.0.0/dist/splitting.js"></script>
    <script src="https://unpkg.com/scroll-out@2.2.3/dist/scroll-out.min.js"></script>
    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
    <script>
        var ml = {
            timelines: {}
        };

        /*ScrollReveal({
            scale: 0.85,
            duration: 1000,
        });*/

        document.documentElement.classList.remove('no-js');
        document.documentElement.classList.add('js');

    </script>
    <script type="text/javascript" src="../assets/js/highlight.pack.js"></script>
    <script type="text/javascript" src="../assets/js/modernizr.custom.min.js"></script>
    <!--<script type="text/javascript" src="assets/js/TweenMax.min.js"></script>-->
    <script type="text/javascript" src="../assets/js/ScrollMagic.js"></script>
    <script type="text/javascript" src="../assets/js/animation.gsap.js"></script>
    <script>
        document.getElementsByTagName("html")[0].className += " js";
        /*
        $(document).ajaxStart(function(){
            $("#loading").removeClass('hide');
        }).ajaxStop(function(){
            $("#loading").addClass('hide');
        });
        */
        var loader;

        function mcsloader() {
            loader = setTimeout(showPage, 1000);
        }

        function showPage() {
            document.getElementById("loading").style.display = "none";
            document.getElementById("content").style.display = "block";
        }

    </script>
    <script>
        window['_fs_debug'] = false;
        window['_fs_host'] = 'fullstory.com';
        window['_fs_org'] = 'NSGNC';
        window['_fs_namespace'] = 'FS';
        (function(m, n, e, t, l, o, g, y) {
            if (e in m) {
                if (m.console && m.console.log) {
                    m.console.log('FullStory namespace conflict. Please set window["_fs_namespace"].');
                }
                return;
            }
            g = m[e] = function(a, b, s) {
                g.q ? g.q.push([a, b, s]) : g._api(a, b, s);
            };
            g.q = [];
            o = n.createElement(t);
            o.async = 1;
            o.crossOrigin = 'anonymous';
            o.src = 'https://' + _fs_host + '/s/fs.js';
            y = n.getElementsByTagName(t)[0];
            y.parentNode.insertBefore(o, y);
            g.identify = function(i, v, s) {
                g(l, {
                    uid: i
                }, s);
                if (v) g(l, v, s)
            };
            g.setUserVars = function(v, s) {
                g(l, v, s)
            };
            g.event = function(i, v, s) {
                g('event', {
                    n: i,
                    p: v
                }, s)
            };
            g.shutdown = function() {
                g("rec", !1)
            };
            g.restart = function() {
                g("rec", !0)
            };
            g.log = function(a, b) {
                g("log", [a, b])
            };
            g.consent = function(a) {
                g("consent", !arguments.length || a)
            };
            g.identifyAccount = function(i, v) {
                o = 'account';
                v = v || {};
                v.acctId = i;
                g(o, v)
            };
            g.clearUserCookie = function() {};
        })(window, document, window['_fs_namespace'], 'script', 'user');

    </script>
    <!-- Start of Woopra Code -->
    <script>
        (function() {
            var t, i, e, n = window,
                o = document,
                a = arguments,
                s = "script",
                r = ["config", "track", "identify", "visit", "push", "call", "trackForm", "trackClick"],
                c = function() {
                    var t, i = this;
                    for (i._e = [], t = 0; r.length > t; t++)(function(t) {
                        i[t] = function() {
                            return i._e.push([t].concat(Array.prototype.slice.call(arguments, 0))), i
                        }
                    })(r[t])
                };
            for (n._w = n._w || {}, t = 0; a.length > t; t++) n._w[a[t]] = n[a[t]] = n[a[t]] || new c;
            i = o.createElement(s), i.async = 1, i.src = "//static.woopra.com/js/w.js", e = o.getElementsByTagName(s)[0], e.parentNode.insertBefore(i, e)
        })("woopra");

        woopra.config({
            domain: 'melbournecardiology.services'
        });
        woopra.track();

    </script>
    <!-- End of Woopra Code -->
    <script src="https://www.w3counter.com/tracker.js?id=123093"></script>
    <!-- Hotjar Tracking Code for https://melbournecardiology.services -->
    <script>
        (function(h, o, t, j, a, r) {
            h.hj = h.hj || function() {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {
                hjid: 1465319,
                hjsv: 6
            };
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');

    </script>
    <!-- Quantcast Tag -->
    <script type="text/javascript">
        var _qevents = _qevents || [];

        (function() {
            var elem = document.createElement('script');
            elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
            elem.async = true;
            elem.type = "text/javascript";
            var scpt = document.getElementsByTagName('script')[0];
            scpt.parentNode.insertBefore(elem, scpt);
        })();

        _qevents.push({
            qacct: "p-1g91qYrX5-hfd"
        });

    </script>
    <noscript>
        <div style="display:none;">
            <img src="//pixel.quantserve.com/pixel/p-1g91qYrX5-hfd.gif" border="0" height="1" width="1" alt="Quantcast" />
        </div>
    </noscript>
    <!-- End Quantcast tag -->
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/5d6869ba77aa790be331803f/default';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();

    </script>
    <!--End of Tawk.to Script-->
    <script id="navegg" type="text/javascript">
        (function(n, v, g) {
            o = "Navegg";
            if (!n[o]) {
                a = v.createElement('script');
                a.src = g;
                b = document.getElementsByTagName('script')[0];
                b.parentNode.insertBefore(a, b);
                n[o] = n[o] || function(parms) {
                    n[o].q = n[o].q || [];
                    n[o].q.push([this, parms])
                };
            }
        })
        (window, document, 'https://tag.navdmp.com/universal.min.js');
        window.naveggReady = window.naveggReady || [];
        window.nvg57748 = new Navegg({
            acc: 57748
        });

    </script>
    <script type="text/javascript">
        (function(a, s, k, p, r) {
                r = a.createElement('script');
                r.type = 'text/javascript';
                r.async = true;
                r.onload = function() {
                    PULSELIB.init([k, p])
                };
                r.src = s;
                a.getElementsByTagName('head')[0].appendChild(r);
            }
            (document, "https://s3.amazonaws.com/pulsemetrics/pulse-metrics.js", "DuFcpFbhCiuOSOPDk5BfFJ5ZOYpI0YqtgDeBaxk4mrDlgDOeQ5", "pulse"));

    </script>
    <script type="application/javascript">
        (function(b, o, n, g, s, r, c) {
            if (b[s]) return;
            b[s] = {};
            b[s].scriptToken = "Xy0xMTE1MjE0NTI3";
            b[s].callsQueue = [];
            b[s].api = function() {
                b[s].callsQueue.push(arguments);
            };
            r = o.createElement(n);
            c = o.getElementsByTagName(n)[0];
            r.async = 1;
            r.src = g;
            r.id = s + n;
            c.parentNode.insertBefore(r, c);
        })(window, document, "script", "//cdn.oribi.io/Xy0xMTE1MjE0NTI3/oribi.js", "ORIBI");

    </script>
    <!-- Start Lyra-->
    <!--<script>
        var lyra = window.lyra || [];
        lyra.push(['lyra_Id', '5d687eb205d05']);

    </script>
    <script async src='https://thelyra.pro/a/analytics.js'></script>-->
    <!-- End Lyra-->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/mcs.css">
    <link rel="stylesheet" href="../assets/css/mcs1.css">
    <link rel="stylesheet" href="../assets/css/cursor.css">
    <link rel="stylesheet" href="../assets/css/micromodal.css">
    <link rel="stylesheet" href="../assets/fonts/medel.css">
    <link rel="stylesheet" href="../assets/fonts/montserrat.css">
    <link rel="stylesheet" href="../assets/fonts/toriga.css">
    <link rel="stylesheet" href="../assets/fonts/vic.css">
    <style>
        html,
        body {
            max-width: 100%;
            overflow-x: hidden;
        }

        .white {
            color: white !important;
        }

        .black {
            color: black !important;
        }

        /*.herotitle:after {
            background-image: url("../assets/img/swoosh-white2.svg");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            content: '';
            display: block;
            height: .25em;
            left: -.2em;
            position: absolute;
            top: calc(100% - .15em);
            width: calc(100% + .4em);
        }*/

        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
        }

        @media (max-width: 575.98px) {
            .shrinkcentre {
                text-align: center;
                margin-top: 1rem;
            }
        }

    </style>
    <title>Thank You | Melbourne Cardiology Services — Cardiac services with a focus on excellence, integrity &amp; quality.</title>
</head>

<body onload="mcsloader()" style="cursor: none">
    <!--     onmousedown='return false;' onselectstart='return false;'    -->
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQXNP5K" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <div id="content">
        <div class="header" style="">
            <div class="progress-container">
                <div class="progress-bar" id="mcsprogress"></div>
            </div>
        </div>
        <div id="ha-header">
            <nav class="menu ha-header ha-header-shrink">
                <ol class="dtmenu text">
                    <li class="menu-item"><a href="../"><img src="../assets/img/icon.png" style="max-height: 40px; width: auto"></a></li>
                    <li class="menu-item dtmenuitem"><a href="../about" class="">About</a></li>
                    <li class="menu-item dtmenuitem">
                        <a href="../services/" class="">Services</a>
                        <ol class="sub-menu">
                            <li class="menu-item"><a href="echo">Echocardiography</a></li>
                            <li class="menu-item"><a href="stressecho">Stress Echocardiography</a></li>
                            <li class="menu-item"><a href="holter">Holter Monitoring</a></li>
                        </ol>
                    </li>
                    <li class="menu-item dtmenuitem">
                        <a href="../locations/" class="dtmenuheader">Locations</a>
                        <ol class="sub-menu">
                            <li class="menu-item"><a href="../locations/nmelb">North Melbourne</a></li>
                            <li class="menu-item"><a href="../locations/epworth">Epworth Richmond</a></li>
                            <li class="menu-item"><a href="../locations/mponds">Moonee Ponds</a></li>
                            <li class="menu-item"><a href="../locations/blackburnsouth">Blackburn South</a></li>
                        </ol>
                    </li>
                    <li class="menu-item dtmenuitem">
                        <a href="../patients" class="dtmenuheader">Patients</a>
                        <ol class="sub-menu">
                            <li class="menu-item"><a href="../book">Request Appointment</a></li>
                            <li class="menu-item"><a href="../contact">General Enquiries</a></li>
                            <li class="menu-item"><a href="../feedback">Feedback</a></li>
                        </ol>
                    </li>
                    <li class="menu-item dtmenuitem"><a href="../refer" class="boldbtn">Refer a Patient</a></li>
                    <!--<li class="menu-item dtmenuitem">
                        <a href="search">
                            <svg class="icon" viewBox="0 0 20 20" aria-label="Toggle search">
                                <title></title>
                                <circle cx="8.5" cy="8.5" r="6.5" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="2"></circle>
                                <line x1="18" y1="18" x2="13.096" y2="13.096" fill="none" stroke="currentColor" stroke-linecap="square" stroke-miterlimit="10" stroke-width="2"></line>
                            </svg>
                        </a>
                    </li>-->
                </ol>
            </nav>
            <nav class="mobmenu">
                <a href="../"><img src="../assets/img/icon.png" style="max-height: 30px; width: auto; margin: 16px 0 0 20px"></a>
                <div class="button_container" id="toggle" data-target="#overlay" aria-controls="navMobile" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="top"></span>
                    <span class="middle"></span>
                    <span class="bottom"></span>
                </div>
            </nav>

            <div class="overlay" id="overlay">
                <nav class="overlay-menu">
                    <ul>
                        <li><a href="../">Home</a></li>
                        <li><a href="../about">About</a></li>
                        <li><a href="../services/">Services</a></li>
                        <li><a href="../locations/">Locations</a></li>
                        <li><a href="../patients">Patients</a></li>
                        <li><a href="../refer">Practitioners</a></li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="scrollContent ha-waypoint" data-animate-down="ha-header-shrink" data-animate-up="ha-header-show" style="background-color: var(--color-bg)">
            <div class="heropurple">
                <div style="width: 100%; height: 100%; position: relative; display: block; overflow: hidden">
                    <img src="../assets/img/logomark-final%20white.png" style="z-index: 1; opacity: 0.25; position: absolute; display: block; top: 50px; right: -100px; width: 500px; overflow: hidden">
                    <div class="col-12" style="align-content: center; align-items: center; text-align: center; z-index: 3">
                        <h1 class="textb herotitle" style="text-align: center; padding-top: 200px; z-index: 3">Thank You</h1>
                        <div class="swooshcontainer2" style="z-index: 3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 357.809 13.618">
                                <g id="Layer_2" data-name="Layer 2">
                                    <g id="Layer_1-2" data-name="Layer 1">
                                        <path d="M1.5,12.118c51.342-3.748,102.805-7.5,154.252-5.677C222.94,8.817,255,12.639,356.309,1.5" fill="none" stroke="var(--color-contrast-higher)" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" />
                                    </g>
                                </g>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid feature row" style="margin-left: 0 !important; margin-right: 0 !important; padding-left: 0 !important; padding-right: 0 !important;">
                <div class="col-1"></div>
                <div class="col-10 py-3 mb-5 text3 container container--adaptive">
                    <div class="" style="text-align: center">
                        <div id="button1">
                            <a class="mybtn link text3" href="../"><span>Back to Home</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-1"></div>
            </div>
            <div class="row">
                <div class="col-1"></div>
                <div class="col-10">
                    <footer class="main-footer">
                        <script>
                            var fero_server_id = '$2y$10$ZisV/mjILpfoj1Cb3toxlOw6PKpslf6sU20bgiwI9omoQSoNNTXzi';

                        </script>
                        <script src='https://fero.io/analytics.js'></script>
                        <div class="container container--lg">
                            <div class="main-footer__content justify-content-center">
                                <nav class="main-footer__nav">
                                    <div class="main-footer__nav-list" style="text-align: center">
                                        <div class="main-footer__nav-item">
                                            <h5 class="main-footer__nav-header">Quick Links</h5>
                                            <div class="main-footer__nav-link"><a href="../about">About Us</a></div>
                                            <div class="main-footer__nav-link"><a href="../refer">Referral Form</a></div>
                                            <div class="main-footer__nav-link"><a href="../faqs">FAQs</a></div>
                                        </div>
                                        <div class="main-footer__nav-item">
                                            <h5 class="main-footer__nav-header">Services</h5>
                                            <div class="main-footer__nav-link"><a href="echo">Echocardiogram</a></div>
                                            <div class="main-footer__nav-link"><a href="stressecho">Stress Echocardiogram</a></div>
                                            <div class="main-footer__nav-link"><a href="holter">Holter Monitoring</a></div>
                                        </div>
                                        <div class="main-footer__nav-item">
                                            <h5 class="main-footer__nav-header">Locations</h5>
                                            <div class="main-footer__nav-link"><a href="../locations/nmelb">North Melbourne</a></div>
                                            <div class="main-footer__nav-link"><a href="../locations/epworth">Epworth Richmond</a></div>
                                            <div class="main-footer__nav-link"><a href="../locations/mponds">Moonee Ponds</a></div>
                                            <div class="main-footer__nav-link"><a href="../locations/blackburnsouth">Blackburn South</a></div>
                                        </div>
                                        <div class="main-footer__nav-item">
                                            <h5 class="main-footer__nav-header">Contact</h5>
                                            <div class="main-footer__nav-link"><a href="../contact">General Enquiries</a></div>
                                            <div class="main-footer__nav-link"><a href="../book">Request Appoinment</a></div>
                                            <div class="main-footer__nav-link"><a href="../feedback">Submit Feedback</a></div>
                                            <div class="main-footer__nav-link"><a href="tel:1800880770">1800 880 770</a></div>
                                        </div>
                                    </div>
                                </nav>
                            </div> <!-- main-footer__content -->
                            <div class="container-fluid">
                                <div class="main-footer__colophon row">
                                    <div class="main-footer__colophon-nav text col-12 text-center justify-content-center" style="font-size: 12px">
                                        <p>
                                            <span>&copy; 2018
                                                <script>
                                                    new Date().getFullYear() > 2018 && document.write("- " + new Date().getFullYear());

                                                </script> Melbourne Cardiology Services. All rights reserved. Website by INQ Creative.
                                            </span>
                                            <a href="../terms">Terms</a>.
                                            <a href="../privacy">Privacy</a>.
                                        </p>
                                    </div>
                                    <div class="main-footer__colophon-nav text col-12 text-center justify-content-center" style="font-size: 12px">
                                        <label class="dmode" style="font-size: 12px; vertical-align: middle; position: relative; display: inline-block;">Light Mode
                                            <div class="switch">
                                                <input class="switch__input" type="checkbox" id="themeSwitch">
                                                <label aria-hidden="true" class="switch__label" for="themeSwitch">On</label>
                                                <div aria-hidden="true" class="switch__marker"></div>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="main-footer__socials col-12 text-center justify-content-center">
                                        <a href="tel:1800880770">
                                            <i class="fas fa-phone-alt"></i>
                                        </a>
                                        <a href="mailto:admin@melbournecardiology.services?Subject=Website%20Enquiry" target="_blank" style="margin: 0 var(--space-xxs) 0 var(--space-xxs)">
                                            <i class="fas fa-envelope"></i>
                                        </a>
                                        <a href="https://fb.me/mcsmelb" target="_blank">
                                            <i class="fab fa-facebook"></i>
                                        </a>
                                    </div>
                                    <div class="main-footer__colophon-nav text col-12 text-center justify-content-center" style="font-size: 12px">
                                        <p>Have a great <span id="daygreeting"><noscript>day</noscript></span>!</p>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- container -->
                    </footer>
                </div>
                <div class="col-1"></div>
            </div>
        </div>
    </div>
    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../assets/js/menu.js"></script>
    <script type="text/javascript" src="../assets/js/cursor.js"></script>
    <script type="text/javascript" src="../assets/js/progressbar.js"></script>
    <script type="text/javascript" src="../assets/js/daygreeting.js"></script>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1Ijoiam9ub2RqbGVlIiwiYSI6ImNqejBrdWV6YjAwMjgzbnAwc3NvdDhoZHAifQ.naL_6lnZjH31Wwc31n4SgA';

        var geojson = {
            'type': 'FeatureCollection',
            'features': [{
                'type': 'Feature',
                'properties': {
                    'iconSize': [30, 47]
                },
                'geometry': {
                    'type': 'Point',
                    'coordinates': [144.922937, -37.772312]
                }
            }, ]
        };

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v10',
            center: [144.922937, -37.772312],
            zoom: 15,
            interactive: false
        });

        // add markers to map
        geojson.features.forEach(function(marker) {
            // create a DOM element for the marker
            var el = document.createElement('div');
            el.className = 'marker';
            el.style.backgroundImage =
                'url(../assets/img/marker.svg)';
            el.style.width = marker.properties.iconSize[0] + 'px';
            el.style.height = marker.properties.iconSize[1] + 'px';


            // add marker to map
            new mapboxgl.Marker(el)
                .setLngLat(marker.geometry.coordinates)
                .addTo(map);
        });

        function createPopUp(currentFeature) {

            $(document).ready(function() {
                $(".linky").attr("href", "https://melbournecardiology.services/locations/" + currentFeature.properties.page);
            });

            var popUps = document.getElementsByClassName('mapboxgl-popup');
            if (popUps[0]) popUps[0].remove();
            var popup = new mapboxgl.Popup({
                    closeOnClick: true
                })
                .setLngLat(currentFeature.geometry.coordinates)
                .setHTML('<h5>' + currentFeature.properties.site + '</h5>' +
                    '<p class="black">' + currentFeature.properties.address + '</p>' + '<a class="linky" href="https://melbournecardiology.services">' + '&rarr;' + '</a>')
                .addTo(map);
        }

    </script>
    <script>
        if ('CSS' in window && 'supports' in window.CSS) {
            var support = window.CSS.supports('mix-blend-mode', 'difference');
            // tests for mix-blend-mode support
            support = support ? 'mix-blend-mode' : 'no-mix-blend-mode';
            document.documentElement.className += support;
        }


        /*MicroModal.init({
            awaitCloseAnimation: true, // set to false, to remove close animation
            onShow: function(modal) {
                console.log("micromodal open");
            },
            onClose: function(modal) {
                console.log("micromodal close");
            }
        });*/

        document.addEventListener("DOMContentLoaded", function() {

            try {

                MicroModal.init({
                    awaitCloseAnimation: true,
                    onShow: function(modal) {
                        console.log("micromodal open");
                    },
                    onClose: function(modal) {
                        console.log("micromodal close");
                    },
                    disableScroll: true,
                    disableFocus: true
                });

            } catch (e) {
                console.log("micromodal error: ", e);
            }

        });

    </script>
    <script src="../assets/js/util.js"></script>
    <script src="../assets/js/main.js"></script>
    <!--<script src="assets/js/waypoints.min.js"></script>-->
    <script type="text/javascript">
        window._mfq = window._mfq || [];
        (function() {
            var mf = document.createElement("script");
            mf.type = "text/javascript";
            mf.async = true;
            mf.src = "//cdn.mouseflow.com/projects/2316ea1d-a65f-40df-b098-262de54db077.js";
            document.getElementsByTagName("head")[0].appendChild(mf);
        })();

    </script>
    <!-- Default Statcounter code for MCS https://melbournecardiology.services -->
    <script type="text/javascript">
        var sc_project = 12079295;
        var sc_invisible = 1;
        var sc_security = "e6d9f3cd";
        var sc_https = 1;

    </script>
    <script type="text/javascript" src="https://www.statcounter.com/counter/counter.js" async>
    </script>
    <noscript>
        <div class="statcounter">
            <a title="Web Analytics" href="https://statcounter.com/" target="_blank">
                <img class="statcounter" src="https://c.statcounter.com/12079295/0/e6d9f3cd/1/" alt="Web Analytics">
            </a>
        </div>
    </noscript>
    <!-- End of Statcounter Code -->
    <!--<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>-->
    <script>
        /*AOS.init();*/

        /*$(window).on('scroll', function() {
            AOS.init();
        });*/

        /*$(window).on("load", function() {
            AOS.init();
        });*/

        /*let scrollRef = 0;

        window.addEventListener('scroll', function() {
            // increase value up to 10, then refresh AOS
            scrollRef <= 5 ? scrollRef++ : AOS.refresh();
        });*/

    </script>
    <script>
        Splitting();

    </script>
    <script>
        ScrollOut({
            threshold: 0.1,
            once: false
        });

    </script>
    <div class="cursor"></div>
</body>

</html>
