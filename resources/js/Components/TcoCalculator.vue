<template>
  <section class="calculator" aria-labelledby="calculator-title">
    <header class="calculator-header">
      <img src="/img/logo/logohinopth.png" alt="HINO">
      <span aria-hidden="true"></span>
      <div>
        <strong id="calculator-title">Kalkulator TCO</strong>
        <small>Total Cost of Ownership</small>
      </div>
    </header>

    <ol class="step-indicator" aria-label="Tahapan kalkulator">
      <li v-for="item in 3" :key="item" :class="{ active: item === step, complete: item < step }">
        <span>{{ item < step ? '✓' : item }}</span>
        <small>{{ stepLabels[item - 1] }}</small>
      </li>
    </ol>

    <form v-if="!result" novalidate @submit.prevent="nextStep">
      <fieldset v-if="step === 1">
        <legend>Data operasional dasar</legend>
        <p class="step-description">Masukkan pola penggunaan kendaraan dalam satu tahun.</p>

        <div class="field-group">
          <label for="daily-km">Rata-rata jarak per hari</label>
          <div class="input-suffix">
            <input id="daily-km" v-model.number="form.dailyKm" type="number" min="1" max="1500" inputmode="numeric" placeholder="Contoh: 100" :aria-invalid="Boolean(errors.dailyKm)" :aria-describedby="errors.dailyKm ? 'daily-km-error' : undefined">
            <span>km</span>
          </div>
          <small v-if="errors.dailyKm" id="daily-km-error" class="field-error">{{ errors.dailyKm }}</small>
        </div>

        <div class="field-group">
          <label for="operating-days">Hari operasional per tahun</label>
          <div class="input-suffix">
            <input id="operating-days" v-model.number="form.operatingDays" type="number" min="1" max="366" inputmode="numeric" placeholder="Contoh: 300" :aria-invalid="Boolean(errors.operatingDays)" :aria-describedby="errors.operatingDays ? 'operating-days-error' : undefined">
            <span>hari</span>
          </div>
          <small v-if="errors.operatingDays" id="operating-days-error" class="field-error">{{ errors.operatingDays }}</small>
        </div>

        <div class="field-group">
          <label for="ownership-years">Periode kepemilikan</label>
          <select id="ownership-years" v-model.number="form.ownershipYears">
            <option v-for="year in 5" :key="year" :value="year">{{ year }} tahun</option>
          </select>
        </div>
      </fieldset>

      <fieldset v-else-if="step === 2">
        <legend>Pilih unit HINO</legend>
        <p class="step-description">Pilihan unit menentukan estimasi harga dan konsumsi bahan bakar.</p>

        <div class="field-group">
          <label for="truck-model">Model kendaraan</label>
          <select id="truck-model" v-model="form.modelKey" @change="applyModelPreset">
            <option v-for="model in models" :key="model.key" :value="model.key">{{ model.name }}</option>
          </select>
        </div>

        <div class="model-summary">
          <i class="fa-solid fa-truck" aria-hidden="true"></i>
          <div>
            <strong>{{ selectedModel.name }}</strong>
            <span>Estimasi harga unit {{ formatCurrency(selectedModel.price) }}</span>
          </div>
        </div>

        <div class="field-group">
          <label for="route-condition">Kondisi rute dominan</label>
          <select id="route-condition" v-model="form.routeFactor">
            <option :value="1.08">Jalan antarkota / relatif lancar</option>
            <option :value="1">Campuran kota dan antarkota</option>
            <option :value="0.88">Kota padat / sering berhenti</option>
            <option :value="0.78">Medan berat / proyek</option>
          </select>
        </div>

        <div class="field-group">
          <label for="fuel-efficiency">Estimasi konsumsi bahan bakar</label>
          <div class="input-suffix">
            <input id="fuel-efficiency" v-model.number="form.fuelEfficiency" type="number" min="1" max="20" step="0.1" inputmode="decimal" :aria-invalid="Boolean(errors.fuelEfficiency)" :aria-describedby="errors.fuelEfficiency ? 'fuel-efficiency-error' : 'fuel-efficiency-help'">
            <span>km/l</span>
          </div>
          <small id="fuel-efficiency-help" class="field-help">Dapat disesuaikan menurut pengalaman armada Anda.</small>
          <small v-if="errors.fuelEfficiency" id="fuel-efficiency-error" class="field-error">{{ errors.fuelEfficiency }}</small>
        </div>
      </fieldset>

      <fieldset v-else>
        <legend>Asumsi biaya</legend>
        <p class="step-description">Sesuaikan angka agar simulasi mendekati kondisi bisnis Anda.</p>

        <div class="cost-grid">
          <div class="field-group">
            <label for="unit-price">Harga unit</label>
            <div class="input-prefix">
              <span>Rp</span>
              <input id="unit-price" v-model.number="form.unitPrice" type="number" min="1" step="1000000" inputmode="numeric" :aria-invalid="Boolean(errors.unitPrice)">
            </div>
          </div>

          <div class="field-group">
            <label for="body-price">Karoseri / bak</label>
            <div class="input-prefix">
              <span>Rp</span>
              <input id="body-price" v-model.number="form.bodyPrice" type="number" min="0" step="1000000" inputmode="numeric" :aria-invalid="Boolean(errors.bodyPrice)">
            </div>
          </div>

          <div class="field-group">
            <label for="diesel-price">Harga solar per liter</label>
            <div class="input-prefix">
              <span>Rp</span>
              <input id="diesel-price" v-model.number="form.dieselPrice" type="number" min="1" step="100" inputmode="numeric" :aria-invalid="Boolean(errors.dieselPrice)">
            </div>
          </div>

          <div class="field-group">
            <label for="annual-service">Servis tahun pertama</label>
            <div class="input-prefix">
              <span>Rp</span>
              <input id="annual-service" v-model.number="form.annualService" type="number" min="0" step="100000" inputmode="numeric" :aria-invalid="Boolean(errors.annualService)">
            </div>
          </div>

          <div class="field-group">
            <label for="interest-rate">Bunga pembiayaan flat</label>
            <div class="input-suffix">
              <input id="interest-rate" v-model.number="form.interestRate" type="number" min="0" max="30" step="0.1" inputmode="decimal" :aria-invalid="Boolean(errors.interestRate)">
              <span>%/th</span>
            </div>
          </div>

          <div class="field-group">
            <label for="financing-years">Tenor pembiayaan</label>
            <select id="financing-years" v-model.number="form.financingYears">
              <option v-for="year in 5" :key="year" :value="year">{{ year }} tahun</option>
            </select>
          </div>
        </div>

        <p v-if="errors.costs" class="form-error" role="alert">{{ errors.costs }}</p>
      </fieldset>

      <div class="form-actions">
        <button v-if="step > 1" class="button-secondary" type="button" @click="previousStep">
          <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kembali
        </button>
        <button class="button-submit" type="submit">
          {{ step === 3 ? 'Hitung Estimasi' : 'Selanjutnya' }}
          <i class="fa-solid" :class="step === 3 ? 'fa-calculator' : 'fa-arrow-right'" aria-hidden="true"></i>
        </button>
      </div>
    </form>

    <div v-else class="result-panel" aria-live="polite">
      <div class="result-heading">
        <span><i class="fa-solid fa-chart-pie" aria-hidden="true"></i></span>
        <div>
          <small>Estimasi total biaya kepemilikan</small>
          <strong>{{ formatCurrency(result.totalTco) }}</strong>
          <p>{{ form.ownershipYears }} tahun · {{ formatNumber(result.totalKm) }} km</p>
        </div>
      </div>

      <dl class="result-summary">
        <div><dt>Biaya per kilometer</dt><dd>{{ formatCurrency(result.costPerKm) }}</dd></div>
        <div><dt>Rata-rata per bulan</dt><dd>{{ formatCurrency(result.costPerMonth) }}</dd></div>
      </dl>

      <dl class="cost-breakdown">
        <div><dt>Investasi unit + pembiayaan</dt><dd>{{ formatCurrency(result.acquisitionCost) }}</dd></div>
        <div><dt>Bahan bakar</dt><dd>{{ formatCurrency(result.fuelCost) }}</dd></div>
        <div><dt>Servis dan ban</dt><dd>{{ formatCurrency(result.maintenanceCost) }}</dd></div>
        <div class="deduction"><dt>Estimasi nilai jual kembali</dt><dd>− {{ formatCurrency(result.resaleValue) }}</dd></div>
      </dl>

      <p class="result-note">Simulasi ini merupakan estimasi perencanaan, bukan penawaran harga. Hasil aktual dipengaruhi spesifikasi unit, muatan, rute, harga bahan bakar, dan skema pembiayaan.</p>

      <div class="result-actions">
        <button class="button-secondary" type="button" @click="editCalculation">
          <i class="fa-solid fa-pen" aria-hidden="true"></i> Ubah Data
        </button>
        <a class="button-submit" :href="whatsAppUrl" target="_blank" rel="noopener noreferrer">
          <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Konsultasikan Hasil
        </a>
      </div>
    </div>

    <footer class="calculator-footer">
      <i class="fa-solid fa-lock" aria-hidden="true"></i>
      Data hanya diproses di perangkat ini dan tidak disimpan.
    </footer>
  </section>
</template>

<script>
const models = [
  { key: 'dutro-136-hdl', name: 'HINO 300 Dutro 136 HDL', price: 421000000, fuelEfficiency: 7.8 },
  { key: 'ranger-fg-260', name: 'HINO 500 Ranger FG 260', price: 875000000, fuelEfficiency: 5.4 },
  { key: 'ranger-fl-280', name: 'HINO 500 Ranger FL 280', price: 1125000000, fuelEfficiency: 4.7 },
  { key: 'profia-700', name: 'HINO 700 Profia', price: 1750000000, fuelEfficiency: 3.2 },
]

export default {
  data() {
    return {
      step: 1,
      stepLabels: ['Operasional', 'Unit', 'Biaya'],
      models,
      errors: {},
      result: null,
      form: {
        dailyKm: 100,
        operatingDays: 300,
        ownershipYears: 5,
        modelKey: models[0].key,
        routeFactor: 1,
        fuelEfficiency: models[0].fuelEfficiency,
        unitPrice: models[0].price,
        bodyPrice: 85000000,
        dieselPrice: 6800,
        annualService: 7271111,
        interestRate: 6.5,
        financingYears: 4,
      },
    }
  },

  computed: {
    selectedModel() {
      return this.models.find((model) => model.key === this.form.modelKey) ?? this.models[0]
    },

    whatsAppUrl() {
      if (!this.result) return '#'

      const message = [
        'Halo Armindo Perkasa, saya ingin konsultasi hasil estimasi TCO.',
        `Unit: ${this.selectedModel.name}`,
        `Periode: ${this.form.ownershipYears} tahun`,
        `Jarak: ${this.formatNumber(this.result.totalKm)} km`,
        `Estimasi TCO: ${this.formatCurrency(this.result.totalTco)}`,
      ].join('\n')

      return `https://wa.me/6281280061238?text=${encodeURIComponent(message)}`
    },
  },

  watch: {
    'form.routeFactor'() {
      this.form.fuelEfficiency = Number((this.selectedModel.fuelEfficiency * this.form.routeFactor).toFixed(1))
    },
  },

  methods: {
    applyModelPreset() {
      this.form.unitPrice = this.selectedModel.price
      this.form.fuelEfficiency = Number((this.selectedModel.fuelEfficiency * this.form.routeFactor).toFixed(1))
    },

    nextStep() {
      if (!this.validateStep()) return

      if (this.step < 3) {
        this.step += 1
        return
      }

      this.calculate()
    },

    previousStep() {
      this.errors = {}
      this.step -= 1
    },

    validateStep() {
      const errors = {}

      if (this.step === 1) {
        if (!this.isWithin(this.form.dailyKm, 1, 1500)) errors.dailyKm = 'Masukkan jarak antara 1 dan 1.500 km.'
        if (!this.isWithin(this.form.operatingDays, 1, 366)) errors.operatingDays = 'Masukkan jumlah hari antara 1 dan 366.'
      }

      if (this.step === 2 && !this.isWithin(this.form.fuelEfficiency, 1, 20)) {
        errors.fuelEfficiency = 'Masukkan konsumsi antara 1 dan 20 km per liter.'
      }

      if (this.step === 3) {
        const costsAreValid = [
          this.form.unitPrice > 0,
          this.form.bodyPrice >= 0,
          this.form.dieselPrice > 0,
          this.form.annualService >= 0,
          this.isWithin(this.form.interestRate, 0, 30),
        ].every(Boolean)

        if (!costsAreValid) errors.costs = 'Periksa kembali asumsi biaya. Nilai tidak boleh kosong atau negatif.'
      }

      this.errors = errors
      return Object.keys(errors).length === 0
    },

    calculate() {
      const totalKm = this.form.dailyKm * this.form.operatingDays * this.form.ownershipYears
      const financedValue = this.form.unitPrice + this.form.bodyPrice
      const financingYears = Math.min(this.form.financingYears, this.form.ownershipYears)
      const financingCost = financedValue * (this.form.interestRate / 100) * financingYears
      const acquisitionCost = financedValue + financingCost
      const fuelCost = (totalKm / this.form.fuelEfficiency) * this.form.dieselPrice
      const tireCost = (totalKm / 60000) * 7800000
      const serviceCost = Array.from(
        { length: this.form.ownershipYears },
        (_, year) => this.form.annualService * (1.15 ** year),
      ).reduce((total, cost) => total + cost, 0)
      const maintenanceCost = tireCost + serviceCost
      const resaleRate = Math.max(0.45, 0.85 - ((this.form.ownershipYears - 1) * 0.1))
      const resaleValue = financedValue * resaleRate
      const totalTco = acquisitionCost + fuelCost + maintenanceCost - resaleValue

      this.result = {
        totalKm: Math.round(totalKm),
        acquisitionCost: Math.round(acquisitionCost),
        fuelCost: Math.round(fuelCost),
        maintenanceCost: Math.round(maintenanceCost),
        resaleValue: Math.round(resaleValue),
        totalTco: Math.round(totalTco),
        costPerKm: Math.round(totalTco / totalKm),
        costPerMonth: Math.round(totalTco / (this.form.ownershipYears * 12)),
      }
    },

    editCalculation() {
      this.result = null
      this.step = 1
      this.errors = {}
    },

    isWithin(value, minimum, maximum) {
      return Number.isFinite(Number(value)) && Number(value) >= minimum && Number(value) <= maximum
    },

    formatCurrency(value) {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
      }).format(value)
    },

    formatNumber(value) {
      return new Intl.NumberFormat('id-ID').format(value)
    },
  },
}
</script>

<style scoped>
.calculator {
  overflow: hidden;
  border: 1px solid #c9d9d0;
  border-radius: 28px;
  color: #17201b;
  background: #fff;
  box-shadow: 0 28px 70px rgba(20, 65, 42, 0.13);
}

.calculator-header {
  display: flex;
  align-items: center;
  gap: 18px;
  padding: 27px 32px 22px;
  border-bottom: 1px solid #d9e3dd;
  background: #f8fbf9;
}

.calculator-header img {
  width: 132px;
  height: 38px;
  object-fit: contain;
}

.calculator-header > span {
  width: 1px;
  height: 38px;
  background: #c9d2cd;
}

.calculator-header strong,
.calculator-header small {
  display: block;
}

.calculator-header strong {
  color: #086b3b;
  font-size: 22px;
}

.calculator-header small {
  margin-top: 2px;
  color: #6b756f;
  font-size: 12px;
}

.step-indicator {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  margin: 0;
  padding: 25px 32px 21px;
  list-style: none;
}

.step-indicator li {
  position: relative;
  color: #8c9791;
  text-align: center;
}

.step-indicator li:not(:last-child)::after {
  position: absolute;
  top: 15px;
  left: calc(50% + 18px);
  width: calc(100% - 36px);
  height: 2px;
  content: '';
  background: #dbe3de;
}

.step-indicator li.complete:not(:last-child)::after {
  background: #159258;
}

.step-indicator span {
  position: relative;
  z-index: 1;
  display: grid;
  width: 32px;
  height: 32px;
  margin: 0 auto 8px;
  place-items: center;
  border: 1px solid #cdd8d2;
  border-radius: 50%;
  background: #fff;
  font-size: 13px;
  font-weight: 700;
}

.step-indicator li.active,
.step-indicator li.complete {
  color: #0b6a3d;
}

.step-indicator li.active span,
.step-indicator li.complete span {
  border-color: #159258;
  color: #fff;
  background: #159258;
}

.step-indicator small {
  font-size: 11px;
  font-weight: 600;
}

form,
.result-panel {
  padding: 4px 32px 30px;
}

fieldset {
  min-width: 0;
  margin: 0;
  padding: 0;
  border: 0;
}

legend {
  padding: 0;
  font-size: 21px;
  font-weight: 700;
}

.step-description {
  margin: 7px 0 24px;
  color: #657069;
  font-size: 13px;
  line-height: 1.5;
}

.field-group {
  margin-bottom: 19px;
}

.field-group label {
  display: block;
  margin-bottom: 7px;
  color: #29332d;
  font-size: 13px;
  font-weight: 650;
}

input,
select {
  width: 100%;
  height: 48px;
  padding: 0 14px;
  border: 1px solid #cdd7d1;
  border-radius: 10px;
  color: #19221d;
  background: #fff;
  outline: none;
}

input:focus,
select:focus {
  border-color: #058c4b;
  box-shadow: 0 0 0 3px rgba(5, 140, 75, 0.14);
}

input[aria-invalid='true'] {
  border-color: #b3261e;
}

.input-suffix,
.input-prefix {
  position: relative;
}

.input-suffix input {
  padding-right: 62px;
}

.input-prefix input {
  padding-left: 50px;
}

.input-suffix span,
.input-prefix span {
  position: absolute;
  top: 50%;
  color: #66716b;
  font-size: 12px;
  font-weight: 600;
  transform: translateY(-50%);
}

.input-suffix span {
  right: 15px;
}

.input-prefix span {
  left: 15px;
}

.field-help,
.field-error {
  display: block;
  margin-top: 6px;
  font-size: 11px;
}

.field-help {
  color: #748078;
}

.field-error,
.form-error {
  color: #9f211b;
}

.model-summary {
  display: flex;
  align-items: center;
  gap: 15px;
  margin: -2px 0 20px;
  padding: 15px;
  border: 1px solid #cfe1d6;
  border-radius: 12px;
  background: #f1f8f4;
}

.model-summary > i {
  display: grid;
  width: 44px;
  height: 44px;
  flex: 0 0 44px;
  place-items: center;
  border-radius: 50%;
  color: #fff;
  background: #0b7543;
}

.model-summary strong,
.model-summary span {
  display: block;
}

.model-summary strong {
  margin-bottom: 3px;
  font-size: 14px;
}

.model-summary span {
  color: #5d6962;
  font-size: 12px;
}

.cost-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 0 15px;
}

.form-error {
  margin: -4px 0 18px;
  padding: 10px 12px;
  border-radius: 8px;
  background: #fff0ef;
  font-size: 12px;
}

.form-actions,
.result-actions {
  display: flex;
  gap: 12px;
  margin-top: 24px;
}

.button-submit,
.button-secondary {
  display: inline-flex;
  min-height: 50px;
  flex: 1;
  align-items: center;
  justify-content: center;
  gap: 9px;
  padding: 12px 20px;
  border: 1px solid transparent;
  border-radius: 999px;
  cursor: pointer;
  font-size: 13px;
  font-weight: 750;
  text-decoration: none;
  transition: background-color 160ms ease, transform 160ms ease;
}

.button-submit {
  color: #fff;
  background: #078647;
}

.button-submit:hover {
  background: #075e37;
  transform: translateY(-1px);
}

.button-secondary {
  border-color: #9db5a7;
  color: #155c38;
  background: #fff;
}

.button-secondary:hover {
  background: #eff7f2;
}

.button-submit:focus-visible,
.button-secondary:focus-visible {
  outline: 3px solid #f6bf26;
  outline-offset: 3px;
}

.result-heading {
  display: flex;
  align-items: flex-start;
  gap: 16px;
  padding: 18px;
  border-radius: 16px;
  color: #fff;
  background: #075e37;
}

.result-heading > span {
  display: grid;
  width: 42px;
  height: 42px;
  flex: 0 0 42px;
  place-items: center;
  border-radius: 50%;
  color: #075e37;
  background: #fff;
}

.result-heading small,
.result-heading strong,
.result-heading p {
  display: block;
  margin: 0;
}

.result-heading small {
  margin-bottom: 5px;
  opacity: 0.82;
}

.result-heading strong {
  font-size: clamp(22px, 3vw, 30px);
  line-height: 1.2;
}

.result-heading p {
  margin-top: 5px;
  font-size: 12px;
  opacity: 0.82;
}

.result-summary {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  margin: 15px 0;
}

.result-summary div {
  padding: 13px;
  border: 1px solid #d5e2da;
  border-radius: 11px;
  background: #f7faf8;
}

.result-summary dt,
.cost-breakdown dt {
  color: #657069;
  font-size: 11px;
}

.result-summary dd,
.cost-breakdown dd {
  margin: 4px 0 0;
  font-weight: 700;
}

.result-summary dd {
  color: #086b3b;
  font-size: 16px;
}

.cost-breakdown {
  margin: 0;
  padding: 4px 0;
  border-top: 1px solid #e1e8e4;
  border-bottom: 1px solid #e1e8e4;
}

.cost-breakdown div {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 18px;
  padding: 9px 0;
}

.cost-breakdown dd {
  font-size: 12px;
  text-align: right;
}

.cost-breakdown .deduction dd {
  color: #087342;
}

.result-note {
  margin: 15px 0 0;
  color: #68736c;
  font-size: 11px;
  line-height: 1.5;
}

.calculator-footer {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 13px 20px;
  border-top: 1px solid #dfe7e2;
  color: #68736c;
  background: #f8faf9;
  font-size: 11px;
  text-align: center;
}

.calculator-footer i {
  color: #168454;
}

@media (max-width: 560px) {
  .calculator {
    border-radius: 20px;
  }

  .calculator-header {
    padding: 22px 20px 18px;
  }

  .calculator-header img {
    width: 110px;
  }

  .calculator-header strong {
    font-size: 18px;
  }

  .step-indicator {
    padding-inline: 20px;
  }

  form,
  .result-panel {
    padding-right: 20px;
    padding-left: 20px;
  }

  .cost-grid,
  .result-summary {
    grid-template-columns: 1fr;
  }

  .form-actions,
  .result-actions {
    flex-direction: column-reverse;
  }
}
</style>
