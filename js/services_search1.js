document.addEventListener('DOMContentLoaded', function () {
    // Get the input field and table
    var input = document.getElementById('searchInput');
    var table = document.querySelector('.table');
    var noDataFoundMessage = document.getElementById('noDataFound');

    // Add an event listener to the input field
    input.addEventListener('input', function () {
        // Get the search query and convert it to lowercase
        var query = input.value.toLowerCase();

        // Get all table rows in the tbody
        var rows = table.querySelectorAll('tbody tr');

        var hasMatch = false;

        // Loop through each row and hide/show based on the search query
        rows.forEach(function (row) {
            var productName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            var category = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

            // Check if the query matches the product name or category
            if (productName.includes(query) || category.includes(query)) {
                row.style.display = ''; // Show the row
                hasMatch = true; // Set hasMatch to true if there's a match
            } else {
                row.style.display = 'none'; // Hide the row
            }
        });

        // Display or hide the "No Data Found" message
        if (hasMatch) {
            noDataFoundMessage.style.display = 'none';
        } else {
            noDataFoundMessage.style.display = 'block';
        }
    });
});
