document.addEventListener('DOMContentLoaded', function() {
    setTanggal();
});

function setTanggal() {
    var today = new Date();
    var monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    var day = today.getDate();
    var monthIndex = today.getMonth();
    var year = today.getFullYear();

    // Memasukkan hasil ke dalam elemen dengan ID "tanggalDiv"
    document.getElementById("tanggalDiv").innerHTML = `Bogor, ${day} ${monthNames[monthIndex]} ${year}`;
}

// new DataTable('#example');