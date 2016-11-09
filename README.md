# Warped Maps to IFrames

Example of embeddable URL:
`http://tools.wmflabs.org/warped-to-iframe/map.php?pageid=35092716`

The view should automatically fit to the warped map. In the future it would be nice to have a search/settings page for generating all HTML code needed to embed maps externally at `index.php`.

## Optional Parameters

```
wmf=true
```
Use the `wmf` parameter if you would like to use the Wikimedia Maps base-layer, this only works on selected sites maintained by the Wikimedia Foundation.

```
opacity=true
```

The `opacity` parameter will add a opacity slider to the map, allowing users to compare the underlaying base-map with the georeferenced one.
