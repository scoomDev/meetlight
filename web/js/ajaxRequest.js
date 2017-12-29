function invitation($containerId, jsonUrl)
{
    let $container = document.querySelector($containerId);

    $.ajax({
        type: "GET",
        url: jsonUrl,
        success: function (response) {
            if (response !== false) {
                $container.innerHTML = response;
            } else {
                $container.innerHTML = 'error';
            }
        }
    });
}
