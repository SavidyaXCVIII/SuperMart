var map;
var InforObj = [];
var centerCords = {
    lat: 6.928791067723671,
    lng: 79.8796843036094
};
var markersOnMap = [{
    place: "Supermart LLC - Col 01",
    address: "224 Old Moor Street 12, Colombo 01",
    directions: "https://goo.gl/maps/zQE8T7EPcwZwAv429",
    LatLng: [{
        lat: 6.928791067723671,
        lng: 79.8796843036094
    }]
},
    {
        place: "Supermart LLC - Col 02",
        address: "105 Havelock Road, Colombo 02",
        directions: "https://goo.gl/maps/WtWNfW8Sggw8DR5a9",
        LatLng: [{
            lat: 6.812509276523612,
            lng: 79.87188105611756
        }]
    },
    {
        place: "Supermart LLC- Col 03",
        address: " 230 Galle Road, Colombo 03",
        directions: "https://goo.gl/maps/YSs2We24pQuUyQTb8",
        LatLng: [{
            lat: 6.970661270067149,
            lng: 79.9793996197056
        }]
    },
    {
        place: "Supermart LLC - Col 04",
        address: "26/1, Colonel T G Wardana Mawatha, Colombo 04",
        directions: "https://goo.gl/maps/R1VE5cvZyfZ8PfVBA",
        LatLng: [{
            lat: 6.921870699027631,
            lng: 79.89382362011513
        }]
    },
    {
        place: "Supermart LLC - Col 05",
        address: " 35/A Grandpass Road,Colombo 05",
        directions: "https://goo.gl/maps/u94eRSuUZdhTd9ePA",
        LatLng: [{
            lat: 6.984600501809108,
            lng: 79.89075166115548
        }]
    }
];

window.onload = function () {
    initMap();
};

function addMarkerInfo() {
    for (var i = 0; i < markersOnMap.length; i++) {
        var contentString = '<div id="content"><h5 class="fw-bold">' + markersOnMap[i].place +
            '</h5><p>' + markersOnMap[i].address +
            '</p><span class="fw-bold">4.1 </span><i class="fa fa-star text-warning" aria-hidden="true"></i>' +
            '<i class="fa fa-star text-warning" aria-hidden="true"></i><i class="fa fa-star text-warning" aria-hidden="true"></i>' +
            '<i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><span class="text-success"> 96 reviews</span>' +
            '<br><br><a href=\'' + markersOnMap[i].directions + '\'>Get directions</a></div>';

        const marker = new google.maps.Marker({
            position: markersOnMap[i].LatLng[0],
            map: map
        });

        const infowindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 240
        });

        marker.addListener('click', function () {
            closeOtherInfo();
            infowindow.open(marker.get('map'), marker);
            InforObj[0] = infowindow;
        });
    }
}

function closeOtherInfo() {
    if (InforObj.length > 0) {
        /* detach the info-window from the marker ... undocumented in the API docs */
        InforObj[0].set("marker", null);
        /* and close it */
        InforObj[0].close();
        /* blank the array */
        InforObj.length = 0;
    }
}

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 11,
        center: centerCords
    });
    addMarkerInfo();
}