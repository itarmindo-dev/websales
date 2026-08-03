<template>
  <div class="bg-[#e9f5ee] border border-[#c1e2d0] rounded-2xl p-6 shadow-xl relative overflow-hidden" style="max-width: 400px;">
    <!-- Dekorasi garis latar -->
    <div class="absolute -right-10 -bottom-10 opacity-30 pointer-events-none">
      <svg width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 200C110.457 200 200 110.457 200 0" stroke="#007F3D" stroke-width="2" stroke-dasharray="4 4"/>
        <path d="M50 200C132.843 200 200 132.843 200 50" stroke="#007F3D" stroke-width="1"/>
      </svg>
    </div>

    <div class="flex items-center gap-3 border-b border-[#c1e2d0] pb-4 mb-5">
      <div class="text-[#ce1126] font-black text-2xl">HINO</div>
      <div class="h-6 w-px bg-gray-400"></div>
      <div class="text-gray-700 font-semibold text-lg">Kalkulator TCO</div>
    </div>

    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">AVG KM Harian:</label>
        <input type="number" v-model="kmHarian" placeholder="Contoh: 100" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 bg-white border">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Hari Operasional / Tahun:</label>
        <input type="number" v-model="hariOperasional" placeholder="Contoh: 300" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 bg-white border">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Periode Kepemilikan (Tahun):</label>
        <select v-model="periodeTahun" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 px-3 py-2 bg-white border">
          <option value="1">1 Tahun</option>
          <option value="2">2 Tahun</option>
          <option value="3">3 Tahun</option>
          <option value="4">4 Tahun</option>
          <option value="5">5 Tahun</option>
        </select>
      </div>

      <div class="pt-2">
        <button @click="hitung" class="w-full bg-gradient-to-r from-[#006429] to-[#009b44] hover:from-[#004e20] hover:to-[#007f3d] text-white font-bold py-3 px-4 rounded-full shadow-lg transition-transform transform hover:scale-105 active:scale-95 flex justify-center items-center gap-2">
          HITUNG ESTIMASI BIAYA
        </button>
      </div>

      <!-- Hasil -->
      <div v-if="hasil > 0" class="mt-6 bg-white p-4 rounded-lg border border-green-200 text-center animate-fade-in">
        <p class="text-sm text-gray-600 mb-1">Estimasi Total Biaya (TCO):</p>
        <p class="text-2xl font-bold text-green-700">Rp {{ formatRupiah(hasil) }}</p>
        <p class="text-xs text-gray-500 mt-2">*Hanya estimasi, dapat berbeda tergantung kondisi riil.</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      kmHarian: null,
      hariOperasional: null,
      periodeTahun: 1,
      hasil: 0
    }
  },
  methods: {
    hitung() {
      // Dummy logic for TCO calculation (Total Cost of Ownership)
      if (this.kmHarian && this.hariOperasional) {
        const costPerKm = 2500; // Contoh asumsi biaya operasional per km
        const totalKm = this.kmHarian * this.hariOperasional * this.periodeTahun;
        this.hasil = totalKm * costPerKm;
      }
    },
    formatRupiah(number) {
      return new Intl.NumberFormat('id-ID').format(number);
    }
  }
}
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.5s ease-in-out;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
