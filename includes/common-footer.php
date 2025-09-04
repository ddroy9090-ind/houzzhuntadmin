</div>
<!-- END layout-wrapper -->
<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>



<!-- JAVASCRIPT -->
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="assets/js/plugins.js"></script>

<!-- apexcharts -->
<script src="assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Vector map-->
<script src="assets/libs/jsvectormap/jsvectormap.min.js"></script>
<script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

<?php if (isset($projectMarkers)): ?>
    <script>
        (function () {
            var projectData = <?php echo json_encode($projectMarkers); ?>;
            var locationCoords = {
                "Dubai": [25.276987, 55.296249],
                "Abu Dhabi": [24.4539, 54.3773],
                "Sharjah": [25.3463, 55.4209],
                "Gurgaon": [28.4595, 77.0266],
                "Delhi": [28.7041, 77.1025]
            };
            window.projectMarkers = projectData
                .map(function (p) {
                    var coords = locationCoords[p.location];
                    if (!coords) return null;
                    return { name: p.project_name, coords: coords };
                })
                .filter(Boolean);
        })();
    </script>
<?php endif; ?>

<!--Swiper slider js-->
<script src="assets/libs/swiper/swiper-bundle.min.js"></script>

<!-- Dashboard init -->
<script src="assets/js/pages/dashboard-ecommerce.init.js"></script>

<!-- App js -->
<script src="assets/js/app.js"></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>







<script>
    function togglePassword(fieldId, btn) {
        let field = document.getElementById(fieldId);
        if (field.type === "password") {
            field.type = "text";
            btn.innerText = "🙈"; // change icon when visible
        } else {
            field.type = "password";
            btn.innerText = "👁"; // back to eye when hidden
        }
    }
</script>



<script>
    var swiper1 = new Swiper(".mySwiper1", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        loop: true,
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Delete User
        let deleteId = null;
        document.querySelectorAll(".remove-item-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                deleteId = this.getAttribute("data-id");
            });
        });

        document.getElementById("delete-record").addEventListener("click", function () {
            if (deleteId) {
                fetch("delete_user.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: "id=" + deleteId
                })
                    .then(res => res.text())
                    .then(data => {
                        if (data === "success") {
                            location.reload();
                        } else {
                            alert("Error deleting user");
                        }
                    });
            }
        });

        // Edit User (Load data into modal)
        document.querySelectorAll(".edit-item-btn").forEach(btn => {
            btn.addEventListener("click", function () {
                let row = this.closest("tr");
                document.getElementById("name-field").value = row.querySelector(".name").innerText;
                document.getElementById("username-field").value = row.querySelector(".username").innerText;
                document.getElementById("email-field").value = row.querySelector(".email").innerText;
                document.getElementById("role-field").value = row.querySelector(".role span").innerText;

                // Store user id in hidden field
                let hiddenId = document.createElement("input");
                hiddenId.type = "hidden";
                hiddenId.name = "id";
                hiddenId.value = this.getAttribute("data-id");
                document.querySelector(".tablelist-form").appendChild(hiddenId);

                // Change form action to edit
                document.querySelector(".tablelist-form").action = "edit_user.php";
            });
        });
    });
</script>

<?php if (basename($_SERVER['PHP_SELF']) === 'index.php'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var chartEl = document.querySelector("#customer_impression_charts");
            if (chartEl) {
                chartEl.innerHTML = "";
                var options = {
                    chart: { type: 'bar', height: 350 },
                    series: [{
                        name: 'Count',
                        data: [<?php echo $totalProperties; ?>, <?php echo $totalLeads; ?>, <?php echo $totalUsers; ?>, <?php echo $todayLeads; ?>]
                    }],
                    xaxis: { categories: ['Total Properties', 'Total Leads', 'Channel Partners', 'Leads Today'] },
                    colors: ['#0ab39c', '#299cdb', '#f7b84b', '#5b73e8'],
                    plotOptions: { bar: { columnWidth: '45%', distributed: true } }
                };
                var chart = new ApexCharts(chartEl, options);
                chart.render();
            }
        });
    </script>
<?php endif; ?>





<script>
    function showFileName(input) {
        const fileName = input.files[0] ? input.files[0].name : '';
        document.getElementById('file-name-' + input.id).textContent = fileName;
    }

    function handleDragOver(event) {
        event.preventDefault();
        event.currentTarget.classList.add('dragover');
    }

    function handleDragLeave(event) {
        event.currentTarget.classList.remove('dragover');
    }

    function handleDrop(event, inputId) {
        event.preventDefault();
        event.currentTarget.classList.remove('dragover');
        const files = event.dataTransfer.files;
        if (files.length) {
            document.getElementById(inputId).files = files;
            showFileName(document.getElementById(inputId));
        }
    }
</script>

<script>
    (function () {
        const selectedCurrency = '<?php echo $_SESSION['currency'] ?? 'AED'; ?>';
        const baseCurrency = 'AED';
        const currencySymbols = { AED: 'AED', USD: '$', EUR: '€', GBP: '£' };

        function applyConversion(rate) {
            document.querySelectorAll('[data-base-amount]').forEach(el => {
                const base = parseFloat(el.getAttribute('data-base-amount'));
                if (isNaN(base)) return;
                const converted = base * rate;
                el.textContent = converted.toLocaleString(undefined, { maximumFractionDigits: 2 });
            });
            document.querySelectorAll('.currency-symbol').forEach(el => {
                el.textContent = currencySymbols[selectedCurrency] || selectedCurrency;
            });
        }

        // Always show the currency symbol even if the exchange-rate fetch fails.
        applyConversion(1);

        if (selectedCurrency !== baseCurrency) {
            fetch(`https://api.exchangerate.host/latest?base=${baseCurrency}`)
                .then(res => res.json())
                .then(data => {
                    const rate = data.rates[selectedCurrency] || 1;
                    applyConversion(rate);
                })
                .catch(() => {
                    // If the API request fails, we keep the base amount but the symbol remains visible.
                });
        }
    })();
</script>


<script>
    // Main Large Image Swiper
    new Swiper(".main-swiper", {
        loop: true,
        navigation: {
            nextEl: ".main-swiper .swiper-button-next",
            prevEl: ".main-swiper .swiper-button-prev",
        },
    });

    // Side Image Swipers
    document.querySelectorAll(".side-swiper").forEach(function (el) {
        new Swiper(el, {
            loop: true,
            navigation: {
                nextEl: el.querySelector(".swiper-button-next"),
                prevEl: el.querySelector(".swiper-button-prev"),
            },
        });
    });
</script>

<script>
    var slider = document.getElementById('price-slider');
    noUiSlider.create(slider, {
        start: [<?= $selectedMin ?>, <?= $selectedMax ?>],
        connect: true,
        range: {
            'min': <?= $minPriceBound ?>,
            'max': <?= $maxPriceBound ?>
        },
        step: 1000, // smoother step size
        tooltips: false,
    });

</script>



</body>

</html>