<?php include 'includes/auth.php'; ?>
<?php include 'includes/common-header.php'; ?>
<div class="main-content">
    <div class="page-content">

        <div class="container-fluid">
             <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div
                        class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Mortgage Calculator</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Mortgage Calculator</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row g-5">
                <!-- Left Panel -->
                <div class="col-lg-6">
                    <div class="p-4 rounded-4 shadow-sm bg-white border border-dark-subtle">
                        <h4 class=" mb-4" style="color:#014d47;">Houzzhunt Mortgage Calculator</h4>

                        <!-- Residency Status -->
                        <div class="mb-3">
                            <label class="form-label">Residency Status</label>
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-outline-dark w-50 active" data-type="resident">UAE
                                    Resident</button>
                                <button type="button" class="btn btn-outline-dark w-50 "
                                    data-type="nonresident">International
                                    Investor</button>
                            </div>
                        </div>

                        <!-- Income Type -->
                        <div class="mb-3">
                            <label class="form-label">Income Type</label>
                            <div class="btn-group w-100">
                                <button type="button" class="btn btn-outline-dark w-50 active">Salaried</button>
                                <button type="button" class="btn btn-outline-dark w-50">Self-Employed</button>
                            </div>
                        </div>

                        <!-- Property Value -->
                        <div class="mb-3">
                            <label class="form-label">Property Price (<span class="currency-code"></span>)</label>
                            <input type="number" id="propertyValue" class="form-control" value="1000000" data-base-value="1000000">
                        </div>

                        <!-- Down Payment -->
                        <div class="mb-3">
                            <label class="form-label">Down Payment (<span class="currency-code"></span>)</label>
                            <input type="number" id="downPayment" class="form-control" value="200000" data-base-value="200000">
                        </div>

                        <!-- Interest Rate -->
                        <div class="mb-3">
                            <label class="form-label">Interest Rate (%)</label>
                            <input type="number" id="interestRate" class="form-control" value="3.99" step="0.01" min="2"
                                max="8">
                        </div>

                        <!-- Loan Duration -->
                        <div class="mb-3">
                            <label class="form-label">Loan Term (Years)</label>
                            <input type="range" class="form-range" id="loanDuration" min="1" max="25" value="20">
                            <p class="text-end"><span id="durationLabel">20</span> Years</p>
                        </div>

                        <!-- Notices -->
                        <div class="mt-4 p-3 highlight-box">
                            <small class="text-dark">
                                <ul class="mb-0 ps-3">
                                    <li>Minimum down payment for UAE residents: 20%</li>
                                    <li>Minimum down payment for international investors: 40%</li>
                                    <li>Maximum loan term: 25 years</li>
                                </ul>
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="col-lg-6">
                    <!-- Loan Summary -->
                    <div class="p-4 rounded-4 shadow-sm" style="background-color: #014d47; color: white;">
                        <h5 class=" mb-4 text-white">Loan Summary</h5>
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="mb-1 text-white">Maximum Loan Amount</p>
                                <h4 id="loanAmount" class="text-white">AED 800,000</h4>
                            </div>
                            <div>
                                <p class="mb-1 text-white">Monthly Payment</p>
                                <h4 id="monthlyCost" class="text-white">AED 4,844</h4>
                            </div>
                            <div>
                                <p class="mb-1 text-white">Total Interest Paid</p>
                                <h4 id="interestPaid" class="text-white">AED 362,471</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Upfront Costs -->
                    <div class="mt-4 p-4 rounded-4 shadow-sm bg-white">
                        <h6 class=" mb-3">Upfront Costs</h6>
                        <div class="row">
                            <div class="col-6">
                                <p>Down Payment</p>
                                <p>Dubai Land Department Fee (4%)</p>
                                <p>Valuation Fee</p>
                                <p>Registration Fee</p>
                            </div>
                            <div class="col-6 text-end">
                                <p id="upfrontDown">AED 200,000</p>
                                <p id="upfrontDLD">AED 40,000</p>
                                <p id="valuationFee">AED 3,000</p>
                                <p id="registrationFee">AED 4,000</p>
                            </div>
                            <div class="col-6">
                                <p>Mortgage Registration (0.25%)</p>
                                <p>Real Estate Agency Fee (2%)</p>
                            </div>
                            <div class="col-6 text-end">
                                <p id="upfrontMR">AED 2,000</p>
                                <p id="upfrontAgency">AED 20,000</p>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between ">
                            <span>Total Upfront Cost</span>
                            <span id="totalUpfront">AED 269,000</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SCRIPT -->
        <script>
            // Refined algorithm with stable validation and tolerance rounding
            let residencyType = 'resident';
            let selectedRate = 3.99;

            const propertyValueInput = document.getElementById('propertyValue');
            const downPaymentInput = document.getElementById('downPayment');
            const loanDurationInput = document.getElementById('loanDuration');
            const interestInput = document.getElementById('interestRate');
            const durationLabel = document.getElementById('durationLabel');

            const selectedCurrency = '<?php echo $_SESSION['currency'] ?? 'AED'; ?>';
            const currencySymbols = { AED: 'AED', USD: '$', EUR: '€', GBP: '£' };
            const baseCurrency = 'AED';
            let conversionRate = 1;
            const valuationFeeBase = 3000;
            const registrationFeeBase = 4000;

            document.querySelectorAll('.currency-code').forEach(el => el.textContent = selectedCurrency);

            if (selectedCurrency !== baseCurrency) {
                fetch(`https://api.exchangerate.host/latest?base=${baseCurrency}`)
                    .then(res => res.json())
                    .then(data => {
                        conversionRate = data.rates[selectedCurrency] || 1;
                        propertyValueInput.value = (parseFloat(propertyValueInput.dataset.baseValue) * conversionRate).toFixed(2);
                        downPaymentInput.value = (parseFloat(downPaymentInput.dataset.baseValue) * conversionRate).toFixed(2);
                        calculate();
                    });
            } else {
                propertyValueInput.value = propertyValueInput.dataset.baseValue;
                downPaymentInput.value = downPaymentInput.dataset.baseValue;
            }

            function formatCurrency(amount) {
                const symbol = currencySymbols[selectedCurrency] || selectedCurrency;
                return `${symbol} ${Math.round(amount).toLocaleString()}`;
            }

            const rateOptions = [{
                label: '3 years fixed-rate',
                rate: 3.99
            },
            {
                label: '5 years fixed-rate',
                rate: 3.98
            },
            {
                label: 'Variable rate',
                rate: 5.51
            }
            ];

            const rateContainer = document.createElement('div');
            rateContainer.className = 'mt-4';
            rateContainer.innerHTML = '<label class="form-label">Select Rate Option</label>';

            const rateGroup = document.createElement('div');
            rateGroup.className = 'btn-group w-100';
            rateGroup.setAttribute('role', 'group');

            rateOptions.forEach((opt, i) => {
                const btn = document.createElement('button');
                btn.className = `btn btn-outline-dark${i === 0 ? ' active' : ''}`;
                btn.textContent = `${opt.label} (${opt.rate.toFixed(2)}%)`;
                btn.dataset.rate = opt.rate;
                btn.setAttribute('data-rate', opt.rate);
                btn.addEventListener('click', function () {
                    document.querySelectorAll('[data-rate]').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    selectedRate = parseFloat(this.dataset.rate);
                    interestInput.value = selectedRate;
                    calculate();
                });
                rateGroup.appendChild(btn);
            });

            rateContainer.appendChild(rateGroup);
            document.querySelector('.mb-3:nth-child(6)').after(rateContainer);

            const residencyButtons = document.querySelectorAll('[data-type]');
            residencyButtons.forEach(btn => {
                btn.addEventListener('click', function () {
                    residencyButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    residencyType = this.getAttribute('data-type');
                    calculate();
                });
            });

            [propertyValueInput, downPaymentInput, loanDurationInput, interestInput].forEach(el => el.addEventListener('input', calculate));

            function calculate() {
                const propertyValue = parseFloat(propertyValueInput.value) || 0;
                const downPayment = parseFloat(downPaymentInput.value) || 0;
                const duration = parseInt(loanDurationInput.value) || 0;
                const rate = parseFloat(interestInput.value) || 0;
                durationLabel.innerText = duration > 0 ? duration : '-';

                if (propertyValue <= 0 || downPayment <= 0 || duration <= 0 || rate <= 0) {
                    return displayInvalid('Enter valid numeric inputs');
                }

                let minDP = residencyType === 'nonresident' ? 0.4 : 0.2;
                const requiredDP = propertyValue * minDP;
                if (downPayment + 1 < requiredDP) {
                    return displayInvalid('Minimum Down Payment not met');
                }

                const loanAmount = propertyValue - downPayment;
                const monthlyRate = rate / 100 / 12;
                const months = duration * 12;

                if (loanAmount <= 0 || monthlyRate <= 0 || months <= 0) {
                    return displayInvalid('Invalid Loan Structure');
                }

                const monthlyPayment = (loanAmount * monthlyRate) / (1 - Math.pow(1 + monthlyRate, -months));
                const totalInterest = (monthlyPayment * months) - loanAmount;

                document.getElementById('loanAmount').innerText = formatCurrency(loanAmount);
                document.getElementById('monthlyCost').innerText = formatCurrency(monthlyPayment);
                document.getElementById('interestPaid').innerText = formatCurrency(totalInterest);

                const dldFee = propertyValue * 0.04;
                const mrFee = propertyValue * 0.0025;
                const agencyFee = propertyValue * 0.02;
                const valuationFee = valuationFeeBase * conversionRate;
                const registrationFee = registrationFeeBase * conversionRate;
                const totalUpfront = downPayment + dldFee + valuationFee + registrationFee + mrFee + agencyFee;

                document.getElementById('upfrontDown').innerText = formatCurrency(downPayment);
                document.getElementById('upfrontDLD').innerText = formatCurrency(dldFee);
                document.getElementById('valuationFee').innerText = formatCurrency(valuationFee);
                document.getElementById('registrationFee').innerText = formatCurrency(registrationFee);
                document.getElementById('upfrontMR').innerText = formatCurrency(mrFee);
                document.getElementById('upfrontAgency').innerText = formatCurrency(agencyFee);
                document.getElementById('totalUpfront').innerText = formatCurrency(totalUpfront);
            }

            function displayInvalid(message = 'Invalid Input') {
                document.getElementById('loanAmount').innerText = message;
                document.getElementById('monthlyCost').innerText = '-';
                document.getElementById('interestPaid').innerText = '-';
                document.getElementById('upfrontDown').innerText = '-';
                document.getElementById('upfrontDLD').innerText = '-';
                document.getElementById('upfrontMR').innerText = '-';
                document.getElementById('upfrontAgency').innerText = '-';
                document.getElementById('totalUpfront').innerText = '-';
            }

            calculate();
        </script>


        <style>
            body {
                background: #f5f5f5;
                font-family: 'Poppins', sans-serif;
            }

            .btn {
                border-radius: 5px !important;
            }

            .btn.active {
                background-color: #014d47;
                color: white;
                border-color: #014d47;
            }

            .btn-outline-dark {
                border-radius: 8px;
            }

            .form-control,
            .form-range {
                border-color: #ccc;
            }

            .highlight-box {
                background-color: #fff3cd;
                border-left: 5px solid #edbb68;
            }

            .btn-group {
                display: -webkit-inline-box;
                display: -webkit-inline-flex;
                display: -ms-inline-flexbox;
                display: inline-flex;
                flex-wrap: nowrap;
                -webkit-box-align: center;
                -webkit-align-items: center;
                -ms-flex-align: center;
                align-items: center;
                gap: 30px;
                margin-bottom: 10px;
            }
        </style>

    </div>
    <?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/common-footer.php'; ?>