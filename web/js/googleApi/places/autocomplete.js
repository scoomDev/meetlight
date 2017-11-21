const initializeAutocomplete = (id) => {
    const element = document.getElementById(id);
    if (element) {
        const autocomplete = new google.maps.places.Autocomplete(element, { types: ['address'] });
        google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);
    }
}

function onPlaceChanged() {
    const place = this.getPlace();

    // console.log(place);  // Uncomment this line to view the full object returned by Google API.

    for (let i in place.address_components) {
        let component = place.address_components[i];
        for (let j in component.types) {  // Some types are ["country", "political"]
            let type_element;
            if (document.getElementById("fos_user_registration_form_" + component.types[j])) {
                type_element = document.getElementById("fos_user_registration_form_" + component.types[j]);
            } else {
                type_element = document.getElementById("fos_user_profile_form_" + component.types[j]);
            }
            console.log(type_element);
            if (type_element) {
                type_element.value = component.long_name;
            }
        }
    }
}

google.maps.event.addDomListener(window, 'load', () => {
    initializeAutocomplete('user_input_autocomplete_address');
});