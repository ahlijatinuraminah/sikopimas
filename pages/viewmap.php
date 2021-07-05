<?php
    include "authorizationuser.php";
?>
<div id="mapid" style="width: 100%; height: 350px; margin-bottom: 20px;"></div>

<script>
    var id_provinsi = "";
    var id_negara ="";
    var id_bidangkerja = "";
    var id_kabupatenkota = "";
    var tingkat_kerawanan = "";
    var id_mitra = "";
    var id_statusperizinan = "";
    var id_isu = "";
    var id_mitralokal = "";
    var nama_organisasi ="";
    var provinsi;
    var kabupaten_kota;
    var markers_provinsi;
    var markers_kabupatenkota;
    var map;
    var lastOpenInfoWin = null;
    var radi = {provinsi: 25000, kabupaten_kota: 7500};

    var defaultLat = -2.2459632;
    var defaultLng = 117.2409634;
    var defaultZoom = 4.5;
    var resetMap = false;
    var latProv = 0;
    var lngProv = 0;

    function gotoTable() {
        var target = $("#tblorganisasi");
        debugger;
        $("html, body").animate(
            {
                scrollTop: target.offset().top,
            },
            500,
            function () {
                var $target = $(target);
                //$target.focus();
                if ($target.is(":focus")) {
                    // Checking if the target was focused
                    return false;
                } else {
                    $target.attr("tabindex", "-1"); // Adding tabindex for elements not focusable
                    //$target.focus(); // Set focus again
                }
            }
        );
    }

    function createTooltip(marker, key, type) {
        var content;
        if(type == 'provinsi')
            content = "<h6 class='tooltipHeader'>" + provinsi[key].nama_provinsi + "</h6><div class='tooltipDetail'>" + provinsi[key].jumlah_organisasi + " organizations</div>"
        else if (type == 'kabupatenKota')
            content = "<h6 class='tooltipHeader'>" + kabupaten_kota[key].nama_kabupatenkota + "</h6><div class='tooltipDetail'>" + kabupaten_kota[key].jumlah_organisasi + " organizations</div>"

        marker.bindPopup(content);
        marker.on('mouseover', function (e) {
            this.openPopup();
        });
        marker.on('mouseout', function (e) {
            this.closePopup();
        });
    }

    function createInfoWindow(loc, marker, key) {
        marker.addEventListener("click", function (e) {
            map.removeLayer(markers_provinsi);
            map.flyTo(e.target.getLatLng(), 7);
            loadKabupatenKotaMarkers(loc.id)
            //gotoTable();
            id_provinsi = provinsi[key].id;
            $("#ddlProvinsi").val(id_provinsi).trigger("change");            
            filterByProvinsi();
            $("#splokasi").html(provinsi[key].nama_provinsi);
        });
    }

    function createInfoWindowKab(loc, marker, key) {
        
        marker.addEventListener("click", function (e) {            
            id_kabupatenkota = kabupaten_kota[key].id;
            filterByKabupatenKota();                       
            //gotoTable(); 
        });
    }

    function loadKabupatenKotaMarkers(id_provinsi) {
        markers_kabupatenkota.clearLayers();
        map.removeLayer(markers_provinsi);
        map.removeLayer(markers_kabupatenkota);
        $.post(
            "controller/controllerkabupatenkota.php",
            {
                id_provinsi: id_provinsi,
                id_kabupatenkota: id_kabupatenkota,
                id_bidangkerja: id_bidangkerja,
				id_negara: id_negara,
                tingkat_kerawanan: tingkat_kerawanan,
                id_mitra : id_mitra,
                id_statusperizinan : id_statusperizinan,
                id_isu : id_isu,
                id_mitralokal : id_mitralokal,
                nama_organisasi:nama_organisasi,
                mode: "loadbyprovinsi",
            },
            function (data, status) {
                debugger;
                console.log(data);
                kabupaten_kota = JSON.parse(data);

                for (var key in kabupaten_kota) {
                    var myPlace = kabupaten_kota[key];
                   // var marker = L.marker(new L.LatLng(myPlace.lati, myPlace.longi));
                   var marker = L.circle(new L.LatLng(myPlace.lati, myPlace.longi), {
                        color: 'blue',
                        fillColor: 'blue',
                        fillOpacity: 1,
                        radius: radi.kabupaten_kota,
                    }).bindTooltip(kabupaten_kota[key].jumlah_organisasi, {
                        permanent: true,
                        direction: 'center',
                        className: 'text'
                    });
                    
                    markers_kabupatenkota.addLayer(marker);
                    createInfoWindowKab(myPlace, marker, key);
                    createTooltip(marker, key, 'kabupatenKota');
                }
                //sini ada
                map.once('zoomend', function () {
                    map.addLayer(markers_kabupatenkota);
                });
            }
        );
    }

    function loadProvinsiMarkers() {
        debugger;
        markers_kabupatenkota.clearLayers();
        map.removeLayer(markers_provinsi);
        map.removeLayer(markers_kabupatenkota);
        $.post(
            "controller/controllerprovinsi.php",
            {
                id_provinsi: id_provinsi,
				id_bidangkerja: id_bidangkerja,
				id_negara: id_negara,
                tingkat_kerawanan: tingkat_kerawanan,
                id_mitra : id_mitra,
                id_statusperizinan : id_statusperizinan,
                id_isu : id_isu,
                id_mitralokal : id_mitralokal,
                nama_organisasi:nama_organisasi,
                mode: "loadmap",
            },
            function (data, status) {
                
                provinsi = JSON.parse(data);
                

                for (var key in provinsi) {
                    var myPlace = provinsi[key];
                    //var marker = L.marker(new L.LatLng(myPlace.lati, myPlace.longi));
                    var marker = L.circle(new L.LatLng(myPlace.lati, myPlace.longi), {
                        color: 'blue',
                        fillColor: 'blue',
                        weight:7,
                        fillOpacity: 1,
                        radius: radi.provinsi,
                    }).bindTooltip(provinsi[key].jumlah_organisasi, {
                        permanent: true,
                        direction: 'center',
                        className: 'text'
                    });                    
                    
                    markers_provinsi.addLayer(marker);
                    createInfoWindow(myPlace, marker, key);
                    createTooltip(marker, key, 'provinsi');
                }
                if(map.getZoom() == defaultZoom)
                    map.addLayer(markers_provinsi)
                else {
                    map.once('zoomend', function () {
                        map.addLayer(markers_provinsi);
                    });
                }
            }
        );
    }

    function createMap() {
        var mapOptions = {
            center: [defaultLat, defaultLng],
            zoom: defaultZoom,
            gestureHandling: true
        };

        map = new L.map('mapid', mapOptions);
        L.tileLayer("https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}", {
            attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
            maxZoom: 18,
            id: "mapbox/streets-v11",
            tileSize: 512,
            zoomOffset: -1,
            accessToken: "pk.eyJ1IjoiYmlsbGFoZWFnbGUiLCJhIjoiY2tmcmtuczhpMGU2dTJ4bnBmYjV2MW9idiJ9.WNlEfnpv8ZS8YuBy7x4MTQ"
        }).addTo(map);
        map.flyTo([defaultLat, defaultLng], defaultZoom);
        markers_provinsi = L.layerGroup();
        markers_kabupatenkota = L.layerGroup();
        loadProvinsiMarkers();
    }

    function changeRadius(diff, radi) {
        if(diff >= 0) return radi / Math.pow(2, Math.abs(diff));
        else return radi * Math.pow(2, Math.abs(diff));
    }

    function mapController(currZoom) {
        if(map.hasLayer(markers_kabupatenkota) && currZoom < 6) {
            loadProvinsiMarkers();
            table.search("").columns().search("").draw();  //reload table when zoom out
            $("#splokasi").html('');
            $("#ddlProvinsi").val('').trigger('change');
        }
        markers_provinsi.eachLayer(function (layer) {
            layer.setRadius(changeRadius(currZoom - 5, radi.provinsi));
        });
        markers_kabupatenkota.eachLayer(function (layer) {
            layer.setRadius(changeRadius(currZoom - 7, radi.kabupaten_kota));
        });
    }

    $(document).ready(function () {
        createMap();
        map.on("zoomend", function (e) {            
            var currZoom = map.getZoom();
            mapController(currZoom)
        })
    });
</script>
