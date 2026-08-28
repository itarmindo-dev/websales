<template>
  <section class="calculator" aria-labelledby="calculator-title">
    <header class="calculator-header">
      <img src="/img/logo/logohinopth.png" alt="HINO">
      <span aria-hidden="true"></span>
      <div>
        <strong id="calculator-title">Kalkulator TCO</strong>
        <small>Total Cost of Ownership</small>
        <small v-if="salesName" class="calculator-sales-source">Referensi sales: {{ salesName }}</small>
      </div>
    </header>

    <ol v-if="!result" class="step-indicator" aria-label="Tahapan kalkulator">
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
          <label for="daily-km">AVG KM harian</label>
          <div class="input-suffix">
            <input
              id="daily-km"
              v-model.number="form.dailyKm"
              type="number"
              min="1"
              inputmode="numeric"
              placeholder="Contoh: 100"
              :aria-invalid="Boolean(errors.dailyKm)"
            >
            <span>km</span>
          </div>
          <small v-if="errors.dailyKm" class="field-error">{{ errors.dailyKm }}</small>
        </div>

        <div class="field-group">
          <label for="operating-days">Hari operasional per tahun</label>
          <div class="input-suffix">
            <input
              id="operating-days"
              v-model.number="form.operatingDays"
              type="number"
              min="1"
              inputmode="numeric"
              placeholder="Contoh: 300"
              :aria-invalid="Boolean(errors.operatingDays)"
            >
            <span>hari</span>
          </div>
          <small v-if="errors.operatingDays" class="field-error">{{ errors.operatingDays }}</small>
        </div>

        <div class="field-group">
          <label for="ownership-years">Periode kepemilikan</label>
          <select id="ownership-years" v-model.number="form.ownershipYears">
            <option v-for="year in 5" :key="year" :value="year">{{ year }} tahun</option>
          </select>
        </div>
      </fieldset>

      <fieldset v-else-if="step === 2">
        <legend>Spesifikasi unit HINO</legend>
        <p class="step-description">Pilih tipe, model, dan kondisi jalan sesuai penggunaan armada.</p>

        <div class="field-group">
          <label for="truck-series">Tipe unit</label>
          <select id="truck-series" v-model="form.truckSeries" :aria-invalid="Boolean(errors.truckSeries)">
            <option value="">Pilih tipe</option>
            <option value="115">Dutro 115 Series</option>
            <option value="136">Dutro 136 Series</option>
          </select>
          <small v-if="errors.truckSeries" class="field-error">{{ errors.truckSeries }}</small>
        </div>

        <div class="field-group">
          <label for="truck-model">Kategori model</label>
          <select id="truck-model" v-model="form.modelKey" :disabled="!form.truckSeries" :aria-invalid="Boolean(errors.modelKey)">
            <option value="">{{ form.truckSeries ? 'Pilih kategori' : 'Pilih tipe terlebih dahulu' }}</option>
            <option v-for="model in availableModels" :key="model" :value="model">{{ model }}</option>
          </select>
          <small v-if="errors.modelKey" class="field-error">{{ errors.modelKey }}</small>
        </div>

        <div class="field-group">
          <label for="road-condition">Kondisi jalan dominan</label>
          <select id="road-condition" v-model="form.roadCondition" :disabled="!form.modelKey">
            <option v-for="condition in roadConditions" :key="condition.value" :value="condition.value">
              {{ condition.label }}
            </option>
          </select>
        </div>

        <div v-if="fuelEfficiency" class="model-summary">
          <i class="fa-solid fa-gas-pump" aria-hidden="true"></i>
          <div>
            <strong>{{ form.modelKey }}</strong>
            <span>Konsumsi BBM acuan {{ fuelEfficiency }} km/liter</span>
          </div>
        </div>
      </fieldset>

      <fieldset v-else>
        <legend>Data finansial dan kontak</legend>
        <p class="step-description">Lengkapi komponen biaya dan kontak yang akan dicantumkan dalam laporan.</p>

        <div class="cost-grid">
          <div class="field-group">
            <label for="unit-price">Harga unit + pajak</label>
            <div class="input-prefix">
              <span>Rp</span>
              <input id="unit-price" v-model.number="form.unitPrice" type="number" min="1" inputmode="numeric" placeholder="450000000" :aria-invalid="Boolean(errors.unitPrice)">
            </div>
            <small v-if="errors.unitPrice" class="field-error">{{ errors.unitPrice }}</small>
          </div>

          <div class="field-group">
            <label for="body-price">Harga karoseri</label>
            <div class="input-prefix">
              <span>Rp</span>
              <input id="body-price" v-model.number="form.bodyPrice" type="number" min="0" inputmode="numeric" placeholder="90000000">
            </div>
          </div>

          <div class="field-group">
            <label for="interest-rate">Bunga flat</label>
            <div class="input-suffix">
              <input id="interest-rate" v-model.number="form.interestRate" type="number" min="0" step="0.01" inputmode="decimal" placeholder="7.5">
              <span>%</span>
            </div>
          </div>

          <div class="field-group">
            <label for="financing-years">Durasi kredit/bunga</label>
            <select id="financing-years" v-model.number="form.financingYears">
              <option v-for="year in financingOptions" :key="year" :value="year">
                {{ year === 0 ? 'Cash (0 tahun)' : `${year} tahun` }}
              </option>
            </select>
          </div>

          <div class="field-group">
            <label for="diesel-price">Harga solar</label>
            <div class="input-prefix">
              <span>Rp</span>
              <input id="diesel-price" v-model.number="form.dieselPrice" type="number" min="1" inputmode="numeric" :aria-invalid="Boolean(errors.dieselPrice)">
            </div>
            <small v-if="errors.dieselPrice" class="field-error">{{ errors.dieselPrice }}</small>
          </div>

          <div class="field-group">
            <label for="tire-price">Harga satu set ban</label>
            <div class="input-prefix">
              <span>Rp</span>
              <input id="tire-price" v-model.number="form.tireSetPrice" type="number" min="1" inputmode="numeric" placeholder="14000000" :aria-invalid="Boolean(errors.tireSetPrice)">
            </div>
            <small v-if="errors.tireSetPrice" class="field-error">{{ errors.tireSetPrice }}</small>
          </div>

          <div class="field-group">
            <label for="tire-life">Umur ban</label>
            <div class="input-suffix">
              <input id="tire-life" v-model.number="form.tireLifeKm" type="number" min="1" inputmode="numeric" placeholder="40000" :aria-invalid="Boolean(errors.tireLifeKm)">
              <span>km</span>
            </div>
            <small v-if="errors.tireLifeKm" class="field-error">{{ errors.tireLifeKm }}</small>
          </div>
        </div>

        <div class="tco-contact-grid">
          <div class="field-group">
            <label for="customer-name">Nama <em>wajib</em></label>
            <input id="customer-name" v-model.trim="form.name" type="text" maxlength="255" autocomplete="name" placeholder="Masukkan nama" :aria-invalid="Boolean(errors.name)">
            <small v-if="errors.name" class="field-error">{{ errors.name }}</small>
          </div>

          <div class="field-group">
            <label for="whatsapp-number">Nomor WhatsApp <em>wajib</em></label>
            <input id="whatsapp-number" v-model.trim="form.whatsapp" type="tel" maxlength="30" inputmode="tel" autocomplete="tel" placeholder="0812xxxxxx" :aria-invalid="Boolean(errors.whatsapp)">
            <small v-if="errors.whatsapp" class="field-error">{{ errors.whatsapp }}</small>
          </div>
        </div>
      </fieldset>

      <div class="form-actions">
        <button v-if="step > 1" class="button-secondary" type="button" @click="previousStep">
          <i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Kembali
        </button>
        <button class="button-submit" type="submit">
          {{ step === 3 ? 'Hitung TCO Final' : 'Selanjutnya' }}
          <i class="fa-solid" :class="step === 3 ? 'fa-calculator' : 'fa-arrow-right'" aria-hidden="true"></i>
        </button>
      </div>
    </form>

    <div v-else class="result-panel" aria-live="polite">
      <div class="result-success-icon">
        <i class="fa-solid fa-check" aria-hidden="true"></i>
      </div>
      <h3>Terima kasih!</h3>
      <p class="result-greeting">Kalkulasi berhasil, <strong>{{ form.name }}</strong>.</p>
      <p class="result-follow-up">Sales kami akan menghubungi Anda.</p>

      <div class="result-heading">
        <small>Estimasi biaya kepemilikan per km</small>
        <strong>{{ formatCurrency(result.costPerKm) }}</strong>
      </div>

      <div class="email-status" :class="`is-${emailStatus.state}`" role="status">
        <i :class="emailStatusIcon" aria-hidden="true"></i>
        <span>{{ emailStatus.message }}</span>
      </div>

      <p class="result-note">
        Angka di atas adalah ringkasan umum. Rincian depresiasi, beban bunga, biaya bahan bakar,
        ban, dan servis tahunan dibuat sebagai laporan PDF untuk tim sales.
      </p>

      <div class="result-actions">
        <button class="button-secondary" type="button" @click="resetCalculation">
          Hitung simulasi baru
        </button>
        <button v-if="emailStatus.state === 'error'" class="button-submit" type="button" @click="sendReport">
          <i class="fa-solid fa-rotate-right" aria-hidden="true"></i> Kirim ulang laporan
        </button>
      </div>
    </div>

    <footer class="calculator-footer">
      <i class="fa-solid fa-file-shield" aria-hidden="true"></i>
      Data digunakan untuk membuat laporan PDF dan tidak disimpan dalam database.
    </footer>
  </section>
</template>

<script>
const fuelConsumptionData = Object.freeze({
  115: {
    'Dutro 115 HD STD': { 1: 4.09, 2: 6.99, 3: 5.95, 4: 5.53 },
    'Dutro 115 LD STD': { 1: 5.03, 2: 5.09, 3: 6.15, 4: 5.77 },
    'Dutro 115 SD STD': { 1: 6.05, 2: 12.74, 3: 9.56, 4: 8.11 },
    'Dutro 115 SDL STD': { 1: 4.74, 2: 8.40, 3: 6.83, 4: 5.71 },
    'Dutro 115 SDR STD': { 1: 6.34, 2: 10.25, 3: 9.10, 4: 7.96 },
  },
  136: {
    'Dutro 136 HD 64': { 1: 3.55, 2: 9.27, 3: 6.40, 4: 4.36 },
    'Dutro 136 HDL 64': { 1: 8.81, 2: 10.77, 3: 3.67, 4: 7.44 },
    'Dutro 136 HDX': { 1: 4.55, 2: 7.01, 3: 7.12, 4: 6.15 },
    'Dutro 136 HDX PTO': { 1: 4.55, 2: 7.01, 3: 7.12, 4: 6.15 },
    'Dutro 136 MDL': { 1: 5.01, 2: 8.91, 3: 8.10, 4: 7.27 },
  },
})

const roadConditions = Object.freeze([
  { value: '1', label: 'Liku-liku / Perbukitan' },
  { value: '2', label: 'Dalam Kota / Dataran Rendah' },
  { value: '3', label: 'Pegunungan / Medan Terjal' },
  { value: '4', label: 'All Around (Kombinasi)' },
])

const firstYearServiceCost = 7271111

function initialForm() {
  return {
    dailyKm: '',
    operatingDays: '',
    ownershipYears: 5,
    truckSeries: '',
    modelKey: '',
    roadCondition: '4',
    unitPrice: '',
    bodyPrice: '',
    interestRate: '',
    financingYears: 0,
    dieselPrice: 6800,
    tireSetPrice: '',
    tireLifeKm: '',
    name: '',
    whatsapp: '',
  }
}

export default {
  props: {
    submitUrl: {
      type: String,
      default: '/tco/submit',
    },
    salesSlug: {
      type: String,
      default: '',
    },
    salesName: {
      type: String,
      default: '',
    },
  },

  data() {
    return {
      step: 1,
      stepLabels: ['Operasional', 'Unit', 'Biaya & kontak'],
      roadConditions,
      errors: {},
      result: null,
      emailStatus: {
        state: 'idle',
        message: '',
      },
      form: initialForm(),
    }
  },

  computed: {
    availableModels() {
      return Object.keys(fuelConsumptionData[this.form.truckSeries] ?? {})
    },

    financingOptions() {
      return Array.from({ length: Number(this.form.ownershipYears) + 1 }, (_, index) => index)
    },

    fuelEfficiency() {
      return fuelConsumptionData[this.form.truckSeries]?.[this.form.modelKey]?.[this.form.roadCondition] ?? null
    },

    selectedRoadLabel() {
      return roadConditions.find((condition) => condition.value === this.form.roadCondition)?.label ?? '-'
    },

    emailStatusIcon() {
      if (this.emailStatus.state === 'sending') return 'fa-solid fa-spinner fa-spin'
      if (this.emailStatus.state === 'success') return 'fa-solid fa-circle-check'
      return 'fa-solid fa-circle-exclamation'
    },
  },

  watch: {
    'form.truckSeries'() {
      this.form.modelKey = ''
      this.form.roadCondition = '4'
    },

    'form.modelKey'(modelKey) {
      if (modelKey) this.form.roadCondition = '4'
    },

    'form.ownershipYears'(years) {
      if (this.form.financingYears > years) this.form.financingYears = 0
    },
  },

  methods: {
    nextStep() {
      if (!this.validateStep()) return

      if (this.step < 3) {
        this.step += 1
        return
      }

      this.result = this.calculate()
      this.sendReport()
    },

    previousStep() {
      this.errors = {}
      this.step -= 1
    },

    validateStep() {
      const errors = {}

      if (this.step === 1) {
        if (!this.isPositive(this.form.dailyKm)) errors.dailyKm = 'AVG KM harian wajib diisi.'
        if (!this.isPositive(this.form.operatingDays)) errors.operatingDays = 'Hari operasional wajib diisi.'
      }

      if (this.step === 2) {
        if (!this.form.truckSeries) errors.truckSeries = 'Pilih tipe unit HINO.'
        if (!this.form.modelKey) errors.modelKey = 'Pilih kategori model HINO.'
      }

      if (this.step === 3) {
        if (!this.isPositive(this.form.unitPrice)) errors.unitPrice = 'Harga unit wajib diisi.'
        if (!this.isPositive(this.form.dieselPrice)) errors.dieselPrice = 'Harga solar wajib diisi.'
        if (!this.isPositive(this.form.tireSetPrice)) errors.tireSetPrice = 'Harga satu set ban wajib diisi.'
        if (!this.isPositive(this.form.tireLifeKm)) errors.tireLifeKm = 'Umur ban wajib diisi.'
        if (!this.form.name) errors.name = 'Nama wajib diisi.'
        if (!this.form.whatsapp) errors.whatsapp = 'Nomor WhatsApp wajib diisi.'
      }

      this.errors = errors
      return Object.keys(errors).length === 0
    },

    calculate() {
      const period = Number(this.form.ownershipYears)
      const totalKm = Number(this.form.dailyKm) * Number(this.form.operatingDays) * period
      const basePrice = Number(this.form.unitPrice) + (Number(this.form.bodyPrice) || 0)
      const totalInterest = basePrice * ((Number(this.form.interestRate) || 0) / 100) * Number(this.form.financingYears)
      const acquisitionCost = basePrice + totalInterest
      const totalLiters = Math.ceil(totalKm / this.fuelEfficiency)
      const fuelCost = totalLiters * Number(this.form.dieselPrice)
      const tireChanges = Math.round((totalKm / Number(this.form.tireLifeKm)) * 100) / 100
      const tireCost = tireChanges * Number(this.form.tireSetPrice)

      let serviceCost = 0
      let currentServiceCost = firstYearServiceCost

      for (let year = 1; year <= period; year += 1) {
        if (year > 1) currentServiceCost = Math.round(currentServiceCost * 1.15)
        serviceCost += currentServiceCost
      }

      let resaleValue = basePrice

      for (let year = 1; year <= period; year += 1) {
        resaleValue *= 1 - (year === 1 ? 0.15 : 0.10)
      }

      const totalTco = acquisitionCost + fuelCost + tireCost + serviceCost - resaleValue

      return {
        totalKm,
        totalTco,
        costPerKm: totalKm > 0 ? Math.floor(totalTco / totalKm) : 0,
      }
    },

    async sendReport() {
      this.emailStatus = {
        state: 'sending',
        message: 'Mengirim laporan detail ke email tim sales...',
      }

      try {
        const response = await fetch(this.submitUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
            Accept: 'application/json',
          },
          body: JSON.stringify(this.reportPayload()),
        })

        const data = await response.json().catch(() => ({}))

        if (!response.ok || !data.success) {
          throw new Error(data.message || 'Laporan gagal dikirim.')
        }

        this.emailStatus = {
          state: 'success',
          message: 'Laporan TCO berhasil dikirim ke email tim sales.',
        }
      } catch (error) {
        this.emailStatus = {
          state: 'error',
          message: error.message || 'Laporan gagal dikirim. Silakan coba lagi.',
        }
      }
    },

    reportPayload() {
      return {
        nama: this.form.name,
        no_wa: this.form.whatsapp,
        avg_km_harian: Number(this.form.dailyKm),
        hari_operasi: Number(this.form.operatingDays),
        periode_tco: Number(this.form.ownershipYears),
        konsumsi_bbm: this.fuelEfficiency,
        harga_unit: Number(this.form.unitPrice),
        harga_karoseri: Number(this.form.bodyPrice) || 0,
        bunga_flat: Number(this.form.interestRate) || 0,
        durasi_bunga: Number(this.form.financingYears),
        harga_solar: Number(this.form.dieselPrice),
        harga_ban: Number(this.form.tireSetPrice),
        umur_ban: Number(this.form.tireLifeKm),
        tipe_unit: this.form.truckSeries,
        kategori_model: this.form.modelKey,
        kondisi_jalan: this.selectedRoadLabel,
        sales_slug: this.salesSlug || null,
      }
    },

    resetCalculation() {
      this.step = 1
      this.errors = {}
      this.result = null
      this.emailStatus = { state: 'idle', message: '' }
      this.form = initialForm()
    },

    isPositive(value) {
      return Number.isFinite(Number(value)) && Number(value) > 0
    },

    formatCurrency(value) {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
      }).format(value)
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

.calculator-header .calculator-sales-source {
  margin-top: 5px;
  color: #087443;
  font-weight: 700;
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

.field-group label em {
  color: #a52720;
  font-size: 11px;
  font-style: normal;
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

select:disabled {
  cursor: not-allowed;
  color: #89938d;
  background: #f1f4f2;
}

input:focus,
select:focus {
  border-color: #058c4b;
  box-shadow: 0 0 0 3px rgba(5, 140, 75, 0.14);
}

input[aria-invalid='true'],
select[aria-invalid='true'] {
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

.field-error {
  display: block;
  margin-top: 6px;
  color: #9f211b;
  font-size: 11px;
}

.model-summary {
  display: flex;
  align-items: center;
  gap: 15px;
  margin: -2px 0 6px;
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

.cost-grid,
.tco-contact-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 0 15px;
}

.tco-contact-grid {
  margin-top: 5px;
  padding-top: 20px;
  border-top: 1px dashed #cdd7d1;
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

.result-panel {
  padding-top: 30px;
  text-align: center;
}

.result-success-icon {
  display: grid;
  width: 68px;
  height: 68px;
  margin: 0 auto 15px;
  place-items: center;
  border-radius: 50%;
  color: #fff;
  background: #078647;
  box-shadow: 0 8px 20px rgba(7, 134, 71, 0.24);
}

.result-success-icon i {
  font-size: 28px;
}

.result-panel h3 {
  margin: 0;
  color: #113e29;
  font-size: 24px;
}

.result-greeting,
.result-follow-up {
  margin: 7px 0 0;
}

.result-greeting {
  color: #29332d;
  font-size: 15px;
}

.result-follow-up {
  color: #078647;
  font-size: 13px;
  font-weight: 700;
}

.result-heading {
  margin-top: 22px;
  padding: 22px 18px;
  border-radius: 16px;
  color: #fff;
  background: #075e37;
}

.result-heading small,
.result-heading strong {
  display: block;
}

.result-heading small {
  margin-bottom: 6px;
  font-size: 12px;
  font-weight: 650;
  text-transform: uppercase;
}

.result-heading strong {
  font-size: clamp(26px, 4vw, 36px);
}

.email-status {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  margin-top: 15px;
  padding: 12px 14px;
  border: 1px solid;
  border-radius: 11px;
  font-size: 12px;
  line-height: 1.45;
  text-align: left;
}

.email-status.is-sending {
  border-color: #7dd3fc;
  color: #075985;
  background: #e0f2fe;
}

.email-status.is-success {
  border-color: #6ee7b7;
  color: #065f46;
  background: #d1fae5;
}

.email-status.is-error {
  border-color: #fca5a5;
  color: #991b1b;
  background: #fee2e2;
}

.result-note {
  margin: 15px 0 0;
  padding: 13px;
  border: 1px solid #f0d98a;
  border-radius: 11px;
  color: #765c08;
  background: #fff8dc;
  font-size: 11px;
  line-height: 1.55;
  text-align: left;
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
  .tco-contact-grid {
    grid-template-columns: 1fr;
  }

  .form-actions,
  .result-actions {
    flex-direction: column-reverse;
  }
}
</style>
