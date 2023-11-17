import {TrackingDataLayer} from './trackingDataLayer.js'
import {TrackingEvents} from './trackingEvents.js'
;(function (window, $) {
    let tdl = new TrackingDataLayer()
    tdl.push()
    let te = new TrackingEvents()
    te.listen()
})(window, jQuery);