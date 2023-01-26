//'use strict';


/*********************************************************/
/*************** INITIALISATION DE LA CARTE **************/

var map = L.map('map', {measureControl:true}).setView([45.76, 4.85], 14);
/********************************************************************************************/

/*********************************************************/
/*************** GEOAPIFY FORM RECHERCHE *****************/
var marker = null;
var myAPIKey = "4c276576aff9404c8418ec208b227049"; // Get an API Key on https://myprojects.geoapify.com
var mapURL = L.Browser.retina
  ? `https://maps.geoapify.com/v1/tile/{mapStyle}/{z}/{x}/{y}.png?apiKey={apiKey}`
  : `https://maps.geoapify.com/v1/tile/{mapStyle}/{z}/{x}/{y}@2x.png?apiKey={apiKey}`;

// Add map tiles layer. Set 20 as the maximal zoom and provide map data attribution.
var OSM = L.tileLayer(mapURL, {
  attribution: 'Powered by Geoapify | © OpenMapTiles © OpenStreetMap contributors',
  apiKey: myAPIKey,
  mapStyle: "osm-bright-smooth", // More map styles on https://apidocs.geoapify.com/docs/maps/map-tiles/
  maxZoom: 20
});

// Add Geoapify Address Search control
const addressSearchControl = L.control.addressSearch(myAPIKey, {
  position: 'topright',
  resultCallback: (address) => {
    if (marker) {
      marker.remove();
    }    
    if (!address) {
      return;
    }
    marker = L.marker([address.lat, address.lon]).addTo(map);
    if (address.bbox && address.bbox.lat1 !== address.bbox.lat2 && address.bbox.lon1 !== address.bbox.lon2) {
      map.fitBounds([[address.bbox.lat1, address.bbox.lon1], [address.bbox.lat2, address.bbox.lon2]], { padding: [100, 100] })
    } else {
      map.setView([address.lat, address.lon], 15);
    }
    console.log(address);
    const postcodeAPI = address.postcode;
    const commune = address.city;
    
    // url de l'API carto pour obtenir le code commune d'une commune à partir du code postal (même si ça recouvre plusieurs communes)
    let apiCartoUrl_cp = "https://apicarto.ign.fr/api/codes-postaux/communes/"+postcodeAPI;

    fetch(apiCartoUrl_cp)
        .then(response => {
            //console.log(response);            
            return response.json();
        }).then(results => { 
            // url de l'API carto pour obtenir le zonage d'une commune à partir du code commune
            console.log(results);
            for(var i=0; i<results.length; i++) {
                if(results[i].nomCommune == commune || results[i].libelleAcheminement == commune.toUpperCase()) {
                    return printLayers("https://apicarto.ign.fr/api/gpu/zone-urba?partition=DU_"+results[i].codeCommune);
                }
            }
        });  

    function onEachFeature(feature, layer) {    
        if (feature.properties.typezone == 'N') {
            layer.bindPopup("<h1>Zonage de "+feature.properties.gid+"</h1></br>" + "Partition : " + feature.properties.partition + "</br>" + "Type de zone : " + feature.properties.typezone + "</br>" + "Libellé : " + feature.properties.libelle + "</br>" + "Description : " + feature.properties.libelong);
            map.fitBounds(layer.getBounds());
            layer.setStyle({
                weight: 2,
                color: 'black',
                fillColor: '#00FF00',
                dashArray: '',
                fillOpacity: 0.4
            });
        } else if (feature.properties.typezone == 'A') {
            layer.bindPopup("<h1>Zonage de "+feature.properties.gid+"</h1></br>" + "Partition : " + feature.properties.partition + "</br>" + "Type de zone : " + feature.properties.typezone + "</br>" + "Libellé : " + feature.properties.libelle + "</br>" + "Description : " + feature.properties.libelong);
            map.fitBounds(layer.getBounds());
            layer.setStyle({
                weight: 2,
                color: 'black',
                fillColor: '#008000',
                dashArray: '',
                fillOpacity: 0.4
            });
        /*} else if (feature.properties == '') {
            layer.bindPopup("<h1>Données zonage non à jour pour l'instant</h1>");*/
        } else {
            layer.bindPopup("<h1>Zonage type non N/A</h1>");
            layer.setStyle({
                weight: 0
            });
        }
    }

    function printLayers(apiCartoUrl_cc) {
        // récupération des données renvoyées par l'API et affichage sur la carte
        fetch(apiCartoUrl_cc)
            .then(response => {
                //console.log(response);            
                return response.json();
            }).then(geojsonFeature => {
                console.log("geojsonFeature:");
                console.log(geojsonFeature);   
                if(geojsonFeature.length == 0) {
                    
                } else {
                    return L.geoJSON(geojsonFeature, {
                        onEachFeature: onEachFeature
                    }).addTo(map);
                }
            });
        }

  },
  suggestionsCallback: (suggestions) => {
        //console.log(suggestions);
  }
});
map.addControl(addressSearchControl);
/********************************************************************************************/


/*********************************************************/
/********************** MEASURE **************************/
map.on('measurefinish', function(evt) {
    writeResults(evt);
});

function writeResults(results) {
    document.getElementById('eventoutput').innerHTML = 
    '<h1>Tracé informations:</h1> ' + '</br>' +      
    'Nombre de points: '+ results.pointCount + '</br>' +
    'Point de départ: ' + results.points[0] + '</br>' +
    'Aire: '+ results.areaDisplay + '</br>' +                                
    'Périmètre: '+ results.lengthDisplay;          
}
/********************************************************************************************/


/*********************************************************/
/******************** EXPORT DATA ************************/
let saveFile = () => {
    // This variable stores all the data.
    let data = 
    '/******************************************/\r\n'+
    '/**************** GEOPV *******************/\r\n'+
    '/******************************************/\r\n\n'+       
    ((document.getElementById('eventoutput').innerText).replaceAll('</br>', '\n'));
    console.log((document.getElementById('eventoutput').innerText).replaceAll('</br>', '\n').replaceAll('<h1>', '<h1 style="color:white">'));
    
    // Convert the text to BLOB.
    const textToBLOB = new Blob([data], { type: 'text/plain' });
    const sFileName = 'GeoPV_données.txt';	   // The file to save the data.

    let newLink = document.createElement("a");
    newLink.download = sFileName;

    if (window.webkitURL != null) {
        newLink.href = window.webkitURL.createObjectURL(textToBLOB);
    }
    else {
        newLink.href = window.URL.createObjectURL(textToBLOB);
        newLink.style.display = "none";
        document.body.appendChild(newLink);
    }     
    newLink.click();
}
/********************************************************************************************/


/*********************************************************/
/***************** COUCHES PAR DEFAUT ********************/

// Photographies aériennes en-dessous de Plan IGN "images réels donc"
var OrthoIGN = L.tileLayer('https://wxs.ign.fr/{ignApiKey}/geoportail/wmts?'+
    '&REQUEST=GetTile&SERVICE=WMTS&VERSION=1.0.0&TILEMATRIXSET=PM'+
    '&LAYER={ignLayer}&STYLE={style}&FORMAT={format}'+
    '&TILECOL={x}&TILEROW={y}&TILEMATRIX={z}',
    {
        ignApiKey: 'decouverte',
        ignLayer: 'ORTHOIMAGERY.ORTHOPHOTOS',
        style: 'normal',
        format: 'image/jpeg',
        service: 'WMTS'
}).addTo(map);

// Plan IGN de la france "images non réels" avec une transparence de 50%
var PlanIGN = L.tileLayer('https://wxs.ign.fr/{ignApiKey}/geoportail/wmts?'+
    '&REQUEST=GetTile&SERVICE=WMTS&VERSION=1.0.0&TILEMATRIXSET=PM'+
    '&LAYER={ignLayer}&STYLE={style}&FORMAT={format}'+
    '&TILECOL={x}&TILEROW={y}&TILEMATRIX={z}',
    {
        ignApiKey: 'decouverte',
        ignLayer: 'GEOGRAPHICALGRIDSYSTEMS.PLANIGNV2',
        style: 'normal',
        format: 'image/png',
        service: 'WMTS'
});

// Plan des cadastre en-dessous de Plan IGN
var CadIGN = L.tileLayer('https://wxs.ign.fr/{ignApiKey}/geoportail/wmts?'+
    '&REQUEST=GetTile&SERVICE=WMTS&VERSION=1.0.0&TILEMATRIXSET=PM'+
    '&LAYER={ignLayer}&STYLE={style}&FORMAT={format}'+
    '&TILECOL={x}&TILEROW={y}&TILEMATRIX={z}',
    {
        ignApiKey: 'essentiels',
        ignLayer: 'CADASTRALPARCELS.PARCELLAIRE_EXPRESS',
        style: 'normal',
        format: 'image/png',
        service: 'WMTS',
        opacity: 0.8
});

var EleIGN1 = L.tileLayer('https://wxs.ign.fr/{ignApiKey}/geoportail/wmts?'+
    '&REQUEST=GetTile&SERVICE=WMTS&VERSION=1.0.0&TILEMATRIXSET=PM'+
    '&LAYER={ignLayer}&STYLE={style}&FORMAT={format}'+
    '&TILECOL={x}&TILEROW={y}&TILEMATRIX={z}',
    {
        ignApiKey: 'topographie',
        ignLayer: 'UTILITYANDGOVERNMENTALSERVICES.ALL',       // POUR TOUTES LES LIGNES ELECTRIQUE EUROPEENNES
        style: 'normal',
        format: 'image/png',
        service: 'WMTS',
        opacity: 0.7
});

// SERVICE WMS:
var PluIGN = L.tileLayer.wms('https://wxs-gpu.mongeoportail.ign.fr/externe/vkd1evhid6jdj5h4hkhyzjto/wms/v?', 
    {
        layers: 'zone_secteur',
        format: 'image/png', 
        transparent: true, 
        opacity: 0.5
});
//console.log(PluIGN);
/********************************************************************************************/


/*********************************************************/
/*********** COUCHES PARCELLES PAR DBLCLIC ***************/

/* création du client WFS */
var wfsClient = new GeoportalWfsClient({
    apiKey: 'essentiels'    //const GEOPORTAL_API_KEY = 'choisirgeoportail';
});

/* affichage d'une popup */
var popup = L.popup();

function showPopup(latlng, content){
    popup
        .setLatLng(latlng)
        .setContent(content)        
        .openOn(map)
    ;
}

var layerGroup = L.layerGroup().addTo(map);

function onMapClick(e) {
    /* nettoyage de l'affichage */
    layerGroup.clearLayers();

    /* préparation du filtre */
    let filter = {};

    filter.geom = {
        type: "Point",
        coordinates: [e.latlng.lng, e.latlng.lat]
    };

    /* style du rendu des parcelles */
    var myStyle = {
        "color": "red",
        "weight": 1,
        "opacity": 1
    };

    /* recherche WFS */
    wfsClient.getFeatures(
        'CADASTRALPARCELS.PARCELLAIRE_EXPRESS:parcelle',
        filter
    ).then(function(geojson){
        /* affichage de la popup */        
        const message = geojson.features.length == 0 ? 'Parcelle non trouvée' : '<h1>Parcelle</h1>'+'</br>'+'Numéro parcelle: '+geojson.features[0].properties.numero+'</br>'+'Section:  '+geojson.features[0].properties.section+'</br>'+'Superficie:  '+(geojson.features[0].properties.contenance*0.0001).toFixed(3)+' Hectares'+'</br>'+'Code département:  '+geojson.features[0].properties.code_dep+'</br>'+'Code Insee:  '+geojson.features[0].properties.code_insee+'</br>'+'Nom commune:  '+geojson.features[0].properties.nom_com+'</br>'+e.latlng.lat+','+e.latlng.lng 
       
        document.getElementById('eventoutput').innerHTML = 
        '<h1 style="color:white">Parcelle</h1>'+'</br>'+'Numéro parcelle: '+geojson.features[0].properties.numero+'</br>'+'Section:  '+geojson.features[0].properties.section+'</br>'+'Superficie:  '+(geojson.features[0].properties.contenance*0.0001).toFixed(3)+' Hectares'+'</br>'+'Code département:  '+geojson.features[0].properties.code_dep+'</br>'+'Code Insee:  '+geojson.features[0].properties.code_insee+'</br>'+'Nom commune:  '+geojson.features[0].properties.nom_com+'</br>'+e.latlng.lat+','+e.latlng.lng     

        showPopup(e.latlng, message);
        if ( geojson.features.length == 0 ){
            return;
        }
        /* rendu des parcelles */
        const geojsonLayer = L.geoJSON(geojson,{
            style: myStyle
        });
        console.log(geojsonLayer);        
        geojsonLayer.addTo(layerGroup);
        map.fitBounds(geojsonLayer.getBounds());
    })
    .catch(function(err){
        console.log(err);
        showPopup(e.latlng,"Une erreur s'est produite (voir console)");
    });    
}

map.on('dblclick', onMapClick);
/********************************************************************************************/


/*********************************************************/
/********** BOUTONS DE CONTROLES DES COUCHES  ************/

// Organisation des sélections de couches
var baseLayers = {    
    "Images aériennes": OrthoIGN,
    "osm": OSM,
    "Plan IGN": PlanIGN           
};

var overlays = {    
    "PLU": PluIGN,    
    "Cadastres": CadIGN,
    "Lignes électriques": EleIGN1
};

// Chargement des différents contrôles
L.control.layers(baseLayers, overlays).addTo(map);   
L.control.mousePosition().addTo(map);
L.control.scale({metric:true,imperial:false}).addTo(map);
L.control.resetView({position: "topleft", title: "Reset view", latlng: L.latLng([45.76, 4.85]), zoom: 14}).addTo(map);
L.geolet({ position: 'bottomleft', title: 'Trouver votre position' }).addTo(map);
/********************************************************************************************/


/*********************************************************/
/******************* LEGENDES COUCHE  ********************/

// Plan Local Urbanisme
var htmlLegendPLU = L.control.htmllegend({
    position: 'bottomright',
    legends: [{
        name: 'Plan Local Urbanisme',
        layer: PluIGN,
        elements: [{
            label: 'Légendes grossières du PLU',
            html: '<div class="container-fluid mb-1 plu"><ul class="text-left"><li class="d-flex align-items-center"><img src="./assets/img/UA_-_Zone_urbanisée.png" alt="" class="me-1" /><p> UA - Zone urbanisée</p></li><li class="d-flex align-items-center"><img src="./assets/img/A_-_Zone_à_usage_agricole.png" alt="" class="me-1" /><p> A - Zone à usage agricole</p></li><li class="d-flex align-items-center"><img src="./assets/img/N_-_Zone_naturelle.png" alt="" class="me-1" /><p> N - Zone naturelle</p></li></ul></div>'   
        }]
    }],
    defaultOpacity: 0.4,
    collapseSimple: true,
    detectStretched: true,
    visibleIcon: 'icon icon-eye',
    hiddenIcon: 'icon icon-eye-slash'
});
map.addControl(htmlLegendPLU);

// Cadastre
var htmlLegendCAD = L.control.htmllegend({
    position: 'bottomright',
    legends: [{
        name: 'Module cadastrale',
        layer: CadIGN,
        elements: [{
            label: 'Données cadastrales de l\'IGN',
            html: '<div class="container-fluid mb-1 cad"><ul class="text-left"><li class="d-flex align-items-center"><img src="./assets/img/Commune.png" alt="" class="me-1" /><p> Commune</p></li><li class="d-flex align-items-center"><img src="./assets/img/Limite_communale.png" alt="" class="me-1" /><p> Limite communale</p></li><li class="d-flex align-items-center"><img src="./img/Limite_de_section.png" alt="" class="me-1" /> Limite de section</p></li><li class="d-flex align-items-center"><img src="./assets/img/Division_cadastrale.png" alt="" class="me-1" /><p> Division cadastrale</p></li><li class="d-flex align-items-center"><img src="./assets/img/Limite_de_division_cadastrale.png" alt="" class="me-1" /><p> Limite de division cadastrale</p></li><li class="d-flex align-items-center"><img src="./assets/img/Parcelle.png" alt="" class="me-1" /><p> Parcelle</p></li></ul></div>'   
        }]
    }],
    defaultOpacity: 0.8,
    collapseSimple: true,
    detectStretched: true,
    visibleIcon: 'icon icon-eye',
    hiddenIcon: 'icon icon-eye-slash'
});
map.addControl(htmlLegendCAD);

// Lignes électriques
var htmlLegendELE = L.control.htmllegend({
    position: 'bottomright',
    legends: [{
        name: 'Lignes électriques',
        layer: EleIGN1,
        elements: [{
            label: 'Réseau de lignes électriques de l\'IGN',
            html: '<div class="container-fluid mb-1 cad"><ul class="text-left"><li class="d-flex align-items-center"><img src="./assets/img/Tension_inférieur_ou_égale_à_150kV.png" alt="" class="me-1" /><p> Ligne de tension inférieur à 150 kV</p></li><li class="d-flex align-items-center"><img src="./assets/img/Tension_de_225kV.png" alt="" class="me-1" /><p> Ligne de tension de 225 kV </p></li><li class="d-flex align-items-center"><img src="./assets/img/Tension_de_400kV.png" alt="" class="me-1" /><p> Ligne de tension de 400kV</p></li><li class="d-flex align-items-center"><img src="./assets/img/Poste_de_transformation.png" alt="" class="me-1" /><p> Poste de transformation</p></li></ul></div>'   
        }]
    }],
    defaultOpacity: 0.8,
    collapseSimple: true,
    detectStretched: true,
    visibleIcon: 'icon icon-eye',
    hiddenIcon: 'icon icon-eye-slash'
});
map.addControl(htmlLegendELE);
/********************************************************************************************/

