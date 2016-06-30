<?php
if (isset($_GET['pageid'])) {
  $curl = curl_init();

  curl_setopt($curl, CURLOPT_URL, 'https://warper.wmflabs.org/api/v1/maps?field=page_id&query=' . $_GET['pageid']);

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  $result = json_decode(curl_exec($curl));
  curl_close($curl);

  if ($result->data[0]->attributes->status == 'warped') {
    // Leaflet does not really deal with WMS...
    $wms = str_replace('?request=GetCapabilities&service=WMS&version=1.1.1', '', $result->data[0]->links->wms);
    $commons = 'https://commons.wikimedia.org/?curid=' . $_GET['pageid'];
    $bbox = explode(',', $result->data[0]->attributes->bbox);
?>
<!doctype html>
<html>
  <head>
    <title>Embedded Map</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://tools-static.wmflabs.org/cdnjs/ajax/libs/leaflet/0.7.7/leaflet.css">
    <script src="https://tools-static.wmflabs.org/cdnjs/ajax/libs/leaflet/0.7.7/leaflet.js"></script>
    <style>
      body {
        margin: 0;
        padding: 0;
        height: 100vh;
        width: 100vw;
      }
    </style>
    <script>
      window.onload = function() {
        var map = L.map('map').fitBounds([
          [<?php echo $bbox[3] ?>, <?php echo $bbox[2] ?>],
          [<?php echo $bbox[1] ?>, <?php echo $bbox[0] ?>]
        ]);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var wmsLayer = L.tileLayer.wms('<?php echo $wms; ?>', {
          layers: 'MapWarper',
          format: 'image/png',
          attribution: '<a href="<?php echo $commons; ?>">Wikimedia Commons</a>'
        }).addTo(map);
      }
    </script>
  </head>
  <body id="map">
    
  </body>
</html>
<?php
  } else {
    echo 'This map is not yet warped!';
  }
}