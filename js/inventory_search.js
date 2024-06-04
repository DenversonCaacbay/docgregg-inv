
    document.addEventListener('DOMContentLoaded', function () {
        // Get the input field, table, and no data found message
        var input = document.getElementById('searchInput');
        var table = document.querySelector('.table');
        var noDataFoundMessage = document.getElementById('noDataFound');

        // Add an event listener to the input field
        input.addEventListener('input', function () {
            // Get the search query and convert it to lowercase
            var query = input.value.toLowerCase();

            var hasMatch = false;

            // Get all table rows in the tbody
            var rows = table.querySelectorAll('tbody tr');

            // Loop through each row and hide/show based on the search query
            rows.forEach(function (row) {
                var productCode = row.querySelector('td:nth-child(1)').textContent.toLowerCase(); // Change to nth-child(3) for Product Name
                var productName = row.querySelector('td:nth-child(3)').textContent.toLowerCase(); // Change to nth-child(3) for Product Name
                var category = row.querySelector('td:nth-child(6)').textContent.toLowerCase(); // Change to nth-child(6) for Category

                // Check if the query matches the product name or category
                if (productCode.includes(query) || productName.includes(query) || category.includes(query)) {
                    row.style.display = ''; // Show the row
                    hasMatch = true;
                } else {
                    row.style.display = 'none'; // Hide the row
                }
            });

            // Show/hide the no data found message
            noDataFoundMessage.style.display = hasMatch ? 'none' : 'block';
        });
    });


    // document.addEventListener('DOMContentLoaded', function () {
    //     // Get the input field and table
    //     var input = document.getElementById('searchInput');
    //     var table = document.querySelector('.table');
    //     var noDataFoundMessage = document.getElementById('noDataFound');

    //     // Add an event listener to the input field
    //     input.addEventListener('input', function () {
    //         // Get the search query and convert it to lowercase
    //         var query = input.value.toLowerCase();

    //         var hasMatch = false;

    //         // Get all table rows in the tbody
    //         var rows = table.querySelectorAll('tbody tr');

    //         // Loop through each row and hide/show based on the search query
    //         rows.forEach(function (row) {
    //             var productName = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
    //             var category = row.querySelector('td:nth-child(5)').textContent.toLowerCase();

    //             // Check if the query matches the product name or category
    //             if (productName.includes(query) || category.includes(query)) {
    //                 row.style.display = ''; // Show the row
    //                 hasMatch = true;
    //             } else {
    //                 row.style.display = 'none'; // Hide the row
    //             }
    //         });
    //         if (hasMatch) {
    //             noDataFoundMessage.style.display = 'none';
    //         } else {
    //             noDataFoundMessage.style.display = 'block';
    //         }
    //     });
    // });