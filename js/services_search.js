
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
                var customerNameCell = row.querySelector('td:nth-child(1)');
                var serviceCell = row.querySelector('td:nth-child(2)');
                var customer_name = customerNameCell.innerText.toLowerCase();
                var fullCustomerName = customerNameCell.getAttribute('data-fullname').toLowerCase();
                var fullService = serviceCell.getAttribute('data-service').toLowerCase();
                var service_availed = row.querySelector('td:nth-child(2)').innerText.toLowerCase();

                // Check if the query matches the shortened or full customer name, or service availed
                if (customer_name.includes(query) || fullCustomerName.includes(query) || service_availed.includes(query) || fullService.includes(query)) {
                    row.style.display = ''; // Show the row
                    hasMatch = true;
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