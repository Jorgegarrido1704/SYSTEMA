
                                    // Function to update data
                                    function updateData() {
                                        $.ajax({
                                            url: '{{ route("fetchdata") }}', // Use Laravel route helper
                                            method: 'GET', // Adjust the method if your route expects GET
                                            dataType: 'json', // Expect JSON response
                                            success: function(response) {
                                                // Update table body content with new data
                                                $('#table-body').html(response.tableContent);
                                            },
                                            error: function(xhr, status, error) {
                                                console.error(error);
                                            }
                                        });
                                    }

                                    // Call the function initially
                                    updateData();

                                    // Call the function every 5 seconds (adjust the interval as needed)
                                    setInterval(updateData, 5000); // 5000 milliseconds = 5 seconds

