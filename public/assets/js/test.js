

        /**
         * @see https://geoservices.ign.fr/blog/2018/09/06/acces_geoportail_sans_compte.html
         */
         const GEOPORTAL_API_KEY = 'choisirgeoportail';

         /**
         * Renvoie l'URL de la couche geoportail
         */
         function getGeoportalURL( layerName ){
             var url = "https://wxs.ign.fr/"+GEOPORTAL_API_KEY+"/geoportail/wmts?SERVICE=WMTS&VERSION=1.0.0&REQUEST=GetTile";
             url += "&LAYER="+layerName;
             url += "&STYLE=normal&FORMAT=image/png";
             url += "&TILEMATRIXSET=PM&TILEMATRIX={z}&TILEROW={y}&TILECOL={x}" ;
             return url ;
         }
 
         var map = L.map('map').setView([47.23,6.02], 14);
         L.tileLayer(getGeoportalURL('GEOGRAPHICALGRIDSYSTEMS.PLANIGNV2'), {
             maxZoom: 18,
             attribution: '&copy; <a href="https://www.ign.fr/">IGN</a>',
             id: 'ignf/carte'
         }).addTo(map);
 
         /* création du client WFS */
         var wfsClient = new GeoportalWfsClient({
             apiKey: GEOPORTAL_API_KEY
         });
 
         /* utilitaire d'affichage d'une popup */
         var popup = L.popup();
         function showPopup(latlng,content){
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
             /* recherche WFS */
             wfsClient.getFeatures(
                 'CADASTRALPARCELS.PARCELLAIRE_EXPRESS:parcelle',
                 filter
             ).then(function(geojson){
                 /* affichage de la popup */
                 const message = geojson.features.length == 0 ? 'Parcelle non trouvée' : 'Parcelle '+geojson.features[0].properties.idu
                 showPopup(e.latlng, message);
                 if ( geojson.features.length == 0 ){
                     return;
                 }
                 /* rendu des parcelles */
                 const geojsonLayer = L.geoJSON(geojson);
                 geojsonLayer.addTo(layerGroup);
                 map.fitBounds(geojsonLayer.getBounds());
             })
             .catch(function(err){
                 console.log(err);
                 showPopup(e.latlng,"Une erreur s'est produite (voir console)");
             });
         }
 
         map.on('click', onMapClick);
 
     