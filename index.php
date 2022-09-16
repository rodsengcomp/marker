<?php


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>
<body>

<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    #mapesp {
        height: 70%;
        margin-left: 20px;
        margin-right: 20px;
    }
    /* Optional: Makes the sample page fill the window. */
    html, body {
        height: 100%;
        margin-left: 20px;
        margin-right: 20px;
    }
</style>
<br>
<br>
    <?php if (isset($_SESSION['msgedit'])) {echo $_SESSION['msgedit'];unset($_SESSION['msgedit']);}?>
<br>

<div id="mapesp"></div>

<script>
    var iconBase = 'imagens/';
    var icons = {
        GATO: {
            icon: iconBase + 'cat.png'
        },
        CAO: {
            icon: iconBase + 'cao.png'
        }

    };

    function initMap(callback) {
        var map = new google.maps.Map(document.getElementById('mapesp'), {
            center: new google.maps.LatLng(-23.454514, -46.572842),
            zoom: 22
            // mapTypeId: 'terrain'
        });
        var infoWindow = new google.maps.InfoWindow;

        // Altere isso dependendo do nome do seu arquivo PHP ou XML
        downloadUrl('maps/proc/proc-maps-esporo.php', function(data) {
            var xml = data.responseXML;
            var markers = xml.documentElement.getElementsByTagName('marker');
            Array.prototype.forEach.call(markers, function(markerElem) {
                var id = markerElem.getAttribute('id');
                var name = markerElem.getAttribute('name');
                var name_animal = markerElem.getAttribute('name_animal');
                var address = markerElem.getAttribute('address');
                var type = markerElem.getAttribute('type');
                var lat = markerElem.getAttribute('lat');
                var lng = markerElem.getAttribute('lng');
                var point = new google.maps.LatLng(
                    parseFloat(markerElem.getAttribute('lat')),
                    parseFloat(markerElem.getAttribute('lng')));
                var html =
                    '<p class="text-center p-0" xmlns="http://www.w3.org/1999/html"><h6>NOME : '
                    + name_animal +
                    '</h6></p>' +
                    '<p class="text-center p-0"><h6>LAT/LNG : '
                    + lat +
                    ' , '
                    + lng +
                    '</h6></p>' +
                    '<p class="text-center p-0"><h6>ESPÉCIE : '
                    + type +
                    '</h6></p>' +
                    '<p class="text-center p-0"><a class="btn btn-warning" href="editar?id=' + id + '" role="button">'
                    + id +
                    '</a></p>';

                var infowincontent = document.createElement('div');
                var strong = document.createElement('strong');
                strong.textContent = name
                infowincontent.appendChild(strong);
                infowincontent.appendChild(document.createElement('br'));

                var text = document.createElement('text');
                text.textContent = address
                infowincontent.appendChild(text);
                var marker = new google.maps.Marker({
                    map: map,
                    position: point,
                    icon: icons[type].icon
                });

                marker.addListener('click', function () {
                    map.setZoom(22);
                    map.setCenter(marker.getPosition());
                    if (type == 'CAO') {
                        infoWindow.setContent(html);
                    } else if (type == 'GATO') {
                        infoWindow.setContent(html);
                    } else {
                        infoWindow.setContent(html);
                    }
                    infoWindow.open(map, marker);
                });

            });
        });
    }


    // Show the lat and lng under the mouse cursor.
    var coordsDiv = document.getElementById('coords');
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(coordsDiv);
    map.addListener('mousemove', function(event) {
        coordsDiv.textContent =
            'lat: ' + Math.round(event.latLng.lat()) + ', ' +
            'lng: ' + Math.round(event.latLng.lng());
    });

    function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
            if (request.readyState == 4) {
                request.onreadystatechange = doNothing;
                callback(request, request.status);
            }
        };

        request.open('GET', url, true);
        request.send(null);
    }

    function doNothing() {}
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAhlslumr1saHPVEJHkzPssYLEsWZJQQKU&callback=initMap">
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
<script src="js/form-validation.js"></script>

</body>
</html>
