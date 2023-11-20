<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Meja</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>

    <h2>Formulir Pemesanan Meja</h2>

    <form id="bookingForm">
        <label for="bookingDate">Tanggal Pemesanan:</label>
        <input type="date" id="bookingDate" name="bookingDate" required>

        <br>

        <label>Jam Mulai:</label>
        <button type="button" data-start-time="14:00" data-end-time="15:00" onclick="toggleTimeRange(this)"
            data-date="">14:00-15:00</button>
        <button type="button" data-start-time="15:00" data-end-time="16:00" onclick="toggleTimeRange(this)"
            data-date="">15:00-16:00</button>
        <button type="button" data-start-time="16:00" data-end-time="17:00" onclick="toggleTimeRange(this)"
            data-date="">16:00-17:00</button>
        <button type="button" data-start-time="17:00" data-end-time="18:00" onclick="toggleTimeRange(this)"
            data-date="">17:00-18:00</button>
        <button type="button" data-start-time="19:00" data-end-time="20:00" onclick="toggleTimeRange(this)"
            data-date="">19:00-20:00</button>
        <br>

        <input type="hidden" id="jmulai" name="jmulai" value="">
        <input type="hidden" id="jhabis" name="jhabis" value="">

        <br>

        <button type="submit">Pesan Meja</button>
    </form>

    <script>
        var selectedTimeRanges = [];

        function toggleTimeRange(clickedButton) {
            var selectedDate = document.getElementById('bookingDate').value;
            var startTime = clickedButton.getAttribute('data-start-time');
            var endTime = clickedButton.getAttribute('data-end-time');
            clickedButton.setAttribute('data-date', selectedDate);

            if (!selectedDate) {
                alert('Pilih tanggal terlebih dahulu.');
                return;
            }

            var today = new Date().toISOString().split('T')[0];
            var isToday = selectedDate === today;

            if (!isToday && isTimeRangeBooked(selectedDate, startTime)) {
                alert('Jam ini sudah dipesan. Pilih jam lain.');
                return;
            }

            // Check if the time range is already selected
            var existingRangeIndex = findTimeRangeIndex(startTime, endTime);

            if (existingRangeIndex !== -1) {
                // Unselect the time range if already selected
                selectedTimeRanges.splice(existingRangeIndex, 1);
            } else {
                // Add the time range to the selection
                selectedTimeRanges.push({ startTime: startTime, endTime: endTime });
            }

            // Update the hidden input fields
            updateHiddenFields();

            // Optional: Display the selected time ranges to the user
            var selectedRangesText = selectedTimeRanges.map(range => range.startTime + '-' + range.endTime).join(', ');
            alert('Waktu Pemesanan: ' + selectedRangesText);

            // Check all times
            checkAllTimes();
        }

        function findTimeRangeIndex(startTime, endTime) {
            // Check if the time range is already selected
            for (var i = 0; i < selectedTimeRanges.length; i++) {
                if (selectedTimeRanges[i].startTime === startTime && selectedTimeRanges[i].endTime === endTime) {
                    return i;
                }
            }
            return -1;
        }

        function updateHiddenFields() {
            // Sort the selected time ranges by start time
            selectedTimeRanges.sort((a, b) => (a.startTime > b.startTime) ? 1 : -1);

            // Set the start time and end time based on the selected ranges
            if (selectedTimeRanges.length > 0) {
                document.getElementById('jmulai').value = selectedTimeRanges[0].startTime;
                document.getElementById('jhabis').value = selectedTimeRanges[selectedTimeRanges.length - 1].endTime;
            } else {
                // No selected ranges, clear the hidden fields
                document.getElementById('jmulai').value = '';
                document.getElementById('jhabis').value = '';
            }
        }

        function submitBookingForm() {
            var bookingDate = document.getElementById('bookingDate').value;
            var startTime = document.getElementById('jmulai').value;
            var endTime = document.getElementById('jhabis').value;

            $.ajax({
                url: 'backend.php?action=saveBooking',
                method: 'POST',
                data: {
                    bookingDate: bookingDate,
                    startTime: startTime,
                    endTime: endTime
                },
                success: function (data) {
                    if (data.success) {
                        alert('Pemesanan berhasil disimpan ke database.');
                    } else {
                        alert('Gagal menyimpan pemesanan. Error: ' + data.error);
                    }
                },
                error: function (error) {
                    console.error('Error saat menyimpan pemesanan:', error);
                }
            });
        }

        document.getElementById('bookingForm').addEventListener('submit', function (event) {
            event.preventDefault();
            submitBookingForm();
        });

        var bookedDatesMap = {};

        function updateButtonsForDate() {
            var selectedDate = document.getElementById('bookingDate').value;
            var buttons = document.querySelectorAll('button[data-start-time]');
            buttons.forEach(function (button) {
                button.disabled = false; // enable all buttons
                button.setAttribute('data-date', selectedDate);
            });
            checkAllTimes();
        }

        function checkAllTimes() {
            var selectedDate = document.getElementById('bookingDate').value;

            var buttons = document.querySelectorAll('button[data-start-time]');
            buttons.forEach(function (button) {
                var startTime = button.getAttribute('data-start-time');

                // Check if the time range is booked
                if (isTimeRangeBooked(selectedDate, startTime)) {
                    button.disabled = true;
                } else {
                    button.disabled = false;
                }
            });
        }

        function isTimeRangeBooked(selectedDate, startTime) {
            var bookedTimeRange = bookedDatesMap[selectedDate] || [];

            // Check if the start time is within the booked time range
            for (var i = 0; i < bookedTimeRange.length; i++) {
                var bookedStartTime = bookedTimeRange[i].start_time;
                var bookedEndTime = bookedTimeRange[i].end_time;

                if (
                    (startTime >= bookedStartTime && startTime < bookedEndTime)
                ) {
                    return true; // There is an overlap, time range is booked
                }
            }

            return false; // No overlap, time range is available
        }

        function getBookedDates(callback) {
            $.ajax({
                url: 'backend.php?action=getBookedDates',
                method: 'GET',
                success: function (data) {
                    console.log('Data tanggal yang sudah dipesan:', data.dates);
                    bookedDatesMap = {};
                    data.dates.forEach(function (date) {
                        bookedDatesMap[date.date] = bookedDatesMap[date.date] || [];
                        bookedDatesMap[date.date].push({
                            start_time: date.start_time,
                            end_time: date.end_time
                        });
                    });
                    updateButtonsForDate();
                },
                error: function (error) {
                    console.error('Error saat mengambil tanggal yang sudah dipesan:', error);
                }
            });
        }

        document.getElementById('bookingDate').addEventListener('change', function () {
            updateButtonsForDate();
        });

        getBookedDates(function (bookedDates) {
            // bookedDatesMap = {}; // Remove this line
            // bookedDates.forEach(function (date) {
            //     bookedDatesMap[date.date] = bookedDatesMap[date.date] || [];
            //     bookedDatesMap[date.date].push({
            //         start_time: date.start_time,
            //         end_time: date.end_time
            //     });
            // });
            // updateButtonsForDate(); // Remove this line
        });
    // </script>

</body>

</html>
