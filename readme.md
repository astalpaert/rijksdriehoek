# Rijksdriehoek
Transform Dutch National Grid coordinate system (EPSG:28992 Amersfoort / RD New) to GPS lat lon (EPSG:4326 WGS 84).
Based on formula from: https://github.com/djvanderlaan/rijksdriehoek


## Installation
* composer install

## Usage
``` use PHPUnit\Framework\TestCase; ```
```
Rijksdriehoek::toLatLon([
   75890.199, // x
   447247.664 // y
])
```
## Testing
* composer test
