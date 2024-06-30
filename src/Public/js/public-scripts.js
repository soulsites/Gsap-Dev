document.addEventListener('DOMContentLoaded', function() {

    gsap.registerPlugin(TextPlugin);

    var flyoutS = document.querySelector('.css-flyout');
    var flyout = '.css-flyout';
    var eigenschaften = '.css-menu-eigenschaften';
    var komponenten = '.css-menu-komponenten';
    var beispiele = '.css-menu-beispiele';
    var menuContainerAll = '.css-menu-eigenschaften, .css-menu-komponenten, .css-menu-beispiele, .suchformular-wrapper';
    var suche = '.suchformular-wrapper';
    var logo = '.css-logo';

    var opener = "";


    gsap.to(flyout, {display: 'none', duration: 0});
    gsap.to(menuContainerAll, {opacity: 0, display: 'none', duration: 0});
    gsap.to(suche, {opacity: 0, display: 'none', duration: 0});

    // Prüfe, ob GSAP geladen ist
    if (typeof gsap !== 'undefined') {



        function flyoutMenu(a){

            const flyouttl = gsap.timeline({ defaults: { duration: .2, ease: 'power2.inOut' }, paused:true});

            flyouttl.to(menuContainerAll, {opacity: 0, duration: 0, display: 'none'}, 0)
                .to(logo, {rotation: 0}, 0)
                .to(flyout, {width: '0px', display: 'none', duration: 0})
                .to(flyout, {display: 'block', width: '300px'})
                .to(logo, {rotation: -90, borderRadius: '50px'}, 0.2)
                .fromTo(suche, {duration: .2, opacity: 0, display: 'none'}, {display: 'block', opacity: 1})
                .fromTo(a, {duration: .2, opacity: 0, display: 'none'}, {display: 'block', opacity: 1});

            flyouttl.play();

        }

        function flyoutMenuClose(){

            const flyouttl2 = gsap.timeline({ defaults: { duration: .1, ease: 'power2.inOut' }, paused:true});

            flyouttl2.to(menuContainerAll, {opacity: 0, display: 'none', duration: .1}, 0)
                .to(logo, {rotation: 0}, 0.1)
                .to(flyout, {width: '0px', display: 'none', duration: .1}, 0.1)

            flyouttl2.play();

        }



        document.getElementById('css-components').addEventListener('click', function() {
            flyoutMenu(komponenten);

        });

        document.getElementById('css-ressourcen').addEventListener('click', function() {
            flyoutMenu(eigenschaften);
        });

        document.getElementById('css-beispiele').addEventListener('click', function() {
            flyoutMenu(beispiele);
        });

        document.getElementById('css-menu-close').addEventListener('click', function() {
            flyoutMenuClose();
        });

        document.addEventListener('mousemove', function(event) {
            const flyoutRect = flyoutS.getBoundingClientRect();

            if (flyoutS.style.display === 'block' && event.clientX - 200 > flyoutRect.right) {
                flyoutMenuClose();
            }
        });

        /* Rotate Btn */

        document.querySelectorAll('.css-rotate').forEach(function(element) {
            element.addEventListener('mouseover', function() {
                gsap.to(element.querySelector('svg'), { rotation: 20, duration: 0.2});
            });

            element.addEventListener('mouseleave', function() {
                gsap.to(element.querySelector('svg'), { rotation: 0, duration: 0.2});
            });
        });



/* jQuery*/
jQuery(document).ready(function() {


        var suchformular = document.getElementById('suchformular');
        var suchfeld = document.getElementById('suchfeld');
        var ladeindikator = document.getElementById('ladeindikator');
        var suchergebnisse = document.getElementById('suchergebnisse');
        var suchergebnisseWrapper = document.getElementById('suchergebnisse-wrapper');
        var closeBtn = document.getElementsByClassName('close-abs');

        const suche = gsap.timeline({ defaults: { duration: .2, ease: 'power2.inOut' }, paused:true});
        const sucheerg = gsap.timeline({ defaults: { duration: .4, ease: 'power2.inOut' }, paused:true});

        suchformular.addEventListener('submit', function(e) {
            // Verhindern, dass das Formular auf traditionelle Weise abgesendet wird
            e.preventDefault();

            // Wert aus dem Suchfeld auslesen
            var schlagwort = suchfeld.value;

            // Ladeindikator anzeigen
            suche.to(ladeindikator, {display: 'block', height: 'auto', opacity: 1 })
                .to(flyout, {duration: .6, width: '450px'})
                .from(ladeindikator, {duration: .6, text: ""}, 0)
                .to(suchergebnisseWrapper, {display: 'none', height: 0, opacity: 0 }, 0);

            suche.play();

            // Suchfunktion aufrufen
            sucheNachSchlagwort(schlagwort);
        });

        document.querySelector('.close-abs').addEventListener('click', function(){
            gsap.to(suchergebnisseWrapper, {duration: .6, height: '0px', opacity: 0, display: 'none'})
            gsap.to(flyout, {duration: .6, width: '300px'});
        });


    function sucheNachSchlagwort(schlagwort) {
        const baseUrl = 'https://css-lernen.com/wp-json/wp/v2/';
        const searchUrl = `${baseUrl}posts?search=${encodeURIComponent(schlagwort)}&orderby=relevance`;

        jQuery.ajax({
            url: searchUrl,
            method: 'GET',
            success: function(posts) {
                anzeigenErgebnisse(posts);
            },
            error: function() {
                console.error('Fehler bei der Suche');
            },
            complete: function() {
                console.log("erg da");

                sucheerg.to(ladeindikator, {height: 0, display: 'none', opacity: 0})
                    .to(suchergebnisseWrapper, {display: 'block', height: '400px', opacity: 1})
                    .to(suchergebnisse, {duration: 0, display: 'block', height: 'auto', opacity: 1});
                sucheerg.play();
            }
        });
    }

    function anzeigenErgebnisse(posts) {
        const ergebnisContainer = jQuery('#suchergebnisse');
        ergebnisContainer.empty();
        const liste = jQuery('<ul></ul>').appendTo(ergebnisContainer);

        if (posts.length > 0) {
            jQuery.each(posts, function(i, post) {
                jQuery('<li></li>', {
                    html: `<a href="${post.link}">${post.title.rendered}</a>`
                }).appendTo(liste);
            });
        } else {
            jQuery('<li>Keine Beiträge gefunden.</li>').appendTo(liste);
        }
    }
});


    } else {
        console.log('GSAP is not loaded');
    }
});