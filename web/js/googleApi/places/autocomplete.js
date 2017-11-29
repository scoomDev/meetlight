//-------------------------------------------------------------------------
// Google Places Autocomplete
//-------------------------------------------------------------------------
const initializeAutocomplete = (id) => {
    const element = document.getElementById(id);
    if (element) {
        const autocomplete = new google.maps.places.Autocomplete(element, { types: ['address'] });
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
    }
};

function onPlaceChanged() {
    const place = this.getPlace();

    for (let i in place.address_components) {
        let component = place.address_components[i];
        for (let j in component.types) {  // Some types are ["country", "political"]
            let type_element;
            if (document.getElementById("fos_user_registration_form_" + component.types[j])) {
                type_element = document.getElementById("fos_user_registration_form_" + component.types[j]);
            } else {
                type_element = document.getElementById("fos_user_profile_form_" + component.types[j]);
            }
            if (type_element) {
                type_element.value = component.long_name;
            }
        }
    }
}

google.maps.event.addDomListener(window, 'load', () => {
    initializeAutocomplete('user_input_autocomplete_address');
});

//-------------------------------------------------------------------------
// Google Maps Geocoder
//-------------------------------------------------------------------------
const addressInput = document.getElementById('user_input_autocomplete_address');
addressInput.addEventListener('change', () => {
    const geocoder = new google.maps.Geocoder();
    let latInput, lngInput;
    if (document.getElementById("fos_user_registration_form_lat")) {
        latInput = document.getElementById('fos_user_registration_form_lat');
        lngInput = document.getElementById('fos_user_registration_form_lng');
    } else {
        latInput = document.getElementById('fos_user_profile_form_lat');
        lngInput = document.getElementById('fos_user_profile_form_lng');
    }
    geocoder.geocode({'address': addressInput.value}, (results, status) => {
        if (status === "OK") {
            latInput.value = results[0].geometry.location.lat();
            lngInput.value = results[0].geometry.location.lng();
        } else {
            alert('Geocode was not successful for the following reason: ' + status);
        }
    });
});