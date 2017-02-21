/* global google */
/* global _ */
/**
 * scripts.js
 *
 * Computer Science 50
 * Problem Set 8
 *
 * Global JavaScript.
 */

// Google Map
var map;

// markers for map
var markers = [];

// info window
var info = new google.maps.InfoWindow();

// execute when the DOM is fully loaded
$(function() {

    // styles for map
    // https://developers.google.com/maps/documentation/javascript/styling
    var styles = [

        // hide Google's labels
        {
            featureType: "all",
            elementType: "labels",
            stylers: [
                {visibility: "off"}
            ]
        },

        // hide roads
        {
            featureType: "road",
            elementType: "geometry",
            stylers: [
                {visibility: "off"}
            ]
        }

    ];

    // options for map
    // https://developers.google.com/maps/documentation/javascript/reference#MapOptions
    var options = {
        center: {lat: 42.3770, lng:-71.1256}, // Cambridge, Massachusetts
        disableDefaultUI: true,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        maxZoom: 18,
        panControl: true,
        styles: styles,
        zoom: 13,
        zoomControl: true
    };

    // get DOM node in which map will be instantiated
    var canvas = $("#map-canvas").get(0);

    // instantiate map
    map = new google.maps.Map(canvas, options);

    // configure UI once Google Map is idle (i.e., loaded)
    google.maps.event.addListenerOnce(map, "idle", configure);

});

/**
 * Adds marker for place to map.
 */
function addMarker(place) {
    // TODO
    var Latlng = new google.maps.LatLng(place.latitude,place.longitude);
    var marker = new MarkerWithLabel({
        position: Latlng,
        map: map,
        labelContent: place.place_name + ", " + place.admin_name1,
        labelAnchor: new google.maps.Point(50, 0),
        labelClass: "label",
        labelStyle: {opacity: 0.75},
        icon: "../img/text.png"
    });
    
    marker.addListener("click", function() {
        showInfo(marker, getContent(marker, place));
    });
    markers.push(marker);
}

/**
 * Configures application.
 */
function configure()
{
    // update UI after map has been dragged
    google.maps.event.addListener(map, "dragend", function() {
        update();
    });

    // update UI after zoom level changes
    google.maps.event.addListener(map, "zoom_changed", function() {
        update();
    });

    // remove markers whilst dragging
    google.maps.event.addListener(map, "dragstart", function() {
        removeMarkers();
    });
    

    // configure typeahead
    // https://github.com/twitter/typeahead.js/blob/master/doc/jquery_typeahead.md
    $("#q").typeahead({
        autoselect: true,
        highlight: true,
        minLength: 1
    },
    {
        source: search,
        templates: {
            empty: "no places found yet",
            suggestion: _.template("<p><%- place_name %>, <%- admin_name1 %> <%- postal_code %></p>")
        }
    });

    // re-center map after place is selected from drop-down
    $("#q").on("typeahead:selected", function(eventObject, suggestion, name) {

        // ensure coordinates are numbers
        var latitude = (_.isNumber(suggestion.latitude)) ? suggestion.latitude : parseFloat(suggestion.latitude);
        var longitude = (_.isNumber(suggestion.longitude)) ? suggestion.longitude : parseFloat(suggestion.longitude);

        // set map's center
        map.setCenter({lat: latitude, lng: longitude});
        map.setZoom(15);

        // update UI
        update();
    });

    // hide info window when text box has focus
    $("#q").focus(function(eventData) {
        hideInfo();
    });

    // re-enable ctrl- and right-clicking (and thus Inspect Element) on Google Map
    // https://chrome.google.com/webstore/detail/allow-right-click/hompjdfbfmmmgflfjdlnkohcplmboaeo?hl=en
    document.addEventListener("contextmenu", function(event) {
        event.returnValue = true; 
        event.stopPropagation && event.stopPropagation(); 
        event.cancelBubble && event.cancelBubble();
    }, true);

    // update UI
    update();

    // give focus to text box
    $("#q").focus();
}

/**
 * Hides info window.
 */
function hideInfo()
{
    info.close();
}

/**
 * Removes markers from map.
 */
function removeMarkers() {
    // TODO
    for (var i = 0, n = markers.length; i < n; i++) {
        markers[i].setMap(null);
    }
    
    markers.length = 0;
}

/**
 * Searches database for typeahead's suggestions.
 */
function search(query, cb)
{
    // get places matching query (asynchronously)
    var parameters = {
        geo: query
    };
    $.getJSON("search.php", parameters)
    .done(function(data, textStatus, jqXHR) {

        // call typeahead's callback with search results (i.e., places)
        cb(data);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {

        // log error to browser's console
        console.log(errorThrown.toString());
    });
}

/**
 * Shows info window at marker with content.
 */
function showInfo(marker, articles, weather) {
    // start div
    var div = "<div id='info'>";
    if (typeof(articles) === "undefined" || typeof(weather) === "undefined") { 
        // http://www.ajaxload.info/
        div += "<img alt='loading' src='img/ajax-loader.gif'/>";
    }
    else {
        div += articles + weather;
    }

    // end div
    div += "</div>";

    // set info window's content
    info.setContent(div);

    // open info window (if not already open)
    info.open(map, marker);
}

/**
 * Updates UI's markers.
 */
function update() 
{
    // get map's bounds
    var bounds = map.getBounds();
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();

    // get places within bounds (asynchronously)
    var parameters = {
        ne: ne.lat() + "," + ne.lng(),
        q: $("#q").val(),
        sw: sw.lat() + "," + sw.lng()
    };
    $.getJSON("update.php", parameters)
    .done(function(data, textStatus, jqXHR) {

        // remove old markers from map
        removeMarkers();

        // add new markers to map
        for (var i = 0; i < data.length; i++)
        {
            addMarker(data[i]);
        }
     })
     .fail(function(jqXHR, textStatus, errorThrown) {

         // log error to browser's console
         console.log(errorThrown.toString());
     });
}

function getContent(marker, place) {
    var parametersForArticles = {
        geo: place.postal_code
    };
    
    var articles;
    var weather;
    
    $.getJSON("articles.php", parametersForArticles)
    .done(function(NewsData, textStatus, jqXHR) {
        articles = NewsData;
        
        var parametersForWeather = {
            latitude: place.latitude,
            longitude: place.longitude,
            APIKey: "APIKey" //you should add API open weather map key
        };
        
        $.getJSON("weather.php", parametersForWeather)
        .done(function (weatherData, textStatus, jqXHR) {
            weather = weatherData;
            showInfo(marker, generateHTMLListOfNews(articles), generateHTMLOfWeather(weather));
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
             console.log(errorThrown.toString());
         });
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
         console.log(errorThrown.toString());
     });
}


function generateHTMLListOfNews(news) {
    var html = "<h3>News:</h3>";
    var n = news.length;
    if (n != 0) {
        html += "<ul>";
        for (var i = 0; i < n; i++) {
            var article = news[i];
            html += "<li><a href='" + article.link + "' target='_blank'>" + article.title + "</a></li>";
        }
        
        html += "</ul>";
    } else
        html += "Slow news day!";
    
    return html;
}

function generateHTMLOfWeather(weather) {
    var html = "<h3>Weather:</h3>";
    if (weather !== "undefined") {
        html += "<div id='weather'><h4>";
        html += "<img src='https://openweathermap.org/img/w/" + weather.weather[0].icon + ".png'/>";
        html += weather.main.temp + "&#176;C ";
        html += "<span>(max: " + weather.main.temp_max + "&#176;C; </span>";
        html += "<span>min: " + weather.main.temp_min + "&#176;C)</span></h4>";
        html += "<div class='panel panel-info'><div class='panel-heading'>" + weather.weather[0].description + "</div>";
        html += "<div class='panel-body'><span class='text-info'>Wind: </span>" + weather.wind.speed + " m/s</br>";
        html += "<span class='text-info'>Pressure: </span>" + weather.main.pressure + " hpa</br>";
        html += "<span class='text-info'>Humidity: </span>" + weather.main.humidity + " %</br></div></div></div>";
    } else
        html += "Don't get data of wetaher!";
        
    return html;
}

function setMapToHarvard() {
    map.setCenter({lat: 42.374490, lng: -71.117185});
    map.setZoom(15);  
};

function setMapToYale() {
    map.setCenter({lat: 41.3163284, lng: -72.9245318});
    map.setZoom(15);  
};
